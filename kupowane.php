<?
echo "<TABLE cellSpacing=0 cellPadding=0 width=190 border=0>
        <TBODY>
        <TR>
          <TD vAlign=center class=kupowane_header><SPAN 
              class=tabelka_font>&nbsp;Najczê¶ciej kupowane</SPAN> </TD></TR>";

    $sql="SELECT produkty_id , count(ilosc) as liczba FROM pozycje_zamowien group by produkty_id order by liczba desc limit $ilosc_kupowanych";
    $result = @mysql_query("$sql",$db);
    if (@mysql_num_rows($result) == 0) 
    {
      echo "<TR bgColor=#eaeaea>
       <TD class=tabelka_font>&nbsp;Niestety jeszcze nie by³o ¿adnych <br>&nbsp;zamówieñ</TD></TR>
           <TR>
            <TD background=images/brbg.gif height=5></TD></TR>";
	
    } 
    else 
    {
      for ($i = 0; $i < @mysql_num_rows($result); $i++) 
   	{
     	  $produkty_id = @mysql_result($result, $i, "produkty_id");
      	  $liczba = @mysql_result($result, $i, "liczba");

    	  $sql2="SELECT nazwa FROM produkty where id=$produkty_id";
    	  $result2 = @mysql_query("$sql2",$db);
	  $produkty_nazwa = @mysql_result($result2, 0, "nazwa");
	  

          echo "<TR><TD class=kupowane_produkty><a class=nowosci_link href=\"main.php?prid=$produkty_id\">$produkty_nazwa (";
	  if ($liczba==round($liczba,0))
	    $liczba=round($liczba,0);
	  echo $liczba;
	  if ($liczba>1) 
     	    echo " razy";
	  else echo "raz";
	  echo ")</a></TD></TR>
          	<TR><TD background=images/brbg.gif height=5></TD></TR>";
        }
    }  



echo "	</TBODY></TABLE>";
?>
