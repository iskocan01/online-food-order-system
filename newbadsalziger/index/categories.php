<?php include("partials-front/menu.php"); 
	require_once("functions/functions.php");

	$createDiv  = new CreatedDiv($db);
?>	
	<style>
     

     .category {

     	position: relative;
      background-color: #ffffff;
      padding: 2px;
      margin-bottom: 20px;
      
      box-shadow: 10px 10px 20px red;
			border-bottom: 2px solid red ;
			border-right: 2px solid red;
			border-radius: 10px;
    }

    .category img {
   	 	      	width: 100%;
     	 height: auto;
      	border-radius: 8px;
    }

    .category-title {
    	position: absolute; 
     top :50%;
     left: 50%;
     width: 100%;
     padding:  15% 0 15%;
       transform: translate(-50%, -50%);
      text-align: center;
      color: black; 
      background: rgb(255,255,255);
	background: linear-gradient(0deg, rgba(255,255,255,0) 0%, rgba(244,244,244,1) 49%, rgba(255,255,255,0) 100%);
       
    }

    .category-count {
    	bottom:0 ;
    	left: 0;
    	padding-top: 15%;
    	width: 100%;
    	position: absolute; 
		color: rgb(204, 229, 251);
      text-align: center;
      background: rgb(34,35,39);
background: linear-gradient(0deg, rgba(34,35,39,1) 0%, rgba(255,255,255,0) 100%);
    }
  </style>

 <div class="container">
	  <div class="row  ">

<?php 

	$categories = $db->query("SELECT * FROM tbl_category where active = 'Yes' ",PDO::FETCH_OBJ)->fetchAll();

	foreach($categories as $category){


			 
		// $createDiv->createCategoryCard($category);
		 
	?>

	<div class="col-6 col-lg-3 ">
	     <a href="<?php echo SITEURL.INDEX; ?>categories-food.php?category-id=<?php echo $category->id; ?>" >
	      <div class="category">
	        <img src="<?php echo SITEURL."images/category/". $category->image_name;  ?>" alt="Kategori 1">
	        <div class="category-title ">
	          <h2><?php echo $category->title; ?></h2>
	        </div>
	        <div class="category-count">
				<?php 
					$count_food = $db->query("SELECT COUNT(*) as row_count FROM tbl_food WHERE category_id = '$category->id' ",PDO::FETCH_OBJ)->fetch();
					 
				?>
	          <p>Toplam <b class="text-danger "><?php echo $count_food->row_count; ?></b> adet Ürün</p>
	        </div>
	      </div>	     	
	     </a>

	    </div>


	
	<!--
	    <div class="col-6 col-lg-3 ">
	     <a href="" type="button" data-bs-toggle="modal" data-bs-target="#category<?php echo $category->id; ?>">
	      <div class="category">
	        <img src="<?php echo SITEURL."images/category/". $category->image_name;  ?>" alt="Kategori 1">
	        <div class="category-title ">
	          <h2><?php echo $category->title; ?></h2>
	        </div>
	        <div class="category-count">
				<?php 
					$count_food = $db->query("SELECT COUNT(*) as row_count FROM tbl_food WHERE category_id = '$category->id' ",PDO::FETCH_OBJ)->fetch();
					 
				?>
	          <p>Toplam <b class="text-danger "><?php echo $count_food->row_count; ?></b> adet Ürün</p>
	        </div>
	      </div>	     	
	     </a>

	    </div>

	   -->

	  
	<?php
		
	} 


?>  </div>
	</div>




 

<?php include("partials-front/footer.php"); ?>