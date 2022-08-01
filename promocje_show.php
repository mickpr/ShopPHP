<?

    $data_obecna=date("Y-m-d");
    $sql_p="SELECT * from promocje WHERE data_waznosci>='$data_obecna' order by data_waznosci desc";
    $result_p = @mysql_query($sql_p,$db);
    for ($pi = 0; $pi < @mysql_num_rows($result_p); $pi++) 
    {
      $promocje_id = @mysql_result($result_p, $pi, "id");
      $promocje_opis = @mysql_result($result_p, $pi, "opis");
      $promocje_datawaznosci = @mysql_result($result_p, $pi, "data_waznosci");

      echo "<TABLE cellSpacing=2 cellPadding=2 width=\"100%\" border=0>
            <tbody><TR><TD><IMG height=4 src=\"images/i.gif\"></TD></TR>
            <TR><TD class=promocje>$promocje_opis";
      
      echo"</TD></TR></TABLE>";

      // pokazywanie produktów z okre¶lonej promocji
      $sql="SELECT produkty.* from produkty WHERE promocje_id = $promocje_id order by data_ceny desc";
      include("product_description.php");
    }    
?>