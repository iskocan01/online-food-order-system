<?php include('partials-front/menu.php'); ?>

<div class="container mt-5">
  <h2>Müşteri Şikayetleri</h2>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Müşteri İsmi</th>
        <th scope="col">Şikayet</th>
        <th scope="col">İşlemler</th>
      </tr>
    </thead>
    <tbody>
      <!-- Örnek şikayet verileri -->
      <tr>
        <td>Ali</td>
        <td>Ürünüm geldi fakat hasarlıydı.</td>
        <td>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal1">Yanıt Ver</button>
          <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal1">Sil</button>
        </td>
      </tr>
      <tr>
        <td>Ayşe</td>
        <td>Siparişim gecikti, bu konuda bir açıklama istiyorum.</td>
        <td>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal2">Yanıt Ver</button>
          <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal2">Sil</button>
        </td>
      </tr>
      <!-- Diğer şikayet verileri buraya eklenebilir -->
    </tbody>
  </table>
</div>

<!-- Yanıt Ver Modal - Şikayet 1 -->
<div class="modal fade" id="responseModal1" tabindex="-1" aria-labelledby="responseModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="responseModalLabel1">Müşteriye Yanıt Ver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Üzgünüz, yaşadığınız sorun için özür dileriz. Sorununuzu çözmek için çalışıyoruz. Lütfen bekleyin.</p>
      </div>
    </div>
  </div>
</div>

<!-- Yanıt Ver Modal - Şikayet 2 -->
<div class="modal fade" id="responseModal2" tabindex="-1" aria-labelledby="responseModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="responseModalLabel2">Müşteriye Yanıt Ver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Özür dileriz, gecikme konusunda yaşadığınız sıkıntı için üzgünüz. En kısa sürede size bilgi vereceğiz.</p>
      </div>
    </div>
  </div>
</div>

<!-- Silme İşlemi Modal - Şikayet 1 -->
<div class="modal fade" id="confirmDeleteModal1" tabindex="-1" aria-labelledby="confirmDeleteModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel1">Şikayeti Sil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Şikayeti silmek istediğinize emin misiniz?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
        <button type="button" class="btn btn-danger">Sil</button>
      </div>
    </div>
  </div>
</div>

<!-- Silme İşlemi Modal - Şikayet 2 -->
<div class="modal fade" id="confirmDeleteModal2" tabindex="-1" aria-labelledby="confirmDeleteModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmDeleteModalLabel2">Şikayeti Sil</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Şikayeti silmek istediğinize emin misiniz?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Vazgeç</button>
        <button type="button" class="btn btn-danger">Sil</button>
      </div>
    </div>
  </div>
</div>


<?php include('partials-front/footer.php'); ?>