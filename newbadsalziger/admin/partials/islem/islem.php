<?php 
	
	include("../../../config/constants.php");
	require_once("../getData/getData.php");

	$order_status = new orderStatus();//sipariş durumunu öğrenip ona göre sipariş durumunu güncelliyoruz

	if(isset($_GET["cart_id"]) && !isset($_GET["t"]) && !isset($_GET["e"]) ){
		$cart_id = $_GET["cart_id"];
		//echo "bu alanda sadece cart_id var cartid = ". $cart_id;
		

		$order_status->orderStatusUpdate($cart_id, $db);

		$_SESSION["process"]="<div class='success'> İşlem Başarılı </div>";
		 header("location:".SITEURL."admin/view-order.php?sepet_id=".$cart_id);


	 
	}elseif(isset($_GET["cart_id"]) && isset($_GET["t"]) && isset($_GET["e"]) 	){//müşteriye ne nezamn gelindeceği ve status durumu değişmektedir.

		$cart_id = $_GET["cart_id"];
		$time = $_GET["t"];
		$email = $_GET["e"];

		$order_status->orderStatusUpdate($cart_id, $db);
		$_SESSION["process"] = "<br><div class='success'> İşlem Başarılı Veri güncellendi </div><br>";
		 header("location:".SITEURL."mail/siparis-onay-mail.php?cart_id=".$cart_id."&time=".$time."&email=".$email);

		 die();
		
		/*echo "Bu alanda 3 lü kombomuz var <br>";

		echo "sepet id = ". $cart_id;
		echo "<br>Zaman = ". $time;
		echo "<br>Email = ". $email;
		*/
	 

	}elseif(isset($_GET["p"])){
		if($_GET["p"]=="iptal"){

			$cart_id = $_GET["x"];
			echo $cart_id."  ". $_GET["p"];
			$order_status->ordercancel($cart_id, $db);
			header("location:".SITEURL."admin/view-order.php?sepet_id=".$cart_id);
		}

	}
	else{
		echo "Sepet id get edilemedi";
	}

	
		
 












	///buradan aşağısııı eski koddurrrr***************************************
/*	
	if (isset($_GET["sepet_id"])&&isset($_GET['status'])) {

		$sepet_id=$_GET["sepet_id"];
		$status = $_GET['status'];

		function islem($conn, $sepet_id, $islem){

			//eğer yola cıkarmak istersek
			if ($islem == "yolacikar") {
				$status="Yolda";
			}
			elseif ($islem == "teslimet") {
				$status ="Teslim";
			}

			//eğer teslim etmek istersek
			$sql ="UPDATE tbl_order SET
			status='$status'
			WHERE sepet_id='$sepet_id'
			";

			$res = mysqli_query($conn, $sql);

			if ($res == true) {
				//işlem tamamlandı
				header("location:".SITEURL."admin/update-order.php?sepet_id=".$sepet_id);
			}
			else{
				echo "buttona basıldı ama data güncellenemedi";
			}

		}

		echo $sepet_id ."  ". $status;

		if ($status == "Hazırlanıyor") {
			islem($conn, $sepet_id, "yolacikar");
		}elseif($status == "Yolda"){
			islem($conn, $sepet_id, "teslimet");
		}


		
	}
	else{
		header("location:".SITEURL."admin/manage-order.php");
	}
*/
 ?>