  // licznik czasu generacji strony...
  function pobierz_microczas() 
  { 
    list($msek, $sek) = explode(" ", microtime()); 
    return ((float)$msek + (float)$sek); 
  } 
  $czas_poczatku = pobierz_microczas();












  $czas_konca = pobierz_microczas();
  $czas_trwania = round($czas_konca - $czas_poczatku, 2);
  echo $czas_trwania; 
  echo " sek.";

