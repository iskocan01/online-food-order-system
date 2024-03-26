<?php 
	include("partials-front/menu.php");
 ?>



<!-- Add the following CSS to your existing stylesheet or inside a <style> tag -->
<style>
  .categories {
    position: relative;
  }

  .categories-container {
    display: flex;
    overflow-x: scroll;
    white-space: nowrap;
      /* Bu satırı ekleyin */
  }

  .categories a div {
    display: inline-block;
    margin-right:  80px;
     gap: 20px;
  }

  .box-3 {
    width: 300px;
    height: 200px;
    position: relative;
    overflow: hidden; 
  }

  .box-3 img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

   

  /* Hide scrollbar */
  .categories-container::-webkit-scrollbar {
    display: none;
  }
  .categories-container {
    -ms-overflow-style: none;
    scrollbar-width: none;
  }


</style>

<!-- Categories Section Starts Here -->
<section class="categories">
  <div class="container">
    <h2 class="text-center">Entdecken Sie Essen</h2>

    <div class="categories-container">
      <?php
      foreach ($categories as $category) {
      ?>
        <a href="<?php echo SITEURL; ?>#<?php echo $category->id; ?>">
          <div class="box-3 float-container">
            <?php
            if ($category->image_name == "") {
              echo "<div class='error'>İmage not Added.</div>";
            } else {
            ?>
              <img src="<?php echo SITEURL . 'images/category/' . $category->image_name ?>" alt="<?php echo $category->title; ?>" class="img-responsive img-curve">
            <?php
            }
            ?>
            <h3 class="float-text text-white"><?php echo $category->title; ?></h3>
          </div>
        </a>
      <?php
      }
      ?>
    </div>
    <div class="clearfix"></div>
  </div>
</section>
<!-- Categories Section Ends Here -->

<!-- Add this at the end of your HTML body or inside a <script> tag -->
<script>
  const container = document.querySelector('.categories-container');
  const animationSpeed = 5;
  let isMouseOver = false;

  const firstCategory = container.firstElementChild.cloneNode(true);
  firstCategory.style.marginRight = '0'; // Bu satırı ekleyin
  container.appendChild(firstCategory);

  container.addEventListener('mouseenter', () => {
    isMouseOver = true;
  });

  container.addEventListener('mouseleave', () => {
    isMouseOver = false;
  });

  function startAutoScroll() {
    if (!isMouseOver) {
      container.scrollLeft += animationSpeed;
      if (container.scrollLeft >= container.firstElementChild.clientWidth) {
        container.appendChild(container.firstElementChild);
        container.scrollLeft -= container.firstElementChild.clientWidth;
      }
    }
    requestAnimationFrame(startAutoScroll);
  }

  startAutoScroll();
</script>





















<div class="container">
<div class="row border">
	<?php 

	$category = $db->query("SELECT * FROM tbl_category WHERE active = 'Yes' AND featured = 'Yes' LIMIT 3", PDO::FETCH_OBJ)->fetchAll();
	
	foreach($category as $key){
		 ?>

		 <div class="col-4 p-4">
		 	<div class="border float-container">
		 		<img src="<?php echo SITEURL.'images/category/'. $key->image_name ?>" alt="<?php echo $key->title; ?>" class="img-responsive img-curve">
		 		<h3 class="float-text border text-white" style="width: 100%"><?php echo $key->title; ?></h3>
		 		<h3 class="border   text-center">selam</h3>
		 		 
		 	</div>
		 </div>


		 <?php
	}

	echo "<pre>";
	print_r($category);
	echo "</pre>";

	 ?>
</div>
</div>






 <?php 
	include("partials-front/footer.php"); ?>