<?php
//1
require('../Database/DBController.php');
//2
class Admin
{
    // Database connection variable
    public $db = null;
     // Constructor for Admin class
    public function __construct(DBController $db)
    {
        // Check if a valid DBController object is passed
        if (!isset($db->conn)) return null;// If not, return null
        // Assign the DBController object to the class variable
        $this->db = $db;
    }
    
    //3
    public function getData($table = 'product'){
        // Execute a SELECT query on the specified table
        $result = $this->db->conn->query("SELECT * FROM {$table}");
        $resultArray = array();

        // fetch product data one by one
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $resultArray[] = $item;
        }
        // echo "API call Succeeded";
        // Iterate over the result array and generate HTML output for each item
        foreach($resultArray as $item){
            echo "<div class='col-lg-4 col-md-6 text-center' id ='".$item['pid']."'".$item['category'].">
            <div class='single-product-item'>
                <div class='product-image'>
                    <a href='single-product.php?id=".$item['pid']."'><img src='".$item['image']."' alt='Product Image'></a>
                </div>
                <h3>".$item['name']."</h3>
                <p class='product-price'>".$item['price']."$</p>
                <a href='cart.php' class='cart-btn'><i class='fas fa-shopping-cart'></i> Add to Cart</a>
                </div>
            </div>";
        }
    }

    //4
    // delete product item using product item id
    public function deleteProduct($item_id = null){
    // Check if the item_id is not null
    if($item_id != null){
        // Execute a DELETE query to delete the product item with the specified item_id
        $result = $this->db->conn->query("DELETE FROM product WHERE pid={$item_id}");
    }
    // Redirect the user to the shop.php page
    header('Location: ../shop.php');
}

    //5
    public function addProduct(){
        // Get the values from the POST data
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $image = $_POST['image'];

        // Execute an INSERT query to add a new product to the database
        $this->db->conn->query("INSERT INTO product(name,price,quantity,description,category,image,clicks) VALUES('".$name."', '".$price."', '".$quantity."', '".$description."', '".$category."', '".$image."', 0)");

        // Redirect the user to the shop.php page
        header('Location: ../shop.php');
    }

    //6
    public function updateProduct(){
        // Get the values from the POST data
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $image = $_POST['image'];
    
        // Construct the UPDATE query to update the product in the database
        $query = "UPDATE product SET name='".$name."', price=".$price.", quantity=".$quantity.", description='".$description."', category='".$category."', image='".$image."' WHERE pid='$pid'";
        
        // Output the generated query (optional)
        echo $query;
    
        // Execute the UPDATE query to update the product in the database
        $this->db->conn->query($query);
    
        // Redirect the user to the shop.php page
        header('Location: ../shop.php');
    }
    
     //7
    public function addCategory($name){
        // Execute an INSERT query to add a new category to the database
        $this->db->conn->query("INSERT INTO category(category_name) VALUES ('$name')");
        
        // Redirect the user to the admin.php page
        header('Location: ../admin.php');
    }
    public function trackClick($id){
        // Execute an UPDATE query to increment the clicks count for a product
        $this->db->conn->query("UPDATE product SET clicks=clicks+1 WHERE pid=$id");
    }

    public function sendContactMail(){
        // Send ana email using the PHP mail function
        mail("support@tigergearlb.com", $_POST['subject'], $_POST['message']);
    }}

    $admin = new Admin($db);

    // Check if the form for adding a product is submitted
    if(isset($_POST['add-product']))
        $admin->addProduct(); // Call the addProduct() method of the $admin object
    
    // Check if the form for updating a product is submitted
    else if(isset($_POST['update-product']))
        $admin->updateProduct(); // Call the updateProduct() method of the $admin object
    
    // Check if the form for adding a category is submitted
    else if(isset($_POST['add-category']))
        $admin->addCategory($_POST['name']); // Call the addCategory() method of the $admin object with the category name as the parameter
    
    // Check if the 'delete' query parameter is set in the URL
    else if(isset($_GET['delete']))
        $admin->deleteProduct($_GET['delete']); // Call the deleteProduct() method of the $admin object with the product ID as the parameter
    
    // Check if the 'trackClick' query parameter is set in the URL
    else if(isset($_GET['trackClick']))
        $admin->trackClick($_GET['trackClick']); // Call the trackClick() method of the $admin object with the product ID as the parameter
    
    // Check if the 'contact' query parameter is set in the URL
    else if(isset($_GET['contact']))
        $admin->sendContactMail(); // Call the sendContactMail() method of the $admin object
    
    else
        echo ('API Not Found'); // Output the message "API Not Found"



