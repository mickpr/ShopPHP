<?
  include "naglowek.php";

  echo "<TABLE class=txt cellSpacing=1 cellPadding=2 width=\"100%\">
        <TBODY>
          <TR class=title>
            <TD>
              <A class=tytul href=\"produkty.php\"><B>Pomoc</B></A> 
              </TD></TR></TBODY></TABLE>";

  echo "<TABLE class=txt width=\"100%\" align=center border=0>
        <TBODY>
          <TR>
            <TD class=txt vAlign=top>
<p class=txt>Niniejsza pomoc dotyczy sklepu internetowego oraz jego administacji.
Przyk³adowy zrzut okienka sklepu internetowego przedstawiono poni¿ej.<br><br>
<center><img src=\"images/zrzut1.jpg\" border=0></center>
Podstawowe elementy sklepu to
<ul>
<li>Belka wyszukiwania
<li>Panel produktów
<li>Panele dodatkowe (boczne)
</ul>
Belka wyszukiwania s³u¿y do szukania okre¶lonych wyrobów wg kategorii, typu b±d¼ te¿ fragmencie nazwy/opisu/symbolu, przy czym fragment ten wpisuje siê w okienko edycyjne zawieraj±ce zwrot 'Wpisz szukany tekst'.
Panel produktów s³u¿y do podgl±du opisów i podstawowych danych o produktach. (Na powy¿szym zdjêciu prezentowana jest strona g³ówna sklepu, gdzie widaæ opis oraz jeden z produktów, bêd±cy przypisany do podanego opisu (w tym przypadku promocji).<br>
Panel po lewej stronie ekranu zawiera pogrupowane linki do kategorii produktów. Klikniêcie na takim linku spowoduje pokazanie wszystkich produktów z podanej kategorii.<br>
Panel po prawej zawiera (przyk³adowo) 3 elementy. Pierwszy to zawarto¶æ koszyka, który mo¿emy równie¿ podejrzeæ poprzez klikniêcie na symbolu koszyka w prawym górnym rogu ekranu.
Druga czê¶æ zawiera nazwy i ceny ostatnio dodanych produktów, za¶ czê¶æ trzecia - produkty które by³y najczê¶ciej zamawiane. 
Obydwie te czê¶ci równie¿ s± linkami, za¶ klikniêcie na nazwie produktu spowoduje wy¶wietlenie jego opisu (i ew. zdjêcia) w ¶rodkowej czê¶ci ekranu.

</p>
              <ul>
              <li>Produkty
              <li>Kategorie produktów
              <li>Typy produktów
              <li>Promocje / wiadomo¶ci
              <li>Zamówienia / klienci
              <li>Raporty
              </ul>
                </TD></TR></TBODY></TABLE>";



  include "stopka.php";
?>
