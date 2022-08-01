<?
   include "config.inc";
   $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
   @mysql_select_db("$databasename",$db);

   // konieczne dla poprawnego wysłania ciasteczka (przed zawartością strony)
   $_user_l=$_POST["user_l"];
   $_user_p=$_POST["user_p"];
   setcookie("user_p1","$_user_p");
?>


<HTML><HEAD><TITLE><? echo $nazwa_sklepu ?></TITLE>
<META http-equiv=Content-Type content="text/html; charset=iso-8859-2">
<LINK href="<? echo $styl_main ?>" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/javascript" src="main.js">
</script>
</HEAD>
<BODY>

<!-- wyszukiwanie -->
<form method="post" action="" name="shoppingcart">
<A name=gora>
<center>
<?
  include("header.php");

// Globalna tabelka sklepu poniżej :-)
?>
<TABLE height=5 cellSpacing=0 cellPadding=0 width=801 align=center border=0>
<TBODY>
  <TR class=gorny_panel>
    <td>
<?
// pusty sklep 
echo "<TABLE class=belka_wyszukiwania height=35 cellSpacing=0 cellPadding=0 width=799 align=center border=0>
      <TBODY>
        <tr>
	<TR><TD height=20>";
//         ------------- belka wyszukiwania w bloku TR tej podtabelki jako odrebna tablelka-----------  
  echo"
       <TABLE cellSpacing=0 cellPadding=0 align=center border=0>
       <TBODY>
         <TR>
           <td><a href=\"main.php\"><img src=\"images/hom_orange.gif\" border=0></a>&nbsp;</td>
           <TD width=120><FONT STYLE=\"position: relative; top: -1px\" class=formt>Wyszukiwanie: </B></FONT></TD>
           <TD><FONT face=verdana size=1>
		<SELECT STYLE=\"position: relative; top: -2px\" class=form name=\"g\" onchange='PokazKategorie(g.value)'> 
		  <OPTION value=0 selected>Kategoria produktu</OPTION>";
               	// Pole selekcji kategorii produktu...
    		$sql="SELECT id, nazwa FROM kategorie where nadrzedny_id<>id order by nazwa";
    		$result = @mysql_query($sql,$db);
    		for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    		{
      		  $kategorie_nazwa = @mysql_result($result, $i, "nazwa");
      		  $kategorie_id = @mysql_result($result, $i, "id");
      		  echo "<OPTION value=$kategorie_id>$kategorie_nazwa</option>\n";
    		}
    	    echo "</SELECT> </FONT>
	   </TD>
           <TD><IMG height=27 src=\"images/i.gif\" width=5></TD>
           <TD><IMG STYLE=\"position: relative; top: -2px\" height=27 src=\"images/st.gif\" width=9></TD>
           <TD><IMG height=27 src=\"images/i.gif\" width=5></TD>
    	   <TD><SELECT STYLE=\"position: relative; top: -2px\" class=form name=\"p\" onchange='PokazTyp(p.value)'> 
    		  <OPTION value=0 selected>Typ produktu</OPTION>"; 
		// Lista selekcji typów...
    		$sql="SELECT * FROM typy order by kolejnosc, nazwa";
    		$result = @mysql_query($sql,$db);
    		for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    		{
      		  $typy_nazwa = @mysql_result($result, $i, "nazwa");
      		  $typy_id = @mysql_result($result, $i, "id");
      		  echo "<OPTION value=$typy_id>$typy_nazwa</option>\n";
    		}
    	      echo "</SELECT> </FONT></TD>
	   <TD><IMG height=27 src=\"images/i.gif\" width=5></TD>
           <TD><IMG STYLE=\"position: relative; top: -2px\" height=27 src=\"images/st.gif\" width=9></TD>
           <TD><IMG height=27 src=\"images/i.gif\" width=5></TD>
           <TD><INPUT class=form STYLE=\"position: relative; top: -2px\" onfocus=\"if(this.value=='Wpisz szukany tekst')this.value=''\" 
             value=\"Wpisz szukany tekst\" name=s width=15></TD>
           <TD width=10 height=1px><IMG height=27 src=\"images/i.gif\" width=10></TD>
           <TD valign=center><img alt=Szukaj! STYLE=\"position: relative; top: -1px\" src=\"images/key_szukaj.gif\" border=0 
             onClick='SzukajProduktu(s.value)'>&nbsp;
		<a href=\"basket.php\"><IMG alt=\"Pokaż koszyk\" STYLE=\"position: relative; top: -1px\" src=\"images/xp_koszyk.gif\" border=0></a></TD>";

// kończymy belkę wyszukiwania..............
echo "	</TR>
      </TBODY>
      </TABLE>
    </TD>
  </TR>";

echo "</TBODY></TABLE>";
// ---                                             ---
// --- koniec podwójnej tabelki z belką wyszukiwania -
// ---                                             ---
// --- teraz to co jest poniżej belki wyszukiwania ---

// --- jak widać kolejna "globalna" tabelka" ----      
echo "
<TABLE cellSpacing=0 cellPadding=0 width=800 align=center>
  <TBODY>
  <TR>";


