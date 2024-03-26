<?php include('partials-front/menu.php'); ?>


<?php 

    if (isset($_GET['category_id'])) {
        // code...
        $category_id = $_GET['category_id'];

        $categories = $db->query("SELECT * FROM tbl_category WHERE id=$category_id",PDO::FETCH_OBJ)->fetch();
 
 
    } 
    else
    {
        header("location:".SITEURL);
    }
    
 ?>

 



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Foods on <a href="<?php echo SITEURL ?>category-foods.php?category_id=<?php echo $categories->id ?>" >"<?php echo $categories->title; ?>"</a></h2>
            <div class="row border" >
            <?php 

                $foods = $db->query("SELECT * FROM tbl_food WHERE category_id = '$category_id' AND active = 'Yes'",PDO::FETCH_OBJ)->fetchAll();

 
 // $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
 if(count($foods) > 0){
    // $foods nesnesinde veri varsa burada yapılacak işlemler 

foreach( $foods as $food){

 
 ?> 
    <div class="col-md-6 p-3">
        <div class="p-3 rounded-4 shadow-lg bg-body-tertiary">
            <div class="row">
                <div class="col-4">
                <?php 
                    if ($food->img_name=="") {
                        //resim yok
                         ?>

                        <img src="<?php echo SITEURL; ?>images/noimage.jpg" alt="No image" class="img-responsive img-curve">

                        <?php
                        echo "<div class='error'>No image</div>";
                    }
                    else
                    {
                        //resim var
                        ?>

                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $food->img_name; ?>" alt="<?php echo $food->img_name; ?>" class="img-responsive img-curve">

                        <?php
                    }

                     ?>
                </div>

                <div class="col-8">
                    <div class="container-fluid">
                        <h4><?php echo  $food->title?></h4>
                        <p class="food-price"> <?php echo  $food->description?></p>
                                
                        <p class="food-price"><b> € <?php echo  $food->price?> </b></p><br> 
                    </div>
                </div>
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
                <div class="col-9"  >
                    <button   type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $food->id;?>" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                 </svg>  
                                       In den Warenkorb
                    </button> 
               </div>
            </div>




            <!-- Modal başlangıcı-->

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







                        <u>Ihre Extras</u>
                        <?php
                        $products = $db->query("SELECT  * FROM tbl_product WHERE product_category= '$food->category_id' ",PDO::FETCH_OBJ)->fetchAll();
                        if(count($products)>0){
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



        </div>
    </div>



        <?php

    }
}

else
{
    //Food not avaible
   echo "<h2 class='error text-center'>Essen nicht verfügbar.</h2>";
}

                
             ?>

            

             

</div>
          

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->
    <br><br>

<?php include('partials-front/footer.php'); ?>