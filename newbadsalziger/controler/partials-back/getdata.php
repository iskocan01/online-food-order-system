<?php


 //Burada sepet id ile siparişleri alıyoruz ve fonksiyona atayacağız fonksiyon icerisinde html etiketleride olacaktır
    class CardData{ 

    
		public function getFoodName($food_id, $db){
			    $query = $db->prepare("SELECT * FROM tbl_food WHERE id = :food_id");
                $query->bindParam(':food_id', $food_id, PDO::PARAM_INT);
                $query->execute();
                $food = $query->fetch(PDO::FETCH_OBJ);
                return $food;
		}

        public function getCategoryName($food_id, $db){
			    $query = $db->prepare("SELECT category_id FROM tbl_food WHERE id = :food_id");
                $query->bindParam(':food_id', $food_id, PDO::PARAM_INT);
                $query->execute();
                $food = $query->fetch(PDO::FETCH_OBJ);
                $category_id = $food->category_id;
                
                 $query = $db->prepare("SELECT * FROM tbl_category WHERE id = :food_id");
                $query->bindParam(':food_id', $category_id, PDO::PARAM_INT);
                $query->execute();
                $category = $query->fetch(PDO::FETCH_OBJ);

                  
                return $category;

		}

        function getProductDetails($inputString, $db) {
            // Verilen string'i virgül ile parçala
            $numbers = explode(',', $inputString);
             $products="";

            // Her bir sayı için tbl_product tablosundan veriyi çek
            foreach ($numbers as $number) {
                // Güvenli bir sorgu oluşturmak için prepared statement kullanalım
                $query = $db->prepare("SELECT * FROM tbl_product WHERE id = :product_id");
                $query->bindParam(':product_id', $number, PDO::PARAM_INT);
                $query->execute();

                $product = $query->fetch(PDO::FETCH_OBJ);

                // Elde edilen ürün bilgilerini kullanarak istediğiniz işlemi yapabilirsiniz
                if ($product) {
                    $products .=  "+ " .$product->product_name."+(€".$product->product_price. ")<br>";
                   // echo "+ " .$product->product_name."+(€".$product->product_price. ")<br>";
                    // Diğer ürün bilgilerini de burada kullanabilirsiniz
                } else {
                
                    echo "Ürün bulunamadı: " . $number . "<br>";
                     
                }

                
            }
            return $products;
        }


        public function viewCard($card_id, $db) {

            $query = $db->prepare("SELECT * FROM tbl_food_order WHERE cart_id = :card_id");
            $query->bindParam(':card_id', $card_id, PDO::PARAM_INT);
            $query->execute();
            $foods = $query->fetchAll(PDO::FETCH_OBJ);

            ?>
            <div class="row-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>Meal Name</th>
                        <th>Meal Note</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data (Replace this with dynamic data from your backend) -->
                    <?php
                    if (!empty($foods)) {
                        $totalPrice = 0;
                        $discount = 0;
                        foreach ($foods as $food) {
                            $totalPrice += $food->price * $food->qty;
                            ?>
                            <tr>
                                <td>
                                    <?php echo $this->getFoodName($food->food_id, $db)->title . "<br>";
                                    if ($food->extra_name != "" || $food->extra_name != null) {
                                      echo  $this->getProductDetails($food->extra_name, $db);
                                    }
                                    ?>
                                </td>
                                <td><?php echo $food->food_note; ?></td>
                                <td><?php echo $food->qty; ?></td>
                                <td>€<?php echo $food->price; ?></td>
                                <td>€<?php echo $food->price * $food->qty; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                        <!-- End of Sample Data -->

                        <!-- Add more rows dynamically based on your data -->

                        <tr class="table-info">
                            <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                            <td colspan="2">€ <?php echo $totalPrice; ?></td>
                        </tr>
                        <tr class="table-success">
                            <td colspan="3" class="text-end"><strong>Discounts:</strong></td>
                            <td colspan="2">€ -<?php echo $discount; ?></td>
                        </tr>
                        <tr class="table-primary">
                            <td colspan="3" class="text-end"><strong>Grand Total:</strong></td>
                            <td colspan="2">€ <?php echo $totalPrice + $discount; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <?php
            } else {
                echo "Şipariş görünmüyor.";
            }
            return true;
        }

        public function orderType($type){
             ?>
                 
            <?php    
                if($type == "delivery"){ 
                
                    echo  '<div class="order-type teslim " style="color: white;;">Eve Servis</div>';
                }
                elseif($type == "take-away" ){
                    echo '<div class="order-type hazırlaniyor " style="color:#00dede;">Dükkandan Alacak</div>';
                }
                elseif($type == "service"){
                    echo '<div class="order-type yolda" style="color:#27012b;">Dükkanda servis</div>';
                }
                else{
                    echo "Hata sipariş türü alınamadı";
                }                
            ?>    
                  
            <?php

            




        }

        public function infoStatus($status){

           

            if($status == "bekliyor..."){
                echo "<div class='status bekliyor'> <i class='fa-solid fa-bell fa-shake'></i> BEKLIYOR </div> ";
                ?>  <audio  src="<?php echo SITEURL; ?>/ses/order.mp3" autoplay loop ></audio>  <?php 
            }
            elseif ($status == "hazırlanıyor..." ){
                echo "<div class='status hazirlaniyor'> <i class='fa-regular fa-clock'></i> HAZIRLANIYOR </div>";
            }
            elseif ($status == "yolda..." ){
                echo "<div class='status yolda'> <i class='fa-solid fa-person-biking'></i> YOLDA </div>";
            }
             elseif ($status == "teslim" ){
                echo "<div class='status teslim'> <i class='fa-solid fa-house-circle-check'></i>TESLİM </div>";
            }
            elseif ($status == "iptal" ){
                echo "<div class='status iptal'> <i class='fa-solid fa-ban'></i> IPTAL </div>";
            }
             else{
                echo "<div class='status yolda'> birşey yok </div>";
            }

        }

        public function infoCustomer($customerId, $db){
            $query = $db->prepare("SELECT * FROM tbl_customer WHERE id = :id");
            $query->bindParam(':id', $customerId, PDO::PARAM_INT);
            $query->execute();
            $customerinfo = $query->fetchAll(PDO::FETCH_OBJ);

               

            return $customerinfo;

        }

        public function getProductName($product_id, $db){
			$product_name = $db->query("SELECT product_name FROM tbl_product WHERE id = '$product_id '", PDO::FETCH_OBJ)->fetch();
			return $product_name;
		}

        public function print($card_id, $db){
           $query = $db->prepare("SELECT * FROM tbl_food_order WHERE cart_id = :card_id");
            $query->bindParam(':card_id', $card_id, PDO::PARAM_INT);
            $query->execute();
            $foods = $query->fetchAll(PDO::FETCH_OBJ);

            $customerinfo = $this->infoCustomer($foods[0]->customer_id, $db);

            $info["customerinfo"] = $customerinfo[0];
            $info["orderinfo"] = array();

          //   $info["orderinfo"]["foodinfo"] = array();

            foreach($foods as $food){
            
                 $foodInfo = (array)$food;

                  // Add food_id as an array with id and title
                $foodInfo['food_id'] = array(
                    'id' => $food->food_id,
                    'title' => $this->getFoodName($food->food_id, $db)->title,
                    'food_code' => $this->getFoodName($food->food_id, $db)->food_code,
                    'category_id' => $this->getCategoryName($food->food_id, $db)->id,
                    'category_name' => $this->getCategoryName($food->food_id, $db)->title
                );

 
                // Diğer yiyecek bilgilerini ekleyebilirsiniz

                // Yiyecek alt dizisini ana diziye ekle // Add the modified foodInfo to the orderinfo array
                     $info["orderinfo"][] = $foodInfo;
            }
             
           
           //   echo $info["orderinfo"]["foodinfo"][35]->title;
              

            
            



            return $info;

        }

      

                         
        public function createButton($card_id, $db){
            $orders = $db->query("SELECT * FROM tbl_food_order WHERE cart_id = '$card_id' ",PDO::FETCH_OBJ)->fetchAll();
            $status = $orders[0]->order_status;

            if($status == "bekliyor...") {
            ?>
             

                 <button type="button" class="btn btn-outline-success" style="" data-bs-toggle ="modal" data-bs-target = "#accept_order_<?php echo $orders[0]->cart_id; ?>">
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
                 <button type="button" class="btn btn-outline-success ">
                    <i class="fa-solid fa-truck-fast"></i>
                    Yola Cıkart
                </button>
            <?php
            }
            elseif($status == "yolda...") {
            ?>
                 <button type="button" class="btn btn-outline-success ">
                     <i class="fa-solid fa-road"></i>
                    Teslim Et
                </button>
            <?php
            }
             
                
             return  $orders[0]->order_status;
           
           //$order[0]->order_status;

        }








    }

 
    class updateData1{ 
          public function updateOrderStatus($card_id, $db){
            echo "güncelleme işlemei burada";
        } 
    }

  

 

?>

 