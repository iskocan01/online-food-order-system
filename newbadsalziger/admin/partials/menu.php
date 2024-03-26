<?php
	 include('../config/constants.php');
	 include('login-check.php');
	 ob_start();
 ?>

<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Bad Salziger Kebab hous</title>
	<link rel="icon" href="<?php echo SITEURL; ?>images/newlogo1.png" type="image/x-icon"/> 
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
	

	
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	<link rel="stylesheet" href="../css/css/custom.css">









<!--




      <style>
        /* Modal stilleri (isteğe bağlı) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
        }

        .modal-content {
            margin: 5% auto;
            padding: 20px;
            width: 80%;
        }
    </style>


-->

















</head>
<body>
	<!-- Menü Section Start	 -->  
	<div class="menu text-center">
		<div class="wrapper">
			<ul>
				<li><a href="index.php">Home</a> </li>
				<li><a href="manage-admin.php">Admin</a> </li>
				<li><a href="manage-category.php">Category</a> </li>
				<li><a href="manage-food.php">Food</a> </li>
				<li><a href="manage-product.php">Product</a> </li>
				<li><a href="manage-order.php">Order</a> </li>
				<li><a href="logout.php">Çıkış yap</a> </li>
			</ul>

		</div>

		<!-- <div class="profil">
			<div class="p-foto">
					
			</div>
					<h1>
						<?php 
							// if(isset($_SESSION['admin-user']))
							// {
							// 	echo $_SESSION['admin-user'];
							// }


						?> 
					</h1>


		</div>  -->
		
	</div>
	<!-- Menü Section Ends	 --> 