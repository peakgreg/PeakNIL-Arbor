#!/bin/bash

echo "Welcome to the PeakNIL Module Creation Script"
echo "This script will guide you through creating a new module for your platform."

# Read module name
read -p "Enter the name of the module: " MODULE_NAME

# Read authentication choice
echo -e "\nWould this module be public or private?\n1) Public\n2) Private (requires authentication)\n"
read -p "Choose an option (1 or 2): " -n 1 ANSWER

# Trim leading and trailing whitespace manually
if [ "$ANSWER" = " " ]; then ANSWER=""; fi
if [ "$ANSWER" != "" ]; then
    if [ "$ANSWER" = " " ]; then ANSWER=""; fi
fi

# Check if the user chose public or private
if [ $ANSWER -eq 1 ]; then
    echo "Module will be public."
elif [ $ANSWER -eq 2 ]; then
    echo "Module requires authentication."
else
    echo "Error: Please choose 1 for Public or 2 for Private."
    exit 1
fi

# Ask for pages/views to create
echo -e "\nPlease specify the pages/views you want to create for this module. Enter one or more page names
separated by spaces: "
read -p "Enter page names: "
PAGES=(`echo "$REPLY" | tr ' ' '|'`)
size=${#PAGES[@]}

if [ $size -ge 1 ]; then
    echo "Creating view files for each specified page..."
else
    echo "Error: Please specify at least one page name."
    exit 1
fi

# Create directory structure
echo "Creating directory structure..."
mkdir -p modules/${MODULE_NAME}/views
echo "Module directories have been created."

# Generate PHP files
echo "Creating PHP files for the module."
touch modules/${MODULE_NAME}/${MODULE_NAME}.php
echo "<?php
require_once CONFIG_PATH . '/init.php';
require_once MODULES_PATH . '/${MODULE_NAME}/functions/${MODULE_NAME}_functions.php';

global \$db;

if (\$request->get('page') == 'login' || !isset($_SESSION['user'])) {
    // Authentication logic here
    switch (\$page) {
        case '${PAGES[0]}':
            require_once MODULES_PATH . '/${MODULE_NAME}/views/view.${PAGE}.${MODULE_NAME}.php';
            break;
        case '${MODULE_NAME}':
        default:
            require_once MODULES_PATH . '/${MODULE_NAME}/views/view.${MODULE_NAME}.php';
            break;
    }
}
" > modules/${MODULE_NAME}/${MODULE_NAME}.php

# Generate view files
for PAGE in ${PAGES[@]}; do
    echo "Creating view file for page: $PAGE"
    touch modules/${MODULE_NAME}/views/view.${PAGE}.${MODULE_NAME}.php
done

# Create CSS and JS files (placeholders)
echo "Creating asset files..."
mkdir -p html/assets/modules/${MODULE_NAME}
touch html/assets/modules/${MODULE_NAME}/style.css
touch html/assets/modules/${MODULE_NAME}/main.js

# Update router configuration
echo "Updating router configuration..."
sed -i "/${MODULE_NAME}:/c * *" /path/to/your/router/routes.php \
    << EOD
    '${MODULE_NAME}' => array(
        '_route' => '${MODULE_NAME}',
        'controller' => 'Module\\Controllers\\${MODULE_NAME}Controller',
        'action' => 'index'
    ),
EOD

echo "Module creation completed!"
echo "You can now access your new module at /${MODULE_NAME}/"