**Installation**

# IMPORTANT
1. Make new Virtual host for project. 
   Url root should start from project root.
   
   _Example_ 
   
   Correct = http://contacts-backend.com/contacts/getList
   
   Wrong = http://localhost/ContactsBackend/contacts/getList
   
   
   _Virtual Host Example_
   
   <VirtualHost *:80>
   
     # Admin email, Server Name (domain name) and any aliases
     ServerAdmin webmaster@domain1.com
     ServerName  contacts-backend.com
     ServerAlias www.contacts-backend.com
   
   
     # Index file and Document Root (where the public files are located)
     DirectoryIndex index.php
     DocumentRoot /var/www/html/ContactsBackend
   
     <Directory "/var/www/html/ContactsBackend/">
       AllowOverride All
     </Directory>
   
   
     # Custom log file locations
     LogLevel warn
     ErrorLog /var/log/apache2/error-mydomainname.com.log
     CustomLog /var/log/apache2/access-mydomainname.com.log combined
   </VirtualHost>
   
   Don't forget to add **AllowOverride All** config in your virtual host.
   
   Make sure you apache **mod_headers** is enabled to handle .htaccess headers config 
   for cross domain requests.
   
   
2. Install composer to handle autoload.


3. Setup correct db configs from db_params.php.
   Use migration.sql queries to create required tables.

