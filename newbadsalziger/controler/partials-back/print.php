<?php

include('../config/constants.php');

require("fpdf/fpdf.php");

require_once("partials-back/getData.php");
 

$cartData = new CardData();



if (isset($_GET["cart_id"])) {

	$cart_id = $_GET["cart_id"];

	$cart = $cartData->print($cart_id, $db); 

}




$date = date("Y/m/d H.i");
class PDF extends FPDF{

	
	function firstHeader(){
		$this->SetFont('arial','',6);
		$this->Image('../images/newlogo.png',13,2,20);
		$this->SetXY(1,20);
		$this->Cell(44,3,iconv('UTF-8','ISO-8859-1',"Alte Heerstraße 6 "),0,1,'C');
		$this->SetX(1);
		$this->Cell(44,3,iconv('UTF-8','ISO-8859-1',"56154 Boppard-Bad Salzig"),0,1,'C');
		$this->SetX(1);
		$this->Cell(44,3,iconv('UTF-8','ISO-8859-1',"Tel:06742 9411617"),0,1,'C');
		$this->SetX(0);
		$this->Cell(46,0,"",1,1);
		$this->Ln(2);

		
		//$this->Cell(20,30,"",0,1);
	}
 
}




$pdf = new PDF(); 
$pdf->AddPage('p','a5');

$pdf->firstHeader();

		//Fiş numarası*************************************
 $pdf->SetFont('arial','B',12);
 $pdf->SetX(1);
 $pdf->Cell(44,4,iconv('UTF-8','ISO-8859-1',"NO:".$cart_id),0,1,'C');
		//Fiş numarası ******************************
 $pdf->SetFont('arial','',8);
 $pdf->SetX(1);
 $pdf->Cell(44,4,  $cart["orderinfo"][0]["order_date"],0,1,'C');


		//Müşteri Bilgileri*****************************
$pdf->SetFont('arial','',9);
$pdf->SetX(1);
$pdf->Cell(44,5,iconv('UTF-8','ISO-8859-9//TRANSLIT',"Name : ".$cart["customerinfo"]->customer_full_name),0,1);
$pdf->SetX(1);
$pdf->Cell(44,5,iconv('UTF-8','ISO-8859-9//TRANSLIT',"No : ".$cart["customerinfo"]->customer_number),0,1);


if ($cart["orderinfo"][0]["order_type"] == "delivery") {
	$pdf->SetX(1);
	 $pdf->MultiCell(44,4,iconv('UTF-8','ISO-8859-9//TRANSLIT',"Adress : ".$cart["customerinfo"]->customer_address." - ".$cart["customerinfo"]->customer_zip." / ".$cart["customerinfo"]->customer_mahalle),0,1);
}

$pdf->Ln(4);
$pdf->SetFont('arial','B',20);
$pdf->SetX(1);
$pdf->Cell(44,5, strtoupper($cart["orderinfo"][0]["order_type"]),0,1,'C');

		//Müşteri Bilgileri*****************************



$font_size=12; 
$tempFontSize = $font_size;

//Loop the Data
$pdf->Cell(10,10,"",0,1);

$cart_price = 0;
$cart_count = 0;

