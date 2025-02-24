<?php
namespace API\V1\Models;

use API\Core\Database;

class ProfileModel {
    private \mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserProfileData(string $uuid): ?array {
        $result = [];

        // Main profile query with joins
        $mainQuery = "
            SELECT 
                up.first_name, 
                up.middle_name, 
                up.last_name, 
                up.role_id, 
                up.gender, 
                up.profile_description, 
                up.tags, 
                up.card_id, 
                up.school_association,
                profile_assets.compressed_cdn_path AS profile_image_path,
                profile_assets.thumbnail_cdn_path AS profile_thumbnail_path,
                profile_assets.status AS profile_image_status,
                cover_assets.compressed_cdn_path AS cover_image_path,
                cover_assets.status AS cover_image_status,
                pos.position,
                pos.positionAbbreviation AS position_abbreviation,
                sp.sport_name,
                sp.abbreviation AS sport_abbreviation,
                sp.icon AS sport_icon,
                sch.nanoid AS school_nanoid,
                sch.name AS school_name,
                sch.mascot AS school_mascot,
                sch.cover_photo_url_1 AS school_cover_image_path,
                sch.marketplace_logo AS school_marketplace_logo_path
            FROM user_profiles AS up
            LEFT JOIN assets AS profile_assets ON up.profile_image_id = profile_assets.id
            LEFT JOIN assets AS cover_assets ON up.cover_image_id = cover_assets.id
            LEFT JOIN positions AS pos ON up.position_id = pos.id
            LEFT JOIN sports AS sp ON up.sport_id = sp.id
            LEFT JOIN schools AS sch ON up.school_id = sch.id
            WHERE up.uuid = ?
        ";

        if ($stmt = $this->db->prepare($mainQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $mainResult = $stmt->get_result();
            
            if ($mainResult->num_rows > 0) {
                $result = $mainResult->fetch_assoc();
            }
            $stmt->close();
        }

        if (empty($result)) {
            return null;
        }

        // User Flags
        $flagsQuery = "SELECT verified, imported, dynamic_pricing, deactivated, banned FROM user_flags WHERE uuid = ?";
        if ($stmt = $this->db->prepare($flagsQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $flagsResult = $stmt->get_result();
            if ($flagsResult->num_rows > 0) {
                $result["flags"] = $flagsResult->fetch_assoc();
            }
            $stmt->close();
        }

        // Social Media Accounts
        $socialQuery = "SELECT instagram_username, x_username, tiktok_username, facebook_username, linkedin_username, youtube_username FROM user_social_media WHERE uuid = ?";
        if ($stmt = $this->db->prepare($socialQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $socialResult = $stmt->get_result();
            $socialMedia = $socialResult->fetch_assoc();
            $result["social_media"] = $socialMedia ?: [];
            $stmt->close();
        }

        // Social Media Stats
        $socialMedia = $result["social_media"] ?? [];

        // Instagram Stats
        if (!empty($socialMedia["instagram_username"])) {
            $instagramQuery = "SELECT follower_count AS instagram_follower_count, 
                                    following_count AS instagram_following_count, 
                                    media_count AS instagram_media_count 
                            FROM social_media_stats_instagram 
                            WHERE uuid = ? 
                            ORDER BY id DESC 
                            LIMIT 1";
            
            if ($stmt = $this->db->prepare($instagramQuery)) {
                $stmt->bind_param("s", $uuid);
                $stmt->execute();
                $instagramStats = $stmt->get_result()->fetch_assoc();
                $result["instagram_stats"] = $instagramStats ?: [];
                $stmt->close();
            }
        }

        // TikTok Stats
        if (!empty($socialMedia["tiktok_username"])) {
            $tiktokQuery = "SELECT follower_count AS tiktok_follower_count, 
                                following_count AS tiktok_following_count, 
                                verified AS tiktok_verified, 
                                signature AS tiktok_signature, 
                                heart AS tiktok_heart_count, 
                                video_count AS tiktok_video_count, 
                                friend_count AS tiktok_friend_count 
                            FROM social_media_stats_tiktok 
                            WHERE uuid = ? 
                            ORDER BY id DESC 
                            LIMIT 1";
            
            if ($stmt = $this->db->prepare($tiktokQuery)) {
                $stmt->bind_param("s", $uuid);
                $stmt->execute();
                $tiktokStats = $stmt->get_result()->fetch_assoc();
                $result["tiktok_stats"] = $tiktokStats ?: [];
                $stmt->close();
            }
        }

        // X (Twitter) Stats
        if (!empty($socialMedia["x_username"])) {
            $xQuery = "SELECT follower_count AS x_follower_count, 
                            following_count AS x_following_count, 
                            favourites_count AS x_favourites_count, 
                            verified AS x_verified, 
                            signature AS x_signature 
                    FROM social_media_stats_x 
                    WHERE uuid = ? 
                    ORDER BY id DESC 
                    LIMIT 1";
            
            if ($stmt = $this->db->prepare($xQuery)) {
                $stmt->bind_param("s", $uuid);
                $stmt->execute();
                $xStats = $stmt->get_result()->fetch_assoc();
                $result["x_stats"] = $xStats ?: [];
                $stmt->close();
            }
        }

        // Service Information
        $serviceQuery = "
            SELECT 
                p.set_price AS service_price,
                p.pricing AS service_dynamic_price,
                p.make_offer AS service_make_offer,
                p.custom_description AS service_custom_description,
                p.expedite_enabled AS service_expedite_enabled,
                s.category AS service_category,
                s.name AS service_name,
                s.description AS service_description,
                s.image_large AS service_image_large,
                s.image_thumbnail AS service_image_thumbnail,
                s.tags AS service_tags
            FROM pricing p
            JOIN services s ON p.service_id = s.id
            WHERE p.uuid = ? AND p.active = 'yes'
        ";
        
        if ($stmt = $this->db->prepare($serviceQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $serviceResult = $stmt->get_result();
            $result['services'] = [];
            while ($serviceData = $serviceResult->fetch_assoc()) {
                $result['services'][] = [
                    'service_price' => $serviceData['service_price'],
                    'service_dynamic_price' => $serviceData['service_dynamic_price'],
                    'service_make_offer' => (bool)$serviceData['service_make_offer'],
                    'service_custom_description' => $serviceData['service_custom_description'],
                    'service_expedite_enabled' => (bool)$serviceData['service_expedite_enabled'],
                    'service_category' => $serviceData['service_category'],
                    'service_name' => $serviceData['service_name'],
                    'service_description' => $serviceData['service_description'],
                    'service_image_large' => $serviceData['service_image_large'],
                    'service_image_thumbnail' => $serviceData['service_image_thumbnail'],
                    'service_tags' => $serviceData['service_tags']
                ];
            }
            $stmt->close();
        }

        return $result;
    }
}
