<?php 
	include("../config/constants.php"); 

	if (isset($_GET['id']) AND isset($_GET['image_name'])) 
	{
		// code...
	
 
		$id=$_GET['id'];
		$image_name = $_GET['image_name'];

		if ($image_name != "") {
		 
		 	$path = "../images/food/".$image_name;

		 	$remove = unlink($path);

		 	if ($remove == false) {
		 		$_SESSION['remove'] = "<div class='error'> Resim dosya dizininden silinemedi..</div>..";
		 		header("location:".SITEURL."admin/manage-food.php");

		 		die();
		 	}
		}

		$sql = "DELETE FROM tbl_food WHERE id=$id";
		$res = mysqli_query($conn, $sql);
		 if ($res == true)
		 {
		 	//set success message and redirect,
			$_SESSION['delete'] ="<div class='success'>Yemek Silindi</div>";

	 		//Redirect Page to manage Admin
	 		header("location:".SITEURL.'admin/manage-food.php');
			
		}
		else
		{
			//olumsuz olursa cerecimiz bu şekilde olacaktır
		$_SESSION['delete'] ="<div class='error'>Yemek silinemedi</div>";

	 		//Redirect Page to manage Admin
			//manage admin sayfasına yönlendirdik
	 		header("location:".SITEURL.'admin/manage-food.php');
		}
		 

	 }
	 else
	 {
	 	header("location".SITEURL."admin/manage-food.php");
	 }



?>

