<?php 
	
	include "constants.php";
	 

//SESSİON
		/*
		*products

		*			Kedi Maması ...... 2 ...... 1000tl......200
		*			köpek Maması ...... 2 ...... 1000tl......200
		* 
		*Summary 
		*			2 adet ürün .....400
		*/
	
	function totalCart($foods){

		
				//sepetin hesaplanması
				$total_price = 0.0;
				$total_count = 0;
		
				// todo Buraya $db parametresi eklenecek ve sepetin bütün hesaplamaları buradan yapılacak..
		
				foreach ($foods as $food) {
					 $food->total_price = $food->count * ($food->price + $food->extra_price);
					 $total_price = $total_price + $food->total_price;
					 $total_count += $food->count;
		
					 
				}
				$summary["total_price"]=$total_price;
				$summary["total_count"]=$total_count;
				
				$_SESSION['cart']["foods"] = $foods;
				$_SESSION['cart']["summary"] = $summary;
		 
				 return $total_count;
		

	}

	function addToCart($food_item, $product_ids){
		if (isset($_SESSION["cart"])) {

				$cart = $_SESSION["cart"];
				$foods = $cart["foods"]; 

		}else{
			$foods = array();
		}
		//! YA burada aynı product ve aynı idye sahip ürünleri bir artırmak gerekmektedir.
		if(empty($foods)){
			$foods[]= $food_item;
		}else{
			foreach($foods as $key => $value){
				if($value->id == $food_item->id && $value->extra == $product_ids && $value->meat == $food_item->meat){
					$durum = true;
					$key = $key;
					$value = $value;
					break;
				}	else{
					$durum = false;
				}
			}
			if ($durum == true) {
					$foods[$key]->count++; 
			}else{
			$foods[] = $food_item;
			}

		}
		

				//sepetin hesaplanması
		totalCart($foods);


		// $total_price = 0.0;
		// $total_count = 0;

		

		// foreach ($foods as $food) {
		// 	 $food->total_price = $food->count * $food->price;
		// 	 $total_price = $total_price + $food->total_price;
		// 	 $total_count += $food->count;

			 
		// }
		// $summary["total_price"]=$total_price;
		// $summary["total_count"]=$total_count;
		
		// $_SESSION['cart']["foods"] = $foods;
		// $_SESSION['cart']["summary"] = $summary;
 
		//  return $total_count;

	}
	   
 
	function removeFromCart($food_id){

		if (isset($_SESSION["cart"])) {
			
			$cart = $_SESSION['cart'];
			$foods = $cart["foods"];



			//ürünü listeden cıkar
			 


				if (array_key_exists($food_id, $foods)) {
				unset($foods[$food_id]);
				}
			 
			
		}

		//tekrardan sepeti hesaplama işlemi****
		 


		//seppetin hesaplama işlemii


		// $total_price = 0.0;
		// $total_count = 0;

		

		// foreach ($foods as $food) {

		// 	 $food->total_price = $food->count * $food->price;
		// 	 $total_price = $total_price + $food->total_price;
		// 	 $total_count += $food->count;

			 
		// }
		// $summary["total_price"]=$total_price;
		// $summary["total_count"]=$total_count;
		
		// $_SESSION['cart']["foods"] = $foods;
		// $_SESSION['cart']["summary"] = $summary;
 
		//  return true;

		totalCart($foods);

		return true;

	}


	

	function incCount($food_id){
		if (isset($_SESSION["cart"])) {
			
			$cart = $_SESSION['cart'];
			$foods = $cart["foods"];

			//Addet Kntrolu

			if (array_key_exists($food_id, $foods)) {
				$foods[$food_id]->count++;
			} 

			//sepetin hesaplanması ....


			
			// $total_price = 0.0;
			// $total_count = 0;

			// foreach ($foods as $food) {
 
			// 		$food->total_price = $food->count * $food->price;
			// 		$total_price = $total_price + $food->total_price;
			// 		$total_count += $food->count;
			// }

			// $summary["total_price"] = $total_price;
			// $summary["total_count"] = $total_count;

			// $_SESSION["cart"]["foods"] = $foods;
			// $_SESSION["cart"]["summary"] = $summary;
 
			// return true;

			totalCart($foods);

			return true;
		}
	}

 

	function decCount($food_id){

		if (isset($_SESSION["cart"])) {
			
			$cart = $_SESSION['cart'];
			$foods = $cart["foods"];

			//Addet Kntrolu

			if (array_key_exists($food_id, $foods)) {
				$foods[$food_id]->count--;
				if(!$foods[$food_id]->count > 0){
					unset($foods[$food_id]);
				}
			} 

			//sepetin hesaplanması ....



			// $total_price = 0.0;
			// $total_count = 0;

			// foreach ($foods as $food) {
 
			// 		$food->total_price = $food->count * $food->price;
			// 		$total_price = $total_price + $food->total_price;
			// 		$total_count += $food->count;
			// }

			// $summary["total_price"] = $total_price;
			// $summary["total_count"] = $total_count;

			// $_SESSION["cart"]["foods"] = $foods;
			// $_SESSION["cart"]["summary"] = $summary;
 
			// return true;

			totalCart($foods);

			return true;


		}



		 
	}



 
 
   

