<?
  // wydobycie informacji o produktach wybranych
  $result = @mysql_query($sql,$db);
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $produkty_id = @mysql_result($result, $i, "id");
    $produkty_nazwa = @mysql_result($result, $i, "nazwa");
    $produkty_opis = @mysql_result($result, $i, "opis");
    $produkty_brutto = @mysql_result($result, $i, "brutto");
    $produkty_netto = @mysql_result($result, $i, "netto");
    $produkty_miniatura=@mysql_result($result, $i, "miniatura");
    $produkty_zdjecie=@mysql_result($result, $i, "zdjecie");
    $produkty_symbol=@mysql_result($result, $i, "symbol");
    $produkty_kategorie_id=@mysql_result($result, $i, "kategorie_id");
    $produkty_typy_id=@mysql_result($result, $i, "typy_id");
    $produkty_ilosc=@mysql_result($result, $i, "ilosc");

if ($pokazuj_ujemne!=0 || $produkty_ilosc>0)
{
    // pokazujemy je¶li taka opcja w³±czona lub ilo¶æ produktów jest >0...
    echo "<TABLE cellSpacing=2 cellPadding=0 width=\"100%\" border=0>
          <tbody>";
    echo "      
          <!-- pokazanie nazwy w opisie produktu - za ni± odstêp...-->
          ";

    if ($odstep_po_belce==1)
      echo "<TR><TD><IMG height=2 src=\"images/i.gif\"></TD></TR>";

          echo "
          <TR><TD><TABLE width=\"100%\"><TBODY>
		    <TR><TD class=nazwa_produktu>$produkty_nazwa</TD></TR>
                  </TBODY></TABLE>
          </TD></TR>";
												

    // pokazuje opis produktu.. wstawiamy tabelke je¶li s± zdjêcia....
    // inaczej jest sam opis, pod miniatura jest link - poka¿ zbli¿enie
    if ($produkty_miniatura)
    { 
	echo "<tr><td>";
	if ($produkty_zdjecie)
	{
           echo "<img align=left style=\"cursor:hand\" onclick=pokazImage($produkty_id) alt=\"Powiêksz\" border=0 src='./img/$produkty_miniatura'>";
	}
	else
        {
	    echo "<img align=left alt=\"Brak powiêkszenia\" border=0 src='./img/$produkty_miniatura'>";
	}
	echo "<P align=top valign=middle class=usl>$produkty_opis</p>
	      </td></tr>";
    }
    else
    {
        echo "<tr><td>";
        if ($produkty_zdjecie)
        {
          echo "<img align=left style=\"cursor:hand\" onclick=pokazImage($produkty_id) alt=\"Powiêksz\" border=0 src='out_thumb.php?file=./img/$produkty_zdjecie&w=$thumb_w&h=$thumb_h'>";
        }
 	// sam opis...
	echo "<P align=top valign=top class=usl>$produkty_opis</p></td></tr>";
    }

// ok... 1 table 


if ($produkty_tabelka==1)
{
  echo"<TR><TD style=\"BORDER-LEFT: #ffffff 2px solid;\" vAlign=center align=left height=40>";
  // uzyskaj nazwy typu i kategorii produktu...
  $sql4="select nazwa from kategorie where id=$produkty_kategorie_id";
  $result4 = @mysql_query($sql4,$db);
  $kategorie_nazwa = @mysql_result($result4, 0, "nazwa");
  $sql4="select nazwa from typy where id=$produkty_typy_id";
  $result4 = @mysql_query($sql4,$db);
  $typy_nazwa = @mysql_result($result4, 0, "nazwa");


  echo "<TABLE cellSpacing=0 cellPadding=2 class=tabela_produktu><TBODY>
  	<TR>
  	<TD 	      style=\"BORDER-BOTTOM: #afafaf 1px solid; BORDER-RIGHT: #afafaf 1px solid; \" width=80 bgcolor=#f4f4f4 align=left>Symbol:</td>
  	<td width=200 style=\"BORDER-BOTTOM: #afafaf 1px solid; \" bgcolor=#f0f0f0 >";
  	if ($produkty_symbol) 
  	{
  	  echo $produkty_symbol;
  	}
  	else
  	{
  	  echo "(brak)";
  	}
  	echo "&nbsp; </TD></TR>
  	<TR class=tabela_produktu>
  	<TD style=\"BORDER-BOTTOM: #afafaf 1px solid; BORDER-RIGHT: #afafaf 1px solid; \" align=left>Kategoria:</td><td style=\"BORDER-BOTTOM: #afafaf 1px solid; \">$kategorie_nazwa</td></tr>
  	<TR class=tabela_produktu>
  	<TD style=\" BORDER-RIGHT: #afafaf 1px solid;\" bgcolor=#f0f0f0 align=left>Typ:</td><td align=left bgcolor=#f0f0f0 >$typy_nazwa</td></tr>
  	
  	</tbody></table></td>";

echo "</tr>";
}
echo "  	<TR><TD vAlign=center align=right height=40>";
// koniec tabeli opisu produktu

    $il2=Round($produkty_ilosc);

    echo " <TABLE cellSpacing=0 cellPadding=0 border=0><TBODY>
  	     <TR>";
  	     // pokazywanie ilo¶ci 
  	     if ($pokazuj_ilosc!=0)
  	     {
  	     //...stare....
  	     
  	     /*echo "<td><img src=\"images/";
  	     if ($produkty_ilosc<1)
  	        echo "0.gif\"";
  	     elseif ($produkty_ilosc>=1 && $produkty_ilosc<=10)
  	        echo "10.gif\"";
  	     elseif ($produkty_ilosc>=11 && $produkty_ilosc<=50)
  	        echo "50.gif\"";
  	     elseif ($produkty_ilosc>=50)
  	        echo "100.gif\"";
  	     */
  	     //..... i nowe

  	     // zabezpieczenie przed bzdurami...
  	     if ($produkty_ilosc>$skala_ilosci)
  	       $produkty_ilosc=$skala_ilosci;
  	     if ($produkty_ilosc<0)
  	       $produkty_ilosc=0;
  	     echo "<td><img src='belka.php?s=$skala_ilosci&w=$produkty_ilosc'";
  	     echo " alt=\"$il2 szt.\" border=0>&nbsp;&nbsp;&nbsp;</td><td></td>";
  	     }

  	     echo "<TD width=120 align=right><SPAN class=szcb>$produkty_brutto </SPAN><span class=szcn>z³ brutto &nbsp;&nbsp;</span>";
	       if ($pokazuj_netto==1)
 	       {
	         echo "<SPAN class=szcn>$produkty_netto z³ netto </SPAN>";
	       }
	       echo "</TD><TD>&nbsp;&nbsp;
 	       <IMG onClick=\"buyItem($produkty_id);return true;\" alt=\"Dodaj towar do koszyka\" style=\"cursor:hand\" src=\"images/p_dokoszyka.gif\" border=0>&nbsp;";

// <IMG alt=\"Poka¿ opis wyrobu\" src=\"images/p_opis.gif\" border=0>

echo "  </TD></TR>
      </TBODY></TABLE>
    </TD></TR>";

	echo "</TBODY></TABLE>";
// ....
// koniec pokazywania ujemnych
}

    }    
?>