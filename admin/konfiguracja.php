<?
  include "../config.inc";
  include "naglowek.php";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
          <TR class=title>
            <TD>
              <A class=tytul href=\"konfiguracja.php\"><B>Konfiguracja sklepu</B></A> 
              </TD></TR></TBODY></TABLE>";

  echo "<TABLE class=txt width=\"100%\" align=center border=0>
        <TBODY>
          <TR>
            <TD class=txt vAlign=top>";
  
    //wyci±gniemy sobie dane o konfiguracji :-)
    $sql = "SELECT * from konfiguracja";
    $result = @mysql_query($sql,$db);
    for ($i = 0; $i < @mysql_num_rows($result); $i++)
    {
	$id = @mysql_result($result, $i, "id");
	$nazwa = @mysql_result($result, $i, "nazwa");
	$opis = @mysql_result($result, $i, "opis");
	$wartosc = @mysql_result($result, $i, "wartosc");
	echo $id . ": $nazwa " . $opis . " = " . $wartosc ."<br>";
    }

  echo "</TD></TR></TBODY></TABLE>";



  include "stopka.php";
?>
