<?php include("partials/menu.php"); ?>
<?php  require_once("partials/getData/getData.php"); ?>

<?php 
	
	$cart = new cartData();
	$getFood = new foodData();
	$getCust = new customerData();
	$changeOrderStatus = new orderStatus();

	
	if (isset($_GET['sepet_id'])) {//eğer sepet id get edildiyse
		$cart_id = $_GET['sepet_id']; 
		$foods = $cart->getAllCart($cart_id, $db);//sipariş bilgilerinin tamamamını aldık
		$sn=0;
		$customer_id = $foods[0]->customer_id;//müsteri id sini aldık
		$info_cust = $getCust->getCustomerAllInformation($customer_id, $db);//müşterinin mütün bilgilerinin aldık

		//test ve görüntü kodları
		//$test = $changeOrderStatus->orderStatusUpdate($cart_id, $db);/// bu kodu burda unuttum ve her severin de neden çalışıyor diye düşünüyorum
		
		
		echo "<pre>";
		 
		echo "</pre>";
		if(isset($_SESSION["process"])){
			echo $_SESSION["process"];
			unset($_SESSION["process"]);
		}

	}
 ?>


<div class="container  my-5">
	<div class="row">
		<h2 class="text-center">Sipariş Detay</h2>
	</div>
	<div class="row border my-light-color my-4 p-3  rounded-4 shadow-lg">
	<div class="row  ">
		<div class="col-5  ">
			<div class="row"><h2 class="text-center"><?php echo strtoupper($info_cust->customer_full_name); ?></h2></div>
			<div class="row"><p class=" "><?php echo $info_cust->customer_number; ?></p></div>
			<div class="row"><p class=" "><?php echo $info_cust->customer_email; ?></p></div>

		</div> 
		<div class="col-2  "></div>

		<div class="col-5  ">
			<div class="row"><h1 class="text-center bold text-danger"><strong><?php echo strtoupper($foods[0]->order_type); ?></strong></h1> </div>
			<p><?php echo $foods[0]->order_status;?></p>

			<?php if ($foods[0]->order_type =="take-away")://eğer sipariş gell olarak verildiyde müşterinin adres bilgilerini almaya gerek yokk ?> 			
			<div class="row">
				<div class="col-3  "> <strong> Adress</strong></div>
				<div class="col-9  ">--------</div>
			</div>
			<div class="row">

				<div class="col-3  "><strong>Mahalle</strong> </div>
				<div class="col-9  ">--------</div> 		
			</div>
				<?php else: ///*********************************Burada sipariş gel al olarak verilmedi ve müşteri adres bilgisini cekelim */ ?>
			<div class="row">
				<div class="col-3 "><strong> Adress</strong> </div>
				<div class="col-9 "><?php echo $info_cust->customer_address; ?></div>
			</div>
			<div class="row">

				<div class="col-3 "><strong>Mahalle</strong></div>
				<div class="col-9 "><?php echo $info_cust->customer_mahalle; ?></div> 		
			</div>				 
				<?php endif//***************************************************************** if in bitişi */ ?>


			<div class="row "><h6 class="text-end"> <?php echo date("H:i:s", strtotime($foods[0]->order_date)); ?></h6></div>
		</div> 
	</div>
	</div>
	<div class="row p-4  rounded-4 shadow-lg">
		<!-- Siparişi iptal edeceğiz Yoksa yazdıracakmıyız kutusu burada -->
		<div class="row   p-4 " > 
			<div class="col-6">
				<?php if($foods[0]->order_status != 'iptal' && $foods[0]->order_status != 'teslim' ) {?>
					<a class="text-start  text-danger" href="<?php echo SITEURL; ?>admin/partials/islem/islem.php?p=iptal&x=<?php echo $cart_id; ?>"> 
						<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-x-circle-fill" viewBox="0 0 16 16">
							<path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
						</svg> 
					</a>
				<?php } ?>
			</div>
			<div class="col-6 text-end">



				 <button class="btn btn-primary" onclick="openPdfModal()">PDF Göster</button>


				 <div id="pdfModal" class="modal">
			        <div class="modal-content">
			            <span class="close" onclick="closePdfModal()">&times;</span>
			            <!-- PDF'nin gösterileceği alan -->
			            <iframe id="pdfFrame" width="100%" height="600px"></iframe>
			        </div>
			    </div>


			    <script>

					// Modalı açma fonksiyonu
					function openPdfModal() {
					    var modal = document.getElementById("pdfModal");
					    modal.style.display = "block";

					    // PDF dosyasının URL'sini belirtin (generate_pdf.php dosyasını kendi projenize uygun olarak değiştirin)
					    var pdfUrl = "print.php?cart_id=87";

					    // PDF'yi iframe içinde gösterin
					    document.getElementById("pdfFrame").src = pdfUrl;
					}

					// Modalı kapatma fonksiyonu
					function closePdfModal() {
					    var modal = document.getElementById("pdfModal");
					    modal.style.display = "none";

					    // PDF iframe'ini sıfırlayın
					    document.getElementById("pdfFrame").src = "";
					}

				</script>









				<a class="  " href="<?php echo SITEURL; ?>admin/print.php?cart_id=<?php echo $cart_id; ?>" >
					<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-printer-fill " viewBox="0 0 16 16">
					<path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
					<path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
					</svg> 
				</a>
			</div>
		</div>
		<table class="table table-striped border table-hover rounded-4 shadow-lg">
  			<tr>
  				<th>Food Code</th>
  				<th>Title</th>
  				<th>Price</th> 
				<th>Extralar </th>	
  				<th>Note</th>
  				<th>Total</th>

  				
  			</tr>

  			<?php foreach ($foods as $food) {//tablo için for döngüsünün başladığı  yer burasııııı
  				
  			 ?>
  			<tr>
  				<td><?php   echo $food->qty." X";?></td>
  				<td>
  					<?php 
  						 
  						 echo $getFood->getFoodName($food->food_id ,$db)->title." (#".$getFood->getFood($food->food_id ,$db)[0]->food_code .")";
  						
  					 ?>
  				</td>
  				<td>€  <?php   echo $food->price; ?></td>
  				 
				<td>
					<?php 
						if($food->extra_name != "" ){
							$str = explode(",", $food->extra_name);
							foreach($str as $val){
								$product = $db->query("SELECT * FROM tbl_product WHERE id = '$val' ",PDO::FETCH_OBJ)->fetchAll();
								echo $product[0]->product_name."(+".$product[0]->product_price."), ";
							}
						}else{
							echo	"______";
						}

					?>
				</td>
  				<td> <?php echo $food->food_note; ?></td>
  				<td>€ <?php echo $food->total_price ;?></td>
  			</tr>

  		<?php } //Burası foreachdöngüsünün bittiği parantez    ?>

				<?php if($foods[0]->order_note != "" ){  ?>
				<tr>
					<td  colspan="2"> <h5 class="text-center"><b> Müşteri notu </b></h5> </td>
					<td></td>
					<td></td>
					<td colspan="2"><?php echo $foods[0]->order_note; ?></td>
				</tr>
				<?php } ?>



  		<?php //indirimin hesaplandığı yer burası buradan sonra indirimleri ve tablonun alt bölümü yapılacaktır..

		$order_date = new DateTime($foods[0]->order_date);
		
		$formatted_date = $order_date->format('Y/m/d');
		echo "Sipariş Tarihi = ". $formatted_date;

		$compare_date = new DateTime('2023-06-01');
		$servis =0;
		if ($order_date < $compare_date) {
    		// Eğer sipariş tarihi 1 Haziran 2023'ten önce ise bu blok çalışır eski kanpanya burada olacak*********************
			if ($foods[0]->order_type =="take-away" || $foods[0]->order_type =="service"){ ///Burada bir indirim adında bir  ?>
				<tr>
					<td colspan="4">
						<strong><p class="text-center text-danger bold">Gel Al siparişi Her ürün için € 1 indirim uygulanıyor</p></strong>
					</td>
					<td>
						<i>İndirim tutarı : </i>
					</td>
					<td>
						<?php $indirim = -($cart->getCountCart($cart_id, $db)); ?>
						€ <?php echo $indirim; ?>
					</td>

				</tr>
			<?php }
			elseif($foods[0]->order_type =="delivery" ){ ?>

				<tr>
					<td colspan="4">
						<p class="text-center text-danger bold"><strong><?php echo $info_cust->customer_mahalle ?></strong> Servis Ücretidir</p>
					</td>
					<td>
						<i>Servis Ücreti : </i>
					</td>
					<td>
					<?php
						$mahalle = $info_cust->customer_mahalle;
							if($mahalle =="bad-salzig"){
								$indirim = 1.50;
							}elseif($mahalle == "spay"){
								$indirim = 3;
							}else{
								$indirim= 2.5;
							}




							
						?>
						€ +<?php echo $indirim; ?>
					</td>

				</tr>				


			
			<?php } 

		} else {
			// Eğer sipariş tarihi 1 Haziran 2023'ten sonra veya aynı günse bu blok çalışır Yeni kanpanya****************
			
			// Şu anki tarihi al
			$indirim = 0;
			
 			$day = $order_date->format('l');// buraya hangi günde olduğumuzu yazalım  
			echo "<br>sipariş günü =".$day;


			if ($day == 'Wednesday') {//Mittwoch Nudel tag
			  	foreach($foods as $food){ 
					$food_id= $food->food_id;
					$ca_id =  $getFood->getFoodCategoryId($food_id, $db)[0]->category_id;
					if($ca_id == 62){//buradaki  idi no nudela aittir
						$indirim--;
					}
				}
			}
			// Pizza günü
			elseif ($day == 'Friday') { //Cuma günü freitag schnitzel günü
				 foreach($foods as $food){ 
					$food_id= $food->food_id;
					$ca_id =  $getFood->getFoodCategoryId($food_id, $db)[0]->category_id;
					if($ca_id == 64){//buradaki  idi no Schnitzele aittir
						$indirim--;
					}
				} 
			}

			elseif($day == 'Thursday'){// dienstag donerGünü 
				foreach($foods as $food){ 
					$food_id= $food->food_id;
					$ca_id =  $getFood->getFoodCategoryId($food_id, $db)[0]->category_id;
					if($ca_id == 59){//buradaki  idi no türkishe gresihe aittir
						$indirim--;
					}
				} 
			}

			elseif($day == 'Tuesday'){//salı günü Pizzq günü
				foreach($foods as $food){ 
					$food_id= $food->food_id;
					$ca_id =  $getFood->getFoodCategoryId($food_id, $db)[0]->category_id;
					if($ca_id == 57){//buradaki  idi no pizzalara aittir
						$indirim--;
					}
				}	
			}
			// Diğer günler
			else {
				 
			}

			if($foods[0]->order_type =="delivery" ){
				?>
					<tr>
						<td colspan="4">
							<p class="text-center text-danger bold"><strong><?php echo $info_cust->customer_mahalle ?></strong> Servis Ücretidir</p>
						</td>
						<td>
							<i>Servis Ücreti : </i>
						</td>
						<td>
						<?php
							$mahalle = $info_cust->customer_mahalle;
								if($mahalle =="bad-salzig"){
									$servis += 1.50;
								}elseif($mahalle == "spay"){
									$servis += 3;
								}else{
									$servis += 2.5;
								}




								
							?>
							€ +<?php echo $servis; ?>
						</td>

					</tr>	

				<?php 
			}
		}


