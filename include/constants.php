<?php

include("db_config.php");

define("TBL_BOOKS", "tbl_books");
define("DATE_FORMAT", 'Y-m-d');
define("DATE_FORMAT_SHOW", 'd.m.Y');
define("TODAY", date("Y-m-d H:i:s"));
define("YEAR", date("Y"));
define("DOCUMENT_ROOT", $_SERVER['DOCUMENT_ROOT']);

define("ALLOWED_IMG_TYPE", serialize (array ("image/jpg", "image/jpeg")));
define("MAX_IMG_SIZE", "5000000");
define("IMG_DIR", "/tcom/images/");
define("IMG_PREFIX", "pic");
define("IMG_DEF", "/tcom/img/knjiga.jpg");
define("IMG_W", "200");
define("IMG_H", "200");
define("MAX_W", "500");
define("MAX_H", "500");
define("QUALITY", "80");
define("FORM_H", "420");
define("FORM_W", "420");
?>