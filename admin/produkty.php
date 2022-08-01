<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);
  $zmieniacz=0;

  // kasowanie - je¶li delid! - potem normalne wy¶wietlanie
  $_delid=$_GET["delid"];
  $_editid=$_REQUEST["editid"];

  $_p_nazwa=$_REQUEST["p_nazwa"];
  $_p_zakup_brutto=$_REQUEST["p_zakup_brutto"];
  $_p_zakup_netto=$_REQUEST["p_zakup_netto"];
  $_p_typy_id=$_REQUEST["p_typy_id"];
  $_p_kategorie_id=$_REQUEST["p_kategorie_id"];
  $_p_brutto=$_REQUEST["p_brutto"];
  $_p_netto=$_REQUEST["p_netto"];
  $_p_vat=$_REQUEST["p_vat"];
  $_p_miniatura=$_REQUEST["p_miniatura"];
  $_p_promocje_id=$_REQUEST["p_promocje_id"];
  $_p_ilosc=$_REQUEST["p_ilosc"];
  $_p_symbol=$_REQUEST["p_symbol"];
  $_p_opis=$_REQUEST["p_opis"];
  $_acceptid=$_REQUEST["acceptid"];
  $_p_zdjecie=$_REQUEST["p_zdjecie"];
  $_addproduct=$_REQUEST["addproduct"];
  $_addproduct_acceptid=$_REQUEST["addproduct_acceptid"];
  $_p_data_ceny=$_REQUEST["p_data_ceny"];
  $_szukaj_promocja=$_REQUEST["szukaj_promocja"];
  $_text_szukaj=$_REQUEST["text_szukaj"];
  $_szukaj_kateg_id=$_REQUEST["szukaj_kateg_id"];
  $_szukaj_typ_id=$_REQUEST["szukaj_typ_id"];


  if ($_delid) 
  {
    $sql="Delete From produkty where id=$_delid";
    $result = @mysql_query($sql,$db);
  }
  if ($_editid)
  {
    // ------------------------------
    //       EDYCJA - formularz
    // ------------------------------

    // edycja - je¶li editid

    include("naglowek.php");

    //wyci±gniemy sobie conieco o edytowanym produkcie
    $sql = "SELECT produkty.* from produkty where id=$_editid";
    $result = @mysql_query($sql,$db);
    $produkty_nazwa = @mysql_result($result, 0, "nazwa");
    $produkty_symbol = @mysql_result($result, 0, "symbol");
    $produkty_id = @mysql_result($result, 0, "id");
    $produkty_brutto = @mysql_result($result, 0, "brutto");
    $produkty_netto =  @mysql_result($result, 0, "netto");
    $produkty_zakup_brutto = @mysql_result($result, 0, "zakup_brutto");
    $produkty_zakup_netto =  @mysql_result($result, 0, "zakup_netto");
    $produkty_miniatura = @mysql_result($result, 0, "miniatura");
    $produkty_zdjecie =  @mysql_result($result, 0, "zdjecie");
    $produkty_opis =  @mysql_result($result, 0, "opis");
    $produkty_typy_id =  @mysql_result($result, 0, "typy_id");
    $produkty_kategorie_id = @mysql_result($result, 0, "kategorie_id");
    $produkty_promocje_id = @mysql_result($result, 0, "promocje_id");
    $produkty_vat =  @mysql_result($result, 0, "vat");
    $produkty_ilosc =  @mysql_result($result, 0, "ilosc");
    $produkty_data_ceny =  @mysql_result($result, 0, "data_ceny");
    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"produkty.php\"><B>Produkty-edycja</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt width=\"100%\" align=center border=0>
          <TBODY>
          <TR>
            <TD vAlign=top>
              <TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
                <FORM action=produkty.php method=post name=\"frmprodukty\"><tbody>
                <tr><td align=left>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td align=left width=150px>Nazwa produktu:</td>
                      <td align=left width=200px><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa value=\"$produkty_nazwa\"></td>
                      <td align=left width=10></td>
 		      <td align=left>Cena zakupu brutto:</td><td width=200px>
			<input class=szukaj type=text style=\"WIDTH: 100px\" 
			name=\"p_zakup_brutto\"
			
			onchange='document.frmprodukty.p_zakup_netto.value=ToNetto(document.frmprodukty.p_zakup_brutto.value, document.frmprodukty.p_vat.value);'

			value=\"$produkty_zakup_brutto\"></td></tr>

  		  <tr><td width=150px>Typ produktu:</td><td align=left>";
			  // lista selekcji typu produktu....
			  echo "<select class=szukaj style=\"WIDTH: 204px\" name=p_typy_id>";
    			  $sql="SELECT id, nazwa FROM typy order by kolejnosc";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $typy_nazwa = @mysql_result($result, $i, "nazwa");
      			    $typy_id = @mysql_result($result, $i, "id");
			    if ($typy_id==$produkty_typy_id)
		            {
		  	      echo "<option value=\"$typy_id\" selected>$typy_nazwa</option>\n";
        		    }
      			    else
        		    {
          		      echo "<option value=\"$typy_id\">$typy_nazwa</option>\n";
        		    }
		          } //koniec for...
			  echo "</select>";
			echo "</td>
			<td></td>
		        <td>Cena zakupu netto:</td><td width=200px>
			<input class=szukaj type=text style=\"WIDTH: 100px\" 
			name=\"p_zakup_netto\"

			onchange='document.frmprodukty.p_zakup_brutto.value=ToBrutto(document.frmprodukty.p_zakup_netto.value, document.frmprodukty.p_vat.value);'

			value=\"$produkty_zakup_netto\"></td></tr>


		  <tr><td width=150px>Kategoria:</td><td>";
			  // lista selekcji kategorii produktu....
			  echo "<select class=szukaj style=\"WIDTH: 204px\" name=p_kategorie_id>";
    			  $sql="SELECT id, nazwa FROM kategorie where nadrzedny_id<>id order by nazwa, kolejnosc";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $kategorie_nazwa = @mysql_result($result, $i, "nazwa");
      			    $kategorie_id = @mysql_result($result, $i, "id");
			    if ($kategorie_id==$produkty_kategorie_id)
		            {
			      echo "<option value=\"$kategorie_id\" selected>$kategorie_nazwa</option>\n";
        		    }
      			    else
        		    {
          		      echo "<option value=\"$kategorie_id\">$kategorie_nazwa</option>\n";
        		    }
		          } //koniec for...
			  echo "</select>";


			echo "</td>
			<td></td>
			<td width=150px>Cena sprzeda¿y brutto:</td>
			<td><input class=szukaj type=text style=\"WIDTH: 100px\" 
                                name=\"p_brutto\"

			        onChange='document.frmprodukty.p_netto.value=ToNetto(document.frmprodukty.p_brutto.value,document.frmprodukty.p_vat.value);'
				 
				value=\"$produkty_brutto\"></td></tr>

			<tr><td width=150px>Miniatura:</td><td><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_miniatura value=\"$produkty_miniatura\"></td>
			<td><img src=\"images/folder.gif\" 
			  onClick='window.open(\"upload.html\",\"upload_miniatura\",\"toolbar=no, location=no, width=400, height=200, left=200, top=200\");' border=0></td>
		    	<td width=150px>Cena sprzeda¿y netto:</td><td>
				<input class=szukaj type=text style=\"WIDTH: 100px\" 
				name=\"p_netto\" 
	
				onchange='document.frmprodukty.p_brutto.value =ToBrutto(document.frmprodukty.p_netto.value, document.frmprodukty.p_vat.value);'
	
				value=\"$produkty_netto\"></td></tr>
			<tr><td width=150px>Zdjêcie</td><td><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_zdjecie value=\"$produkty_zdjecie\"></td>
			<td><img src=\"images/folder.gif\" 
			  onClick='window.open(\"upload.html\",\"upload_zdjecie\",\"toolbar=no, location=no, width=400, height=200, left=200, top=200\");' border=0></td>
		    	<td width=150px>VAT:</td><td><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_vat value=\"$produkty_vat\"></td></tr>
			<tr><td width=150px>Promocja:</td><td>";
			  echo "<select class=szukaj style=\"WIDTH: 204px\" name=p_promocje_id>";
    			  $sql="SELECT id, nazwa FROM promocje order by nazwa, data_waznosci";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $promocje_nazwa = @mysql_result($result, $i, "nazwa");
      			    $promocje_id = @mysql_result($result, $i, "id");
			    if ($promocje_id==$produkty_promocje_id)
		            {
			      echo "<option value=\"$promocje_id\" selected>$promocje_nazwa</option>\n";
        		    }
      			    else
        		    {
          		      echo "<option value=\"$promocje_id\">$promocje_nazwa</option>\n";
        		    }
		          } //koniec for...
			  echo "</select>";
			echo "
			<td></td>
		    	<td width=150px>Ilo¶æ (jm.):</td><td><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_ilosc value=\"$produkty_ilosc\"></td></tr>

		    	<tr><td width=150px>Symbol:</td><td><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_symbol value=\"$produkty_symbol\"></td><tr>

  			<tr><td width=150px></td><td></td>
		    	</tr>
		    	</tbody></table>

		<TABLE class=szukaj cellSpacing=0 cellPadding=0 width=\"100%\" border=0>
		<TBODY>
			<tr><td valign=top align=left width=150px>Opis</td>
			    <td valign=top align=left width=400px><textarea class=szukaj style=\"WIDTH: 400px; HEIGHT:120px\" wrap=yes name=p_opis>$produkty_opis</textarea></td>
			    <td valign=top align=left width=150px><input type=button style=\"WIDTH: 100px\" value=\"&nbsp;Usuñ produkt&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='produkty.php?delid=$produkty_id'\">
			    <input type=hidden name=acceptid value=\"$produkty_id\"></td>
			    <td valign=top align=left width=80px><input type=submit style=\"WIDTH: 100px\" value=\"   OK   \"></td></tr>
		  </td></tr>
		</tbody></form>
 	       </TABLE>
	     </TD>
	   </TR>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_acceptid) 
  {
    //troche inteligencji - autokorekta przecinków na kropki...
    $_p_vat=str_replace(",",".",$_p_vat);
    $_p_brutto=str_replace(",",".",$_p_brutto);
    $_p_netto=str_replace(",",".",$_p_netto);
    $_p_zakup_brutto=str_replace(",",".",$_p_zakup_brutto);
    $_p_zakup_netto=str_replace(",",".",$_p_zakup_netto);
    $_p_ilosc=str_replace(",",".",$_p_ilosc);
 
    $_p_data_ceny=date("Y-m-d");
    if ($_p_promocje_id==0) $_p_promocje_id=1;

    $sql = "UPDATE produkty set nazwa='$_p_nazwa', miniatura='$_p_miniatura', zdjecie='$_p_zdjecie', 
            opis='$_p_opis', typy_id=$_p_typy_id, kategorie_id=$_p_kategorie_id, promocje_id=$_p_promocje_id,
            vat='$_p_vat', zakup_brutto='$_p_zakup_brutto', zakup_netto='$_p_zakup_netto', 
            brutto='$_p_brutto', netto='$_p_netto', ilosc='$_p_ilosc', symbol='$_p_symbol', data_ceny='$_p_data_ceny' where id=$_acceptid";
    $result = @mysql_query($sql,$db);
    if ($result==FALSE)
    {
      // uaktualnienie siê nie uda³o...
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
      echo "<html><head></head><body onload='document.location.href=\"produkty.php\"'></body></html>";
    }
  }
  else 
  if ($_addproduct)
  {
    // ------------------------------
    //     DODAWANIE - formularz
    // ------------------------------
    include("naglowek.php");

    //wstawimy conieco...
    $produkty_nazwa = "";
    $produkty_brutto = 0;
    $produkty_netto =  0;
    $produkty_zakup_brutto = 0;
    $produkty_zakup_netto =  0;
    $produkty_miniatura = "";
    $produkty_zdjecie =  "";
    $produkty_opis =  "";
    $produkty_typy_id = 1;
    $produkty_kategorie_id = 1;
    $produkty_promocje_id = 1;
    $produkty_vat =  22;
    $produkty_ilosc =  1;
    //belka tytu³owa...
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"produkty.php\"><B>Produkty-dodawanie nowego produktu</B></A> 
            </TD></TR></TBODY></TABLE>";
 
    echo "<TABLE class=txt width=\"100%\" align=center border=0>
          <TBODY>
          <TR>
            <TD vAlign=top>
              <TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
                <FORM action=produkty.php name=\"frmprodukty\" method=post><tbody>
		<TABLE class=szukaj cellSpacing=0 cellPadding=1 width=\"100%\" border=0>
		<TBODY>
		  <tr><td width=150px>Nazwa produktu:</td>
                      <td align=left width=200px>
			<input class=szukaj type=text style=\"WIDTH: 200px\" name=p_nazwa 
			value=\"$produkty_nazwa\"></td><td></td>
 		      <td>Cena zakupu brutto:</td><td width=200px><input class=szukaj type=text style=\"WIDTH: 100px\" 
			name=\"p_zakup_brutto\"

			     onChange='document.frmprodukty.p_zakup_netto.value=ToNetto(document.frmprodukty.p_zakup_brutto.value,document.frmprodukty.p_vat.value);'
			
			value=\"$produkty_zakup_brutto\"></td></tr>
  		  <tr><td width=150px>Typ produktu:</td><td align=left>";
			  // lista selekcji typu produktu....
			  echo "<select class=szukaj style=\"WIDTH: 204px\" name=p_typy_id>";
    			  $sql="SELECT id, nazwa FROM typy order by kolejnosc";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $typy_nazwa = @mysql_result($result, $i, "nazwa");
      			    $typy_id = @mysql_result($result, $i, "id");
			    if ($typy_id==$produkty_typy_id)
		            {
			      echo "<option value=\"$typy_id\" selected>$typy_nazwa</option>\n";
        		    }
      			    else
        		    {
          		      echo "<option value=\"$typy_id\">$typy_nazwa</option>\n";
        		    }
		          } //koniec for...
			  echo "</select>";
			echo "</td>
			<td></td>
		        <td>Cena zakupu netto:</td><td width=200px>
			<input class=szukaj type=text style=\"WIDTH: 100px\" 
				name=\"p_zakup_netto\" 

				onchange='document.frmprodukty.p_zakup_brutto.value=ToBrutto(document.frmprodukty.p_zakup_netto.value, document.frmprodukty.p_vat.value);'			

				value=\"$produkty_zakup_netto\"></td></tr>
			<tr><td width=150px>Kategoria:</td><td>";
			  // lista selekcji kategorii produktu....
			  echo "<select class=szukaj style=\"WIDTH: 204px\" name=p_kategorie_id>";
    			  $sql="SELECT id, nazwa FROM kategorie where nadrzedny_id<>id order by nazwa, kolejnosc";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $kategorie_nazwa = @mysql_result($result, $i, "nazwa");
      			    $kategorie_id = @mysql_result($result, $i, "id");
			    if ($kategorie_id==$produkty_kategorie_id)
		            {
			      echo "<option value=\"$kategorie_id\" selected>$kategorie_nazwa</option>\n";
        		    }
      			    else
        		    {
          		      echo "<option value=\"$kategorie_id\">$kategorie_nazwa</option>\n";
        		    }
		          } //koniec for...
			  echo "</select>";


			echo "</td>
			<td></td>
			<td width=150px>Cena sprzeda¿y brutto:</td><td>
			<input class=szukaj type=text style=\"WIDTH: 100px\" 
				name=\"p_brutto\" 
				
				onchange='document.frmprodukty.p_netto.value=ToNetto(document.frmprodukty.p_brutto.value, document.frmprodukty.p_vat.value);'
				
				value=\"$produkty_brutto\"></td></tr>
			<tr><td width=150px>Miniatura</td><td><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_miniatura value=\"$produkty_miniatura\"></td>
			<td><img src=\"images/folder.gif\" 
			  onClick='window.open(\"upload.html\",\"upload_miniatura\",\"toolbar=no, location=no, width=400, height=200, left=200, top=200\");' border=0></td>
		    	<td width=150px>Cena sprzeda¿y netto:</td><td>
				<input class=szukaj type=text style=\"WIDTH: 100px\" 
				name=\"p_netto\" 

				onchange='document.frmprodukty.p_brutto.value=ToBrutto(document.frmprodukty.p_netto.value,document.frmprodukty.p_vat.value);'

				value=\"$produkty_netto\"></td></tr>
			<tr><td width=150px>Zdjêcie</td><td><input class=szukaj type=text style=\"WIDTH: 200px\" name=p_zdjecie value=\"$produkty_zdjecie\"></td>
			<td><img src=\"images/folder.gif\" 
			  onClick='window.open(\"upload.html\",\"upload_zdjecie\",\"toolbar=no, location=no, width=400, height=200, left=200, top=200\");' border=0></td>
		    	<td width=150px>VAT:</td><td><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_vat value=\"$produkty_vat\"></td></tr>
			<tr><td width=150px>Promocja:</td><td>";
			  echo "<select class=szukaj style=\"WIDTH: 204px\" name=p_promocje_id>";
    			  $sql="SELECT id, nazwa FROM promocje order by data_waznosci desc";
    			  $result = @mysql_query($sql,$db);
    			  for ($i = 0; $i < @mysql_num_rows($result); $i++)
    			  {
      			    $promocje_nazwa = @mysql_result($result, $i, "nazwa");
      			    $promocje_id = @mysql_result($result, $i, "id");
			    if ($promocje_id==$produkty_promocje_id)
		            {
			      echo "<option value=\"$promocje_id\" selected>$promocje_nazwa</option>\n";
        		    }
      			    else
        		    {
          		      echo "<option value=\"$promocje_id\">$promocje_nazwa</option>\n";
        		    }
		          } //koniec for...
			  echo "</select>";
			echo "
			<td></td>
		    	<td width=150px>Ilo¶æ (jm.):</td><td><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_ilosc value=\"$produkty_ilosc\"></td></tr>

		    	<tr><td width=150px>Symbol:</td><td><input class=szukaj type=text style=\"WIDTH: 100px\" name=p_symbol value=\"$produkty_symbol\"></td><td></td><tr>
  			
  			<tr><td width=150px></td><td></td>
		    	</tr>
		    	</tbody></table>

		<TABLE class=szukaj cellSpacing=0 cellPadding=0 width=\"100%\" border=0>
		<TBODY>
			<tr><td valign=top align=left width=150px>Opis</td>
			    <td valign=top align=left width=400px><textarea class=szukaj style=\"WIDTH: 400px; HEIGHT:120px\" wrap=yes name=p_opis>$produkty_opis</textarea></td>
			    <td valign=top align=left width=150px><input type=button style=\"WIDTH: 150px\" value=\"Poka¿ produkt\"><br>
								  <input type=button style=\"WIDTH: 150px\" value=\"&nbsp;Usuñ produkt&nbsp;\" onclick=\"if(confirm('Czy na pewno chcesz usun±æ?')) document.location.href='produkty.php?delid=$produkty_id'\">
			    <input type=hidden name=addproduct_acceptid value=\"1\"></td>
			    <td valign=top align=left width=200px><input type=submit style=\"WIDTH: 105px\" value=\"   OK   \"></td></tr>
		</tbody></form>
 	       </TABLE>
	     </TD>
	   </TR>
	 </TBODY>
	 </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else if ($_addproduct_acceptid) 
  {
    // -----------------------------
    //   DODAWANIE - wykonanie sql
    // -----------------------------
  
    //troche inteligencji - autokorekta przecinków na kropki...
    $_p_vat=str_replace(",",".",$_p_vat);
    $_p_brutto=str_replace(",",".",$_p_brutto);
    $_p_netto=str_replace(",",".",$_p_netto);
    $_p_zakup_brutto=str_replace(",",".",$_p_zakup_brutto);
    $_p_zakup_netto=str_replace(",",".",$_p_zakup_netto);
    $_p_ilosc=str_replace(",",".",$_p_ilosc);
 
    $_p_data_ceny=date("Y-m-d");
    if ($p_promocje_id==0) $p_promocje_id=1;

    $sql = "INSERT INTO produkty (nazwa, miniatura, zdjecie, opis, typy_id, kategorie_id, promocje_id,
            vat, zakup_brutto, zakup_netto, brutto, netto, ilosc, data_ceny, symbol) 
	    values ('$_p_nazwa','$_p_miniatura', '$_p_zdjecie', '$_p_opis', $_p_typy_id, $_p_kategorie_id,$_p_promocje_id,
            '$_p_vat', '$_p_zakup_brutto', '$_p_zakup_netto', '$_p_brutto', '$_p_netto', '$_p_ilosc', '$_p_data_ceny', '$_p_symbol')";
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
      echo "<html><head></head><body onload='document.location.href=\"produkty.php\"'></body></html>";
    }
    // koniec dodawania
  }
  else
  {
    // ----------------------------------------------------------
    //   WY¦WIETLANIE LISTY PRODUKTÓW + ewentualnie filtrowanie
    // ----------------------------------------------------------
   
    // najpierw nag³ówek.......
    include("naglowek.php");
    
    // postawowe produkty....
    $produkty_sql = "SELECT * from produkty";
    if (($_szukaj_promocja==1) || ($_text_szukaj) || ($_szukaj_kateg_id) || ($_szukaj_typ_id))
      {
        $produkty_sql .= " WHERE 1 "; 
      }
    if ($_szukaj_promocja==1) 
    {
      $produkty_sql .= " AND promocje_id>1";
    }
    if ($_text_szukaj!="")
    {
      $produkty_sql .=" AND nazwa LIKE '%$_text_szukaj%'";
    }
    if ($_szukaj_kateg_id)
    {
      $produkty_sql .= " AND kategorie_id=$_szukaj_kateg_id";
    }
    if ($_szukaj_typ_id)
    {
      $produkty_sql .= " AND typy_id=$_szukaj_typ_id";
    }

        
    //echo $produkty_sql;
  
    // ------------------------------
    //       PROMOCJE
    // ------------------------------
  
    
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"produkty.php\"><B>Produkty</B></A>
            </TD></TR></TBODY></TABLE>
      <TABLE class=txt width=\"100%\" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top>
            <TABLE class=szukaj cellSpacing=0 cellPadding=2 width=\"100%\" 
            border=0>
              <FORM action=produkty.php method=get name=\"frmprodukty\">
              <TBODY>
              <TR>
                <TD width=\"45%\">
                  <TABLE class=szukaj cellSpacing=0 cellPadding=0 width=\"100%\" 
                  align=left border=0>
                    <TBODY>
                    <TR>
                      <TD><B>Wy¶wietl tylko :</B></TD>
                      <TD>
                        <TABLE class=szukaj cellSpacing=0 cellPadding=1 border=0>
                          <TBODY>
                          <TR>
                            <TD align=right>"; 
			    echo "<INPUT class=checkbox_szukaj type=checkbox ";
			    if ($szukaj_promocja==1)
                              echo " value=1 CHECKED";
                            else
                              echo " value=1 NOTCHECKED"; 

		            echo " name=szukaj_promocja>promocja";
        //echo $szukaj_promocja;
        echo "</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                <TD width=\"55%\">
                  <TABLE class=szukaj cellSpacing=0 cellPadding=2 align=right 
                  border=0>
                    <TBODY>
                    <TR>
                      <TD><B>Znajd¼:</B></TD>
                      <TD><INPUT class=szukaj style=\"WIDTH: 100px\" 
                        name=text_szukaj></TD>
                      <TD><SELECT class=szukaj name=szukaj_kateg_id> <OPTION value=\"\" 
                          selected>Kategoria</option>";
    // pokazanie combobox 1 i 2 ....
    $sql="SELECT id, nazwa FROM kategorie where nadrzedny_id<>id order by nazwa";
    $result = @mysql_query($sql,$db);
    for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    {
      $kategorie_nazwa = @mysql_result($result, $i, "nazwa");
      $kategorie_id = @mysql_result($result, $i, "id");

      echo "<OPTION value=$kategorie_id>$kategorie_nazwa</option>\n";
    }
    echo "</SELECT> </TD>
          <TD><SELECT class=szukaj name=szukaj_typ_id> <OPTION value=\"\" 
          selected>Typ produktu</option>";

    $sql="SELECT * FROM typy order by nazwa";
    $result = @mysql_query($sql,$db);
    for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    {
      $typy_nazwa = @mysql_result($result, $i, "nazwa");
      $typy_id = @mysql_result($result, $i, "id");
      echo "<OPTION value=$typy_id>$typy_nazwa</option>\n";
    }
  // przycisk szukaj...
  echo "</SELECT> </TD>
        <TD><INPUT class=button_szukaj style=\"WIDTH: 80px\" type=submit value=Szukaj></TD></TR></TBODY></TABLE></TD></TR>";
  echo "</FORM></TBODY></TABLE></TD></TR>
        </TBODY></TABLE>";
  // ---------------------- CONTENT ---------------------- 
  // nag³ówek tabeli produktów...
  echo "<TABLE width=\"100%\">
        <TBODY>
        <TR>
          <TD class=txt>
            <TABLE class=border cellSpacing=0 cellPadding=0 width=\"100%\" border=0>
              <TBODY>
              <TR>
                <TD>
                  <TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\" 
                  border=0>
                    <TBODY>
                    <TR class=head_list>
                      <TD>Nazwa</TD>
                      <TD>Symbol</TD>
                      <TD align=center>Kategoria</TD>
                      <TD width=80 align=center>Typ</TD>
                      <TD align=center>Brutto</TD>
                      <TD align=center>Netto</TD>
                      <TD align=center>Zakup<br>brutto</TD>
                      <TD align=center>Zakup<br>netto</TD>
                      <TD align=center>% VAT</TD>
                      <TD align=center>Miniatura<br>/ Zdjêcie</TD>
                      <TD align=center>Opis</TD>
                      <TD align=center>Ilo¶æ</TD>
                      <TD align=center>Pro-<br>mocja</TD>
                      <TD align=center>Data</TD>
                      <TD align=center colSpan=2><A class=edytuj href=\"produkty.php?addproduct=1\">Dodaj nowy</A> </TD></TR>";
  
  // $sql w³a¶ciwa lista produktów.... (musi byæ ustalona wg. filtrów wcze¶niej)
  //
  $result = @mysql_query($produkty_sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $produkty_nazwa = @mysql_result($result, $i, "nazwa");
    $produkty_id = @mysql_result($result, $i, "id");
    $produkty_symbol = @mysql_result($result, $i, "symbol");
    $produkty_brutto = @mysql_result($result, $i, "brutto");
    $produkty_netto =  @mysql_result($result, $i, "netto");
    $produkty_zakup_brutto = @mysql_result($result, $i, "zakup_brutto");
    $produkty_zakup_netto =  @mysql_result($result, $i, "zakup_netto");
    $produkty_vat =  @mysql_result($result, $i, "vat");
    $produkty_kategorie_id =  @mysql_result($result, $i, "kategorie_id");
    $produkty_typy_id =  @mysql_result($result, $i, "typy_id");
    $produkty_miniatura =  @mysql_result($result, $i, "miniatura");
    $produkty_zdjecie =  @mysql_result($result, $i, "zdjecie");
    $produkty_opis =  @mysql_result($result, $i, "opis");
    $produkty_ilosc =  @mysql_result($result, $i, "ilosc");
    $produkty_promocje_id =  @mysql_result($result, $i, "promocje_id");
    $produkty_data_ceny =  @mysql_result($result, $i, "data_ceny");

    $sql2 = "SELECT * from kategorie where id=$produkty_kategorie_id";
    $result2 = @mysql_query($sql2,$db);
    $kategorie_nazwa = @mysql_result($result2, 0, "nazwa");

    $sql2 = "SELECT * from typy where id=$produkty_typy_id";
    $result2 = @mysql_query($sql2,$db);
    $typy_nazwa = @mysql_result($result2, 0, "nazwa");

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
  
    // wiersz zawieraj±cy produkt...
    echo "";
    echo "<TD><SPAN 
            style=\"COLOR: blue\">$produkty_nazwa</SPAN></TD>
	  <TD class=lista style=\"COLOR: #000000\">$produkty_symbol</TD>
          <TD align=left>$kategorie_nazwa</TD>
          <TD align=left>$typy_nazwa</TD>
          <TD align=right><B>$produkty_brutto</b></TD>
          <TD align=right><B>$produkty_netto</B></TD>
          <TD align=right>$produkty_zakup_brutto</TD>
          <TD align=right>$produkty_zakup_netto</TD>
          <TD align=right>$produkty_vat</TD>
          <TD align=middle><IMG src=\"images/";
	  if ($produkty_miniatura) 
          { 
	    echo "b_green.gif";
          }
          else
          { 
            echo "b_red.gif";
          }
	  echo "\" border=0>/<IMG src=\"images/";
	    
          if ($produkty_zdjecie) 
          { 
	    echo "b_green.gif";
          }
          else
          { 
            echo "b_red.gif";
          }
	  echo "\" border=0></TD><td>";
	  
	  echo "&nbsp;&nbsp;<IMG src=\"images/";
          if ($produkty_opis) 
          {
            echo "b_green.gif";
          }
          else
	  {
            echo "b_red.gif";
          }
          echo"\" border=0></TD>
          <TD align=right>$produkty_ilosc</TD><td>
          &nbsp;&nbsp;<IMG src=\"images/";
	  if ($produkty_promocje_id<2) 
	  {
            echo "b_red.gif";
          }
          else
	  {
            echo "b_green.gif";
          }
          echo "\" border=0>
          <TD width=70>$produkty_data_ceny</TD>
          <TD align=middle><A class=edytuj 
            href=\"produkty.php?editid=$produkty_id\">Edytuj</A> 
          </TD>
          <TD align=middle><A class=usun 
            onclick=\"return confirm('Czy na pewno chcesz usun±æ?')\" 
            href=\"produkty.php?delid=$produkty_id\">Usuñ</A> 
          </TD></TR>";
    } // koniec pêtli for  (w³a¶ciwej listy produktów...

    echo "</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
      <TR>
        <TD class=txt></TD>
      </TR>
      </TBODY></TABLE>
      </TD></TR></TBODY>
      </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");

  } // koniec.... pustego wywo³ania - listy produktów...


?>
