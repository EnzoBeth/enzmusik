<!--
#########################################################
##               HTML - EnzMusik                       ##
##    This is the main page of the website             ##
##                                                     ##
##    Made with love by EnzoBeth (@iamenzobeth)        ##
#########################################################
-->

<!DOCTYPE html>
<html>
<head>
  <title>EnzMusic</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#9F7AEA">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="white">
  <style>
    /* Style CSS pour l'interface */
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      background-color: #121212;
      color: #fff;
      margin: 0;
      padding: 0;
      accent-color: #9F7AEA;
      padding-bottom: env(safe-area-inset-bottom); /* Ajouter un espace pour éviter que la homebar ne recouvre le player sur iPhone en mode webapp */
    }

    h1 {
      color: #9F7AEA;
      margin-top: 30px;
    }

    .menu-bar {
      background-color: #191414;
      padding: 10px;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 9999;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    .site-title {
      font-size: 24px;
      font-weight: bold;
      color: #fff;
      text-align: center;
      padding: 0 10px;
    }

    .site-title span {
      color: #B785F7;
    }

    .player-container {
      display: flex;
      align-items: center;
      max-width: 400px;
      background-color: #282828;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      padding: 10px;
      margin: 0 auto; /* Centrer le player horizontalement */
      position: fixed;
      bottom: 20px;
      left: 50%;
      transform: translateX(-50%);
    }

    #songTitle {
      color: #fff;
      font-size: 16px;
      margin: 0;
      text-align: center;
      max-width: 150px;
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
    }

    #albumArt {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      margin-right: 10px;
    }

    audio {
      width: 100%;
      margin-top: 20px;
    }

    .music-item {
      display: inline-block;
      width: 200px;
      height: 250px;
      margin: 10px;
      padding: 10px;
      border-radius: 10px;
      background-color: #282828;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .music-item:hover {
      background-color: #383838;
    }

    .music-item img {
      width: 100%;
      height: 120px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 10px;
    }

    .music-item p {
      margin: 0;
      font-size: 14px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    button {
      padding: 10px;
      background-color: #9F7AEA;
      color: #fff;
      border: none;
      border-radius: 50%;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #B785F7;
    }

    .player-buttons {
      display: flex;
      gap: 10px;
    }

    /* Media queries pour ajuster le design en fonction de la taille de l'écran */

    @media screen and (max-width: 768px) {
      .menu-bar {
        flex-direction: column;
      }

      .player-container {
        max-width: calc(100% - 40px); /* Prendre toute la largeur moins les marges */
        margin: 0 20px; /* Ajouter de l'espacement entre le player et les bords */
        left: 0;
        right: 0;
        transform: none;
        bottom: 5px;
        background-color: #191414;
        display: flex;
        justify-content: space-between; /* Centrer les boutons horizontalement à droite */
        gap: 20px; /* Ajouter de l'espacement entre l'album art, le titre et les boutons */
        position: sticky; /* Faire en sorte que le player reste fixe en bas de l'écran */
      }

      .site-title {
        font-size: 20px;
        padding: 10px 0;
      }

      #songTitle {
        font-size: 14px;
        max-width: 200px;
      }

      /* Afficher les musiques en 2 colonnes */
      #musicList {
        display: grid;
        grid-template-columns: repeat(2, 1fr); /* Deux colonnes */
        gap: 10px;
        justify-content: center;
        max-width: calc(100% - 20px); /* Prendre toute la largeur moins les marges */
        margin: 50px auto; /* Centrer la liste horizontalement */
        padding: 10px;
      }

      .music-item {
        width: 140px; /* Réduire la largeur des musiques */
        height: 250px; /* Ajuster la hauteur des musiques */
        margin: 5px;
        padding: 10px;
      }

      .music-item img {
        height: 100px; /* Ajuster la hauteur de l'image */
      }

      .music-item p {
        font-size: 12px; /* Ajuster la taille du texte */
      }

      /* Centrer les boutons horizontalement à droite */
      .player-buttons {
        justify-content: flex-end;
      }
      .search-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 20px;
    }

    #searchInput {
      padding: 10px;
      border: 2px solid #9F7AEA;
      border-radius: 5px 0 0 5px;
      width: 300px;
      font-size: 16px;
      color: #121212;
      outline: none;
    }

    #searchBtn {
      padding: 10px 20px;
      background-color: #9F7AEA;
      color: #fff;
      border: none;
      border-radius: 0 5px 5px 0;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    #searchBtn:hover {
      background-color: #B785F7;
    }
    .music-artist {
  color: #B785F7;
  font-size: 14px;
  margin: 5px 0;
}
    }

    
    </style>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <div class="menu-bar">
    <div class="site-title">Enz<span>Musik</span></div>
  </div>

    
  <h2>Liste des musiques</h2>
  <!-- Ajouter un champ de recherche -->
  <div class="search-container">
    <input type="text" id="searchInput" placeholder="Rechercher une musique...">
    <button id="searchBtn">Rechercher</button>
  </div>
  

  <div id="musicList">
    <!-- Exemple de musique -->
    <div class="music-item">
      <img src="lien_de_l_image" alt="Nom de la musique">
      <p>Nom de la musique qui est un peu long</p>
    </div>
    <!-- Ajouter les autres musiques ici -->
  </div>

  <!-- Élément audio avec l'attribut controls pour afficher la barre de durée et de contrôle -->
  <audio id="audioPlayer" controls style="display: none;"></audio>

  <div class="player-container">
    <img id="albumArt" src="" alt="Album Art">
    <h2 id="songTitle">Titre de la chanson</h2>
    <div class="player-buttons">
      <button id="prevBtn" onclick="playPreviousSong()"><i class="fas fa-backward"></i></button>
      <button id="playBtn" onclick="togglePlayPause()"><i class="fas fa-play"></i></button>
      <button id="nextBtn" onclick="playNextSong()"><i class="fas fa-forward"></i></button>
    </div>
  </div>


  <!-- Votre code JavaScript ici -->
  <script src="script.js"></script>
</body>
</html>