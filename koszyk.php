<?
  // rozpakuj zawarto¶æ koszyka...
  $subtotal = 0;
  $lp = 1;
  // rozpakuj ciag (string) ciasteczka w tablice
  $_basket=$_COOKIE["basket"];
  $items = explode("&", $_basket);

    // nag³ówek koszyka
    echo "<TABLE cellSpacing=0 cellPadding=2 width=190 border=0>
          <TBODY>
             <TR>
               <TD vAlign=center class=koszyk_header><SPAN 
                   class=tabelka_font>Zawarto¶æ koszyka</SPAN> </TD>
             </TR>";
  
  // je¶li w tablicy zawieraj±cej ciasteczka jest choæ 1 element...
  if (count($items)>1)
  {
    // pozycje koszyka...
    // listowanie zawartosci tablicy zawierajacej produkty i ich ilo¶æ...
    for ($i = 0; $i < count($items)-1; $i++) 
    {
      // dane z bazy o cenie i nazwie produktu...
      // wy³uskanie ilo¶ci i identyfikatora z $items
      $items_values = explode("=", $items[$i]);
      $items_id = $items_values[0];
      $items_val = $items_values[1];
      $sql="SELECT * FROM produkty WHERE id=$items_id";
      $result = @mysql_query("$sql",$db);
      if (@mysql_num_rows($result) == 0) 
      {
        $nazwa = "B³±d";
        $cena = 0;
      } 
      else 
      {
        $nazwa = @mysql_result($result, 0, "nazwa");
        $brutto = @mysql_result($result, 0, "brutto");
        $sql2="SELECT kategorie.nazwa FROM kategorie, produkty WHERE produkty.kategorie_id=kategorie.id AND produkty.id=$items_id";
        $result2=@mysql_query("$sql2",$db);
        if (@mysql_num_rows($result) == 0) 
        {
          $nazwa2 = "B³±d - brak kategorii";
        } 
        else 
    	{
 	  $nazwa2 = @mysql_result($result2, 0, "nazwa");
      	}

      	$wartosc = $brutto*$items_val;
	$subtotal = $subtotal+$wartosc;
      }  
    
    echo "<tr><td class=koszyk_produkty>$nazwa ($items_val szt.)</td></tr>
	";
     $lp++;
    }
    echo "<tr><td class=koszyk_produkty><b>Razem <font color=red>$subtotal z³</font> brutto</b></td></tr>";
  }
  else
  {
    echo "<tr><td class=koszyk_produkty>&nbsp;Twój koszyk jest pusty... :-(</td></tr>";
  }
  echo "</tbody></table>";
?>
