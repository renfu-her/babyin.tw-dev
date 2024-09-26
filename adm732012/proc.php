<?php
require_once '../config.php';

if($ary_get['proc'] == 'login'){
	require 'proc/login.php';
	exit;
}


if($_SESSION['AdminLogin'] != true){			//登入檢查
	header("Location:./index.php");
	exit;
}


if($ary_get['proc'] == 'ckeditorUpload'){

	$img = pic_upload_proc($_FILES['upload']['name'],$_FILES['upload']['tmp_name'],0,0);

	$CKEditorFuncNum = isset($_GET['CKEditorFuncNum']) ? $_GET['CKEditorFuncNum'] : 2;
	$fileUrl = $ary_config['ckeditorUploadUrl'].$img;
	echo "<script>window.parent.CKEDITOR.tools.callFunction(". $CKEditorFuncNum .",'" . $fileUrl . "','');</script>";

	exit;
}



if(file_exists('proc/'.$ary_get['proc'].'.php')){
	require 'proc/'.$ary_get['proc'].'.php';
	exit;
}




if($ary_post['self_post'] == 33){

	if(file_exists('proc/backend/s'.$ary_post['c'].'.php') && $ary_post['sort'] == '1'){
		require 'proc/backend/s'.$ary_post['c'].'.php';
	}else if(file_exists('proc/backend/'.$ary_post['c'].'.php')){
		require 'proc/backend/'.$ary_post['c'].'.php';
	}

	exit;
		
}





// $ary_procAction[] = 'download';
// $ary_procAction[] = 'delFile';
// foreach($ary_procAction as $value){
// 	if($ary_get['proc'] == $value){
// 		require 'proc/'.$value.'.php';
// 		exit;
// 	}
// }






?>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="js/vendors/jquery/dist/jquery.min.js"></script>
	<script src="js/vendors/moment/min/moment.min.js"></script>
	<script src="js/vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	<script src="js/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>


	<link href="js/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Font Awesome -->
	<link href="js/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<!-- NProgress -->
	<link href="js/vendors/nprogress/nprogress.css" rel="stylesheet">
	<!-- iCheck -->
	<link href="js/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	<!-- bootstrap-wysiwyg -->
	<link href="js/vendors/google-code-prettify/prettify.min.css" rel="stylesheet">
	<!-- Select2 -->
	<link href="js/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	<!-- Switchery -->
	<link href="js/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	<!-- starrr -->
	<link href="js/vendors/starrr/dist/starrr.css" rel="stylesheet">
	<!-- bootstrap-daterangepicker -->


	<link href="js/vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	<link href="js/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">


	<!-- Custom Theme Style -->
	<link href="js/build/css/custom.css" rel="stylesheet">

	<script>
		Number.prototype.numberFormat = function(c, d, t){
			var n = this, 
			c = isNaN(c = Math.abs(c)) ? 2 : c, 
			d = d == undefined ? "." : d, 
			t = t == undefined ? "," : t, 
			s = n < 0 ? "-" : "", 
			i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))), 
			j = (j = i.length) > 3 ? j % 3 : 0;
			return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
		};
	</script>

	<style>
		body{
			background: #ffffff;
			padding-top: 30px; 
		}
		.bootstrap-datetimepicker-widget td.day {
			font-size: 10px;
		}
		th.dow {
			font-size: 12px;
		}

	</style>

<?php



if(file_exists('proc/frontend/s'.$ary_get['c'].'.php') && $ary_get['sort'] == '1'){
	require 'proc/frontend/s'.$ary_get['c'].'.php';
}else if(file_exists('proc/frontend/'.$ary_get['c'].'.php')){
	require 'proc/frontend/'.$ary_get['c'].'.php';
}








?>