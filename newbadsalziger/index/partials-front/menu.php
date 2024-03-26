<?php include('../config/constants.php'); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
    <title>Bad-Salzing Haus</title>

  

    <!-- Link our CSS file -->

<link rel="icon" href="../images/newlogo1.png" type="image/x-icon"/> 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="js/jquery-3.6.3.min.js"></script> 

</head>
<body>
<?php
    $currentPage = $_SERVER['PHP_SELF'];
    // pathinfo fonksiyonu kullanarak dosya adını elde etme
    $fileInfo = pathinfo($currentPage);
    $fileName = $fileInfo['basename'];

   
    if (isset($_SESSION["cart"])) {
		$foods = $_SESSION['cart']["foods"];
        $summary = $_SESSION['cart']['summary'];

         
        $total_count = $summary["total_count"];
       }   

   
 ?>

 


	
	<div class="nav ">
		<div class="navigation">
			<ul>
				<li class="list <?php echo ($fileName == 'index.php') ? 'active' : ''; ?> "> 
					<a href="<?php echo SITEURL.INDEX; ?>">
						<span class="icon">
							<i class="fa-solid fa-house"></i>
						</span>
						<span class="text">Home</span>
					</a>
				</li>	
				<li class="list  <?php echo ($fileName == 'categories.php' || $fileName =="categories-food.php") ? 'active' : ''; ?> ">
					<a href="<?php echo SITEURL.INDEX; ?>categories.php">
						<span class="icon">
							<i class="fa-solid fa-border-all"></i>
						</span>
						<span class="text">Category</span>
					</a>
				</li>	
				<li class="list <?php echo ($fileName == 'card.php') ? 'active' : ''; ?> ">
					<a href="<?php echo SITEURL.INDEX; ?>card.php">
						<span class="icon position-relative">
							<i class="fa-solid fa-basket-shopping"></i>

								<?php 
								if (isset($total_count)) {
									if ($total_count <= 0 || !isset($total_count)) {
										echo "total count yok";
									}else{
										?>
											<span class="position-absolute   translate-middle badge rounded-pill bg-success" style="top:-5px; right: -40px;">
										      <?php echo $total_count; ?>   
											</span>	
										<?php
									}									 
								}

								 ?>
							
						</span>
						<span class="text">Card</span>

					</a>
				</li >	
				<li class="list <?php echo ($fileName == 'orders.php') ? 'active' : ''; ?> ">
					<a href="<?php echo SITEURL.INDEX; ?>orders.php">
						<span class="icon">
							<i class="fa-solid fa-burger"></i>
						</span>
						<span class="text">Orders</span>
					</a>
				</li>	
				<li class="list <?php echo ($fileName == 'help.php') ? 'active' : ''; ?> ">
					<a href="<?php echo SITEURL.INDEX; ?>help.php">
						<span class="icon">
							<i class="fa-solid fa-question"></i>
						</span>
						<span class="text">Help</span>
					</a>
				</li>	
				<div class="indicator"></div>	 
			</ul>
	
		</div>
		
	</div>