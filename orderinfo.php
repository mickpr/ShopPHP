<?
// kasuj koszyk ...
$basket=$_COOKIE["basket"];
if ($basket != "") {
  setcookie ("basket", "");
}
?>
<html>
<head>
<title>
<?
	include "config.inc";
	echo "$nazwa_sklepu";
?>
 - informacja o zamówieniu</title>
<META http-equiv=Content-Type content=text/html; charset=iso-8859-2>
<LINK href="./index.css" type=text/css rel=STYLESHEET>	
</head>

<body>
<center>

<table width=800 border="0" cellspacing="0" cellpadding="2" align="center">
  <tr align="center"> 
    <td>
      <p><font face="Arial, Helvetica, sans-serif"><b>Dziękujemy
        za złożenie zamówienia!</b></font> </p>
      <p><font face="Verdana, Arial, Helvetica, sans-serif">Po potwierdzeniu
	      złożonego zamówienia przystąpimy do jego realizacji.</font><br>
      </p>
      <p><font face="Verdana, Arial, Helvetica, sans-serif">Możesz się z nami skontaktować:</font></p>
      <table border="0" cellspacing="0" cellpadding="2">
        <tr> 
          <td align="right" ><font face="Verdana, Arial,
		  Helvetica, sans-serif"><b>telefonicznie:</b></font></td>
          <td ><font face="Verdana, Arial, Helvetica, sans-serif"><? echo "$telefon_sklepu"; ?></font></td>
        </tr>
        <tr> 
          <td align="right"><font face="Verdana, Arial, Helvetica,
		  sans-serif"><b>przez e-mail:</b></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif"><a href="mailto:<? echo "$email_sklepu\">$email_sklepu"; ?></a></font></td>
        </tr>
        <tr>
          <td align="right" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif"><b>lub pod adresem:</b></font></td>
          <td><font face="Verdana, Arial, Helvetica, sans-serif"><? echo "$adres_sklepu"; ?></font></td>
        </tr>
      </table>
      
      <p><font face="Verdana, Arial, Helvetica, sans-serif"><a class=me	href="main.php"><img border=0 src="images/k_powrot.jpg"></a></font></p>

    </td>
  </tr>
</table>

</center>
</body></html>
