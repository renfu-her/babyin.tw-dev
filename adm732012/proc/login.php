<?php 


	if(!$_SESSION['checkRepeatTime'] || ( time() - $_SESSION['checkRepeatTime']) > (24*60*60)){
		$_SESSION['checkRepeatTime'] = time();
		$_SESSION['checkRepeat'] = 0;
	}
	$_SESSION['checkRepeat'] += 1;
	if($_SESSION['checkRepeat'] >= 30 ){
		echo 'limit';
		exit;
	}


	$ary_user = $obj_admin->fetch('*' , " acc = '".$ary_post['acc']."' order by pkey DESC ");

	if(shaThis($ary_post['pwd']) == $ary_user['pwd'] ){
		$ary_DBdata['acc'] = $ary_post['acc'];
		$ary_DBdata['info'] = 'login';
		$ary_DBdata['ip_addr'] = showUserIp();
		$obj_admin_log->create($ary_DBdata);
		$_SESSION['AdminPk'] = $ary_user['pkey'];
		$_SESSION['AdminAcc'] = $ary_user['acc'];
		$_SESSION['AdminLvl'] = $ary_user['lvl'];
		$_SESSION['AdminLogin'] = true;
		header("Location:./index.php?c=40");
		exit;
	}else{

		header("Location:./login.php?mag=err");
		exit;
	}


