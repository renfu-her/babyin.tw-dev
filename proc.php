<?php
require_once 'config.php';

if ($ary_get['proc'] == 'contact') {

	// if(strtolower($ary_post['captcha']) != strtolower($_SESSION['captcha']['code'])){
	// 	echo 'captcha';
	// 	exit;
	// }
	$ary_DBdata = array(
		'uname' => $ary_post['uname'],
		'tel' => $ary_post['tel'],
		'email' => $ary_post['email'],
		'info' => safe(nl2br($_POST['info'])),
		'ip_addr' => showUserIp()
	);
	if ($obj_contact->create($ary_DBdata)) {


		$mailBody = '
		姓名：' . $ary_post['uname'] . '<br>
		電話：' . $ary_post['tel'] . '<br>
		email：' . $ary_post['email'] . '<br>
		填寫日期：' . date('Y-m-d H:i:s') . '<br>
		內容：' . nl2br($_POST['info']) . '<br>
		';

		// send_mail('babyin印鑑工坊 - 與我聯絡 ',$mailBody,$ary_config['adminEmail']);

		$send_email_array = explode(",", $ary_config['adminEmail']); //根据逗号分割存入数组
		foreach ($send_email_array as $recipient) {
			$recipient = trim($recipient); // 移除可能的空格
			if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
				// $mail->addAddress($recipient);
				$emails[] = $recipient;
			}
		}

		// $emails[] = 'renfu.her@gmail.com';

		$postData = [
			'from_email' => 'bloomami2022@gmail.com',
			'from_name' => 'babyin印鑑工坊',
			'emails' => $emails,
			'message' => $mailBody,
			'subject' => 'babyin印鑑工坊 - 與我聯絡 ',
			'mail_username' => 'bloomami2022@gmail.com',
			'mail_password' => 'vbahrmbbdiafomvf',
		];

		$ch = curl_init('https://message-sent.dev-vue.com/api/send-mail');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

		$response = curl_exec($ch);
		curl_close($ch);

		echo 'succ';
	} else {
		echo 'err';
	}
	unset($_SESSION['captcha']);
	exit;
}





if ($ary_get['proc'] == 'captcha') {

	include "uploads/captcha/simple-php-captcha.php";
	$_SESSION['captcha'] = simple_php_captcha();
	echo $_SESSION['captcha']['image_src'];
	exit;
}



if ($ary_get['proc'] == 'join') {


	if (!$_SESSION['checkRepeatTime'] || (time() - $_SESSION['checkRepeatTime']) > (24 * 60 * 60)) {
		$_SESSION['checkRepeatTime'] = time();
		$_SESSION['checkRepeat'] = 0;
	}
	$_SESSION['checkRepeat'] += 1;
	if ($_SESSION['checkRepeat'] >= $ary_config['actionLimit']) {
		header("Location:./?l=1");
		exit;
	}



	// if(strtolower($ary_post['captcha']) != strtolower($_SESSION['captcha']['code'])){
	// 	$_SESSION['join'] = $_POST;
	// 	header("Location:./join.php?err=captcha");
	// 	exit;
	// }

	if (!$ary_post['uname'] || !$ary_post['email'] || !$ary_post['pwd'] || !$ary_post['tel'] || !$ary_post['addr']) {
		header("Location:./join.php");
		exit;
	}
	if ($obj_member->fetch('*', " email = '" . $ary_post['email'] . "' ")) {
		header("Location:./join.php?err=email");
		exit;
	}

	$ary_DBdata = array(
		'uname' => $ary_post['uname'],
		'email' => $ary_post['email'],
		'pwd' => Md5This($ary_post['pwd']),
		'gender' => $ary_post['gender'],
		'birthday' => $ary_post['year'] . '-' . $ary_post['month'] . '-' . $ary_post['day'],
		'tel' => $ary_post['tel'],
		'addr' => $ary_post['addr'],
		'ip_addr' => showUserIp()
	);
	$ary_DBdata['city'] = $ary_post['city'];
	$ary_DBdata['district'] = $ary_post['district'];


	if ($ary_post['fb_id']) {
		$ary_DBdata['fb_id'] = $ary_post['fb_id'];
	}

	if ($obj_member->create($ary_DBdata)) {

		$ary_data = $obj_member->fetch('*', " email = '" . $ary_post['email'] . "' ");


		$mailBody = '
		時間 : ' . date('Y-m-d H:i:s') . '<br>
		<br>
		電子郵件 : ' . $ary_DBdata['email'] . '<br>
		<br>
		姓名 : ' . $ary_DBdata['uname'] . '<br>
		<br>
		性別 : ' . $ary_config['gender'][$ary_DBdata['gender']] . '<br>
		<br>
		生日 : ' . $ary_DBdata['birthday'] . '<br>
		<br>
		手機 : ' . $ary_DBdata['countrycodes'] . ' ' . $ary_DBdata['tel'] . '<br>
		<br>
		地址 : ' . $ary_DBdata['country'] . ' ' . $ary_DBdata['city'] . ' ' . $ary_DBdata['district'] . ' ' . $ary_DBdata['addr'] . '<br>
		<br>
		<br>
		===== 本信件由系統自動發送，請勿直接回覆本信件，謝謝 =====
		';

		// send_mail('babyin印鑑工坊 - 註冊通知 ', $mailBody, $ary_post['email']);

		$send_email_array = explode(",", $ary_post['email']); //根据逗号分割存入数组
		foreach ($send_email_array as $recipient) {
			$recipient = trim($recipient); // 移除可能的空格
			if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
				// $mail->addAddress($recipient);
				$emails[] = $recipient;
			}
		}

		// $emails[] = 'renfu.her@gmail.com';

		$postData = [
			'from_email' => 'bloomami2022@gmail.com',
			'from_name' => 'babyin印鑑工坊',
			'emails' => $emails,
			'message' => $mailBody,
			'subject' => 'babyin印鑑工坊 - 註冊通知 ',
			'mail_username' => 'bloomami2022@gmail.com',
			'mail_password' => 'vbahrmbbdiafomvf',
		];

		$ch = curl_init('https://message-sent.dev-vue.com/api/send-mail');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

		$response = curl_exec($ch);
		curl_close($ch);


		$_SESSION['login'] = $ary_data;
		$ary_DBdataLog['data_pkey'] = $_SESSION['login']['pkey'];
		$ary_DBdataLog['status'] = 'login';
		$ary_DBdataLog['ip_addr'] = showUserIp();
		$obj_member_log->create($ary_DBdataLog);


		header("Location:./index.php?status=succJoin");
		exit;
	} else {

		header("Location:./?err=db");
		exit;
	}





	exit;
}


