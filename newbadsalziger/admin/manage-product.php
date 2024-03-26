<?php include("partials/menu.php"); ?>

<?php require_once("partials/getData/getData.php") ?>

<?php
     $categories = new categoryData();
     $product = new productData();
    
    $category = $categories->getCategories($db);
    
    

    // echo   "<pre>";
    // print_r($category);
    // echo   "</pre>";

 ?>

<div class="main-content">
        <div class="wrapper">
            <h1>Manage Product</h1>
            <div class="row  ">
            <?php 
            if(isset($_SESSION["product_kayit"])){
                echo $_SESSION["product_kayit"];
                unset($_SESSION["product_kayit"]);  
            }
               /*  foreach ($category as $key => $value) {
                    $category_id = $value->id;
                    $products = $product->getProduct($category_id, $db);
                 
                */
            ?>
            <?php
                              //Burasınııııı chat gbt verdi aşağıııya kadarrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr
foreach ($category as $key => $value) {
    $category_id = $value->id;
    $products = $product->getProduct($category_id, $db);
?>

    <div class="col-xl-3 col-md-4  ">
        <div class="  m-2 border rounded-5">
            <h3 class=" text-center "><?php echo $value->title?></h3>
            <div class="m-2 my-5">
                <?php 
                    // Sadece ilk 3 ürünü göster
                    $i = 0;
                    foreach($products as $product_key => $product_value){
                        echo $product_value->product_name." = ".$product_value->product_price."<br>";
                        $i++;
                        if ($i >= 4) break; // İlk 3 ürünü gösterdik
                    }
                    if (count($products) > 3) {
                        // Tümünü göster butonunu ekle
                        echo '<button class="btn btn-link" onclick="showAllProducts(this)">Show All </button>';
                        // Tüm ürünleri gizli olarak ekle
                        echo '<div class="all-products d-none">';
                        foreach($products as $product_key => $product_value){
                            echo $product_value->product_name." = ".$product_value->product_price."<br>";
                        }
                        echo '</div>';
                    } elseif(count($products) == 0) {
                        echo "<div class='error'>There is no Content</div>";
                    }
                ?>
            </div>
            <a href="add-product.php?id=<?php echo $category_id; ?>"  class="btn btn-success     ">Add Product</a>
        </div>
    </div>
    
<?php 
}
?>

<script>
function showAllProducts(button) {
    button.style.display = 'none'; // Tümünü Göster butonunu gizle
    var allProducts = button.nextSibling;
    allProducts.classList.remove('d-none'); // Tüm ürünleri göster
}
//Burasınııııı chat gbt verdi Yukarıya kadarrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrrr

</script>

            

                 
                
                 
             </div> 

        </div>
</div>  

<?php include("partials/footer.php"); ?>