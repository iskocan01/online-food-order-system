<?php include("partials-front/menu.php"); ?>

<?php require_once("functions/functions.php"); ?>

<?php 
	$summary["total_price"] = 0.0;
	$summary["total_count"] = 0;

	  $createDiv = new CreatedDiv($db);

	if (isset($_SESSION["cart"])) {
		$foods = $_SESSION['cart']["foods"];
		$summary = $_SESSION['cart']['summary']; 

		if($summary["total_count"]>0){

			if (!isset($_SESSION['deliveryOption'])) {
                                        
                $_SESSION["deliveryOption"] = true; 
                $deliveryOptionChecked = true;
                                         
            }else{
                if ($_SESSION['deliveryOption'] == true) {
                	$deliveryOptionChecked = true;

                }else{
                	$deliveryOptionChecked =false;
                }
            }

            $deliveryOption = $_SESSION['deliveryOption'];



				    if ($_SERVER["REQUEST_METHOD"] == "POST") {
					    // Eğer 'deliveryOption' gönderilmişse ve 'on' ise 'Eve Servis' olarak ayarla
					    if (isset($_POST['deliveryOption']) && $_POST['deliveryOption'] == 'on') {
					        $_SESSION['deliveryOption'] = false;
					        $deliveryOptionChecked = true;
					    } else { // Değilse, 'Gel Al' olarak ayarla
					        $_SESSION['deliveryOption'] = true;
					        $deliveryOptionChecked = false;
					    }
					}



					if ($_SERVER["REQUEST_METHOD"] == "POST") {
					    $deliveryOption = isset($_POST['deliveryOption']) ? true : false;
					    $_SESSION['deliveryOption'] = $deliveryOption;

					    // Test amaçlı ekrana yazdırma
					    echo "Seçilen teslimat seçeneği: " . $_SESSION['deliveryOption'];
					}





			?>

				<form class=""   action="" method="POST" id="deliveryForm">
				    <div class="  container mt-2 d-flex justify-content-center fixed-top">
				        <label class="switch">
				            
				            <input type="checkbox" id="deliverySwitch" name="deliveryOption" <?php echo $deliveryOptionChecked ? 'checked' : ''; ?> onchange="this.form.submit()"> 

				            <span class="slider round">
				                <span class="option eve-servis"><i class="fas fa-home"></i>     Eve Servis
				                </span>
				                <span class="option gel-al"><i class="fas fa-store"></i>
				                    Gel Al
				                </span>
				            </span>
				        </label>
				    </div>

				    <div class="container border">
                            <div class="row m-4"> </div>
				    	<div class="row p-4">

				    		<h2 class="text-center text-secondary">Es befinden sich <span class="text-danger"><?php echo $summary["total_count"]; ?></span> Artikel in Ihrem Warenkorb</h2>
					 	 <?php
					 	  foreach ($foods as $key => $food) { ?>

                            <div class="col-12 col-md-6 p-3 food-card border   " style="font-size: 10px;"> 
                                <div class=" p-3 rounded-3 rounded shadow-lg ">
                                    <div class=" row   ">
                                        <div class="col-4 ">
                                            <?php if ($food->img_name != "") {
                                                ?>
                                                    <img src="<?php echo SITEURL ?>images/food/<?php echo $food->img_name; ?>" alt="<?php echo $food->img_name ?>" width="100%" stylesheet="background-size: cover;">
                                          <!--   <img src="images/burger.jpg" class="img-fluid" alt="">-->
                                                <?php
                                            }else{ ?>
                                            <img src="<?php echo SITEURL ?>images/noimage.jpg" alt="Badsalziger " width="100%" stylesheet="background-size: cover;">
                                              <!--   <img src="images/burger.jpg" class="img-fluid" alt="">-->
                                          <?php } ?>
                                        </div>
                                        <div class="col-8">
                                            <div class="container-fluid">
                                                <h6><?php echo  $food->title?></h6> 
                                                <?php 

                                                if ($food->meat != "") {
                                                     echo "mit ". $food->meat."<br>";
                                                }

                                                if($food->extra == "" || $food->extra == null){
                                                     
                                                }else{
                                                    
                                                    $extra = $food->extra;
                                                    $arr = explode(",", $extra);
                                                     

                                                    foreach($arr as $product){
                                                        $extra_product = $db->query("SELECT * FROM tbl_product WHERE id='$product' ", PDO::FETCH_OBJ)->fetchAll();
                                                        
                                                         $diz=$extra_product[0];
                                                        echo "mit ". $diz->product_name." (".$diz->product_price." € )<br>";
                                                    }
                                                    
                                                }
                                                    
                                                ?>

                                               
									            
                                                <div class=" row">

                                                    <div class="col-6 qtyindec ">
	 													<a href="<?php echo SITEURL; ?>config/cart-db.php?p=decCount&product_id=<?php echo $key; ?>" class="  text-danger">
	 														<i class="fas fa-minus"></i>
	 													</a>
										                <span ><?php echo  $food->count; ?></span>

										                <a href="<?php echo SITEURL; ?>config/cart-db.php?p=incCount&product_id=<?php echo $key; ?>" class="   text-success">
										                	<i class="fas fa-plus"></i>
										                </a>
										                
									            	</div>
									            	
                                                    <div class=" total  text-end"> Gesamtbetrag :  <?php echo " € ".$food->total_price ;?> </div>



                                                      
                                                     
                                                </div>

                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row mt-4 mx-1"> 
                                               <input type="text" class=" form-control" placeholder="Notiz hinzufügen" name="<?php echo $key;?>"> 
                                            </div> 
                                    <div class="row mt-2"> 
                                        <div class="col-3">
                                            <!-- Burası ayrıntılar buttonudur -->
                                            
                                        </div> 
                                        <div class="col-9">
                                        <button style="weight:100%" type="button" class="btn btn-danger  removeFromCartBtn"   product-id="<?php echo $key ;?>">
                                          
                                             <i class="fa fa-trash"></i>

                                            Aus Warenkorb entfernen
                                        </button>
                                        </div>
                                    </div>
                                </div> 
                            </div> 


                          <?php } //burası foreach döggüsüünün bittiği yerdir; ?>  
                        </div>	
					</div>

				</form>



				




				    <?php  





					 ?>

					 






			<?php
		}else{
			echo "ürün yok";
		}
	}else{
		echo "cerez yok";
	}
 ?>

<?php include("partials-front/footer.php"); ?>