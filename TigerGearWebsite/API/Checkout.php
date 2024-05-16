<?php
session_start();
require('../Database/DBController.php');

class Checkout {
    public $db = null;

    public function __construct(DBController $db) {
        // Check if the database connection is set
        if (!isset($db->conn)) return null;
        $this->db = $db;
    }

    public function saveOrder($order) {
        // Decode the order JSON string into an associative array
        $order = json_decode($order, true);
        $out = "";
        $flag = 0;

        // Iterate over each item in the order array
        foreach($order as $item) {
            if($flag != 0) {
                $out = $out.", ".$item['id']."(".$item['quantity'].")";
                $flag = 1;
            } else {
                $out = $out.$item['id']."(".$item['quantity'].")";
            }
        }

        // Construct the SQL query to save the order details
        $query = "INSERT INTO orders(user_name, products) VALUES( '".$_SESSION['username']."', '".$out."')";

        // Execute the SQL query
        $this->db->conn->query($query);

        // Check for any database connection errors
        if($this->db->conn->connect_error) {
            exit("Connection failed: " . $this->db->conn->connect_error);
        }

        // Update the quantity of products in the database
        for ($i = 0 ; $i < count($order) ; $i++) {
            $id = $order[$i]['id'];
            $query = "UPDATE product SET quantity=quantity-".$order[$i]['quantity']." WHERE pid=$id";
            $this->db->conn->query($query);
        }

        // Exit with a success message in JSON format
        exit('{
            "result": "success" 
        }');
    }
}

// Create an instance of the Checkout class
$C = new Checkout($db);

// Call the saveOrder() method with the "order" query parameter value from the URL
$C->saveOrder(@$_GET['order']);



