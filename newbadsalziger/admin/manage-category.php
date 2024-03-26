<?php include('partials/menu.php'); ?>
	<div class="main-content">
		<div class="wrapper">
			<h1>Manage Category</h1>
			<br><br><br>

			<?php 

				if (isset($_SESSION['failed-remove'])) 
				{
					echo $_SESSION['failed-remove'];
					unset($_SESSION['failed-remove']);				
				}

				if (isset($_SESSION['add'])) 
				{
					echo $_SESSION['add'];
					unset($_SESSION['add']);
				}

				if (isset($_SESSION['delete'])) 
				{
					echo $_SESSION['delete'];
					unset($_SESSION['delete']);				
				} 

				if (isset($_SESSION['remove'])) 
				{
					echo $_SESSION['remove'];
					unset($_SESSION['remove']);				
				}

				if (isset($_SESSION['no-category-found'])) 
				{
					echo $_SESSION['no-category-found'];
					unset($_SESSION['no-category-found']);				
				}

				if (isset($_SESSION['update'])) 
				{
					echo $_SESSION['update'];
					unset($_SESSION['update']);				
				}

				if (isset($_SESSION['upload'])) 
				{
					echo $_SESSION['upload'];
					unset($_SESSION['upload']);				
				}

				

			 ?>
			 <br><br>
			<a href="add-category.php" class="btn-primary">Add Catagory</a>
			<br /><br /><br />

<!--Toblomuzun başladığı yer ********************************************************************************************-->			
		<table class="tbl-full">
			<tr>
				<th>S.N.</th> 
				<th>Image</th>
				<th>Title</th>
				<th>Feature/Active</th> 
				<th>Actions</th> 
			</tr>

			<?php 

				$sql ="SELECT * FROM tbl_category";
				$res =mysqli_query($conn, $sql);

				if ($res==true) 
				{
					$count=mysqli_num_rows($res);

					if ($count>0) 
					{

						$sn = 1 ;
						while ($rows=mysqli_fetch_assoc($res)) 
						{
							$id= $rows["id"];
							$title =$rows["title"];
							$image_name=$rows["image_name"];
							$featured=$rows["featured"];
							$active=$rows["active"];

							
						
					
				 
			 ?>



			<tr>
				<td><?php echo $sn; ?></td>
				<td> 
					<?php 

						if ($image_name != "") 
						{
					?>
							<img src="../images/category/<?php echo $image_name; ?>" width="100px"  >  
					<?php					
						}
						else
						{
							echo "<div class='error'>No image</div>";
						}

					?>
					
				</td>
				<td><?php echo $title; ?></td>				
				<td><?php echo $featured."/".$active; ?></td> 
				<td>
				<a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary" >Kategoryi Güncelle</a>
				<a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-dangery" >Kategoryi Sil</a>
				</td> 
			</tr>

		<?php $sn = $sn+1; } }}

		?>
			<tr></tr>
			<tr></tr> 
			<tr>
				
			</tr> 
			
		</table>
<!--Toblomuzun Bittiği yer ********************************************************************************************-->		


		</div>
	</div> 

<?php include('partials/footer.php'); ?>