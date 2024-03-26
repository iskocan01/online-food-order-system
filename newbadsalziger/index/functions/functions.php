<?php 
/**
 * 
 */
class connectData 
{	
	protected $db; // Eğer veritabanı bağlantısı kullanacaksanız
	
	 public function __construct($db) {
	
		$this->db = $db;
	}
	    // Veritabanı bağlantısını döndüren bir metod ekleyebilirsiniz.
    public function db() {
        return $this->db;
    }
}
	
	/**
	 * food-card
	 * category-cart
	 * modal cart
	 * buttons  
	 * 
	 */
	class CreatedDiv extends connectData
	{
		public function viewFood($food_id){
			$food = $this->db->query("SELECT * FROM tbl_food WHERE id = '$food_id' ")->fetchAll(PDO::FETCH_OBJ);
			return $food[0];
		}



		public function viewProduct($category_id){
			$product = $this->db->query("SELECT * FROM tbl_product WHERE product_category = '$category_id' ")->fetchAll(PDO::FETCH_OBJ);
			return $product;
			print_r($product);
		}

		public function createAddToCardBtn($food_id){
			$food = $this->viewFood($food_id);

			$category_id = $food->category_id;
			$products = $this->viewProduct($category_id);
			echo "<pre>";
			//print_r($products);
			echo "</pre>";

			$count_product = count($products);
			 

 		 	if ($count_product <= 0) {
 		 		?>
 		 			<button   type="button" class="btn btn-success btn-block addToCartBtn" role="button"   product-id="<?php echo $food->id ;?>">
 		 				<i class="fa-solid fa-square-plus"></i>	In den Warenkorb
					</button>
 		 		<?php 		 		
 		 	}
 		 	else{
				?>

				<button class="btn btn-success " data-bs-toggle='modal' data-bs-target='#addToCard<?php echo $food->id; ?>'><i class="fa-solid fa-square-plus"></i> Optionen</button>

				<!--Modal Başlangıcıdır -->
				<div class="modal fade modal-options " id="addToCard<?php echo $food->id; ?>" tabindex = "-1"  role="dialog" >
					<div class="modal-dialog">
						<div class="modal-content bg-dark">
							<div class="modal-header">
								<h2><?php echo $food->title; ?></h2>
								<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
							</div>
							<div class="modal-body">
								<?php 
	                                            if ($food->category_id == 59 ) {
	                                                // code...
	                                                ?>
	                                                <u>Ihre Fleischsorte</u>

	                                                    <div class="form-check">
	                                                      <input class="form-check-input" type="radio" name="meat<?php echo $food->id; ?>" value="hahnchenfleisch" id="flexRadioDefault1" checked >
	                                                      <label class="form-check-label" for="flexRadioDefault1">
	                                                        mit Hahnchenfleisch
	                                                      </label>
	                                                    </div>

	                                                    <div class="form-check">
	                                                      <input class="form-check-input" type="radio" name="meat<?php echo $food->id; ?>" value="kalbsfleisch" id="flexRadioDefault2">
	                                                      <label class="form-check-label" for="flexRadioDefault2">
	                                                        mit Kalbsfleisch
	                                                      </label>
	                                                    </div>
	                                                  
	                                                    <hr>

	                                                   

	                                                <?php
	                                            }

									if ($count_product > 0) {
										echo "<u>Ihre Extras</u>   ";
									 	foreach($products as  $product_key){
									 	 
						                 	?>
						                    <div class="form-check">
							                    <input class="form-check-input" type="checkbox" name="product" value="<?php echo $product_key->id; ?>" id="flexCheckDefault">
							                    <label class="form-check-label" for="flexCheckDefault">
							                    	mit <?php echo $product_key->product_name."  (+".$product_key->product_price ." €)"; ?> 
							                    </label>
						                    </div>
						                    <?php
						                    }				
									}

								 ?>
							</div>
							<div class="modal-footer">
								<button   type="button" class="btn btn-success btn-block addToCartBtn" role="button"   product-id="<?php echo $food->id ;?>">
			 		 				<i class="fa-solid fa-square-plus"></i>	In den Warenkorb
								</button>
							</div>
						</div>
					</div>
				</div>

				<!--Modal Bitişidir -->
				
				<?php
 		 	}



		}



		  public function createInfoBtn($food_id) {
		  	$food = $this->viewFood($food_id);
		  	 
	        ?>
	        <button class='btn btn-primary float-end' data-bs-toggle='modal' data-bs-target='#foodModalInfo<?= $food_id ?>'><i class="fa-solid fa-info"> </i></button>

	        <div class="modal fade modal-xl modal-info " id="foodModalInfo<?= $food_id ?>" tabindex="-1" role="dialog" aria-labelledby="foodModalLabel<?= $food_id ?>" aria-hidden="false">
	            <div class="modal-dialog " >
	                <div class="modal-content bg-dark">
	                    <div class="modal-header">
	                        <h5 class="modal-title" id="foodModalLabel<?php echo $food_id ;?>"><?php echo $food->title ?></h5>
	                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
	                            <span aria-hidden="true">&times;</span>
	                        </button>
	                    </div>
	                    <div class="modal-body">
	                    	<div class="card mb-3" >
							  <div class="row g-0">
							  	<div class="col-md-4">
								  	<?php if (!$food->img_name) {

								  		?><img src="<?php echo SITEURL; ?>images/noimage.jpg" class="img-fluid rounded-start" alt="..."><?php
								  	}else{
								  		?> <img src="<?php echo SITEURL."images/food/".$food->img_name; ?>" class="img-fluid rounded-start" alt="..."><?php
								  	}?>
								    
							     
							    </div>
							    <div class="col-md-8">
							      <div class="card-body">
							        <h5 class="card-title"><?php echo $food->title; ?></h5>
							        <p class="card-text"><?php echo $food->description; ?></p>
							        <!-- <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p> -->
							        <?php $this->createCommentSection($food_id); ?>
							      </div>
							    </div>
							  </div>
							</div> 
	                    </div>
	                    <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
					        <?php $this->createAddToCardBtn($food_id); ?> 

					        
				 
					       


					      </div>
	                </div>
	            </div>
	        </div>
	        <?php
	    }

	    public function createCategoryCard($category){
	    		

	    	?>

 



	    		<div class="col-6 col-lg-3">

	    			<button type="button " data-bs-toggle="modal" data-bs-target="#category-<?php echo $category->id; ?>">
	    				 <div class="category">
					        <img src="<?php echo SITEURL."images/category/". $category->image_name;  ?>" alt="Kategori 1">
					        <div class="category-title ">
					          <h2><?php echo $category->title; ?></h2>
					        </div>
					        <div class="category-count">
								<?php 
									$count_food = $this->db->query("SELECT COUNT(*) as row_count FROM tbl_food WHERE category_id = '$category->id' ",PDO::FETCH_OBJ)->fetch();
									 
									 
								?>
					          <p>Toplam <b class="text-danger "><?php echo $count_food->row_count; ?></b> adet Ürün</p>
					        </div>
					      </div> 
	    			</button>

	    			<!-- Modal new -->
	    			<div class="modal fade " id="category-<?php echo $category->id; ?>"  data-bs-keyboard="false" tabindex="-1"   >
	    				<div class="modal-dialog">
	    					<div class="modal-content">
	    						<div class="modal-header">
	    							<h1>başlık</h1>
				    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

	    						</div>
	    						<div class="modal-body">
	    							<?php 

				    					$foods = $this->db->query("SELECT * FROM tbl_food WHERE category_id = '$category->id' ",PDO::FETCH_OBJ)->fetchAll();
				    					foreach ($foods as $food ) {
				    						$this->createFoodCardForModal($food->id);
				    					}
	    							 ?>
	    						</div>
	    						<div class="modal-footer">
	    							burası footer
	    						</div>
	    					</div>
	    				</div>
	    			</div>










	    			<a href="#"  type="button"  data-bs-toggle="modal" data-bs-target="#category<?php echo $category->id; ?>"> 
	    				  
	    			
	    				  <div class="category">
					        <img src="<?php echo SITEURL."images/category/". $category->image_name;  ?>" alt="Kategori 1">
					        <div class="category-title ">
					          <h2><?php echo $category->title; ?></h2>
					        </div>
					        <div class="category-count">
								<?php 
									$count_food = $this->db->query("SELECT COUNT(*) as row_count FROM tbl_food WHERE category_id = '$category->id' ",PDO::FETCH_OBJ)->fetch();
									 
									 
								?>
					          <p>Toplam <b class="text-danger "><?php echo $count_food->row_count; ?></b> adet Ürün</p>
					        </div>
					      </div>
	    			</a>
	    		</div>
	    		 


	    		<!--Modall -->
	    			    <div class="modal fade " id="category<?php echo $category->id; ?>"   data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="false" >
				    	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable   modal-xl">
				    		<div class="modal-content" style="background-color: #222327">
				    			<div class="modal-header">
				    				<h5 class=""> <?php echo $category->title; ?> </h5>
				    				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				    			</div>
				    			<div class="modal-body  " style="margin:0;padding: 0;">
				    				<div class="">
				    				<?php
				    				  
				    					$foods = $this->db->query("SELECT * FROM tbl_food WHERE category_id = '$category->id' ",PDO::FETCH_OBJ)->fetchAll();
				    					foreach ($foods as $food ) {
				    						$this->createFoodCardForModal($food->id);
				    					}
				    					
				    				 ?>
				    					
				    				</div>
				    			</div>
				    		</div>
				    	</div>
				    </div>
 
	    	<?php 
	    }



	    public function createCommentButton($food_id){
	    	?>
		    		<!-- Button trigger modal -->
			<a type="button" class="" data-bs-toggle="modal" data-bs-target="#commentFor<?php echo $food_id; ?>">
			  Kommentare
			</a>



			<!-- Modal -->
			<div class="modal modal-comment fade" id="commentFor<?php echo $food_id; ?>" tabindex="-1" aria-labelledby="staticBackdropLabel<?php echo $food_id; ?>" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h1 class="modal-title fs-5" id="staticBackdropLabel<?php echo $food_id; ?>">Kommentare</h1>
			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			      </div>
			      <div class="modal-body">
			        Burada Yemeğe ait Yorumlar
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			         
			      </div>
			    </div>
			  </div>
			</div>
	    		 
	    	<?php
	    	return true;
	    }

	    public	function createCommentSection($food_id){
	    	?>
	    		<div class="rating  ">
					<i class="fas fa-star"></i>
					<i class="fa-regular fa-star-half-stroke"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					
					<i class="fa-regular fa-star"></i>
					 
					<span><?php $this->createCommentButton($food_id); ?></span>
				</div>
	    	<?php
	    }

		 public function createFoodCard($food_id){
		 	$food = $this->viewFood($food_id);
		 	?>
		 		<div class="food-card border col-lg-6">
					<div class="row">
						<div class=" col-4   image">
							<?php if ($food->img_name == "" || $food->img_name == null) {
								?>
								<img src="<?php echo SITEURL.'images/noimage.jpg'; ?>" alt="badsalzing kabab döner">
								<?php
							}
							else 
							{ 
								?>
								<img src="<?php echo SITEURL.'images/food/'.$food->img_name; ?>" alt="<?php echo $food->title ;?>">
				 				<?php 
				 			}
				 				 ?>
						</div>

						<div class="col-8  ">
							<div class="content  ">
									<h5 class="title  "><?php echo $food->title; ?></h5>
									<p class="description  "><?php echo $food->description; ?></p>
									<?php $this->createCommentSection($food_id); ?>
									<p class="price  ">Price: € <?php echo $food->price; ?></p>
									
								</div>
						</div>
						<div class="col-12 mt-1">
						 
							<?php echo $this->createAddToCardBtn($food->id); ?>
							<?php echo $this->createInfoBtn($food->id); ?>
						</div>				
					</div>
				</div>
		 	<?php
		 	return true;
		 }

		 public function createFoodCardForModal($food_id){
		 	$food = $this->viewFood($food_id);
		 	 
		 	?>
		 		<div class="food-card col-12">
					<div class="row">
						<div class=" col-4   image">
							<?php if ($food->img_name == "" || $food->img_name == null) {
								?>
								<img src="<?php echo SITEURL.'images/noimage.jpg'; ?>" alt="badsalzing kabab döner">
								<?php
							}
							else 
							{ 
								?>
								<img src="<?php echo SITEURL.'images/food/'.$food->img_name; ?>" alt="<?php echo $food->title ;?>">
				 				<?php 
				 			}
				 				 ?>
						</div>

						<div class="col-8  ">
							<div class="content  ">
									<h5 class="title  "><?php echo $food->title; ?></h5>
									<p class="description  "><?php echo $food->description; ?></p>
									<?php $this->createCommentSection($food_id); ?>
									<p class="price  ">Price: € <?php echo $food->price; ?></p>
									
								</div>
						</div>
						<div class="col-12 mt-1">
						 
							<?php echo $this->createAddToCardBtn($food->id); ?>
							<?php echo $this->createInfoBtn($food->id); ?>
						</div>				
					</div>
				</div>
		 	<?php
		 	return true;
		 }
	}
		
 ?>