<?php include "config.php";
$cheap = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services ORDER BY price_per_kg ASC LIMIT 1"));
?>
<html>
<head>
<title>WashWise Laundry | Where Your Laundry Belongs</title>
<link rel="stylesheet" href="style.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="navbar">
  <div class="logo">WashWise Laundry</div>
  <div>
    <a href="index.php">Home</a>
    <a href="#layanan">Layanan</a>
    <a href="#harga">Harga</a>
    <a href="#testimoni">Testimoni</a>
    <a href="login.php">Login</a>
    <a href="register.php" class="btn btn-blue" style="padding:8px 18px;">Pesan Sekarang</a>
  </div>
</div>

<div class="trust">
  <span>Dipercaya Oleh</span><br>
  <span>Apartemen Premium</span><span>Kantor & Bank</span><span>Sekolah Internasional</span><span>Hotel & Spa</span>
</div>

<div class="container">
  <!-- HERO like Kago -->
  <div class="hero">
    <div class="hero-grid">
      <div>
        <p class="eyebrow">WashWise Laundry</p>
        <h1>Where Your Laundry Belongs</h1>
        <span class="accent-bar"></span>
        <p>Semua kebutuhan laundry Anda di satu tempat — cuci kilo premium, satuan, tas, sepatu, dan lainnya.</p>
        <a href="register.php" class="btn btn-blue">Pesan Sekarang -></a>
        <a href="#layanan" class="btn btn-beige">Lihat Layanan</a>
        <div class="hero-badges">
          ✔ Available untuk pickup & delivery<br>
          ✔ Wet clean, hand wash, cuci kilo premium<br>
          ✔ Telah melayani 15.000+ pelanggan sejak 2016
        </div>
      </div>
      <div>
        <img src="img/folded.jpg" alt="Tumpukan pakaian bersih WashWise" class="hero-img">
      </div>
    </div>
  </div>

  <!-- LAYANAN KAMI -->
  <div class="card" id="layanan">
    <p class="eyebrow">Layanan Kami</p>
    <h2>Mencuci Menjadi Mudah.</h2>
    <span class="accent-bar"></span>
    <div class="price-list" style="margin-top:16px;">
      <?php
      $q = mysqli_query($conn, "SELECT * FROM services");
      while ($s = mysqli_fetch_assoc($q)) {
        echo "<div class='card price-card'>";
        echo "<h3>" . htmlspecialchars($s["name"]) . "</h3>";
        echo "<p><b>Rp " . $s["price_per_kg"] . " / kg</b></p>";
        echo "<p style='font-size:13px;color:#42556a;'>" . htmlspecialchars($s["description"]) . "</p>";
        echo "<a href='register.php' class='btn btn-beige' style='font-size:12px;padding:8px 16px;'>Pesan</a>";
        echo "</div>";
      }
      ?>
    </div>
    <div class="banner-row">
      <img src="img/machines.jpg" alt="Mesin laundry modern">
      <img src="img/washroom.jpg" alt="Ruang cuci bersih">
    </div>
  </div>

  <!-- HARGA TRANSPARAN + BENEFIT -->
  <div class="card" id="harga">
    <div class="split">
      <div>
        <p class="eyebrow">Harga Transparan</p>
        <h2>Semua Cucian,<br>Aman Dengan Kami!</h2>
        <span class="accent-bar"></span>
        <ul class="check">
          <li><b>Dijemput & diantar</b> langsung ke rumah Anda (slot 9-12, 13-15, 15-17)</li>
          <li><b>Dicuci, dikeringkan, dan dilipat rapi</b> — 1 mesin khusus 1 pelanggan + quality control</li>
          <li><b>Aman, wangi, dan tepat waktu</b> — setiap pesanan bisa dilacak di akun Anda</li>
          <li><b>Bonus loyalitas</b> — tiap 5 order dapat 1 poin reward</li>
          <li><b>Chat langsung dengan admin</b> per order untuk request khusus</li>
        </ul>
        <a href="register.php" class="btn btn-blue">Pesan Penjemputan -></a>
      </div>
      <div>
        <div class="card price-card" style="border-top:4px solid #C2632B;">
          <h3><?php echo $cheap ? htmlspecialchars($cheap["name"]) : "Regular Kilo"; ?></h3>
          <p style="font-size:32px;font-weight:800;color:#C2632B;">Rp <?php echo $cheap ? $cheap["price_per_kg"] : "8000"; ?><span style="font-size:13px;color:#42556a;"> /kg</span></p>
          <p style="font-size:12px;color:#8BA0B5;">rasa aman untuk setiap helai pakaian Anda</p>
          <a href="register.php" class="btn btn-blue">Lihat Detail</a>
        </div>
      </div>
    </div>
  </div>

  <!-- ANGKA -->
  <div class="dark-band">
    <p class="eyebrow">WashWise Dalam Angka</p>
    <h2>Dipercaya dari Tahun ke Tahun.</h2>
    <span class="accent-bar"></span>
    <div class="stat-grid">
      <div class="stat-card"><div class="num">350+</div><div class="lbl">Layanan</div></div>
      <div class="stat-card"><div class="num">15K+</div><div class="lbl">Pelanggan Setia</div></div>
      <div class="stat-card"><div class="num">10</div><div class="lbl">Tahun Pengalaman</div></div>
    </div>
  </div>

  <!-- TESTIMONI (fake) -->
  <div class="card" id="testimoni">
    <p class="eyebrow">Kata Mereka</p>
    <h2>Testimoni Pelanggan</h2>
    <span class="accent-bar"></span>
    <div class="testi-grid" style="margin-top:16px;">
      <div class="testi">
        <div class="stars">★★★★★</div>
        <p>"Langganan 2 tahun, baju kantor selalu rapi dan wangi. Pickup-nya on time, tracking statusnya jelas banget."</p>
        <b>- Ratna, Karyawan Bank (Jakarta Selatan)</b>
      </div>
      <div class="testi">
        <div class="stars">★★★★★</div>
        <p>"Sepatu putih saya kayak baru lagi setelah shoe spa di sini. Admin fast respon via chat, recommended!"</p>
        <b>- Dimas, Mahasiswa (Bintaro)</b>
      </div>
      <div class="testi">
        <div class="stars">★★★★★</div>
        <p>"Linen apartemen kami 100+ pcs per minggu di-handle rapi. Ada nota + QC, cocok untuk partner bisnis."</p>
        <b>- Mrs. Liu, Pengelola Apartemen (Senopati)</b>
      </div>
    </div>
  </div>

  <!-- KONTAK -->
  <div class="card">
    <p class="eyebrow">Hubungi Kami</p>
    <h2>Kami Siap Melayani Anda.</h2>
    <span class="accent-bar"></span>
    <p>Jl. Melati No. 26, Jakarta Selatan | washwise@mail.com | 0815-0000-1234</p>
    <a href="register.php" class="btn btn-blue">Buat Akun & Pesan -></a>
    <a href="login.php" class="btn btn-beige">Login</a>
  </div>
</div>
<div class="footer">WashWise Laundry - Where Your Laundry Belongs | melayani dengan sepenuh hati</div>
</body>
</html>
