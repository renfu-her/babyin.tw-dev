<?php
require_once '../config.php';


if($_SESSION['AdminLogin'] != true || $_SESSION['AdminLvl'] != '1' ){
	header("Location:./index.php");
	exit;
}




switch($ary_get['c']){


	case '20':

		if(is_numeric($ary_get['pk'])){
			$ary_data = $obj_blog_article->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$ary_DBdata['is_show'] = ($ary_data['is_show']=='1')?'0':'1';
			$obj_blog_article->edit($ary_DBdata , " pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;



	default:
		header("Location:./index.php");
		exit;
	break;


}


















?>