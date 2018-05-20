<?php
	include($_SERVER['DOCUMENT_ROOT']."/tcom/include/database.php");

	if(isset($_GET['id_book']))  {
	
	  $id_book = $format->returnValue($_GET['id_book'], true); 
	  
	  $sql  = "SELECT * FROM ".TBL_BOOKS." WHERE id = '$id_book' ";	
	  $res  = mysql_query($sql);
	  
	  	if($res)
	  	{
	  
			while($row = mysql_fetch_array($res))
			{
		
				 $id       = $row['id'];
				 $title    = $row['title'];
				 $author   = $row['author'];
				 $released = $row['released'];
				 
				 $released = $format->convertDate($released, DATE_FORMAT_SHOW);
				 
				 $json = array(
							 array('field' => 'id',         'value'  => $id), 
							 array('field' => 'title',      'value'  => $title), 
							 array('field' => 'author',     'value'  => $author), 
							 array('field' => 'released',   'value'  => $released)  
					  );
		
			}
			
			echo json_encode($json );			
			mysql_free_result($res);
			
		}
	
	}

?>