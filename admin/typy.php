<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);
  $zmieniacz=0;

  $_delid=$_GET["delid"];
  $_upid=$_GET["upid"];
  $_downid=$_GET["downid"];
  $_editid=$_GET["editid"];
  $_acceptid=$_REQUEST["acceptid"];
  $_addtyp=$_GET["addtyp"];
  $_addtyp_acceptid=$_REQUEST["addtyp_acceptid"];
  $_p_nazwa=$_REQUEST["p_nazwa"];
  $_p_kolejnosc=$_REQUEST["p_kolejnosc"];
  // kasowanie - je¶li delid! - potem normalne wy¶wietlanie
  if ($_delid) 
  {
    $sql="Delete From typy where id=$_delid";
    $result = @mysql_query($sql,$db);
  }


  // przestawienie pozycji w górê listy (warto¶æ leci w dó³) ..
  if ($_upid) 
  {
    // aktualna pozycja
    $sql="select * from typy where id=$_upid";
    $result = @mysql_query($sql,$db);
    $pozycja= @mysql_result($result, 0, "kolejnosc");
    
    // znajd¿ najwy¿szy w kolejno¶ci typ nie wy¿szy ni¿ bie¿±cy...
    $sql="select kolejnosc, id from typy where kolejnosc<$pozycja order by kolejnosc desc";
    $result = @mysql_query($sql,$db);
    $typek2_id= @mysql_result($result, 0, "id");
    $typek2_pozycja= @mysql_result($result, 0, "kolejnosc");

    // .... i zamieñ z aktualn± pozycj± miejscami
    $sql="update typy set kolejnosc=$pozycja where id=$typek2_id";
    $result = @mysql_query($sql,$db);
    $sql="update typy set kolejnosc=$typek2_pozycja where id=$_upid";
    $result = @mysql_query($sql,$db);
  }

  // przestawienie pozycji w dó³...
  if ($_downid) 
  {
    // aktualna pozycja
    $sql="select * from typy where id=$_downid";
    $result = @mysql_query($sql,$db);
    $pozycja= @mysql_result($result, 0, "kolejnosc");

    // znajd¿ najni¿sze w kolejno¶ci typ z wy¿szych ni¿ bie¿±cy...
    $sql="select kolejnosc, id from typy where kolejnosc>$pozycja order by kolejnosc";
    $result = @mysql_query($sql,$db);
    $typek2_id= @mysql_result($result, 0, "id");
    $typek2_pozycja= @mysql_result($result, 0, "kolejnosc");

    // .... i zamieñ z aktualn± pozycj± miejscami
    $sql="update typy set kolejnosc=$pozycja where id=$typek2_id";
    $result = @mysql_query($sql,$db);
    $sql="update typy set kolejnosc=$typek2_pozycja where id=$_downid";
    $result = @mysql_query($sql,$db);
  }

  if ($_editid)
  {
    // ------------------------------
    //       EDYCJA - formularz
    // ------------------------------

    // edycja - je¶li editid

    include("naglowek.php");

    //wyci±gniemy sobie conieco o edytowanym typie :-)
    $sql = "SELECT * from typy where id=$_editid";
    $result = @mysql_query($sql,$db);
    $typy_id = @mysql_result($result, 0, "id");
    $typy_nazwa = @mysql_result($result, 0, "nazwa");
    $typy_kolejnosc=@mysql_result($result, 0, "kolejnosc");
    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"typy.php\"><B>Typy - edycja</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=typy.php method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$typy_nazwa\"></td>
		    <td align=left width=190px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
	            <td align=left width=190px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usuñ typ&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='typy.php?delid=$typy_id'\"></td>
	            <td align=right width=*><input type=hidden name=acceptid value=\"$_editid\">
		    <input type=hidden name=p_kolejnosc value=\"$typy_kolejnosc\"></td>
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
    $sql = "UPDATE typy set nazwa='$_p_nazwa', kolejnosc=$_p_kolejnosc where id=$_acceptid";
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
      //include("naglowek.php");
      //include("stopka.php");
      echo "<html><head></head><body onload='document.location.href=\"typy.php\"'></body></html>";
      
    }
  }
  else 
  if ($_addtyp)
  {
    // ------------------------------
    //     DODAWANIE - formularz
    // ------------------------------
    include("naglowek.php");

    //ustalmy conieco...
    $typy_nazwa = "";
    $typy_kolejnosc = 1;

    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"typy.php\"><B>Typy - dodawanie nowego typu</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=typy.php method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$typy_nazwa\"></td>
		    <td align=left width=190px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
	            <td align=left width=190px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usuñ typ&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='typy.php?delid=$typy_id'\"></td>
	            <td align=right width=*><input type=hidden name=addtyp_acceptid value=\"1\">
		    <input type=hidden name=p_kolejnosc value=\"$typy_kolejnosc\"></td>
                  </tr>
		</TBODY></table>
                </form>   </td></tr>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_addtyp_acceptid) 
  {
    // -----------------------------
    //   DODAWANIE - wykonanie sql
    // -----------------------------
  
    $sql = "INSERT INTO typy (nazwa, kolejnosc)
	    values ('$_p_nazwa',$_p_kolejnosc)";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // dodanie nie uda³o...
      include("naglowek.php");
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa³e¶ niepoprawne dane. <br>Popraw dane i spróbuj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powrót</a></span></td></tr></table></center>";
      include("stopka.php");
    }
    else 
    {
      //include("naglowek.php");
      //echo $p_promocje_id;
      //include("stopka.php");

      // dodatkowe zabezpieczenie - unikalno¶æ kolejnosci
      $sql = "SELECT id from typy order by id desc";
      $result = @mysql_query($sql,$db); 
      $ostatni_id = @mysql_result($result, 0, "id");

      $sql = "SELECT max(kolejnosc) as ostatni from typy";
      $result = @mysql_query($sql,$db); 
      $ostatni = @mysql_result($result, 0, "ostatni")+1;

      $sql = "UPDATE typy SET kolejnosc=$ostatni WHERE id=$ostatni_id";
      $result = @mysql_query($sql,$db);
      echo "<html><head></head><body onload='document.location.href=\"typy.php\"'></body></html>";
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
          <TD><A class=tytul href=\"typy.php\"><B>Typy produktów</B></A>
            </TD></TR></TBODY></TABLE>";
  // ---------------------- CONTENT ---------------------- 
  // nag³ówek tabeli typów...
  echo "<TABLE width=\"600\">
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
                      <TD width=32>Id.</TD>
                      <TD>Nazwa</TD>
                      <TD align=center colSpan=4>
			 <A class=edytuj href=\"typy.php?addtyp=1\">Dodaj nowy</A></TD></TR>";
  
  // typy........ SQL............
  //
  $sql = "SELECT * from typy order by kolejnosc";
  $result = @mysql_query($sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $typy_id = @mysql_result($result, $i, "id");
    $typy_nazwa = @mysql_result($result, $i, "nazwa");
    $typy_kolejnosc = @mysql_result($result, $i, "kolejnosc");
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
    echo "<TD align=right class=lista style=\"COLOR: #000000\">$typy_id</TD>";
    echo "<TD><SPAN 
            style=\"COLOR: blue\"><B>$typy_nazwa</b></SPAN></TD>
          <TD width=50 align=middle><A class=edytuj 
            href=\"typy.php?editid=$typy_id\">Edytuj</A> 
          </TD>
          <TD width=50 align=middle>";


    // usuwanie tylko - je¶li nie ma powi±zanych produktów z danym typem
    $sql_d = "SELECT * from produkty where typy_id=$typy_id";
    $result_d = @mysql_query($sql_d,$db);
    if (@mysql_num_rows($result_d) == 0)
    {
      echo "<A class=usun 
            onclick=\"return confirm('Czy na pewno chcesz usun±æ?')\" 
            href=\"typy.php?delid=$typy_id\">Usuñ</A>";
    }
    else
    {
      echo " &nbsp; ";
    }

    echo "</TD>
          <TD width=30 align=middle>";
		if ($i>0)
		echo "<A class=usun href=\"typy.php?upid=$typy_id\"><img src=\"images/up.gif\" border=0></A> ";
          echo "</TD>
          <TD width=30 align=middle>";
                if ($i<@mysql_num_rows($result)-1)
		  echo "<A class=usun href=\"typy.php?downid=$typy_id\"><img src=\"images/down.gif\" border=0></A>";
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
