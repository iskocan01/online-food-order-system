<?php include('partials-front/menu.php'); ?>

<div class="container mt-5">
    <h2>Müşteri Bilgileri</h2>
    <table class="table">
      <thead>
        <tr>
          <th scope="col">Müşteri Adı</th>
          <th scope="col">Telefon Numarası</th>
          <th scope="col">Sipariş Sayısı</th>
          <th scope="col">Eylemler</th>
        </tr>
      </thead>
      <tbody>

        <?php 
          $select = "SELECT MAX(id) as id, 
                  customer_full_name, 
                  customer_number, 
                  customer_email, 
                  customer_mahalle, 
                  customer_address, 
                  customer_zip, 
                  customer_password, 
                  customer_verification, 
                  verification_code, 
                  email_verified_at
           FROM tbl_customer
           GROUP BY customer_email;";

          $customers = $db->query($select, PDO::FETCH_OBJ)->fetchAll();

          echo "<h3>".count($customers)."</h3>";
         
         /* echo "<pre>";
          print_r($customers);
          echo "</pre>";*/

          foreach($customers as $customer){
          ?>

           <tr>
          <td><?php echo $customer->customer_full_name; ?></td>
          <td><?php echo $customer->customer_number; ?></td>

          <!-- Buraya bir fonk siyon yazacağım mail adresine sahip kac adet id var bunu bulacağız daha sonra idler ile order tablosunda karşılaştırma yapacağız -->
          <td>3</td>
          <td>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#orderModal">Eski Siparişler</button>
            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#emailModal">E-posta Gönder</button>
            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#infoModal-<?php echo $customer->id; ?>">Görüntüle</button>
          </td>
        </tr>

       <!-- Müşteri bilgilerin olduğu modal  -->
        <div class="modal fade" id="infoModal-<?php echo $customer->id; ?>" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel"><?php echo $customer->customer_full_name; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!-- Buraya müşterinin eski siparişleri listelenebilir -->
                <p>Customer Email <?php echo $customer->customer_email; ?></p>
                <p>Örnek eski sipariş 2</p>
              </div>
            </div>
          </div>
        </div>


          <?php
          }
         ?>
       
       
        <!-- Diğer müşteri verileri buraya eklenebilir -->
      </tbody>
    </table>
  </div>
  
  <!-- Eski Siparişler Modal -->
  <div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="orderModalLabel">Eski Siparişler</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Buraya müşterinin eski siparişleri listelenebilir -->
          <p>Örnek eski sipariş 1</p>
          <p>Örnek eski sipariş 2</p>
        </div>
      </div>
    </div>
  </div>
  
  <!-- E-posta Gönder Modal -->
  <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="emailModalLabel">E-posta Gönder</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Buraya e-posta gönderme formu eklenebilir -->
          <form>
            <div class="mb-3">
              <label for="recipientEmail" class="form-label">Alıcı E-posta Adresi:</label>
              <input type="email" class="form-control" id="recipientEmail" required>
            </div>
            <div class="mb-3">
              <label for="emailMessage" class="form-label">Mesajınız:</label>
              <textarea class="form-control" id="emailMessage" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Gönder</button>
          </form>
        </div>
      </div>
    </div>
  </div>


<?php include('partials-front/footer.php'); ?>