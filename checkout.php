<?
   include "config.inc";
   $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
   @mysql_select_db("$databasename",$db);
?>

<html>
<head>
<title>Zapis zamówienia</title>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-2">
<LINK href="<? echo $styl_main ?>" type=text/css rel=stylesheet>
</head>

<body bgcolor="#ffffff">
<center>

<table width="800" border="0" cellspacing="0" cellpadding="1" align="center">
  <tr align="center">
    <td><span class=zamow_font><b>Realizacja zamówienia</b></span>

      <table border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="60%" valign="top"><p><span class=zamow_font><font size=2>
	    Potwierdź złożenie zamówienia wypełniając Twoimi danymi ten formularz i kliknij OK. 
	    Zamówienie zostane przesłane do nas, a po jego otrzymaniu potwierdzimy jego przyjęcie. 
            Po otrzymaniu przyjęcia wystarczy dokonać przelewu na podane przez nas konto. Realizacja nastąpi natychmiast po zaksięgowaniu przelewu.
	    Minimalna kwota zakupu tylko 20 zł brutto
	    Przesyłka wykonana jest na nasz koszt tak , że żadnych dodatkowych kosztów nie ponosi kupujący.<br>
	    Gwarantujemy wysoką jakość naszych produktów.</font>
	    
</span></p></td></tr>
        <tr>
          <td align=center width="40%" valign="top">
            </td>
        </tr>
      </table>

    </td>
  </tr>
  <tr align="center">
    <td>

      <table cellspacing="0" cellpadding="1">
        <tr align="center">
          <td>

            <form action="order.php" method=get name="orderform">
              <p>
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
          <td width="400" valign="top" align="left"> 
            <p><a class=me href="main.php"><img border=0 src="images/k_powrot.jpg"></a></p>
          </td>
	  <td width="400" align=right" valign="top">
	    <a class=mn href="basket.php"><img align=right border=0 src="images/k_zmien.jpg"></a>
          </td>
        </tr>
      </table>
<?
  if (count($items)>1)
  {
    echo "<p><font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><b>
        Twoje zamówienie obejmuje następujące pozycje...</b></font></p>
      <p>
      <table border=\"0\" width=\"800\"  cellspacing=0 cellpadding=0>
        <tr cellspacing=0 cellpadding=0 align=center> 
          <td> 
	    <table class=zamow_font width=800 cellspacing=0 cellpadding=2 >
	      <tr>
		<td align=center class=tabelka_lt>Lp.</td>
		<td width=350 align=center class=tabelka_t>Produkt</td>
		<td align=center class=tabelka_t>Kategoria</td>
		<td align=center class=tabelka_t>Ilość</td>
		<td align=center class=tabelka_t>Cena<br>jedn.</td>
		<td align=center class=tabelka_rt>Wartość<br>Brutto</td>
		<td class=newsbox></td>
		<td border=0 cellspacing=0 cellpadding=0 ></td></tr>";
  		
 		// listowanie zawartosci tablicy zawierajacej produkty i ich ilość...
		for ($i = 0; $i < count($items)-1; $i++) 
		{
		  // dane z bazy o cenie i nazwie produktu...
		  // wyłuskanie ilości i identyfikatora z $items
		  $items_values = explode("=", $items[$i]);
		  $items_id = $items_values[0];
		  $items_val = $items_values[1];

    		  $sql="SELECT * FROM produkty WHERE id=$items_id";
    		  $result = @mysql_query("$sql",$db);
    		  if (@mysql_num_rows($result) == 0) 
    		  {
      		    $nazwa = "Błąd";
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
      		      $nazwa2 = "Błąd - brak kategorii";
      		    } 
		    else 
    		    {
 		      $nazwa2 = @mysql_result($result2, 0, "nazwa");
      		    }

      		    $wartosc = $brutto*$items_val;
		    $subtotal = $subtotal +$wartosc;
                  }  
    
    echo "<tr height=28>
	<td width=5 class=tabelka_lm align=right>$lp</td>
	<td class=tabelka_m align=left><a class=ml href=\"main.php?prid=$items_id\">$nazwa&nbsp:(ID:$symbol)</a></td>
	<td class=tabelka_m align=right>$nazwa2</td>
	<td class=tabelka_m align=right>$items_val</td>
	<td class=tabelka_m align=right>$brutto</td>
	<td class=tabelka_m align=right>$wartosc</td>
	<td class=tabelka_font></td>
	</tr>";
     $lp++;
    }

  echo "<tr >
    	  <td class=tabelka_lb align=left height=24 colspan=5><b>Razem (brutto):</b></td>
    	  <td class=tabelka_rb align=right><INPUT TYPE=HIDDEN NAME=\"sum\" VALUE=\"$subtotal\"><b>$subtotal</b></td>
    	  <td class=newsbox align=right></td>
        </tr>
        </TABLE>
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
        Twoje zamówienie jest puste. Zapraszamy do zakupów...</font><br><br></p>";
    echo "</td>
    </tr>
    </table>";

  }

?>


   <br>
   <font size="2" face="Verdana, Arial, Helvetica, sans-serif">* = wymagane</font><br>
       <table border=0 cellspacing=0 cellpadding=3>
          <tr>
            <td align="right" width="250"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Imię i nazwisko / Nazwa firmy:</font></td>
            <td width="112">
              <input type=text name="nazwa" size=40></td>
            <td width="7">*</td></tr>
          <tr>
            <td align="right" width="250"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">e-mail:</font></td>
            <td width="112">
              <input type=text name="email" size=40></td>
            <td width="7">*</td></tr>
          <tr>
            <td width="250" align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Adres:</font></td>
            <td width="112">
              <input type=text name="adres" size=40></td>
            <td>*</td></tr>
          <tr>
            <td width="250" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Telefon kontaktowy:</font></td>
            <td width="112">
              <input type=text name="telefon" size=40></td>
            <td>*</td></tr>
        </table>

              <br>
              <table>
                <tr>
                  <td colspan=4 align=center>
                    <p>
                      <input type="submit" value="&nbsp;&nbsp;OK&nbsp;&nbsp;" name="Submit">
                      <input type="reset" value="Kasuj" name="reset">
                  </td>
                </tr>
              </table>

              </form>
          </td>
        </tr>
      </table>

    </td>
  </tr>
</table>

</center>
</body></html>