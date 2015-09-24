<?
/**
 * Класс для работы с изображениями
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00.04	26.07.2012
 */


class imager{
	var $width=array();
	var $height=array();
	var $fname=array();
	var $sign=array();
	var $signtype=array();
	var $crop=array();
	var $whatcrop=array();
	var $desttype=array();
	var $resizetype = '';

	function getExistsImage($existfile){
		$pp = pathinfo($existfile);
		list($width, $height, $type, $attr) = @getimagesize($existfile);
		$file = array(
            'name' => $pp['basename'],
            'type' => image_type_to_mime_type($type),
            'tmp_name' => $existfile,
            'error' => 0,
            'size' => filesize($existfile)
		);
		return $file;
	}
	
	function ResizeImage($file){
		global $_conf;
		$ch=imager::CheckImage($file);
		if($ch == 1){
			$current_file = $file['tmp_name'];
			for($i=0;$i<count($this->width);$i++){
				$max_width = $this->width[$i];
				$max_height = $this->height[$i];
				$dest_name = $this->fname[$i];
				$crop_flag = $this->crop[$i];
				$whatcrop = $this->whatcrop[$i];
				$desttype = $this->desttype[$i];
				$sign = $this->sign[$i];
				$signtype = $this->signtype[$i];
				$resizetype = $this->resizetype;
				if(file_exists($current_file)) $current_size = getimagesize($current_file);
				else return "Ошибка! Отсутствует загружаемый файл!";
				$current_img_width = $current_size[0];
				$current_img_height = $current_size[1];
				$thumb_name = $_SERVER['DOCUMENT_ROOT']."/".$dest_name;
				if($desttype=="thumb"){
					if($resizetype == "fix_h"){//высота как указано в конфиге,а ширина пропорционально
						if($current_img_height > $max_height){
						    $too_big_diff_ratio = $current_img_height/$max_height;
				    		$new_img_width = round($current_img_width/$too_big_diff_ratio);
						    $new_img_height = $max_height;
							$resize="yes";
						}else{
				    		$new_img_width = $current_img_width;
						    $new_img_height = $current_img_height;
							$resize="no";
						}
					}else if($resizetype == "fix_w"){//ширина как в конфиге, а высота пропорционально
						if($current_img_width > $max_width){
						    $too_big_diff_ratio = $current_img_width/$max_width;
				    		$new_img_height = round($current_img_height/$too_big_diff_ratio);
						    $new_img_width = $max_width;
							$resize="yes";
						}else{
				    		$new_img_width = $current_img_width;
						    $new_img_height = $current_img_height;
							$resize="no";
						}
					}else{//вписываем рисунок в прямоугольник указанный в конфиге
						if ($current_img_width > $max_width && $max_width!=0){
						    $too_big_diff_ratio = $current_img_width/$max_width;
				    		$new_img_width = $max_width;
						    $new_img_height = round($current_img_height/$too_big_diff_ratio);
							$resize="yes";
						}
						if(isset($new_img_height) && ($new_img_height > $max_height) && $crop_flag!="yes"){
						    $too_big_diff_ratio = $current_img_height/$max_height;
				    		$new_img_width = round($current_img_width/$too_big_diff_ratio);
						    $new_img_height = $max_height;
							$resize="yes";
						}
						if(!isset($resize)){
				    		$new_img_width = $current_img_width;
						    $new_img_height = $current_img_height;
							$resize="no";
						}
					}
				}
				if($desttype=="photo"){
					if (($current_img_width >= $current_img_height && $current_img_width > $max_width && $max_width!=0)){
					    $too_big_diff_ratio = $current_img_width/$max_width;
			    		$new_img_width = $max_width;
					    $new_img_height = round($current_img_height/$too_big_diff_ratio);
						$resize="yes";
					}else if(($current_img_width <= $current_img_height && $current_img_height > $max_height && $max_height!=0)){
					    $too_big_diff_ratio = $current_img_height/$max_height;
			    		$new_img_width = round($current_img_width/$too_big_diff_ratio);
					    $new_img_height = $max_height;
						$resize="yes";
					}else{
			    		$new_img_width = $current_img_width;
					    $new_img_height = $current_img_height;
						$resize="no";
					}
				}
				if($desttype=="original"){
					$resize="no";
				}
				
				if($resize=="yes"){
					$retval = 0;
						$im1 = imagecreatetruecolor($new_img_width, $new_img_height) or die("Cannot Initialize new GD image stream $GD");
						imageAlphaBlending($im1, false);
						imageSaveAlpha($im1, true);
						if($current_size[2]==2) $img = imagecreatefromjpeg($file['tmp_name']);
						if($current_size[2]==1) $img = imagecreatefromgif($file['tmp_name']);
						if($current_size[2]==3) $img = imagecreatefrompng($file['tmp_name']);
						imagecopyresampled($im1,$img,0,0,0,0,$new_img_width, $new_img_height, $current_img_width, $current_img_height);
						if($current_size[2]==2) imagejpeg($im1,$thumb_name,100);
						if($current_size[2]==1) imagegif($im1,$thumb_name);
						if($current_size[2]==3) imagepng($im1,$thumb_name);
						imagedestroy($im1);
//					}
				}else{
					if(!copy($current_file,$thumb_name)) {
					    return("Не удалось сохранить файл!");
					}
				}
				if($crop_flag == "yes") imager::CropImage($thumb_name, $max_width, $max_height, $whatcrop);
				
				/* Если необходимо подписать рисунок или нанести поверх изображение */
				if($sign!='' && $desttype!="original"){
	    			list($width, $height, $type, $attr) = getimagesize($thumb_name);
					if($current_size[2]==2) $img = imagecreatefromjpeg($thumb_name);
					if($current_size[2]==1) $img = imagecreatefromgif($thumb_name);
					if($current_size[2]==3) $img = imagecreatefrompng($thumb_name);
					/* если пишем текст */
					if($signtype == "txt"){
						$black = imagecolorallocate($img, 234, 78, 0);
						$font = $_SERVER['DOCUMENT_ROOT'].'/arial.ttf';
						imagefttext($img, 16, -14, 1, 15, $black, $font, $sign);
					}
					/* если накладываем рисунок */
					if($signtype == "img"){
						$cs = getimagesize($sign);
						if($cs[2]==2) $img_s = imagecreatefromjpeg($sign);
						if($cs[2]==1) $img_s = imagecreatefromgif($sign);
						if($cs[2]==3) $img_s = imagecreatefrompng($sign);
						imagecopy($img, $img_s , 0, 0, 0, 0, $cs[0], $cs[1]);
					}
					if($current_size[2]==2) imagejpeg($img,$thumb_name,100);
					if($current_size[2]==1) imagegif($img,$thumb_name);
					if($current_size[2]==3) imagepng($img,$thumb_name);
					imagedestroy($img);
				}
			} // end for cycle
			return(true);
		}else{
			return $ch;
		}
	}
	
