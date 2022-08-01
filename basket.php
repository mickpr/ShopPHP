<?
  include "config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  $_removeall=$_GET["removeall"];
  if ($_removeall != "") 
  {
    //usuwamy ca³e ciasteczko...
    setcookie ("basket", "");
    // i przekierowujemy znów na basket.php
    header("Location: basket.php");
  }

  $_remove=$_GET["remove"];
  // je¶li usuwamy jak±¶ pozycjê...
  if ($_remove != 0) 
  {
    // rozpakuj koszyk do tablicy $items...
    $_basket=$_COOKIE["basket"];
    $items = explode("&", $_basket);
    // przepisz ponownie koszyk...
    for ($i = 0; $i < count($items)-1; $i++) 
    {
      if ($_remove != $i+1) 
      {
        $newbasket = $newbasket.$items[$i]."&";
      }
    } 
    // i zamieñ z istniej±cym...
    setcookie ("basket", "$newbasket");
    header ("Location: basket.php");
  }
?>
<html>
<head>
<title>Twój koszyk</title>

<LINK href="<? echo $styl_main ?>" type=text/css rel=stylesheet>

<META http-equiv=Content-Type content=text/html; charset=iso-8859-2>
</head>
<BODY>
<center>
<?
  $subtotal = 0;
  $lp = 1;
  // rozpakuj ciag (string) ciasteczka w tablice
  $_basket=$_COOKIE["basket"];
  $items = explode("&", $_basket);
?>

<table class=newsbox width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr align="center"> 
    <td>
      <table width="800" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="40%" valign="top" align="left"> 
            <p><a class=me href="main.php"><img border=0 src="images/k_powrot.jpg"></a></p>
          </td>

          <td width="60%" valign="top" align=right> 

<?
  // je¶li w tablicy zawieraj±cej ciasteczka jest choæ 1 element...
  if (count($items)>1)
  {
    echo "<p><a class=me href=\"checkout.php\"><img src=\"images/k_zamowienie.jpg\" border=0></a> 
 	<a class=me href=\"zamowieniepdf.php\"><img border=0 src=\"images/drukuj.jpg\"></a></p>";
    echo "<p></p>";
  }
?>

          </td>
          <td width="20%" align="center">&nbsp;</td>
        </tr>
      </table>
<?
  if (count($items)>1)
  {
    echo "<p><font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
        Twoje zamówienie obejmuje nastêpuj±ce pozycje...</b></font></p>
      <p>
      <table border=\"0\" width=\"800\"  cellspacing=0 cellpadding=0>
        <tr cellspacing=0 cellpadding=0 align=center> 
          <td> 
	    <table class=zamow_font width=800 cellspacing=0 cellpadding=2 >
	      <tr>
		<td align=center class=tabelka_lt>Lp.</td>
		<td width=350 align=center class=tabelka_t>Produkt</td>
		<td align=center class=tabelka_t>Kategoria</td>
		<td align=center class=tabelka_t>Ilo¶æ</td>
		<td align=center class=tabelka_t>Cena<br>jedn.</td>
		<td align=center class=tabelka_rt>Warto¶æ<br>Brutto</td>
		<td class=newsbox></td>
		<td border=0 cellspacing=0 cellpadding=0 ></td></tr>";
  		
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
      		    $symbol = @mysql_result($result, 0, "symbol");
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
		    $subtotal = $subtotal +$wartosc;
                  }  
    
    echo "<tr>
	<td width=5 class=tabelka_lm align=right>$lp</td>
	<td class=tabelka_m align=left><a class=ml href=\"main.php?prid=$items_id\">$nazwa&nbsp;(ID:$symbol)</a></td>
	<td class=tabelka_m align=right>$nazwa2</td>
	<td class=tabelka_m align=right>$items_val</td>
	<td class=tabelka_m align=right>$brutto</td>
	<td class=tabelka_m align=right>$wartosc</td>
	<td class=tabelka_font><A class=me HREF=\"basket.php?remove=",$i+1,"\">&nbsp;<img src=\"./images/k_usun.jpg\" border=0></A></td>
	</tr>";
     $lp++;
    }

  echo "<tr >
    	  <td class=tabelka_lb align=left height=24 colspan=5><b>Razem (brutto):</b></td>
    	  <td class=tabelka_rb align=right><INPUT TYPE=HIDDEN NAME=\"sum\" VALUE=\"$subtotal\"><b>$subtotal</b></td>
    	  <td class=newsbox align=right></td>
        </tr>
        </TABLE>
          <p>
            <form action=\"basket.php\" method=\"get\">
              <input type=\"hidden\" name=\"removeall\" value=\"true\">
              <input type=\"image\" name=\"sub\" src=\"images/k_usun_zawartosc.jpg\">
            </form>
          </p>          
	  </td>
          </tr>
        </table>
        <p></p>
      </td>
    </tr>
    </table>";
  
  }
  else
  {
    echo "<p class=ml><font size=+1>
        Twoje koszyk jest pusty. Zapraszamy do zakupów...</font><br><br></p>";
    echo "</td>
    </tr>
    </table>";
  }
?>
</center>
</body>
</html>
