<?
//----------------------------------------------------
//  Tworzenie miniaturki zachowuj¥cej skal© oryginaˆu
//----------------------------------------------------

//  $file="212444.gif";
//  $file="Explorer.png";
//  $dest_width=200;
//  $dest_height=300;

// wywoˆanie:
//    out_thumb("212444.gif",300,400);

$f=$_GET["file"];
$w=$_GET["w"];
$h=$_GET["h"];


out_thumb($f,$w,$h);

function out_thumb($file,$dest_width,$dest_height)
{
  // pobranie informacji o obrazku
  $a=getimagesize($file);
if ($a[2]==1)
  {
    $image=imagecreatefromgif($file);
  }
  elseif ($a[2]==2)
  {
    $image=imagecreatefromjpeg($file);
  }
  elseif ($a[2]==3)
  {
    $image=imagecreatefrompng($file);
  }

//1 IMAGETYPE_GIF 
//2 IMAGETYPE_JPEG 
//3 IMAGETYPE_PNG 

// skalowanie - przeliczanie rozmiaru aby zachowa† proporcje obrazu
if (ImageSX($image)>ImageSY($image))
  {
    $width=$dest_width;
    $height=(ImageSY($image)/ImageSX($image))*$dest_width;
  }
  else
  {
    $height=$dest_height;
    $width=(ImageSX($image)/ImageSY($image))*$dest_height;
  } 

// tworzenie obrazka
if (function_exists("ImageCreateTrueColor")) 
  {
    $thumb = ImageCreateTrueColor($width, $height);
  }
  else 
  {
    $thumb = ImageCreate($width, $height);
  }

// kopiowanie ze skalowaniem
if (function_exists("ImageCopyResampled")) 
  {
    ImageCopyResampled($thumb, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
  }
  else 
  {
    ImageCopyResized($thumb, $image, 0, 0, 0, 0, $width, $height, ImageSX($image), ImageSY($image));
  }

// wyplucie na ekran w jakim˜ formacie (najlepiej png :-))
  if (function_exists("imagepng")) 
  {
    header("Content-type: image/png");
    imagepng($thumb);
  } 
  elseif (function_exists("imagegif")) 
  {
    header("Content-type: image/gif");
    imagegif($thumb);
  } 
  elseif (function_exists("imagejpeg")) 
  {
    header("Content-type: image/jpeg");
    imagejpeg($thumb, "", 0.5);
  } 
}
// end of function : out_thumbnail
imagedestroy($thumb);
imagedestroy($image);
?>
