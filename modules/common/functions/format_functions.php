<?php
function formatPrice($number) {
    // Divide the number by 100 to get the desired value
    $formattedNumber = $number / 100;
    
    // Format the number to two decimal places
    return number_format($formattedNumber, 2, '.', '');
}

function removeLastTwoDigits($number) {
    // Divide the number by 100 and cast it to an integer to remove the last two digits
    return intval($number / 100);
}
?>