foreach($cart["orderinfo"] as $item){

 

	$food = $item;
	$category = $item["food_id"]["category_name"]; /// Kategori id sini FOod nesnesinden aldık ve categori nesnemizi oluşturduk

	 


	$cellWidth = 22	;//Burası 22 olmalı
	$celHeight = 5; 

	if($item["food_id"]["category_id"] != 58 && $item["food_id"]["category_id"] != 59){  //! Burada indirim ve karttadaki ürünlerü listeliyorum
		$cart_count++;												//!!
	}																//! Burada sepettin fiyatını ve nekadar indirim yapılacağını yazıyoruz.
	$cart_price += $item["total_price"]* $item["qty"];

	//check whether the text is overflowing
	if($pdf->GetStringWidth($item["food_id"]["title"]."(#)".$item["food_id"]["food_code"]) < $cellWidth){//Burası karakter sayısının uzunluğu
		//if not then do nothing
		$line =1;
	}else{
		//if it is, then calculate the height needed  for wrapped cell
		//by splitting the text to fit the cell widht
		//then count how many lines are needed for the text to fit the cell

		$textLength = strlen($item["food_id"]["title"]."(#)".$item["food_id"]["food_code"]); // total text length
		$errMargin = 3; //Cell with erorr margin, just case  //! Burası bizim verdiğimiz SeyX değerine eşit olacak bu kod önce verilmediği için böyle
		$startChar = 0; //character start positıon for each line
		$maxChar = 0; //maximun character in a line to be incremented later
		$textArray = array(); //to hold to strings for each line
		$tmpString =""; //to hold the string for a line (temporary)

		while($startChar < $textLength){ // loop until end of the text
			//loop until max,imun character reached
			while(
				$pdf->GetStringWidth($tmpString) < ($cellWidth-$errMargin)&&
				($startChar+$maxChar)< $textLength ){
					$maxChar++;
					$tmpString=substr($item["food_id"]["title"]."(#)".$item["food_id"]["food_code"],$startChar, $maxChar); 

				}	
				//move startChar to next line
				$startChar = $startChar + $maxChar;
				//than add it into the array so we know how many line are needed
				array_push($textArray, $tmpString);
				//reset maxChar and tmpstring
				$maxChar =0;
				$tmpString ="";
		}
		//get number of line
		$line = count($textArray); 
	}
	//write the Cells

	//	$this->Cell(62, 3, iconv('utf-8', 'ISO-8859-9', $name), 1, 1, "C");      iconv('utf-8','ISO-8859-1',)
	 
	$pdf->SetFont('arial','B',12);
	$pdf->SetX(1);
	$pdf->Cell(44,5, iconv('utf-8','ISO-8859-1',$item["food_id"]["category_name"]), 0, 1);

	$pdf->SetFont('arial','B',10); 
	$pdf->SetX(3);
	$pdf->Cell(4,4,$item["qty"],0,0);

	$pdf->SetFont('arial','',8);
	$pdf->Cell(3,4," X",0,0);
	$pdf->Cell(1,($line * $celHeight),"",0,0);
	
	$pdf->SetFont('arial','B',9);
	$xPos = $pdf->GetX();
	$yPos = $pdf->GetY();
	$pdf->MultiCell($cellWidth, $celHeight, iconv('utf-8','ISO-8859-1',$item["food_id"]["title"]."(#".$item["food_id"]["food_code"].")"),0,0 );
	
	$pdf->SetFont('arial','B',8);
	$pdf->SetXY($xPos + $cellWidth, $yPos);


	//$pdf->Cell(10,($line * $celHeight),$food[0]->title);

	 
	$pdf->Cell(10,4, $item["total_price"] ,0,0);
	$pdf->Cell(0.00001,($line * $celHeight), "",0,1);
	 

	$pdf->SetFont('arial','',8);
	if(isset($item["extra_name"]) && $item["extra_name"] != ""){

	$product_name = $cartData->getProductDetails($item["extra_name"],$db);

/*		$errr = $item["extra_name"];
		$extra = explode(",",$errr);
		$product_name ="";
			foreach($extra as $id){
				$product_name .= " +".$cart->getProductDetails($item["extra_name"],$db).", ";
				//$pdf->MultiCell(22,2,$productName->getProductName($id,$db)->product_name,1,1);
			
			}

			*/

		$pdf->SetX(5);
		$pdf->MultiCell(36,4, $product_name ,0,1);
	}
	 
	if(isset($item["food_note"]) && $item["food_note"] != ""){
	$pdf->SetFont('arial','i',10);
	$pdf->SetX(3);
	$pdf->MultiCell(40, 3, mb_convert_encoding($item["food_note"], 'ISO-8859-9', 'utf-8'), 0, 1);
	//$pdf->MultiCell(40,3, mb_convert_encoding( iconv('utf-8','ISO-8859-9//TRANSLIT', $item->food_note), 'ISO-8859-9', 'utf-8') ,0,1);


	 
	
	$pdf->SetFont('Courier','',6);
	}	
	$pdf->Ln(10);

	
	
	//$pdf->Cell(26,6, $food[0]->title.'(#'.$food[0]->food_code.')' ,1,0);
	
	
	 
}//foreach burada bitiyor/


