<?php

   require_once(__DIR__ . '/../../config/constants.php');

	

    class updateData{

       // $db adında bir özellik tanımlıyoruz
        private $db;

        // Sınıf kurucu (constructor) fonksiyon
        public function __construct($db) {
            // $db özelliğini sınıfın kurucusunda başlatıyoruz
            $this->db = $db;
        }

        //deneme fonksiyonu
        public function deneme($cart_id){

            $foods = $this->db->query("SELECT * FROM tbl_food_order WHERE cart_id = '$cart_id' ",PDO::FETCH_OBJ)->fetchAll();

            echo "<pre>";
            print_r($foods);
            echo "</pre>";
            $this->infoOrderStatus($cart_id);
        }

        public function createButton($card_id){
            $orders = $this->db->query("SELECT * FROM tbl_food_order WHERE cart_id = '$card_id' ",PDO::FETCH_OBJ)->fetchAll();
            $status = $orders[0]->order_status;

            if($status == "bekliyor...") {
                ?>
                

                    <button type="button" class="btn btn-outline-success " style="" data-bs-toggle ="modal" data-bs-target = "#accept_order_<?php echo $orders[0]->cart_id; ?>">
                        <i class="fa-regular fa-clock"></i>
                        Onayla
                    </button>

                    <!-- Modal -->
                        <div class="modal fade modal-sm" id="accept_order_<?php echo $orders[0]->cart_id; ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Müşteriye ne zaman teslim edersiniz </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-time-select">
                                            <ul>
                                                    
                                                    <form method="post" action="<?php echo SITEURL.CONTROL;?>partials-back/islem.php">

                                                        <li><button type="submit" name="time" value="10" class="btn btn5 px-5 mt-2">10 dk</button></li>
                                                        <li><button type="submit" name="time" value="20" class="btn btn5 px-5 mt-2">20 dk</button></li>
                                                        <li><button type="submit" name="time" value="30" class="btn btn4 px-5 mt-2">30 dk</button></li>
                                                        <li><button type="submit" name="time" value="40" class="btn btn3 px-5 mt-2">40 dk</button></li>
                                                        <li><button type="submit" name="time" value="50" class="btn btn2 px-5 mt-2">50 dk</button></li>
                                                        <li><button type="submit" name="time" value="60" class="btn btn1 px-5 mt-2">60 dk</button></li>

                                                        <input type="hidden" name="card_id" value="<?php echo $card_id; ?>">
                                                    </form>
                                                </ul>
                                            
                                            </div>
                                                
                                </div>
                        
                            </div>
                        </div>
                        </div>
                <?php
            }
            elseif($status == "hazırlanıyor...") {
            ?>
                <form method="post" action="<?php echo SITEURL.CONTROL;?>partials-back/islem.php">
                 <button type="submit" name="cikar" value="<?php echo $card_id; ?>" class="btn btn-outline-success ">
                    <i class="fa-solid fa-truck-fast"></i>
                    Gönder
                </button>
                  
                </form>
            <?php
            }
            elseif($status == "yolda...") {
            ?>
                <form method="post" action="<?php echo SITEURL.CONTROL;?>partials-back/islem.php">
                    <button type="submit" name="teslim-et" value="<?php echo $card_id; ?>" class="btn btn-outline-success ">
                        <i class="fa-solid fa-road"></i>
                        Teslim Et
                    </button>
                </form>
            <?php
            }
             
                
             return  $orders[0]->order_status;
           
           //$order[0]->order_status;

        }

        public function infoOrderStatus($card_id){
            $statu = $this->db->query( "SELECT order_status FROM tbl_food_order WHERE cart_id = ' $card_id ' ",PDO::FETCH_OBJ )->fetchAll();
            return $statu[0]->order_status;
        }

        public function updateOrderStatus($card_id ){

            $statu = $this->infoOrderStatus($card_id);

            if($statu == "teslim"){

              ///Burada bir şey yapmasına gerek yok belki ilerde müsteri değerlendirmesi için mail gönder yaparız.. 

                
            }
            elseif( $statu == "yolda..."){
                //Teslim diye güncelleme yeri
                 $sql = "UPDATE tbl_food_order SET order_status = :status WHERE cart_id = :card_id ";
                $stmt = $this->db->prepare($sql);

                $stmt->bindValue(":status", "teslim");
                $stmt->bindValue(":card_id", $card_id);
                try{
                    $stmt->execute();
                    $_SESSION['info-success'] = "Siparişi başarıyla teslim edildi...";
                }catch(PDOException $a){
                     $_SESSION['info-error'] = "Teslim Edilmedi!! güncelleme hatası: " . $e->getMessage();
                }                
            }

            elseif($statu == "hazırlanıyor..."){

                 $sql = "UPDATE tbl_food_order SET order_status = :status WHERE cart_id = :card_id ";
                $stmt = $this->db->prepare($sql);

                $stmt->bindValue(":status", "yolda...");
                $stmt->bindValue(":card_id", $card_id);
                try{
                    $stmt->execute();
                    $_SESSION['info-success'] = "Siparişi başarıyla yola cıkarttınız...";
                }catch(PDOException $a){
                     $_SESSION['info-error'] = "Sipariş yola cıkmadı!!, güncelleme hatası: " . $e->getMessage();
                }
            }

            elseif($statu == "bekliyor..."){

                $sql = "UPDATE tbl_food_order SET order_status = :status WHERE cart_id = :card_id ";
                $stmt = $this->db->prepare($sql);

                $stmt->bindValue(":status", "hazırlanıyor...");
                $stmt->bindValue(":card_id", $card_id);
                try{
                    $stmt->execute();
                    $_SESSION['info-success'] = "Siparişi başarıyla onayladınız...";
                    //Burada mail gönderme işlemi yapacağız
                }catch(PDOException $a){
                   $_SESSION['info-error'] = "Sipariş Onaylanmadı!! bir hata oluştu. ". $e->getMessage();
                }

            }

            header("location:".SITEURL.CONTROL);

        }

        


    
    }

    

    $updateData = new updateData($db);

   

    

    if(isset($_POST["time"]) ){
        $updateData = new updateData($db);
            if(isset($_POST["card_id"])){
                // "card_id" değerini al
                $card_id = $_POST["card_id"];
                
                $updateData->updateOrderStatus($card_id);
            
            }
        // "time" değerini al
        $selectedTime = $_POST["time"];



    

        // Alınan değerleri ekrana yazdır
     // echo "Seçilen Süre: " . $selectedTime . " dk<br>";
        // echo "Card ID: " . $card_id;

        


    } 

    if(isset($_POST["cikar"])){
        $card_id = $_POST["cikar"];
       // echo $card_id." li siparişi yola cıkartma işlemi burada yapılıyor.";
       $updateData->updateOrderStatus($card_id);
    }

    if(isset($_POST["teslim-et"])){
        $card_id = $_POST["teslim-et"];
        //echo "teslim et buttonuna basıldı ve card_id = ".$card_id ;
        $updateData->updateOrderStatus($card_id);
    }


    if(isset($_GET["time"]) && isset($_GET["card_id"])){
        $updateData = new updateData($db);
        $updateData->updateOrderStatus($_GET["card_id"]);
    }












	/*
    
    
    
    
    
    
    $order_status = new updateData();//sipariş durumunu öğrenip ona göre sipariş durumunu güncelliyoruz

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




*/

 ?>