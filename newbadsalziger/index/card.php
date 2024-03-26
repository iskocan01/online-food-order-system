<?php include("partials-front/menu.php");
require_once("functions/functions.php");
 ?>

	
	 <?php

            $createDiv = new CreatedDiv($db);
                    $summary["total_price"] = 0.0;
                    $summary["total_count"] = 0;

                        if (isset($_SESSION["cart"])) {
                            $foods = $_SESSION['cart']["foods"];
                            $summary = $_SESSION['cart']['summary'];           
                            if($summary["total_count"]>0){

                                // !burayaa dikkat örneği   
                                // todo : dfslgsdlş
                                // ? enes 
                                // *desd
                                // echo "<pre>"; 
                                // print_r($_SESSION['cart']);
                                // echo "</pre>";
                                  
                                  ?>


                                  <?php 

                                   
                                  if (!isset($_SESSION['deliveryOption'])) {
                                        
                                        $_SESSION["deliveryOption"] = "Gel Al";
                                        
                                        $deliveryOptionChecked = true;
                                         
                                  }else{
                                    if ($_SESSION['deliveryOption'] == "Gel Al") {
                                        $deliveryOptionChecked = true;

                                    }else{
                                        $deliveryOptionChecked =false;
                                    }
                                  }

                                  $deliveryOption = $_SESSION['deliveryOption'];


                                    // Oturumda 'deliveryOption' varsa ve 'Eve Servis' ise, $deliveryOptionChecked'i true yap
/*if (isset($_SESSION['deliveryOption']) && $_SESSION['deliveryOption'] == "Eve Servis") {
    $deliveryOptionChecked = true;
}else{
    $_SESSION['deliveryOption'] = "Gel Al";
    $deliveryOptionChecked = false;
}*/

// POST isteği varsa, 'deliveryOption' kontrol et ve oturumu güncelle
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Eğer 'deliveryOption' gönderilmişse ve 'on' ise 'Eve Servis' olarak ayarla
    if (isset($_POST['deliveryOption']) && $_POST['deliveryOption'] == 'on') {
        $_SESSION['deliveryOption'] = "Eve Servis";
        $deliveryOptionChecked = true;
    } else { // Değilse, 'Gel Al' olarak ayarla
        $_SESSION['deliveryOption'] = "Gel Al";
        $deliveryOptionChecked = false;
    }
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
</form>

 
 

  

<?php  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deliveryOption = isset($_POST['deliveryOption']) ? "Gel Al" : "Eve Servis";
    $_SESSION['deliveryOption'] = $deliveryOption;

    // Test amaçlı ekrana yazdırma
    echo "Seçilen teslimat seçeneği: " . $_SESSION['deliveryOption'];
}
 ?>
 
        <div class="container pt-5">
         
 
                          <!-- ************************************************************ -->
                        <form action="<?php echo SITEURL; ?>delivery-order.php" method="POST"> 
                            <input type="hidden" name="delivery-type" value="<?php $deliveryOption; ?>">
                        <div class="row  p-4 ">
                        <h2 class="text-center text-secondary">Es befinden sich <span class="text-danger"><?php echo $summary["total_count"]; ?></span> Artikel in Ihrem Warenkorb</h2>
                       
                        <?php 

                            if(isset($_SESSION["verification"])){
                                echo $_SESSION["verification"];
                                unset($_SESSION["verification"]);
                            }

                           
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
                                            <?php $createDiv->createInfoBtn($food->id); ?>
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



                            <div class="container-fluid   px-3  ">
                                <div class="row">
                                    <div class="p-3 rounded-5  ">
                                        <h3 class="text-center">Sie haben insgesamt <strong class="text-danger "><?php echo  $summary["total_count"]; ?></strong> Produkte.</h3>
                                       <div class="text-center" style="font-size:30px;">  <b class="text-center">Gesamtpreis : <strong class="text-danger">€ <?php echo $summary["total_price"]; ?></strong></b></div>

                                    </div>
                                </div>
                            </div>

                            <div class="container">
                                <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Şipariş ver
</button>

<!-- Modal -->

<form class="row g-3 needs-validation" novalidate>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl ">
    <div class="modal-content bg-dark">

      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       
          <div class="col-md-4">
            <label for="validationCustom01" class="form-label">First name</label>
            <input type="text" class="form-control" id="validationCustom01" value="Mark" required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationCustom02" class="form-label">Last name</label>
            <input type="text" class="form-control" id="validationCustom02" value="Otto" required>
            <div class="valid-feedback">
              Looks good!
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationCustomUsername" class="form-label">Username</label>
            <div class="input-group has-validation">
              <span class="input-group-text" id="inputGroupPrepend">@</span>
              <input type="text" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
              <div class="invalid-feedback">
                Please choose a username.
              </div>
            </div>
          </div>
          


            <?php if ($deliveryOption == "Gel Al") {
                echo "deliveryOption gel al dır";
            }else{
                ?>
                    <div class="col-md-6">
                        <label for="validationCustom03" class="form-label">City</label>
                        <input type="text" class="form-control" id="validationCustom03" required>
                        <div class="invalid-feedback">
                          Please provide a valid city.
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="validationCustom04" class="form-label">State</label>
                        <select class="form-select" id="validationCustom04" required>
                          <option selected disabled value="">Choose...</option>
                          <option>...</option>
                        </select>
                        <div class="invalid-feedback">
                          Please select a valid state.
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label for="validationCustom05" class="form-label">Zip</label>
                        <input type="text" class="form-control" id="validationCustom05" required>
                        <div class="invalid-feedback">
                          Please provide a valid zip.
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                          <label class="form-check-label" for="invalidCheck">
                            Agree to terms and conditions
                          </label>
                          <div class="invalid-feedback">
                            You must agree before submitting.
                          </div>
                        </div>
                      </div>
                <?php
            } ?>
                     








          <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>

    </div>
  </div>
</div>
  </form>                  
       </div>
 
                           

<br><br><br><br><br><br>
<br><br><br>
<br><br><br>
<br><br><br>

<hr>


                            <div class="container">
                                <?php  ?>
                            </div>
                            
                            <br>
                            <hr>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>

                                <div class="container-fluid  ">
                                    <div class="row">
                                         
                                        <div  class="col-12 col-md-6 border p-3">
                                             

                                             
                                              


  
                                           
 

                                            <hr>
                                                <!-- ödeme seceneklerinin olduğu yer burası -->
                                       
                                       




                                        
                                        </div>
                                    </div>
                                    <div class="row">
                                    <?php if (!isset($_SESSION["user"])){ ?>
                                                <a href="<?php echo SITEURL ?>login-customer.php" class="btn btn-success " style="margin:20px 0;">
                                                    Melden Sie sich an, um zu bestellen
                                                </a> 
                                                  <!-- Burada üye olmadan sipariş verebilsin -->
                                                <input type="submit" name="submit2" value="Ohne Anmeldung bestellen" class="btn btn-danger ">
                                                    
                                                   
                                                 
                                    <?php } else { 	?>
                                                <input type="submit" name="submit" value="Bestellbestätigung" class="btn btn-success">
                                    <?php } ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                         
                                 <!-- * ****************************************************************************** -->              
                     

             

                  <?php  
                            } else{
                                ?>
									<div class="container  ">
									    <div class="row">
									        <div class="col">
									            <!-- Sepet boşsa gösterilecek alan -->
									            <div class="no-products-container"  style="display: flex; justify-content: center; align-items: center; height: 100vh;">
									                <div class="no-products-box" style="text-align: center;padding: 20px; border: 1px solid #ccc; border-radius: 10px; max-width: 400px; width: 100%;">
									                    <i class="fas fa-shopping-cart no-products-icon" style=" font-size: 48px;    color: #d9534f; /* Bootstrap danger color */"></i>
									                    <h2 class="mt-3 mb-4">Sie haben noch keine Produkte in den Warenkorb gelegt.</h2>
									                    <p>Zum Hinzufügen <a href="<?php echo SITEURL; ?>index"><b>klicken</b></a></p>
									                </div>
									            </div>
									        </div>
									    </div>
									</div>                               
					 			<?php 

                            }
                        }else{
                            //sepette ürün yok bilgisi
                             ?>
									<div class="container  ">
									    <div class="row">
									        <div class="col">
									            <!-- Sepet boşsa gösterilecek alan -->
									            <div class="no-products-container"  style="display: flex; justify-content: center; align-items: center; height: 100vh;">
									                <div class="no-products-box" style="text-align: center;padding: 20px; border: 1px solid #ccc; border-radius: 10px; max-width: 400px; width: 100%;">
									                    <i class="fas fa-shopping-cart no-products-icon" style=" font-size: 48px;    color: #d9534f; /* Bootstrap danger color */"></i>
									                    <h2 class="mt-3 mb-4">Sie haben noch keine Produkte in den Warenkorb gelegt.</h2>
									                    <p>Zum Hinzufügen <a href="<?php echo SITEURL; ?>index"><b>klicken</b></a></p>
									                </div>
									            </div>
									        </div>
									    </div>
									</div>                               
					 			<?php 
                        }
                     ?> 
	</div>




<?php include("partials-front/footer.php"); ?>