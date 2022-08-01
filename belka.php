<?php

$skala=$_GET["s"];
$wartosc=$_GET["w"];
//  $skala = 75;
//  $wartosc=25;


$mnoznik=18/$skala;
// create a blank image
$image = imagecreate(25, 10);

// fill the background color
$bg = imagecolorallocate($image, 255, 255,255);

// choose a color for the polygon
$col_poly = imagecolorallocate($image, 220,220,220);

// pusta belka
imagefilledpolygon($image,array (3,0,23, 0,20,3,0,3),4,$col_poly);
imagefilledpolygon($image,array (0,3,0,8,20,8,20,3),4,$col_poly);
$col_poly = imagecolorallocate($image, 170,170,170);
imagefilledpolygon($image,array (23,0,23,5,20,8,20,3),4,$col_poly);
$col_line = imagecolorallocate($image, 250,250,250);
imageline ( $image, 0, 3,18,3,$col_line);
$col_line = imagecolorallocate($image, 150,150,150);
// obramówka
imagepolygon($image,array (0,8,20,8,23,5,23,0,3,0,0,3,0,8),7,$col_line);

// teraz obliczamy warto¶æ - do narysowania - ile pikseli
$wartosc2=round($wartosc*$mnoznik,0);

// kolor wype³nienia
if ($wartosc>0)
{
  $col_poly = imagecolorallocate($image, 255,150,150);

  if ($wartosc2<3)
    {
      $col_poly = imagecolorallocate($image, 250,0,0);
    }
    elseif ($wartosc2>=3 && $wartosc2<6)
    {
      $col_poly = imagecolorallocate($image, 250,120,120);
    }
    elseif ($wartosc2>=6 && $wartosc2<9)
    {
      $col_poly = imagecolorallocate($image, 250,120,120);
    }
    elseif ($wartosc2>=9 && $wartosc2<12)
    {
      $col_poly = imagecolorallocate($image, 160,160,250);
    }
    elseif ($wartosc2>=12)
    {
      $col_poly = imagecolorallocate($image, 40,220,40);
    }

    // góra, dó³, prawy bok (je¶li 100%)
    imagefilledpolygon($image,array (3,0,$wartosc2+4, 0,$wartosc2+1,3,0,3),4,$col_poly);
    imagefilledpolygon($image,array (0,3,0,8,$wartosc2+1,8,$wartosc2+1,3),4,$col_poly);

    if ($wartosc>=$skala)
    {
      imagefilledpolygon($image,array (23,0,23,5,20,8,20,3),4,$col_poly);
    }
} // koniec je¶li wartosc>0

// output the picture
header("Content-type: image/png");
imagepng($image);
//echo $wartosc;
imagedestroy($image);
?>
