<?php
echo "Available password algorithms: ";
print_r(password_algos());

if (defined('PASSWORD_BCRYPT')) {
    echo "\nBcrypt is supported!";
}
?>

<?php
    phpinfo();
?>
