<?php include('config/constants.php'); ?>
<?php ob_start();

if (isset($_SESSION["cart"])){

  $shoppingCart = $_SESSION['cart'];
  $total_count = $shoppingCart["summary"]["total_count"];
  $total_price = $shoppingCart["summary"]["total_price"];
  

} else{
  $total_count=0;
  $total_price = 0.0;
}

?>


<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

   
    

    <title>Bad-Salzing Haus</title>

    <!-- Link our CSS file -->

<link rel="icon" href="<?php echo SITEURL; ?>images/newlogo1.png" type="image/x-icon"/> 

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<link rel="stylesheet" href="css/style.css">
<!-- <link rel="stylesheet" type="text/css" href="css/customer.css"> -->




<script src="js/jquery-3.6.3.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>



</head>

<body>
 




    <nav class="navbar navbar-expand-lg bg-body-tertiary  ">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo SITEURL ?>"> <img src="<?php echo SITEURL ?>images/newlogo1.png" width="80px"></a>

        <button  class="navbar-toggler  " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
                         

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="<?php echo SITEURL; ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo SITEURL; ?>lib/menupage.php">Speisekarte</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="<?php echo SITEURL; ?>categories.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Kategorie
              </a>
              <ul class="dropdown-menu">
                <li class="dropdown-item"><a href="<?php echo SITEURL; ?>"></a>Kategorien</li>
                <li class="dropdown-divider"></li>
                <?php
                    $categories = $db->query("SELECT * FROM tbl_category where active = 'Yes' ",PDO::FETCH_OBJ)->fetchAll();
                    foreach($categories as $category){
                        //echo
                         ?>
                        <!--
                        <li><a class="dropdown-item" href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $category->id;?>"><?php echo $category->title;?></a></li>
                        -->
                        <li><a class="dropdown-item" href="<?php echo SITEURL; ?>foods.php#<?php echo $category->id;?>"><?php echo $category->title;?></a></li>
                <?php
                    }
                ?>
 
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item disabled" href="#">Anregung</a></li>
              </ul>
            </li>


          


          
            <li class="nav-item">
                <a href="<?php echo SITEURL; ?>foods.php" class="nav-link ">Mahlzeiten</a> 
            </li>
            <li class="nav-item">
                <a href="<?php echo SITEURL; ?>contact.php" class="nav-link ">Kontakt</a> 
            </li>

              
            <?php if(isset($_SESSION['user'])){ ?>
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="<?php echo SITEURL; ?>categories.php" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Mein Konto
                </a>
                <ul class="dropdown-menu">
                
                  <li class="nav-item"> 
                    <a class="nav-link disabled">Geschmacksbewertungen</a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item " href="<?php echo SITEURL ; ?>customer-settings.php">Account Einstellungen</a></li>
                  <li><a class="dropdown-item" href="<?php echo SITEURL; ?>logout-customer.php  "> Abmelden</a></li>
                </ul>
              </li>
              <?php }else{ ?> 
                <li class="nav-item">
                  <a class="nav-link" href="<?php echo SITEURL; ?>login-customer.php"> Anmeldung</a></li>
              <?php } ?> 

          </ul>

          <form class="d-flex" role="search" action="<?php echo SITEURL; ?>food-search.php" method="POST">
            
            <input class="form-control me-2"  name="search" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" name="submit"  type="submit">Search</button>
          </form>

        </div>
        
      </div>
    
      
    </nav>


    
    <?php 
    if(isset($_SESSION['user'])){
      $customer_id = $_SESSION['user'];
    

      $customers = $db->query("SELECT * FROM tbl_customer WHERE id = '$customer_id' ", PDO::FETCH_OBJ)->fetch();
    
      if($customers->customer_verification != "Yes"){
        ?>
         <div class="container text-white text-center border mt-3 bg-danger rounded" style="  padding:1%; ">
          Ihr Konto wurde noch nicht verifiziert. Verifizieren Sie Ihr Konto, um eine Bestellung aufzugeben. <br>
          <a href="<?php echo SITEURL; ?>mail/mail.php?id=<?php echo $customers->id; ?>" class="btn btn-secondary p-1 mt-4 ">verifiziere mein Konto</a>
        </div>

        <?php
        
      }
   

    } ?>
  
                
    <div class="fixed-top cart-area text-end " style="   margin-top: 80px; margin-right:30px; font-size: 32px!important; float:right;">
    
      <a href="<?php echo SITEURL; ?>sepet.php" class="text-dark">
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?php echo $total_count; ?>
          
        </span>

          <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-basket-fill" viewBox="0 0 16 16">
            <path d="M5.071 1.243a.5.5 0 0 1 .858.514L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15.5a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5H15v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9H.5a.5.5 0 0 1-.5-.5v-2A.5.5 0 0 1 .5 6h1.717L5.07 1.243zM3.5 10.5a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3zm2.5 0a.5.5 0 1 0-1 0v3a.5.5 0 0 0 1 0v-3z"/>
          </svg>
        </a>
    </div>






