<?php
function getUserProfileData($conn) {
    $result = [];

    // Validate UUID format (version 1-4 compliant)
    if (!isset($_GET['id']) || !preg_match('/^[a-f0-9]{8}-[a-f0-9]{4}-[1-5][a-f0-9]{3}-[89ab][a-f0-9]{3}-[a-f0-9]{12}$/i', $_GET['id'])) {
        return ['error' => 'Invalid UUID format'];
    }
    $uuid = $_GET['id'];

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
            sch.logo_path AS school_logo_path,
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

    if ($stmt = $conn->prepare($mainQuery)) {
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $mainResult = $stmt->get_result();
        
        if ($mainResult->num_rows > 0) {
            $result = $mainResult->fetch_assoc();
        }
        $stmt->close();
    }

    // User Flags
    $flagsQuery = "SELECT verified, imported, dynamic_pricing, deactivated, banned FROM user_flags WHERE uuid = ?";
    if ($stmt = $conn->prepare($flagsQuery)) {
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $flagsResult = $stmt->get_result();
        if ($flagsResult->num_rows > 0) {
            $result['flags'] = $flagsResult->fetch_assoc();
        }
        $stmt->close();
    }

    // Social Media Accounts
    $socialQuery = "SELECT instagram_username, x_username, tiktok_username, facebook_username, linkedin_username, youtube_username FROM user_social_media WHERE uuid = ?";
    if ($stmt = $conn->prepare($socialQuery)) {
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $socialResult = $stmt->get_result();
        $socialMedia = $socialResult->fetch_assoc();
        $result['social_media'] = $socialMedia ?: [];
        $stmt->close();
    }

    // Social Media Stats
    $socialMedia = $result['social_media'] ?? [];

    // Instagram Stats
    if (!empty($socialMedia['instagram_username'])) {
        $instagramQuery = "SELECT follower_count AS instagram_follower_count, 
                                  following_count AS instagram_following_count, 
                                  media_count AS instagram_media_count 
                          FROM social_media_stats_instagram 
                          WHERE uuid = ? 
                          ORDER BY id DESC 
                          LIMIT 1";
        
        if ($stmt = $conn->prepare($instagramQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $instagramStats = $stmt->get_result()->fetch_assoc();
            $result['instagram_stats'] = $instagramStats ?: [];
            $stmt->close();
        }
    }

    // TikTok Stats
    if (!empty($socialMedia['tiktok_username'])) {
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
        
        if ($stmt = $conn->prepare($tiktokQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $tiktokStats = $stmt->get_result()->fetch_assoc();
            $result['tiktok_stats'] = $tiktokStats ?: [];
            $stmt->close();
        }
    }

    // X (Twitter) Stats
    if (!empty($socialMedia['x_username'])) {
        $xQuery = "SELECT follower_count AS x_follower_count, 
                          following_count AS x_following_count, 
                          favourites_count AS x_favourites_count, 
                          verified AS x_verified, 
                          signature AS x_signature 
                  FROM social_media_stats_x 
                  WHERE uuid = ? 
                  ORDER BY id DESC 
                  LIMIT 1";
        
        if ($stmt = $conn->prepare($xQuery)) {
            $stmt->bind_param("s", $uuid);
            $stmt->execute();
            $xStats = $stmt->get_result()->fetch_assoc();
            $result['x_stats'] = $xStats ?: [];
            $stmt->close();
        }
    }

    return $result;
}
?>