// teraz w tej tabelce będą 3 kolumny (podstawowe) 
// ... +ewentualnie kolumny oddzielające (kropeczki :-))
if ($oddziel_boki==1)
{ 
  echo "<td width=1px style=\"background-image: url(images/co_bg.gif);  background-repeat: repeat\"></td>";
} 
else
{
  echo "<TD width=1px></TD>";
}

// --- kolumna pierwsza - (lewe menu :-)) ----


// zaczynamy oczywiście od TD... a potem tabelka ....
echo "<TD valign=top>
      <TABLE cellSpacing=0 cellPadding=0 width=\"100%\" align=center border=0>
      <TBODY>";

if ($odstep_po_belce!=0) 
  {
    echo "<TR><TD><IMG height=$odstep_po_belce src=\"images/i.gif\"></TD></TR>";
  }

// no to odstęp mamy załatwiony, teraz treść po kolei.... 
// ... w kolejnych wierszach TR kolejne pola TD
echo "<TR vAlign=top align=middle>
	<TD width=190></td></tr>";
  include("kategorie.php");

echo "
  </TBODY>
</TABLE>";
  include("galeria.php");
  include("napisz.php");


echo "</TD>";


// koniec lewego menu....
  
if ($oddziel_srodek==1)
{ 
  echo "<td align=right width=1px style=\"background-image: url(images/co_bg.gif);  background-repeat: repeat\"></td>";
} 
else
{
  echo "<TD width=1></TD>";
};


//-------------------------------środek-----------------------------------
//
echo "<TD width=420 valign=top align=center>";

  if ($odstep_po_belce!=0) 
    echo "<table cellSpacing=0 cellPadding=0 width=\"100%\" align=center border=0><tbody>
	  <tr><TD><IMG height=$odstep_po_belce src=\"images/i.gif\"></td>
	  </tr></tbody></table>";

$_cat=$_GET["cat"];
$_mid=$_GET["mid"];
$_ssid=$_GET["ssid"];
$_prid=$_GET["prid"];



$bylo_logowanie=0;
// jeśli podano użytkownika ... redirekcja na sprawdzenie hasła
if ($_user_l && $_user_p)
{
    include "uzytkownicy.php";
    $bylo_logowanie=1;
}


if ($_cat && $bylo_logowanie==0) 
{
    $sql="SELECT produkty.* from produkty WHERE kategorie_id = $_cat";
    include("product_description.php");
}

// jeśli podano typ - wyświetlamy go ekranie....
if ($_mid && $bylo_logowanie==0) 
{
    $sql="SELECT produkty.* from produkty WHERE produkty.typy_id = $_mid";
    include("product_description.php");
}

// jeśli podano wzorzec wyszkiwania - wyświetlamy produkty jego ekranie....
if ($_ssid && $bylo_logowanie==0) 
{
    $sql="SELECT * from produkty WHERE nazwa LIKE '%$_ssid%' or opis LIKE '%$_ssid%' or symbol LIKE '%$_ssid%'";
    include("product_description.php");
}

// puste wywolanie - pokaz promocje
if ((!$_cat) && (!$_mid) && (!$_ssid) && (!$_prid) && $bylo_logowanie==0)
{
    // wyświetlanie promocji...
    include("promocje_show.php"); 
}

// wywolanie z (prid) - pokaz 1 produkt
if ($_prid && $bylo_logowanie==0)
{
    $sql="SELECT * from produkty WHERE id=$_prid";
    include("product_description.php");
}

//-------------------------------koniec środka--------------------------------
// --- ODSTEP PRAWO --- (po lewej mamy środek) ---

if ($oddziel_srodek==1)
{ 
  echo "<td width=1px style=\"background-image: url(images/co_bg.gif);  background-repeat: repeat\"></td>";
} 

// ...................*** PRAWE MENU ***........................
echo "<TD valign=top align=top width=190>";

  if ($odstep_po_belce!=0) 
    echo "<IMG height=$odstep_po_belce src=\"images/i.gif\">";

  // koszyk :-) ... bez pytania... 
  include "koszyk.php";
  include "userlogin.php";
  include "pokaz_cennik.php";
  include "dodane.php";
  include "kupowane.php";

echo "</TD>";

// koniec prawego menu - jeszcze ewentualnie odstęp i kończymy
if ($oddziel_boki==1)
{ 
  echo "<td width=1px style=\"background-image: url(images/co_bg.gif);  background-repeat: repeat\"></td>";
} 

// zamykamy cały sklep (poniżej tylko stopka)...
echo "</TR></TBODY></TABLE>";
// tutaj jest faktycznie koniec całego sklepu - poniżej jest tylko stopka ...

echo"  <!-- *** STOPKA *** -->
  <TABLE height=15 cellSpacing=0 cellPadding=0 width=800 align=center bgColor=#e9e9e9 border=0>
  <tbody>
    <TR><TD bgColor=#777777><IMG height=1 src=\"images/i.gif\" width=1></TD></TR>
    <TR><TD align=right><font size=-2 face=\"Verdana,Arial\">&copy; 2005 mickpr&nbsp;</font></TD>
    <TR><TD bgColor=#777777><IMG height=1 src=\"images/i.gif\" width=1></TD></TR>
  <tbody>
  </TABLE>";

// ---------------koniec stopki ------------------

// koniec całej globalnej tabelki sklepu...
echo "</tr></tbody></table>
</center>




</FORM>
</BODY></HTML>";

// end of main.php
?>