if ($ary_get['proc'] == 'editMember') {

	if (!$_SESSION['login']) {
		header("Location:./login.php");
		exit;
	}
	if (!$ary_post['pwd'] || !$ary_post['tel'] || !$ary_post['addr']) {
		header("Location:./personal.php");
		exit;
	}

	$ary_DBdata = array(
		'pwd' => Md5This($ary_post['pwd']),
		'countrycodes' => $ary_post['countryCodes'],
		'tel' => $ary_post['tel'],
		'addr' => $ary_post['addr']
	);

	$ary_DBdata['city'] = $ary_post['city'];
	$ary_DBdata['district'] = $ary_post['district'];


	if ($obj_member->edit($ary_DBdata, " pkey = '" . $_SESSION['login']['pkey'] . "' ")) {

		$ary_data = $obj_member->fetch('*', " pkey = '" . $_SESSION['login']['pkey'] . "' ");
		$_SESSION['login'] = $ary_data;

		header("Location:./personal.php?status=succPersonalEdit");
		exit;
	} else {

		header("Location:./?err=db");
		exit;
	}





	exit;
}



if ($ary_get['proc'] == 'fblogin' && $ary_get['code'] != '') {

	$data = json_decode(file_get_contents('https://graph.facebook.com/oauth/access_token?client_id=' . $ary_config['fbAppId'] . '&client_secret=' . $ary_config['fbAppSecret'] . '&code=' . $_REQUEST['code'] . '&redirect_uri=' . urlencode($ary_config['fbLoginRedirecturl'])), true);
	$user_loginNOW = json_decode(file_get_contents('https://graph.facebook.com/me?fields=id,name,email&access_token=' . $data['access_token']), true);
	// echo '<pre>';
	// print_r($data);
	// print_r($user_loginNOW);
	// exit;
	// Array
	// (
	// 	[id] => 10157431015429734
	// 	[name] => Clouder Wang
	// 	[email] => clouderwang@gmail.com
	// )
	$ary_data = $obj_member->fetch('*', " email = '" . $user_loginNOW['email'] . "' ");
	if ($ary_data) {

		$_SESSION['login'] = $ary_data;

		$ary_DBdataLog['data_pkey'] = $_SESSION['login']['pkey'];
		$ary_DBdataLog['status'] = 'login';
		$ary_DBdataLog['info'] = 'fb';
		$ary_DBdataLog['ip_addr'] = showUserIp();
		$obj_member_log->create($ary_DBdataLog);

		header("Location:./product_list.php?status=loginSucc");
		exit;
	} else {
		$_SESSION['join']['uname'] = $user_loginNOW['name'];
		$_SESSION['join']['email'] = $user_loginNOW['email'];
		$_SESSION['join']['fb_id'] = $user_loginNOW['id'];
		header("Location:./join.php");
		exit;
	}





	exit;
}


