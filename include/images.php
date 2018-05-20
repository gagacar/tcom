<?php

class Images
{

 	   function uploadImage($file_name, $file_size, $file_tmp, $file_type, $image_name, $file_ext)
	   {
		  if(in_array($file_type, unserialize(ALLOWED_IMG_TYPE))=== false)
		  {
			 $errors[] = "Extension not allowed";
		  }
		  
		  if($file_size > MAX_IMG_SIZE)
		  {
			 $errors[]= 'File size must be excately '.(MAX_IMAGE_SIZE/1000).' MB';
		  }
		  
		  if(empty($errors)==true)
		  {
			 $path =  DOCUMENT_ROOT."".IMG_DIR;
								
			 if (!file_exists($path)) {
				mkdir($path, 0755, true);
			 }
			 
			 move_uploaded_file($file_tmp, $path."".$image_name);
			 $this->resizeImage($image_name, $path, '', MAX_W, MAX_H, QUALITY, $file_ext);
			 
			 return true;
			 
		  }
		  else
		  {
			 print_r($errors);
			 return false;
		  }
		  
	   }
   
		function resizeImage($img, $imgPath, $suffix, $maxw, $maxh, $quality, $ext)
		{
			// Open the original image.
			if ((strtolower($ext) == 'jpg') or (strtolower($ext) == 'jpeg') or (strtolower($ext) == 'pjpeg'))
			$original = imagecreatefromjpeg("$imgPath/$img") or die("Error: (<em>$imgPath/$img</em>)");
			if  (strtolower($ext) == 'png') 
			$original = imagecreatefrompng("$imgPath/$img") or die("Error: (<em>$imgPath/$img</em>)");
			if  (strtolower($ext) == 'gif') 
			$original = imagecreatefromgif("$imgPath/$img") or die("Error: (<em>$imgPath/$img</em>)");
			 
			
			@list($width, $height) = getimagesize("$imgPath/$img");
		 
			if ($width > $maxw) {
				$ratio = ($width / $maxw);
				$newWidth = (int)($width / $ratio);
				$newHeight = (int)($height / $ratio);
			}
			if ($height > $maxh) {
				$ratio = ($height / $maxh);
				$newWidth = (int)($width / $ratio);
				$newHeight = (int)($height / $ratio);
			}
						
			if (($newWidth == '') or ($newWidth == 0)) $newWidth = $width;
			if (($newHeight == '') or ($newHeight == 0)) $newHeight = $height;
			
			if (($newWidth == '') or ($newWidth == 0)) $newWidth = $maxw;
			if (($newHeight == '') or ($newHeight == 0)) $newHeight = $maxh;
		 
			// Resample the image.
			$tempImg =  imagecreatetruecolor($newWidth, $newHeight) or die("Error 1!");
			
			if  (strtolower($ext) == 'png')  {
				imagealphablending($tempImg, false);
				imagesavealpha($tempImg,true);
				$transparent = imagecolorallocatealpha($tempImg, 255, 255, 255, 127);
				imagefilledrectangle($tempImg, 0, 0, $newWidth, $newHeight, $transparent);
			}
			
			imagecopyresampled($tempImg, $original, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height) or die("Error 2!");
		 
			// Create the new file name.
			$newNameE = explode(".", $img);
			$newName = ''. $newNameE[0] .''. $suffix .'.'. $newNameE[1] .'';
		 
			// Save the image.
			if ((strtolower($ext) == 'jpg') or (strtolower($ext) == 'jpeg'))
			imagejpeg($tempImg, "$imgPath/$newName", $quality) or die("Error 3!");
			if  (strtolower($ext) == 'png') 
			{
			imagepng($tempImg, "$imgPath/$newName", floor($quality/10)) or die("Error 4!");
			 
			}
			if  (strtolower($ext) == 'gif')
			imagegif($tempImg, "$imgPath/$newName", $quality) or die("Error 5!"); 
			 
		 
			// Clean up.
			imagedestroy($original);
			imagedestroy($tempImg);
			return true;
		}

};


$images = new Images;

?>