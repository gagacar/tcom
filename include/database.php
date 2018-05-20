<?php

include("constants.php");
include("format.php");
include("images.php");
      
class MySQLDB
{
   
   var $connection; 
   
   function MySQLDB(){

      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS) or die(mysql_error());
      mysql_select_db(DB_NAME, $this->connection) or die(mysql_error());
      
   }  
   
   function addBook($title, $author, $released)
   {
   		$sql = "INSERT INTO ".TBL_BOOKS." (title, author, released) VALUES ('$title', '$author', '$released') ";
		$res = mysql_query($sql);
		if($res) return true;
		else return false;
   }
   
   function editBook($id, $title, $author, $released)
   {
   		$sql = "UPDATE ".TBL_BOOKS." SET title = '$title', author = '$author', released = '$released' WHERE id = '$id'";
		$res = mysql_query($sql);
		if($res) return true;
		else return false;
   }
   
   function updateBook($id, $column, $value)
   {
		$sql = "UPDATE ".TBL_BOOKS." SET ".$column." = '$value' WHERE id = '$id'";
		$res = mysql_query($sql);
		if($res) return true;
		else return false;
   }
   
   function deleteBook($id)
   {
   	    $sql = "DELETE FROM ".TBL_BOOKS." WHERE id = '$id'";
		$res = mysql_query($sql);
		if($res) return true;
		else return false;
   }
    
   function showBooks($str)
   {
   		global $format;
		
		$exit  = '';
		$where = '';
		$j = 0; 
		
		if(!empty($str))
		{
			$where = ' WHERE (1=1) ';
			
			foreach ($str as $k => $v)
			{
				if($k == 'search')
				{
					$where .= $this->fixWhere($v); 
				}
				if($k == 'released')
				{
					if(($v > 0) && ($v <> '')) $where .= " AND (YEAR($k) = '".$v."') ";			
				}
				if($k == 'author')
				{
					if($v <> '') $where .= " AND ($k = '".$v."') ";			
				}
				
			}
		}
		 
		
		$sql  = "SELECT * FROM ".TBL_BOOKS." ".$where." ORDER BY id DESC ";
		$res  = mysql_query($sql);
		
			if($res)
			{
				while($row = mysql_fetch_array($res))
				{
					$j++;
					$id 		= $row['id'];	
					$title 		= $row['title'];	
					$author 	= $row['author'];	
					$picture 	= $row['picture'];	
					$released 	= $row['released'];	
					
					$released   = $format->convertDate($released, DATE_FORMAT_SHOW);
					
					$img 		=  DOCUMENT_ROOT."".$picture;
					
					if((file_exists($img)) && (!empty($picture)))
					{
					
						$size = @getimagesize ($img);									 
						// 0 - width, 1 - height
						if ($size[0] > IMG_W) {
							$ratio = ($size[0] / IMG_W);
							$size[0] = (int)($size[0] / $ratio);
							$size[1] = (int)($size[1] / $ratio);
						}
						if ($size[1] > IMG_H) {
							$ratio = ($size[1] / IMG_H);
							$size[0] = (int)($size[0] / $ratio);
							$size[1] = (int)($size[1] / $ratio);
						}
					
					
						$img_show = '<img src="'.$picture.'" alt="'.$title.'" width="'.$size[0].'" height="'.$size[1].'" />';
					
					}
					else
					{
						$img_show = '<img src="'.IMG_DEF.'" alt="'.$title.'" width="'.IMG_W.'" height="'.IMG_H.'" />';
					}
				
					
					$exit .= '<article id="article_'.$id.'">
								<div class="knjiga_slika" id="knjiga_slika_'.$id.'">
								'.$img_show.'
								</div>
								<div class="knjiga_opis" id="knjiga_opis_'.$id.'">
									<p>Title: '.$title.'</p>
									<p>Author: '.$author.'</p>
									<p>Released: '.$released.'</p>
									<form method="post" id="form_'.$id.'">
										<input type="button" name="edit"   id="edit_'.$id.'"   class="dugme dugme_promeni" value="Edit" />
										<input type="button" name="delete" id="delete_'.$id.'" class="dugme dugme_obrisi"  value="Delete" />
									</form>
								</div>
							 </article>';
					if($j % 2 == 0) $exit .= '<div class="prelom"></div>';
					$img_show = '';
				}
			
			$exit .= '<div class="prelom"></div>';
			}
			
			echo $exit;
   
   }
   
   function showAuthors($str)
   {
   		$exit = '<option value=""> --- </option>';
		
		$sql = "SELECT DISTINCT author FROM ".TBL_BOOKS." ORDER BY author ";
		$res  = mysql_query($sql);
		
			if($res)
			{
				while($row = mysql_fetch_array($res))
				{
					$author  = $row['author'];
					if($str == $author) $selected = ' selected ';
					else $selected = '';
					$exit   .= '<option value="'.$author.'" '.$selected.'>'.$author.'</option>';				
				}
			}
			
		echo $exit;
   }
   
   function showYears($str)
   {
   		$exit = '<option value=""> --- </option>';
		
		$sql = "SELECT DISTINCT YEAR(released) AS year FROM ".TBL_BOOKS." ORDER BY YEAR(released) DESC ";
		$res  = mysql_query($sql);
		
			if($res)
			{
				while($row = mysql_fetch_array($res))
				{
					$year  = $row['year'];
					if($str == $year) $selected = ' selected ';
					else $selected = '';
					$exit   .= '<option value="'.$year.'" '.$selected.'>'.$year.'</option>';				
				}
			}
			
		echo $exit;
   }   
   
   function fixWhere($str)
   {
  	    $where = '';
		
		$words = explode(" ", $str);
		$max_words = min(sizeof($words), 5);
	
		for ($i = 0; $i < $max_words; $i++) {
			$words[$i] = trim($words[$i]);
			if($words[$i] <> '') $where .= " AND ((title LIKE '%".$words[$i]."%') OR (author LIKE '%".$words[$i]."%') OR (YEAR(released) = '".$words[$i]."')) ";    
		}	
		
		return $where;
   }
  
     
};


$database = new MySQLDB;

?>