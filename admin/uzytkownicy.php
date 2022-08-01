<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);
  $zmieniacz=0;

  $_delid=$_GET["delid"];
  $_editid=$_REQUEST["editid"];
  $_p_nazwa=$_REQUEST["p_nazwa"];
  $_p_haslo=$_REQUEST["p_haslo"];
  $_p_promocja=$_REQUEST["p_promocja"];
  $_p_promocja=str_replace(",",".",$_p_promocja);
  $_p_klientid=$_REQUEST["p_klientid"];

  $_acceptid=$_REQUEST["acceptid"];
  $_adduzytkownicy=$_REQUEST["adduzytkownicy"];
  $_add_acceptid=$_REQUEST["add_acceptid"];
  // kasowanie - je¶li delid! - potem normalne wy¶wietlanie
  if ($_delid) 
  {
    $sql="Delete From uzytkownicy where id=$_delid";
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
    $sql = "SELECT * from uzytkownicy where id=$_editid";
    $result = @mysql_query($sql,$db);

    $p_id = @mysql_result($result, 0, "id");
    $p_nazwa = @mysql_result($result, 0, "nazwa");
    $p_haslo=@mysql_result($result, 0, "haslo");
    $p_promocja=@mysql_result($result, 0, "promocja");
    $p_klientid=@mysql_result($result, 0, "klientid");

    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"uzytkownicy.php\"><B>Zarz±dzanie u¿ytkownikami- edycja</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=uzytkownicy.php method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$p_nazwa\"></td>
                    </tr>   
		  <tr><td align=left width=50px>Has³o:</td>
                    <td align=left width=200px><input class=szukaj type=password style=\"WIDTH: 200px\" name=p_haslo value=\"$p_haslo\"></td>
                    </tr>   
		  <tr><td align=left width=200px>Kwota promocji:</td>
                    <td align=left width=100px><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_promocja value=\"$p_promocja\"></td>
                    </tr>
		  <tr><td align=left width=200px>Klient:</td>
                    <td align=left width=100px>
                    ";
	// teraz zrobimy sobie selecta z klientów
	echo "<select class=szukaj style=\"WIDTH: 400px\" name=p_klientid>";
	$sql1 = "SELECT * from klienci order by nazwa";
	$result1 = @mysql_query($sql1,$db);
  	for ($j = 0; $j < @mysql_num_rows($result1); $j++) 
  	{
          $klient_id = @mysql_result($result1, $j, "id");
          $klient_nazwa = @mysql_result($result1, $j, "nazwa");
          $klient_email = @mysql_result($result1, $j, "email");
          $klient_adres = @mysql_result($result1, $j, "adres");
          $klient_telefon = @mysql_result($result1, $j, "telefon");
	  echo "<option value=$klient_id";
	  if ($klient_id==$p_klientid)
	  {
	    echo " selected ";
          }
	  echo ">$klient_nazwa , $klient_adres</option>";
	}



	echo "</td></tr></select>";
	    echo" <tr><td align=left width=200px></td>     
		    <td align=left width=150px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
 	              <td align=left width=200px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usuñ&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='uzytkownicy.php?delid=$p_id'\">
                        <input type=hidden name=acceptid value=\"$p_id\">
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
    $sql = "UPDATE uzytkownicy set nazwa='$_p_nazwa', haslo='$_p_haslo', promocja='$_p_promocja', klientid=$_p_klientid where id=$_acceptid";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // uaktualnienie siê nie uda³o...
      include("naglowek.php");
      echo $sql;
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa³e¶ niepoprawne dane. <br>Popraw dane i spróbuj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powrót</a></span></td></tr></table></center>";
      include("stopka.php");
    }
    else 
    {
      Header ("Location: uzytkownicy.php");
      //echo "<html><head></head><body onload='document.location.href=\"uzytkownicy.php\"'></body></html>";
    }
    // koniec uaktualniania po edycji...
  }
  else 
  if ($_adduzytkownicy)
  {
    // ------------------------------
    //     DODAWANIE - formularz
    // ------------------------------
    include("naglowek.php");

    //ustalmy conieco...
    $p_nazwa = "";
    $p_haslo = "";
    $p_promocja = "0.00";

    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"promocje.php\"><B>Zarz±dzanie u¿ytkownikami - dodawanie nowego</B></A> 
            </TD></TR></TBODY></TABLE>";

    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=uzytkownicy.php method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$p_nazwa\"></td>
                    </tr>   
		  <tr><td align=left width=50px>Has³o:</td>
                    <td align=left width=200px><input class=szukaj type=password style=\"WIDTH: 200px\" name=p_haslo value=\"$p_haslo\"></td>
                    </tr>   
		  <tr><td align=left width=200px>Kwota promocji:</td>
                    <td align=left width=100px><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_promocja value=\"$p_promocja\"></td>
                    </tr>
		  <tr><td align=left width=200px>Klient:</td>
                    <td align=left width=100px>
                    ";
	// teraz zrobimy sobie selecta z klientów
	echo "<select class=szukaj style=\"WIDTH: 400px\" name=p_klientid>";
	$sql1 = "SELECT * from klienci order by nazwa";
	$result1 = @mysql_query($sql1,$db);
  	for ($j = 0; $j < @mysql_num_rows($result1); $j++) 
  	{
          $klient_id = @mysql_result($result1, $j, "id");
          $klient_nazwa = @mysql_result($result1, $j, "nazwa");
          $klient_email = @mysql_result($result1, $j, "email");
          $klient_adres = @mysql_result($result1, $j, "adres");
          $klient_telefon = @mysql_result($result1, $j, "telefon");
	  echo "<option value=$klient_id>$klient_nazwa , $klient_adres</option>";
	}

	echo "</select></td></tr>

                        <input type=hidden name=add_acceptid value=\"1\">
                        </td>
                  </tr>
	          <tr><td align=left width=200px></td>     
		      <td align=left width=150px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
		  </tr>
		</TBODY></table>
                </form>   </td></tr>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_add_acceptid) 
  {
    // -----------------------------
    //   DODAWANIE - wykonanie sql
    // -----------------------------
  
    $sql = "INSERT INTO uzytkownicy(nazwa, haslo,promocja,klientid)
	    values ('$_p_nazwa','$_p_haslo', $_p_promocja, $_p_klientid)";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // dodanie nie uda³o...
      include("naglowek.php");
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa³e¶ niepoprawne dane. <br>Popraw dane i spróbuj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powrót</a></span></td></tr></table></center>";
      echo "\n$sql";
      include("stopka.php");
    }
    else 
    {
      //include("naglowek.php");
      //echo $p_promocje_id;
      //include("stopka.php");
      echo "<html><head></head><body onload='document.location.href=\"uzytkownicy.php\"'></body></html>";
    }
    // koniec dodawania
  }
  else
  {
    // -------------------------------------------
    //   WY¦WIETLANIE LISTY - PUSTE WYWO³ANIE     
    // -------------------------------------------
   
    // najpierw nag³ówek.......
    include("naglowek.php");
 
    echo "<TABLE class=txt cellSpacing=2 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"promocje.php\"><B>Zarz±dzanie u¿ytkownikami</B></A>
            </TD></TR></TBODY></TABLE>";
  // ---------------------- CONTENT ---------------------- 
  // nag³ówek tabeli uzytkownikow...
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
                      <TD>Has³o</TD>
                      <TD align=center>Promocja</TD>
                      <TD align=center width=300>Klient</TD>
                      <TD align=center colSpan=4>
			 <A class=edytuj href=\"uzytkownicy.php?adduzytkownicy=1\">Dodaj nowego</A></TD></TR>";
  
  // ........ SQL............
  //
  $sql = "SELECT * from uzytkownicy where id>0 order by nazwa";
  $result = @mysql_query($sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $user_id = @mysql_result($result, $i, "id");
    $user_nazwa = @mysql_result($result, $i, "nazwa");
    $user_haslo = @mysql_result($result, $i, "haslo");
    $user_promocja= @mysql_result($result, $i, "promocja");
    $user_klientid= @mysql_result($result, $i, "klientid");
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
  

	$sql1 = "SELECT * from klienci where id=$user_klientid";
	$result1 = @mysql_query($sql1,$db);
        $klient_nazwa = @mysql_result($result1, 0, "nazwa");
        $klient_email = @mysql_result($result1, 0, "email");
        $klient_adres = @mysql_result($result1, 0, "adres");
        $klient_telefon = @mysql_result($result1, 0, "telefon");



    // wiersz zawieraj±cy 1 uzytkownika...
    echo "<TD width=100><SPAN 
            style=\"COLOR: blue\"><B>$user_nazwa</b></SPAN></TD>
	  <TD width=50>$user_haslo</TD>
	  <TD width=50 align=right>$user_promocja</TD>
	  <TD width=600>$klient_nazwa --- $klient_adres</TD>

  	<TD width=50 align=middle>";
	if ($user_id>1)
          {
            echo "<A class=edytuj 
              href=\"uzytkownicy.php?editid=$user_id\">Edytuj</A> 
              ";
          }
        echo "</TD><TD width=50 align=middle>";  
	if ($user_id>1)
          {
           echo "<A class=usun 
              onclick=\"return confirm('Czy na pewno chcesz usun±æ?')\" 
              href=\"uzytkownicy.php?delid=$user_id\">Usuñ</A>";
          }  
          echo "</TD></TR>";
    } // koniec pêtli for  (w³a¶ciwej listy)...

    echo "</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
      <TR>
      <TD class=txt>
      </TD></TR></TBODY></TABLE>
      </TD></TR></TBODY>
      </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");

  } // koniec.... pustego wywo³ania - listy uzytkownikow...


?>
