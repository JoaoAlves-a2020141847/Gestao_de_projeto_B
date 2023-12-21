<?php
    function i18n(string $key) : string {
        if(defined($key)) 
            return constant($key); 
        else
            return $key;
    }
?>