if ($ary_get['proc'] == 'login') {

	if (!$_SESSION['checkRepeatTime'] || (time() - $_SESSION['checkRepeatTime']) > (24 * 60 * 60)) {
		$_SESSION['checkRepeatTime'] = time();
		$_SESSION['checkRepeat'] = 0;
	}
	$_SESSION['checkRepeat'] += 1;
	if ($_SESSION['checkRepeat'] >= $ary_config['actionLimit']) {
		header("Location:./?l=1");
		exit;
	}

	$ary_data = $obj_member->fetch('*', " email = '" . $ary_post['email'] . "' ");
	if ($ary_data['pwd'] === Md5This($ary_post['password'])) {
		$_SESSION['login'] = $ary_data;

		$ary_DBdataLog['data_pkey'] = $_SESSION['login']['pkey'];
		$ary_DBdataLog['status'] = 'login';
		$ary_DBdataLog['ip_addr'] = showUserIp();
		$obj_member_log->create($ary_DBdataLog);

		header("Location:./product_list.php?status=loginSucc");
		exit;
	} else {
		header("Location:./login.php?status=loginErr");
		exit;
	}
}

if ($ary_get['proc'] == 'logout') {

	$ary_DBdataLog['data_pkey'] = $_SESSION['login']['pkey'];
	$ary_DBdataLog['status'] = 'logout';
	$ary_DBdataLog['ip_addr'] = showUserIp();
	$obj_member_log->create($ary_DBdataLog);

	unset($_SESSION['login']);
	header("Location:./login.php?status=logout");
	exit;
}


if ($ary_get['proc'] == 'forget') {


	if (!$_SESSION['checkRepeatTime'] || (time() - $_SESSION['checkRepeatTime']) > (24 * 60 * 60)) {
		$_SESSION['checkRepeatTime'] = time();
		$_SESSION['checkRepeat'] = 0;
	}
	$_SESSION['checkRepeat'] += 1;
	if ($_SESSION['checkRepeat'] >= $ary_config['actionLimit']) {
		header("Location:./?l=1");
		exit;
	}

	// if(strtolower($ary_post['captcha']) != strtolower($_SESSION['captcha']['code'])){
	// 	header("Location:./forget.php?err=captcha");
	// 	exit;
	// }


	if (!$ary_post['email']) {
		header("Location:./forget.php");
		exit;
	}

	$ary_data = $obj_member->fetch('*', " email = '" . $ary_post['email'] . "' ");

	if (!$ary_data) {

		$ary_DBdataLog['status'] = 'forget';
		$ary_DBdataLog['info'] = $ary_post['email'];
		$ary_DBdataLog['ip_addr'] = showUserIp();
		$obj_member_log->create($ary_DBdataLog);

		header("Location:./forget.php?status=forgetNoEmail");
		exit;
	}

	$resetPwd = randomPassword();
	$ary_DBdata['pwd'] = Md5This($resetPwd);
	if ($obj_member->edit($ary_DBdata, " pkey = '" . $ary_data['pkey'] . "' ")) {

		$ary_DBdataLog['data_pkey'] = $ary_data['pkey'];
		$ary_DBdataLog['status'] = 'forget';
		$ary_DBdataLog['ip_addr'] = showUserIp();
		$obj_member_log->create($ary_DBdataLog);


		$mailBody = '
		' . $ary_data['uname'] . '，您好<br>
		您剛在babyin印鑑工坊申請了一組新的密碼，<br>
		將可以順利使用新的密碼登入：<br>
		密碼： ' . $resetPwd . '<br>
		登入後請至會員中心修改密碼! <br>
		歡迎直接進入babyin印鑑工坊線上購物 ' . $ary_config['websiteUrl'] . ' <br>
		<br>
		<br>
		======本信件由系統自動發送，請勿直接回覆本信件，謝謝!======<br>
		';

		// send_mail('babyin印鑑工坊 密碼通知信 ', $mailBody, $ary_data['email']);

		$send_email_array = explode(",", $ary_data['email']); //根据逗号分割存入数组
		foreach ($send_email_array as $recipient) {
			$recipient = trim($recipient); // 移除可能的空格
			if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
				// $mail->addAddress($recipient);
				$emails[] = $recipient;
			}
		}

		// $emails[] = 'renfu.her@gmail.com';

		$postData = [
			'from_email' => 'bloomami2022@gmail.com',
			'from_name' => 'babyin印鑑工坊',
			'emails' => $emails,
			'message' => $mailBody,
			'subject' => 'babyin印鑑工坊 密碼通知信 ',
			'mail_username' => 'bloomami2022@gmail.com',
			'mail_password' => 'vbahrmbbdiafomvf',
		];

		$ch = curl_init('https://message-sent.dev-vue.com/api/send-mail');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

		$response = curl_exec($ch);
		curl_close($ch);

		header("Location:./forget.php?status=succForgetEmail");
		exit;
	} else {
		header("Location:./index.php");
		exit;
	}
}



