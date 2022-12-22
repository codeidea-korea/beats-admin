<?php
    function resizeWH($w, $h)
    {
        $percent = 0.8;
        $cnt = 0;
        while ($w > 740) {
            $w = $w * $percent;
            $h = $h * $percent;
            $cnt++;
            if ($cnt > 100) {
                break;
            }
        }
        return array($w, $h);
    }

    function resize_copy_b($img, $get_FILENAME, $pdsDIR, $wh)
    {

        $ext = explode('.', $get_FILENAME);
        $width = imagesx($img);
        $height = imagesy($img);

        $new_width = $wh[0];
        $new_height = $wh[1];

        $image_p = imagecreatetruecolor($new_width, $new_height);
        imagecopyresampled($image_p, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

        if ($ext[count($ext) - 1] == "jpg" || $ext[count($ext) - 1] == "jpeg") {
            imagejpeg($image_p, $pdsDIR . $get_FILENAME, 100);
        } else if ($ext[count($ext) - 1] == "png") {
            imagepng($image_p, $pdsDIR . $get_FILENAME, 100);
        } else if ($ext[count($ext) - 1] == "gif") {
            imagegif($image_p, $pdsDIR . $get_FILENAME, 100);
        }
    }

// default redirection
$url = 'callback.html?callback_func='.$_REQUEST["callback_func"];
$bSuccessUpload = is_uploaded_file($_FILES['Filedata']['tmp_name']);


// SUCCESSFUL
if(bSuccessUpload) {
	$tmp_name = $_FILES['Filedata']['tmp_name'];
	$name = $_FILES['Filedata']['name'];

	$filename_ext = strtolower(array_pop(explode('.',$name)));
	$allow_file = array("jpg", "png", "bmp", "gif");

	if(!in_array($filename_ext, $allow_file)) {
		$url .= '&errstr='.$name;
	} else {
		$uploadDir = '../../upload/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}

		$newPath = $uploadDir.urlencode($_FILES['Filedata']['name']);

		@move_uploaded_file($tmp_name, $newPath);

		$url .= "&bNewLine=true";
		$url .= "&sFileName=".urlencode(urlencode($name));
		$url .= "&sFileURL=upload/".urlencode(urlencode($name));

	}
}
// FAILED
else {
	$url .= '&errstr=error';
}

header('Location: '. $url);
?>
