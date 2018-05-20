<?php
class Format
{

	function validateDate($date, $format = DATE_FORMAT)
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	function fixString($str, $bool)
	{
		$str = mysql_escape_string($str);
		$str = strip_tags($str);
		$str = htmlspecialchars($str);
		if($bool) $str = (int)$str;
		return $str;
	}
	
	function convertDate($date, $format)
	{
		return date($format, strtotime($date));
	}
	
	function returnValue($str, $bool)
	{
		$exit = '';
		
		if(!empty($str)) 
		{
			$exit  = $this->fixString($str, $bool);
		}
		
		return $exit;
	}

};


$format = new Format;


?>