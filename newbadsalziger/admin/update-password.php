<?php include("partials/menu.php"); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Şifre Değiştir</h1>

		<?php 
			if (isset($_GET['id'])) {
				$id=$_GET['id'];
			}
			
			
		 ?>

		<form action="" method="POST" >
			
			<table class="tbl-30">
				<tr>
					<td>Eski Şifre</td>
					<td>
						<input type="text" name="old_password" placeholder="Giriniz">
					</td>
				</tr>
				<tr>
					<td>Yeni Şifre</td>
					<td>
						<input type="text" name="new_password" placeholder="Giriniz">
					</td>
				</tr>
				<tr>
					<td>Şifre Tekrar</td>
					<td>
						<input type="text" name="confirm_password" placeholder="Giriniz">
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="hidden" name="id" value="<?php echo $id; ?>">
						<input type="submit" name="submit" class="btn-primary" value="Şifre Onayla">
					</td>
				</tr>
			</table>

		</form>

	</div>
</div>

<?php 
		
		if (isset($_POST['submit'])) {
			
			$id = $_POST['id'];
			$current_password = md5($_POST['old_password']);
			$new_password = md5($_POST['new_password']);
			$confirm_password= md5($_POST['confirm_password']);

			$sql ="SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

			$res = mysqli_query($conn, $sql);

			if ($res==true) {

				$count = mysqli_num_rows($res);

				if ($count==1) {
					
					if ($new_password==$confirm_password) {
						
						$sql2 ="UPDATE tbl_admin SET 
						password='$new_password' WHERE id=$id";

						$res2 =mysqli_query($conn, $sql2);

						if ($res2==true) {
							$_SESSION['pdw-patch']="<div class='success'>Şifreniz Başrıyla Değişmiştir Vatana Millete Hayırlı Olsun</div>";
							header('location:'.SITEURL.'admin/manage-admin.php');

						}else{

						}

						

					}
					else
					{
						$_SESSION['pdw-not-patch']="<div class='error'>Şifreler aynı değil Lütfen tekrar dendeyin</div>";
					header('location:'.SITEURL.'admin/manage-admin.php');
					}
				}
				else
				{
					$_SESSION['user-not-found']="<div class='error'>Kullanıcı bulunamadı</div>";
					header('location:'.SITEURL.'admin/manage-admin.php');
					
				}

				echo "connectin succesfully";
			}


		}


 ?>


<?php include("partials/footer.php"); ?>