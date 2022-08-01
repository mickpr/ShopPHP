<?
	$subsql="SELECT * FROM kategorie WHERE nadrzedny_id = $kategorie_id AND id != nadrzedny_id order by kolejnosc, nazwa";
        $subresult = @mysql_query($subsql,$db);
        for ($j = 0; $j < @mysql_numrows($subresult); $j++) 
        {
          $subcategoryname = @mysql_result($subresult, $j, "nazwa");
          $subcategoryid = @mysql_result($subresult, $j, "id");
          echo "<TR><TD class=podkategorie>&nbsp;<A class=podkategorie_link href=\"main.php?cat=$subcategoryid\">$subcategoryname</A></TD></TR>\n";
        }
?>
