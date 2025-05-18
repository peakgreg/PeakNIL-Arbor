PeakNIL Platform - Codename Arbor
    
  - composer install --no-dev --optimize-autoloader
  - SSH:
    ssh -i /Users/gregoryjackson/Documents/GitHub/PeakNIL-Arbor/PeakNIL-Arbor.pem ec2-user@3.145.193.251

# Setup
  - Update .env file.

# Terminal Commands
  - Generate directory tree
    `tree -a --prune -I 'vendor' > directory_tree.txt`

  - Launch PHP
    `php -S 0.0.0.0:8888`
    `php -S 0.0.0.0:8000 -t public`

# Architecture 
  - Procedural Modular Architecture

# MySQL
  - Start the MySQL service
    - `brew services start mysql`

  - Secure the installation (set root password and remove insecure defaults):
    - `mysql_secure_installation`
  
  - Log into MySQL.
    -  `mysql -u root -p`
  
  - Create MySQL Database
    - `CREATE DATABASE database_name;`
  
  - Import `schema.sql` to setup tables.
    - `mysql -u root -p user_auth < database/schema.sql`