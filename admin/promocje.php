<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);
  $zmieniacz=0;

  $_delid=$_GET["delid"];
  $_editid=$_GET["editid"];
  $_p_nazwa=$_REQUEST["p_nazwa"];
  $_p_opis=$_REQUEST["p_opis"];

  $_p_data_waznosci=$_REQUEST["p_data_waznosci"];
  $_acceptid=$_REQUEST["acceptid"];
  $_addpromocje=$_REQUEST["addpromocje"];
  $_addpromocje_acceptid=$_REQUEST["addpromocje_acceptid"];
  // kasowanie - je¶li delid! - potem normalne wy¶wietlanie
  if ($_delid) 
  {
    $sql="Delete From promocje where id=$_delid";
    $result = @mysql_query($sql,$db);
  }

  if ($_editid)
  {
    // ------------------------------
    //       EDYCJA - formularz
    // ------------------------------

    // edycja - je¶li editid

    include("naglowek.php");

    //wyci±gniemy sobie conieco o edytowanej promocji :-)
    $sql = "SELECT * from promocje where id=$_editid";
    $result = @mysql_query($sql,$db);
    $promocje_id = @mysql_result($result, 0, "id");
    $promocje_nazwa = @mysql_result($result, 0, "nazwa");
    $promocje_opis=@mysql_result($result, 0, "opis");
    $promocje_data_waznosci=@mysql_result($result, 0, "data_waznosci");
    $promocje_wyswietlac=@mysql_result($result, 0, "wyswietlac");


    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"promocje.php\"><B>Promocje i news'y - edycja</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=promocje.php method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$promocje_nazwa\"></td>
                    </tr>   
		  <tr><td align=left width=50px>Opis:</td>
                    <td align=left width=200px><textarea class=szukaj style=\"WIDTH: 400px; HEIGHT:120px\" wrap=yes name=p_opis>$promocje_opis</textarea></td>
                    </tr>   
		  <tr><td align=left width=200px>Data wa¿no¶ci (rrrr-mm-dd):</td>
                    <td align=left width=100px><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_data_waznosci value=\"$promocje_data_waznosci\"></td>
                    </tr>   
                   <tr><td align=left width=200px></td>     
		    <td align=left width=150px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
 	              <td align=left width=200px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usuñ&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='promocje.php?delid=$promocje_id'\">
                        <input type=hidden name=acceptid value=\"$promocje_id\">
                        </td>
                  </tr>
		</TBODY></table>
                </form>   </td></tr>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_acceptid) 
  {
    $sql = "UPDATE promocje set nazwa='$_p_nazwa', opis='$_p_opis', data_waznosci='$_p_data_waznosci', wyswietlac=1 where id=$_acceptid";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // uaktualnienie siê nie uda³o...
      include("naglowek.php");
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa³e¶ niepoprawne dane. <br>Popraw dane i spróbuj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powrót</a></span></td></tr></table></center>";
      include("stopka.php");
    }
    else 
    {
      echo "<html><head></head><body onload='document.location.href=\"promocje.php\"'></body></html>";
    }
    // koniec uaktualniania po edycji...
  }
  else 
  if ($_addpromocje)
  {
    // ------------------------------
    //     DODAWANIE - formularz
    // ------------------------------
    include("naglowek.php");

    //ustalmy conieco...
    $promocje_nazwa = "";
    $promocje_opis = "";
    $promocje_data_waznosci = "2005-01-01";

    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"promocje.php\"><B>Promocje i news'y - dodawanie nowej promocji/news'a</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=promocje.php method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$promocje_nazwa\"></td>
                    </tr>   
		  <tr><td align=left width=50px>Opis:</td>
                    <td align=left width=200px><textarea class=szukaj style=\"WIDTH: 400px; HEIGHT:120px\" wrap=yes name=p_opis>$promocje_opis</textarea></td>
                    </tr>   
		  <tr><td align=left width=200px>Data wa¿no¶ci (rrrr-mm-dd):</td>
                    <td align=left width=100px><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_data_waznosci value=\"$promocje_data_waznosci\"></td>
                    </tr>   
                   <tr><td align=left width=200px></td>     
		    <td align=left width=150px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
 	              <td align=left width=200px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usuñ&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='promocje.php?delid=$promocje_id'\">
                        <input type=hidden name=addpromocje_acceptid value=\"1\">
                        </td>
                  </tr>
		</TBODY></table>
                </form>   </td></tr>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_addpromocje_acceptid) 
  {
    // -----------------------------
    //   DODAWANIE - wykonanie sql
    // -----------------------------
  
    $sql = "INSERT INTO promocje(nazwa, opis, data_waznosci, wyswietlac)
	    values ('$_p_nazwa','$_p_opis', '$_p_data_waznosci', 1)";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // dodanie nie uda³o...
      include("naglowek.php");
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa³e¶ niepoprawne dane. <br>Popraw dane i spróbuj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powrót</a></span></td></tr></table></center>";
      //echo "\n$sql";
      include("stopka.php");
    }
    else 
    {
      //include("naglowek.php");
      //echo $p_promocje_id;
      //include("stopka.php");
      echo "<html><head></head><body onload='document.location.href=\"promocje.php\"'></body></html>";
    }
    // koniec dodawania
  }
  else
  {
    // -----------------------------
    //   WY¦WIETLANIE LISTY TYPÓW 
    // -----------------------------
   
    // najpierw nag³ówek.......
    include("naglowek.php");
 
    echo "<TABLE class=txt cellSpacing=2 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"promocje.php\"><B>Promocje i news-y</B></A>
            </TD></TR></TBODY></TABLE>";
  // ---------------------- CONTENT ---------------------- 
  // nag³ówek tabeli typów...
  echo "<TABLE width=\"800\">
        <TBODY>
        <TR>
          <TD class=txt>
            <TABLE class=border cellSpacing=0 cellPadding=0 width=\"100%\" border=0>
              <TBODY>
              <TR>
                <TD>
                  <TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\" border=0>
                    <TBODY>
                    <TR class=head_list>
                      <TD>Nazwa</TD>
                      <TD>Opis</TD>
                      <TD>Data wa¿no¶ci</TD>
                      <TD align=center colSpan=4>
			 <A class=edytuj href=\"promocje.php?addpromocje=1\">Dodaj nowy</A></TD></TR>";
  
  // promocje........ SQL............
  //
  $sql = "SELECT * from promocje where id>1 order by data_waznosci desc";
  $result = @mysql_query($sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $promocje_id = @mysql_result($result, $i, "id");
    $promocje_nazwa = @mysql_result($result, $i, "nazwa");
    $promocje_opis = @mysql_result($result, $i, "opis");
    $promocje_data_waznosci = @mysql_result($result, $i, "data_waznosci");
    // fajne kolorki .... na jêzorki;-) ... w tabelce
    if ($zmieniacz==0)
    {
      $zmieniacz=1;
      echo "<TR class=lista 
                onmouseover=\"this.style.backgroundColor='#FFFFFF'\" 
                onmouseout=\"this.style.backgroundColor='#EEEEEE'\" 
                bgColor=#eeeeee>";
    }
    else
    {
      $zmieniacz=0;
      echo "<TR class=lista 
                onmouseover=\"this.style.backgroundColor='#FFFFFF'\" 
                onmouseout=\"this.style.backgroundColor='#F2F7F7'\" 
                bgColor=#f2f7f7>";
    }  
  
    // wiersz zawieraj±cy 1 typ...
    echo "<TD><SPAN 
            style=\"COLOR: blue\"><B>$promocje_nazwa</b></SPAN></TD>
	  <TD width=440>$promocje_opis</TD>
	  <TD width=100>$promocje_data_waznosci</TD>

  	<TD width=50 align=middle>";
	if ($promocje_id<>1)
          {
            echo "<A class=edytuj 
              href=\"promocje.php?editid=$promocje_id\">Edytuj</A> 
              ";
          }
        echo "</TD><TD width=50 align=middle>";  
	if ($promocje_id<>1)
          {
           echo "<A class=usun 
              onclick=\"return confirm('Czy na pewno chcesz usun±æ?')\" 
              href=\"promocje.php?delid=$promocje_id\">Usuñ</A>";
          }  
          echo "</TD></TR>";
    } // koniec pêtli for  (w³a¶ciwej listy typów)...

    echo "</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
      <TR>
      <TD class=txt>
      </TD></TR></TBODY></TABLE>
      </TD></TR></TBODY>
      </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");

  } // koniec.... pustego wywo³ania - listy produktów...


?>
