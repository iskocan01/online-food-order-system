<?php 
	include("partials-front/menu.php"); 
	require_once("functions/functions.php");

	$createDiv  = new CreatedDiv($db);

	
?>

 
 

	<style>
		.food-card{
			
			padding: 10px 20px ;
			margin-top: 28px;

		}

		.food-card .row {

			box-shadow: 15px 15px 40px red;
			border-bottom: 2px solid red ;
			border-right: 2px solid red;
			padding-bottom: 15px;
		}
/*
		.food-card .row .image::after{
			content: "";
			width: 50px;
			height: 50px;
			position: absolute;
			border-top-left-radius: 20px;
			background: transparent;
			box-shadow: -15px -15px 15px yellow;
			left: 5px;
			top: -2px;
		}
*/		
		.image {
			 
		        display: flex;
		    justify-content: center;
		    align-items: center;
		    height: 100%; /* Div'in yüksekliğini 100% olarak ayarla */
		}
		.image{
		 margin-top: 15px;
		
		}
		.image img{
		     max-width: 150px; 
   			object-fit: cover; /* Resmi içinde koru ve boşlukları oluştur */	
   			z-index: 	99;
   			border: 6px solid white	;
   			border-bottom-left-radius: 20px;
   			border-top-left-radius: 20px;
   			border-bottom-right-radius: 20px;
   		}


   		 
 
 
   		.content h5{ 
   			margin-left: 	-85px;
			margin-top: 15px;
   			background: white;
   			display: inline-block;
   			color: black;
   			width: 80%;
   			padding: 0 0 5px 85px ;
   			border-bottom-right-radius: 20px;
   			border-top-right-radius: 20px;
   		}
   		.content .description{
   			margin-bottom: 0;
   			color: 	#f5f5f5		;
   		}
   		.content .rating{
   			 
   		}

   		@media screen and (max-width: 600px) {
		  body {
		    font-size: 14px;
		  }
		  .content h5{
		  	font-size: 25px;
		  	width: 130%;
		  }
		  	.image img{
		     max-width: 125px; 
   			 
   		}

		}
   	 

   	 
	</style>

 
	<?php 

		
       unset($_SESSION['deliveryOption']);  

	 ?>

 
	
<div class="container   mt-5">
	<div class="row">
		<?php 
			 $foods = $db->query("SELECT * FROM tbl_food WHERE active = 'Yes' ORDER BY CAST(SUBSTRING_INDEX(food_code, ' ', 1) AS UNSIGNED), SUBSTRING(food_code, LOCATE(' ',food_code)+1);  ",PDO::FETCH_OBJ)->fetchAll();

			foreach ($foods as $food) {
				 
				$createDiv->createFoodCard($food->id);
			 
				?>
				 
				
						<!-- Modal başlangıcı-->

                            <div class="modal fade" id="exampleModal<?php echo $food->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $food->id;?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel<?php echo $food->id;?>">Passen Sie Ihre Mahlzeit an</h1>
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

                                            ?>



                                        <?php
                                        $products = $db->query("SELECT  * FROM tbl_product WHERE product_category= '$food->category_id' ",PDO::FETCH_OBJ)->fetchAll();
                                        if(count($products)>0){


                                            $i = 0;
                                             echo "<u>Ihre Extras</u>   ";
                                            foreach($products as $product => $product_key){
                                                ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="product" value="<?php echo $product_key->id; ?>" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        mit <?php echo $product_key->product_name."  (+".$product_key->product_price ." €)"; ?> 
                                                    </label>
                                                </div>
                                                <?php 
                                                $i++;
                                                 if ($i >= 5) break; // İlk 4 ürünü gösterdik
                                            }if (count($products) > 3) {
                                                // Tümünü göster butonunu ekle
                                                echo '<button class="btn btn-link" onclick="showAllProducts(this)">Weitere '.count($products).' anzeigen </button>';
                                                // Tüm ürünleri gizli olarak ekle
                                                echo '<div class="all-products d-none">';
                                                foreach($products as $product => $product_key){
                                                    if ($i > 0) {
                                                        $i--;
                                                        continue;
                                                    }
                                                   ?>
                                                     <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="product" value="<?php echo $product_key->id; ?>" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            mit <?php echo $product_key->product_name."  (+".$product_key->product_price ." €)"; ?> 
                                                        </label>
                                                    </div>
                                                   <?php
                                                }
                                                echo '</div>';
                                            }


                                        }else{
                                            echo "Jetzt in den Warenkorb legen";
                                        } 
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                        <button   type="button" class="btn btn-success btn-block addToCartBtn" role="button"   product-id="<?php echo $food->id ;?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                                 </svg>  
                                                       In den Warenkorb
                                    </button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                        <!--Modal bitişidir   -->

				<?php
				
			}
		 ?>
		 
	 
	</div>
</div>


<br><br><br> 




 
 
				
			 

<?php include("partials-front/footer.php"); ?>

