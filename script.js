// #########################################################
// ##               JAVASCRIPT - EnzMusik                 ##
// ##    This script handle the audio of the website      ##
// ##                                                     ##
// ##    Made with love by EnzoBeth (@iamenzobeth)        ##
// #########################################################



var audioElement = document.querySelector('audio');
var currentSongIndex = 0;
var playlist = [];
var filteredPlaylist = [];

// Fonction pour mettre à jour le titre de la chanson et l'image de l'album
function updateSongInfo() {
  var songTitle = document.getElementById('songTitle');
  var albumArt = document.getElementById('albumArt');

  songTitle.textContent = getFileName(playlist[currentSongIndex]);
  albumArt.src = getAlbumArtPath(playlist[currentSongIndex]);

  // Mettre à jour les informations du media session
  updateMediaSession(songTitle.textContent, albumArt.src);
}

// Fonction pour démarrer la lecture
function play() {
  audioElement.play();
}

// Fonction pour mettre en pause la lecture
function pause() {
  audioElement.pause();
}

// Fonction pour obtenir le nom de fichier à partir d'une URL
function getFileName(url) {
  var startIndex = url.lastIndexOf('/') + 1;
  var endIndex = url.lastIndexOf('.');
  return url.substring(startIndex, endIndex);
}

// Fonction pour obtenir le chemin d'accès de l'image de l'album
function getAlbumArtPath(file) {
  var fileName = getFileName(file);
  var albumArtPath = 'musik/art/' + fileName + '.jpg';
  var genericAlbumArtPath = 'musik/art/generic.jpg';

  // Vérifier si l'album art spécifique existe
  var http = new XMLHttpRequest();
  http.open('HEAD', albumArtPath, false);
  http.send();

  // Si l'album art spécifique existe, retourner le chemin d'accès spécifique
  if (http.status !== 404) {
    return albumArtPath;
  }

  // Sinon, retourner le chemin d'accès de l'album art générique
  return genericAlbumArtPath;
}

// Exécute la requête AJAX pour récupérer la liste des musiques
function fetchMusicList() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_music_list.php', true);
  xhr.onload = function() {
    if (xhr.status === 200) {
      var response = JSON.parse(xhr.responseText);
      if (response && response.length > 0) {
        playlist = response;
        filteredPlaylist = playlist;
        createMusicList();

        // Écouter l'événement de chargement des métadonnées de l'audioElement
        audioElement.addEventListener('loadedmetadata', function() {
          // Obtenez le titre et l'album art de la chanson en cours de lecture
          var title = getFileName(playlist[currentSongIndex]);
          var albumArt = getAlbumArtPath(playlist[currentSongIndex]);

          // Mettre à jour les métadonnées du media session avec les informations de la chanson
          updateMediaSession(title, albumArt);
        });
      }
    }
  };
  xhr.send();
}

// Crée la liste des musiques dans l'interface
function createMusicList() {
  var musicList = document.getElementById('musicList');
  musicList.innerHTML = '';

  filteredPlaylist.forEach(function(file) {
    var musicItem = document.createElement('div');
    musicItem.classList.add('music-item');

    var albumArt = document.createElement('img');
    albumArt.src = getAlbumArtPath(file);
    albumArt.alt = getFileName(file);
    albumArt.classList.add('album-art');
    musicItem.appendChild(albumArt);

    var title = document.createElement('p');
    title.textContent = getFileName(file);
    musicItem.appendChild(title);

    musicItem.addEventListener('click', function() {
      currentSongIndex = filteredPlaylist.indexOf(file);
      audioElement.src = file;
      audioElement.play(); // Démarrer la lecture de la musique
      updateSongInfo();
      updateButtons();
    });

    musicList.appendChild(musicItem);
  });

  updateButtons(); // Mettre à jour l'état des boutons Suivant et Précédent
}

// Fonction pour lire la chanson suivante
function playNextSong() {
  currentSongIndex++;
  if (currentSongIndex >= filteredPlaylist.length) {
    currentSongIndex = 0; // Revenir à la première chanson
  }
  audioElement.src = filteredPlaylist[currentSongIndex];
  audioElement.play();
  updateSongInfo();
  updateButtons();
}

// Fonction pour lire la chanson précédente
function playPreviousSong() {
  currentSongIndex--;
  if (currentSongIndex < 0) {
    currentSongIndex = filteredPlaylist.length - 1; // Revenir à la dernière chanson
  }
  audioElement.src = filteredPlaylist[currentSongIndex];
  audioElement.play();
  updateSongInfo();
  updateButtons();
}

// Événement "ended" : déclenché lorsque la musique en cours se termine
audioElement.addEventListener('ended', function() {
  playNextSong();
});

// Fonction pour mettre à jour l'état des boutons Suivant et Précédent
function updateButtons() {
  var nextButton = document.getElementById('nextBtn');
  var prevButton = document.getElementById('prevBtn');
  nextButton.disabled = currentSongIndex === filteredPlaylist.length - 1;
  prevButton.disabled = currentSongIndex === 0;
}

// Fonction pour mettre à jour les informations du media session
function updateMediaSession(title, albumArt) {
  if ('mediaSession' in navigator) {
    navigator.mediaSession.metadata = new MediaMetadata({
      title: title,
      album: 'EnzMusic', // Remplacez cela par le nom de l'album si vous avez l'information
      artwork: [
        { src: albumArt, sizes: '512x512', type: 'image/png' },
      ],
    });

    // Gérer les événements de contrôle du média
    navigator.mediaSession.setActionHandler('play', function() {
      play();
    });

    navigator.mediaSession.setActionHandler('pause', function() {
      pause();
    });

    navigator.mediaSession.setActionHandler('previoustrack', function() {
      playPreviousSong();
    });

    navigator.mediaSession.setActionHandler('nexttrack', function() {
      playNextSong();
    });
  }
}

// Fonction pour filtrer la liste des musiques en fonction de la recherche
function filterMusicList(searchTerm) {
  filteredPlaylist = playlist.filter(function (file) {
    const fileName = getFileName(file).toLowerCase();
    return fileName.includes(searchTerm.toLowerCase());
  });
}

// Fonction pour mettre à jour la liste des musiques affichées en fonction de la recherche
function updateMusicList() {
  const searchTerm = document.getElementById('searchInput').value;
  filterMusicList(searchTerm);
  createMusicList();
}

// Mettre à jour la liste des musiques lors du chargement de la page
fetchMusicList();

// Appeler la fonction updateSongInfo() pour afficher les informations de la première chanson lors du chargement de la page
updateSongInfo();

// Mettre à jour la liste des musiques lorsqu'un terme de recherche est saisi
document.getElementById('searchInput').addEventListener('input', function () {
  updateMusicList();
});

// Mettre à jour la liste des musiques lorsqu'on clique sur le bouton de recherche
document.getElementById('searchBtn').addEventListener('click', function () {
  updateMusicList();
});