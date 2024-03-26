<?php include("../config/constants.php"); ?>
<?php 
if (isset($_GET['sepet_id'])) { 
	$sepet_id= $_GET['sepet_id'];

	$sql = "UPDATE tbl_order SET 
					onay = 'Onaylandı', 
					status = 'Hazırlanıyor' 
					WHERE sepet_id = $sepet_id
					"; 
	$res = mysqli_query($conn, $sql); 

	if ($res == true) {
		//oldu
		$_SESSION['siparis-durum']="<div class='success'>Sipariş Onaylandı</div>";
		$email = $_GET['email'];
		header("location:".SITEURL."mail/siparis-onay-mail.php?sepet_id=".$sepet_id."&email=".$email);


	}
	else
	{
		//olmadı
			$_SESSION['siparis-durum']="<div class='error'>sıkıntı</div>";
			header("location:".SITEURL."admin/manage-order.php");
	}

	  

}
else
{

}

 ?>