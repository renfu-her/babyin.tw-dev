<?php

require_once libs.'PHPExcel.php';
ini_set('memory_limit', '1024M');





if(file_exists('proc/backend/o'.$ary_get['c'].'.php')){
	require 'proc/backend/o'.$ary_get['c'].'.php';
}








