<?php include('partials/menu.php') ?>
	
	<!-- Main Contect Section Start	 -->  
	<div class="main-content">
		<div class="wrapper">
		<h1>Deshboard</h1><br><br>
		<?php 

			

			if (isset($_SESSION['login'])) 
			{
				echo $_SESSION['login']; //Display  the Session message if Set
				unset($_SESSION['login']);// Remove Session message
			}
		?>
		
		<br><br>	


		<?php 
				/// günlük verileri almak için kullanılan data
				$date = date("Y-m-d"); 
				
				$start_date =$date." 00:00:01";             //"2023-01-24 00:00:00";//date("Y-m-d");
				$end_date =$date." 23:59:59"  ;             //"2023-01-24 23:59:59";// date("Y-m-d");


				// aylık verileri almak için alınan tarihler
				$datem= date("Y-m");
				$start_datem = $datem."-01 00:00:00";
				$end_datem = $datem."-31 23:59:59";


				//*********************************************************************************************************
			$sql = "SELECT * FROM tbl_category WHERE active ='Yes'";

			$res = mysqli_query($conn, $sql);

			$count = mysqli_num_rows($res);


		 ?>
			<div class="col-4 text-center">
				<h1><?php echo $count ;?></h1>
				<br />
				Categories
			</div>


			<?php //********************************************************************************************

			$sql2 = "SELECT * FROM tbl_food WHERE active ='Yes'";

			$res2 = mysqli_query($conn, $sql2);

			$count2 = mysqli_num_rows($res2);


		 ?>

			<div class="col-4 text-center">
				<h1><?php echo $count2; ?></h1>
				<br />
				Menüler
			</div>

			<?php //********************************************************************************************

			$sql3 = "SELECT * FROM tbl_food_order WHERE order_status ='teslim' AND order_date < 'DATE'";

			$res3 = mysqli_query($conn, $sql3);

			$count3 = mysqli_num_rows($res3);	


		 ?>

			<div class="col-4 text-center">
				<h1><?php echo $count3; ?></h1>
				<br />
				Tamamlanan Sipariş sayısı
			</div>



			<?php //**********************************************************************************
			 	$total_daily = 0;

				$sql7 = "SELECT SUM(total_price) AS Total FROM tbl_food_order  WHERE order_status='teslim' AND order_date BETWEEN '$start_date' AND '$end_date'";

				$res7 = mysqli_query($conn, $sql7);

				$row7 = mysqli_fetch_assoc($res7);

				$total_daily = $row7['Total']; 

			 ?> 

			<div class="col-4 text-center">
				<h1>€<?php echo $total_daily; ?></h1>
				<br />
				 
				Günlük Getir  
			</div>


			<?php //************************************************************************************** 
			
			 

				$query = "SELECT * FROM tbl_customer WHERE email_verified_at BETWEEN '$start_date' AND '$end_date'";
				$result = mysqli_query($conn, $query);
				$count_customer= mysqli_num_rows($result);
				 
			?>
			<div class="col-4 text-center">
				<h1><?php echo $count_customer; ?></h1> 
				<br />
				Bugün eklenen müsteri
			</div>

			<?php //************************************************************************************** 

				$sql6="SELECT * FROM tbl_customer WHERE customer_verification ='Yes'";
				$res6= mysqli_query($conn, $sql6);
				$total_customer = mysqli_num_rows($res6);

			?>



			<div class="col-4 text-center">
				<h1><?php echo $total_customer ;?></h1>
				<br />
				Toplam Müşteriler
			</div>


			

			<?php //**********************************************************************************
			 
				$sql8 = "SELECT SUM(total_price) AS Total FROM tbl_food_order  WHERE order_status='teslim' AND order_date BETWEEN '$start_datem' AND '$end_datem'";

				$res8 = mysqli_query($conn, $sql8);

				$row8 = mysqli_fetch_assoc($res8);

				$total_monthly = $row8['Total']; 

			 ?> 

			<div class="col-4 text-center">
				<h1>€ <?php echo $total_monthly; ?></h1>
				<br />
				Aylık toplam gelir
			</div>



			<?php //**********************************************************************************

				$dateIWant = DATE;
				$sql4 = "SELECT SUM(total_price) AS Total FROM tbl_food_order  WHERE order_status='teslim' AND order_date > '$dateIWant'";

				$res4 = mysqli_query($conn, $sql4);

				$row4 = mysqli_fetch_assoc($res4);

				$total_renenue = $row4['Total'];



			 ?>



			<div class="col-4 text-center">
				<h1>€<?php echo $total_renenue; ?></h1>
				<br />
				Toplam gelir
			</div>






			<div class="clearfix"></div>
		</div>
	</div>
	<!-- Main Contect Section Ends	 --> 

	<div class="main-content">
		<div class="wrapper">
			<h1 class="text-center">Campaigns</h1>
			<br>
			<div class="campaigns">
				<div class="campaign-item">
					<h3>Daily Campaign</h3>
					

				</div>
				<div class="campaign-item">
					<h3>Percent Discount </h3>
				</div>
				<div class="campaign-item">
					<h3>Promotions</h3>
				</div>
				<div class="campaign-item">
					<h3>Special Customers</h3>

				</div>
			</div>
		</div>
	</div>

<?php include('partials/footer.php') ?>