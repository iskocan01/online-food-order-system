<?php include ("partials-front/menu.php"); 
		require_once("functions/functions.php");
?>
	
	<?php
	if(isset($_GET['category-id'])){

		$createDiv = new CreatedDiv($db);
		$category_id = $_GET['category-id'];

		$foods = $db->query("SELECT id FROM tbl_food WHERE category_id = '$category_id' ",PDO::FETCH_OBJ)->fetchAll();
		?>
			<div class="container mt-5">
				<div class="row">
					<div class="category-title">
						<h1>Category title</h1>
					</div>
					
					<?php 
						foreach ($foods as $food) {
							$createDiv->createFoodCard($food->id);
						}
					 ?>
				</div>
			</div>
		<?php
		
		 	
	} 

	 ?>

<?php include ("partials-front/footer.php"); ?>