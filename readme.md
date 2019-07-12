**Installation**

# IMPORTANT
1. Make new Virtual host for project. 
   Url root should start from project root.
   
   _Example_ 
   
   Correct = http://contacts-backend.com/contacts/getList
   
   Wrong = http://localhost/ContactsBackend/contacts/getList
   
   Don't forget to add **AllowOverride All** config in your virtual host.
   
   Make sure you apache **mod_headers** is enabled to handle .htaccess headers config 
   for cross domain requests.
   
   
2. Give full permission to project if need. sudo chmod -R 0777 ContactsBackend   
  
   
3. Install composer to handle autoload.


4. Setup correct db configs from db_params.php.
   Use migration.sql queries to create required tables.

