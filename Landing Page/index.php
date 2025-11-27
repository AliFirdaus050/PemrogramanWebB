<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Museum Siola</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Poppins, sans-serif;
    }

    body {
      line-height: 1.6;
      color: #333;
    }

    nav {
      position: sticky;
      top: 0;
      background: black;
      backdrop-filter: blur(5px);
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 40px;
      z-index: 1000;
    }
    nav .logo {
      color: white;
      font-size: 22px;
      font-weight: bold;
      letter-spacing: 1px;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }
    nav ul li a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      transition: color 0.3s;
    }
    nav ul li a:hover {
      color: #ffd700;
    }

    .welcome {
      width: 100%; 
      height: 100vh;
      background: url("Foto/gambarbg.jpg") no-repeat center center;
      background-size: cover;
      background-color: black;
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: white;
      position: relative;
    }
    .welcome::after {
      content: "";
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0, 0, 0, 0.5);
    }
    .welcome-content {
      position: relative;
      z-index: 2;
    }
    .welcome-content h1 {
      font-size: 48px;
      margin-bottom: 20px;
    }
    .welcome-content p {
      font-size: 20px;
    }

    .about {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 60px 40px;
      background: #f7f7f7;
    }
    .about h2 {
      font-size: 32px;
      margin-bottom: 15px;
      text-align: left;
    }
    .about-content {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 40px;
      max-width: 1200px;
      margin: 0 auto;
    }
    .about-text {
      flex: 1;
      font-size: 18px;
      line-height: 1.8;
      text-align: justify;
    }
    .about-image {
      flex: 1;
      display: flex;
      justify-content: center;
    }
    .about-image img {
      width: 100%;
      max-width: 450px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.2);
      object-fit: cover;
    }

    @media (max-width: 768px) {
      .about-content {
        flex-direction: column;
        text-align: center;
      }
      .about-text {
        text-align: justify;
      }
      .about-image img {
        max-width: 100%;
      }
    }

    .gallery {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
      background: #272626;
      text-align: center;
    }
    .gallery h2 {
      font-size: 40px;
      margin-top: 10px;
      margin-bottom: 10px;
      color: white;
    }
    .gallery-container {
      position: relative;
      display: flex;
      align-items: center;
      justify-content: center;
      max-width: 90%;
      margin: auto;
      margin-top: 25px;
      overflow: hidden;
    }
    .gallery-images {
      display: flex;
      gap: 30px;
      overflow-x: auto;
      scroll-behavior: smooth;
      scrollbar-width: none;
      -ms-overflow-style: none;
    }
    .gallery-images img {
      border-radius: 12px;
      width: 400px;
      height: 310px;
      object-fit: cover;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }
    .gallery-btn {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background: rgba(0,0,0,0.5);
      color: white;
      font-size: 28px;
      border: none;
      padding: 12px;
      cursor: pointer;
      border-radius: 50%;
      z-index: 2;
    }
    .gallery-btn:hover {
      background: rgba(0,0,0,0.8);
    }
    .gallery-btn.left {
      left: -10px;
    }
    .gallery-btn.right {
      right: -10px;
    }

    .ticket {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 60px 20px;
      background: #f7f7f7;
      text-align: center;
    }

    .ticket-box {
      background: white;
      padding: 30px 40px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
      max-width: 500px;
      width: 100%;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .ticket-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.2);
    }
    .ticket-box h2 {
      font-size: 28px;
      margin-bottom: 25px;
      color: #222;
    }
    .ticket-box form label {
      font-weight: 600;
      margin-bottom: 6px;
      display: block;
      color: #444;
      text-align: left;
    }
    .ticket-box form input,
    .ticket-box form select {
      width: 100%;
      padding: 12px;
      margin-bottom: 18px;
      border-radius: 10px;
      border: 1px solid #ddd;
      font-size: 15px;
      transition: border 0.2s ease, box-shadow 0.2s ease;
    }
    .ticket-box form input:focus,
    .ticket-box form select:focus {
      border-color: #0077cc;
      box-shadow: 0 0 6px rgba(0, 119, 204, 0.3);
      outline: none;
    }
    .ticket-box form button {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #0077cc, #005fa3);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 16px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease, transform 0.2s ease;
    }
    .ticket-box form button:hover {
      background: linear-gradient(135deg, #005fa3, #004080);
      transform: translateY(-2px);
    }

    footer {
      padding: 20px;
      background: black;
      color: white;
      text-align: center;
    }
  </style>
</head>
<body>

  <nav>
    <div class="logo">Museum Siola</div>
    <ul>
      <li><a href="#home">Home</a></li>
      <li><a href="#about">Tentang</a></li>
      <li><a href="#galeri">Galeri</a></li>
      <li><a href="#ticket">Tiket</a></li>
    </ul>
  </nav>

  <section id="home" class="welcome">
    <div class="welcome-content">
      <h1>Selamat Datang di Museum Surabaya Siola</h1>
      <p>Menelusuri Sejarah & Budaya Kota Pahlawan</p>
    </div>
  </section>

  <section id="about" class="about">
    <div class="about-content">
      <div class="about-image">
        <img src="Foto/museum.jpg" alt="Foto Museum Surabaya">
      </div>
      <div class="about-text">
        <h2>Tentang Museum</h2>
        <p>
          Museum Surabaya, yang dikenal juga dengan nama Museum Siola, terletak di 
          <strong>Jl. Tunjungan No.1, Genteng, Kec. Genteng, Surabaya</strong>, sebuah kawasan bersejarah 
          yang menjadi saksi perkembangan perdagangan dan budaya kota sejak abad ke-19. Museum ini menyimpan koleksi artefak yang beragam, mulai dari dokumen, foto, peta kuno, hingga benda-benda peninggalan kolonial Belanda yang mencerminkan perjalanan sejarah Kota Pahlawan.
        </p>
        <p>
          Di setiap ruangannya, pengunjung dapat menelusuri sejarah perjuangan kemerdekaan Surabaya, kehidupan masyarakat lokal pada masa lalu, hingga perkembangan ekonomi dan teknologi kota dari masa ke masa.
        </p>
      </div>
    </div>
  </section>

  <section id="galeri" class="gallery">
    <h2>Galeri Museum</h2>
    <div class="gallery-container">
      <button class="gallery-btn left" onclick="scrollGallery(-1)">&#10094;</button>
      <div class="gallery-images" id="gallery">
        <img src="Foto/gambar0.jpg" alt="Foto 1">
        <img src="Foto/gambar2.jpg" alt="Foto 2">
        <img src="Foto/gambar3.jpg" alt="Foto 3">
        <img src="Foto/gambar4.jpg" alt="Foto 4">
        <img src="Foto/gambar5.jpg" alt="Foto 5">
        <img src="Foto/gambar6.jpg" alt="Foto 6">
        <img src="Foto/gambar7.jpg" alt="Foto 7">
        <img src="Foto/gambar8.jpg" alt="Foto 8">
        <img src="Foto/gambar9.jpg" alt="Foto 9">
        <img src="Foto/gambar10.jpg" alt="Foto 10">
        <img src="Foto/gambar11.jpg" alt="Foto 11">
        <img src="Foto/gambar12.jpg" alt="Foto 12">
        <img src="Foto/gambar13.jpg" alt="Foto 13">
        <img src="Foto/gambar14.jpg" alt="Foto 14">
        <img src="Foto/gambar15.jpg" alt="Foto 15">
        <img src="Foto/gambar16.jpg" alt="Foto 16">
      </div>
      <button class="gallery-btn right" onclick="scrollGallery(1)">&#10095;</button>
    </div>
  </section>

  <section id="ticket" class="ticket">
    <div class="ticket-box">
      <h2>Pemesanan Tiket</h2>
      <form action="proses_tiket.php" method="POST">
        <label for="nama">Nama Lengkap</label>
        <input type="text" id="nama" name="nama" required placeholder="Masukkan nama anda">

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required placeholder="contoh@email.com">

        <label for="tanggal">Tanggal Kunjungan</label>
        <input type="date" id="tanggal" name="tanggal" required>

        <label for="jumlah">Jumlah Tiket</label>
        <select id="jumlah" name="jumlah" required>
          <option value="1">1 Tiket</option>
          <option value="2">2 Tiket</option>
          <option value="3">3 Tiket</option>
          <option value="4">4 Tiket</option>
          <option value="5">5 Tiket</option>
        </select>

        <button type="submit">Pesan Tiket</button>
      </form>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 Museum Siola - Semua Hak Dilindungi</p>
  </footer>

  <script>
    function scrollGallery(direction) {
      const gallery = document.getElementById("gallery");
      const scrollAmount = 450;
      gallery.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
      });
    }
  </script>

</body>
</html>