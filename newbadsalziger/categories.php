<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

              <?php 

                //create sql query to display Category from database
                $foods =$db->query("SELECT * FROM tbl_category WHERE active='Yes' ",PDO::FETCH_OBJ)->fetchAll();

                //$sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //execute the query
                //$res = mysqli_query($conn, $sql);
                //Count rows to check whether category is avaible or not
                //$count = mysqli_num_rows($res);

                if (count($foods) > 0) 
                {
                    //category is avaible
                    foreach ($foods as $food ) {
                        // code...
                    
                        //Get value like id, title, image name
                 //       $id = $row["id"];
                  //      $title = $row["title"];
                   //     $image_name = $row["image_name"];



                        ?>
                            <a href="<?php echo SITEURL; ?>/category-foods.php?category_id=<?php echo $food->id; ?>">
                                <div class="box-3 float-container">
                                    <?php 
                                   
                                    //resim olup olmadığını kontrol et 
                                        if ($food->image_name=="") {
                                            //image name is not avaible
                                            echo "<div class='error'>İmage not Found.</div>";
                                        }
                                        else
                                        {
                                            //image is avaible
                                            ?>
                                                  <img src="<?php echo SITEURL.'images/category/'. $food->image_name ?>" alt="<?php echo $food->image_name ?>" class="img-responsive img-curve">
                                            <?php
                                        }
                                     ?>
                                    

                                    <h3 class="float-text text-white"><?php echo $food->title; ?></h3>
                                </div>
                            </a>
                        <?php
                    }

                }
                else
                {
                    //category not avaible
                    echo "<div class='error'>Category not Added..</div>";
                }


             ?>

            



            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


 <?php include('partials-front/footer.php'); ?>