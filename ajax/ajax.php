<?php
include($_SERVER['DOCUMENT_ROOT']."/tcom/include/database.php");

if((isset($_POST['id'])) && (isset($_POST['title'])) && (isset($_POST['author'])) && (isset($_POST['released'])) && (isset($_FILES['image'])))
{
	$status = '';	
	$exit   = 'false';
	
	$id 		= $format->fixString(@$_POST['id'], true);
	$title 		= $format->fixString(@$_POST['title'], false);	
	$author 	= $format->fixString(@$_POST['author'], false);	
	$released 	= $format->fixString(@$_POST['released'], false);	
	$check_date = $format->validateDate($released, DATE_FORMAT); 
	$released 	= $format->convertDate($released, DATE_FORMAT);
	$image		= @$_FILES['image'];
	
	if(empty($title)) 		$status = 'Enter title';
	if(empty($author)) 		$status = 'Enter author';
	if(empty($released)) 	$status = 'Enter date released';
	if(!check_date) 		$status = 'Enter valid date released';
	if(empty($image))    	$status = 'Upload image';
	
	
	 
	/* Sva polja su popunjena */
	if($status == '')
	{
		if(isset($_FILES['image']))   
		{
			if(!(($_FILES['image']['size'] == 0) && ($_FILES['image']['error'] == 4))) 
			{
				$file_ext  = strtolower(end(explode('.',$_FILES['image']['name'])));
				$file_name = IMG_PREFIX."_".strtotime(TODAY).".".$file_ext;
				$res_img   = $images->uploadImage($_FILES['image']['name'], $_FILES['image']['size'], $_FILES['image']['tmp_name'], $_FILES['image']['type'], $file_name, $file_ext);
			}
		}
		 
		if($id > 0)
		{
			/* Postoji knjiga, radi se edit */
			$res = $database->editBook($id, $title, $author, $released);			
			if($res_img) $res = $database->updateBook($id, 'picture', IMG_DIR.$file_name);	 		
		}
		else
		{
			if($res_img)
			{
				/* Ne postoji knjiga, radi se insert */
				$res = $database->addBook($title, $author, $released);			
				$id  = mysql_insert_id();
				if($res_img) $res = $database->updateBook($id, 'picture', IMG_DIR.$file_name);	
			}
	
		}
	}
	
	if(($res) && (($res_img) || ($id > 0)))   $exit = 'true'; 
	
	echo $exit;
}

if(isset($_POST['show_books']))
{
	$where = array();
	$years   = '';
	$authors = '';
	$search  = '';
	
	if((isset($_POST['years'])) && (!empty($_POST['years'])))
	{
		$years   = $format->returnValue($_POST['years'], true);
	}
	
	if((isset($_POST['authors'])) && (!empty($_POST['authors'])))
	{
		$authors = $format->returnValue($_POST['authors'], false);
	}
	
	if((isset($_POST['search'])) && (!empty($_POST['search'])))
	{
		$search  = $format->returnValue($_POST['search'], false);
	}
	 
	$where = array('released' => $years, 'author' => $authors, 'search' => $search);	
	echo $database->showBooks($where);
}

if(isset($_POST['show_authors']))
{
	$authors = $format->returnValue($_POST['show_authors'], false);
	echo $database->showAuthors($authors);
}

if(isset($_POST['show_years']))
{
	$years   = $format->returnValue($_POST['show_years'], true); 
	echo $database->showYears($years);
}

if(isset($_POST['delete_book']))
{
	$delete_book   = $format->returnValue($_POST['delete_book'], true); 
	$res = $database->deleteBook($delete_book);
	if($res) echo 'true'; else echo 'false';
}

?>