if ($ary_get['proc'] == 'addToCart') {

	if ($obj_products->fetch('*', " pkey = '" . $ary_post['p'] . "' ")) {

		$_SESSION['cart'][] = array(
			'pkey' => abs(intval($ary_post['p'])),
			'select1' => abs(intval($ary_post['select1'])),
			'select2' => abs(intval($ary_post['select2'])),
			'total' => abs(intval($ary_post['total'])),
			'time' => time()
		);
	}
	echo count($_SESSION['cart']);

	exit;
}


if ($ary_get['proc'] == 'renewCart') {

	$ary_prod = explode('|||', $ary_post['data']);

	unset($_SESSION['cart']);

	foreach ($ary_prod as $value) {
		if ($value) {
			$ary_info = explode(',', $value);
			if ($obj_products->fetch('*', " pkey = '" . abs(intval($ary_info['0'])) . "' ")) {
				$_SESSION['cart'][] = array(
					'pkey' => abs(intval($ary_info['0'])),
					'select1' => abs(intval($ary_info['1'])),
					'total' => abs(intval($ary_info['2'])),
					'time' => time()
				);
			}
		}
	}



	exit;
}


if ($ary_get['proc'] == 'shoppingFinishCaptcha') {

	// if(strtolower($ary_post['captcha']) != strtolower($_SESSION['captcha']['code'])){
	// 	echo 'captcha';
	// 	exit;
	// }else{
	echo 'succ';
	exit;
	// }
}



