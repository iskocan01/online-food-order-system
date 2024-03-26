<?php include("partials/menu.php"); ?>

	<div class="main-content">
		<div class="wrapper">
			<h1>Add Food</h1>
			<br><br>

			<?php 

			
 


			?>


			<form action="" method="POST" enctype="multipart/form-data">
				
				<table class="tbl-30">
					<tr> 
						<td>Food Code:</td>
						<td>
							<input type="text" name="food-code" placeholder="Food Code">
						</td>
					</tr>
					<tr>
						<td>Title:</td>
						<td>
							<input type="text" name="title" placeholder="Title of food">
						</td>
					</tr>

					<tr>
						<td>Description: </td>
						<td>
							<textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
						</td>
					</tr>

					<tr>
						<td>Price:</td>
						<td>
							<input type="text" name="price" placeholder="Price">
						</td>
					</tr>

					<tr>
						<td>Select Image: </td>
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
												$id=$row['id'];
												$title=$row['title'];
												?>
													<option value="<?php echo $id; ?>"><?php echo $title; ?></option>
												<?php
											}
										}
										else
										{
											//we donnot have category
											?>
												<option value="0">Henüz Bir kategori Eklemediniz </option>

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
							<input type="radio" name="featured" value="Yes">Yes
							<input type="radio" name="featured" value="No">No
						</td>
					</tr>

					<tr>
						<td>Active:</td>
						<td>
							<input type="radio" name="active" value="Yes">Yes
							<input type="radio" name="active" value="No">No
						</td>
					</tr>

					<tr>
						<td colspan="2">
							<input type="submit" name="submit" value="Add Food" class="btn-secondary">
						</td>
					</tr>
				</table>
			</form>


			<?php 

				if (isset($_POST['submit'])) 
				{
					//Add the food in Database
					echo "cliked";

					//1. Get the data from Form
					$food_code = $_POST['food-code'];
					$title = $_POST['title'];
					$description = $_POST['description'];
					$price	= $_POST['price'];
					$category = $_POST['category'];

					//check Whether radion button for featured and active are checked or not
					if (isset($_POST['featured'])) {
						$featured=$_POST['featured'];
					}
					else
					{
						$featured="No" ; //setting the defauld value
					}

					if (isset($_POST['active'])) {
						$active=$_POST['active'];
					}
					else
					{
						$active="No" ; //setting the defauld value
					}

					// 2.Upload the image if slected
					// Check whether the select image is clicked or not and upload the image only  if the image is slected 
					if (isset($_FILES['image']['name']))////// ***************************************************************************** ************************** * **buradaki if bloğuna giremedik
					{
						//Get the details of the selected image

						$image_name= $_FILES['image']['name'];

						// check İmage selected or not and upload image only upload if  selected

						if ($image_name !="") 
						{ 
							// its main image is selected
							

							//A.Rename the image

							$ext =end(explode(".", $image_name));

							 
							//Create a new name for image

							$image_name="Food-name-".$category."-".rand(0000,9999).".".$ext;

							//B.Upload the image

							//sourch path is the current location of the image 

							$src = $_FILES['image']['tmp_name'];

							//destinetion path for the image to be uploaded 
							$dst= "../images/food/".$image_name;

							//finnaly upload the food image
							$upload = move_uploaded_file($src, $dst);

							//check whether image uploaded or not
							if ($upload==false) 
							{
								//Faild the upload image 	
								//redirect to Add food page with error message
								$_SESSION['upload'] = "<div class='error'> re Yüklenmedi</div>";

									header("location:".SITEURL."admin/manage-food.php");
								//Stop the process
								die();
							}
							else
							{
								//Faild the upload image 	
								//redirect to Add food page with error message
								$_SESSION['upload'] = "<div class='success'>Resim dizine yüklendi</div>";

									//header("location:".SITEURL."admin/manage-food.php");
								//Stop the process	
								//die();
							}


						}
						else
						{
							//Faild the upload image 	
								//redirect to Add food page with error message
								$_SESSION['kontrol'] = "<div class='error'>image-name ye geğer atanmdı ve boş</div>";

									header("location:".SITEURL."admin/manage-food.php");
								//Stop the process	
								
						}

						
					}
					else 
					{
						$image_name=""; //setting defauld value as blank
						$_SESSION['kontrol'] = "<div class='success'> Hataa </div>";

									header("location:".SITEURL."admin/manage-food.php");
								//Stop the process	
								die();
					}

					// 3.Insert  into Database

					//create a sql query to Save or add Food

					$sql2 = "INSERT INTO tbl_food SET
					food_code = '$food_code',
					title ='$title',
					description ='$description',
					price = $price,
					img_name = '$image_name',
					category_id = $category,
					featured = '$featured',
					active = '$active' 
					";

					//execute Query

					$res2 = mysqli_query($conn, $sql2);
					//CHeck whether Data inserted or not
					if ($res2==true) 
					{
						//Data insert the succsessfly

						$_SESSION['add'] = "<div class='success'> Data is Successfly added to Database</div>";
						header("location:".SITEURL."admin/manage-food.php");

					}
					else
					{
						//Data not inserted
						$_SESSION['add'] = "<div class='error'> Failed added food </div>";
						header("location:".SITEURL."admin/manage-food.php");

					}

						// 4. redirect with message to Mange Food page


				}

			 ?>


		</div>
	</div>

<?php include('partials/footer.php'); ?>