//Foterrrr Toplam tutar vs........************************************
if($item["order_type"] == "delivery"){
	$pdf->SetFont('arial','',12);
	if($cart["customerinfo"]->customer_mahalle == "bad-salzig"){
		$service_price = 1.5;	
	}elseif($cart["customerinfo"]->customer_mahalle == "spay"){
		$service_price = 3;
	}else{
		$service_price = 2.5;
	}
	$pdf->SetX(2);
	$pdf->Cell(28,6,"Liefern    : " ,0,0);
	$pdf->SetFont('arial','B',12);
	$pdf->Cell(14,6, $service_price,0,1,'C');
	$indir = $service_price;
}else{

	 $pdf->SetFont('arial','',10);
	 
	$pdf->SetX(2);
	$pdf->Cell(28,6, "Essensrabatt :" ,0,0);
	$pdf->Cell(14,6, -$cart_count,0,1);
	$indir = -1 * $cart_count;
}

$pdf->Ln(5);
$pdf->SetFont('arial','B',10);
$pdf->SetX(2);
$pdf->Cell(28,6,"Total : " ,0,0);
$pdf->SetFont('arial','B',15);
$pdf->Cell(14,6, $cart_price+$indir,0,1);
$pdf->ln(20);
 




//Foterrrr Toplam tutar vs........************************************

//$pdf->customer("15/02/2023 15.44", 14);


