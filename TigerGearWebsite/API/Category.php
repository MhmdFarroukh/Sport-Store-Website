<?php
session_start();
require('../Database/DBController.php');

class Category {
    public $db = null;

    public function __construct(DBController $db) {
        // Check if the database connection is set
        if (!isset($db->conn)) return null;
        $this->db = $db;
    }

    public function getCategories() {
        // Retrieve all categories from the database
        $result = $this->db->conn->query("SELECT * FROM category");
        $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $category = @$_GET['cat'];

        // Echo HTML code to display categories as a list
        echo '<li>
                <a href="shop.php">All</a>
              </li>';

        // Loop through each category and display it as a list item
        foreach($result as $cat) {
            echo '<li>
                    <a href="shop.php?cat='.$cat['category_name'].'">'.$cat['category_name'].'</a>
                  </li>';  
        }
    }
}

// Create an instance of the Category class
$C = new Category($db);

// Check if the "getCategories" query parameter is set in the URL
if(isset($_GET['getCategories']))
    $C->getCategories(); // Call the getCategories() method to display the categories