if ($ary_get['proc'] == 'shoppingFinish') {

	if (!$_SESSION['cart']) {
		header("Content-Type:text/html; charset=utf-8");
		echo '
		<script>
		alert("購物車沒有任何商品");
		top.location.href = "product_list.php";
		</script>
		';
		exit;
	}
	if (!$_SESSION['login']) {
		header("Location:./login.php");
		exit;
	}
	if (!$ary_post['payment'] || !$ary_post['uname'] || !$ary_post['tel'] || !$ary_post['addr']) {
		unset($_SESSION['cart']);
		unset($_SESSION['login']);
		header("Location:./?l=3");
		exit;
	}

	$ary_DBdata = array(
		'data_pkey' => $_SESSION['login']['pkey'],
		'payment' => $ary_post['payment'],
		'uname' => $ary_post['uname'],
		'shippment' => $ary_post['shippment'],
		'timeslot' => $ary_post['timeslot'],
		'gender' => $ary_post['gender'],
		'tel' => $ary_post['tel'],
		'email' => $_SESSION['login']['email'],
		'addr' => $ary_post['addr'],
		'info' => safe(nl2br($_POST['info'])),
		// 'invoice' => $ary_post['receipt'],
		'ip_addr' => showUserIp()
	);

	$ary_DBdata['bankaccount'] = $ary_post['payment'] == '2' ? $ary_post['bankaccount'] : '';

	$ary_DBdata['city'] = $ary_post['city'];
	$ary_DBdata['district'] = $ary_post['district'];

	$ary_DBdata['invoiceCity'] = $ary_post['receipt'] != '1' ? $ary_post['invoiceCity'] : '';
	$ary_DBdata['invoiceDistrict'] = $ary_post['receipt'] != '1' ? $ary_post['invoiceDistrict'] : '';
	$ary_DBdata['invoiceAddr'] = $ary_post['receipt'] != '1' ? $ary_post['invoiceAddr'] : '';

	$ary_DBdata['invoiceTitle'] = $ary_post['receipt'] == '3' ? $ary_post['invoiceTitle'] : '';
	$ary_DBdata['invoiceTaxid'] = $ary_post['receipt'] == '3' ? $ary_post['invoiceTaxid'] : '';

	$mailBodyUserInfo = '
		訂購方式 : ' . $ary_config['payment'][$ary_DBdata['payment']] . '<br>
		收貨姓名 : ' . $ary_DBdata['uname'] . '<br>
		性別 : ' . $ary_config['gender'][$ary_DBdata['gender']] . '<br>
		連絡電話 : ' . $ary_DBdata['tel'] . '<br>
		寄送地址 : ' . $ary_DBdata['country'] . ' ' . $ary_DBdata['city'] . ' ' . $ary_DBdata['district'] . ' ' . $ary_DBdata['addr'] . '<br>
		匯款帳號 : ' . $ary_DBdata['bankaccount'] . '<br>
		訂購備註 : ' . nl2br($_POST['info']) . '<br>
		<br>
		<br>
	';

	// 暫時關閉發票功能
	// $mailBodyUserInfo .= '發票類型 : '.$ary_config['invoice'][$ary_DBdata['invoice']].'<br>';
	// $mailBodyUserInfo .= $ary_DBdata['invoiceCity'] ? '發票寄送地址 : '.$ary_DBdata['invoiceCity'].' '.$ary_DBdata['invoiceDistrict'].' '.$ary_DBdata['invoiceAddr'].'<br>' : '' ;
	// $mailBodyUserInfo .= $ary_DBdata['invoiceTitle'] ? '發票抬頭 : '.$ary_DBdata['invoiceTitle'].'<br>' : '';
	// $mailBodyUserInfo .= $ary_DBdata['invoiceTaxid'] ? '發票統編 : '.$ary_DBdata['invoiceTaxid'].'<br>' : '';
	// 暫時關閉發票功能

	if ($obj_order->create($ary_DBdata)) {
		$ary_data = $obj_order->fetch('*', " data_pkey = '" . $ary_DBdata['data_pkey'] . "' order by pkey DESC ");
		$ary_select = $obj_products_select->fetchAll_join();
		foreach ($ary_select as $value) {
			$ary_selectRe[$value['pkey']] = $value['title'];
		}
		foreach ($_SESSION['cart'] as $value) {
			$ary_prod = $obj_products->fetch('*', " pkey = '" . $value['pkey'] . "' ");
			$ary_DBdataProd = array(
				'user_pkey' => $_SESSION['login']['pkey'],
				'data_pkey' => $ary_data['pkey'],
				'prod_pkey' => $value['pkey'],
				'prod_title' => $ary_prod['title'],
				'select1' => $value['select1'],
				's1_title' => $ary_selectRe[$value['select1']],
				'price' => $ary_prod['price'],
				'total' => $value['total']
			);

			$mailBodyProdList .= '<tr>
					<td><img src="' . $ary_config['websiteUrl'] . 'uploads/' . $ary_prod['listpic'] . '" height="90px"></td>
					<td>' . $ary_DBdataProd['prod_title'] . ' ' . $ary_DBdataProd['s1_title'] . ' ' . $ary_DBdataProd['s2_title'] . '</td>
					<td>$' . $ary_DBdataProd['price'] . '</td>
					<td>' . $ary_DBdataProd['total'] . '</td>
					<td>' . ($ary_DBdataProd['total'] * $ary_DBdataProd['price']) . '</td>
					</tr>';


			if (!$obj_order_list->create($ary_DBdataProd)) {
				unset($_SESSION['cart']);
				unset($_SESSION['login']);
				header("Location:./?l=5");
				exit;
			}
			$totalMoney += $ary_prod['price'] * $value['total'];
		}

		unset($_SESSION['cart']);


		$finalTotalMoney = $totalMoney;

		$ary_DBfinalTotalMoney['orderno'] = date('Ymd', strtotime($ary_data['createdate'])) . str_pad($ary_data['pkey'], 6, '0', STR_PAD_LEFT);
		$ary_DBfinalTotalMoney['total'] = $finalTotalMoney;
		$obj_order->edit($ary_DBfinalTotalMoney, " pkey = '" . $ary_data['pkey'] . "' ");

		$mailBodyProdList = '<table style="width: 80%;"><tr style="background-color: #ccc;">
					<td></td>
					<td>商品名稱</td>
					<td>售價</td>
					<td>數量</td>
					<td>小計</td>
					</tr>' . $mailBodyProdList . '<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td style="text-align: right;">
					小計 : ' . $totalMoney . '<br>
					總計 : ' . $finalTotalMoney . '<br>
					</td>
					</tr></table>';

		if ($ary_post['payment'] != '1') {

			$mailBody = '
			' . $_SESSION['login']['uname'] . ' 您好，訂購明細如下:<br>
			' . $mailBodyProdList . '
			';

			$mailBodyUserInfo = $mailBodyUserInfo . '<br><br>=====<br><br>' . $mailBody;

			// send_mail('babyin印鑑工坊 訂單通知信 ', $mailBodyUserInfo, $ary_config['adminEmail']);

			$send_email_array = explode(",", $ary_config['adminEmail']); //根据逗号分割存入数组
			foreach ($send_email_array as $recipient) {
				$recipient = trim($recipient); // 移除可能的空格
				if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
					// $mail->addAddress($recipient);
					$emails[] = $recipient;
				}
			}

			// $emails[] = 'renfu.her@gmail.com';

			$postData = [
				'from_email' => 'bloomami2022@gmail.com',
				'from_name' => 'babyin印鑑工坊',
				'emails' => $emails,
				'message' => $mailBodyUserInfo,
				'subject' => 'babyin印鑑工坊 訂單通知信 ',
				'mail_username' => 'bloomami2022@gmail.com',
				'mail_password' => 'vbahrmbbdiafomvf',
			];

			$ch = curl_init('https://message-sent.dev-vue.com/api/send-mail');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

			$response = curl_exec($ch);
			curl_close($ch);


			if ($ary_post['payment'] == '3' || $ary_post['payment'] == '4') {

				send_mail('babyin印鑑工坊 訂單成功通知 ', $mailBody, $_SESSION['login']['email']);

				$send_email_array = explode(",", $_SESSION['login']['email']); //根据逗号分割存入数组
				foreach ($send_email_array as $recipient) {
					$recipient = trim($recipient); // 移除可能的空格
					if (filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
						// $mail->addAddress($recipient);
						$emails[] = $recipient;
					}
				}

				// $emails[] = 'renfu.her@gmail.com';

				$postData = [
					'from_email' => 'bloomami2022@gmail.com',
					'from_name' => 'babyin印鑑工坊',
					'emails' => $emails,
					'message' => $mailBody,
					'subject' => 'babyin印鑑工坊 訂單成功通知 ',
					'mail_username' => 'bloomami2022@gmail.com',
					'mail_password' => 'vbahrmbbdiafomvf',
				];

				$ch = curl_init('https://message-sent.dev-vue.com/api/send-mail');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));

				$response = curl_exec($ch);
				curl_close($ch);
			} else if ($ary_post['payment'] == '2') {
				$mailBody .= '
				<br>
				<span style="color:#135ab8;">
				銀行代碼：' . $ary_config['bank']['code'] . '<br>
				匯款銀行：' . $ary_config['bank']['bank'] . '<br>
				匯款帳號：' . $ary_config['bank']['acc'] . '<br>
				匯款戶名：' . $ary_config['bank']['name'] . '<br>
				</span>
				<br>
				<br>
				======本信件由系統自動發送，請勿直接回覆本信件，謝謝!======<br>
				';
				send_mail('babyin印鑑工坊 訂單成功 請繳款 ', $mailBody, $_SESSION['login']['email']);
			}


			$mailBody .= '
				<br>
				<br>
				======本信件由系統自動發送，請勿直接回覆本信件，謝謝!======<br>
			';

			header("Location:./shopping_3.php?p=" . $ary_data['pkey']);
			exit;
		}

		header("Content-Type:text/html; charset=utf-8");
		$mer_array = array(
			'MerchantID' => $ary_config['newebpayMerchantID'],
			'RespondType' => $ary_config['newebpayRespondType'],
			'ReturnURL' => $ary_config['newebpayReturnURL'],
			'TimeStamp' => time(),
			'Version' => $ary_config['newebpayVersion'],
			'MerchantOrderNo' => $ary_data['pkey'],
			'Amt' => $finalTotalMoney,
			'ItemDesc' => '購買商品'
		);
		$mer_key = $ary_config['newebpayHashKey'];
		$mer_iv = $ary_config['newebpayHashIV'];
		$TradeInfo = create_mpg_aes_encrypt($mer_array, $mer_key, $mer_iv);


		$CheckValue_str = 'HashKey=' . $ary_config['newebpayHashKey'] . '&' . $TradeInfo . '&HashIV=' . $ary_config['newebpayHashIV'];
		$TradeSha = strtoupper(hash("sha256", $CheckValue_str));