<style>
        .pulse-button {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>




    <button class="btn btn-primary fixed-bottom mb-3 pulse-button " data-bs-toggle="modal" data-bs-target="#indirimModal" style="margin: 0 auto ;">Sieh dir die reduzierten Gerichte an.</button>

    <!-- Modal -->
    <div class="modal fade" id="indirimModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">İndirimdeki Yemekler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- İndirimdeki yemeklerin listesi -->
                    <div class="row">
                      <h1 class="text-center">Schnitzel</h1>
                      <?php 

                        $schinitzel = $db->query("SELECT * FROM tbl_food WHERE category_id = '64' ",PDO::FETCH_OBJ)->fetchAll();
 
                        foreach($schinitzel as $food){
                          ?>

                          


                          <div class="col-md-6  p-4">
                            <div class="border">
                              <div class="row">
                                <div class="col-4">
                                  <?php 
                                    if ($food->img_name != "") {
                                      ?>
                                          <img src="<?php echo SITEURL; ?>images/food/<?php echo $food->img_name;  ?>" alt="<?php echo $food->title;  ?>" width="100%">
                                      <?php
                                    }else{
                                      ?>
                                        <img src="<?php echo SITEURL; ?>images/noimage.jpg" alt="<?php echo $food->title;  ?>" width="100%">
                                      <?php
                                    }
                                   ?>
                                 
                                </div>
                                <div class="col-8">
                                  <h5 class="mt-2"><?php echo $food->title;  ?> </h5>
                                   <p><?php echo $food->description;  ?></p>  

                                </div> 
                              </div>
                                <div class="p-2">
                                    
                                   <p class="text-end">
                                          <del>€<?php echo $food->price+2; ?></del>
                                         <br>
                                          €<?php echo $food->price; ?>
                                      </p>

                                    <button   type="button" class="btn btn-success btn-block addToCartBtn" role="button"   product-id="<?php echo $food->id ;?>" style="width: 100%;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                                 </svg>  
                                                       In den Warenkorb
                                    </button>
                                </div>
                              
                               
                              
                          </div>
                          </div>
                          <?php
                        }





                        ?><h1 class="text-center">Burger</h1><?php
                        $discountFood = $db->query("SELECT * FROM tbl_food WHERE food_code = '130' OR food_code = '131' OR food_code = '132'  OR food_code = '133' ",PDO::FETCH_OBJ)->fetchAll();

                          foreach ($discountFood as $food ) {
                            
                           

                           
                        ?>

                          


                          <div class="col-md-6  p-4">
                            <div class="border">
                              <div class="row">
                                <div class="col-4">
                                 <img src="<?php echo SITEURL; ?>images/food/<?php echo $food->img_name;  ?>" alt="<?php echo $food->title;  ?>" width="100%">
                                </div>
                                <div class="col-8">
                                  <h5 class="mt-2"><?php echo $food->title;  ?> </h5>
                                   <p><?php echo $food->description;  ?></p>  

                                </div> 
                              </div>
                                <div class="p-2">
                                   <p class="text-end"> €<?php echo $food->price;  ?></p>
                                    <button   type="button" class="btn btn-success btn-block addToCartBtn" role="button"   product-id="<?php echo $food->id ;?>" style="width: 100%;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
                                                  <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5v-.5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0zM8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5V8z"/>
                                                 </svg>  
                                                       In den Warenkorb
                                    </button>
                                </div>
                              
                               
                              
                          </div>
                          </div>
                          <?php
                          }
                           
                         ?>
                          
                           
                        
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                </div>
            </div>
        </div>
    </div>




    <div class="modal-dialog "></div>

    

  
 
 
  
 
        <!-- Navbar Section Ends Here -->


    