/*
		//Fiş numarası*************************************
 $pdf->SetFont('arial','B',8);
 $pdf->SetX(1);
 $pdf->Cell(44,3,iconv('UTF-8','ISO-8859-1',"NO:".$cart_id),0,1,'C');
		//Fiş numarası ******************************


		//Müşteri Bilgileri*****************************
$pdf->SetFont('arial','',6);
$pdf->SetX(1);
$pdf->Cell(44,5,iconv('UTF-8','ISO-8859-9//TRANSLIT',"Name : ".$customer->customer_full_name),0,1);
$pdf->SetX(1);
$pdf->Cell(44,5,iconv('UTF-8','ISO-8859-9//TRANSLIT',"No : ".$customer->customer_number),0,1);
$pdf->SetX(1);
$pdf->Cell(44,5,iconv('UTF-8','ISO-8859-9//TRANSLIT',"Adress : ".$customer->customer_address." - ".$customer->customer_zip." / ".$customer->customer_mahalle),0,1);

		//Müşteri Bilgileri*****************************

 

$font_size=12; 
$tempFontSize = $font_size;

//Loop the Data
$pdf->Cell(10,10,"",0,1);

$cart_price = 0;
$cart_count = 0;
foreach($cart as $item){

	$food = $foodData->getFood($item->food_id, $db);
	$category = $categoryData->getCategory($food[0]->category_id, $db); /// Kategori id sini FOod nesnesinden aldık ve categori nesnemizi oluşturduk


	$cellWidth = 22	;//Burası 22 olmalı
	$celHeight = 5; 

	if($food[0]->category_id != 58 && $food[0]->category_id != 59){  //! Burada indirim ve karttadaki ürünlerü listeliyorum
		$cart_count++;												//!!
	}																//! Burada sepettin fiyatını ve nekadar indirim yapılacağını yazıyoruz.
	$cart_price += $item->total_price* $item->qty;

	//check whether the text is overflowing
	if($pdf->GetStringWidth($food[0]->title."a100") < $cellWidth){//Burası karakter sayısının uzunluğu
		//if not then do nothing
		$line =1;
	}else{
		//if it is, then calculate the height needed  for wrapped cell
		//by splitting the text to fit the cell widht
		//then count how many lines are needed for the text to fit the cell

		$textLength = strlen($food[0]->title."(xx)"); // total text length
		$errMargin = 3; //Cell with erorr margin, just case  //! Burası bizim verdiğimiz SeyX değerine eşit olacak bu kod önce verilmediği için böyle
		$startChar = 0; //character start positıon for each line
		$maxChar = 0; //maximun character in a line to be incremented later
		$textArray = array(); //to hold to strings for each line
		$tmpString =""; //to hold the string for a line (temporary)

		while($startChar < $textLength){ // loop until end of the text
			//loop until max,imun character reached
			while(
				$pdf->GetStringWidth($tmpString) < ($cellWidth-$errMargin)&&
				($startChar+$maxChar)< $textLength ){
					$maxChar++;
					$tmpString=substr($food[0]->title."a100",$startChar, $maxChar); 

				}	
				//move startChar to next line
				$startChar = $startChar + $maxChar;
				//than add it into the array so we know how many line are needed
				array_push($textArray, $tmpString);
				//reset maxChar and tmpstring
				$maxChar =0;
				$tmpString ="";
		}
		//get number of line
		$line = count($textArray); 
	}
	//write the Cells

	//	$this->Cell(62, 3, iconv('utf-8', 'ISO-8859-9', $name), 1, 1, "C");      iconv('utf-8','ISO-8859-1',)

	$pdf->SetFont('arial','B',8);
	$pdf->SetX(1);
	$pdf->Cell(44,5, iconv('utf-8','ISO-8859-1',$category[0]->title) , 0, 1);

	$pdf->SetFont('arial','B',6);
	
	$pdf->SetX(3);
	$pdf->Cell(8,($line * $celHeight),$item->qty." X",0,0);
	
	$pdf->SetFont('arial','',6);
	$xPos = $pdf->GetX();
	$yPos = $pdf->GetY();
	$pdf->MultiCell($cellWidth, $celHeight, iconv('utf-8','ISO-8859-1',$food[0]->title."(#".$food[0]->food_code.")"),0 );

	$pdf->SetXY($xPos + $cellWidth, $yPos);


	//$pdf->Cell(10,($line * $celHeight),$food[0]->title);

	 
	$pdf->Cell(10,($line * $celHeight), $item->total_price. iconv('utf-8','ISO-8859-9//TRANSLIT',"€"),0,1);
	if(isset($item->extra_name) && $item->extra_name != ""){
		$errr = $item->extra_name;
		$extra = explode(",",$errr);
		$product_name ="";
			foreach($extra as $id){
				$product_name .= " +".$productName->getProductName($id,$db)->product_name.", ";
				//$pdf->MultiCell(22,2,$productName->getProductName($id,$db)->product_name,1,1);
			
			}

		$pdf->SetX(5);
		$pdf->MultiCell(36,4, $product_name ,0,1);
	}
	 
	if(isset($item->food_note) && $item->food_note != ""){
	$pdf->SetFont('arial','i',5);
	$pdf->SetX(3);
	$pdf->MultiCell(40, 3, mb_convert_encoding($item->food_note, 'ISO-8859-9', 'utf-8'), 0, 1);
	//$pdf->MultiCell(40,3, mb_convert_encoding( iconv('utf-8','ISO-8859-9//TRANSLIT', $item->food_note), 'ISO-8859-9', 'utf-8') ,0,1);


	 
	
	$pdf->SetFont('Courier','',6);
	}	
	$pdf->Ln(5);

	
	
	//$pdf->Cell(26,6, $food[0]->title.'(#'.$food[0]->food_code.')' ,1,0);
	
	
	 
}


//Foterrrr Toplam tutar vs........************************************
if($cart[0]->order_type == "delivery"){
	$pdf->SetFont('arial','',6);
	if($customer->customer_mahalle == "bad-salzig"){
		$service_price = 1.5;	
	}elseif($customer->customer_mahalle == "spay"){
		$service_price = 3;
	}else{
		$service_price = 2.5;
	}
	$pdf->SetX(2);
	$pdf->Cell(28,6,"Liefern ".$customer->customer_mahalle."  : " ,0,0);
	$pdf->Cell(14,6, $service_price,0,1);
	$indir = $service_price;
}else{
	$pdf->SetFont('arial','',6);
	 
	$pdf->SetX(2);
	$pdf->Cell(28,6, "Essensrabatt" ,0,0);
	$pdf->Cell(14,6, -$cart_count,0,1);
	$indir = -1 * $cart_count;
}


$pdf->SetFont('arial','B',8);
$pdf->SetX(2);
$pdf->Cell(28,6,"Total : " ,0,0);
$pdf->Cell(14,6, $cart_price+$indir.iconv('utf-8','ISO-8859-9//TRANSLIT'," €"),0,1);
//Foterrrr Toplam tutar vs........************************************

//$pdf->customer("15/02/2023 15.44", 14);

 
*/

