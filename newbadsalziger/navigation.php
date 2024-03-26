 
  <?php //include("partials-front/menu.php"); ?>

 

 
<!-- Burası bizim navigation barımız -->
<div id="container-nav " class=" container-fluid  shadow    sticky-top  "          >

    <nav id="navigation" class="   nav nav-pills   " >

        <button class="prev">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                  <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg>
        </button>
        <ul>
    <?php 

$categories = $db->query("SELECT *  FROM tbl_category WHERE active ='Yes'", PDO::FETCH_OBJ)->fetchAll();

foreach($categories as $category){
?>  
      <li> <a class="shadow  " href="#<?php echo $category->id; ?>" ><?php echo $category->title; ?>  </a>   </li>
     
<?php 
} 

?> </ul>

<button class=" next "> <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
  <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
</svg> </button>

    </nav>
</div>

 
 


<div id="food-nav" class="container-fluid ">
    <?php

    foreach($categories as $category){
    ?>


        <div id="<?php echo $category->id; ?>" style="height:100px;  " class="section " >

        </div>
        <div style=" background-image: url('images/category/<?php echo $category->image_name; ?>');" class="     back-image ">
        <h2 style=""><?php echo $category->title; ?></h2>

        
        </div>
  
        
         <div class="  row" >
    <?php
     
    $foods = $db->query("SELECT * FROM tbl_food WHERE category_id = '$category->id' AND active = 'Yes' ORDER BY CAST(SUBSTRING_INDEX(food_code, ' ', 1) AS UNSIGNED), SUBSTRING(food_code, LOCATE(' ',food_code)+1);  ",PDO::FETCH_OBJ)->fetchAll();
    foreach($foods as $food){
        ?>
       
       <div  class="col-lg-6 p-3  ">
                        <div class="p-3 rounded-4 shadow-lg  ">
                            <div class="row">
                                <div class="col-4">
                                <?php 
                                    if ($food->img_name=="") {
                                        //resim yok
                                        ?>

                                        <img src="<?php echo SITEURL; ?>images/noimage.jpg" alt="No image" class="img-responsive img-curve">

                                        <?php 
                                    }
                                    else
                                    {
                                        //resim var
                                        ?>

                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $food->img_name; ?>" alt="<?php echo $food->title; ?>" class="img-responsive img-curve">

                                        <?php
                                    }
 
                                     ?>
                                </div>

                                <div class="col-8">
                                    <div class="container-fluid">
                                        <h4><?php echo $food->food_code." - ". $food->title?></h4>
                                        <p class="food-price"> <?php echo  $food->description; ?> </p> 
                                        <p class="food-price"><b> € <?php echo  $food->price; ?> </b></p><br> 
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
                                    <!-- Burası Sepet buttonudur -->
                                    <button   type="button" class="btn btn-success " data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $food->id;?>" >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                                 </svg>  
                                                 Hinzufügen
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

                            <!--Modal bitişidir   -->



                        </div>
                    </div>
                    
                


 
       

 
        <?php 
    }
?>
</div>
 <?php

}
    
    ?>
     </div>
    


<script>
    const sections = document.querySelectorAll('.section');
    const nav = document.querySelector('#navigation');
    const navLinks = document.querySelectorAll('#navigation a');

    window.addEventListener('scroll', () => {
    let currentSection = '';
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (pageYOffset >= (sectionTop - sectionHeight / 3)) {
        currentSection = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').slice(1) === currentSection) {
        link.classList.add('active');
        }
    });
    
   // nav.classList.toggle('bg-dark', window.scrollY > 0);
    });




var menu = document.querySelector('#navigation ul');
var menuPosition = 0;
var menuWidth = menu.offsetWidth;
var buttonPrev = document.querySelector('#navigation .prev');
var buttonNext = document.querySelector('#navigation .next');
var step = 100;

console.log(menuWidth);

buttonPrev.addEventListener('click', function() {
  if (menuPosition < 0) {
    menuPosition += step;
     menu.style.setProperty('transform', 'translateX(' + menuPosition + 'px)');
    //menu.style.transform = 'translateX(' + menuPosition + 'px)';
  }
});

buttonNext.addEventListener('click', function() {

  if (menuPosition > -(menuWidth - menu.parentNode.offsetWidth)) {
    menuPosition -= step;
     menu.style.setProperty('transform', 'translateX(' + menuPosition + 'px)');
   // menu.style.transform = 'translateX(' + menuPosition + 'px)';    
  }
});



//Burası göstermek istediği diğer extra ürünler kısmıdır.
function showAllProducts(button) {
    button.style.display = 'none'; // Tümünü Göster butonunu gizle
    var allProducts = button.nextSibling;
    allProducts.classList.remove('d-none'); // Tüm ürünleri göster
}
</script>
 


  <?php // include("partials-front/footer.php"); ?>
 