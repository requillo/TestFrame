<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Behavior
{
	public function __construct(){
		$app = App::config('app');
		$file = $app['media-protect'].'media.php';
		include_once($file);
	}
	public function upload($name,$arg = NULL){
		$msg = '';
		$empty = true;
		$_POST['data'][$name] = '';
		if(!empty($_FILES) && isset($_FILES['data']["name"][$name]) && $_FILES['data']["name"][$name] != ''){			
			if(isset($arg['ext'])) {
				$allowedExts = $arg['ext'];
			} else {
				$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "svg");
			}

			if(isset($arg['dir'])) {
				if (!file_exists(BASEPATH."media/uploads/".$arg['dir'])) {
					    mkdir(BASEPATH."media/uploads/".$arg['dir'], 0755, true);
					}
				$dir = BASEPATH."media/uploads/".$arg['dir'].'/';
				$file_dir = str_replace('/', '-', $arg['dir']);
				$file_dir = rtrim($file_dir,'-');
				$file_dir = $file_dir .'-';
			} else {
				$dir = BASEPATH."media/uploads/";
				$file_dir = '';
			}
			if(isset($arg['size'])) {
				$size = $arg['size']*1000000;
			} else {
				$size = 5000000;
			}
			
		    $temp = explode(".", $_FILES['data']["name"][$name]);

		    if($_FILES['data']["size"][$name] > $size) {
		    	$msg .= __('Size is to large') .'. '. __('Max allowed is') . ' ' . ($size/1000000).' mb'. "<br>";
		    }
		      
		    $extension = strtolower(end($temp));
		    $newfilename = $this->generateRandomString(). round(microtime(true)) . '.' . $extension;
		      if (($_FILES['data']["size"][$name] < $size)
		      && in_array($extension, $allowedExts))
		        {
		        if ($_FILES['data']["error"][$name]  > 0)
		          {
		          $msg .= "Return Code: " . $_FILES["data"]["error"][$name] . "<br>";
		          }
		        else 
		          {

		            $fileName = $temp[0].".".$temp[1];
		            $temp[0] = rand(0, 3000); //Set to random number
		            $fileName;

		          if (file_exists($dir . $newfilename))
		            {
		            $msg .= $_FILES["data"]["name"][$name] . " already exists. ";
		            }
		          else
		            {
					move_uploaded_file($_FILES["data"]["tmp_name"][$name], $dir . $newfilename);
		           
		            $_POST['data'][$name] = $file_dir . $newfilename;
		            }
		          }
		        }
		    	else
		        {
		        $msg .= "Invalid file<br>";
		        }

		}
		if($msg != '') {
			Message::flash($msg,'error');
		}
		return $_POST['data'][$name];
	}

	public function upload_ajax($name,$arg = NULL){
		$msg = '';
		$empty = true;
		$_POST['data'][$name] = '';
		if(!empty($_FILES) && isset($_FILES[$name]["name"]) && $_FILES[$name]["name"] != ''){			
			if(isset($arg['ext'])) {
				$allowedExts = $arg['ext'];
			} else {
				$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "svg");
			}

			if(isset($arg['dir'])) {
				if (!file_exists(BASEPATH."media/uploads/".$arg['dir'])) {
					    mkdir(BASEPATH."media/uploads/".$arg['dir'], 0755, true);
					}
				$dir = BASEPATH."media/uploads/".$arg['dir'].'/';
				$file_dir = str_replace('/', '-', $arg['dir']);
				$file_dir = rtrim($file_dir,'-');
				$file_dir = $file_dir .'-';
			} else {
				$dir = BASEPATH."media/uploads/";
				$file_dir = '';
			}
			if(isset($arg['size'])) {
				$size = $arg['size']*1000000;
			} else {
				$size = 5000000;
			}
			
		    $temp = explode(".", $_FILES[$name]["name"]);

		    if($_FILES[$name]["size"] > $size) {
		    	$msg .= __('Size is to large') .'. '. __('Max allowed is') . ' ' . ($size/1000000).' mb'. "<br>";
		    }
		      
		    $extension = strtolower(end($temp));
		    $newfilename = $this->generateRandomString(). round(microtime(true)) . '.' . $extension;
		      if (($_FILES[$name]["size"] < $size)
		      && in_array($extension, $allowedExts))
		        {
		        if ($_FILES[$name]["error"]  > 0)
		          {
		          $msg .= "Return Code: " . $_FILES[$name]["error"] . "<br>";
		          }
		        else 
		          {

		            $fileName = $temp[0].".".$temp[1];
		            $temp[0] = rand(0, 3000); //Set to random number
		            $fileName;

		          if (file_exists($dir . $newfilename))
		            {
		            $msg .= $_FILES[$name]["name"] . " already exists. ";
		            }
		          else
		            {
					move_uploaded_file($_FILES[$name]["tmp_name"], $dir . $newfilename);
		           
		            $_POST['data'][$name] = $file_dir . $newfilename;
		            }
		          }
		        }
		    	else
		        {
		        $msg .= "Invalid file<br>";
		        }

		}
		if($msg != '') {
			Message::flash($msg,'error');
		}
		return $_POST['data'][$name];
	}

	public function upload_protect($name,$arg = NULL){
		$msg = '';
		$empty = true;
		$_POST['data'][$name] = '';
		if(!empty($_FILES) && isset($_FILES['data']["name"][$name]) && $_FILES['data']["name"][$name] != ''){			
			if(isset($arg['ext'])) {
				$allowedExts = $arg['ext'];
			} else {
				$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "svg");
			}

			if(isset($arg['dir'])) {
				if (!file_exists(MEDIA_PATH."/media/uploads/".$arg['dir'])) {
					    mkdir(MEDIA_PATH."/media/uploads/".$arg['dir'], 0777, true);
					}
				$dir = MEDIA_PATH."/media/uploads/".$arg['dir'].'/';
				$file_dir = str_replace('/', '-', $arg['dir']);
				$file_dir = rtrim($file_dir,'-');
			} else {
				$dir = MEDIA_PATH."/media/uploads/";
				$file_dir = '';
			}
			if(isset($arg['size'])) {
				$size = $arg['size']*1000000;
			} else {
				$size = 5000000;
			}
			
		    $temp = explode(".", $_FILES['data']["name"][$name]);

		    if($_FILES['data']["size"][$name] > $size) {
		    	$msg .= __('Size is to large') .'. '. __('Max allowed is') . ' ' . ($size/1000000).' mb'. "<br>";
		    }
		      
		    $extension = strtolower(end($temp));
		    $newfilename = $this->generateRandomString(30). round(microtime(true)) . '.' . $extension;
		      if (($_FILES['data']["size"][$name] < $size)
		      && in_array($extension, $allowedExts))
		        {
		        if ($_FILES['data']["error"][$name]  > 0)
		          {
		          $msg .= "Return Code: " . $_FILES["data"]["error"][$name] . "<br>";
		          }
		        else 
		          {

		            $fileName = $temp[0].".".$temp[1];
		            $temp[0] = rand(0, 3000); //Set to random number
		            $fileName;

		          if (file_exists($dir . $newfilename))
		            {
		            $msg .= $_FILES["data"]["name"][$name] . " already exists. ";
		            }
		          else
		            {
					move_uploaded_file($_FILES["data"]["tmp_name"][$name], $dir . $newfilename);
		           
		            $_POST['data'][$name] = $file_dir.'-'.$newfilename;
		            }
		          }
		        }
		    	else
		        {
		        $msg .= "Invalid file<br>";
		        }

		}

		if($msg != '') {
			Message::flash($msg,'error');
		}
		return $_POST['data'][$name];
	}

	public function upload_protect_ajax($name,$arg = NULL){
		$msg = '';
		$empty = true;
		$_POST['data'][$name] = '';
		if(!empty($_FILES) && isset($_FILES[$name]["name"]) && $_FILES[$name]["name"] != ''){			
			if(isset($arg['ext'])) {
				$allowedExts = $arg['ext'];
			} else {
				$allowedExts = array("gif", "jpeg", "jpg", "png", "pdf", "svg");
			}

			if(isset($arg['dir'])) {
				if (!file_exists(MEDIA_PATH."/media/uploads/".$arg['dir'])) {
					    mkdir(MEDIA_PATH."/media/uploads/".$arg['dir'], 0777, true);
					}
				$dir = MEDIA_PATH."/media/uploads/".$arg['dir'].'/';
				$file_dir = str_replace('/', '-', $arg['dir']);
				$file_dir = rtrim($file_dir,'-');
			} else {
				$dir = MEDIA_PATH."/media/uploads/";
				$file_dir = '';
			}
			if(isset($arg['size'])) {
				$size = $arg['size']*1000000;
			} else {
				$size = 5000000;
			}
			
		    $temp = explode(".", $_FILES[$name]["name"]);

		    if($_FILES[$name]["size"] > $size) {
		    	$msg .= __('Size is to large') .'. '. __('Max allowed is') . ' ' . ($size/1000000).' mb'. "<br>";
		    }
		      
		    $extension = strtolower(end($temp));
		    $newfilename = $this->generateRandomString(30). round(microtime(true)) . '.' . $extension;
		      if (($_FILES[$name]["size"] < $size)
		      && in_array($extension, $allowedExts))
		        {
		        if ($_FILES[$name]["error"]  > 0)
		          {
		          $msg .= "Return Code: " . $_FILES[$name]["error"] . "<br>";
		          }
		        else 
		          {

		            $fileName = $temp[0].".".$temp[1];
		            $temp[0] = rand(0, 3000); //Set to random number
		            $fileName;

		          if (file_exists($dir . $newfilename))
		            {
		            $msg .= $_FILES[$name]["name"] . " already exists. ";
		            }
		          else
		            {
					move_uploaded_file($_FILES[$name]["tmp_name"], $dir . $newfilename);
		           
		            $_POST['data'][$name] = $file_dir.'-'.$newfilename;
		            }
		          }
		        }
		    	else
		        {
		        $msg .= "Invalid file<br>";
		        }

		}

		if($msg != '') {
			Message::flash($msg,'error');
		}
		return $_POST['data'][$name];
	}

	public function multiple_uploads($name,$arg = NULL) {
		if(!empty($_FILES)){
			print_r($_FILES);
		}
	}

	public function resize_image($file, $w, $h, $crop=FALSE){
		$file = str_replace('-', '/', $file);
		$file = rtrim($file,'/');
		$getext = explode('.', $file);
		$new_dir = $getext[0].'_'.$w.'x'.$h;
		$new_name = str_replace('/', '-', $new_dir);
		$ext =  strtolower(end($getext));
		$file1 = MEDIA_PATH."/media/uploads/".$file;
		$file2 = BASEPATH."media/uploads/".$file;
		if(file_exists($file1)) {
			$file = $file1;
			$new_file = MEDIA_PATH."/media/uploads/".$new_dir;
		} else if(file_exists($file2)) {
			$file = $file2;
			$new_file = BASEPATH."media/uploads/".$new_dir;
		}
		list($width, $height) = getimagesize($file);
	    $r = $width / $height;
	    if ($crop) {

	        if ($width > $height) {
	            $width = ceil($width-($width*abs($r-$w/$h)));
	        } else {	
	            $height = ceil($height-($height*abs($r-$w/$h)));
	        }

	        $newwidth = $w;
	        $newheight = $h;

	        $x1 = 0;
			$y1 = 0;

			$x2 = 0;
	        $y2 = 0;
			

	    } else {
	        if ($w/$h > $r) {
	            $newwidth = $h*$r;
	            $newheight = $h;
	        } else {
	            $newheight = $w/$r;
	            $newwidth = $w;
	        }

	        $x1 = 0;
			$y1 = 0;

			$x2 = 0;
			$y2 = 0;
	    }
	    if($ext == 'jpg' || $ext == 'jpeg') {
	    	$src = imagecreatefromjpeg($file);
	    } else if($ext == 'png') {
	    	$src = imagecreatefrompng($file);
	    } else if($ext == 'gif') {
	    	$src = imagecreatefromgif($file);
	    }
	    $dst = imagecreatetruecolor($newwidth, $newheight);
	    imagecopyresampled($dst, $src, $x1, $y1, $x2, $y2, $newwidth, $newheight, $width, $height);
	    imagejpeg($dst, $new_file.'.'.$ext);
	    return $new_name . '.' . $ext;
	}

	private function generateRandomString($length = 20) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP', ceil($length/strlen($x)) )),1,$length);
	}

}