$pdf->Output();















































































// include('../config/constants.php');
// require("fpdf/fpdf.php");

// require_once("partials/getData/getData.php");

// $cartData = new cartData();
// $foodData = new foodData();
// $customerData = new customerData();


// if (isset($_GET["cart_id"])) {

// 	$cart_id = $_GET["cart_id"];

// 	$cart = $cartData->getAllCart($cart_id, $db);
// 	$customer = $customerData->getCustomerAllInformation($cart[0]->customer_id, $db);


// }


// 	//$foods = $foodData->getFood()


// 	// echo "<pre>";
// // print_r($foods);
// // echo "</pre>";







// class PDF extends FPDF
// {

// 	function convert($data)
// 	{
// 		return iconv('utf-8', 'ISO-8859-9', $data."ßbakıntürkçe var");
// 	}
// 	function Header()
// 	{
// 		$this->Image("../images/newlogo.png", 34, 5, 14);
// 		$this->SetFont('arial', "", 7);
// 		$this->MultiCell(62, 10, iconv('utf-8', 'ISO-8859-9', 'Bad Salziger Pizza  Kebab Haus Alte Heerstraße 6  56154 Boppard-Bad Salzig'), 0, 0, "C");
// 	}
// 	function infoB()
// 	{
// 		$this->SetFont('courier', "B", 9);
// 		$this->Cell(10, 20, "", 0, 1);
// 	}


// 	function customer($name, $address, $contact, $mahalle)
// 	{
// 		// $this->SetFont('Arial', "", 9);
// 		// $this->Cell(62, 4, iconv('utf-8', 'ISO-8859-9', "ßıiş"), 1, 1, "C");

// 		$this->SetFont('arial', "", 7);
// 		$this->Cell(62, 3, iconv('utf-8', 'ISO-8859-9', $name), 1, 1, "C");

// 		$this->SetFont('arial', "", 9);
// 		$this->Cell(62, 4, "TELEFON", 1, 1, "C");


// 		$this->SetFont('courier', "", 7);
// 		$this->Cell(62, 3, $contact, 1, 1, "C");

// 		$this->SetFont('arial', "", 9);
// 		$this->Cell(62, 4, "Mahalle", 1, 1, "C");

// 		$this->SetFont('arial', "", 7);
// 		$this->Cell(62, 3, $mahalle, 1, 1, "C");

// 		$this->SetFont('courier', "B", 9);
// 		$this->Cell(62, 4, "Adresse", 1, 1, "C");
// 		$this->SetFont('arial', "", 9);
// 		$this->Cell(62, 5, iconv('utf-8', 'ISO-8859-9', $address), 0, 1, "C");

// 		$this->Cell(62, 0.1, "", 1, 1);
// 	}






// 	function info($title, $qty, $price, $total)
// 	{

// 		$this->Cell(20, 15, "", 0, 1, "C");
// 		$this->SetFont("courier", "B", 15);
// 		$this->Cell(4, 3, $qty, 1, 0);
// 		$this->SetFont("courier", "", 8);
// 		$this->Cell(4, 3, "X", 1, 0);
// 		$this->SetFont("arial", "", 8);
// 		$this->MultiCell(16, 6, "Baslikli yemek siparisi", 1, 0);
// 		$this->Ln();
// 		$this->Cell(16, 6, '', 0, 0);
// 		$this->MultiCell(10, 6, $price, 0, 0);
// 		;
// 		$this->MultiCell(10, 6, $price, 1, 1, "C");

// 		$this->Cell(6, 2, "", 1, 1);

