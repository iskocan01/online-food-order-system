<?php include('partials-front/menu.php'); ?>

<div class="container mt-5">
  <h2>Ayarlar</h2>
  <form>
    <div class="mb-3">
      <label for="firstName" class="form-label">Adınız</label>
      <input type="text" class="form-control" id="firstName" placeholder="Adınızı girin">
    </div>
    <div class="mb-3">
      <label for="lastName" class="form-label">Soyadınız</label>
      <input type="text" class="form-control" id="lastName" placeholder="Soyadınızı girin">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-posta Adresiniz</label>
      <input type="email" class="form-control" id="email" placeholder="E-posta adresinizi girin">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Şifreniz</label>
      <input type="password" class="form-control" id="password" placeholder="Şifrenizi girin">
    </div>
    <div class="mb-3">
      <label for="communicationPreference" class="form-label">İletişim Tercihleri</label>
      <select class="form-select" id="communicationPreference">
        <option value="email">E-posta</option>
        <option value="sms">SMS</option>
        <option value="none">Hiçbiri</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Kaydet</button>
  </form>
</div>

<?php include('partials-front/footer.php'); ?>