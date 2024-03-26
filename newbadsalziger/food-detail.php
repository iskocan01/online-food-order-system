<?php include("partials-front/menu.php"); ?>

<?php 

    include_once("admin/partials/getData/getData.php");

    $foodData = new foodData();

    if(isset($_GET["id"])){
        $id= $_GET["id"];
        
    }
    

    $food = $foodData->getFood($id, $db); 
    $food = $food[0]; 
?>

<div class="container">
    <h1 class="text-center"><b>Essensdetails</b></h1>
    <div class="row  ">
        <div class=" col-xl-6    p-4 ">
            <div class="rounded-5  ">
                <img src="<?php echo SITEURL ;?>images/food/<?php echo $food->img_name;?>" alt="<?php echo $food->title;?>" widht="100%" class ="image-fluid  img-thumbnail"  style="display: block; margin: 0 auto; max-width: 100%;">
            </div>
        </div>
        <div class=" col-xl-6    p-4  ">
            <div class="rounded-5  ">
                <div>
                <h1 class="text-center text-bold"><?php echo $food->food_code."- ". $food->title ; ?></h1>
                </div>
                
                <div class="m-5">
                <h2><?php echo $food->description ; ?></h2>
                <h4 class="food-price mt-5">€ <?php echo $food->price ; ?></h4>
                </div>
                <div class="row  "  >

                             <!-- Burası Sepet buttonudur -->
                                    <button   type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $food->id;?>" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                                 </svg>  
                                                 Hinzufügen
                                    </button>   





                             <!-- Modal başlangıcı                ***************   -->

                            <div class="modal fade" id="exampleModal<?php echo $food->id;?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $food->id;?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel<?php echo $food->id;?>">Passen Sie Ihre Mahlzeit an</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body"> 

                                        
                                           <?php

                                            if ($food->category_id == 59 ) {
                                                // code...
                                                ?>
                                                <u>Ihre Fleischsorte</u>
                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="meat<?php echo $food->id; ?>" value="hahnchenfleisch" id="flexRadioDefault1" checked >
                                                      <label class="form-check-label" for="flexRadioDefault1">
                                                        mit Hahnchenfleisch
                                                      </label>
                                                    </div>

                                                    <div class="form-check">
                                                      <input class="form-check-input" type="radio" name="meat<?php echo $food->id; ?>" value="kalbsfleisch" id="flexRadioDefault2">
                                                      <label class="form-check-label" for="flexRadioDefault2">
                                                        mit Kalbsfleisch
                                                      </label>
                                                    </div>
                                                    <hr>

                                                   

                                                <?php
                                            }

                                            ?>



                                        <?php
                                        $products = $db->query("SELECT  * FROM tbl_product WHERE product_category= '$food->category_id' ",PDO::FETCH_OBJ)->fetchAll();
                                        if(count($products)>0){


                                            $i = 0;
                                             echo "<u>Ihre Extras</u>   ";
                                            foreach($products as $product => $product_key){
                                                ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="product" value="<?php echo $product_key->id; ?>" id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        mit <?php echo $product_key->product_name."  (+".$product_key->product_price ." €)"; ?> 
                                                    </label>
                                                </div>
                                                <?php 
                                                $i++;
                                                 if ($i >= 5) break; // İlk 4 ürünü gösterdik
                                            }if (count($products) > 3) {
                                                // Tümünü göster butonunu ekle
                                                echo '<button class="btn btn-link" onclick="showAllProducts(this)">Weitere '.count($products).' anzeigen </button>';
                                                // Tüm ürünleri gizli olarak ekle
                                                echo '<div class="all-products d-none">';
                                                foreach($products as $product => $product_key){
                                                    if ($i > 0) {
                                                        $i--;
                                                        continue;
                                                    }
                                                   ?>
                                                     <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="product" value="<?php echo $product_key->id; ?>" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            mit <?php echo $product_key->product_name."  (+".$product_key->product_price ." €)"; ?> 
                                                        </label>
                                                    </div>
                                                   <?php
                                                }
                                                echo '</div>';
                                            }


                                        }else{
                                            echo "Jetzt in den Warenkorb legen";
                                        } 
                                        ?>
                                    </div>
                                    <div class="modal-footer">
                                        <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                        <button   type="button" class="btn btn-success btn-block addToCartBtn" role="button"   product-id="<?php echo $food->id ;?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                                 </svg>  
                                                       In den Warenkorb
                                    </button>
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <!--Modal bitişidir                   ****************  -->
                            





                </div> 
            </div>
            <div class="text-end">
                                    <b><div >
                                        <button class="text-end" onclick="share()">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-share-fill" viewBox="0 0 16 16">
                                                <path d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5z"/>
                                            </svg>
                                        </button>
                                        </div>
                                    </b>
                                 

                                                                <script>
                                                                function share() {
                                                                var title = 'Dieses Gericht solltet ihr probieren :)';
                                                                var text = 'Jetzt anmelden und bestellen';
                                                                var url = '<?php echo SITEURL; ?>food-detail.php?id=<?php echo $food->id;?>';
                                                                

                                                                if (navigator.share) {
                                                                    navigator.share({
                                                                    title: title,
                                                                    text: text,
                                                                    url: url
                                                                    })
                                                                    .then(() => console.log('Paylaşım başarılı.'))
                                                                    .catch((error) => console.error('Paylaşım hatası: ', error));
                                                                } else {
                                                                    console.log('Tarayıcı paylaşım özelliğini desteklemiyor.');
                                                                }
                                                                }
                                                                </script>
                                </div>
        </div>
    </div>
</div>



                     
 

<?php include("partials-front/footer.php"); ?>