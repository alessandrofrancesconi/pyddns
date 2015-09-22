<?php     
    if (isset($_POST["newip"])) {
        $f = fopen("ip.txt", "w");
        fwrite($f, $_POST["newip"]. PHP_EOL);
        fclose($f);
    }
    else {
        $f = fopen("ip.txt", "r");
        $ip = trim(fgets($f));
        fclose($f);
        
        if (!filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $location = "Location: http://". $ip .":314";
            header($location); 
        }
        else error_log($ip . " is not a valid address.\n", 3, "error.log");
    }
    
    die(); 
?>