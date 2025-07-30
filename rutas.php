<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rutas Turísticas</title>
  
  <?php include 'header.php'; ?>
 
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #f2eaea;
      color: #222;
    }

    header {
      background-color: #00796b;
      color: white;
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .nav {
      display: flex;
      gap: 15px;
      flex-wrap: wrap;
    }

    .nav a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      padding: 6px 10px;
      border-radius: 5px;
    }

    .nav a:hover,
    .nav a.active {
      background-color: #004d40;
    }

    main {
      max-width: 900px;
      margin: 30px auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h1 {
      text-align: center;
      color: #00796b;
    }

    .video-container {
      position: relative;
      padding-bottom: 56.25%; /* 16:9 ratio */
      height: 0;
      overflow: hidden;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.3);
    }

    .video-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
    }

    @media (max-width: 600px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }

      .nav {
        flex-direction: column;
        gap: 8px;
      }

      main {
        margin: 20px 10px;
      }
    }
  </style>
</head>
<body>

<main>
  <h1>Rutas destacadas en Ecuador</h1>
  <div class="video-container">
    <iframe src="https://www.youtube.com/embed/RDbe-4Z5bvQ" 
            title="Rutas Turísticas en Ecuador"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen></iframe>
  </div>
</main>

</body>
</html>
