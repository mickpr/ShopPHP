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
Przyk�adowy zrzut okienka sklepu internetowego przedstawiono poni�ej.<br><br>
<center><img src=\"images/zrzut1.jpg\" border=0></center>
Podstawowe elementy sklepu to
<ul>
<li>Belka wyszukiwania
<li>Panel produkt�w
<li>Panele dodatkowe (boczne)
</ul>
Belka wyszukiwania s�u�y do szukania okre�lonych wyrob�w wg kategorii, typu b�d� te� fragmencie nazwy/opisu/symbolu, przy czym fragment ten wpisuje si� w okienko edycyjne zawieraj�ce zwrot 'Wpisz szukany tekst'.
Panel produkt�w s�u�y do podgl�du opis�w i podstawowych danych o produktach. (Na powy�szym zdj�ciu prezentowana jest strona g��wna sklepu, gdzie wida� opis oraz jeden z produkt�w, b�d�cy przypisany do podanego opisu (w tym przypadku promocji).<br>
Panel po lewej stronie ekranu zawiera pogrupowane linki do kategorii produkt�w. Klikni�cie na takim linku spowoduje pokazanie wszystkich produkt�w z podanej kategorii.<br>
Panel po prawej zawiera (przyk�adowo) 3 elementy. Pierwszy to zawarto�� koszyka, kt�ry mo�emy r�wnie� podejrze� poprzez klikni�cie na symbolu koszyka w prawym g�rnym rogu ekranu.
Druga cz�� zawiera nazwy i ceny ostatnio dodanych produkt�w, za� cz�� trzecia - produkty kt�re by�y najcz�ciej zamawiane. 
Obydwie te cz�ci r�wnie� s� linkami, za� klikni�cie na nazwie produktu spowoduje wy�wietlenie jego opisu (i ew. zdj�cia) w �rodkowej cz�ci ekranu.

</p>
              <ul>
              <li>Produkty
              <li>Kategorie produkt�w
              <li>Typy produkt�w
              <li>Promocje / wiadomo�ci
              <li>Zam�wienia / klienci
              <li>Raporty
              </ul>
                </TD></TR></TBODY></TABLE>";



  include "stopka.php";
?>
