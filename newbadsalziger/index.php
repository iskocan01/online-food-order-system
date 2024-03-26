<?php  include 'partials-front/menu.php'; ?>

<?php 

    require_once "config/constants.php"; //sonradan eklendi

            if (isset($_SESSION['siparis-durum'])) {
                echo $_SESSION['siparis-durum'];
                unset($_SESSION['siparis-durum']);
            }
 
       

 ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <!-- <section class="food-search text-center ">
        <div class="container">
            
            <form   action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section> -->

    
<?php 
// Şu anki tarihi al
$day = date('l' );



// Döner günü
if ($day == 'Wednesday') {
    $mealOfDay = 'Nudeltag';
}
// Pizza günü
elseif ($day == 'Friday') {
    $mealOfDay = 'Schnitzltag';
}

elseif($day == 'Thursday'){
     $mealOfDay = 'Schnitzltag';
}

elseif($day == 'Tuesday'){
     $mealOfDay = 'Pizzatag';
}
// Diğer günler
else {
    $mealOfDay = '';
}

 

 
?>
<?php if ($day != 'Monday' && $day != 'Saturday' && $day != 'Sunday') { ?>

 <div class="container">
    
    <div class="row   ">
        <h1 class="text-center"> Heute ist <?php echo $mealOfDay?></h1>

    </div>
 </div>
     
<?php } ?>


<br><br>
    <div class="container">
        <div class="row ">
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                    <img src="images/slider/slider1.png" class="d-block w-100" alt="..." >
                    </div>
                    <div class="carousel-item">
                    <img src="images/slider/slider2.png" class="d-block w-100" alt="..." >
                    </div>
                    <div class="carousel-item">
                    <img src="images/slider/slider3.png" class="d-block w-100" alt="..." >
                    </div>
                    <div class="carousel-item">
                    <img src="images/slider/slider4.png" class="d-block w-100" alt="..." >
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    
    <!-- fOOD sEARCH Section Ends Here -->
        <?php   

      /*      if (isset($_SESSION['order'])) 
            {
                echo $_SESSION['order'];
                unset($_SESSION['order']);


            }
          
             if (isset($_SESSION['login'])) 
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']); 
            }
*/


         ?>
    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Entdecken Sie Essen</h2>

            <?php 

                //create sql query to display Category from database
                $categories = $db->query("SELECT  * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3",PDO::FETCH_OBJ)->fetchAll();//sonradan eklendi

                 foreach ($categories as $category) {
        // code...
    
                        ?>
                            <a href="<?php echo SITEURL; ?>#<?php echo $category->id; ?>">
                                <div class="  box-3 float-container">
                                    
                                    <?php 

                                    //resim olup olmadığını kontrol et 
                                        if ($category->image_name=="") {
                                            //image name is not avaible
                                            echo "<div class='error'>İmage not Added.</div>";
                                        }
                                        else
                                        {
                                            //image is avaible
                                            ?>
                            <img src="<?php echo SITEURL.'images/category/'. $category->image_name ?>" alt="<?php echo $category->title; ?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                     ?>
                                    

                                         <h3 class="float-text text-white"><?php echo $category->title; ?></h3>
                                      
                                    
                                </div>
                            </a>
                        <?php
                    }
 


             ?>

           

            

            <div class="clearfix"></div>
        </div> 
    </section>
    <!-- Categories Section Ends Here -->



 
    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container-fluid">
            

            <?php include("navigation.php"); ?>
            <div class="clearfix"></div> 
        </div> 
        <p class="text-center">
            <a href="<?php echo SITEURL; ?>foods.php">Alle Gerichte ansehen</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->






    <?php //include("partials-front/navigation.php"); ?>


 

   
    <?php include('partials-front/footer.php'); ?>    
