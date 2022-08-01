<?
  include "config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  $_userid=$_REQUEST["userid"];

  // uzyskanie has³a u¿ytkownika z ciasteczka (wys³anego z pocz±tku
  // strony main - je¶li oczywi¶cie nast±pi³o logowanie)
  $_u_pwd=$_COOKIE["user_p1"];

  // przy drugim wywo³aniu (po wci¶nieciu OK)... wykonywane jest to
  $_zmien=$_REQUEST["zmien"];
  if ($_zmien==1)
  {
    $_user_pp1=$_REQUEST["user_pp1"];
    $_user_pp2=$_REQUEST["user_pp2"];
    // has³o niepuste ale zgodne... :-)
    if (($_user_pp1 == $_user_pp2 ) && ($_user_pp1!=""))
    {
      $sql2 = "UPDATE uzytkownicy SET haslo='$_user_pp2' WHERE id=$_userid";
      $result = @mysql_query($sql2,$db);
      setcookie("user_p1","$_user_pp1");
      header("Location: closewindow.php");
    }
  }


  //pobierzmy sobie dane o u¿ytkowniku
  $sql = "SELECT * from uzytkownicy where id=$_userid";
  $result = @mysql_query($sql,$db);
  $haslo = @mysql_result($result, 0, "haslo");
  $nazwa = @mysql_result($result, 0, "nazwa");

  // a teraz has³o do porównania pochodzi z ciasteczka 
  // "$_u_pwd=$_COOKIE["user_p1"];" - na górze tej strony
  // (po logowaniu na main.php->userlogin.php)
  if (strcmp("$_u_pwd","$haslo") != 0)
  {
      header("Location: closewindow.php");
  }
  else
  {
    echo "<html><head>
      <title>$nazwa_sklepu - zmiana has³a</title>
      <META http-equiv=Content-Type content=text/html; charset=iso-8859-2>
      <LINK href=$styl_main type=text/css rel=stylesheet>";
    echo "<SCRIPT language=JavaScript type=text/JavaScript>
    function ustaw() 
    {
      x1=screen.availWidth/2;
      y1=screen.availHeight/2;
      window.moveTo(x1-250,y1-100);
      window.resizeTo(500,200);
    }";
    echo "</SCRIPT>";
    echo "</head>";
  }

echo "<body onLoad='ustaw();'><form action=\"zmienhaslo.php\" method=\"GET\">";
//echo "$_userid,$_zmien,$_user_pp1,$_user_pp2,$sql2";
?>


<center>
<br>
<table class=newsbox width=400 border="0" cellspacing="0" cellpadding="2" align="center">
  <tr align="center"> 
    <td class=login_header><span class=tabelka_font>Podaj nowe has³o (2 razy to samo)</span></td>
  </tr>
</table>

<?
  echo "<table class=newsbox width=400 border=0 cellspacing=0 cellpadding=2 align=center>
        <TBODY>
	  <tr class=login_tlo>
	    <td width=210>Nowe has³o</td>
	    <td width=80><INPUT type=password class=form name=\"user_pp1\" width=4></td>
	    <td width=210>Jeszcze raz</td>
	    <td width=80><INPUT type=password class=form name=\"user_pp2\" width=4></td>
	  </tr>";
echo "<tr><td class=login_tlo align=right colspan=4><input type=button class=form value=\"Anuluj\" onClick='window.close();'>&nbsp;&nbsp;<input type=submit class=form value=\"   Ok   \"></td></tr>";
echo "</tbody>
      </table><input type=hidden name=\"zmien\" value=1>
	      <input type=hidden name=\"userid\" value=$_userid>";
echo "<table class=newsbox width=400 border=0 cellspacing=0 cellpadding=2 align=center>
      <TBODY>
        <tr bgcolor=#f0f0f0>
          <td width=400><b>Po zmianie has³a nie musisz siê ponownie logowywaæ!</td>
        </tr>
      </tbody>
      </table>";
echo "</center></form></body><html>";

?>