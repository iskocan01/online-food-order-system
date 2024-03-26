<?php
    include("partials/menu.php"); 
    require_once("partials/getData/getData.php"); 
?>

<?php  

    $category = new categoryData(); 

    if(isset($_GET["id"])){
        $category_id = $_GET["id"];
    }else{
        header("location:".SITEURL."admin/manage-product.php");
    }

    $category = $category->getCategory($category_id, $db)[0];
 

?>
<div class="main-content">
        <div class="wrapper">
            <h1>Add Product</h1>  
            <h3><?php echo $category->title ?> 'e ürün ekle</h3>
            

            
                    <form action="" method="POST">
                        <table class="tbl-30">
                            <tr>
                                <td>Ürün başlığı:</td>
                                <td >
                                    <input   type="text" name="product_name">
                                </td>
                            </tr>
                            <tr>
                                <td>Price : </td>
                                <td >
                                    <input type="text" name="product_price">
                                </td>
                            </tr>
                            <tr>
                                <td>Active : </td>
                                <td>
                                    <input type="radio" name="active" value="Yes" checked>Yes
                                    <input type="radio" name="active" value="No">No
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="">
                                    <input type="submit" name="submit" value="Add Product" class="btn btn-success" >
                                </td>
                            </tr>
                            
                        </table>
                    </form> 
            
            <?php 
                if(isset($_POST["submit"])){

                    $product_name = $_POST["product_name"];
                    $product_price = $_POST["product_price"];
                    if (isset($_POST['active'])) {
                        $product_active =$_POST['active'];
                    }
                    else{
                        $product_active ='No';
                    }

                   $sql = "INSERT INTO tbl_product SET
                   product_name = '$product_name',
                   product_price = '$product_price',
                   product_category = '$category_id',
                   product_active = '$product_active'
                   ";

                    $res = mysqli_query($conn, $sql);
                    if($res == true ){
                        $_SESSION["product_kayit"]= "<div class='success'> Kayıt Başarılı</div>";
                        header("location:".SITEURL."admin/manage-product.php");


                    }else{
                        $_SESSION["product_kayit"]= "<div class='error'> Kayıt edilmedi iletişime geç</div>";
                        header("location:".SITEURL."admin/manage-product.php");
                    }
 
                }
            ?>
            
         
            

        </div>
</div> 


<?php include("partials/footer.php"); ?>