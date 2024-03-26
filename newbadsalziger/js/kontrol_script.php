<?php
include("../config/constants.php");
// Veritabanına bağlantı vb. gerekli işlemleri yapın

// Örnek veritabanı sorgusu
$query = "SELECT * FROM tbl_food_order ORDER BY cart_id DESC LIMIT 5";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Siparişleri almakta sorun oluştu: " . mysqli_error($connection));
}

// Siparişleri HTML olarak biçimlendirin ve geri döndürün
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="siparis">' .
        '<p>Sipariş ID: ' . $row['cart_id'] . '</p>' .
        '<p>Müşteri: ' . $row['customer_id'] . '</p>' .
        // Diğer sipariş bilgilerini ekleyin
        '</div>';
}

// Veritabanı bağlantısını kapatın
mysqli_close($conn);
?>