?>
		<form id='form' method='post' action='<?= $ary_config['newebpayUrl'] ?>'>
			<input type='hidden' name='MerchantID' value='<?= $mer_array['MerchantID'] ?>'><br>
			<input type='hidden' name='RespondType' value='<?= $mer_array['RespondType'] ?>'><br>
			<input type='hidden' name='TradeInfo' value='<?= $TradeInfo ?>'><br>
			<input type='hidden' name='TradeSha' value='<?= $TradeSha ?>'><br>
			<input type='hidden' name='TimeStamp' value='<?= $mer_array['TimeStamp'] ?>'><br>
			<input type='hidden' name='Version' value='<?= $mer_array['Version'] ?>'><br>
			<input type='hidden' name='MerchantOrderNo' value='<?= $mer_array['MerchantOrderNo'] ?>'><br>
			<input type='hidden' name='Amt' value='<?= $mer_array['Amt'] ?>'><br>
			<input type='hidden' name='ItemDesc' value='<?= $mer_array['ItemDesc'] ?>'><br>
			<input type='hidden' name='Email' value='<?= $_SESSION['login']['email'] ?>'><br>
			<input type='hidden' name='EmailModify' value='0'><br>
			<input type='hidden' name='CREDIT' value='1'><br>
			<input type='hidden' name='LoginType' value='0'><br>
			<input type='hidden' name='ReturnURL' value='<?= $ary_config['newebpayReturnURL'] ?>'><br>
			<input type='hidden' name='OrderComment' value=''><br>
			<input type='submit' value='Submit' style="display:none;">
		</form>
		<script>
			document.getElementById("form").submit();
		</script>

