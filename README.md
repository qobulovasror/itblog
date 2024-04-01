# IT Blog

This is a simple IT blog application built using PHP and MySQL. It allows users to create, read, update, and delete blog posts related to Information Technology topics.

## Features

1. User Authentication: Users can sign up for an account and log in to create, edit, or delete their blog posts.
2. CRUD Operations: Full CRUD (Create, Read, Update, Delete) functionality for blog posts.
3. Responsive Design: The application is designed to be responsive and accessible across various devices.
4. Security: User authentication and input validation to ensure security.
5. Search Functionality: Users can search for specific blog posts based on keywords or categories.
6. Categories: Ability to categorize blog posts for better organization and navigation.

## Requirements

- PHP 7.x or higher
- MySQL
- Web server (e.g., Apache, Nginx)
- Modern web browser

## Installation

1. Clone this repository to your local machine:
   ```bash
    git clone https://github.com/qobulovasror/itblog.git
   ```  
2. Import the included SQL file (database.sql) into your MySQL database to set up the necessary tables.
3. Configure the database connection in script/main.php:
```php
    <?php
    	// Connecttion server
    	$servername="localhost";
    	$username="your_database_username";
    	$password="your_database_username";
    	$dbname="your_database_name";
    	$link=mysqli_connect($servername,$username,$password,$dbname);
    
    	if($connect -> conncet_error){
    		die("Bo'glanishda xatolik: ".conncet_error);
    	}
    ?>
   ```
4. Start your web server.
5. Access the application through your web browser.

## Usage

1. Sign Up/Login: Users need to sign up for an account or log in if they already have one.
2. Create a Blog Post: Logged-in users can create new blog posts by providing a title, content, and selecting a category.
3. Edit/Delete Blog Posts: Users can edit or delete their own blog posts.
4. View Blog Posts: All users can view blog posts created by others.
5. Search: Utilize the search functionality to find specific blog posts by keyword or category.

__Thank you for using our IT Blog App! Happy Blogging! 🚀__
   
