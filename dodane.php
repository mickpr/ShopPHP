<?
  echo"<TABLE cellSpacing=0 cellPadding=2 width=190 border=0>
         <TBODY>
               <TR>
                 <TD class=dodane_header>
	         <SPAN class=tabelka_font>Nowo¶ci</SPAN> </TD></TR>";

	$sql="SELECT nazwa, brutto, id from produkty order by id desc limit $ilosc_ostatnich";
    	$result = @mysql_query($sql,$db);
    	for ($i = 0; $i < @mysql_num_rows($result); $i++) 
	{
      	  $productname = @mysql_result($result, $i, "nazwa");
      	  $prid = @mysql_result($result, $i, "id");
      	  $brutto = @mysql_result($result, $i, "brutto");
	    echo "<TR class=nowosci_tlo><TD><a class=nowosci_link href=\"main.php?prid=$prid\">$productname</a></TD></TR>
	    <TR class=nowosci_tlo><TD align=\"right\"><font size=-2 color=blue>Brutto: $brutto z³</font></TD></TR>
            <TR><TD background=images/brbg.gif height=3></TD></TR>";
    	}

  $subtotal = 0;
  $subtotal2 = 0;
  $subtotal3 = 0;
  $items = explode("&", $basket);
  for ($i = 0; $i < count($items)-1; $i++) 
  {
    // Pobierz najnowsza cene z bazy danych...
    $sql="SELECT * FROM ceny WHERE produkty_id=$items[$i]";
    $result = @mysql_query("$sql",$db);
    if (@mysql_num_rows($result) == 0) {
      $brutto = 0;
      $netto = 0;
      $marza = 0;
    } 
    else 
    {
      $subtotal += @mysql_result($result, 0, "brutto");
      $subtotal2 += @mysql_result($result, 0, "netto");
      $subtotal3 += @mysql_result($result, 0, "marza_brutto");
    }  
  }

  echo "<input type=\"hidden\" name=\"total\" size=\"4\" value=\"$subtotal\">";
  echo "<input type=\"hidden\" name=\"total2\" size=\"4\" value=\"$subtotal2\">";
  echo "<input type=\"hidden\" name=\"total3\" size=\"4\" value=\"$subtotal3\">";
?>
