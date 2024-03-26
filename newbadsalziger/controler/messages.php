<?php include('partials-front/menu.php'); ?>

<div class="container mt-5">
  <h2>Yemek Yorumları</h2>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">Yemek Adı</th>
        <th scope="col">Ortalama Puan</th>
        <th scope="col">Yorum Sayısı</th>
        <th scope="col">Yorumları Görüntüle</th>
      </tr>
    </thead>
    <tbody>
      <!-- Örnek yemek verileri -->
      <tr>
        <td>Spagetti Bolognese</td>
        <td>
          <span class="text-warning">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="far fa-star"></i>
          </span>
          4.0
        </td>
        <td>5</td>
        <td>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#commentsModal1">Görüntüle</button>
        </td>
      </tr>
      <tr>
        <td>Margarita Pizza</td>
        <td>
          <span class="text-warning">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="far fa-star"></i>
            <i class="far fa-star"></i>
          </span>
          3.0
        </td>
        <td>3</td>
        <td>
          <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#commentsModal2">Görüntüle</button>
        </td>
      </tr>
      <!-- Diğer yemek verileri buraya eklenebilir -->
    </tbody>
  </table>
</div>

<!-- Yorumlar Modal - Spagetti Bolognese -->
<div class="modal fade" id="commentsModal1" tabindex="-1" aria-labelledby="commentsModalLabel1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commentsModalLabel1">Spagetti Bolognese Yorumları</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Yorum</th>
              <th scope="col">Puan</th>
              <th scope="col">Kim Tarafından</th>
            </tr>
          </thead>
          <tbody>
            <!-- Spagetti Bolognese yorumları buraya eklenebilir -->
            <tr>
              <td>Harika bir lezzet!</td>
              <td>
                <span class="text-warning">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                </span>
              </td>
              <td>Ali</td>
            </tr>
            <tr>
              <td>Çok doyurucu!</td>
              <td>
                <span class="text-warning">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                </span>
              </td>
              <td>Ayşe</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Yorumlar Modal - Margarita Pizza -->
<div class="modal fade" id="commentsModal2" tabindex="-1" aria-labelledby="commentsModalLabel2" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="commentsModalLabel2">Margarita Pizza Yorumları</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Yorum</th>
              <th scope="col">Puan</th>
              <th scope="col">Kim Tarafından</th>
            </tr>
          </thead>
          <tbody>
            <!-- Margarita Pizza yorumları buraya eklenebilir -->
            <tr>
              <td>En iyi pizza!</td>
              <td>
                <span class="text-warning">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                </span>
              </td>
              <td>Mehmet</td>
            </tr>
            <tr>
              <td>İçinde bolca peynir var.</td>
              <td>
                <span class="text-warning">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="far fa-star"></i>
                  <i class="far fa-star"></i>
                </span>
              </td>
              <td>Zeynep</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>



<?php include('partials-front/footer.php'); ?>