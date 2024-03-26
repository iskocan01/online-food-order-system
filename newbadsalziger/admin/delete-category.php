<?php 
	include('../config/constants.php');

	if (isset($_GET['id']) AND isset($_GET['image_name'])) 
	{
		

		$id= $_GET['id'];
		$image_name = $_GET['image_name'];

//		remove the physical image file is avaible

		//echo $id."<br>".$image_name;

		if ($image_name != "") 
		{
			
			$path = "../images/category/".$image_name;

			$remove = unlink($path);

			if ($remove == false) 
			{

				/// 
				$_SESSION['remove'] ="<div class='error'>Faile to remove Category Image brası calışıyor .</div>";
				header("location:".SITEURL."admin/manage-category.php"); 

				die();
				
			}

		}

		//delete data From Database

		$sql ="DELETE FROM tbl_category WHERE id=$id";

		$res = mysqli_query($conn, $sql);

		if ($res==true) 
		{
			//set success message and redirect,
			$_SESSION['delete'] ="<div class='success'>Category deleted Successfully</div>";

	 		//Redirect Page to manage Admin
	 		header("location:".SITEURL.'admin/manage-category.php');
			
		}
		else
		{
			//olumsuz olursa cerecimiz bu şekilde olacaktır
		$_SESSION['delete'] ="<div class='error'>Category couldn\'t delete</div>";

	 		//Redirect Page to manage Admin
			//manage admin sayfasına yönlendirdik
	 		header("location:".SITEURL.'admin/manage-category.php');
		}

		//redirect to manage catagory page with message

	}
	else
	{
		header("location:".SITEURL."admin/manage-category.php");

	}
 ?> 