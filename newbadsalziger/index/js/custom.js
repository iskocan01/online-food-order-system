 
 // jQuery kullanarak basit bir AJAX örneği
function checkForNewOrders() {
	$.ajax({
	  url: 'kontrol_script.php', // Sipariş kontrolü için bir PHP dosyası
	  type: 'GET',
	  success: function (data) {
		// Veri tabanından gelen yeni siparişleri işle ve sayfaya ekle
		$('#siparisListesi').html(data);
	  }
	});
  }
  
  // Belirli aralıklarla fonksiyonu çağır
  setInterval(checkForNewOrders, 60000); // Her 1 dakikada bir kontrol et




  

$(document).ready(function(){

 
  $('.modal').on('hidden.bs.modal', function () {
    $('.modal-backdrop').remove();
});

 
	$(".addToCartBtn").click(function(){

 

		var url="http://localhost/newbadsalziger/config/cart-db.php";

		var id = $(this).attr("product-id");
		var meat_id = "meat"+id;
		 
		 

		var data = {
			p: "addToCart",
			food_id: id,
			checkedValues: $('input[name="product"]:checked').map(function(){ 
				return $(this).val();
			}).get().join(","),
			radio: $('input[name="'+meat_id+'"]:checked').val() 
			
		}	

		 
		$.post(url,data,function (response){
			 
			 

			console.log(response);
			
			$(".cart-count").text(response);
			window.location.reload(); 
			
			 
		});





		
		// var url="http://localhost/badsalziger/config/cart-db.php";
		// var data = {
		// 	p: "addToCart",
		// 	food_id: $(this).attr("product-id"), 
			
		// } 
		// $.post(url,data,function (response){
		// $(".cart-count").text(response);
		// window.location.reload(); 
		 
			
		//  })
	})


	$(".removeFromCartBtn").click(function(){

		var url ="http://localhost/newbadsalziger/config/cart-db.php";
		var data = {
			p: "removeFromCart",
			food_id: $(this).attr("product-id")
			//product_id: $(this).attr("extras")
		}
		$.post(url,data,function (response){
			  
			window.location.reload(); 
		})
	})


	$(".login-customer").click(function(){
	 
		$(location).attr('href', 'http://localhost/newbadsalziger/login-customer.php');
	})



 
	  
})