<?php


	} else {
		unset($_SESSION['cart']);
		unset($_SESSION['login']);
		header("Location:./?l=4");
		exit;
	}








	exit;
}


if ($ary_get['proc'] == 'return') {

	if (!$_SESSION['login']) {
		header("Location:./login.php");
		exit;
	}

	$ary_DBdata['info'] = print_r($ary_post, true);
	$ary_DBdata['ip_addr'] = showUserIp();
	$obj_order_return->create($ary_DBdata);


	$ary_NPback = json_decode(create_aes_decrypt($ary_post['TradeInfo'], $ary_config['newebpayHashKey'], $ary_config['newebpayHashIV']), true);


	// echo '<pre>';
	// print_r($ary_post);
	// print_r(create_aes_decrypt($ary_post['TradeInfo'],$ary_config['newebpayHashKey'], $ary_config['newebpayHashIV']));
	// print_r($ary_NPback);


	if ($ary_post['Status'] == 'SUCCESS') {
		$ary_DBorder['status'] = '1';
		$ary_DBorder['msg'] = $ary_NPback['Message'];
		$ary_data = $obj_order->fetch('*', " pkey = '" . $ary_NPback['Result']['MerchantOrderNo'] . "' ");
		if ($ary_data['total'] == $ary_NPback['Result']['Amt']) {
			$obj_order->edit($ary_DBorder, " pkey = '" . $ary_NPback['Result']['MerchantOrderNo'] . "' ");

			$ary_list = $obj_order_list->fetchAll('*', " data_pkey = '" . $ary_data['pkey'] . "' ");

			foreach ($ary_list as $value) {
				$ary_prod = $obj_products->fetch('*', " pkey = '" . $value['prod_pkey'] . "' ");
				$mailBodyProdList .= '<tr>
						<td><img src="' . $ary_config['websiteUrl'] . 'uploads/' . $ary_prod['listpic'] . '" height="90px"></td>
						<td>' . $value['prod_title'] . ' ' . $value['s1_title'] . ' ' . $value['s2_title'] . '</td>
						<td>$' . $value['price'] . '</td>
						<td>' . $value['total'] . '</td>
						<td>' . ($value['total'] * $value['price']) . '</td>
						</tr>';
			}



			$mailBodyProdList = '<table style="width: 80%;"><tr style="background-color: #ccc;">
						<td></td>
						<td>商品名稱</td>
						<td>售價</td>
						<td>數量</td>
						<td>小計</td>
						</tr>' . $mailBodyProdList . '<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td style="text-align: right;">
						小計 : ' . ($ary_data['total'] - $ary_data['shippingfee']) . '<br>
						總計 : ' . $ary_data['total'] . '<br>
						</td>
						</tr></table>';
			$mailBody = '
			' . $ary_data['uname'] . ' 您好，訂購明細如下:<br>
			' . $mailBodyProdList . '
			<br>
			<br>
			======本信件由系統自動發送，請勿直接回覆本信件，謝謝!======<br>
			';

			// $mailBodyUserInfo = '
			// 	訂購方式 : '.$ary_config['payment'][$ary_data['payment']].'<br>
			// 	收貨姓名 : '.$ary_data['uname'].'<br>
			// 	性別 : '.$ary_config['gender'][$ary_data['gender']].'<br>
			// 	連絡電話 : '.$ary_data['tel'].'<br>
			// 	生日 : '.$ary_data['birthday'].'<br>
			// 	寄送地址 : '.$ary_data['country'].' '.$ary_data['city'].' '.$ary_data['district'].' '.$ary_data['addr'].'<br>
			// 	訂購備註 : '.$ary_data['info'].'<br>
			// 	<br>
			// 	<br>
			// 	發票類型 : '.$ary_config['invoice'][$ary_data['invoice']].'<br>
			// 	發票寄送地址 : '.$ary_data['invoiceCity'].' '.$ary_data['invoiceDistrict'].' '.$ary_data['invoiceAddr'].'<br>
			// 	發票抬頭 : '.$ary_data['invoiceTitle'].'<br>
			// 	發票統編 : '.$ary_data['invoiceTaxid'].'<br>
			// ';
			$mailBodyUserInfo = '
				訂購方式 : ' . $ary_config['payment'][$ary_data['payment']] . '<br>
				收貨姓名 : ' . $ary_data['uname'] . '<br>
				性別 : ' . $ary_config['gender'][$ary_data['gender']] . '<br>
				連絡電話 : ' . $ary_data['tel'] . '<br>
				生日 : ' . $ary_data['birthday'] . '<br>
				寄送地址 : ' . $ary_data['country'] . ' ' . $ary_data['city'] . ' ' . $ary_data['district'] . ' ' . $ary_data['addr'] . '<br>
				訂購備註 : ' . $ary_data['info'] . '<br>
			';
			$mailBodyUserInfo .= $ary_data['invoiceCity'] ? '發票寄送地址 : ' . $ary_data['invoiceCity'] . ' ' . $ary_data['invoiceDistrict'] . ' ' . $ary_data['invoiceAddr'] . '<br>' : '';
			$mailBodyUserInfo .= $ary_data['invoiceTitle'] ? '發票抬頭 : ' . $ary_data['invoiceTitle'] . '<br>' : '';
			$mailBodyUserInfo .= $ary_data['invoiceTaxid'] ? '發票統編 : ' . $ary_data['invoiceTaxid'] . '<br>' : '';


			$mailBodyUserInfo = $mailBodyUserInfo . '<br><br>=====<br><br>' . $mailBody;


			send_mail('babyin印鑑工坊 訂單通知信 ', $mailBodyUserInfo, $ary_config['adminEmail']);

			send_mail('babyin印鑑工坊 訂單成功通知 ', $mailBody, $ary_data['email']);
		}
		header("Location:./shopping_3.php?p=" . $ary_data['pkey']);
		exit;
	} else {
		$ary_DBorder['msg'] = $ary_NPback['Message'];
		$obj_order->edit($ary_DBorder, " pkey = '" . $ary_NPback['Result']['MerchantOrderNo'] . "' ");

		// 付款失敗
		exit;
	}
}






