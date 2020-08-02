<?php

function _d2($data, $die = false) {
    //print '<div style="color=red">';
    if(is_array($data)) { //If the given variable is an array, print using the print_r function.
        print "<pre>-----------------------\n";
        print_r($data);
        print "-----------------------</pre>";
    } elseif (is_object($data)) {
        print "<pre>==========================\n";
        var_dump($data);
        print "===========================</pre>";
    } else {
        print "=========&gt; ";
        var_dump($data);
        print " &lt;=========";
        print "</br>";
    }
    //print '</div>';

    if ($die) {
        exit;
    }
}

function _d($var, $exit = false)
{
    /*
    if(is_array($var)){
        ob_clean();
        $var = json_encode($var);
        echo $var;
        die;
    }
    //*/

    if (isset($_SERVER['HTTP_HOST']) and $_SERVER['HTTP_HOST']) {
        /*
        if (!in_array(@$_SERVER['REMOTE_ADDR'], ProjectConfiguration::getAllowedDevIps())) {
          return;
        }
        //*/

        /*
        $xx = debug_backtrace();
        echo '<pre style="background-color:navy;color:yellow" id="dump" title="'.$xx[1]['file'].' line:'.$xx[1]['line'].'">';
        //*/

        echo '<pre style="background-color:navy;color:yellow" id="dump">';
    }

    if ($var) {
        print_r($var);
    } else {
        var_dump($var);
    }

    if (isset($_SERVER['HTTP_HOST']) and $_SERVER['HTTP_HOST']) {
        echo '</pre>';
    } else {
        echo "\n";
    }

    if ($exit) {
        exit;
    }
}