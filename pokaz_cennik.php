<?
  if ($pokaz_cennik!=0)
  {
    echo "<!-- *** CENNIKI *** -->";
    echo"<TABLE cellSpacing=0 cellPadding=0 width=190 border=0>
           <TBODY>
       	     <TR class=cennik_header>
	       
              <TD vAlign=center><span class=tabelka_font>Cenniki</span></TD></TR>
             <TR>
               <TD>
		<A class=ml 
		onmouseover=\"Pokaz('tip1', event)\" 
		onmouseout=\"Ukryj()\"
		href=\"cennik.php\">&nbsp;
		<img border=0 name=\"cennik\" src=\"images/cennik.gif\" 
		STYLE=\"position: relative; top: +5px\" 
		onMouseOver=\"this.src='images/cennik2.gif'\"
		onMouseOut=\"this.src='images/cennik.gif'\" >
		&nbsp;Cennik do wydruku (PDF)</A><br></TD></TR>
             <TR>
               <TD>
		<A class=ml 
		onmouseover=\"Pokaz('tip2', event)\" 
		onmouseout=\"Ukryj()\"
		href=\"cennik_csv.php\">&nbsp;
		<img border=0 name=\"cennik2\" src=\"images/save2.png\" 
		STYLE=\"position: relative; top: +5px\" 
		onMouseOver=\"this.src='images/save.png'\"
		onMouseOut=\"this.src='images/save2.png'\" >
		&nbsp;Cennik CSV (np. Excel)</A><br><br></TD></TR>
           </TBODY>
         </TABLE>";
  echo "<DIV class=tooltip id=tip1>Cennik w formacie PDF<BR>Do wydrukowania.</DIV>";
  echo "<DIV class=tooltip id=tip2>Cennik w formacie CSV<BR>(Ms Excel) - kodowanie ISO-8859-2!!!</DIV>";
 
  }
?>
