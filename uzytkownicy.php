<?
  // wydobycie informacji o u¿ytkowniku próbujacym sie logowaæ
  //echo $_user_l;
  //echo $_user_p1;

  $sql="select * from uzytkownicy where nazwa='$_user_l' and haslo='$_user_p'";
  $result = @mysql_query($sql,$db);
  if (@mysql_num_rows($result)<1)
  {
    // logowanie nieudane ... :-(
    echo "<br>
          <TABLE cellSpacing=0 cellPadding=0 width=\"100%\" border=0><tbody>";
    echo "<TR><TD valign=top align=center>";
    echo "<TABLE cellSpacing=0 cellPadding=3 width=400><tbody>";
      echo "<TR ><TD align=center class=tabela_produktu bgcolor=#ff8080><font size=2px><b>B³±d logowania</b></font></td><TR>";
      echo "<TR ><TD align=center class=tabela_produktu height=200><font color=red size=3px>U¿ytkowniku:<b>$_user_l<BR><BR>Poda³e¶ b³êdne has³o!</b></font></td><TR>";
    echo "</TBODY></TABLE>";
    echo "</TD></TR>";
    echo "</TBODY></TABLE>";
  }
  else
  {
    // logowanie udane ... :-)
    for ($i = 0; $i < @mysql_num_rows($result); $i++) 
    {
      $user_id = @mysql_result($result, $i, "id");
      $user_nazwa = @mysql_result($result, $i, "nazwa");
      $user_haslo = @mysql_result($result, $i, "haslo");
      $user_promocja = @mysql_result($result, $i, "promocja");
      $user_klientid = @mysql_result($result, $i, "klientid");
    
      if ($user_nazwa=="admin" && @mysql_num_rows($result) > 0)
      {
         // przeladowanie... niestety tutaj nie mozna skorzystac z 'Header'...
         echo "<script>
    	this.location.href='admin/admin.php';
    	</script>";
      }
      else 
      if (@mysql_num_rows($result) > 0)
      {
        echo "<TABLE cellSpacing=0 cellPadding=0 width=\"100%\" border=0>
              <tbody>";
        echo "<TR><TD><IMG height=2 src=\"images/i.gif\"></TD></TR>";
        echo "<TR><TD align=center>";
    
        echo "<TABLE cellSpacing=0 cellPadding=0 class=tabela_produktu width=418><tbody>";
    	echo "<TR><TD class=login_header><span class=tabelka_font>Witamy u¿ytkownika : <b>$user_nazwa</b></span></td><TR>";
    	echo "<TR><TD class=login_tlo>U¿ytkownik: $user_nazwa<br></td><TR>";
        // $user_haslo
        echo "</TBODY></TABLE>";
    
        echo "<TABLE cellSpacing=0 cellPadding=1 width=418><tbody>";

    	echo "<TR><TD class=login_header><font size=2px>
	  <a class=wi href=\"zamowienia.php?userid=$user_id\" target=\"_zam\">Poka¿ zamówienia</a>&nbsp;&nbsp;
	  <a onClick='window.open(\"zmienhaslo.php?userid=$user_id\",\"_pas\",\"toolbar=no, location=no, width=1, height=1, left=0, top=0\");'
	    class=wi href=\"zmienhaslo.php?userid=$user_id\" target=\"_pas\">Zmieñ has³o</a>
	  </font></td><TR>";
        echo "</TBODY></TABLE>";
    
    
        echo "</TD></TR>
          </TBODY></TABLE>";
      } // end of if
    } //end of for...
  } // end of if..
?>
