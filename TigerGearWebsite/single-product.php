<?php
session_start();
if (!isset($_SESSION["loggedIN"])) {
	header('Location: ./loginPage.php');
	exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- title -->
	<title>Single Product</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="logo.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="assets/css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="assets/css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="assets/css/responsive.css">
	<!-- JQUERY -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


</head>

<body>

	<!--PreLoader-->
	<div class="loader">
		<div class="loader-inner">
			<div class="circle"></div>
		</div>
	</div>
	<!--PreLoader Ends-->

	<?php
	include('header.php');
	?>

	<!-- single product -->
	<div class="single-product mt-150 mb-150">
		<div class="container">
			<div id="single-product-container" class="row">
			</div>
		</div>
	</div>
	<!-- end single product -->


	<script type="text/javascript">
		let id = new URLSearchParams(window.location.search).get('id'); // Get the value of the 'id' parameter from the URL

		$(document).ready(function() {
			$.ajax({
				url: 'API/Product.php?getProductById=1&id=' + id, // The URL to fetch product details by ID
				method: 'GET', // The HTTP method used for the request
				success: function(response) {
					console.log(response); // Log the response (product details) to the console
					$("#single-product-container").html(response); // Display the product details in the 'single-product-container' element
				},
				dataType: 'text', // The expected data type of the response
			});
		});

		function addToCart(id) {
			let order = JSON.parse(localStorage.getItem('order')) || []; // Get the order from the localStorage or create an empty array
			let added = false;
			order.forEach(item => {
				if (item.id == id) {
					item.quantity += 1; // If the item is already in the order, increase its quantity by 1
					added = true;
				}
			});
			if (!added) order.push({
				id,
				quantity: 1
			}); // If the item is not in the order, add it with a quantity of 1

			localStorage.setItem("order", JSON.stringify(order)); // Store the updated order in the localStorage
			alert("Product added to cart"); // Display an alert indicating that the product has been added to the cart

			$.ajax({
				url: 'API/Admin.php?trackClick=' + id, // The URL to track the click event for the product
				method: 'GET', // The HTTP method used for the request
				success: function(response) {
					console.log("FA Tracking Activated - Recorded product added to cart");
					// Log a message to the console indicating that the product click has been tracked
				},
				dataType: 'text', // The expected data type of the response
			});
		}
	</script>

	<?php
	include('footer.php');
	?>

	<!-- jquery -->
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<!-- mean menu -->
	<script src="assets/js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="assets/js/sticker.js"></script>
	<!-- main js -->
	<script src="assets/js/main.js"></script>

</body>

</html>