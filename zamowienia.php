<?
  include "config.inc";
  $_userid=$_REQUEST["userid"];

  // uzyskanie hasła użytkownika z ciasteczka (wysłanego z początku
  // strony main - jeśli oczywiście nastąpiło logowanie)
  $_u_pwd=$_COOKIE["user_p1"];
  $data_aktualna=date("Y-m-d");

  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  //pobierzmy sobie dane o użytkowniku
  $sql = "SELECT haslo from uzytkownicy where id=$_userid";
  $result = @mysql_query($sql,$db);
  $haslo  = @mysql_result($result, 0, "haslo");

  // a teraz hasło do porównania pochodzi z ciasteczka 
  // "$_u_pwd=$_COOKIE["user_p1"];" - na górze tej strony
  // (po logowaniu na main.php->userlogin.php)
  if (strcmp("$_u_pwd","$haslo") != 0)
  {
      header("Location: closewindow.php");
  }
  else
  {
    echo "<html><head>
      <title>$nazwa_sklepu - informacja o zamówieniu</title>
      <META http-equiv=Content-Type content=text/html; charset=iso-8859-2>
      <LINK href=$styl_main type=text/css rel=stylesheet></head>";
    echo "<body onLoad='opener.location.href=\"main.php\";'>";
  }

?>

<center>
<br>
<table class=newsbox width=400 border="0" cellspacing="0" cellpadding="2" align="center">
  <tr class=tabelka_zamowienia align="center"> 
    <td>Twoje zamówienia</td>
  </tr>
</table>

<?
  // wyłuskanie na podstawie userid odpowiedniego klientid
  $sql = "SELECT klientid from uzytkownicy where id=$_userid";
  $result = @mysql_query($sql,$db);
  // przekierowanie natychmiast w przypadku oszustwa...
  if (@mysql_num_rows($result) == 0)
  { 
    Header ("Location: main.php");
  }
  $klientid = @mysql_result($result, 0, "klientid");
  // pominięcie admina
  if ($klientid==1)
  {
    Header ("Location: main.php");
  }
  //Pokazanie zamówień z możliwością ich wyboru...
  $sql = "SELECT zamowienia.id, zamowienia.datazamowienia, zamowienia.opis, zamowienia.data_realizacji, zamowienia.stan, klienci.adres, klienci.nazwa from klienci, zamowienia where zamowienia.klienci_id=klienci.id and klienci_id=$klientid";
  $result = @mysql_query($sql,$db);

  // tabelka z zamówieniami

  echo "<table class=newsbox width=400 border=0 cellspacing=0 cellpadding=2 align=center>
        <TBODY>
	  <tr bgcolor=#f0f0f0>
	    <td width=255 >Zamówienie (data)</td>
	    <td width=30>Pokaż</td>
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
    echo "<td>Zamówienie z dnia: $datazamowienia</td>
          <td><a href=><img alt=\"Pokaż zamówienie\" src=\"images/arrowgreen.gif\" border=0></a></td> 
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
          <td width=400><b>UWAGA - Aby otworzyć to okno ponownie musisz się znów zalogować!</td>
        </tr>
      </tbody>
      </table>";
echo "</center></body><html>";

?>