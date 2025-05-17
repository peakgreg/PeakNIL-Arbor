<?php
/**
 * Functions for handling user settings
 */

/**
 * Get all interests from the interests table
 *
 * @return array List of interests with id and interest_name
 */
function get_all_interests() {
    global $db; // Assuming $db is your mysqli connection

    $interests = [];

    // Check if $db is a valid mysqli connection
    if ($db instanceof mysqli) {
        $query = "SELECT id, interest_name FROM interests ORDER BY interest_name ASC";
        $result = $db->query($query);

        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $interests[] = $row;
            }
            $result->free();
        } else {
            error_log("Error fetching interests: " . $db->error);
        }
    } else {
        error_log("Database connection is not a valid mysqli instance.");
    }

    return $interests;
}

/**
 * Get user settings data by UUID
 *
 * This function fetches comprehensive user settings data by joining multiple tables
 * based on the user's UUID.
 *
 * @param string $uuid The UUID of the user.
 * @return array|false An associative array containing the user's settings data on success,
 *                     or false if the user is not found or an error occurs.
 */
function get_user_settings_data($uuid) {
    global $db; // Assuming $db is your mysqli connection

    $user_data = false;

    // Check if $db is a valid mysqli connection
    if ($db instanceof mysqli) {
        $query = "
            SELECT
              users.username,
              users.email,
              users.email_verified,
              users.status,
              user_social_media.instagram_username,
              user_social_media.x_username,
              user_social_media.tiktok_username,
              user_social_media.facebook_username,
              user_social_media.linkedin_username,
              user_social_media.youtube_username,
              user_profiles.first_name,
              user_profiles.middle_name,
              user_profiles.last_name,
              user_profiles.date_of_birth,
              user_profiles.access_level,
              user_profiles.role_id,
              user_profiles.us_citizen,
              user_profiles.gender,
              user_profiles.phone_number,
              user_profiles.profile_image_id,
              user_profiles.cover_image_id,
              user_profiles.profile_description,
              user_profiles.referral_code,
              user_profiles.additional_data,
              user_profiles.level_id,
              user_profiles.position_id,
              user_profiles.sport_id,
              user_profiles.school_id,
              user_profiles.team_id,
              user_profiles.tags,
              user_profiles.card_id,
              user_profiles.verified,
              user_profiles.school_association,
              user_profiles.team_association,
              user_flags.verified,
              user_flags.dynamic_pricing,
              user_flags.deactivated,
              user_flags.banned,
              user_addresses.address_type,
              user_addresses.street_address,
              user_addresses.city,
              user_addresses.state,
              user_addresses.postal_code,
              user_addresses.country,
              user_addresses.is_primary,
              positions.position,
              positions.positionAbbreviation,
              schools.nanoid,
              schools.name,
              schools.display_name,
              schools.mascot,
              schools.logo_set,
              schools.address,
              schools.state,
              schools.zip,
              schools.compliance_email,
              schools.compliance_phone,
              sports.sport_name,
              sports.abbreviation,
              sports.icon,
              sports.icon_svg,
              levels.level,
              teams.pro_team_city,
              teams.pro_team_mascot
            FROM
              users
            LEFT JOIN user_social_media
              ON users.uuid = user_social_media.uuid
            LEFT JOIN user_profiles
              ON users.uuid = user_profiles.uuid
            LEFT JOIN user_flags
              ON users.uuid = user_flags.uuid
            LEFT JOIN user_addresses
              ON users.uuid = user_addresses.uuid
            LEFT JOIN positions
              ON user_profiles.position_id = positions.id
            LEFT JOIN schools
              ON user_profiles.school_id = schools.id
            LEFT JOIN sports
              ON user_profiles.sport_id = sports.id
            LEFT JOIN levels
              ON user_profiles.level_id = levels.id
            LEFT JOIN teams
              ON user_profiles.pro_team_id = teams.id
            WHERE users.uuid = ?
        ";

        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
        } else {
            error_log("Error fetching user settings data: " . $db->error);
        }

        $stmt->close();
    } else {
        error_log("Database connection is not a valid mysqli instance.");
    }

    return $user_data;
}

// EOF
