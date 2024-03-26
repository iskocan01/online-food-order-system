<?php include("../config/constants.php"); ?>
<style>
    .container-sm {
        width:75%;
        border: 1px solid black;
        margin:15px auto;
        background-color: #BFB9B8;
        box-shadow: 5px 10px ;
        border-radius: 22px; 
        padding: 2%;

    }
    .error{
        color: red;
    }
    h2{
        text-align: center;
    }
    p{
        text-align: center;
    }
    form {
        text-align:center;
    }
    form input {
        padding : 2%;
    }
</style>



<?php 
    if (isset($_GET['email'])) {
        // code... 
        $email = $_GET['email'];
    }
    else
    {
        header("location:".SITEURL);
    }
   
    //echo $email; 

        if (isset($_POST['submit'])) {
            $sql = "SELECT * FROM tbl_customer WHERE customer_email='$email' AND customer_verification ='No'";
            $res = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($res);
            if ($res == true) {
                if ($count == 1) {
                    $row = mysqli_fetch_assoc($res);
                    $id = $row['id'];
                     $_SESSION['user']=$id;
                    $code = $row['verification_code'];        
                    }
            }else{
                $code = "böyle bir mail adresi bulunamadı Kayıt ol";
            }

            $date= date('Y-m-d h:i:sa:');

            if (isset($_POST['verification'])) {
                $verification = $_POST['verification'];
                if ($verification == $code) {
                    //burada müşteriye ait olan kısmı güncelleyim doğrulmamının tamalandığını görmemiz gerekecek 
                    //müsteri doğrulama tarihini ve doğrulama statüsününü onaylayacağız
                    $sql2 = "UPDATE tbl_customer  SET
                    customer_verification ='Yes',
                    email_verified_at = '$date'
                    WHERE customer_email ='$email' AND customer_verification='No'
                    ";
                    $res2 = mysqli_query($conn, $sql2);

                    if ($res2==true) {
                        // code...
                       
                        header("location:".SITEURL);
                    }else
                    {
                        echo "no its doesnt work";
                    }
                    

                }
                else{
                    ///doğrulama kodu ile gercek kod doğrulanamadı
                    $_SESSION['durum'] = "<div class = 'error'> DOğrulama kodunu yanlış girdiniz lütfen tekrar dendeyin </div>"; 
                    header("location:".SITEURL."mail/verification-mail.php?email=".$email);
                }

            }
            else{
                echo "doğrulama alanını doldurmak zorundasınız";
            }
 

        }


     ?>





<div class="container-sm border">
     <?php
        
      if(isset($_SESSION['durum'])){
        echo $_SESSION['durum']."selamıun aleykum reis";

        unset($_SESSION['durum']);
         
    } ?>
    <h2> <?php echo $_GET["email"]?></h2>
    <p>Ein Bestätigungscode wurde an Ihre Adresse gesendet. Überprüfen Sie bitte.</p>
   
  
    <form action="" method="POST">
        <input type="text" name="verification" placeholder="Bestätigungs-Code" required>
        <input type="submit" name="submit" value="Verifizieren">
    </form>
    <a href="<?php echo SITEURL; ?>customer-settings.php/">Meine E-Mail-Adresse ändern</a><br><a href="../contact.php">Bestätigungscode nicht erhalten</a> <br><a href="../contact.php">Unterstützung</a>

    <p></p>
</div>


 