if (isset($_POST["p"])) {
	
	$islem = $_POST["p"];
	
	 
	

			if ($islem =="addToCart") {  
					 
				 
					if (isset($_POST["food_id"])) {
						
						$id = $_POST["food_id"];

						if (isset($_POST['radio'])) {
								
								$meat = $_POST['radio'];

						}else{
							$meat = "";
						}

						
				

					

						//burada food is yi alarak bir nesneye dönüştürdük
						$food = $db->query("SELECT * FROM tbl_food WHERE id={$id}", PDO::FETCH_OBJ)->fetch();
						$food->count = 1;//bu nesneye count özelliği ekledik

						//Burada bizim checkboxlardaki değerleri aldığımız yerdir.
						if(isset($_POST["checkedValues"])){
							$product_ids = $_POST["checkedValues"];
							 
						}else{
							$product_ids = ""; 
						}

						// todo Burada checkboxlardan aldığımız string değerini diziye cevirdik
						// todo burada her $food nesnesi için yeni bir fiyat bilgisi daha ekleyecceğim bu bilgi product ids den gelecek
						$arr = explode(",", $product_ids);
						$extra_price = 0;
						if(empty($arr)){
							$extra_price = 0;
						}else{
							foreach($arr as $product_id){	
								$extra_product = $db->query("SELECT * FROM tbl_product WHERE id ='$product_id' ",PDO::FETCH_OBJ)->fetchAll();
								$extra_price = $extra_price + $extra_product[0]->product_price;
							}
						}
						// if(empty($product_ids)){
						// 	$product_ids = array();
						// }else{
						// 	$product_ids = explode(",",$product_ids);
						// }


						echo $product_ids;
						$food->extra = $product_ids;
						$food->extra_price = $extra_price;
						$food->meat = $meat;
						echo addToCart($food, $product_ids); 	














						 
					}  
				 
			} 
			elseif ($islem =="removeFromCart") {

						if (isset($_POST['food_id'])) {
								$id = $_POST['food_id'];
								 
								

									echo removeFromCart($id);
						}else{ 
 
						}
						
				} 

} 


if (isset($_GET["p"])) {
	
	$islem = $_GET["p"];

			if ($islem =="incCount") { 
						$id= $_GET['product_id'];
						

						if (incCount($id)) {
							
							header("location:".SITEURL."sepet.php");
						} 
						
				} elseif ($islem == "decCount") {
						$id= $_GET['product_id'];

						if (decCount($id)) {
							header("location:".SITEURL."sepet.php");
						} 
				}
}



 //ADD to Cart
/*
*
*urun id al
*cart-db.php  dosyasına post et
*veri tabanından ürün bilgilerini al
*SESSİON daki sepete ekle
*Sepeti tekrardan hesapla
*
*/




  ?>