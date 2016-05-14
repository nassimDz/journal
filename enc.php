<?php
require('php/init.php');
$text = "this is text";
$enc =encrypt($text);
echo "Encrypted is : ".$enc."<br>";
$dec = decrypt($enc);
echo "Decrypted is : ".$dec;

?>