function create_mpg_aes_encrypt($parameter = "", $key = "", $iv = "")
{
	$return_str = '';
	if (!empty($parameter)) {
		//將參數經過 URL ENCODED QUERY STRING
		$return_str = http_build_query($parameter);
	}
	return trim(bin2hex(openssl_encrypt(addpadding($return_str), 'aes-256-cbc', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv)));
}
function addpadding($string, $blocksize = 32)
{
	$len = strlen($string);
	$pad = $blocksize - ($len % $blocksize);
	$string .= str_repeat(chr($pad), $pad);
	return $string;
}


function create_aes_decrypt($parameter = "", $key = "", $iv = "")
{
	// return openssl_decrypt(hextobin($parameter),'AES-256-CBC', $key, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $iv);
	return strippadding(openssl_decrypt(hextobin($parameter), 'AES-256-CBC', $key, OPENSSL_RAW_DATA | OPENSSL_ZERO_PADDING, $iv));
}
function strippadding($string)
{
	$slast = ord(substr($string, -1));
	$slastc = chr($slast);
	$pcheck = substr($string, -$slast);
	if (preg_match("/$slastc{" . $slast . "}/", $string)) {
		$string = substr($string, 0, strlen($string) - $slast);
		return $string;
	} else {
		return false;
	}
}
function hextobin($hexstr)
{
	$n = strlen($hexstr);
	$sbin = "";
	$i = 0;
	while ($i < $n) {
		$a = substr($hexstr, $i, 2);
		$c = pack("H*", $a);
		if ($i == 0) {
			$sbin = $c;
		} else {
			$sbin .= $c;
		}
		$i += 2;
	}
	return $sbin;
}
