<?php
$musicDirectory = 'musik/';
$musicFiles = array_diff(scandir($musicDirectory), array('..', '.')); // Exclure les dossiers parent et les fichiers cachés
$musicList = [];

foreach ($musicFiles as $file) {
  if (pathinfo($file, PATHINFO_EXTENSION) === 'mp3') {
    $musicList[] = $musicDirectory . $file;
  }
}

echo json_encode($musicList);
?>
