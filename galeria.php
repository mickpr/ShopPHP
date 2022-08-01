<?
  echo"<TABLE cellSpacing=0 cellPadding=0 width=100% border=0>
         <TBODY>
           <TR><TD class=galeria_header><SPAN class=tabelka_font>&nbsp;Galeria</SPAN></TD></TR>";
	$sql="SELECT * from produkty where zdjecie<>\"\"";
    	$result = @mysql_query($sql,$db);
    	// losowanie :-)
        $i=rand(0,@mysql_num_rows($result)-1);
    	$productname = @mysql_result($result, $i, "nazwa");
      	$prid = @mysql_result($result, $i, "id");
      	$brutto = @mysql_result($result, $i, "brutto");
      	$zdjecie = @mysql_result($result, $i, "zdjecie");
	  echo "<TR><TD class=galeria_tlo align=center>
	  <a class=nowosci_link href=\"main.php?prid=$prid\">
	  <img src=\"out_thumb.php?file=./img/$zdjecie&w=90&h=	150\" border=0><br>
	  $productname</a></TD></TR>
	  <TR><TD class=galeria_cena align=\"right\">Brutto: $brutto z³&nbsp;</TD></TR>
          <TR><TD background=images/brbg.gif height=3></TD></TR>";
    	
echo "</tbody></table>";
?>
