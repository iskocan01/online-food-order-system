<?php include('../config/constants.php'); ?>

<?php if(!isset($_SESSION["user_id"])){
    $_SESSION["no-login-message"]="<div class='text-center text-danger'>Giris Yapınız!!</div>";
    header("location:".SITEURL.CONTROL."login-admin.php");
}

 ?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bad Salziger Login System</title>
    
    <link rel="icon" href="<?php echo SITEURL; ?>images/newlogo1.png" type="image/x-icon"/> 

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="css/style.css">


<style>
    .success-message, .error-message {
        display: block;
        position: fixed;
        top: 50%;
        left:50% ;
        transform: translate(-50%, -50%);
        padding: 15px;
        background-color: #4CAF50; /* Yeşil renk - başarı durumu için */
        color: white;
        border-radius: 5px;
        z-index: 1;
        animation: fadeOut 10s forwards;
    }

    @keyframes fadeOut {
        0% { opacity: 1; }
        100% { opacity: 0; display: none; }
    }
</style>

<!-- index.php dosyasında BODY bölümünde -->
<script>
    // Sayfa yüklendiğinde
    window.onload = function() {
        // Success message
        var successMessage = document.getElementById('success-message');
        if(successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 500000); // 2000 milisaniye (2 saniye) sonra başarı mesajını gizle
        }

        // Error message
        var errorMessage = document.getElementById('error-message');
        if(errorMessage) {
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 5000); // 2000 milisaniye (2 saniye) sonra hata mesajını gizle
        }
    };
</script>



     



</head>

<?php  
    $currentPage = $_SERVER['PHP_SELF'];
    // pathinfo fonksiyonu kullanarak dosya adını elde etme
    $fileInfo = pathinfo($currentPage);
    $fileName = $fileInfo['basename'];

   

     
?>
<body>




    <div class="container-is">
        <div class="navigation-is">
            <ul>
                <li >
                    <a href="<?php echo SITEURL.CONTROL; ?>">
                        <span class="icon"> 
                        <ion-icon name="logo-apple"></ion-icon>
                        </span>
                        <span class="title" >Brand Name</span>
                    </a>
                </li>
                <li <?php echo ($fileName == 'index.php') ? 'class="hovered"' : ''; ?>>
                    <a href="<?php echo SITEURL.CONTROL; ?>">
                        <span class="icon"><ion-icon name="home-outline"></ion-icon></span>
                        <span class="title" >Deshboard</span>
                    </a>
                </li>
                <li <?php echo ($fileName == 'customer.php') ? 'class="hovered"' : ''; ?>>
                    <a href="<?php echo SITEURL.CONTROL.'customer.php'; ?>">
                        <span class="icon"><ion-icon name="people-outline"></ion-icon> </span>
                        <span class="title">Customer</span>
                    </a>
                </li>
                <li <?php echo ($fileName == 'messages.php') ? 'class="hovered"' : ''; ?>>
                    <a href="<?php echo SITEURL.CONTROL.'messages.php'; ?>">
                        <span class="icon"><ion-icon name="chatbubble-ellipses-outline"></ion-icon></span>
                        <span class="title">Message</span>
                    </a>
                </li>
                <li <?php echo ($fileName == 'help.php') ? 'class="hovered"' : ''; ?> >
                    <a href="<?php echo SITEURL.CONTROL.'help.php'; ?>">
                        <span class="icon"><ion-icon name="information-circle-outline"></ion-icon></span>
                        <span class="title" >Help</span>
                    </a>
                </li>
                <li <?php echo ($fileName == 'settings.php') ? 'class="hovered"' : ''; ?>>
                    <a href="<?php echo SITEURL.CONTROL.'settings.php'; ?>">
                        <span class="icon"><ion-icon name="settings-outline"></ion-icon></span>
                        <span class="title" >Settings</span>
                    </a>
                </li>
                <li <?php echo ($fileName == 'password.php') ? 'class="hovered"' : ''; ?>>
                    <a href="<?php echo SITEURL.CONTROL.'password.php'; ?>">
                        <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></ion-icon></span>
                        <span class="title" >Password</span>
                    </a>
                </li>
                <li >
                    <a href="<?php echo SITEURL.CONTROL.'logout.php'; ?>">
                        <span class="icon"><ion-icon name="log-out-outline"></ion-icon></span>
                        <span class="title" >Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>

        <!--Main -->
        <div class="main">

            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>
                <!-- search -->
                <div class="search">
                    <label for="">
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div>
                <!-- User -->
                <div class="user">
                    <img src="../images/newlogo1.png" alt="">
                </div>
            </div>

            <?php
                if(isset($_SESSION['info-success'])) {
                    echo '<div id="success-message" class="success-message"><h1>' . $_SESSION['info-success'] . '</h1></div>';
                    unset($_SESSION['info-success']); // Mesajı bir kere gösterdikten sonra session'dan silmek iyi bir uygulamadır.
                }

                if(isset($_SESSION['info-error'])) {
                    echo '<div id="error-message" class="error-message">' . $_SESSION['info-error'] . '</div>';
                    unset($_SESSION['info-error']);
                }

               //  echo '<div id="success-message" class="success-message">' ."<h1>Sipariş onaylandı</h1>" . '</div>';
            
            ?>


            
