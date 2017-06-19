$enc=openssl_encrypt    ("This string was AES-128 / ECB encrypted.",
 "AES-128-CBC",
 "some password");
 
$dec=openssl_decrypt($enc,  "AES-128-CBC", "Classera");
     echo $dec;die; 