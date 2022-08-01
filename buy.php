<?
  // Otwórz bazê...
  include "config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  $_serverek=$_SERVER["QUERY_STRING"];
  $_yes=$_GET["yes"];
  $_no=$_GET["no"];
  $_item=$_GET["item"];
  $_ilosc=$_GET["ilosc"];
  $_brutto=$_GET["brutto"];
  $_basket=$_COOKIE["basket"];
  // dodajemy je¶li wci¶niêto Tak
  if ($_yes!="") 
  {
    // troche inteligencji 
    $ilosc=str_replace(",",".",$ilosc);

    // rozpakuj koszyk do tablicy $items...
    $items = explode("&", $_basket);
    $jest=0;
    for ($i = 0; $i < count($items)-1; $i++) 
    {
      // wy³uskanie ilo¶ci i identyfikatora z $items
      $items_values = explode("=", $items[$i]);
      $items_id = $items_values[0];
      $items_val = $items_values[1];
      // je¶li jaka¶ pozycja w koszyku pasuje do obecnie dodawanej, to...
      if ($items_id==$_item)
      {
        $jest=1;
        $items_values[1]=$items_values[1]+$_ilosc;
      }
      $items[$i]=implode("=",$items_values);
    }

    // i zapakuj zpowrotem koszyk ...
    $_basket = implode("&", $items);
    if ($jest==0)
      setcookie("basket","$_basket$_item=$_ilosc&");
    else
      setcookie("basket","$_basket");

    echo "<html><head><script language=\"javascript\">
    opener.document.shoppingcart.total.value = parseInt(opener.document.shoppingcart.total.value) + $_brutto;

    // prze³adowanie okienka w celu od¶wie¿enia zawarot¶ci koszyka wywo³ywanego z main.php - poprzez odczyt cookies... :-)
    opener.location.reload();
    this.close();</script></head></html>";
  }

  // nic nie robimy je¶li wci¶niêto Nie, nic nie dodajemy
  if ($_no!="") 
  {
    echo "<html><head><script language=\"javascript\">this.close();</script></head></html>";
  }

  // Pobierz nazwe, brutto i netto z bazy...
  if (!$_item)
  {
    $sql="SELECT nazwa, brutto, netto FROM produkty WHERE id='$_serverek'";
  }
  else
  {
    $sql="SELECT nazwa, brutto, netto FROM produkty WHERE id=$_item";
  }
  $result = @mysql_query("$sql",$db);
  if (@mysql_num_rows($result) == 0) 
  {
    echo "<html><head><title>B³±d!</title></head>
          <body><h1>B³±d!</h1><h2>Tego nie ma w naszym sklepie!</h2></body></html>";
    exit();
  } 
  else 
  {
    $nazwa = @mysql_result($result, 0, "nazwa");
    $brutto = @mysql_result($result, 0, "brutto");
    $netto = @mysql_result($result, 0, "netto");
    echo "<html><head><title>Dodawanie produktu do zamówienia.</title>
          <LINK href=\"";
    echo $styl_main;

    echo "\" type=text/css rel=stylesheet>
      </head>
      <body>
      <center>
      <span class=mn>
        Czy chcesz dodaæ ?<br><br></span>
      <TABLE  class=nazwa_produktu><TBODY><TR align=center><td width=400>
        \"$nazwa\"<br></td></tr></TBODY></TABLE><TABLE class=newsbox><TBODY><tr align=center><td width=400>(Cena = $brutto z³ brutto / jm.)</td></tr></tbody></table><br>
        <font face=\"Arial, Helvetica, Tahoma, sans-serif\" size=-1>
        do Twojego koszyka?
      <form action=\"buy.php\" method=\"get\">
      <input type=\"hidden\" name=\"item\" value=\"$_serverek\">
        Ilo¶æ:<input type=\"text\" size=3 name=\"ilosc\" value=\"1\">
        <input type=\"hidden\" name=\"brutto\" value=\"$brutto\">
        <input type=\"hidden\" name=\"netto\" value=\"$netto\">
	<input type=\"submit\" name=\"yes\" value=\"Tak\">
	<input type=\"submit\" name=\"no\" value=\"Nie\">
	</form>
	</font>
	</body>
	</html>";
   }
?>
