<?php

// dane z mysql
include "config.inc";
$db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
@mysql_select_db("$databasename",$db);



echo "nadkategoria,podkategoria,nazwa,symbol,brutto,netto\n";

// czy nad-kategoria zawiera podkategorie
$sql="SELECT * FROM kategorie WHERE nadrzedny_id = id order by kolejnosc";
$result = @mysql_query($sql,$db);
for ($i = 0; $i < @mysql_num_rows($result); $i++) 
{

  $nazwa = @mysql_result($result, $i, "nazwa");
  $nadrzedny_id = @mysql_result($result, $i, "nadrzedny_id");
  $nadkategoria=$nazwa;

  $sql2="SELECT * FROM kategorie WHERE nadrzedny_id = $nadrzedny_id and nadrzedny_id<>id order by kolejnosc";
  $result2 = @mysql_query($sql2,$db);

  // tutaj drukowanie kategorii o nazwie '$nazwa' ...	
 
  // potem podkategorie...
  for ($j = 0; $j < @mysql_num_rows($result2); $j++)
  {
    $categoryname2 = @mysql_result($result2, $j, "nazwa");
    $podkategoria=$categoryname2;
    $categoryid = @mysql_result($result2, $j, "id");
    // liczba produktów w kategorii
    $sql3="SELECT id FROM produkty WHERE kategorie_id=$categoryid";
    $result3 = @mysql_query($sql3,$db);
    $count3 = @mysql_num_rows($result3);

    // je¶li w danej kategorii s± jakie¶ produkty... pokazuj j± :-)
    if ($count3>0) 
    {

      $sql4="SELECT * from produkty WHERE kategorie_id=$categoryid order by nazwa";
      $result4 = @mysql_query($sql4,$db);
      $k = 0;
      while ($k < @mysql_num_rows($result4))
      {
        $nazwa  = @mysql_result($result4, $k, "nazwa");
    	$brutto = @mysql_result($result4, $k, "brutto");
     	$netto  = @mysql_result($result4, $k, "netto");
	$symbol = @mysql_result($result4, $k, "symbol");
	//pokazanie produktu i ceny        
	echo $nadkategoria . "," . $podkategoria . "," . $nazwa . "," . $symbol . "," . $brutto . "," . $netto . "\n";
        $k++;

      }
    }
  }
}

mb_http_output("Windows-1250");
ob_start("mb_output_handler");

header("Content-type: text/csv");
// ustawiamy jego nazwê 
header("Content-Disposition: attachment; filename=cennik.csv");

?>
