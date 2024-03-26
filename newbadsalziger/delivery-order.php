<?php include("partials-front/menu.php"); ?>

<?php 

	// // // // // if (isset($_SESSION['user'])) {
	// // // // // 	$customer_id = $_SESSION["user"];
 
	// // // // // }else{
	// // // // // 	header("location:".SITEURL."login-customer.php");
	// // // // // 	die();
	// // // // // }

	$cart_id = $db->query("SELECT cart_id FROM tbl_food_order ORDER BY id DESC LIMIT 1",PDO::FETCH_OBJ)->fetch();
			 
	$cart_id = $cart_id->cart_id + 1;

	if(isset($_SESSION["cart"])){ 
		$foods = $_SESSION["cart"]["foods"];
		$total_price = $_SESSION["cart"]["summary"]; 
	}else{
		// todo burada sepetin boş olduğunu ve ürün eklemesi gerektiği söylemek zorundayız.
		echo "sepet boş ";
		die();
	}


	
	// $order_note = $_POST["note"];
	// $payment_status = $_POST["delivery_payment"];
	// $order_type = $_POST["delivery-type"];

	// if($_POST["delivery-time"]=="now"){
	// $order_date = date("Y-m-d H:i:s");
	// $timed ="no";
	// }elseif($_POST["delivery-time"]=="later"){
	// 	$date_str = $_POST["delivery-time-input"];
	// 	$order_date = new DateTime($date_str);
	// 	$timed="yes";

	// 	$order_date = $order_date->format("Y-m-d H:i:s"); 
	// }

	// foreach($foods as $key => $food){
	// 	// Buradaki her yemeğin notunu o yemeğe ekledik bundan sonra oradan cekeceğiz.
	// 	$food->note = $_POST[$key];
	// }



	if(isset($_POST["submit"])){

		$order_note = $_POST["note"];
		$payment_status = $_POST["delivery_payment"];
		$order_type = $_POST["delivery-type"];

			//Burası üyelik sistemi açık ve customer id hazır
		if (isset($_SESSION['user'])) {
			$customer_id = $_SESSION["user"];
		}else{
			$_SESSION['siparis-durum'] = "<br><h3><div class='error text-center'> Unauthorized entry </div></h3>";
			 header("location:".SITEURL);
			 die();
		} 


		if($_POST["delivery-time"]=="now"){
			$order_date = date("Y-m-d H:i:s");
			$timed ="no";
			}elseif($_POST["delivery-time"]=="later"){
				$date_str = $_POST["delivery-time-input"];
				$order_date = new DateTime($date_str);
				$timed="yes";
		
				$order_date = $order_date->format("Y-m-d H:i:s"); 
			}
		
			foreach($foods as $key => $food){
				// Buradaki her yemeğin notunu o yemeğe ekledik bundan sonra oradan cekeceğiz.
				$food->note = $food->meat.$_POST[$key];
			} 


		// echo "customerid : ".$customer_id."<br>";
		// echo "Sepet id : ".$cart_id."<br>";
		// echo "Seeptin genel notu : ".$order_note."<br>";
		// echo "her Yemek için not :  food->note şeklinde cekeceğiz<br>";
			//echo "yemek"
		// echo "her Yemeğin toplam fitayı :  food->total_price şeklinde cekeceğiz<br>";
		// echo "sipariş ödeme şekli : ". $payment_status."<br>";
		// echo $_POST["delivery-time"]."<br>";
		// echo "Burada siparişin ne zaman olacağıdır : ".$order_date."<br>";
		// echo "Zamanlı siparişmi değilmi : ".$timed."<br>";


		// echo "<pre>";
		// print_r($foods);
		// print_r($total_price);
		// echo "</pre>";




			//Burada eğer kullanıcı giriş yapıpda sipariş verirse vermemesini sağlıyoruz
	
		$customer_verification = $db->query("SELECT customer_verification FROM tbl_customer WHERE id = '$customer_id'", PDO::FETCH_OBJ)->fetchAll();
		$statuvation = $customer_verification[0]->customer_verification;
		echo $statuvation;


		if ($statuvation == "Yes") {
			// kimlik doğrulanmış

		//Burada veri tabanına ekleme işlemi yapılıyorrr.
		foreach($foods as $food => $value){

			 
			$food_id = $value->id;
			$price = $value->price;
			$qty = $value->count;
			$total_price = $value->total_price;
			$food_note = $value->note;
			$extra_name = $value->extra;
			$extra_price = $value->extra_price;
			 

			$send_order = "INSERT INTO tbl_food_order SET
						cart_id = ?,
						customer_id =?,
						food_id = ?, 
						extra_name = ?,
						extra_price = ?,
						price = ?,
						qty = ?,
						order_note = ?,
						food_note = ?,
						total_price = ?,
						order_status = ?,
						payment_status = ?,
						order_type = ?,
						timed = ?,
						order_date = ? 
						"; 
			
			$add_food = $db->prepare($send_order);
			$kontrol= $add_food->execute(array($cart_id,$customer_id,$food_id,$extra_name,$extra_price,$price,$qty,$order_note,$food_note,$total_price,"bekliyor...",$payment_status,$order_type,$timed,$order_date));
	
		}


			if ($kontrol) {
				$_SESSION['siparis-durum'] = "<br><h3><div class='success text-center'> Ihre Bestellung ist eingegangen. Wir senden die Bestelldaten an Ihre E-Mail-Adresse. :):)</div></h3>";
				unset($_SESSION["cart"]);
				include("mail/siparis-var.php");
				header("location:".SITEURL);
				
			}else {
				$_SESSION['siparis-durum'] = "<br><h3><div class='error text-center'>  Sie hatten ein systemisches Problem beim Aufgeben Ihrer Bestellung. :( :(</div></h3>";
				 header("location:".SITEURL);
			}

		}else{
			//kimlik doğrulanmamış
			$_SESSION['siparis-durum'] = "<br><h3><div class='error text-center'> Sie müssen Ihr Konto oder Ihre Bestellung bestätigen, ohne Mitglied zu sein. </div></h3>";
			 header("location:".SITEURL);
			 die();

		}  
	}





 

	if(isset($_POST["submit2"])){

		$order_note = $_POST["note"];
		$payment_status = $_POST["delivery_payment"]; //siparis durumu 
		$order_type = $_POST["delivery-type"];


		if($_POST["delivery-time"]=="now"){
			$order_date = date("Y-m-d H:i:s");
			$timed ="no";
			}elseif($_POST["delivery-time"]=="later"){
				$date_str = $_POST["delivery-time-input"];
				$order_date = new DateTime($date_str);
				$timed="yes";
		
				$order_date = $order_date->format("Y-m-d H:i:s"); 
			}
		
			foreach($foods as $key => $food){
				// Buradaki her yemeğin notunu o yemeğe ekledik bundan sonra oradan cekeceğiz.
				$food->note = $_POST[$key];
			}

	 
 
		// echo "Sepet id : ".$cart_id."<br>";
		// echo "Seeptin genel notu : ".$order_note."<br>";
		// echo "her Yemek için not :  food->note şeklinde cekeceğiz<br>";
		// echo "her Yemeğin toplam fitayı :  food->total_price şeklinde cekeceğiz<br>";
		// echo "sipariş ödeme şekli : ". $payment_status."<br>";
		// echo $_POST["delivery-time"]."<br>";
		// echo "Burada siparişin ne zaman olacağıdır : ".$order_date."<br>";
		// echo "Zamanlı siparişmi değilmi : ".$timed."<br>";


		// echo "<pre>";
		// print_r($foods);
		// print_r($total_price);
		// echo "</pre>";
		?>

		<div class="container">

			<form action="" method="POST" class="row g-3 needs-validation" novalidate>
				<div class="col-md-4">
					<label for="validationCustom01" class="form-label">Vorname Familienname</label>
					<input type="text" class="form-control" id="validationCustom01" name="full-name"   required>
					<div class="valid-feedback">
					sieht gut aus
					</div>
				</div>
				<div class="col-md-4">
					<label for="validationCustom02" class="form-label">Telefonnummer</label>
					<input type="text" class="form-control" name="number" id="validationCustom02"   required>
					<div class="valid-feedback">
					sieht gut aus
					</div>
				</div>
				<div class="col-md-4">
					<label for="validationCustomUsername" class="form-label">E-Mail</label>
					<div class="input-group has-validation">
					<span style="margin:20px 0;" class="input-group-text" id="inputGroupPrepend">@</span>
					<input type="text" class="form-control" name="mail" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
					<div class="invalid-feedback">
						Bitte geben Sie ihre E-Mail-Adresse ein
					</div>
					</div>
				</div>
				<div class="col-md-6">
					<label for="validationCustom03" class="form-label">Adresse</label>
					<input type="text" class="form-control" name="address" id="validationCustom03" required>
					<div class="invalid-feedback">
						Bitte geben Sie eine gültige Adresse an.
					</div>
				</div>
				<div class="col-md-3">
					<label for="validationCustom04" class="form-label">Zustand</label>

					<select class="form-select" style="margin-top: 20px; padding:6px 12px; height:50px; " name="neighborhood" id="validationCustom04" required>
						<option selected disabled value="">Choose...</option>
						<option value="bad-salzig" >Bad Salzig (€ 1.50)</option>
	                	<option value="weiler" >Weiler (€ 2.50)</option>
	                	<option value="hirzenach">Hirzenach (€ 2.50)</option>
	                	<option value="buchenau" >Buchenau (€ 2.50)</option>
	                	<option value="boppard" >Boppard (€ 2.50)</option>
	                	<option value="spay" >Spay (€ 3.00)</option>
	                	<option value="fleckertshöhe" >Fleckertshöhe (€ 2.50)</option>
	                	<option value="rheinbay" >Rheinbay (€ 2.50)</option>
	                	<option value="holzfeld" >Holzfeld (€ 2.50)</option>
	                	<option value="werlau" >Werlau (€ 2.50)</option>
	                	<option value="bibernheim" >Bibernheim (€ 2.50)</option>
	                	<option value="grundelbach" >Grundelbach (€ 2.50)</option>
	                	<option value="fellen">Fellen (€ 2.50)</option>
	                	<option value="st.goar" >St.Goar (€ 2.50)</option>
					</select>
					<div class="invalid-feedback">
					Bitte wählen Sie ein gültiges Bundesland aus
					</div>
				</div>
				<div class="col-md-3">
					<label for="validationCustom05" class="form-label">Zip</label>
					<input type="text" class="form-control" name="zip" id="validationCustom05" required>
					<div class="invalid-feedback">
					Bitte geben Sie eine gültige Postleitzahl an.
					</div>
				</div>
				<div class="col-12">
					<div class="form-check">
					<input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
					<label class="form-check-label" for="invalidCheck">
						Bedingungen zustimmen
					</label>
					<div class="invalid-feedback">
						Sie müssen vor dem Absenden  <a href="<?php echo SITEURL; ?>lib/gizli.php"> zustimmen.</a>
					</div>
					</div>
				</div>
				<div class="col-12">
					<input type="submit" name="submit3" class="btn btn-success" value="Bestellbestätigung">
				</div>
				<input type="hidden" value="<?php echo $timed; ?>" name="timed">
				<input type="hidden" value="<?php echo $payment_status; ?>" name="delivery_payment">
				<input type="hidden" value="<?php echo $order_date; ?>" name="order-date">
				<input type="hidden" value="<?php echo $order_type; ?>" name="delivery-type">
				<input type="hidden" value="<?php echo $order_note; ?>" name="note" > 
			</form>
		</div>

			<script>
				(() => {
					'use strict'

					// Fetch all the forms we want to apply custom Bootstrap validation styles to
					const forms = document.querySelectorAll('.needs-validation')

					// Loop over them and prevent submission
					Array.from(forms).forEach(form => {
						form.addEventListener('submit', event => {
						if (!form.checkValidity()) {
							event.preventDefault()
							event.stopPropagation()
						}

						form.classList.add('was-validated')
						}, false)
					})
					})()
					var numaraInput = document.getElementById("validationCustom02");

					numaraInput.addEventListener("input", function(event) {
					var value = event.target.value;
					var valueOnlyNumbers = value.replace(/[^0-9]/g, '');
					event.target.value = valueOnlyNumbers;
					});
			</script>

		<?php 
	}


	if(isset($_POST["submit3"])){

		$payment_status = $_POST["delivery_payment"]; //siparis durumu 
		$order_type = $_POST["delivery-type"];
		$timed = $_POST["timed"];
		$order_date = $_POST["order-date"];
		$order_note = $_POST["note"];

		//Customer information /************************************************************************************** */
		$customer_name = $_POST["full-name"];
		$customer_number = $_POST["number"];
		$customer_mail = $_POST["mail"];
		$customer_zip = $_POST["zip"];
		$customer_mahalle = $_POST["neighborhood"];
		$customer_address = $_POST["address"];

			// echo "buttona basıldı<br><br>";


			// echo "Sepet id : ".$cart_id."<br>";
			// echo "Seeptin genel notu : ".$order_note."<br>";
			// echo "her Yemek için not :  food->note şeklinde cekeceğiz<br>";
			// echo "her Yemeğin toplam fitayı :  food->total_price şeklinde cekeceğiz<br>";
			// echo "sipariş ödeme şekli : ". $payment_status."<br>";
			// echo "Sipariş verileceği zaman : ".$_POST["order-date"]."<br>";
			// echo "Burada siparişin ne zaman olacağıdır : ".$order_date."<br>";
			// echo "Zamanlı siparişmi değilmi : ".$timed."<br>";


			// echo "<br> <br> Müsteri bilgileri <br>";
			// echo "name : ".$customer_name."<br>";
			// echo "Number : ".$customer_number."<br>";
			// echo "mail : ".$customer_mail."<br>";
			// echo "adress : ". $customer_address."<br>";
			// echo "mahalle : ".$customer_mahalle."<br>";

	
	
			// echo "<pre>";
			// print_r($foods);
			// print_r($total_price);
			// echo "</pre>";





			$send_customer = "INSERT INTO tbl_customer SET
						customer_full_name = ?,
						customer_number =?,
						customer_email = ?, 
						customer_mahalle = ?,
						customer_address = ?,
						customer_zip = ?
						";
			
			$add_customer = $db->prepare($send_customer);
			$durum= $add_customer->execute(array($customer_name,$customer_number,$customer_mail,$customer_mahalle,$customer_address,$customer_zip));
	
		
		if ($durum) { 
		 // başarılı
		 $customer_id = $db->lastInsertId();
			
		}else {
			//başarısız
		}

		if($customer_id != ""){

			foreach($foods as $food => $value){

				
				$food_id = $value->id;
				$price = $value->price;
				$qty = $value->count;
				$total_price = $value->total_price;
				$food_note = $value->note;
				$extra_name = $value->extra;
				$extra_price = $value->extra_price;
				

				$send_order = "INSERT INTO tbl_food_order SET
							cart_id = ?,
							customer_id =?,
							food_id = ?, 
							extra_name = ?,
							extra_price = ?,
							price = ?,
							qty = ?,
							order_note = ?,
							food_note = ?,
							total_price = ?,
							order_status = ?,
							payment_status = ?,
							order_type = ?,
							timed = ?,
							order_date = ? 
							";
				
				$add_food = $db->prepare($send_order);
				$kontrol= $add_food->execute(array($cart_id,$customer_id,$food_id,$extra_name,$extra_price,$price,$qty,$order_note,$food_note,$total_price,"bekliyor...",$payment_status,$order_type,$timed,$order_date));
		
			}
				

				if ($kontrol) {
					$_SESSION['siparis-durum'] = "<br><h3><div class='success text-center'> Ihre Bestellung ist eingegangen. Wir senden die Bestelldaten an Ihre E-Mail-Adresse. :):)</div></h3>";
					unset($_SESSION["cart"]);
					include("mail/siparis-var.php");
					header("location:".SITEURL);
					
				}else {
					$_SESSION['siparis-durum'] = "<br><h3><div class='error text-center'>  Sie hatten ein systemisches Problem beim Aufgeben Ihrer Bestellung. :( :(</div></h3>";
					header("location:".SITEURL);
				}
		}



			 
		}



	if(empty($_POST)){
   		header("location:".SITEURL);
   	 	exit;
	}
 
	
	
 ?><?php include("partials-front/footer.php"); ?>