// 		$this->MultiCell(16, 6, "Baslikli yemek siparisi", 1, 0);
// 		$this->Ln();
// 		$this->Cell(16, 6, '', 0, 0);
// 		$this->MultiCell(10, 6, $price, 0, 0);

// 		$this->Cell(35, 3, $title, 1, 0);

// 		$this->Cell(13, 3, $qty, 1, 0);
// 		$this->Cell(13, 3, $price, 1, 0);
// 		$this->Cell(20, 3, $total, 1, 1);

// 	}

// 	function infoTotalPrice($total, $indirim)
// 	{
// 		$this->SetFont("courier", "B", 10);
// 		$this->Cell(65, 5, "Total Price : ", 1, 0, "C");
// 		$this->Cell(20, 5, $total + $indirim, 1, 1, "C");
// 	}

// 	function takeAway($indirim)
// 	{
// 		$this->SetFont("courier", "B", 9);
// 		$this->Cell(65, 5, "Rabatt fur kommen und kaufen : ", 1, 0, "C");
// 		$this->Cell(20, 5, $indirim, 1, 1, "C");
// 	}

// 	function delivery($indirim)
// 	{
// 		$this->SetFont("courier", "B", 9);
// 		$this->Cell(65, 5, "Liefergebuhr nach Hause : ", 1, 0, "C");
// 		$this->Cell(20, 5, $indirim, 1, 1, "C");
// 	}
// }

// $name = $customer->customer_full_name;
// $address = $customer->customer_address;
// $contact = $customer->customer_number;
// $mahalle = $customer->customer_mahalle;


// $indirim = 3;




// $pdf = new PDF();
// $pdf->AddPage('P', 'A7');

// // $pdf->AddFont('arial','','Arimo-Regular.php'); 


// $pdf->infoB();
// $pdf->customer($name, $address, $contact, $mahalle);
// //$pdf->tableHeader();


// $total = 0;
// $count = 0;
// foreach ($cart as $food) {
// 	$foods = $foodData->getFood($food->food_id, $db);
// 	$pdf->info($foods[0]->title, $food->qty, $food->price, $food->total_price);


// 	$total = $total + $food->total_price;
// 	$count = $count + $food->qty;


// }



// if ($cart[0]->order_type == "take-away") {
// 	$indirim = -1 * $count;
// 	$pdf->takeAway($indirim);

// } elseif ($cart[0]->order_type == "delivery") {

// 	$mahalle = $customer->customer_mahalle;
// 	if ($mahalle == "Bad Salzig (€ 1.50)") {
// 		$indirim = 1.50;
// 	} elseif ($mahalle == "Spay (€ 3.00)") {
// 		$indirim = 3;
// 	} else {
// 		$indirim = 2.5;
// 	}

// 	$pdf->delivery($indirim);
// }
// $pdf->infoTotalPrice($total, $indirim);


// $pdf->Output();













































// 	 include('../config/constants.php');
// 	require("fpdf/fpdf.php");

// 	require_once("partials/getData/getData.php"); 

// 	$cartData = new cartData();
// 	$foodData = new foodData();
// 	$customerData = new customerData();


// 	if(isset($_GET["cart_id"])){

// 	$cart_id = $_GET["cart_id"];

// 	$cart = $cartData->getAllCart($cart_id, $db);
// 	$customer = $customerData->getCustomerAllInformation($cart[0]->customer_id,$db);




// 	//$foods = $foodData->getFood()


// 	// echo "<pre>";
// 	// print_r($foods);
// 	// echo "</pre>";


// 	}





// 	class PDF extends FPDF
// 	 {
// 		function Header(){
// 			$this->Image("../images/newlogo.png",5,5,14);
// 		}

// 		function customer($name, $address, $contact, $mahalle){
// 			$this->SetFont('courier',"B",9);
// 			$this->Cell(30,5,"",0,0);
// 			$this->Cell(25,5,"Name : ",0,0,"R");
// 			$this->SetFont('courier',"",9);
// 			$this->Cell(25,5,$name,0,1,"L");

// 			$this->Cell(30,5,"",0,0);
// 			$this->SetFont('courier',"B",9);
// 			$this->Cell(25,5,"Telefon : ",0,0,"R");
// 			$this->SetFont('courier',"",9);
// 			$this->Cell(25,5,$contact,0,1,"L");

