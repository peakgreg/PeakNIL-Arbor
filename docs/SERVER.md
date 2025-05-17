# EC2 PHP-Apache Setup Guide

## Initial Server Setup
```bash
# Update your system
sudo yum update -y

# Install Apache
sudo yum install -y httpd

# Start and enable Apache
sudo systemctl start httpd
sudo systemctl enable httpd

# Install Amazon Linux Extras to get newer PHP versions
sudo amazon-linux-extras install -y php8.2

# Install PHP and common extensions
sudo yum install -y php php-common php-pdo php-gd php-xml php-mbstring php-json php-zip php-curl

# Install MySQL PDO driver to connect to PlanetScale
sudo yum install -y php-mysqlnd

# Install optional PHP extensions
sudo yum install -y php-fileinfo php-tokenizer php-simplexml

# Install Composer for PHP dependency management
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer
```

## Directory Setup and Configuration
```bash
# Make Public Directory
sudo mkdir -p /var/www/public

# Create a test index.php file
echo '<?php phpinfo(); ?>' | sudo tee /var/www/public/index.php

# Edit Apache Config file to make /var/www/public the document root
sudo nano /etc/httpd/conf/httpd.conf
```

In the configuration file, change:
```
DocumentRoot "/var/www/html"
<Directory "/var/www/html">
```
To:
```
DocumentRoot "/var/www/public"
<Directory "/var/www/public">
```

Also find any other instances of "/var/www/html" and change them to "/var/www/public"

```bash
# Restart Apache to apply configuration changes
sudo systemctl restart httpd
```

## Permission Setup
```bash
# Give ec2-user ownership temporarily to manage files
sudo chown -R ec2-user:ec2-user /var/www

# Set proper directory permissions
sudo chmod 755 /var/www
sudo chmod 755 /var/www/public

# Set file permissions in the public directory
sudo chmod 644 /var/www/public/index.php

# Set Apache as the final owner for production
sudo chown -R apache:apache /var/www

# Add ec2-user to the apache group for continued management
sudo usermod -a -G apache ec2-user

# Log out and log back in for group changes to take effect
exit
# (log back in)
```

## Enable .htaccess (Optional)
```bash
# Edit Apache Config to allow .htaccess overrides
sudo nano /etc/httpd/conf/httpd.conf
```

Find:
```
<Directory "/var/www/public">
    AllowOverride None
```
Change to:
```
<Directory "/var/www/public">
    AllowOverride All
```

```bash
# Restart Apache to apply changes
sudo systemctl restart httpd
```

## Configure Security Group
1. Navigate to the EC2 dashboard
2. Select your instance
3. Click on the Security tab
4. Make sure the Security Group allows inbound traffic on ports:
   - 80 (HTTP)
   - 443 (HTTPS) if using SSL
   - 22 (SSH) restricted to your IP

## Testing Your Setup
```bash
# Access your website by visiting your EC2 public IP address
http://your-ec2-public-ip
```

You should see the PHP info page, confirming that everything is working correctly.

## Next Steps
- Install SSL certificate with Let's Encrypt (Certbot)
- Set up your application's database connection to PlanetScale
- Deploy your application code to /var/www