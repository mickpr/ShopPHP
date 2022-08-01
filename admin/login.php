<?
 require("config.inc.php");
 import_request_variables("GPC","");
 if ($login==$poprawny_login && $haslo==$poprawne_haslo)
 {
  setcookie("haslo",$haslo);
  setcookie("login",$login);
  Header("Location: admin.php");
 } else
 {
  include("naglowek.php");
  echo "<table width=100%><tbody><tr><td align=center bgColor=#004f84>";
  echo "<BR><BR><CENTER><FONT color=white face=arial size=+2><B>B³êdy login i/lub has³o</B> !</FONT><BR><BR><BR>\n";
  echo "<A style=\"COLOR: white; FONT-FAMILY: Arial; FONT-SIZE=14px; FONT-WEIGHT: BOLD\" color=white href='index.php'>Powrót do strony logowania</A></CENTER><br><BR></td></tr></tbody></table>";

  include("stopka.php");
 }

?>
