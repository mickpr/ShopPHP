<?php
    $aDoAuth = True;
    if ( isset( $PHP_AUTH_USER ) )
    {
        if ( ( $PHP_AUTH_USER == "admin" ) && 
             ( $PHP_AUTH_PW == "jmpe45f" ) )
        {
            // prawid³owa nazwa u¿ytkownika i has³o
            $aDoAuth = False;
        }
    }

    if( $aDoAuth == True ) 
    {
    	header('WWW-Authenticate: Basic realm="Autoryzacja"');
    	header('HTTP/1.0 401 Unauthorized');
    	echo "Musisz podaæ poprawny login i has³o by wej¶æ na tê stronê.<br>\n";
        echo "Nie uda³o siê zalogowanie do systemu.\n";
        exit;
    } 
?>
