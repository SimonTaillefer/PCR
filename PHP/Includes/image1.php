<?php
// Création d'un image contenant le texte "Bienvenue sur le site PCR" dans un cadre bleu clair
header("Content-type: image/png");
$image = imagecreate(290,50);

$bleuclair = imagecolorallocate($image, 60, 170, 232);
$textcolor = imagecolorallocate($image, 255, 255, 255);

imagestring($image, 4, 35, 15, "Bienvenue sur le site de PCR", $textcolor);

imagepng($image);
?>