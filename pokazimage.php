<?
   include "config.inc";
   $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
   @mysql_select_db("$databasename",$db);
   $_productid=$_GET["productid"];
   $sqls="SELECT zdjecie from produkty WHERE id=$_productid";
   $results = @mysql_query($sqls,$db);
   $fullimage=@mysql_result($results, 0, "zdjecie");
   $size = GetImageSize ("img/$fullimage");
   $sizex=$size[0]+100;
   if ($sizex<450) $sizex=450;
   $sizey=$size[1]+190;
   // ustalenie pozycji okienka - aby byˆo po˜rodku
?>
<HTML>
<HEAD>
<TITLE>zbli¿enie</TITLE>
<LINK href="<? echo $styl_main ?>" type=text/css rel=stylesheet>
<?
 $sizex1=$sizex/2;
 $sizey1=$sizey/2;

echo "<SCRIPT language=JavaScript type=text/JavaScript>
function ustaw() 
{
  x1=screen.availWidth/2;
  y1=screen.availHeight/2;
  window.moveTo(x1-$sizex1,y1-$sizey1);
}
</SCRIPT>";
?>


</HEAD>

<!-- autozamykanie po 10 sekundach -->

<?
 echo "<body bgcolor=\"white\" onload=\"setTimeout('javascript:window.close()',10000);  window.resizeTo($sizex,$sizey); ustaw(); \">";

 echo "<center><table border=0><tbody><tr><td align=center valign=middle>";
 $sqls="SELECT * from produkty WHERE id=$_productid";
 $results = @mysql_query($sqls,$db);
 $produkty_miniatura=@mysql_result($results, 0, "miniatura");
 $produkty_zdjecie=@mysql_result($results, 0, "zdjecie");
 $produkty_nazwa=@mysql_result($results, 0, "nazwa");
 $produkty_kategorie_id=@mysql_result($results, 0, "kategorie_id");
 $produkty_symbol=@mysql_result($results, 0, "symbol");
 $produkty_typy_id=@mysql_result($results, 0, "typy_id");
 echo "<img name=\"zdjecie\" align=middle src='./img/$produkty_zdjecie' border=0>";
 echo "</td></tr></tbody></table>";
 echo "<br><table class=newsbox width=400><tbody>
                <tr>
 		  <td align=center>$produkty_nazwa</td>
 		</tr>
 	</tbody></table><br>";

 // zawsze pokazujemy tabelkê
 
 echo"<TR><TD style=\"BORDER-LEFT: #ffffff 2px solid;\" vAlign=center align=left height=40>";
 // uzyskaj nazwy typu i kategorii produktu...
 $sql4="select nazwa from kategorie where id=$produkty_kategorie_id";
 $result4 = @mysql_query($sql4,$db);
 $kategorie_nazwa = @mysql_result($result4, 0, "nazwa");
 $sql4="select nazwa from typy where id=$produkty_typy_id";
 $result4 = @mysql_query($sql4,$db);
 $typy_nazwa = @mysql_result($result4, 0, "nazwa");


 echo "<TABLE cellSpacing=0 cellPadding=2 class=tabela_produktu><TBODY>
 	<TR>
  	<TD style=\"BORDER-BOTTOM: #afafaf 1px solid; BORDER-RIGHT: #afafaf 1px solid; \" width=80 bgcolor=#f4f4f4 align=left>Symbol:</td>
  	<td width=200 style=\"BORDER-BOTTOM: #afafaf 1px solid; \" bgcolor=#f0f0f0 >$produkty_symbol &nbsp; </TD></TR>
  	<TR class=tabela_produktu>
  	<TD style=\"BORDER-BOTTOM: #afafaf 1px solid; BORDER-RIGHT: #afafaf 1px solid; \" align=left>Kategoria:</td><td style=\"BORDER-BOTTOM: #afafaf 1px solid; \">$kategorie_nazwa</td></tr>
  	<TR class=tabela_produktu>
  	<TD style=\" BORDER-RIGHT: #afafaf 1px solid;\" bgcolor=#f0f0f0 align=left>Typ:</td><td align=left bgcolor=#f0f0f0 >$typy_nazwa</td></tr>
  	</tbody></table></td></tr>";
 // ---- koniec tabelki....
 
 echo "</center>";
 $size = GetImageSize ("./img/$produkty_zdjecie");
 echo "<script language=\"javascript\"></script>";

//Funkcja zwraca tablicê z 4 elementami. 
//Pod indeksem 0 znajduje siê szeroko¶æ rysunku w pikselach, 
//pod indeksem 1 znajduje siê wysoko¶æ rysunku. 
//Indeks 2 zawiera znacznik okre¶laj±cy typ rysunku, 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF. 
//Pod indeksem 3 znajduje siê ci±g zawieraj±cy tekst height=xxx width=xxx, 
//który mo¿e byæ u¿yty bezpo¶rednio w znaczniku IMG.
//array GetImageSize( string filename [, array imgeinfo])

?>
</BODY>
</HTML>
