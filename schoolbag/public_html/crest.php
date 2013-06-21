<?php
 $src = imagecreatefromjpeg('information/1/S/crest.jpg');
 $img_width = imagesx($src);
 $img_height = imagesy($src);

 // Create trans image
 $dest = imagecreatetruecolor($img_width, $img_height);
 //imagesavealpha($dest, true); // This has no effect it appears
 $trans_colour = imagecolorallocatealpha($dest, 255, 255, 255, 0);

 // Make the background transparent
imagecolortransparent($dest, $trans_colour);
 //imagefill($dest, 0, 0, $trans_colour); // This does not work

 // Merge src on top of dest, with opacity of 1 in this case
// imagecopymerge($dest, $src, 0, 0, 0, 0, $img_width, $img_height, 1);

 // Output and free from memory
 header('Content-Type: image/png');
 imagepng($dest);
 ?>