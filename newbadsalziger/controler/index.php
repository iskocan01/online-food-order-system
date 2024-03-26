<?php include('partials-front/menu.php'); ?>

<?php 

    require_once('partials-back/getdata.php');
    require_once('partials-back/islem.php');


    $updateData = new updateData($db);
    $cartData = new CardData();

  
 

 
?> 

<!-- 
        <button class="btn-view" onclick="openPdfModal('<?php echo $order->cart_id; ?>')">PDF Göster</button>

        <div id="pdfModal-<?php echo $order->cart_id; ?>" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closePdfModal('<?php echo $order->cart_id; ?>')">&times;</span>-->
                <!-- PDF'nin gösterileceği alan -->
              <!--  <iframe id="pdfFrame-<?php echo $order->cart_id; ?>" width="100%" height="600px"></iframe>
            </div>
        </div>

-->





<div class="container">
    <?php $cartData->print(17,$db) ; ?>
</div>



<div class="cardorders">
    <?php
$query = '
SELECT
    fo.cart_id,
    MAX(fo.id) AS order_id,
    MAX(fo.customer_id) AS customer_id,
    MAX(c.customer_full_name) AS customer_full_name,
    MAX(c.customer_number) AS customer_number,
    MAX(c.customer_mahalle) AS customer_mahalle,
    MAX(fo.food_id) AS food_id,
    MAX(fo.extra_name) AS extra_name,
    MAX(fo.extra_price) AS extra_price,
    MAX(fo.price) AS price,
    MAX(fo.qty) AS qty,
    MAX(fo.order_note) AS order_note,
    MAX(fo.food_note) AS food_note,
    MAX(fo.total_price) AS total_price,
    MAX(fo.order_status) AS order_status,
    MAX(fo.payment_status) AS payment_status,
    MAX(fo.order_type) AS order_type,
    MAX(fo.timed) AS timed,
    MAX(fo.order_date) AS order_date,
    MAX(fo.delivery_date) AS delivery_date
FROM
    tbl_food_order fo
JOIN
    tbl_customer c ON fo.customer_id = c.id
GROUP BY
    fo.cart_id
ORDER BY
    fo.cart_id DESC; -- Tersine sıralama için DESC kullanılır
';


        $orders = $db->query($query, PDO::FETCH_OBJ)->fetchAll();
        foreach($orders as $order){
           // echo "<pre>";
           // print_r($order);
          //  echo "</pre>";
            ?>
                <div class="order">
                    <?php $cartData->infoStatus($order->order_status); ?>
                    <?php $cartData->orderType($order->order_type); ?>
                     
                    <div class="info-order">
                        
                            <h4 class="customerName">
                                <?php echo $order->customer_full_name; ?>
                            </h4>
                        
                        <div class=" ">
                             <p><?php echo $order->customer_number."<br>".$order->customer_mahalle;?></p> 
                        </div>
                    </div>
                    <div class="action ">
                        <div class="btn-group btn-group-sm btn-group-justify "  role="group" aria-label="Small button group">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#card-<?php echo $order->cart_id; ?>"  class="btn btn-outline-primary"><i class="fa-solid fa-eye"></i> VİEW</button>
                            <a type="button" href="<?php echo SITEURL; ?>controler/print.php?cart_id=<?php echo $order->cart_id; ?>" class="btn btn-outline-secondary"><i class="fa-solid fa-print"></i>  Print</a>
 
                            
                            <?php  $updateData->createButton($order->cart_id); ?>
                        </div>                       
                    </div> 

                    <!-- Modal sipariş görüntüle -->
                        <div class="modal  modal-lg .modal-fullscreen-md-down	" id="card-<?php echo $order->cart_id ;?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel"><?php echo $order->customer_full_name; ?></h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4><?php echo $order->customer_full_name; ?></h4>
                                            <p><?php echo  $order->customer_number; ?></p>
                                        </div>
                                        <div class="col-md-4 ms-auto">
                                            
                                        </div>
                                    </div>
                                    
                                        <?php $cartData->viewCard($order->cart_id, $db); ?>
                                     
                                </div>
                                 

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                <button type="button" class="btn btn-primary">Action</button>
                            </div>
                            </div>
                        </div>
                        </div>
                    

                </div>
            <?php
        }
    ?>
    
</div>

             <!--Cartd-->
             
            <div class="cardBox">
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Daily Views</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Daily Views</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Daily Views</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
                <div class="card">
                    <div>
                        <div class="numbers">1,504</div>
                        <div class="cardName">Daily Views</div>
                    </div>
                    <div class="iconBox">
                        <ion-icon name="eye-outline"></ion-icon>
                    </div>
                </div>
            </div>
            <!-- Data list-->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                        <a href="#" class="btn-view">View All</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Payment</td>
                                <td>Status</td>
                            </tr>   
                        </thead>
                        <tbody>
                            <tr>
                                <td>İsmet Tepecik</td>
                                <td>$1500</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>
                            <tr>
                                <td>İsmet Tepecik</td>
                                <td>$1500</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>
                            <tr>
                                <td>İsmet Tepecik</td>
                                <td>$1500</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>


            
              


<?php include('partials-front/footer.php'); ?>
</html>
       
 