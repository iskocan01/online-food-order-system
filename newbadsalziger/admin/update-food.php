<?php include("partials/menu.php"); ?>

	<div class="main-content">
		<div class="wrapper">
			<h1>Yemek Güncelle</h1>
			<br><br>

			<?php 
				if (isset($_GET['id'])) {
					$id = $_GET["id"];

					$sql2 = "SELECT * FROM tbl_food WHERE id=$id";

					$res2 = mysqli_query($conn, $sql2);

					//
					$row2 = mysqli_fetch_assoc($res2);
					// gett the individual value of selectet
					$food_code = $row2['food_code'];
					$title = $row2['title'];
					$description = $row2['description'];
					$price= $row2['price'];
					$current_image = $row2["img_name"];
					$current_category = $row2['category_id'];
					$featured = $row2['featured'];
					$active	= $row2['active'];
					
				}
				else
				{
					//manage food sayfasına yönlendir
					header("location:".SITEURL."admin/manage-food.php");
				}
			 ?>	

			<form action="" method="POST" enctype="multipart/form-data">
				<table class="tbl-30">
					<tr>
						<td>Food Code:</td>
						<td>
							<input type="text" name="food-code" value="<?php echo $food_code; ?>" placeholder="<?php echo $food_code; ?>">
						</td>
					</tr>
					<tr>
						<td>Title:</td>
						<td>
							<input type="text" name="title" value="<?php echo $title; ?>" placeholder="<?php echo $title; ?>">
						</td>
					</tr>

					<tr>
							<td>Description: </td>
						<td>
							<textarea name="description" cols="30" rows="5"   placeholder="<?php echo $description; ?>"><?php echo $description; ?></textarea>
						</td>
					</tr>

					<tr>
						<td>Price:</td>
						<td>
							<input type="number" name="price"  value="<?php echo $price; ?>"  placeholder="<?php echo $price; ?>">
						</td>
					</tr>
					<tr>
						<td>Current image</td>
						<td>
							<?php 
								if ($current_image=="") {
									echo "<div class ='error' >Resim Eklenmedi</div>";
								}
								else
								{
									?>
									<img src="<?php echo SITEURL."images/food/".$current_image; ?>" width="110px">
									<?php
								}
							 ?>
								
							
						</td>
					</tr>

					<tr>
						<td>Select New	 Image: </td>
						<td>
							<input type="file" name="image">
						</td>
					</tr>

					<tr>
						<td>Category:</td> 
						<td>
							<select name="category">

									<?php 
										 //create Php go to display catogories From data base

										//1. Create sql to get active categories From Data base

										$sql = "SELECT * FROM tbl_category WHERE active='Yes'";

										//executing query
										$res = mysqli_query($conn, $sql);

										//count rows to check whether we have categories or not
										$count = mysqli_num_rows($res);

										//if count is greater than zero we have categories else we dont have any categories
										if ($count>0) {
											//we have categories
											while ($row = mysqli_fetch_assoc($res)) {
												// get the details of categories
												$category_id=$row['id'];
												$category_title=$row['title'];
												?>
													<option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>" ><?php echo $category_title; ?></option>
													
												<?php
											}
										}
										else
										{
											//we donnot have category
											?>
												<option  value="0">Henüz Bir kategori Eklemediniz </option>

											<?php
										}

										//2.Display on Drpopdown

									 ?>
 
							</select>
						</td>
					</tr>

					<tr>
						<td>Featured:</td>
						<td>
							<input <?php if($featured=="Yes") echo "checked"; ?> type="radio" name="featured" value="Yes">Yes
							<input <?php if($featured=="No") echo "checked"; ?> type="radio" name="featured" value="No">No
						</td>
					</tr>

					<tr>
						<td>Active:</td>
						<td>
							<input <?php if($active=="Yes") echo "checked"; ?> type="radio" name="active" value="Yes">Yes
							<input <?php if($active=="No") echo "checked"; ?> type="radio" name="active" value="No">No
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<input type="hidden" name="id" value="<?php echo $id; ?>">
							<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
							<input type="submit" name="submit" value="Update Food" class="btn-secondary">
						</td>
					</tr>
				</table>
			</form>

			<?php 

				if (isset($_POST['submit'])) 
				{
					//echo "button cliked";
					//bütün bilgileri formdan almamız gerekiyor

					$id = $_POST['id'];
					$food_code = $_POST['food-code'];
					$title = $_POST['title'];
					$description = $_POST['description'];
					$price	= $_POST['price'];
					$current_image = $_POST['current_image'];
					$category = $_POST['category'];

					$featured= $_POST['featured'];
				 	$active = $_POST['active']; 

					//2. Eğer Yeni resim  secildiyse yükle

					if (isset($_FILES['image']['name'])) {
						
						$image_name = $_FILES['image']['name'];

						if ($image_name != "") 
						{
							
							$ext = end(explode(".",$image_name));

							$image_name ="Food-name-".$category_id."-".rand(0000,9999).".".$ext;

							$source_path = $_FILES['image']['tmp_name'];
							$destination_path = "../images/food/".$image_name;
							$upload = move_uploaded_file($source_path, $destination_path);

							if ($upload==false) 
							{
								$_SESSION['upload'] = "<div class='error' >İmage could not upload folder </div>";
		 						header('location:'.SITEURL.'admin/manage-food.php');

		 						die();
							}

							if ($current_image != "") {
								$remove_path = "../images/food/".$current_image;

								$remove = unlink($remove_path);

								if ($remove == false) 
								{
									$_SESSION['failed-remove']="<div class='error' > Resim dosya dizininden silinemedi..</div>";
			 						header("location:".SITEURL."admin/manage-category.php");
			 						die(); 
								}
							}


						}   
						else
						{
							$image_name = $current_image;
						}

					}
					
					//3. eski resim varse ve yeni resim yüklendiyse eski resmi kaldır.

					// 4. yemekği veri tabanın da güncelle

					$sql3 = "UPDATE tbl_food SET
						food_code = '$food_code',
						title ='$title',
						description ='$description',
						price =$price,
						img_name ='$image_name',
						category_id ='$category', 
						featured = '$featured',
						active = '$active'
						WHERE id=$id 
					";

					$res3 = mysqli_query($conn, $sql3);

					if ($res3 == true) {
						//veriler güncellendi
						$_SESSION['update'] = "<div class='success'> Güncellendi.. </div>";
						header("location:".SITEURL."admin/manage-food.php");


					}
					else
					{
						//veriler güncellenemedi
						$_SESSION['update'] = "<div class='error'> Hatta!!! güncellenmedi.. </div>";
						header("location:".SITEURL."admin/manage-food.php");

						die();
					}


					// 5. manage food sayfasına yönlendir ve mesajlarını aktar
				}
				else
				{
					//echo "button dont click";
				}
			 ?>
			
		</div>
	</div>

<?php include("partials/footer.php"); ?>