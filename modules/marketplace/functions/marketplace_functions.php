<?php
/**
  * Get athlete cards
 */
function getAthleteCards($conn, $params = []) {

    // Initialize conditions array to store WHERE clauses
    $conditions = ["u.role_id = 2"];

    $pricing_join = "";
    if (isset($params['type']) && !empty($params['type'])) {
        $service_id = (int)$params['type'];
        $pricing_join = "INNER JOIN pricing p 
                          ON u.id = p.user_id 
                          AND p.service_id = {$service_id} 
                          AND p.active = 'yes'";
    }

    // Handle collection filter
    if (isset($params['collection']) && !empty($params['collection'])) {
        $collection_table = mysqli_real_escape_string($conn, $params['collection']);
        $conditions[] = "u.id IN (SELECT athlete_id FROM {$collection_table})";
    }
    
    // Handle sport filter
    if (isset($params['sport']) && !empty($params['sport'])) {
        $sport_id = (int)$params['sport'];
        $conditions[] = "u.sport_id = $sport_id";
    }
    
    // Handle school filter
    if (isset($params['school']) && !empty($params['school'])) {
        $school_id = (int)$params['school'];
        $conditions[] = "u.school_id = $school_id";
    }

    // Combine all conditions
    $where_clause = implode(' AND ', $conditions);

    // Handle ordering
    $order_clause = "ORDER BY u.id DESC"; // Default to newest ID
    if (isset($params['order']) && $params['order'] === 'random') {
        $order_clause = "ORDER BY RAND()";
    }
    
    // Handle limit
    $limit = isset($params['limit']) && is_numeric($params['limit']) ? (int)$params['limit'] : 50;
    $limit_clause = "LIMIT " . $limit;
    
    $sql = "
        SELECT 
            u.*, 
            s.nanoid AS school_nanoid,
            s.name AS school_name,
            s.mascot AS school_mascot,
            s.logo_set AS logo_set,
            a.compressed_cdn_path AS profile_image_url,
            usm.instagram_username,
            usm.x_username,
            usm.tiktok_username,
            usm.facebook_username,
            usm.linkedin_username,
            (SELECT follower_count FROM social_media_stats_instagram WHERE uuid = u.uuid LIMIT 1) AS instagram_follower_count,
            (SELECT follower_count FROM social_media_stats_x WHERE uuid = u.uuid LIMIT 1) AS x_follower_count,
            (SELECT follower_count FROM social_media_stats_tiktok WHERE uuid = u.uuid LIMIT 1) AS tiktok_follower_count
        FROM 
            user_profiles u
        LEFT JOIN 
            schools s ON u.school_id = s.id
        LEFT JOIN 
            assets a ON u.profile_image_id = a.id
        LEFT JOIN 
            user_social_media usm ON u.uuid = usm.uuid
        {$pricing_join}
        WHERE 
            {$where_clause}
        {$order_clause}
        {$limit_clause}
    ";

    $result = mysqli_query($conn, $sql);
    
    // Debug output to terminal
    if (php_sapi_name() === 'cli') {
        echo "\n=== SQL Query ===\n";
        echo $sql . "\n\n";
        
        if (!$result) {
            echo "=== MySQL Error ===\n";
            echo mysqli_error($conn) . "\n";
        } else {
            echo "=== Query Results ===\n";
            $row_count = mysqli_num_rows($result);
            echo "Rows returned: " . $row_count . "\n";
            
            if ($row_count > 0) {
                $first_row = mysqli_fetch_assoc($result);
                echo "First row sample:\n";
                print_r($first_row);
                // Reset pointer back to start
                mysqli_data_seek($result, 0);
            }
        }
        echo "\n";
    }

    $cards = [];

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            // Check the value of logo_set
            if ($row['logo_set'] === '1') {
                // If logo_set is '1', construct the URL using school_nanoid
                $row['school_thumbnail_path'] = "https://cdn.peaknil.com/public/logos/schools/thumbnail/{$row['school_nanoid']}.png";
            } else {
                // If logo_set is '0', use the default URL
                $row['school_thumbnail_path'] = "https://cdn.peaknil.com/public/logos/schools/thumbnail/default.png";
            }

            // Initialize social media flags and follower counts
            $row['instagram_set'] = !empty($row['instagram_username']) ? 'true' : 'false';
            $row['x_set'] = !empty($row['x_username']) ? 'true' : 'false';
            $row['tiktok_set'] = !empty($row['tiktok_username']) ? 'true' : 'false';
            $row['facebook_set'] = !empty($row['facebook_username']) ? 'true' : 'false';
            $row['linkedin_set'] = !empty($row['linkedin_username']) ? 'true' : 'false';

            // Add the row to the cards array
            $cards[] = $row;
        }
    }

    return $cards;
}
?>