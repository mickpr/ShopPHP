<?
    $sql="SELECT * FROM kategorie WHERE nadrzedny_id = id order by kolejnosc";
    $result = @mysql_query($sql,$db);
    for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    {
      $kategorie_nazwa = @mysql_result($result, $i, "nazwa");
      $kategorie_id = @mysql_result($result, $i, "id");
       
      // sprawdzamy, czy istniej± podkategorie tej nadkategorii 
      // - je¶li nie - to nie jest ona (kategoria g³ówna) pokazywana
      $subsql2="SELECT * FROM kategorie WHERE nadrzedny_id = $kategorie_id AND id != nadrzedny_id";
      $subresult2 = @mysql_query($subsql2,$db);
      if (@mysql_num_rows($subresult2)>0)
      { 
        echo "<TR><TD class=nadkategorie>
          <SPAN class=tabelka_font>&nbsp;$kategorie_nazwa</SPAN></TD></TR>\n";
      }

      if (($kategorie_id != $nadrzedny_id) || ($kategorie_id == $parent)) 
      {
        include("podkategorie.php");
      }
    }
?>