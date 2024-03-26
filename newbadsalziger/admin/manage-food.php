<?php include('partials/menu.php'); ?>
    <div class="main-content">
        <div class="wrapper">
            <h1>Manage Food</h1>
            <br><br>
                <?php 
                    if (isset($_SESSION['add']))
                    {
                        echo  $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if (isset($_SESSION['upload'])) 
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']); 
                    } 

                      if (isset($_SESSION['kontrol'])) 
                    {
                        echo $_SESSION['kontrol'];
                        unset($_SESSION['kontrol']); 
                    } 

                    if (isset($_SESSION['remove'])) {
                        echo $_SESSION['remove'];
                        unset($_SESSION['remove']);
                    }

                    if (isset($_SESSION['delete'])) {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }


                    if (isset($_SESSION['failed-remove'])) {
                        echo $_SESSION['failed-remove'];
                        unset($_SESSION['failed-remove']);
                    }
                    
                      if (isset($_SESSION['update'])) {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }

                ?>
                    
                
            <br><br> 
            <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary" > Add Food </a>

            <br><br> 

           

            <table class="tbl-full">
                <tr>
                    <th>Food Code</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Description</th> 
                    <th>Price</th> 
                    <th>Category  </th>
                    <th>Feature / Active</th>
                     
                    <th>Actions</th>
                </tr>

 



                   <?php
                 

                 $sql ="SELECT * FROM tbl_food ORDER BY CAST(SUBSTRING_INDEX(food_code, ' ', 1) AS UNSIGNED), SUBSTRING(food_code, LOCATE(' ',food_code)+1); ";

                $res = mysqli_query($conn, $sql);

                if ($res == true) {
                    $count = mysqli_num_rows($res);
                    if ($count > 0 )
                    {
                        echo "<h3>Food count : ".$count."</h3>";
                      
                        while ($rows = mysqli_fetch_assoc($res)) 
                        {
                            $id = $rows['id'];
                            $food_code = $rows['food_code'];
                            $title = $rows['title'];
                            $description = $rows['description'];
                            $price = $rows['price'];
                            $image_name = $rows['img_name'];
                            $category_id = $rows['category_id'];
                            $featured = $rows['featured'];
                            $active = $rows['active'];

                            $sql2 ="SELECT * FROM tbl_category WHERE id='$category_id' ";
                            $res2 = mysqli_query($conn, $sql2);
                            $row2 = mysqli_fetch_assoc($res2);
                            $category_name = $row2['title'];


                            ?>

                            <tr>
                                <td class=" " ><?php echo  $food_code; ?>.</td>
                                <td class=" ">
                                    <?php 
                                        if ($image_name!="") {
                                            ?>
                                            <img src="../images/food/<?php echo $image_name; ?>"  width="115px">
                                            <?php
                                        }
                                        else
                                        {
                                              ?>
                                            <img src="../images/noimage.jpg"  width="115px">
                                            <?php
                                        }

                                     ?>
                                    
                                </td>
                                <td style="width:20%;"><?php echo "<b>". $title."</b>"; ?></td>
                                <td style="width: 20%;"><?php echo $description; ?></td>
                                <td>€ <?php echo $price; ?></td>
                                <td><?php echo $category_name; ?></td>
                                <td><?php echo $featured."/".$active; ?></td>
                              
                                <td>
                                    <div class="btn-group-vertical" role="group" aria-label="Vertical button group">
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary btn p-2" type="button"> Güncelle </a>
                                        <a href="delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-dangery btn" type="button">Sil</a>
                                       
                                    </div>
                                    </br><br>

                                  
                                </td>
                            </tr>


                            <?php




                        }
                    }
                    else
                    {
                        //Food not Added  in database
                        echo "<tr><td colspan='7' class='error'> Food not Added yet</td></tr>";
                    }
                }

             ?>

                <tr>
                    
                </tr>
            </table>
        </div>
    </div>
<?php include('partials/footer.php'); ?>