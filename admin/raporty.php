<?
  include "../config.inc";
  $db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
  @mysql_select_db("$databasename",$db);

  include "naglowek.php";
?>

      <TABLE class=txt cellSpacing=1 cellPadding=2 width="100%">
        <TBODY>
        <TR class=title>
          <TD><A class=tytul 
            href="raporty.php"><B>Raporty</B></A> 
          </TD></TR></TBODY></TABLE>
      
      <TABLE class=txt cellSpacing=1 cellPadding=2 width="100%" bgColor=gray>
        <TBODY>
        <TR class=stat_often>
          <TD colSpan=6><B>Najczê¶ciej kupowane produkty</B> </TD></TR>
        <TR class=stat_head>
          <TD width=20>Lp.</TD>
          <TD width="41%">Produkt</TD>
          <TD width=100>Data dodania</TD>
          <TD width=140>Kategoria</TD>
          <TD width=100>Typ</TD>
          <TD width=40 align=middle>Zakupów</TD></TR>
<?
  $sql="select sum(ilosc) as ilosc, produkty_id from pozycje_zamowien group by produkty_id order by ilosc desc limit 10";
  $result = @mysql_query($sql,$db);
  //echo "$sql";
  $lp=1;
  for ($i = 0; $i < @mysql_num_rows($result); $i++) 
  {
    $ilosc= @mysql_result($result, $i, "ilosc");
    $produkty_id= @mysql_result($result, $i, "produkty_id");

    $sql2="select * from produkty where id=$produkty_id";
    $result2 = @mysql_query($sql2,$db);
    $produkty_nazwa= @mysql_result($result2, 0, "nazwa");
    $produkty_data_ceny= @mysql_result($result2, 0, "data_ceny");
    $produkty_kategorie_id= @mysql_result($result2, 0, "kategorie_id");
    $produkty_typy_id= @mysql_result($result2, 0, "typy_id");

    $sql3="select * from kategorie where id=$produkty_kategorie_id";
    $result3 = @mysql_query($sql3,$db);
    $kategorie_nazwa= @mysql_result($result3, 0, "nazwa");

    $sql3="select * from typy where id=$produkty_typy_id";
    $result3 = @mysql_query($sql3,$db);
    $typy_nazwa= @mysql_result($result3, 0, "nazwa");

    echo "<TR class=stat_content>
            <TD>$lp</TD>
            <TD><A class=lista style=\"TEXT-DECORATION: none\" 
              href=\"XXXXXXX\">$produkty_nazwa</A></TD>
            <TD>$produkty_data_ceny</TD>
            <TD>$kategorie_nazwa</TD>
            <TD align=middle>$typy_nazwa</TD>
            <TD align=middle>$ilosc</TD></TR>

     ";
    $lp++;
  }

?>
       
        
          
</TBODY></TABLE>


<BR></TD></TR></TBODY></TABLE>

<?
  include "stopka.php";
?>