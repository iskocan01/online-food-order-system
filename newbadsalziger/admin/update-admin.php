<?php include("partials/menu.php");?>
<?php// include("../config/constants.php"); ?>
	
	<div class="main-content">
		<div class="wrapper">
			<h1>Update Admin</h1>
			<br><br>

			<?php  

				$id=$_GET['id'];
				$sql ="SELECT * FROM tbl_admin WHERE id=$id";
				$res = mysqli_query($conn, $sql);

			if ($res == true) {
				$count = mysqli_num_rows($res);
				if ($count == 1) 
				{
					 
					$row = mysqli_fetch_assoc($res);

					$full_name = $row['full_name'];
					$username= $row['user_name'];
												
					
				}
				else{
					header('location:'.SITEURL.'admin/manage-admin.php');
					//echo "veri bulunamadı lütfen destek alın";
				}
			}
				
			?>

			<form action="" method="POST">
				<table class="tbl-30">
					<tr>
						<td>isim:</td>
						<td>
							
							<input type='text' name='full_name' value='<?php echo $full_name; ?>'>
							
							 
						</td>
					</tr>
					<tr>
						<td>Kullanıcı Adı:</td>
						<td>
							<input type="text" name="username" value="<?php echo $username; ?>">
						</td>
					</tr>
					<tr>
						<td colspan="2" >
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="submit" name="submit" value="Güncelle" class="btn-secondary">
						</td>
					</tr>
				</table>

			</form>
			
		</div>
	</div>

	<?php 

		if (isset($_POST['submit'])) {
			
		 	$id=$_POST['id'];
		 	$full_name = $_POST['full_name'];
		 	$username= $_POST['username'];

		 	$sql = "UPDATE tbl_admin SET
		 		full_name = '$full_name',
		 		user_name = '$username' WHERE id=$id 
		 	";

		 	$res= mysqli_query($conn, $sql);
		 	if ($res==true) {
		 		$_SESSION['update']="<div class='success'>Admin güncellendi</div>";

		 		header("location:".SITEURL.'admin/manage-admin.php');
		 	}
		 	else{
		 		$_SESSION['update']="<div class='error'>Admin güncellenemedi</div>";

		 		header("location:".SITEURL.'admin/manage-admin.php');
		 	}

		}
		else{
			
		}

	 ?>
	
<?php include("partials/footer.php"); ?>