	function CheckImage($file){	
		global $_conf;
		$mm=$_conf['max_image_size']*1024;
		if(trim($file['name'])=="") return "Ошибка! Отсутствует загружаемый файл!";
		if($file['error']==1) return "Файл, который Вы загружаете превышает определенный размер установленный директивой в php.ini.";
		if($file['size']>$mm) return("Размер загружаемого файла не должен превышает $_conf[max_image_size]Kb!");
		if($file['error']==2) return("Загружаемый файл превышает размер $_conf[max_image_size]Kb!");
		if($file['error']==3) return("К сожалению загрузка была прервана! Попробуйте ещё раз!");
		if($file['error']==4) return("Не удалось загрузить файл! Попробуйте ещё раз!");
		if($file['error']==6) return("Отсутствует папка хранения временных файлов на вашем сервере. В таком случае обратитесь к вашему хостинг-провайдеру либо создайте её вручную. Путь к вашей папке хранения временных файлов должен прописываться в php.ini.");
		if($file['error']==7) return("Ошибка при записи файла на диск во временную папку!");
		if($file['error']==8) return("Загрузка файла прервана, поскольку файлы с таким расширением запрещено заливать на сервер настройками php.ini.");
		list($width, $height, $type, $attr) = @getimagesize($file['tmp_name']);
		if(($type>3 && $type<0) || $type=="" || !isset($type)) return("Ошибка! Вы можете загрузить фотографии только в форматах .jpg, .gif  и .png!");
		return(true);
	}
	
