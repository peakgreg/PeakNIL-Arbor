<?php
namespace API\V1\Models;

use API\Core\Database;

class SchoolModel {
    private \mysqli $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getSchoolByNanoId(string $nanoId): ?array {
        $result = [];

        // Main school query
        $query = "SELECT * FROM schools WHERE nanoid = ?";
        
        if ($stmt = $this->db->prepare($query)) {
            $stmt->bind_param("s", $nanoId);
            $stmt->execute();
            $mainResult = $stmt->get_result();
            
            if ($mainResult->num_rows > 0) {
                $result = $mainResult->fetch_assoc();
                
                // Process sports
                $sports = [];
                for ($i = 101; $i <= 150; $i++) {
                    if ($result["sport_$i"] ?? false) {
                        $sports[] = $i;
                    }
                }
                $result['sports'] = $sports;

                // Process social media
                $result['social_media'] = [
                    'facebook' => $result['schoolFacebookUsername'] ?? null,
                    'instagram' => $result['schoolInstagramUsername'] ?? null,
                    'twitter' => $result['schoolTwitterUsername'] ?? null,
                    'tiktok' => $result['schoolTikTokUsername'] ?? null,
                    'youtube' => $result['schoolYouTubeUsername'] ?? null
                ];

                // Process colors
                $result['colors'] = [
                    'primary' => $result['color'] ?? null,
                    'alternate' => $result['altColor'] ?? null,
                    'text' => $result['textColor'] ?? null,
                    'card1' => $result['cardColor1'] ?? null,
                    'card2' => $result['cardColor2'] ?? null,
                    'button' => $result['buttonColor'] ?? null,
                    'select' => $result['selectColor'] ?? null
                ];

                // Clean up response by removing individual fields
                unset(
                    $result['schoolFacebookUsername'],
                    $result['schoolInstagramUsername'],
                    $result['schoolTwitterUsername'],
                    $result['schoolTikTokUsername'],
                    $result['schoolYouTubeUsername'],
                    $result['color'],
                    $result['altColor'],
                    $result['textColor'],
                    $result['cardColor1'],
                    $result['cardColor2'],
                    $result['buttonColor'],
                    $result['selectColor']
                );

                // Remove sport fields
                for ($i = 101; $i <= 150; $i++) {
                    unset($result["sport_$i"]);
                }
            }
            $stmt->close();
        }

        return empty($result) ? null : $result;
    }
}
