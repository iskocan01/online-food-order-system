<?php 

	class productData{
		public function getProduct($category_id, $db){
			$products = $db->query("SELECT * FROM tbl_product WHERE product_category = '$category_id' ", PDO::FETCH_OBJ)->fetchAll();
			return $products;
		}

		public function getProductName($product_id, $db){
			$product_name = $db->query("SELECT product_name FROM tbl_product WHERE id = '$product_id '", PDO::FETCH_OBJ)->fetch();
			return $product_name;
		}
	}





	class categoryData{
		public function getCategories($db){
			$categories = $db->query("SELECT * FROM tbl_category", PDO::FETCH_OBJ)->fetchAll();
			return $categories;
		}

		public function getCategory($id, $db){
			$category = $db->query("SELECT * FROM tbl_category WHERE id = '$id' ", PDO::FETCH_OBJ)->fetchAll();
			
			return $category;
		}
	}



	class cartData{


		public function getTotalPrice($cart_id, $db){
			$price = 0;
			$total = $db->query("SELECT * FROM tbl_food_order WHERE cart_id = '$cart_id' ", PDO::FETCH_OBJ)->fetchAll();
			foreach ($total as $food ) {
			 $price +=  $food->total_price;
			}
			return $price;
		}


		public function getCountCart($cart_id, $db){
			$count = 0;
			$total = $db->query("SELECT * FROM tbl_food_order WHERE cart_id = '$cart_id' ", PDO::FETCH_OBJ)->fetchAll();
			foreach ($total as $food ) {
			 $count +=  $food->qty;
			}
			return $count;
		}


		public function getAllCart($cart_id, $db){
			
			$foods = $db->query("SELECT * FROM tbl_food_order WHERE cart_id = '$cart_id' ", PDO::FETCH_OBJ)->fetchAll(); 
			return $foods;
		}
	}


	class orderStatus{
		public function orderStatusUpdate($cart_id, $db){
			$cart = $db->query("SELECT order_status FROM tbl_food_order WHERE cart_id = '$cart_id' ", PDO::FETCH_OBJ)->fetchAll();
			$status = $cart[0]->order_status;

			if($status == "bekliyor..."){
				$status ="hazırlanıyor...";
			}elseif($status == "hazırlanıyor..."){
				$status = "yolda...";
			}elseif($status == "yolda..."){
				$status ="teslim";
			} 

			$sql = "UPDATE tbl_food_order SET order_status = :value WHERE cart_id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':value', $status, PDO::PARAM_STR);
			$stmt->bindValue(':id', $cart_id, PDO::PARAM_INT);
			$stmt->execute();
			 
		}
		public function ordercancel($cart_id, $db){
			$sql = "UPDATE tbl_food_order SET order_status = :value WHERE cart_id = :id";
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':value', "iptal", PDO::PARAM_STR);
			$stmt->bindValue(':id', $cart_id, PDO::PARAM_INT);
			$stmt->execute();
		}
	}



	class foodData{

		public function getFood($food_id, $db){
			$foods = $db->query("SELECT * FROM tbl_food WHERE id = '$food_id' ", PDO::FETCH_OBJ)->fetchAll();
			return $foods; 
		}

		public function getFoodName($food_id, $db){
			$food = $db->query("SELECT title FROM tbl_food WHERE id = '$food_id' ", PDO::FETCH_OBJ)->fetch();
			return $food; 
		}
		public function getFoodCategoryId($food_id, $db){
			$food = $db->query("SELECT category_id FROM tbl_food where id ='$food_id'", PDO::FETCH_OBJ)->fetchAll();
			return $food;

		}

	}



	class customerData{

		public function getCustomerAllInformation($id, $db){
			$customers = $db->query("SELECT * FROM tbl_customer WHERE id = '$id' ", PDO::FETCH_OBJ)->fetch();
			return $customers;
		}


		//aşağısı eski kodlar dır*********************************************************
		public function getCustomerNumber($id, $db){
			$customers = $db->query("SELECT * FROM tbl_customer WHERE id = '$id' ", PDO::FETCH_OBJ)->fetch();
			return $customers->customer_number;
		}


		public function getName($id,$conn){
			$sql = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$name = $row['customer_full_name'];
			return $name;
		}

		public function getNumber($id,$conn){
			$sql = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$name = $row['customer_number'];
			return $name;
		} 


		public function getEmail($id,$conn){
			$sql = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$name = $row['customer_email'];
			return $name;
		}

		public function getMahalle($id,$conn){
			$sql = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$name = $row['customer_mahalle'];
			return $name;
		}


		public function getAddress($id,$conn){
			$sql = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$name = $row['customer_address'];
			return $name;
		}

		public function getFoodName($food_id,$conn){
			$sql = "SELECT * FROM tbl_food WHERE id='$food_id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$name = $row['title'];
			return $name;
		}


	}

 ?>