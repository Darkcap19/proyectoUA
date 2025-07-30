<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Turístico Ecuador</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f1e5e5ff;   /* Fondo claro */
      color: #222;           /* Texto oscuro */
    }
    header {
      background-color: #00796b;
      color: white;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      flex-wrap: wrap;
    }
    .nav-left {
      display: flex;
      align-items: center;
    }
    .nav-left img {
      height: 40px;
      margin-right: 10px;
    }
    .nav-left span {
      font-weight: bold;
      font-size: 18px;
    }
    .nav-center {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }
    .nav-center a {
      color: white;
      text-decoration: none;
      font-size: 15px;
      padding: 4px 10px;
    }
    .nav-center a:hover,
    .nav-center a.active {
      background-color: #004d40;
      border-radius: 4px;
    }
    .nav-right {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .nav-right button {
      padding: 6px 12px;
      font-size: 14px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .btn-acceso {
      background-color: #d32f2f;
      color: white;
    }
    .btn-login {
      background-color: white;
      color: #004d40;
    }
    .dropdown {
      position: relative;
    }
    .menu-accesibilidad {
      position: absolute;
      top: 100%;
      left: 0;
      background-color: #004d40;
      display: none;
      flex-direction: column;
      border-radius: 4px;
      overflow: hidden;
      z-index: 999;
    }
    .menu-accesibilidad button {
      background-color: #004d40;
      color: white;
      border: none;
      padding: 10px 15px;
      text-align: left;
      font-size: 14px;
      cursor: pointer;
      border-bottom: 1px solid #00695c;
    }
    .menu-accesibilidad button:hover {
      background-color: #00695c;
    }
    #lupa {
      display: none;
      width: 100px;
      height: 100px;
      position: absolute;
      border: 2px solid #ccc;
      border-radius: 50%;
      pointer-events: none;
      transform: scale(2);
      z-index: 999;
    }
    .zoom {
      transform: scale(1.1);
      transform-origin: top left;
    }
    .high-contrast,
    .high-contrast * {
      background-color: black !important;
      color: yellow !important;
      border-color: yellow !important;
    }
    .large-text,
    .large-text * {
      font-size: 1.25em !important;
    }
    .small-text,
    .small-text * {
      font-size: 0.8em !important;
    }
    .dyslexic-font,
    .dyslexic-font * {
      font-family: 'OpenDyslexic', Arial, sans-serif !important;
    }
    .carousel {
      max-width: 90%;
      margin: 20px auto;
    }
    .carousel img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
    }
    #map {
      height: 300px;              /* puedes ajustar entre 200 y 300 */
      width: 600px;               /* ancho fijo */
      max-width: 90%;             /* para que sea responsive */
      margin: 20px auto;
      border-radius: 10px;
    }
    .destinos {
      max-width: 90%;
      margin: auto;
      display: flex;
      justify-content: space-between;
      gap: 20px;
      flex-wrap: wrap;
      margin-bottom: 40px;
    }
    .destino {
      background: #ffffff;
      color: #222; /* 👈 Forzamos color de texto visible */
      padding: 10px;
      border-radius: 10px;
      width: 30%;
      min-width: 250px;
    }
    .destino img {
      width: 100%;
      border-radius: 10px;
    }
    .destino h4 {
      margin: 10px 0 5px;
      color: #33d1b2;
    }
    .destino p {
      font-size: 14px;
    }
    .destino button {
      margin-top: 10px;
      background: #00796b;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
    }
    #modal {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 9999;
    }
    .modal-content {
      background-color: #fff;
      color: black;
      width: 100%;
      max-width: 360px;
      margin: 5% auto;
      padding: 25px 20px;
      border-radius: 12px;
      position: relative;
      box-sizing: border-box;
    }
    .close-btn {
      position: absolute;
      right: 15px;
      top: 10px;
      font-size: 20px;
      cursor: pointer;
    }
    .modal-content input[type="text"],
    .modal-content input[type="email"],
    .modal-content input[type="password"] {
      width: 100%;
      padding: 10px 12px;
      margin-bottom: 15px;
      box-sizing: border-box;
      font-size: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    .modal-content input[type="submit"] {
      width: 100%;
      background-color: #00796b;
      color: white;
      padding: 12px;
      border: none;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }
    .password-container {
      position: relative;
      width: 100%;
    }

    .password-container input {
      padding-right: 40px;
    }

    .toggle-password {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      font-size: 18px;
      color: #333;
    }

  </style>
</head>
 <?php include 'login_modal.php'; ?>

<body>
<header>
  <div class="nav-left">
    <img src="img/logo.png" alt="Logo">
    <span>PORTAL TURÍSTICO EC</span>
  </div>
 <div class="nav-center">
    <a href="index1.php">Inicio</a>
    <a href="rutas.php">Rutas</a>
    <a href="alojamientos.php">Alojamientos</a>
    <a href="accesibilidad.php">Accesibilidad</a>
    <a href="contacto.php">Contacto</a>
  </div>
  <div class="nav-right">
    <div class="dropdown">
      <button class="btn-acceso" onclick="toggleMenu()">
        <i class="fas fa-universal-access"></i> Accesibilidad ▼
      </button>
      <div class="menu-accesibilidad" id="menuAccesibilidad">
        <button onclick="document.body.classList.toggle('zoom')"><i class="fas fa-search-plus"></i> Zoom</button>
        <button onclick="toggleLupa()"><i class="fas fa-crosshairs"></i> Lupa puntual</button>
        <button onclick="document.body.classList.toggle('high-contrast')"><i class="fas fa-adjust"></i> Alto contraste</button>
        <button onclick="document.body.classList.add('large-text'); document.body.classList.remove('small-text')"><i class="fas fa-plus"></i> Aumentar texto</button>
        <button onclick="document.body.classList.add('small-text'); document.body.classList.remove('large-text')"><i class="fas fa-minus"></i> Reducir texto</button>
        <button onclick="document.body.classList.toggle('dyslexic-font')"><i class="fas fa-font"></i> Fuente legible</button>
        <button onclick="leerTexto()"><i class="fas fa-volume-up"></i> Lectura de texto</button>
        <button onclick="resetAccesibilidad()"><i class="fas fa-sync-alt"></i> Restablecer</button>
      </div>
    </div>
    <?php if (isset($_SESSION['nombre'])): ?>
      <form method="post" action="logout.php">
        <button type="submit" class="btn-login" style="background-color:#c62828; color:white;">
          Cerrar sesión (<?= htmlspecialchars($_SESSION['nombre']) ?>)
        </button>
      </form>
    <?php else: ?>
      <button class="btn-login" onclick="openModal()">Iniciar sesión</button>
    <?php endif; ?>

  </div>
</header>
  <div class="carousel">
    <img src="img/banner0.jpg" alt="Amazonía" id="carouselImage">
  </div>
  <h3 style="text-align:center">Mapa de Rutas Turísticas</h3>
  <div id="map"></div>
  <h3 style="text-align:center; color: #33d1b2;">Destinos Destacados</h3>
  <div class="destinos">
    <div class="destino">
      <img src="img/cuenca.jpg" alt="Cuenca">
      <h4>Cuenca</h4>
      <p>Ciudad patrimonial de la humanidad con arquitectura colonial y entorno tradicional.</p>
      <button>Ver más</button>
    </div>
    <div class="destino">
      <img src="img/salinas.jpg" alt="Salinas">
      <h4>Salinas</h4>
      <p>Hermosa playa del Pacífico con excelente infraestructura turística y accesibilidad.</p>
      <button>Ver más</button>
    </div>
    <div class="destino">
      <img src="img/manta.jpg" alt="Manta">
      <h4>Manta</h4>
      <p>Puerto pesquero con hermosas playas y deliciosa gastronomía marina.</p>
      <button>Ver más</button>
    </div>
  </div>
  <div id="lupa"></div>
  <script>
  function toggleMenu() {
    const menu = document.getElementById("menuAccesibilidad");
    menu.style.display = (menu.style.display === "flex") ? "none" : "flex";
  }
  function toggleLupa() {
    const lupa = document.getElementById("lupa");
    if (lupa.style.display === "none") {
      lupa.style.display = "block";
      document.addEventListener("mousemove", moverLupa);
    } else {
      lupa.style.display = "none";
      document.removeEventListener("mousemove", moverLupa);
    }
  }
  function moverLupa(e) {
    const lupa = document.getElementById("lupa");
    lupa.style.left = (e.pageX - 50) + "px";
    lupa.style.top = (e.pageY - 50) + "px";
  }
  function leerTexto() {
    const texto = document.querySelector("main")?.innerText || document.body.innerText;
    const msg = new SpeechSynthesisUtterance(texto);
    window.speechSynthesis.speak(msg);
  }
  function resetAccesibilidad() {
    document.body.classList.remove("zoom", "high-contrast", "large-text", "small-text", "dyslexic-font");
    document.getElementById("lupa").style.display = "none";
    document.removeEventListener("mousemove", moverLupa);
    window.speechSynthesis.cancel();
  }
  // Leaflet Map
  const map = L.map('map').setView([-1.8312, -78.1834], 6);
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
  L.marker([-2.9, -79.0]).addTo(map).bindPopup("Cuenca");
  L.marker([-2.2, -80.97]).addTo(map).bindPopup("Salinas");
  L.marker([-0.9677, -80.7165]).addTo(map).bindPopup("Manta");
  </script>

  <script>
    function openModal() {
      const modal = document.getElementById("modal");
      if (modal) modal.style.display = "block";
    }

    function closeModal() {
      const modal = document.getElementById("modal");
      if (modal) modal.style.display = "none";
    }

    // También permite cerrar el modal al hacer clic fuera
    window.onclick = function(event) {
      const modal = document.getElementById("modal");
      if (event.target === modal) {
        modal.style.display = "none";
      }
    }
      </script>
      <script>
  document.getElementById("formRegister").addEventListener("submit", async function (e) {
    e.preventDefault(); // evita recargar la página

    const data = {
      fName: this.fName.value,
      lName: this.lName.value,
      reg_email: this.reg_email.value,
      reg_password: this.reg_password.value,
      signUp: true
    };

    try {
      const response = await fetch("register.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();
      alert(result.mensaje);
      if (response.ok && result.mensaje.includes("✅")) {
        this.reset();
        closeModal(); // ✅ cierra el modal automáticamente
      }

    } catch (error) {
      console.error("❌ Error en el registro:", error);
      alert("Error en la conexión.");
    }
  });
</script>
<!-- Sección Rutas -->
<section id="rutas" style="padding: 40px; text-align: center;">
  <h2>Rutas Accesibles</h2>
  <p>Aquí encontrarás información sobre rutas adaptadas en Ecuador.</p>
</section>

<!-- Sección Alojamientos -->
<section id="alojamientos" style="padding: 40px; text-align: center;">
  <h2>Alojamientos Inclusivos</h2>
  <p>Hoteles, hostales y alojamientos adaptados para todos.</p>
</section>

<!-- Sección Accesibilidad -->
<section id="accesibilidad" style="padding: 40px; text-align: center;">
  <h2>Accesibilidad</h2>
  <p>Conoce las características de accesibilidad que ofrece nuestro portal.</p>
</section>

<!-- Sección Contacto -->
<section id="contacto" style="padding: 40px; text-align: center;">
  <h2>Contacto</h2>
  <p>Puedes escribirnos a: <a href="mailto:info@turismoec.com">info@turismoec.com</a></p>
</section>


</body>
</html>