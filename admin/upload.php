<?php

  $uploaddir = '../img/';
  $uploadfile = $uploaddir . $_FILES['avatar']['name'];
  $file = $_FILES['avatar']['name'];

  @ $avatar_size = $_POST['avatar']['size'];
  @ $avatar_error = $_POST['avatar']['error'];

  if($avatar_error > 0)
  {
  echo 'Problem: ';
  switch ($avatar_error)
  {
  case 1: echo 'Rozmiar pliku przekroczył wartosc upload_max_filesize';
  break;
  
  case 2: echo 'Rozmiar pliku przekroczył wartosc upload_max_file';
  break;
  
  case 3: echo 'Plik wysłany tylko częściowo';
  break;
  
  case 4: 'Nie wysłano żadnego pliku';
  break;
  }
}

/////////////////////////////////
//  SPRAWDZENIE PLIKU  //
////////////////////////////////

$result_array = explode('.', $file);

if ($result_array != false) 
{
   $mime_type = $result_array[1];
}
else 
{
   echo 'Plik nie jest zdjęciem.';
   exit;
}
   

if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadfile)) 
{
    echo "<html><head><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-2\">
          <link href=\"style.css\" type=\"text/css\" rel=\"STYLESHEET\" />
          </head><body bgcolor=#80ff80>
	<center><br>
	<table width=100% height=120 cellpadding=\"0\" cellspacing=\"0\" border=\"0\">
	<tbody><tr>
	<td valign=middle align=center><font size=3 face=Verdana><b>Plik przesłany poprawnie.</b></font></td></tr>
	</tbody></table>
	</center>
	</form>
	</html>";

    //rename("upload/avatar/".$_FILES['avatar']['name'], "upload/avatar/1.jpg");
    chmod("upload/avatar/".$_FILES['avatar']['name'], 0777);
}
else 
    echo "<html><head><META http-equiv=Content-Type content=\"text/html; charset=iso-8859-2\">
          <link href=\"index.css\" type=\"text/css\" rel=\"STYLESHEET\" />
          </head><body bgcolor=#ff4040>
	<center><br>
	<table width=100% height=120 cellpadding=0 cellspacing=0 border=0><tbody> 
	<td><center><font face=Verdana size=3><b>Plik nie został przesłany.</b></font><br></center></td></tr>
	</tbody></table>
	</center>
	</form>
	</html>";
?> 
