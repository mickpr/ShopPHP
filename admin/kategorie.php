<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);
  $zmieniacz=0;

  $_delid=$_GET["delid"];
  $_upid=$_GET["upid"];
  $_downid=$_GET["downid"];
  $_editid=$_GET["editid"];
  $_acceptid=$_GET["acceptid"];
  $_addkategorie=$_GET["addkategorie"];
  $_addkategoria_acceptid=$_GET["addkategoria_acceptid"];
  $_p_nazwa=$_GET["p_nazwa"];
  $_p_nadrzedna_kategoria_id=$_GET["p_nadrzedna_kategoria_id"];
  // kasowanie - je�li delid! - potem normalne wy�wietlanie
  if ($_delid) 
  {
    $sql="Delete From kategorie where id=$_delid";
    $result = @mysql_query($sql,$db);
  }

  // przestawienie pozycji w g�r� listy (warto�� leci w d�) ..
  if ($_upid) 
  {
    // aktualna pozycja
    $sql="select * from kategorie where id=$_upid";
    $result = @mysql_query($sql,$db);
    $pozycja= @mysql_result($result, 0, "kolejnosc");
    $nad_id = @mysql_result($result, 0, "nadrzedny_id");

    // teraz sprawdzamy czy jest to kategoria nadrz�dna
    $sql="select nadrzedny_id from kategorie where id=$_upid";
    $result = @mysql_query($sql,$db);
    $czy_nadrzedny = @mysql_result($result, 0, "nadrzedny_id");

    // je�li nadrz�dny to...
    if ($czy_nadrzedny==$_upid)
    {
      // ...zamie� miejscami z innym nadrzednym

      // znajd� najwy�szy w kolejno�ci kategoria nie wy�sza ni� bie��cy...
      $sql="select kolejnosc, id from kategorie where kolejnosc<$pozycja and id=nadrzedny_id order by kolejnosc desc";
      $result = @mysql_query($sql,$db);
      $typek2_id= @mysql_result($result, 0, "id");
      $typek2_pozycja= @mysql_result($result, 0, "kolejnosc");
      // .... i zamie� z aktualn� pozycj� miejscami
      $sql="update kategorie set kolejnosc=$pozycja where id=$typek2_id";
      $result = @mysql_query($sql,$db);
      $sql="update kategorie set kolejnosc=$typek2_pozycja where id=$_upid";
      $result = @mysql_query($sql,$db);
    }
    else
    {
      // je�li podrz�dny to r�wnie� zamie� miejscami, ale z podrzednymi tylko tego!!!

      // znajd� najwy�szy w kolejno�ci nie wy�sza ni� bie��cy w tej nad_kategorii!!!.....
      $sql="select kolejnosc, id from kategorie where kolejnosc<$pozycja and nadrzedny_id=$nad_id and nadrzedny_id<>id order by kolejnosc desc";
      $result = @mysql_query($sql,$db);
      $typek2_id= @mysql_result($result, 0, "id");
      $typek2_pozycja= @mysql_result($result, 0, "kolejnosc");
      // .... i zamie� z aktualn� pozycj� miejscami
      $sql="update kategorie set kolejnosc=$pozycja where id=$typek2_id";
      $result = @mysql_query($sql,$db);
      $sql="update kategorie set kolejnosc=$typek2_pozycja where id=$_upid";
      $result = @mysql_query($sql,$db);
    }
  }

  // przestawienie pozycji w d�...(aktualna pozycja++)
  if ($_downid) 
  {
    // aktualna pozycja
    $sql="select * from kategorie where id=$_downid";
    $result = @mysql_query($sql,$db);
    $pozycja= @mysql_result($result, 0, "kolejnosc");
    $nad_id = @mysql_result($result, 0, "nadrzedny_id");

    // teraz sprawdzamy czy jest to kategoria nadrz�dna
    //$sql="select nadrzedny_id from kategorie where id=$downid";
    //$result = @mysql_query($sql,$db);
    //$czy_nadrzedny = @mysql_result($result, 0, "nadrzedny_id");
    $czy_nadrzedny = $nad_id;

    // je�li nadrz�dny to...
    if ($czy_nadrzedny==$_downid)
    {
      // znajd� najwy�szy w kolejno�ci nie ni�szy ni� bie��cy...
      $sql="select kolejnosc, id from kategorie where kolejnosc>$pozycja and id=nadrzedny_id order by kolejnosc asc";
      $result = @mysql_query($sql,$db);
      $typek2_id= @mysql_result($result, 0, "id");
      $typek2_pozycja= @mysql_result($result, 0, "kolejnosc");
      // .... i zamie� z aktualn� pozycj� miejscami
      $sql="update kategorie set kolejnosc=$pozycja where id=$typek2_id";
      $result = @mysql_query($sql,$db);
      $sql="update kategorie set kolejnosc=$typek2_pozycja where id=$_downid";
      $result = @mysql_query($sql,$db);
    }
    else
    {
      // je�li podrz�dny to r�wnie� zamie� miejscami, ale z podrzednymi tylko tego!!!

      // znajd� najwy�szy w kolejno�ci nie wy�sza ni� bie��cy w tej nad_kategorii!!!.....
      $sql="select kolejnosc, id from kategorie where kolejnosc>$pozycja and nadrzedny_id=$nad_id and nadrzedny_id<>id order by kolejnosc asc";

      $result = @mysql_query($sql,$db);
      $typek2_id= @mysql_result($result, 0, "id");
      $typek2_pozycja= @mysql_result($result, 0, "kolejnosc");
      // .... i zamie� z aktualn� pozycj� miejscami
      $sql="update kategorie set kolejnosc=$pozycja where id=$typek2_id";
      $result = @mysql_query($sql,$db);
      $sql="update kategorie set kolejnosc=$typek2_pozycja where id=$_downid";
      $result = @mysql_query($sql,$db);
    }
  }
  if ($_editid)
  {
    // ------------------------------
    //       EDYCJA - formularz
    // ------------------------------

    // edycja - je�li editid

    include("naglowek.php");

    //wyci�gniemy sobie conieco o edytowanej kategorii :-)
    $sql = "SELECT * from kategorie where id=$_editid";
    $result = @mysql_query($sql,$db);
    $kategorie_id = @mysql_result($result, 0, "id");
    $kategorie_nazwa = @mysql_result($result, 0, "nazwa");
    $kategorie_kolejnosc=@mysql_result($result, 0, "kolejnosc");
    $kategorie_nadrzedny_id=@mysql_result($result, 0, "nadrzedny_id");
    //belka tytu�owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"kategorie.php\"><B>Kategorie - edycja</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=kategorie.php method=get><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$kategorie_nazwa\"></td>
                    <td align=left width=200px>";
                    
 		// wstawienie pola select do wyboru kategorii nadrz�dnej ale to
 		// tylko wtedy gdy kategoria albo jest g��wn� nie maj�c� 
 		// powi�zanych �adnych podrz�dnych kategorii, albo jest 
 		// podrz�dn� bez �adnych produkt�w
 		//
 		// ... sprawdzamy wi�c
 		//
 		// na pocz�tek blokujemy...
 		$zezwolenie_zmiany_nadkategori=0;
 		if ($kategorie_id==$kategorie_nadrzedny_id)
 		{
 		  // je�li kategoria jest nadrz�dn� sprawdzamy dodatkowo, 
 		  // czy jest r�wnie� kategori� bez powi�zanych dodatkowych
 		  // podkategorii
	          $sql="SELECT * FROM kategorie where nadrzedny_id=$kategorie_id and id<>nadrzedny_id";
    		  $result = @mysql_query($sql,$db);
    		  if (@mysql_num_rows($result) == 0)
    		  {
    		    $zezwolenie_zmiany_nadkategori=1;
    		  }
 		}
 		else
 		{
 		  // je�li to jest kategoria podrz�dna, sprawdzamy czy nie ma czasem produkt�w
 		  // kt�re s� do niej podwi�zane...
	          $sql="SELECT * FROM produkty where kategorie_id=$kategorie_id";
    		  $result = @mysql_query($sql,$db);
    		  if (@mysql_num_rows($result) == 0)
    		  {
    		    $zezwolenie_zmiany_nadkategori=1;
    		  }
 		}
	        
	        // no i wy�wieltlamy je�li mo�na...
	        if ($zezwolenie_zmiany_nadkategori==1)
	        {
                  echo "<select class=szukaj style=\"WIDTH: 200px\" name=p_nadrzedna_kategoria_id>";
		  echo "<option value=\"$_editid\">To b�dzie kategoria g��wna</option>";
    	          $sql2="SELECT id, nazwa FROM kategorie where nadrzedny_id=id order by kolejnosc";
    		  $result2 = @mysql_query($sql2,$db);
    		  for ($i = 0; $i < @mysql_num_rows($result2); $i++)
    		    {
      		      $kategorie_nazwa2 = @mysql_result($result2, $i, "nazwa");
      		      $kategorie_id2 = @mysql_result($result2, $i, "id");
		      echo "<option value=\"$kategorie_id2\"";
		      if ($kategorie_id2=$_editid) 
		        echo " selected";
		      echo ">$kategorie_nazwa2</option>";
      		    }
		  echo "</select>";
		}
		else
		{
		  // w przeciwnym wypadku wy�wietlamy co innego...
		  echo "<input type=hidden name=p_nadrzedna_kategoria_id value=\"$kategorie_nadrzedny_id\">";
		}


     	        echo "</td><td align=left width=190px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
	              <td align=left width=190px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usu� kategori�&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun��?')) document.location.href='kategorie.php?delid=$kategorie_id'\"></td>
	            <td align=right width=*><input type=hidden name=acceptid value=\"$kategorie_id\"></td>
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
    $sql = "UPDATE kategorie set nazwa='$_p_nazwa', nadrzedny_id=$_p_nadrzedna_kategoria_id where id=$_acceptid";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // uaktualnienie si� nie uda�o...
      include("naglowek.php");
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa�e� niepoprawne dane. <br>Popraw dane i spr�buj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powr�t</a></span></td></tr></table></center>";
      include("stopka.php");
    }
    else 
    {
      //include("naglowek.php");
      //include("stopka.php");
      echo "<html><head></head><body onload='document.location.href=\"kategorie.php\"'></body></html>";
    }
  }
  else 
  if ($_addkategorie)
  {
    // ------------------------------
    //     DODAWANIE - formularz
    // ------------------------------
    include("naglowek.php");

    //ustalmy conieco...
    $kategorie_nazwa = "";
    $kategorie_kolejnosc = 1;

    //belka tytu�owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"kategorie.php\"><B>Kategorie - dodawanie nowej kategorii</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
          <TBODY><tr><td>
	      <FORM action=kategorie.php method=get><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=50px>Nazwa:</td>
                    <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$kategorie_nazwa\"></td>
                    <td align=left width=200px>";
                    
 		// wstawienie pola select do wyboru kategorii nadrz�dnej
                    echo "<select class=szukaj style=\"WIDTH: 200px\" name=p_nadrzedna_kategoria_id>";
		    echo "<option value=\"0\">To b�dzie kategoria g��wna</option>";
    			  $sql="SELECT id, nazwa FROM kategorie where id=nadrzedny_id order by kolejnosc";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $kategorie_nazwa = @mysql_result($result, $i, "nazwa");
      			    $kategorie_id = @mysql_result($result, $i, "id");
			    echo "<option value=\"$kategorie_id\">$kategorie_nazwa</option>";
      			  }
			  echo "</select></td>";

		    echo "<td align=left width=190px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td>
	            <td align=left width=190px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usu� kategori�&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun��?')) document.location.href='kategorie.php?delid=$kategorie_id'\"></td>
	            <td align=right width=*><input type=hidden name=addkategoria_acceptid value=\"1\"></td>
                  </tr>
		</TBODY></table>
                </form>   </td></tr>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_addkategoria_acceptid) 
  {
    // -----------------------------
    //   DODAWANIE - wykonanie sql
    // -----------------------------
  
    $sql = "INSERT INTO kategorie (nazwa) values ('$_p_nazwa')";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // dodanie nie uda�o...
      include("naglowek.php");
      echo "<center><table width=300px><tr><td><span class=txt>Wpisa�e� niepoprawne dane. <br>Popraw dane i spr�buj jeszcze raz. <a href=\"javascript:history.go(-1);\">Powr�t</a></span></td></tr></table></center>";
      include("stopka.php");
    }
    else 
    {

      //ustalenie nadrz�dno�ci i podrz�dno�ci kategorii
      // ustalamy ostatnio dodan� kategori�...
      $sql = "SELECT id from kategorie order by id desc";
      $result = @mysql_query($sql,$db); 
      $ostatni_id = @mysql_result($result, 0, "id");
      if ($_p_nadrzedna_kategoria_id==0)
      {
        // zero oznacza, ze to ma by� kategoria g��wna - uaktualniamy...
        $sql = "UPDATE kategorie set nadrzedny_id=id where id=$ostatni_id";
        $result = @mysql_query($sql,$db);
        $_p_nadrzedna_kategoria_id=$ostatni_id;
      }
      else
      {
        // warto�� inna ni� 0 oznacza nadrz�dn� kategori� danej kategorii...
        $sql = "UPDATE kategorie set nadrzedny_id=$_p_nadrzedna_kategoria_id where id=$ostatni_id";
        $result = @mysql_query($sql,$db); 
      }

      // dodatkowe zabezpieczenie unikalno�ci kolejnosci...
      // unikalno�� musi by� zachowana oddzielnie dla nadrz�dnych 
      // i podrz�dnych kategorii - najpierw sprawdzamy dla
      // nadrz�dnych kategorii.............................
      if ($_p_nadrzedna_kategoria_id==$ostatni_id)
      {
        $sql = "SELECT kolejnosc from kategorie where id=nadrzedny_id and id<>$ostatni_id order by kolejnosc desc";
        $result = @mysql_query($sql,$db);
        $ostatni = @mysql_result($result, 0, "kolejnosc")+1;
        $sql = "UPDATE kategorie SET kolejnosc=$ostatni WHERE id=$ostatni_id";
        $result = @mysql_query($sql,$db);
      } 
      else
      {
        // .......... a teraz dla podrzednych
        $sql = "SELECT kolejnosc from kategorie where id<>nadrzedny_id and id<>$ostatni_id order by kolejnosc desc";
        $result = @mysql_query($sql,$db); 
        $ostatni = @mysql_result($result, 0, "kolejnosc")+1;
        $sql = "UPDATE kategorie SET kolejnosc=$ostatni WHERE id=$ostatni_id";
        $result = @mysql_query($sql,$db);
      }
      //include("naglowek.php");
      //echo $sql;
      //echo "<br>";
      //echo $ostatni;
      //echo $p_nadrzedna_kategoria_id;
      //echo $ostatni_id;
      //include("stopka.php");

      echo "<html><head></head><body onload='document.location.href=\"kategorie.php\"'></body></html>";
    }
    // koniec dodawania
  }
  else
  {
    // -----------------------------
    //   WY�WIETLANIE LISTY TYP�W 
    // -----------------------------
   
    // najpierw nag��wek.......
    include("naglowek.php");
    
    echo "<TABLE class=txt cellSpacing=2 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"kategorie.php\"><B>Kategorie produkt�w</B></A>
            </TD></TR></TBODY></TABLE>";
  // ---------------------- CONTENT ---------------------- 
  // nag��wek tabeli typ�w...
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
                      <TD>Nadrz�dna kategoria</TD>
                      <TD>Nazwa kategorii</TD>
                      <TD align=center colSpan=4>
			 <A class=edytuj href=\"kategorie.php?addkategorie=1\">Dodaj now�</A></TD></TR>";
  
  // kategorie........ SQL............
  //
  $sql = "SELECT * from kategorie where nadrzedny_id=id order by kolejnosc";
  $result = @mysql_query($sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $nadrzedna_kategorie_id = @mysql_result($result, $i, "id");
    $nadrzedna_kategorie_nazwa = @mysql_result($result, $i, "nazwa");
    $nadrzedna_kategorie_kolejnosc = @mysql_result($result, $i, "kolejnosc");


      // fajne kolorki .... na j�zorki;-) ... w tabelce
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


    // poniewaz nadrzedne tez pokazujemy... wiec...
    // wiersz zawieraj�cy 1 kategori�...
    echo "<TD align=right class=lista style=\"COLOR: #000000\">$nadrzedna_kategorie_id</TD>";
    echo "<TD><SPAN style=\"COLOR: blue\"><B>$nadrzedna_kategorie_nazwa</b></SPAN></TD>
	  <TD><SPAN style=\"COLOR: blue\"><B>$nadrzedna_kategorie_nazwa</b></SPAN></TD>
          <TD width=50 align=middle><A class=edytuj href=\"kategorie.php?editid=$nadrzedna_kategorie_id\">Edytuj</A></TD>
          <TD width=50 align=middle>";
             // a usuwamy nadrzedna tylko wtedy, gdy brak podrzednych :-)...
             // wiec trzeba najpierw sprawdzic....
	     $p_sql = "SELECT * from kategorie where id<>nadrzedny_id and nadrzedny_id=$nadrzedna_kategorie_id";
	     $p_result = @mysql_query($p_sql,$db); 
	     if (@mysql_num_rows($p_result) == 0)
             {
               echo "<A class=usun onclick=\"return confirm('Czy na pewno chcesz usun��?')\" href=\"kategorie.php?delid=$nadrzedna_kategorie_id\">Usu�</A>";
             }
             echo "</TD>
             <TD width=30 align=middle>";
 	     if ($i>0)
 		echo "<A class=usun href=\"kategorie.php?upid=$nadrzedna_kategorie_id\"><img src=\"images/up.gif\" border=0></A>";
             echo "</TD>
             <TD width=30 align=middle>";
                if ($i<@mysql_num_rows($result)-1)
		  echo "<A class=usun href=\"kategorie.php?downid=$nadrzedna_kategorie_id\"><img src=\"images/down.gif\" border=0></A>";
             echo "</TD></TR>";

      // teraz bierzemy sie za podkategorie... (tu niema nadrz�dnych)
      //
      $n_sql = "SELECT * from kategorie where nadrzedny_id=$nadrzedna_kategorie_id and nadrzedny_id<>id order by kolejnosc";
      //echo $n_sql;
      $n_result = @mysql_query($n_sql,$db);
      for ($j = 0; $j < @mysql_num_rows($n_result); $j++) 
      {
        $podrzedna_kategorie_nazwa = @mysql_result($n_result, $j, "nazwa");
        $podrzedna_kategorie_id =  @mysql_result($n_result, $j, "id");
        $podrzedna_kategorie_kolejnosc = @mysql_result($n_result, $j, "kolejnosc");
        // nadrzedn� i tak wiemy jaka jest


	// no to drukujemy....

      // fajne kolorki .... na j�zorki;-) ... w tabelce
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

        // i w ko�cu  wiersz zawieraj�cy 1 kategori�...
        echo "<TD align=right class=lista style=\"COLOR: #000000\">$podrzedna_kategorie_id</TD>";
        echo "<TD><SPAN style=\"COLOR: blue\"><B></b></SPAN></TD>
	  <TD>$podrzedna_kategorie_nazwa</SPAN></TD>
          <TD width=50 align=middle><A class=edytuj href=\"kategorie.php?editid=$podrzedna_kategorie_id\">Edytuj</A></TD>
          <TD width=50 align=middle>";
             // a usuwamy nadrzedna tylko wtedy, gdy brak powi�zanych produkt�w :-)...
             // wiec trzeba najpierw sprawdzic....
	     $q_sql = "SELECT * from produkty where kategorie_id=$podrzedna_kategorie_id";
	     $q_result = @mysql_query($q_sql,$db); 
	     if (@mysql_num_rows($q_result) == 0)
             echo "<A class=usun onclick=\"return confirm('Czy na pewno chcesz usun��?')\" href=\"kategorie.php?delid=$podrzedna_kategorie_id\">Usu�</A>";
             echo "</TD>
             <TD width=30 align=middle>";
 	     if ($j>0)
 		echo "<A class=usun href=\"kategorie.php?upid=$podrzedna_kategorie_id\"><img src=\"images/up.gif\" border=0></A>";
             echo "</TD>
             <TD width=30 align=middle>";
                if ($j<@mysql_num_rows($n_result)-1)
		  echo "<A class=usun href=\"kategorie.php?downid=$podrzedna_kategorie_id\"><img src=\"images/down.gif\" border=0></A>";
             echo "</TD></TR>";

      } 
      // koniec p�tli for  (kategorii podrz�dnych)...


    } // koniec p�tli for  (nadrzednych kategorii)...

    echo "</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
      <TR>
      <TD class=txt>
      </TD></TR></TBODY></TABLE>
      </TD></TR></TBODY>
      </TABLE>$dupsko";

    // jeszcze tylko stopka strony.
    include("stopka.php");

  } // koniec.... pustego wywo�ania - listy produkt�w...


?>
