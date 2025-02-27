# Public Directory
cd /var/www/html

# View Directory
ls /var/www
ls -l /var/www
ls -al /var/www

ls /var/www/html
ls -l /var/www/html

# Delete File
sudo rm /var/www/html/private_key.pem

# Correct Permissions
[ec2-user@ip-172-31-6-102 ~]$ ls -ld /var/www /var/www/html
drwxr-xr-x 4 ec2-user ec2-user  49 Feb 20 19:07 /var/www
drwxr-xr-x 5 apache   apache   103 Feb 24 20:08 /var/www/html

# Connect SSH
ssh -i "/Users/gregoryjackson/Desktop/peakprod.pem" ec2-user@ec2-3-145-193-251.us-east-2.compute.amazonaws.com

# Create File
nano fix-apache.sh