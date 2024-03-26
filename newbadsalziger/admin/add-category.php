<?php include('partials/menu.php'); ?>
	<div class="main-content">
		<div class="wrapper">
			<h1>Add Category</h1>
			<br><br><br>

			<?php 
				if (isset($_SESSION['add'])) 
				{
					echo $_SESSION['add'];
					unset($_SESSION['add']);				
				}

				if (isset($_SESSION['upload'])) 
				{
					echo $_SESSION['upload'];
					unset($_SESSION['upload']);				
				}

			 ?>
			 <br><br>
<!--Kategori ekleme formu başlangıcı ********************************************************************************-->
			<form action="" method="POST" enctype="multipart/form-data">
				<table class="tbl-30">
					<tr>
						<td>Title:</td>
						<td>
							<input type="text" name="title" placeholder="Category Title">
						</td>
					</tr>
					<tr>
						<td>Select image</td>
						<td>
							<input type="file" name="image">
						</td>
					</tr>
					<tr>
						<td>Featured:</td>
						<td>
							<input type="radio" name="featured" value="Yes"> Yes
							<input type="radio" name="featured" value="No"> No
						</td>
					</tr>
					<tr>
						<td>Active:</td>
						<td>
							<input type="radio" name="active" value="Yes"> Yes
							<input type="radio" name="active" value="No"> No
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" name="submit" value="Add category" class="btn-secondary">
						</td>
					</tr>
				</table>
			</form>

<!--Kategori ekleme formu sonu ******************************************************************************************-->

			<?php 

	// buttona basıldığında burası çalışacak |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
			if (isset($_POST['submit'])) {
				//başlık için bir değişken oluşturduk ve formdaki title ismindeki texti başlığa atadık
				$title=$_POST['title'];
				//ilk radio secme buttonları
				if (isset($_POST['featured'])) {
					$featured =$_POST['featured'];
				}
				else{
					$featured ='No';
				} 
				//ikinci radio secme butonu
				if (isset($_POST['active'])) {
					$active =$_POST['active'];
				}
				else{
					$active ='No';
				}



				//print_r($_FILES['image']);

				//die();
				//resim dosyamız için resim özelliklerini değişkenlere atadık
				if (isset($_FILES['image']['name'])) //resimin ismi doğru ise koşulu
				{ 
					$image_name=$_FILES['image']['name'];//resmin ismini cektik ve değişkene atadık

					if ($image_name!="") 
					{
						
					
						//dosya yolunu explode fonk. ile parcalayıp dosyanın uzantısını alacağız

						$ext = end(explode(".", $image_name));

						$image_name="Food_Category_".rand(000,999).".".$ext;	


						$source_path =$_FILES['image']['tmp_name'];// //resmin kaynak yoludur
						$destination_path = "../images/category/".$image_name; //resmin hedef yoludur

						

						//Finaly Upload the image

						$upload = move_uploaded_file($source_path, $destination_path);//resmin kaynak yolunu ve hedef yolu ile resmi yükledik

						//check whether image is uploaded or not
						//and if image is not uploaded than we will stop the process and redirect  with error message

						if ($upload==false) //hata alırsak yükleme tamamlanmaz ise aşağıdaki blok çalışacak
						{
							//Set  message
							$_SESSION['upload'] ="<div class='error' > Failed to upload Image.</div>";//cerez oluşturarak  add-category sayfasına yönlendirelim
							//Redirect to add-category page

							header('location:'.SITEURL."admin/add-category.php");//yönlendirdiğimiz sayfa yolunu bu şekilde yazdık

							//stop the process 

							die();//bu ne sen yaz hadi
						}

					}
				}
				else
				{
					$image_name="";
				}
				//
				$sql = "INSERT INTO tbl_category SET
					title='$title',
					image_name='$image_name', /*Resim ismini bir üsteki ifden aldık ve veri tabanı ile birleştirdik*/
					featured='$featured',
					active='$active'
				";

				$res = mysqli_query($conn, $sql);///veri tabanına yükleme işlemi tamamlandı

				//Ekleme tamamlandımı yoksa tamamlanmadımı anlamak için çerezzler sayesinde kullanıcıya bildireceğiz 
				if ($res==true) 
				{
					$_SESSION['add']="<div class='success'>Kategori Eklendi </div>";
					header("location:".SITEURL."admin/add-category.php");
				}
				else
				{
					$_SESSION['add']="<div class='error'>Hatta Aldınız </div>";
					header("location:".SITEURL."admin/add-category.php");
				}



			} 
	// buttona basıldığında buraya kadar çalışacak |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||

			?>
			
		</div>
	</div>



<?php include('partials/footer.php'); ?>