	function ConvertFileArray($fieldname){
		$file=array();
		while(list($key,$val)=each($_FILES[$fieldname]['name'])){
			$file[$key]=array('name'=>$_FILES[$fieldname]['name'][$key],
				'type'=>$_FILES[$fieldname]['type'][$key],
				'tmp_name'=>$_FILES[$fieldname]['tmp_name'][$key],
				'error'=>$_FILES[$fieldname]['error'][$key],
				'size'=>$_FILES[$fieldname]['size'][$key]
			);	
		}
		return $file;
	}
	
	function CropImage($file, $img_sw, $img_sh, $whatcrop){
		if(file_exists($file)) $cs = getimagesize($file);
		else return(false);
		list($imagewidth, $imageheight, $imageType) = getimagesize($file);
		$imageType = image_type_to_mime_type($imageType);
		$img_w = $cs[0];
		$img_h = $cs[1];
		if($img_h > $img_sh){
			$h_diff = (int)($img_h - $img_sh)/2;
			if($imageType=="image/pjpeg" || $imageType=="image/jpeg" || $imageType=="image/jpg") $img = imagecreatefromjpeg($file);
			if($imageType=="image/gif") $img = imagecreatefromgif($file['tmp_name']);
			if($imageType=="image/png" || $imageType=="image/x-png") $img = imagecreatefrompng($file);
			$img1 = @imagecreatetruecolor($img_sw, $img_sh) or die("Cannot Initialize new GD image stream $GD");
			imageAlphaBlending($img1, false);
			imageSaveAlpha($img1, true);

			if($whatcrop=="center") imagecopy($img1, $img, 0, 0, 0, $h_diff, $img_sw, $img_sh);
			if($whatcrop=="bottom") imagecopy($img1, $img, 0, 0, 0, 0, $img_sw, $img_sh);
			if($whatcrop=="top") imagecopy($img1, $img, 0, 0, 0, $h_diff*2, $img_sw, $img_sh);
			if($imageType=="image/pjpeg" || $imageType=="image/jpeg" || $imageType=="image/jpg") imagejpeg($img1,$file,100);
			if($imageType=="image/gif") imagegif($img1,$file);
			if($imageType=="image/png" || $imageType=="image/x-png") imagepng($img1,$file);
			imagedestroy($img1);
			return(true);
		}
		if($img_w > $img_sw){
			$h_diff = (int)($img_w - $img_sw)/2;
			if($imageType=="image/pjpeg" || $imageType=="image/jpeg" || $imageType=="image/jpg") $img = imagecreatefromjpeg($file);
			if($imageType=="image/gif") $img = imagecreatefromgif($file);
			if($imageType=="image/png" || $imageType=="image/x-png") $img = imagecreatefrompng($file);
			$img1 = @imagecreatetruecolor($img_sw, $img_sh) or die("Cannot Initialize new GD image stream $GD");
			imageAlphaBlending($img1, false);
			imageSaveAlpha($img1, true);
			if($whatcrop=="center") imagecopy($img1, $img, 0, 0, $h_diff, 0, $img_sw, $img_sh);
			if($whatcrop=="bottom") imagecopy($img1, $img, 0, 0, 0, 0, $img_sw, $img_sh);
			if($whatcrop=="top") imagecopy($img1, $img, 0, 0, $h_diff*2, 0, $img_sw, $img_sh);
			if($imageType=="image/pjpeg" || $imageType=="image/jpeg" || $imageType=="image/jpg") imagejpeg($img1,$file,100);
			if($imageType=="image/gif") imagegif($img1,$file);
			if($imageType=="image/png" || $imageType=="image/x-png") imagepng($img1,$file);
			imagedestroy($img1);
			return(true);
		}
		return(false);
	}


function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,90); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break;
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}

}
/*
$img = new imager;

$farr=$img->ConvertFileArray($fieldname);

while(list($key,$val)=each($farr)){
	$width=array('99','250','0');
	$name=array("photo/newsanons/1_a.jpg","photo/newsanons/1_b.jpg","photo/newsanons/1.jpg");
	$img->width=$width;
	$img->fname=$name;
	$res=$img->ResizeImage($val);
	if($res == 1){
		echo "OK";
	}else{
		echo $res."<br />";
	}
*/
?>
