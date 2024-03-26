<?php 
include('../config/constants.php');
	
	//1.Get the id Admin to be deleted
	echo $id = $_GET['id']; 
	//2.Create Sql Query to delete admin
	$sql = "DELETE FROM tbl_category WHERE id=$id";

	//Execute Query
	$res = mysqli_query($conn, $sql);

	//Check Whether the Query Executed Succesfully or not 
	if ($res==true) {

		//echo "it s succesfully";
		//Create a session variable to display message
		//bir cerez oluşturduk ve manage-admin sayfasından cekiyorum
	 		$_SESSION['delete'] ="<div class='success'>Category deleted Successfully</div>";

	 		//Redirect Page to manage Admin
	 		header("location:".SITEURL.'admin/manage-category.php');

	}else{
		//echo "it s not succesfully";
 
		//olumsuz olursa cerecimiz bu şekilde olacaktır
		$_SESSION['delete'] ="<div class='error'>Category couldn\'t delete</div>";

	 		//Redirect Page to manage Admin
			//manage admin sayfasına yönlendirdik
	 		header("location:".SITEURL.'admin/manage-category.php');
	}
	
	//3. Redirect to manage Admin with massage (success / error)

 ?>