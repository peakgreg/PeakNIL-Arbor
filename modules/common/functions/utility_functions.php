<?php
/******************************************************************************/
/**
 * Builds a query string from an array of GET parameters.
 *
 * @param array $getParams The current GET parameters to be included in the query string
 *
 * @return string
 *   - Returns a properly formatted query string starting with `?` if there are any parameters.
 *   - Returns an empty string if there are no parameters.
 */
function buildQuery($getParams) {
    $queryString = http_build_query($getParams);
    $parsed = parse_str($queryString, $result);

    return !empty($result) ? '?' . http_build_query($result) : '';
}

// Get current GET parameters
$getParameters = $_GET;

/* <?php echo buildQuery($getParameters); ?> */

/******************************************************************************/
?>