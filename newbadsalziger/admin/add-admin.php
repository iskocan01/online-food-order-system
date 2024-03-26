<?php include('partials/menu.php'); ?>
	
	<form action="" method="POST">
		<div class="main-content">
			<div class="wrapper">
				<h1>Add Admin</h1>
				<br/><br/>

				<?php 
					if (isset($_SESSION['add'])) //Checking whether the Session is set of Not
					{
						echo $_SESSION['add']; //Display  the Session message if Set
						unset($_SESSION['add']);// Remove Session message
					}	
				 ?>

				<table class="tbl-30">
					<tr>
						<td> Isim: </td>
						<td>
							<input type="text" name="full_name" placeholder="İsim Soyisim">
						</td>
					</tr>
					<tr>
						<td>Kullanıcı adı:</td>
						<td>
							<input type="text" name="username" placeholder="kulanıcı adı">
						</td>
					</tr>
					<tr>
						<td>Sifre:</td>
						<td>
							<input type="password" name="password" placeholder="Şifre">
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit"  value="Admin Ekle" name="submit" class="btn-primary">
						</td>
					</tr>
				</table>
			</div> 
		</div>
	</form>
	

<?php include('partials/footer.php'); ?>

<?php 
	
	//Process the Value from Form and Save it in Database

	//Check whether the submit button is cliked or not
	
	if (isset($_POST['submit'])) {
		//Button cliked
		//echo "Button cliked";

		//1. Get the Data from Form

		$full_name = $_POST['full_name'];
		$username = $_POST['username']; 
	 	$password =md5($_POST['password']);

	 	//2. Sql query to save yhe data into Database

	 	$sql ="INSERT INTO tbl_admin SET
	 		full_name='$full_name',
	 		user_name='$username',
	 		password='$password'

	 	";

	 	//3. Execute query and Save data in Database 

	 	$res = mysqli_query($conn, $sql) or die(mysqli_error());

	 	//4. Check Whether the(querty is executed) Data is inserted or not and display appropriate message
	 	if ($res==true) {
	 		//Data inserted
	 		//echo "Data inserted";
	 		//Create a session variable to display message
	 		$_SESSION['add'] ="Admin Added Successfully";

	 		//Redirect Page to manage Admin
	 		header("location:".SITEURL.'admin/manage-admin.php');

	 	}else{
	 		//Failed to insert Data
	 			//Create a session variable to display message
	 		$_SESSION['add'] ="Failed to add Admin";

	 		//Redirect Page to Add Admin
	 		header("location:".SITEURL.'admin/add-admin.php');
	 	}

	}
	


 ?>