<?php

$enc=openssl_encrypt("osamahaffar@gmail.com+anas",  "AES-128-CBC", "Classera");
//echo $enc;
$x=base64_encode($enc);
echo $x;
echo "<br>";
$y=base64_decode($x);
echo $y;
$dec=openssl_decrypt($y,  "AES-128-CBC", "Classera");
echo  $dec;
echo "<br>";

$msg= explode("+", $dec);
print_r($msg);
die;