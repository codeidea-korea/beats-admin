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

 	$sFileInfo = '';
	$headers = array();

	foreach($_SERVER as $k => $v) {
		if(substr($k, 0, 9) == "HTTP_FILE") {
			$k = substr(strtolower($k), 5);
			$headers[$k] = $v;
		}
	}

	$filename = rawurldecode($headers['file_name']);
	$filename_ext = strtolower(array_pop(explode('.',$filename)));
	$allow_file = array("jpg", "png", "bmp", "gif");

	if(!in_array($filename_ext, $allow_file)) {
		echo "NOTALLOW_".$filename;
	} else {
		$file = new stdClass;
		$file->name = date("YmdHis").mt_rand().".".$filename_ext;
		$file->content = file_get_contents("php://input");

		$uploadDir = '../../upload/';
		if(!is_dir($uploadDir)){
			mkdir($uploadDir, 0777);
		}

		$newPath = $uploadDir.$file->name;

        $img = imagecreatefromstring($file->content);
        $width = imagesx($img);
        $height = imagesy($img);
        if($width>1280){
            $wh = resizeWH($width,$height);
            resize_copy_b($img,$file->name,'../../upload/',$wh);

            $sFileInfo .= "&bNewLine=true";
            $sFileInfo .= "&sFileName=".$file->name;
            $sFileInfo .= "&sFileURL=upload/".$file->name;
        }else{
            if(file_put_contents($newPath, $file->content)) {
                $sFileInfo .= "&bNewLine=true";
                $sFileInfo .= "&sFileName=".$filename;
                $sFileInfo .= "&sFileURL=upload/".$file->name;
            }
        }




		echo $sFileInfo;
	}
?>
