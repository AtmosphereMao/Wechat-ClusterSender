<?php
function helpers_test($value='')
{
    dump("helpers_test".$value);
}

function other_test($value='')
{
    dump("other_test".$value);
}


function GetInfo($base_uri,$redirect_uri,$push_uri)
{
    //            echo $base_uri.'<br>';
    //            echo $redirect_uri.'<br>';
    //            echo $push_uri;
    $output = exec('python ../app/Http/Controllers/Python/GetInfo.py ' . $base_uri . ' ' . $redirect_uri . ' ' . $push_uri);
    $output = urldecode($output);
    $resulf = substr($output, 1);
    $resulf = substr($resulf, 0, -1);
    $resulf = str_replace("'", "", $resulf);
    $resulf = str_replace("[", "", $resulf);
    $resulf = substr($resulf,0,strlen($resulf)-1);
    $analysis = explode("],", $resulf);
//                dd($analysis);
    $wx_array = array();
    foreach ($analysis as $value) {
        $friend_info = explode(",", $value);
        array_push($wx_array, $friend_info);
    }
    return $wx_array;
}
?>