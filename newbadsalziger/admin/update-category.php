<?php include("partials/menu.php");?>
<?php// include("../config/constants.php"); ?>
	
	<div class="main-content">
		<div class="wrapper">
			<h1>Kategoriyi Güncelle</h1>
			<br><br> 


			<?php 

			//burada eski verileri cekip yeni veriler ile güncelleme yapmamıza yarayacak

			if (isset($_GET['id'])) 
			{

				 

				$id=$_GET['id'];

				//veri tabanınınile ne yapacağımızı yazdık
				$sql ="SELECT * FROM tbl_category WHERE id=$id";

				//sql sorgumuzu gerçekleştirdik
				$res = mysqli_query($conn, $sql); 


				$count = mysqli_num_rows($res);

				if ($count == 1) 
				{
					 
					$row = mysqli_fetch_assoc($res);

					$title = $row['title'];
					$current_image= $row['image_name'];
					$featured=$row['featured'];
					$active = $row['active'];
												
					
				} 
				else
				{
					$_SESSION['no-category-found']="<div class='error'>Category not foumd</div>";


					header('location:'.SITEURL.'admin/manage-category.php');
					//echo "veri bulunamadı lütfen destek alın";
				}

				
			}
			else
			{
				header("location:".SITEURL."admin/manage-category.php");
			}


 /*

				$id=$_GET['id'];
				$sql ="SELECT * FROM tbl_category WHERE id=$id";
				$res = mysqli_query($conn, $sql);

			if ($res == true) {
				$count = mysqli_num_rows($res);
				if ($count == 1) 
				{
					 
					$row = mysqli_fetch_assoc($res);

					$title = $row['title'];
					//$image_name= $row['image_name'];
					$featured=$row['featured'];
					$active = $row['active'];
												
					
				}
				else{
					header('location:'.SITEURL.'admin/manage-category.php');
					//echo "veri bulunamadı lütfen destek alın";
				}
			}
				
			*/
			?>
  

			<form action="" method="POST" enctype="multipart/form-data">
				<table class="tbl-30">
					<tr>
						<td>Title:</td>
						<td>
							<input type="text" name="title" placeholder="Category Title" value="<?php echo $title  ?>">
						</td>
					</tr>
					<tr></tr>
						<td>Current İmage:</td>
						<td>
							<?php 
								if ($current_image !="") 
								{
									//display the image
									?>
									<img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px">
									<?php
								}
								else
								{
									echo "<div class=error >İmage Not Added.</div>";
								}
							 ?>
						</td>
					</tr>
					<tr>
						<td>New Image:</td>
						<td>
							<input type="file" name="image">
						</td>
					</tr>
					<tr>
						<td>Featured:</td>
						<td>
							<input selected type="radio" name="featured" value="Yes" <?php if ($featured=="Yes"){echo "checked";} ?>>Yes
							<input type="radio" name="featured" value="No"  <?php if ($featured=="No"){echo "checked";} ?> >No

						</td>
					</tr>
					<tr>
						<td>Active:</td>
						<td>
							<input type="radio" name="active" value="Yes" <?php if ($active=="Yes"){echo "checked";} ?> >Yes
							<input type="radio" name="active" value="No" <?php if ($active=="No"){echo "checked";} ?> >No
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="submit" name="submit" value="Kategori Güncelle " class="btn-secondary">
						</td>
					</tr>
				</table>

			</form>

			<?php 



		if (isset($_POST['submit'])) 
		{
			
		 	$id=$_POST['id'];
		 	$title = $_POST['title'];
		 	$current_image= $_POST['current_image'];
		 	$image_name=$_FILES['image'];
		 	$featured= $_POST['featured'];
		 	$active = $_POST['active'];


		 	//yeni resim seçip secmediğimizi kontrol edelim
	/*	 	if (isset($_FILES['image']['name']))
		 	{
		 		 $image_name = $_FILES['image']['name'];

		 		 //check Whether image is avaible or not

		 		if ($image_name != "") //yeni resim almak istemediysek ve input boş ise
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

							header('location:'.SITEURL."admin/manage-category.php");//yönlendirdiğimiz sayfa yolunu bu şekilde yazdık

							//stop the process 

							die();//bu ne sen yaz hadi
						}
						else
						{
							if ($current_image != "") //eski resim adımız boş değilse eski sill
							{
								
								
				 		 	
				 		 		$path = "../images/category/".$current_image;

								$remove = unlink($path);
								if ($remove == false) 
								{

									/// 
									$_SESSION['remove'] ="<div class='error'>Faile to remove Category Image.</div>";
									header("location:".SITEURL."admin/manage-category.php"); 

									die();
									
								}
								else
								{
									$_SESSION['remove']= "<div class='success'>Eski resim dosya içerisinden Silindi</div>";
									header("location:".SITEURL."admin/manage-category.php"); 

									die();
								}

							}
							else
							{
								$_SESSION['remove']= "<div class='error'>Eski resim ismi bulunamadı içerisinden Silinemedi</div>";
								header("location:".SITEURL."admin/manage-category.php"); 

								die();

							}
							
							$_SESSION['upload'] ="<div class='success' > - Resim  Kaynak Dosyaya Yüklendi.</div>";

							header("location:".SITEURL."admin/manage-category.php"); 

							die();
						}

						 
		 		
		 		}
		 		 else
		 		 {
		 		 	$image_name=$current_image;
		 		 }
		 	}
		 	else
		 	{
		 		$image_name = $current_image;
		 	}
	*/	 		

		 	if (isset($_FILES['image']['name'])) 
		 	{
		 		//resmin ismini all
		 		$image_name= $_FILES['image']['name'];

		 		//resmin olup olmadığını kontrol et
		 		if ($image_name != "") 
		 		{
		 			// resim mevcus ise calışan blok burasıdır

		 			// A-)..Yeni resmi yükle  ve yükleyeceğimiz resmin ismini değiştirelim
		 			$ext = end(explode('.', $image_name));

		 			$image_name = "Food-Category_".rand(000,999).".".$ext;

		 			$source_path = $_FILES['image']['tmp_name'];

		 			$destination_path = "../images/category/".$image_name;

		 			$upload = move_uploaded_file($source_path, $destination_path);//////////////////////burayı kontrol et sonra ilk başta dosya ismimi yoksa 

		 			if ($upload==false)
					{
		 				$_SESSION['upload'] = "<div class='error' >Resim dizine yüklenemedi. </div>";
		 				header('location:'.SITEURL.'admin/manage-category.php');

		 				die();
		 			}

		 			//   B-).. Eski resmi dosya dizininden kaldır

		 			if ($current_image != "") 
		 			{

			 			$remove_path = "../images/category/".$current_image;

			 			$remove = unlink($remove_path);
			 			// resimin dizinden silinip silinmediğini kontrol edelim
			 			if ($remove==false) {
			 				// dosya silinemedi  
			 				$_SESSION['failed-remove']="<div class='error' > Resim dosya dizininden silinemedi..</div>";
			 				header("location:".SITEURL."admin/manage-category.php");
			 				die(); 

			 			}
		 			}

		 			

		 		}
		 		else
		 		{
		 			//resim mevcut değildir ve çalışan blok burası olacaktır
		 			$image_name = $current_image;
		 		}

		 	}
		 	else
		 	{
		 		$image_name = $current_image;
		 	}
		 	

		 	$sql2 = "UPDATE tbl_category SET
		 		title = '$title',
		 		image_name ='$image_name',
		 		featured = '$featured',
		 		active = '$active' WHERE id=$id 
		 	";
			
			$res2= mysqli_query($conn, $sql2);

			if ($res2==true) {
		 		$_SESSION['update']="<div class='success'>Kategori güncellendi</div>";

		 		header("location:".SITEURL.'admin/manage-category.php');
		 	}
		 	else{
		 		$_SESSION['update']="<div class='error'>kategori Bulunamadı</div>";

		 		header("location:".SITEURL.'admin/manage-category.php');
		 	}
		 } 
		
		?>

		</div>
	</div>

	

	<?php 

/*

		if (isset($_POST['submit'])) {
			
		 	$id=$_POST['id'];
		 	$title = $_POST['title'];
		 	$featured= $_POST['featured'];
		 	$active = $_POST['active'];

		 	$sql = "UPDATE tbl_category SET
		 		title = '$title',
		 		featured = '$featured',
		 		active = '$active' WHERE id=$id 
		 	";

		 	$res= mysqli_query($conn, $sql);
		 	if ($res==true) {
		 		$_SESSION['update']="<div class='success'>Kategori güncellendi</div>";

		 		header("location:".SITEURL.'admin/manage-category.php');
		 	}
		 	else{
		 		$_SESSION['update']="<div class='error'>kategori güncellenemedi</div>";

		 		header("location:".SITEURL.'admin/manage-category.php');
		 	}

		}
		else{
			
		}


*/

	 ?>
	
<?php include("partials/footer.php"); ?>