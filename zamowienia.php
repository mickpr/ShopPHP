<?
  include "config.inc";
  $_userid=$_REQUEST["userid"];

  // uzyskanie has�a u�ytkownika z ciasteczka (wys�anego z pocz�tku
  // strony main - je�li oczywi�cie nast�pi�o logowanie)
  $_u_pwd=$_COOKIE["user_p1"];
  $data_aktualna=date("Y-m-d");

  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  //pobierzmy sobie dane o u�ytkowniku
  $sql = "SELECT haslo from uzytkownicy where id=$_userid";
  $result = @mysql_query($sql,$db);
  $haslo  = @mysql_result($result, 0, "haslo");

  // a teraz has�o do por�wnania pochodzi z ciasteczka 
  // "$_u_pwd=$_COOKIE["user_p1"];" - na g�rze tej strony
  // (po logowaniu na main.php->userlogin.php)
  if (strcmp("$_u_pwd","$haslo") != 0)
  {
      header("Location: closewindow.php");
  }
  else
  {
    echo "<html><head>
      <title>$nazwa_sklepu - informacja o zam�wieniu</title>
      <META http-equiv=Content-Type content=text/html; charset=iso-8859-2>
      <LINK href=$styl_main type=text/css rel=stylesheet></head>";
    echo "<body onLoad='opener.location.href=\"main.php\";'>";
  }

?>

<center>
<br>
<table class=newsbox width=400 border="0" cellspacing="0" cellpadding="2" align="center">
  <tr class=tabelka_zamowienia align="center"> 
    <td>Twoje zam�wienia</td>
  </tr>
</table>

<?
  // wy�uskanie na podstawie userid odpowiedniego klientid
  $sql = "SELECT klientid from uzytkownicy where id=$_userid";
  $result = @mysql_query($sql,$db);
  // przekierowanie natychmiast w przypadku oszustwa...
  if (@mysql_num_rows($result) == 0)
  { 
    Header ("Location: main.php");
  }
  $klientid = @mysql_result($result, 0, "klientid");
  // pomini�cie admina
  if ($klientid==1)
  {
    Header ("Location: main.php");
  }
  //Pokazanie zam�wie� z mo�liwo�ci� ich wyboru...
  $sql = "SELECT zamowienia.id, zamowienia.datazamowienia, zamowienia.opis, zamowienia.data_realizacji, zamowienia.stan, klienci.adres, klienci.nazwa from klienci, zamowienia where zamowienia.klienci_id=klienci.id and klienci_id=$klientid";
  $result = @mysql_query($sql,$db);

  // tabelka z zam�wieniami

  echo "<table class=newsbox width=400 border=0 cellspacing=0 cellpadding=2 align=center>
        <TBODY>
	  <tr bgcolor=#f0f0f0>
	    <td width=255 >Zam�wienie (data)</td>
	    <td width=30>Poka�</td>
	    <td colspan=2 width=*>Stan i data realizacji</td>
	  </tr>";

  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $datazamowienia = @mysql_result($result, $i, "datazamowienia");
    $data_realizacji = @mysql_result($result, $i, "data_realizacji");
    $stan = @mysql_result($result, $i, "stan");
    $opis = @mysql_result($result, $i, "opis");
    $adres = @mysql_result($result, $i, "adres");
    $nazwa = @mysql_result($result, $i, "nazwa");

    echo "<TR class=newsbox>";
    echo "<td>Zam�wienie z dnia: $datazamowienia</td>
          <td><a href=><img alt=\"Poka� zam�wienie\" src=\"images/arrowgreen.gif\" border=0></a></td> 
	  <td align=left height=24 valign=middle>";
          if ($stan==1)
          {
            echo "<img src=\"images/buzka.png\" border=0>";
          }
    echo "</td>
	  <td width=80>$data_realizacji</td>";
  }

echo "</tbody>
      </table>";
echo "<table class=newsbox width=400 border=0 cellspacing=0 cellpadding=2 align=center>
      <TBODY>
        <tr bgcolor=#f0f0f0>
          <td width=400><b>UWAGA - Aby otworzy� to okno ponownie musisz si� zn�w zalogowa�!</td>
        </tr>
      </tbody>
      </table>";
echo "</center></body><html>";

?>