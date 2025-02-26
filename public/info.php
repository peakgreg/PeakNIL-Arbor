<?php
echo "Available password algorithms: ";
print_r(password_algos());

if (defined('PASSWORD_ARGON2ID')) {
    echo "\nArgon2id is supported!";
}
?>

<?php
    phpinfo();
?>