// 			$this->Cell(30,5,"",0,0);
// 			$this->SetFont('courier',"B",9);
// 			$this->Cell(25,5,"Mahalle : ",0,0,"R");
// 			$this->SetFont('courier',"",9);
// 			$this->Cell(25,5,$mahalle,0,1,"L");

// 			$this->SetFont('courier',"B",9);
// 			$this->Cell(20,5,"Adresse : ",0,1,"L");
// 			$this->SetFont('courier',"",9);
// 			$this->Cell(25,5,$address,0,1,"L");
// 		}


// 		function tableHeader(){
// 			$this->Cell(20,15,"",0,1,"C");
// 			$this->SetFont('courier',"B",7);
// 			$this->Cell(4,4,"#",1,0,"C");
// 			$this->Cell(35,4,"ESSEN",1,0,"C");
// 			$this->Cell(13,4,"STUCK",1,0,"C");
// 			$this->Cell(13,4,"PREIS",1,0,"C");
// 			$this->Cell(20,4,"GESAMT",1,1,"C");
// 		}

// 		function info($title,$qty,$price,$total,$sn){
// 			$this->SetFont("courier","");
// 			$this->Cell(4,3,$sn,1,0);
// 			$this->Cell(35,3,$title,1,0);
// 			$this->Cell(13,3,$qty,1,0);
// 			$this->Cell(13,3,$price,1,0);
// 			$this->Cell(20,3,$total,1,1);

// 		}

// 		function infoTotalPrice($total,$indirim){
// 			$this->SetFont("courier","B", 10);
// 			$this->Cell(65,5,"Total Price : ",1,0,"C");
// 			$this->Cell(20,5, $total+$indirim ,1,1,"C");
// 		}

// 		function takeAway($indirim){
// 			$this->SetFont("courier","B", 9);
// 			$this->Cell(65,5,"Rabatt fur kommen und kaufen : ",1,0,"C");
// 			$this->Cell(20,5, $indirim ,1,1,"C");
// 		}

// 		function delivery($indirim){
// 			$this->SetFont("courier","B", 9);
// 			$this->Cell(65,5,"Liefergebuhr nach Hause : ",1,0,"C");
// 			$this->Cell(20,5, $indirim ,1,1,"C");
// 		}
// 	 }

// 	$name = $customer->customer_full_name;	
// 	 $address= $customer->customer_address ;
// 	 $contact = $customer->customer_number; 
// 	 $mahalle = $customer->customer_mahalle;


// 	 $indirim = 3;




//  $pdf = new PDF();
//  $pdf->AddPage('P','A6');

// // $pdf->AddFont('arial','','Arimo-Regular.php'); 


// //$turkce_icerik = iconv('utf-8', 'ISO-8859-9', 'ŞüİĞ gibi harfleri artık kullanabiliriz');
// $pdf->customer($name, $address, $contact, $mahalle);
// $pdf->tableHeader();

// $sn=1;
// $total = 0;
// $count = 0;
// foreach($cart as $food){
// 	$sn = 1;
// 	$foods =$foodData->getFood($food->food_id, $db);
// 	$pdf->info($foods[0]->title, $food->qty,$food->price,$food->total_price, $foods[0]->food_code);
// 	$sn++;

// 	$total = $total+ $food->total_price;
// 	$count = $count + $food->qty;


// }



// if($cart[0]->order_type == "take-away"){
// 	$indirim = -1*$count;
// $pdf->takeAway($indirim);

// }
// elseif($cart[0]->order_type == "delivery"){

// 	$mahalle = $customer->customer_mahalle;
// 	if($mahalle =="Bad Salzig (€ 1.50)"){
// 		$indirim = 1.50;
// 	}elseif($mahalle == "Spay (€ 3.00)"){
// 		$indirim = 3;
// 	}else{
// 		$indirim= 2.5;
// 	}

// 	$pdf->delivery($indirim);
// }
// $pdf->infoTotalPrice($total,$indirim);


//  $pdf->Output();



?>
