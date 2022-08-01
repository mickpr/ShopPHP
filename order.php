<?
include "config.inc";
// sprawdzenie wype³nienia pól

$_nazwa=$_GET["nazwa"];
$_email=$_GET["email"];
$_adres=$_GET["adres"];
$_telefon=$_GET["telefon"];

if (($_nazwa=="") || ($_email=="") || ($_adres=="") || ($_telefon=="")) 
{
    header("Location:error1.html");
    exit;
}

// stwórz co¶ co wys³ane zostanie e-mailem...
//$message="$nazwa_sklepu - zamówienie\n\n";
//foreach ($HTTP_POST_VARS as $field => $value) 
//  {
//    if (!($field == "Submit")) 
//  {
//    $message=$message."$field: $value\n\n";
//  }
//}

// Otwórz bazê danych...
$db = @mysql_connect("localhost", "$databaseuser", "$databasepasswd");
@mysql_select_db("$databasename",$db);

// Zapamiêtaj zamawiaj±cego - wybierz po e-mailu i imieniu lub dodaj nowego...
$sql="SELECT * FROM klienci WHERE email='$_email' and nazwa='$_nazwa'";
$result = @mysql_query("$sql",$db);
if (@mysql_num_rows($result) != 0) 
  {
    $klienci_id = @mysql_result($result, 0, "id");
  } 
  else  
  {
    $sql = "INSERT INTO klienci (nazwa, email, adres, telefon, identyfikacja) VALUES ('$_nazwa', '$_email', '$_adres', '$_telefon', '$REMOTE_ADDR')";
    $result = @mysql_query("$sql",$db);
    $klienci_id = @mysql_insert_id();
  }

// Zapamiêtaj zamówienie...

  $p_data_zamowienia=date("Y-m-d");
  //najpierw zapisz zamowienie.. aby uzyskaæ identyfikator zamówienia...
  $sql = "INSERT INTO zamowienia (klienci_id, datazamowienia, opis, stan) VALUES ($klienci_id,'$p_data_zamowienia','opis',0)";
  $result = @mysql_query("$sql",$db);
  $zamowienia_id = @mysql_insert_id();

  $_basket=$_COOKIE["basket"];
  $items = explode("&", $_basket);

  for ($i = 0; $i < count($items)-1; $i++) 
  {

    $items_values = explode("=", $items[$i]);
    $items_id = $items_values[0];
    $items_val = $items_values[1];

    // pobierz produkty i ich ceny z bazy...
    $sql="SELECT * FROM produkty WHERE id=$items_id";

    $result = @mysql_query("$sql",$db);
    if (@mysql_num_rows($result) == 0) 
    {
      $nazwa = "Error";
    } 
    else 
    {
      $produkty_id = $items_id;
      $produkty_nazwa = @mysql_result($result, 0, "nazwa");
      $produkty_brutto = @mysql_result($result, 0, "brutto");
      $produkty_netto = @mysql_result($result, 0, "netto");
      $produkty_vat = @mysql_result($result, 0, "vat");
      $subtotal += $produkty_brutto;

      // zdejmowanie ilosci produktow z bazy...
      // najpierw odczytamy ile ich jest
      $sql2 = "select ilosc from produkty where id=$produkty_id";
      $result = @mysql_query("$sql2",$db);
      $ilosc_jm=@mysql_result($result, 0, "ilosc");
      $ilosc_jm=$ilosc_jm-$items_val;
      // i uaktualniamy dane...
      // dla pewno¶ci... zamiana na kropkê....
      $ilosc_jm=str_replace(",",".",$ilosc_jm);
      $sql2 = "update produkty set ilosc='$ilosc_jm' where id=$produkty_id";
      $result = @mysql_query("$sql2",$db);
    }
    $sql = "INSERT INTO pozycje_zamowien (produkty_id, zamowienia_id, vat, brutto, netto, ilosc) VALUES ('$produkty_id','$zamowienia_id','$produkty_vat', '$produkty_brutto','$produkty_netto','$items_val')";
    //echo "<html><head></head><body>dupa:$sql<br></body></html>";
    $result = @mysql_query("$sql",$db);
  }

  @mysql_close($db);
  header("Location:orderinfo.php");

?>
