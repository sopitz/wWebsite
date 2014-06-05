<?php

Header ("Content-type: image/gif");
$im = imagecreate (70, 20);
$white = ImageColorAllocate ($im, 255, 255, 255);
$black = ImageColorAllocate ($im, 0, 0, 0);
ImageTTFText ($im, 10, 0, 0, 15, $black, "arial.ttf", base64_decode($_GET['string']));
ImageGif ($im);

?>