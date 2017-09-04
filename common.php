<?php

//创建二维码
function create_qr($path, $avatar, $openid, $url) {
    if(!is_dir($path)) { 
        mkdir($path);
    }
    Vendor("phpqrcode.phpqrcode");
    $object = new \QRcode(); 

    //生成的二维码//
    $file = "qrcode/qrcode_" .$openid. ".png";
    $filename = $path.$file;
    $level = "H";
    $size = '10';
    $padding = 0;
    $saveandprint = true;
    $object -> png($url, $filename, $level, $size, $padding, $saveandprint);

    $qr = imagecreatefromstring(file_get_contents($filename));
    $thumb = imagecreatefromstring(file_get_contents($avatar));

    // 圆角图片
    $corner = imagecreatefromstring(file_get_contents('src/corner.png')); 
    $corner_size = imagesx($corner);

    $logo_size = imagesx($thumb);
    $thumb_img = imagecreatetruecolor(76, 76);
    imagecopyresampled($thumb_img, $thumb, 0, 0, 0, 0, 76, 76, $logo_size, $logo_size);
    $qr_size = imagesx($qr);
    $image_size = 400;
    $im = imagecreatetruecolor(400, 400); 
    imagecopyresampled($im, $qr, 0, 0, 0, 0, $image_size, $image_size, $qr_size, $qr_size);
    $x = (400-76)/2;
    $y = (400-80)/2;
    imagecopyresampled($im, $thumb_img, $x, $x, 0, 0, 76, 76, 76, 76);
    //中间边框
    imagesavealpha($corner, true);
    imagecopyresampled($im, $corner, $y, $y, 0, 0, 80, 80, $corner_size, $corner_size);
    imagepng($im, $filename);
    imagedestroy($im);
}
