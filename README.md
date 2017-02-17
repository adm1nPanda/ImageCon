##ImageCON
###A simple web application to upload images.

####Dependancies
This application is built using Apache, javascript and mysql.

####Setup instructions

1. Install Xampp - https://www.apachefriends.org/index.html  
	Xampp has Apache and MySQL bundled and makes it easy to install.  
2. Download all files from git
> $ git clone https://github.com/chowdaryd/ImageCon.git
3. Move files/folder into apache.
4. Setup database
	4.1 Start MySQL server
	4.2 Create a new database for application 
> $ CREATE DATABASE imagecon;

	4.3 Create tables in new database

	```
	$ CREATE TABLE `users` (
 	`index` int(255) NOT NULL AUTO_INCREMENT,
 	`username` varchar(150) NOT NULL,
 	`password` varchar(150) NOT NULL,
 	`user_id` int(50) NOT NULL,
 	PRIMARY KEY (`index`),
 	UNIQUE KEY `user_id` (`user_id`),
 	UNIQUE KEY `username` (`username`)
	) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1

	$ CREATE TABLE `images` (
 	`imageid` int(255) NOT NULL AUTO_INCREMENT,
 	`filename` varchar(35) NOT NULL,
 	`caption` varchar(350) NOT NULL,
 	`uploadtime` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
 	`user_id` int(50) NOT NULL,
 	PRIMARY KEY (`imageid`)
	) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1
	```

####Files
index - Homepage for website  
upload - Image upload form  
img_upload - serverside PHP to handle image upload  
login - login form  
user_login - serverside PHP to verify login  
register - register form  
user_register - serverside PHP to register new users  
logout - serverside PHP to logout users  
profile - user's profile - edit/delete own pictures  
edit - update caption form  
edit_image - serverside PHP to update caption  
delete - serverside PHP to delete user's images  
base - CSS for all webpages  
db_config - database configuration file  

####References
PHP documentation - http://php.net/manual/en/  
More Documentation - https://www.w3schools.com/  
Pagination code - http://stackoverflow.com/questions/14451364/php-code-for-display-10-records-from-mysql-dynamically  