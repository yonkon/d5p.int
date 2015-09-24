<?php
/**
 * Класс для загрузки файлов на сервер и манипуляции с этими файлами
 * ShiftCMS - Content Management System
 * @package ShiftCMS
 * @author Volodymyr Demchuk
 * @copyright 2005-2009 
 * @link http://shiftcms.net
 * @version 1.00
 */


class uploader{
	var $fname='';
	var $rewrite = '';

	public function SaveFile($file){
		global $_conf;
		$ch=uploader::CheckFile($file,$this->fname);
		if($ch == 1){
			if($_conf['upload_type'] =="ftp"){
				$file_name=$_conf['doc_root'].$this->fname;
				$conn_id = ftp_connect($_conf['ftp_host']);
				if (!@ftp_login($conn_id, $_conf['ftp_login'], $_conf['ftp_password'])) {
				    return("Не удалось войти под именем $_conf[ftp_login]");
				}else{
					if (ftp_put($conn_id, $file_name, $file['tmp_name'], FTP_BINARY)) {
						ftp_chmod($conn_id, 0777, $file_name);
						return(true);
					} else {
						return("Не удалось загрузить файл $file[name]");
					}
					ftp_quit($conn_id);
				}
			}
			if($_conf['upload_type'] =="http"){
				$file_name=$_SERVER['DOCUMENT_ROOT']."/".$this->fname;
//		$file_name="/".$_conf['doc_root'].$this->fname;
//				$file_name = "/".$this->fname;
				if(!@move_uploaded_file ($file['tmp_name'],$file_name)){
					return("Не удалось загрузить файл ".$file['name']);
				}else{
					$oldumask = umask(0) ;
					@chmod($file_name,0777);
					umask( $oldumask ) ;
					return(true);
				}
			}
		}else{
			return $ch;
		}
	}

	public function MoveFile($file_in,$file_out){
		global $_conf;
			if($_conf['upload_type'] =="ftp"){
				$file_out=$_conf['doc_root'].$file_out;
				$file_in=$_conf['doc_root'].$file_in;
				$conn_id = ftp_connect($_conf['ftp_host']);
				if (!@ftp_login($conn_id, $_conf['ftp_login'], $_conf['ftp_password'])) {
				    return("Не удалось войти под именем $_conf[ftp_login]");
				}else{
//					if (ftp_put($conn_id, $file_out, $file_in, FTP_BINARY)) {
					if (ftp_rename($conn_id, $file_in, $file_out)) {
						ftp_chmod($conn_id, 0777, $file_out);
						return(true);
						// попытка удалить файл
						if (!ftp_delete($conn_id, $file_in)) {
							echo "Не удалось удалить $file_in";
						}
					} else {
						return("Не удалось переместить файл $file_in в $file_out");
					}
					ftp_quit($conn_id);
				}
			}
			if($_conf['upload_type'] =="http"){
				$file_out=$_SERVER['DOCUMENT_ROOT']."/".$file_out;
				//$file_in=$_SERVER['DOCUMENT_ROOT']."/".$file_in;
//		$file_name=$_conf['doc_root']."/".$this->fname;
//				$file_name="./".$this->fname;
				if(!@move_uploaded_file ($file_in,$file_out)){
					return("Не удалось переместить файл $file_in в $file_out");
				}else{
					// попытка удалить файл
					if (!@unlink($file_in)) {
						echo "Не удалось удалить $file_in";
					}
					$oldumask = umask(0) ;
					@chmod($file_out,0777);
					umask( $oldumask ) ;
					return(true);
				}
			}
	}
	
	public function CheckFile($file,$dest){	
		global $_conf;
		$mm=$_conf['max_image_size']*1000;
		if(trim($file['name'])=="") return "Отсутствует загружаемый файл!";
		if($file['error']==1) return "Файл, который Вы загружаете превышает размер установленный директивой в php.ini.";
		if($file['size']>$mm) return("Размер загружаемого файла не должен превышает $_conf[max_image_size]Kb!");
		if($file['error']==2) return("Загружаемый файл превышает размер $_conf[max_image_size]Kb!");
		if($file['error']==3) return("К сожалению загрузка была прервана! Попробуйте ещё раз!");
		if($file['error']==4) return("Не удалось загрузить файл! Попробуйте ещё раз!");
		if($file['error']==6) return("Отсутствует папка хранения временных файлов на вашем сервере. В таком случае обратитесь к вашему хостинг-провайдеру либо создайте её вручную. Путь к вашей папке хранения временных файлов должен прописываться в php.ini.");
		if($file['error']==7) return("Ошибка при записи файла на диск во временную папку!");
		if($file['error']==8) return("Загрузка файла прервана, поскольку файлы с таким расширением запрещено заливать на сервер настройками php.ini.");
		if($this -> rewrite != 1) {if(is_file($dest)) return("Файл с именем $dest уже существует!");} 
		return(true);
	}
	
	public function ConvertFileArray($fieldname){
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
	
	public function MakeDir($dir){
	global $_conf;
		if($_conf['upload_type'] =="ftp"){
			$conn_id = ftp_connect($_conf['ftp_host']);
			$login_result = ftp_login($conn_id, $_conf['ftp_login'], $_conf['ftp_password']);
			if (ftp_mkdir($conn_id, $_conf['doc_root'].$dir)) {
				ftp_chmod($conn_id, 0777, $_conf['doc_root'].$dir);
				return true;
			} else {
				return false;
			}
			ftp_quit($conn_id);
		}
		if($_conf['upload_type'] =="http"){
			$oldumask = umask(0) ;
			if(@mkdir($dir, 0777)){
				umask( $oldumask );
				return true;
			}else{
				umask( $oldumask );
				return false;
			}
		}
	}

	public function DeleteFile($fname){
		global $_conf;
		if($_conf['upload_type'] =="ftp"){
			$conn_id = ftp_connect($_conf['ftp_host']);
			$login_result = ftp_login($conn_id, $_conf['ftp_login'], $_conf['ftp_password']);
			if (ftp_delete($conn_id, $_conf['doc_root'].$fname)) {
				$res=1;
			} else {
				$res=0;
			}
			ftp_quit($conn_id);
			return $res;
		}
		if($_conf['upload_type'] =="http"){
			if(@unlink($fname)){
				return 1;
			}else{
				return 0;
			}
		}
	}

}
?>
