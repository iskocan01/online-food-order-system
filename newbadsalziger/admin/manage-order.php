<?php
     include('../config/constants.php');
     include('login-check.php');
    require_once("partials/getData/getData.php"); 
 ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Manage</title>
    <link rel="icon" href="<?php echo SITEURL; ?>images/newlogo1.png" type="image/x-icon"/> 
    <meta http-equiv="refresh" content="20">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
    <!-- Menü Section Start  -->  
    <div class="menu text-center">
        <div class="wrapper">
            <ul>
                <li><a href="index.php">Home</a> </li>
                <li><a href="manage-admin.php">Admin</a> </li>
                <li><a href="manage-category.php">Category</a> </li>
                <li><a href="manage-food.php">Food</a> </li>
                <li><a href="manage-product.php">Product</a> </li>
                <li><a href="manage-order.php">Order</a> </li>
                <li><a href="logout.php">Çıkış yap</a> </li>
            </ul>

            </div> 
        
    </div>
    <!-- Menü Section Ends   --> 

 

 <div class="main-content">
     <div class="container-fluid">
         <h1>Order Management</h1>

         <br><br><br>
<?php
          if (isset($_SESSION['update']))
         {
             echo $_SESSION['update'];
             unset($_SESSION['update']);
         }




      

?>
            <?php //! Bursı modalın yaptığğı modalin göründüğü yerdir display:none;  
            
            ?>
       
                <div class="modal fade" id="display-order" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body" >
                          
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal Et</button>
                        <button type="button" class="btn btn-primary">Onayla</button>
                      </div>
                    </div>
                  </div>
                </div>

            


 
         <!--İlk kutuumuzun başlangıçı ***************************************************************************-->
        <div class="row p-4">


           <div id="shower" class="row  ">
              <div class="box">
                <div class="color" style="background-color: #ff88ff;"></div>
                <span>Service</span>
              </div>
              <div class="box">
                <div class="color" style="background-color: #ffcbdb;"></div>
                <span>Take-away</span>
              </div>
              <div class="box">
                <div class="color" style="background-color: #ffc48a;"></div>
                <span>Delivery</span>
              </div>
            </div>


            <br><br><br>
            <div class=" shadow-lg rounded-4 p-4" style="background-color: #F8FFDB;">   
                <h3> <strong> Aktif Siparişler</strong></h3>
                <table class="tbl-full fs-6">
                    <tr>   
                        <th>S.N.</th>
                        <th>Vorname Familienname</th>
                        
                        <!--Sipariş toplamı-->
                        <th>Auftragssumme</th>
                        
                    
                        <!--telefon no-->
                        <th>Kundenkontakt</th>

                        <!--Sipariş tarih-->
                        <th>Bestelldatum</th>
        
                        <!--Sipariş Durumu-->
                        <th>Bestellstatus</th>

                        <!--Ödeme Durumu-->
                        <th>Zahlungsstatus</th>

                        <!--Sipariş Tipi-->
                        <th>Auftragsart</th>

                        <!--Buttonlar-->
                        <th>Aktionen</th>

                    </tr>

                    <?php 
                        

                        //****************************************************************************************************** */
                        $dataCart = new cartData();
                        $dataCustomer = new customerData();


                        $foods = $db->query("SELECT  * FROM tbl_food_order WHERE order_status !='teslim' AND order_status != 'iptal' AND id != 1 ORDER BY id DESC ",PDO::FETCH_OBJ)->fetchAll();

                        

                            $sn = 1;
                            $check_cart=0;
                            foreach ($foods as $food) {
                                
                                if ($check_cart != $food->cart_id) {
                                    if ($food->order_type == "service") {
                                        echo "<tr style = 'background-color:#ff88ff;'>";
                                    }elseif($food->order_type == "delivery"){
                                         echo "<tr style = 'background-color:#ffc48a;'>";
                                    }else{
                                        echo "<tr style = 'background-color:#ffcbdb;'>";
                                    }
                                ?>  


                        
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $dataCustomer->getCustomerAllInformation($food->customer_id, $db)->customer_full_name; ?></td>
                            <td>€ <?php echo $dataCart->getTotalPrice($food->cart_id, $db); ?></td>
                            <td><?php echo $dataCustomer->getCustomerAllInformation($food->customer_id, $db)->customer_number; ?></td>
                            <td>
                                <?php 
                                    $saat = date("H:i:s", strtotime($food->order_date));
                                    echo $saat; 
                                ?>
                            </td>
                            <td><?php echo $food->order_status; ?></td>
                            <td><?php echo $food->payment_status; ?></td>
                            <td><?php echo $food->order_type; ?></td>
                            <td>

                               <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#display-order">Görüntüle modalda</button><br>-->
                                <a style="padding: 2%; " href="<?php echo SITEURL ?>admin/view-order.php?sepet_id=<?php echo $food->cart_id; ?>" target="_blank" class="btn btn-primary">Görüntüle  </a><br>
                                <!-- <a style="padding: 2%; " href="#" class="btn btn-dangery">Yazdır</a><br>-->
                            </td>

                        </tr>



                                <?php  
                                if ($food->order_status =="bekliyor...") {
                                    ?>  <audio  src="<?php echo SITEURL; ?>/ses/order.mp3" autoplay loop ></audio>  <?php 
                                }                        

                                }else{
                                    continue;
                                }
                                $check_cart = $food->cart_id;

                            }
                        ?>
                        

                    
                </table>
            </div>
        </div>
         <!--İlk kutuumuzun Sonu **********************************************************************************-->

        <br>
        <hr>
        <br>
        

        
        <!---- Burası ikinci satırın başladığı yerdirrrrr *************************************************---->
        <div class="row p-2">

            <div class="col-md-6  p-2">
                <div class="shadow-lg  rounded-4 p-2" style="background-color:#B3FFAE;">
                    <h3>Bugünün Siparişi</h3>
                    <table class="tbl-full  ">
                        <tr>
                            <th>#</th>
                            <th>İsim</th>
                            <th>durum</th>
                            <th>Tarih</th>
                            <th></th>
                        </tr>
                        <tr> 
                            <?php
                            //*********************************************************************** */

                            $foods = $db->query("SELECT  * FROM tbl_food_order WHERE  id != 1 AND order_status != 'iptal' AND order_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ORDER BY id DESC ",PDO::FETCH_OBJ)->fetchAll();

                            

                            $sn = 1;
                            $check_cart=0;
                            foreach ($foods as $food) {

                                if ($check_cart != $food->cart_id) {
                                ?> 
                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $dataCustomer->getCustomerAllInformation($food->customer_id, $db)->customer_full_name; ?></td>
                                <?php
                                 
                                    if ($food->order_type == "service") {
                                        echo "<td style = 'background-color:#ff88ff;'>";
                                    }elseif($food->order_type == "delivery"){
                                         echo "<td style = 'background-color:#ffc48a;'>";
                                    }else{
                                        echo "<td style = 'background-color:#ffcbdb;'>";
                                    }
                                    ?>


                            <?php echo $food->order_status; ?></td>
                            <td>
                                <?php 
                                    $saat = date("H:i:s", strtotime($food->order_date));
                                    echo $saat; 
                                ?>
                            </td> 
                            <td>

                                <!-- <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#display-order">Görüntüle modalda</button><br> -->
                                <a style="padding: 2%; " href="<?php echo SITEURL ?>admin/view-order.php?sepet_id=<?php echo $food->cart_id; ?>" target="_blank" class="btn btn-primary">Görüntüle </a><br>
                                
                            </td>

                        </tr>



                            <?php  
                            if ($food->order_status =="bekliyor...") {
                                ?>  <audio  src="<?php echo SITEURL; ?>/ses/order.mp3" autoplay loop ></audio>  <?php 
                            }                        

                            }else{
                                continue;
                            }
                            $check_cart = $food->cart_id;

                        }

                                             ?>

                        
                      

                            
                        </tr>
                    </table>
                </div>
            </div>



            <div class="col-md-6 p-2">
                <div class=" rounded-4 p-2" style="background-color:#ffaca8;">
                    <h3>İptal edilen Sipariş</h3>
                    <?php 
                              //  $foods = $db->query("SELECT  * FROM tbl_food_order WHERE order_status ='iptal' AND id != 1 AND order_date = BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ORDER BY id DESC ",PDO::FETCH_OBJ)->fetchAll();
                    $foods = $db->query("SELECT * FROM tbl_food_order WHERE order_status = 'iptal' AND id != 1 AND order_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 1 DAY) ORDER BY id DESC")->fetchAll(PDO::FETCH_OBJ);

                                if(count($foods)>0){                    
                    ?>
                        <table class="tbl-full">
                            <tr>
                                <th>#</th>
                                <th>İsim</th> 
                                <th>Tarih</th>
                                <th>Action</th>
                            </tr>

                            <?php 

                                
                                $sn=1;
                                $check_cart = 0;

                                    foreach($foods as $food){

                                        if($check_cart != $food->cart_id){
                                            ?> 
                                                <tr>
                                                    <td><?php echo $sn++; ?></td>
                                                     <td><?php echo $dataCustomer->getCustomerAllInformation($food->customer_id, $db)->customer_full_name; ?></td>
                                                    
                                                     <td>
                                                        <?php 
                                                            $saat = date("H:i:s", strtotime($food->order_date));
                                                            echo $saat; 
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <a style="padding: 2%; " href="<?php echo SITEURL ?>admin/view-order.php?sepet_id=<?php echo $food->cart_id; ?>" target="_blank" class="btn btn-primary">Görüntüle </a>
                                                    </td>
                                                </tr>
                                            <?php
                                        }

                                        
                                        $check_cart = $food->cart_id;
                                        
                                    }
                                }else{
                                    echo "<h4 class='text-center text-success'>iptal ürün yoktur</h4>";
                                }

                            ?>
 
                         
                        </table>
                </div>
             </div>
           
        </div>
        
         <!---- Burası ikinci satırın Bittiği  yerdirrrrr *************************************************---->





         <br><br><br><br><br><br>
         <!--Burası ücüncü satırımızıın başlangıc yeridirrrrrr ********************* ****** **************** ** ******************************************************* *************-->
                 <div class="row p-4">


           <div id="shower" class="row  ">
              <div class="box">
                <div class="color" style="background-color: #ff88ff;"></div>
                <span>Service</span>
              </div>
              <div class="box">
                <div class="color" style="background-color: #ffcbdb;"></div>
                <span>Take-away</span>
              </div>
              <div class="box">
                <div class="color" style="background-color: #ffc48a;"></div>
                <span>Delivery</span>
              </div>
            </div>


            <br><br><br>
            <div class=" shadow-lg rounded-4 p-4" style="background-color: #F8FFDB;">   
                <h3> <strong>Bütün Siparişler</strong></h3>
                <table class="tbl-full fs-6">
                    <tr>   
                        <th>S.N.</th>
                        <th>Vorname Familienname</th>
                        
                    
                        <!--telefon no-->
                        <th>Kundenkontakt</th>
                        
                        <!--Sipariş toplamı-->
                        
                        <!--Sipariş tarih-->
                        <th>Bestelldatum</th>
        
                        <!--Sipariş Durumu-->
                        <th>Bestellstatus</th>

                        <!--Ödeme Durumu-->
                         

                        <!--Sipariş Tipi-->
                        <th>Auftragsart</th>

                        <!--Buttonlar-->
                        <th>Aktionen</th>

                    </tr>

                    <?php 
                        

                        //****************************************************************************************************** */
                        $dataCart = new cartData();
                        $dataCustomer = new customerData();

                        $startDateTime = DATE;

                        echo DATE;
                        $foods = $db->query("SELECT  * FROM tbl_food_order WHERE (order_status ='teslim' OR order_status = 'iptal') AND id != 1 AND order_date > '$startDateTime' ORDER BY id DESC ",PDO::FETCH_OBJ)->fetchAll();

                        

                            $sn = 1;
                            $check_cart=0;
                            foreach ($foods as $food) {
                                
                                if ($check_cart != $food->cart_id) {

                                    if ($food->order_type == "service") {
                                        echo "<tr style = 'background: linear-gradient(0deg, rgba(255,136,255,1) 0%, rgba(255,121,255,1) 100%);;'>";
                                    }elseif($food->order_type == "delivery"){
                                         echo "<tr style = 'background: linear-gradient(0deg, rgba(255,196,138,1) 0%, rgba(245,180,116,1) 100%);'>";
                                    }else{
                                        echo "<tr style = 'background: linear-gradient(0deg, rgba(255,203,219,1) 0%, rgba(249,184,204,1) 100%);'>";
                                    }
                                ?>  


                        
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $dataCustomer->getCustomerAllInformation($food->customer_id, $db)->customer_full_name; ?></td>
                            <td><?php echo $dataCustomer->getCustomerAllInformation($food->customer_id, $db)->customer_number; ?></td>
                             
                            <td>
                                <?php 
                                    $saat = date("Y.m.d", strtotime($food->order_date));
                                    echo $saat; 
                                ?>
                            </td>
                                <?php 

                                     if ($food->order_status == "iptal") {
                                        echo "<td style = 'background: linear-gradient(0deg, rgba(65,0,0,1) 0%, rgba(255,0,0,1) 100%);; color:white; '>";
                                    }else{
                                        echo "<td style = 'background: linear-gradient(0deg, rgba(13,224,0,1) 0%, rgba(153,255,156,1) 100%);'>";
                                    }

                                ?>
                            <?php echo $food->order_status; ?></td>
                            
                            <td><?php echo $food->order_type; ?></td>
                            <td>

                               <!-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#display-order">Görüntüle modalda</button><br>-->
                                <a style="padding: 2%; " href="<?php echo SITEURL ?>admin/view-order.php?sepet_id=<?php echo $food->cart_id; ?>" target="_blank" class="btn btn-primary">Görüntüle  </a><br>
                                <!-- <a style="padding: 2%; " href="#" class="btn btn-dangery">Yazdır</a><br>-->
                            </td>

                        </tr>



                                <?php  
                                if ($food->order_status =="bekliyor...") {
                                    ?>  <audio  src="<?php echo SITEURL; ?>/ses/order.mp3" autoplay loop ></audio>  <?php 
                                }                        

                                }else{
                                    continue;
                                }
                                $check_cart = $food->cart_id;

                            }
                        ?>
                        

                    
                </table>
            </div>
        </div>


            <!--Burası ücüncü satırımızıın Bitiş yeridirrrrrr ********************* ****** **************** ** ******************************************************* *************-->




     </div>
 </div>



<?php include('partials/footer.php'); ?>