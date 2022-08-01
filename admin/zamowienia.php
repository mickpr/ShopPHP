<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);
  $zmieniacz=0;
  $data_aktualna=date("Y-m-d");

  $_delid=$_REQUEST["delid"];
  $_realized_id=$_REQUEST["realized_id"];
  $_n_realized_id=$_REQUEST["n_realized_id"];
  $_show_id=$_REQUEST["show_id"];
  $_szukaj_zamowienia=$_REQUEST["szukaj_zamowienia"];
  $_szukaj_klient_id=$_REQUEST["szukaj_klient_id"];

  // kasowanie - je¶li delid! - potem normalne wy¶wietlanie
  if ($_delid) 
  {
    $sql="Delete From zamowienia where id=$_delid";
    $result = @mysql_query($sql,$db);
    $sql="Delete From pozycje_zamowien where zamowienia_id=$_delid";
    $result = @mysql_query($sql,$db);
  }
                                                             
  if ($_realized_id) 
  {
    $sql="UPDATE zamowienia set stan=1, data_realizacji='$data_aktualna' where id=$_realized_id";
    $result = @mysql_query($sql,$db);
  }

  if ($_n_realized_id) 
  {
    $sql="UPDATE zamowienia set stan=0, data_realizacji=null where id=$_n_realized_id";
    $result = @mysql_query($sql,$db);
  }

  if ($_show_id)
  {
    // ------------------------------
    //       POKAZANIE ZAMÓWIENIA
    // ------------------------------

    // edycja - je¶li editid

    include("naglowek.php");

    //echo $data_aktualna;
    $sql = "SELECT zamowienia.id, zamowienia.datazamowienia, zamowienia.opis, zamowienia.data_realizacji, zamowienia.stan, klienci.adres, klienci.nazwa from klienci, zamowienia where zamowienia.klienci_id=klienci.id and zamowienia.id=$_show_id";
    $result = @mysql_query($sql,$db);
    $datazamowienia = @mysql_result($result, 0, "datazamowienia");
    $data_realizacji = @mysql_result($result, 0, "data_realizacji");
    $stan = @mysql_result($result, 0, "stan");
    $opis = @mysql_result($result, 0, "opis");
    $adres = @mysql_result($result, 0, "adres");
    $nazwa = @mysql_result($result, 0, "nazwa");

    // tabelka: najpierw opis zamówienia...
    echo "
    <TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"zamowienia.php?show_id=$_show_id\"><B>Szczegó³y wybranego zamówienia</B></A></td>
          <TD align=right><A class=tytul href=\"javascript:history.go(-1);\"><B>Wróæ</B></A></td>
        </tr>
        </tbody>
    </table>
      <TABLE class=txt width=\"400\" align=center border=0>
        <TBODY>
        <TR>
          <TD bgcolor=#f0f0f0 width=200 vAlign=top>Data z³o¿enia zamówienia:</td><td bgcolor=#f0f0f0 width=200>$datazamowienia</td></tr>
        <TR>
          <TD bgcolor=#f0f0f0 width=200 vAlign=top>Nazwa klienta:</td><td bgcolor=#f0f0f0 >$nazwa</td></tr>
        <TR>
          <TD bgcolor=#f0f0f0 width=200 vAlign=top>Adres klienta:</td><td bgcolor=#f0f0f0 >$adres</td></tr>
        <TR>
          <TD bgcolor=#f0f0f0 width=200 vAlign=top>Stan realizacji:</td><td bgcolor=#f0f0f0 >";

          if ($stan==0)
          {
            echo "niezrealizowane";
          }
          else
          {
            echo "zrealizowane";
          }
          echo "</td></tr>
        <TR>
          <TD bgcolor=#f0f0f0 width=200 vAlign=top>Data realizacji:</td><td bgcolor=#f0f0f0>$data_realizacji</td>

        </tr>
        </tbody>
      </table>
      <br>
      <TABLE class=title width=\"400\" align=center border=0>
        <TBODY>
        <TR>
          <TD class=txt bgcolor=#a0d0ff width=200 vAlign=top>&nbsp;Pozycje zamówienia</td>
        </tr>
        </tbody>
      </table>
    ";

    // nag³ówek tabeli pozycji zamówienia....
    echo "<TABLE cellpadding=2 cellspacing=0 class=title width=\"100%\" align=center border=0>
        <TBODY>
        <TR class=head_list >
          <TD class=txt vAlign=top>Nazwa</td>
          <TD width=120 class=txt vAlign=top>Symbol</td>
          <TD width=80 class=txt align=right vAlign=top>Brutto</td>
          <TD width=80 class=txt align=right vAlign=top>Netto</td>
          <TD width=80 class=txt align=right vAlign=top>Vat</td>
          <TD width=80 class=txt align=right vAlign=top>Ilo¶æ</td>
        </tr>
	";

    // odczytywanie poszczególnych produktów i wstawianie kolejnych wierszy tabeli w pozycji zamówieñ...
    $sql = "SELECT produkty.nazwa, produkty.symbol, pozycje_zamowien.vat, pozycje_zamowien.brutto, pozycje_zamowien.netto, pozycje_zamowien.ilosc from pozycje_zamowien, produkty where pozycje_zamowien.produkty_id=produkty.id and pozycje_zamowien.zamowienia_id=$_show_id";
    $result = @mysql_query($sql,$db);
    //echo $sql;
    $zmieniacz=0;
    $suma_netto=0;
    $suma_brutto=0;
    for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    {
      $nazwa = @mysql_result($result, $i, "nazwa");
      $vat = @mysql_result($result, $i, "vat");
      $brutto = @mysql_result($result, $i, "brutto");
      $netto = @mysql_result($result, $i, "netto");
      $ilosc = @mysql_result($result, $i, "ilosc");
      $symbol = @mysql_result($result, $i, "symbol");
      $suma_netto=$suma_netto+$netto*$ilosc;
      $suma_brutto=$suma_brutto+$brutto*$ilosc;
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

      echo"	<td class=txt vAlign=top>$nazwa</td>
      		<td class=txt vAlign=top>$symbol</td>
      		<td class=txt align=right vAlign=top>$brutto</td>
      		<td class=txt align=right vAlign=top>$netto</td>
      		<td class=txt align=right vAlign=top>$vat</td>
      		<td class=txt align=right vAlign=top>$ilosc</td>";
      echo "   		</tr>";
    }

    // teraz podsumowanie zamówienia...
    echo "
        <TR>
          <TD colspan=2 bgcolor=#a0d0Ff class=txt vAlign=top><b>Suma zamówienia:</b></td>
          <TD class=txt bgcolor=#a0d0Ff align=right vAlign=top><b>$suma_brutto z³</b></td>
          <TD class=txt bgcolor=#a0d0Ff align=right vAlign=top><b>$suma_netto z³</b></td>
          <TD colspan=2 class=txt bgcolor=#a0d0Ff vAlign=top></td>
        </tr>
        </tbody>
      </table><br>";



    // jeszcze tylko stopka strony.
    include("stopka.php");
    // koniec edycji
  }
  else
  {
    // ----------------------------------------------------------
    //   WY¦WIETLANIE LISTY ZAMóWIEÑ + ewentualnie filtrowanie
    // ----------------------------------------------------------
   
    // najpierw nag³ówek.......
    include("naglowek.php");
    
    // postawowe produkty....
    $zamowienia_sql = "SELECT zamowienia.id, zamowienia.datazamowienia, zamowienia.opis, zamowienia.data_realizacji, zamowienia.stan, klienci.adres, klienci.nazwa from klienci, zamowienia where zamowienia.klienci_id=klienci.id";

    if ($_szukaj_zamowienia==1)
    {
      $zamowienia_sql .=" AND zamowienia.stan=0";
    }
    if ($_szukaj_klient_id!=null) 
    {
      $zamowienia_sql .= " AND klienci_id=$_szukaj_klient_id";
    }

    $zamowienia_sql .= " order by zamowienia.datazamowienia desc";
    //echo $zamowienia_sql;
  
    echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul href=\"zamowienia.php\"><B>Przegl±danie zamówieñ</B></A>
            </TD></TR></TBODY></TABLE>
      <TABLE class=txt width=\"100%\" align=center border=0>
        <TBODY>
        <TR>
          <TD vAlign=top>
            <TABLE class=szukaj cellSpacing=0 cellPadding=2 width=\"100%\" 
            border=0>
              <FORM action=zamowienia.php method=get>
              <TBODY>
              <TR>
                <TD width=\"45%\">
                  <TABLE class=szukaj cellSpacing=0 cellPadding=0 width=\"100%\" 
                  align=left border=0>
                    <TBODY>
                    <TR>
                      <TD><B>Wy¶wietl :</B></TD>
                      <TD>
                        <TABLE class=szukaj cellSpacing=0 cellPadding=1 border=0>
                          <TBODY>
                          <TR>
                            <TD align=left>"; 
			    echo "<INPUT class=checkbox_szukaj type=checkbox ";
			    if ($szukaj_zamowienia==1)
                              echo " value=1 CHECKED";
                            else
                              echo " value=1 NOTCHECKED"; 

		            echo " name=szukaj_zamowienia>tylko niezrealizowane";

        echo "</TD></TR></TBODY></TABLE></TD></TR></TBODY></TABLE></TD>
                <TD width=\"55%\">
                  <TABLE class=szukaj cellSpacing=0 cellPadding=2 align=right border=0>
                    <TBODY>
                    <TR>
                      <TD><B>Klienci:</B></TD>
                      <TD><SELECT size=800px class=szukaj name=szukaj_klient_id><OPTION value=\"\" ";

    if ($_szukaj_klient_id==null)                            
    {
      echo " selected";
    }
    
    echo ">Wszyscy klienci</option>";
  
    // pokazanie combobox 1 i 2 ....
    $sql="SELECT id, nazwa, adres FROM klienci order by nazwa";
    $result = @mysql_query($sql,$db);
    for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    {
      $klienci_nazwa = @mysql_result($result, $i, "nazwa");
      $klienci_adres = @mysql_result($result, $i, "adres");
      $klienci_id = @mysql_result($result, $i, "id");
      if ($szukaj_klient_id==$klienci_id) 
      {
        echo "<OPTION value=$klienci_id selected>$klienci_nazwa  | $klienci_adres</option>\n";
      }
      else
      {
        echo "<OPTION value=$klienci_id>$klienci_nazwa  | $klienci_adres</option>\n";
      }
      
      
    }
    echo "</SELECT> </TD>";
       // przycisk szukaj...
  echo "<TD><INPUT class=button_szukaj style=\"WIDTH: 80px\" type=submit value=Wy¶wietl></TD></TR></TBODY></TABLE></TD></TR>";
  echo "</FORM></TBODY></TABLE></TD></TR>
        </TBODY></TABLE>";
  // ---------------------- CONTENT ---------------------- 
  // nag³ówek tabeli zamówieñ od klientów...
  echo "<TABLE width=\"100%\">
        <TBODY>
        <TR>
          <TD class=txt>
            <TABLE class=border cellSpacing=0 cellPadding=0 width=\"100%\" border=0>
              <TBODY>
              <TR>
                <TD align=center>
                  <TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\" border=0>
                    <TBODY>
                    <TR class=head_list>
                      <TD>Data</TD>
                      <TD>Klient</TD>
                      <TD align=center>Netto</TD>
                      <TD align=center>Brutto</TD>
                      <TD align=center>Stan</TD>
                      <TD align=center>Data<br>realizacji</TD>
                      <TD align=center colspan=2>Operacje</TD>
                      </TR>";
  
  // $sql w³a¶ciwa lista produktów.... (musi byæ ustalona wg. filtrów wcze¶niej)
  //
  $result = @mysql_query($zamowienia_sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $zamowienia_id = @mysql_result($result, $i, "id");
    $zamowienia_datazamowienia = @mysql_result($result, $i, "datazamowienia");
    $zamowienia_opis = @mysql_result($result, $i, "opis");
    $klienci_nazwa = @mysql_result($result, $i, "nazwa");
    $klienci_adres = @mysql_result($result, $i, "adres");
    $zamowienia_stan = @mysql_result($result, $i, "stan");
    $zamowienia_data_realizacji = @mysql_result($result, $i, "data_realizacji");

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
  
    // wiersz zawieraj±cy zamowienie...
    echo "<TD class=lista width=80 style=\"COLOR: #000000\">$zamowienia_datazamowienia</TD>";
    echo "<TD><SPAN 
            style=\"COLOR: blue\"><B>$klienci_nazwa - $klienci_adres</b></SPAN></TD>
          ";
    $suma_brutto=0;
    $suma_netto=0;
    $zsql="select * from pozycje_zamowien where zamowienia_id=$zamowienia_id";
    $zresult = @mysql_query($zsql,$db);
    for ($l = 0; $l < @mysql_num_rows($zresult); $l++) 
    {
      $suma_brutto=$suma_brutto+(@mysql_result($zresult, $l, "brutto")*@mysql_result($zresult, $l, "ilosc"));   
      $suma_netto=$suma_netto+(@mysql_result($zresult, $l, "netto")*@mysql_result($zresult, $l, "ilosc"));   
    }
    $suma_brutto = round($suma_brutto,2);
    $suma_netto = round($suma_netto,2);

    echo "<TD align=right>$suma_netto</TD>

          <TD align=right>$suma_brutto</TD>";

          // zamówienia... stan (ikonka czerwona/zielona)...
          echo "<TD width=30 align=center><A onclick=\"return confirm('Czy chcesz zmieniæ stan na";

	  if ($zamowienia_stan!=0) 
            { 
	      echo " NIEZREALIZOWANE?')\" href=\"zamowienia.php?n_realized_id=$zamowienia_id\"><IMG src=\"images/b_green.gif\" ";
            }
            else
            { 
              echo " ZREALIZOWANE?')\" href=\"zamowienia.php?realized_id=$zamowienia_id\"><IMG src=\"images/b_red.gif\" ";
            }
          echo "border=0></a></TD>";
          echo "<TD width=80 align=right>$zamowienia_data_realizacji</TD>";

	  echo "</TD>";
	  
          echo "
          <TD align=middle width=50><A class=usun 
            onclick=\"return confirm('Czy na pewno chcesz usun±æ?')\" 
            href=\"zamowienia.php?delid=$zamowienia_id\">Usuñ</A> 
          </TD>
          <TD align=middle width=50><A class=usun 
            href=\"zamowienia.php?show_id=$zamowienia_id\">Poka¿</A> 
          </TD></TR>";
    } // koniec pêtli for  (w³a¶ciwej listy zamówieñ)...

    echo "</TBODY></TABLE></TD></TR></TBODY></TABLE></TD></TR>
      <TR>
      <TD class=txt>
      </TD></TR></TBODY></TABLE>
      </TD></TR></TBODY>
      </TABLE>";

    // jeszcze tylko stopka strony.
    include("stopka.php");

  } // koniec.... pustego wywo³ania - listy zamówieñ...


?>
