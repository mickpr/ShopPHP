<?php
    $aDoAuth = True;
    if ( isset( $PHP_AUTH_USER ) )
    {
        if ( ( $PHP_AUTH_USER == "admin" ) && 
             ( $PHP_AUTH_PW == "jmpe45f" ) )
        {
            // prawid�owa nazwa u�ytkownika i has�o
            $aDoAuth = False;
        }
    }

    if( $aDoAuth == True ) 
    {
    	header('WWW-Authenticate: Basic realm="Autoryzacja"');
    	header('HTTP/1.0 401 Unauthorized');
    	echo "Musisz poda� poprawny login i has�o by wej�� na t� stron�.<br>\n";
        echo "Nie uda�o si� zalogowanie do systemu.\n";
        exit;
    } 
?>