?>			

			<tr>
					<td colspan="4">
						<strong><p class="text-center text-danger bold">Kampanya indirimi</p></strong>
					</td>
					<td>
						<i>İndirim tutarı : </i>
					</td>
					<td>
						
						€ <?php echo $indirim; ?>
					</td>

				</tr>
  				<td colspan="5">
  					Toplam Tutar :
  				</td>
  				<td>
   					<strong > 
  						 <p class=" ">€ <?php  echo ($cart->getTotalPrice($cart_id, $db))+$indirim + $servis ;?></p>
  					</strong> 					
  				</td>
  			</tr>
  		 
		</table>



 





		<div class="row">
			<div class="col-6"></div>
			<div class="col-6">
				<div class="row m-botton-5">
					 
 					<?php 
 					if ($foods[0]->order_status == "bekliyor...") { 
 						// Onay bekleyen sipariş
 						?>
						
						<div class="col-7">
							
						</div>

						
						<!--Süre secim modalı-->
						<div class="modal fade" id="choosetime" tabindex="-1" aria-labelledby="choosetime"  >
						  	<div class="modal-dialog">
						   		<div class="modal-content"> 

									<div class="modal-body">
									  <h2 class="fs-5">Süre seçiniz</h2>

									  <hr>
									  	<div class="modal-time-select">
										  <ul>
												<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=10&e=<?php echo $info_cust->customer_email;?>"  class = "btn btn5 px-5" >10 dk</a></li>

												<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=20&e=<?php echo $info_cust->customer_email;?>"  class = "btn btn5 px-5" >20 dk</a></li>
												<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=30&e=<?php echo $info_cust->customer_email;?>" class = "btn btn4  px-5" >30 dk</a></li>
												<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=40&e=<?php echo $info_cust->customer_email;?>" class = "btn btn3 px-5" >40 dk</a></li>
												<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=50&e=<?php echo $info_cust->customer_email;?>" class = "btn btn2  px-5" >50 dk</a></li>
												<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=60&e=<?php echo $info_cust->customer_email;?>"  class = "btn btn1  px-5" >60 dk</a></li> 
											</ul>
										</div>

									</div> 
								</div>
							</div>
						</div>
						<!--Süre secim modalı-->
 

						

						<div id="time_div" class="row">
						 	<button type="button" class="btn btn-dangery p-2" data-bs-toggle="modal" data-bs-target="#choosetime">
							  Onayla
							</button>





						<!--
							<ul class="text-end" id ="time">
								
								<li>

									<a href="" class="categories btn btn-dangery  px-5">Onayla</a>
									<div id="categories-li">
										<ul>
											<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=10&e=<?php echo $info_cust->customer_email;?>"  class = "btn btn5 px-5" >10 dk</a></li>
											<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=20&e=<?php echo $info_cust->customer_email;?>"  class = "btn btn5 px-5" >20 dk</a></li>
											<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=30&e=<?php echo $info_cust->customer_email;?>" class = "btn btn4  px-5" >30 dk</a></li>
											<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=40&e=<?php echo $info_cust->customer_email;?>" class = "btn btn3 px-5" >40 dk</a></li>
											<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=50&e=<?php echo $info_cust->customer_email;?>" class = "btn btn2  px-5" >50 dk</a></li>
											<li><a href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>&t=60&e=<?php echo $info_cust->customer_email;?>"  class = "btn btn1  px-5" >60 dk</a></li>
											
											
											
										</ul>
									</div>
								</li>
								
							</ul>

						-->
						</div>



						 <?php
 					}elseif ($foods[0]->order_status == "hazırlanıyor...") {
 						// Hazırlanan sipariş
 						?>
							<a class="text-end" href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>"><div  class="col-3  btn btn-secondary">Yola Çıkar</div></a> <?php
 					}elseif ($foods[0]->order_status == "yolda...") {
 						// yolda
 						?>
						<a class="text-end" href="<?php echo SITEURL ?>admin/partials/islem/islem.php?cart_id=<?php echo	$cart_id;?>">
						<div  class='col-3   btn btn-dangery'>Teslim Et</div>
						</a><?php
 					}elseif ($foods[0]->order_status == "teslim") {
 						// tamamlanmış sipariş ?>
						<div class="row text-success   ">
								<svg  xmlns="http://www.w3.org/2000/svg" width="100" height="120" fill="currentColor" class="bi bi-check-all " viewBox="-25 0 16 16">
									<path d="M8.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L2.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093L8.95 4.992a.252.252 0 0 1 .02-.022zm-.92 5.14.92.92a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 1 0-1.091-1.028L9.477 9.417l-.485-.486-.943 1.179z"/>
								</svg>					
						</div>
							<?php
 					} else{
 						//Veri tabanına kayıt edilirken hata oluştu
 					}


 					 ?>
					
					
					
				</div> 
			</div> 
		</div>
	</div>
</div>


<?php include("partials/footer.php"); ?>