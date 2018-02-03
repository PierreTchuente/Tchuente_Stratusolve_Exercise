<?php
/**
 * Created by PhpStorm.
 * User: TCHUENTE
 * Date: 02-Feb-18
 * Time: 6:20 PM
 * @param $data
 */


function logData($data){
    file_put_contents('./log_'.date("j.n.Y").'.txt', $data .'\n', FILE_APPEND);
}