<?php

function logger($login, $lokasi)
{
    if (!file_exists("$lokasi" . "log.txt")) {
        file_put_contents("$lokasi" . "log.txt", ' ');
    }
    date_default_timezone_set("asia/Jakarta");
    $time = date('d/m/y h:iA', time());

    $contents = file_get_contents("$lokasi/log.txt");
    $contents .= "$time\t$login\r";

    file_put_contents("$lokasi/log.txt", $contents);
}
