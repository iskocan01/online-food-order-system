<?php include('partials-front/menu.php'); ?>




<?php 
	//burada önce müterinin üye olup olmadığını  kontrol ediyruz giriş yapmamışsa hemen giriş yapması için sign up sayfasına gönderiyoruz.
	if (isset($_POST['submit'])) 
	{

		if (!isset($_SESSION['user'])) 
		{
		
		$_SESSION['no-login-massage'] = "<div class='error text-center'>Sipariş vermek için Lütfen Giriş Yapınız</div>"; 
		//btn basıldı ve kullanıcı girişi yok
		//bu yüzden sayfaya yönlendir 
		header('Location:'.SITEURL.'login-customer.php');
		exit();
		echo "Üye girişi yapmak zorundasınız";  
		}
		else
		{ 
			echo $_SESSION['user'];
			header("location:".SITEURL."siparisi-gonder.php");
		} 
	}
	else 
	{

		
	
	}
	
 


 ?>
 
		 <?php
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

            <div class="container">

          
              

                          <!-- ************************************************************ -->
                        <form action="<?php echo SITEURL; ?>delivery-order.php" method="POST"> 
                        <div class="row border p-4 ">
                        <h2 class="text-center text-dark">Es befinden sich <span class="text-danger"><?php echo $summary["total_count"]; ?></span> Artikel in Ihrem Warenkorb</h2>
                       
                        <?php 

                            if(isset($_SESSION["verification"])){
                                echo $_SESSION["verification"];
                                unset($_SESSION["verification"]);
                            }

                           
                            foreach ($foods as $key => $food) { ?>

                            <div class="col-12 col-md-6 p-3   "> 
                                <div class=" p-3 rounded-3 rounded shadow-lg bg-body-tertiary">
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
                                                <h4><?php echo  $food->title?></h4>
                                                <p class="food-price">€ <?php echo  $food->price; ?></p>
                                                
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
                                                <div class="row ">
                                                     <div class="col-3 ">
                                                        <a href="<?php echo SITEURL; ?>config/cart-db.php?p=decCount&product_id=<?php echo $key; ?>" class=" btn text-danger"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-dash-square" viewBox="0 0 16 16">
                                                        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                                        </svg></a>
                                                      </div> 
                                                    <div class="col-2 "><p class="food-detail"><?php echo  $food->count; ?></p></div>
                                                    <div class="col-3">
                                                        <a href="<?php echo SITEURL; ?>config/cart-db.php?p=incCount&product_id=<?php echo $key; ?>" class="btn  text-success"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-plus-square" viewBox="0 0 16 16">
                                                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                                            </svg></a>
                                                    </div>
                                                    <div class="col-4 rounded-4  bg-success"> <strong><p class="mt-2 text-center">€ <?php echo  $food->total_price?></p></strong></div>
                                                     
                                                </div>   
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="row mt-4 mx-1"> 
                                               <input type="text" placeholder="Notiz hinzufügen" name="<?php echo $key;?>"> 
                                            </div> 
                                    <div class="row mt-2"> 
                                        <div class="col-3">
                                            <!-- Burası ayrıntılar buttonudur -->
                                        <a href="<?php echo SITEURL ; ?>food-detail.php?id=<?php echo $food->id;?>" class="btn btn-warning p-3 mt-3"> 
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                            </svg> 
                                        </a>
                                        </div> 
                                        <div class="col-9">
                                        <button style="weight:100%" type="button" class="btn btn-danger  removeFromCartBtn"   product-id="<?php echo $key ;?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-x" viewBox="0 0 16 16">
                                                <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z"/>
                                              <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                                            </svg>
                                            Aus Warenkorb entfernen
                                        </button>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        <?php } //burası foreach döggüsüünün bittiği yerdir; ?>  
                            <div class="container-fluid   px-3  ">
                                <div class="row ">
                                    <div class="p-3 rounded-5 bg-body-tertiary ">
                                        <h3 class="text-center">Sie haben insgesamt <strong class="text-danger "><?php echo  $summary["total_count"]; ?></strong> Produkte.</h3>
                                       <div class="text-center" style="font-size:30px;">  <b class="text-center">Gesamtpreis : <strong class="text-danger">€ <?php echo $summary["total_price"]; ?></strong></b></div>

                                    </div>
                                </div>
                            </div>
                            

                                <div class="container-fluid border">
                                    <div class="row">
                                        <div class="col-12 col-md-6 border p-3">
                                        <h3 class="text-center">Sie können Ihrer Bestellung eine Notiz hinzufügen.</h3>
                                        <textarea name="note" id=""   style="width:98%; padding:2%;" rows="5" placeholder="Note"></textarea>
                                        </div>
                                        <div  class="col-12 col-md-6 border p-3">
                                            <h3 class="text-center">Wählen Sie Ihre Auftragsart</h3>

                                            <div class="form-check">
                                                <input class="form-check-input" value="delivery" type="radio" name="delivery-type" id="html">
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Liefern
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="take-away" type="radio" name="delivery-type" id="flexRadioDefault2" checked>
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Abholung
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="service" type="radio" name="delivery-type" id="flexRadioDefault3" >
                                                <label class="form-check-label" for="flexRadioDefault3">
                                                    Servis
                                                </label>
                                            </div>
                                            <hr>



                                            <div class="form-check"> 
                                                <input class="form-check-input" value="now" type="radio" name="delivery-time" id="flexRadioDefault4" checked >
                                                <label class="form-check-label" for="flexRadioDefault4">
                                                    Now
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" value="later" type="radio" name="delivery-time" id="flexRadioDefault5" >
                                                <label class="form-check-label" for="flexRadioDefault5">
                                                    Later
                                                </label> 
                                            </div>

                                            <div id="delivery-time-picker" style="display: none;">
                                                <label for="delivery-time-input">Teslim Tarihi ve Saati:</label>
                                                <input type="datetime-local" id="delivery-time-input" name="delivery-time-input"> 
                                            </div>

                                            <script>
                                                const deliveryTimeRadio = document.querySelector('input[name="delivery-time"][value="later"]');
                                                const deliveryTimePicker = document.getElementById('delivery-time-picker');

                                                 

                                                // Radyo düğmelerinin değişiklik olayına abone olun
                                                document.querySelectorAll('input[name="delivery-time"]').forEach((radio) => {
                                                    radio.addEventListener('change', () => {
                                                    // delivery-time-radio değişkenini güncelle
                                                    deliveryTimeRadio.checked = (radio.value === "later");

                                                    // Teslim tarihi seçicisi, radyo düğmesinin durumuna göre gizle veya göster
                                                    if (deliveryTimeRadio.checked) {
                                                        deliveryTimePicker.style.display = 'block';
                                                        

                                                        const now = new Date();
                                                        const minDate = new Date(now.getTime() + (90 * 60000)); // şu andan 90 dakika sonrası
                                                        minDate.setSeconds(0, 0); // saniye ve milisaniyeleri sıfırla
                                                        document.getElementById('delivery-time-input').min = minDate.toISOString().slice(0, 16);

                                                        console.log(minDate);
                                                        
                                                        // ! Buerada- speett kısmına yemeği nezamn isteyeceğini yazıyoruz.
                                                        
                                                    } else {
                                                        deliveryTimePicker.style.display = 'none';
                                                    }
                                                    });
                                                }); 

                                            </script>

                                            <hr>
                                                <!-- ödeme seceneklerinin olduğu yer burası -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_payment" id="kasse" value="kasse" checked>
                                            <label class="form-check-label" for="exampleRadios1">
                                                Kasse
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_payment" id="kredi" value="kredi" disabled>
                                            <label class="form-check-label" for="exampleRadios2">
                                                Kreditkarte
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="delivery_payment" id="paypal" value="paypal" disabled>
                                            <label class="form-check-label" for="exampleRadios3">
                                                Paypal
                                            </label>
                                        </div>




                                        
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
                                ?><h2 class="text-center">Sie haben noch keine Produkte in den Warenkorb gelegt. Zum Hinzufügen <a href="<?php echo SITEURL; ?>foods.php"><b>klicken</b></a></h2><?php 

                            }
                        }else{
                            //sepette ürün yok bilgisi
                            ?><h2 class="text-center">Sie haben noch keine Produkte in den Warenkorb gelegt. Zum Hinzufügen <a href="<?php echo SITEURL; ?>foods.php"><b>klicken</b></a></h2><?php 

                        }
                     ?> 
                                    
                                   
</div>



	 

<?php include('partials-front/footer.php'); ?> 
