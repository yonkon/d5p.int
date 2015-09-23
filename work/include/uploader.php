<?
/**
* class for upload files
* @package ShiftCMS
*/

class uploader{
	var $fname='';
	var $rewrite = '';

	function SaveFile($file){
		global $_conf;
		$ch=uploader::CheckFile($file,$this->fname);
		if($ch == 1){
				$file_name = $this->fname;
				if(!@move_uploaded_file ($file['tmp_name'],$file_name)){
					return("Не удалось загрузить файл ".$file['name']);
				}else{
					$oldumask = umask(0) ;
					@chmod($file_name,0777);
					umask( $oldumask ) ;
					return(true);
				}
		}else{
			return $ch;
		}
	}

	function MoveFile($file_in,$file_out){
		global $_conf;
				if(!@copy($file_in,$file_out)){
					return("Не удалось переместить файл $file_in в $file_out");
				}else{
					if (!unlink($file_in)) {
						echo "Не удалось удалить $file_in";
					}
					$oldumask = umask(0) ;
					@chmod($file_out,0777);
					umask( $oldumask ) ;
					return(true);
				}
	}

	function CopyFile($file_in,$file_out){
		global $_conf;
				if(!@copy($file_in,$file_out)){
					return("Не удалось переместить файл $file_in в $file_out");
				}else{
					$oldumask = umask(0) ;
					@chmod($file_out,0777);
					umask( $oldumask ) ;
					return(true);
				}
	}	
	
	function CheckFile($file,$dest){	
		global $_conf;
		if(trim($file['name'])=="") return "Отсутствует загружаемый файл!";
		if($file['error']==1) return "Файл, который Вы загружаете превышает размер установленный директивой в php.ini.";
		if($file['error']==2) return("Загружаемый файл превышает размер $_conf[max_image_size]Kb!");
		if($file['error']==3) return("К сожалению загрузка была прервана! Попробуйте ещё раз!");
		if($file['error']==4) return("Не удалось загрузить файл! Попробуйте ещё раз!");
		if($this -> rewrite != 1) {if(is_file($dest)) return("Файл с именем $dest уже существует!");} 
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
	
	function MakeDir($dir){
	global $_conf;
			$oldumask = umask(0) ;
			if(@mkdir($dir, 0777)){
				umask( $oldumask );
				return true;
			}else{
				umask( $oldumask );
				return false;
			}
	}

	function DeleteFile($fname){
		global $_conf;
			if(@unlink($fname)){
				return 1;
			}else{
				return 0;
			}
	}

}
?>
