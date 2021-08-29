<?php  
	session_start();
	$_SESSION['captcha'] = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'),0,4);
	header('Content-type: image/jpeg');
	$text = $_SESSION['captcha'];
	$font_size =30;
	$image_width = 125;
	$image_height = 40;
	$image = imagecreate($image_width, $image_height);
	imagecolorallocate($image, 255, 255, 255);
	$text_color = imagecolorallocate($image, 0, 0, 0);
	for($i = 0;$i< 30;$i++)
	{
		imageline($image, rand(1,100), rand(1,100),rand(1,100), rand(1,100), $text_color); 
	}
	$font_file = array('font0.ttf','font1.ttf','font2.ttf','font3.ttf','font4.ttf','font5.ttf','font6.ttf','font7.ttf','font8.ttf');
	$fontfile_index = rand(0,8);
	imagefttext($image, $font_size, 0, 15, 30, $text_color,$font_file[$fontfile_index], $text);
	imagejpeg($image); 
?>