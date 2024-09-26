<?php 
session_start();
ini_set('display_errors', 0);
if($_GET['debug'] == 'cldd'){
	ini_set('display_errors', 1);
	error_reporting(E_ALL ^ E_NOTICE);
}
if(!defined(ROOT))		
	define('ROOT',dirname(__FILE__).'/');

if(!defined(libs))        
	define('libs',dirname(__FILE__).'/library/');

if(!defined(icld))        
	define('icld',dirname(__FILE__).'/include/');


include_once libs.'MyDB.php';
include_once libs.'SimpleSQL.php';
include_once libs.'func.php' ;
include_once libs.'Mobile_Detect.php' ;

$conn_host  = '127.0.0.1';
$conn_db    = 'goodwayt_babyin';
$conn_user  = 'babyin';
$conn_pass  = 'qF2n9LA58A292yKE';


// admin acc
// clouday / FAGQdsM79JJvsEvh


 define("mail_server","smtp.gmail.com");
 define("mail_login_name","bloomami2022@gmail.com");
// define("mail_login_pass", "bloomserver29160722");
 define("mail_login_pass", "owectxuwfbapejsn");

 define("smtp_port","465");
 define("config_mailFrom","bloomami2022@gmail.com");
 define("config_mailFromName","Babyin 印鑑工坊");

//define("mail_server","smtp.google.com");
//define("mail_login_name","bloomami2022@gmail.com");
//define("mail_login_pass","29160722");
//define("smtp_port","465");
//define("config_mailFrom","no-reply@goodway.tw");
//define("config_mailFromName","Babyin 印鑑工坊");


$mydb = new MyDB($conn_host , $conn_db , $conn_user , $conn_pass);
//var_dump($mydb);
$mydb->SqlQuery("SET NAMES utf8");

$obj_category							= new SimpleSQL($mydb , 'babyin_category');
$obj_products							= new SimpleSQL($mydb , 'babyin_products');
$obj_products_pic						= new SimpleSQL($mydb , 'babyin_products_pic');
$obj_products_select					= new SimpleSQL($mydb , 'babyin_products_select');
$obj_banner								= new SimpleSQL($mydb , 'babyin_banner');
$obj_news								= new SimpleSQL($mydb , 'babyin_news');
$obj_contact							= new SimpleSQL($mydb , 'babyin_contact');
$obj_member								= new SimpleSQL($mydb , 'babyin_member');
$obj_member_log							= new SimpleSQL($mydb , 'babyin_member_log');
$obj_order								= new SimpleSQL($mydb , 'babyin_order');
$obj_order_list							= new SimpleSQL($mydb , 'babyin_order_list');
$obj_order_return						= new SimpleSQL($mydb , 'babyin_order_return');
$obj_faq_category						= new SimpleSQL($mydb , 'babyin_faq_category');
$obj_faq								= new SimpleSQL($mydb , 'babyin_faq');

$obj_article							= new SimpleSQL($mydb , 'babyin_article');
$obj_article_category					= new SimpleSQL($mydb , 'babyin_article_category');


$obj_admin								= new SimpleSQL($mydb , 'babyin_admin');
$obj_admin_log							= new SimpleSQL($mydb , 'babyin_admin_log');
$obj_adminrec        				   	= new SimpleSQL($mydb , 'babyin_adminrec');


$ary_adminConfig['pageTitle'] = 'Babyin';
$ary_adminConfig['logoTitle'] = 'Babyin';

$ary_adminConfig['lvlBtnShow'] = $_SESSION['AdminLvl']=='1' ? '' : 'display:none;';
$ary_adminConfig['lvlBtnReadonly'] = $_SESSION['AdminLvl']=='1' ? '' : 'readonly';


$server_root = ROOT.'uploads/';

$ary_config['websiteUrl'] = 'https://babyin.tw/';
$ary_config['ckeditorUploadUrl'] = $ary_config['websiteUrl'].'uploads/';
$ary_config['fbLoginRedirecturl'] = $ary_config['websiteUrl'].'proc.php?proc=fblogin';
$ary_config['fbAppId'] = '740794153019659';
$ary_config['fbAppSecret'] = 'c7b495d5c070f5a5a9f1130f0fbdd237';

$ary_config['actionLimit'] = 100;

$ary_post = safe($_REQUEST);
$ary_get = safe($_GET);
//var_dump($ary_get);


// 測試
// $ary_config['newebpayUrl'] = 'https://ccore.newebpay.com/MPG/mpg_gateway';
// $ary_config['newebpayMerchantID'] = 'MS38173631';
// $ary_config['newebpayRespondType'] = 'JSON';
// $ary_config['newebpayVersion'] = '1.5';
// $ary_config['newebpayHashKey'] = 'NRK8eSON5TUeYirjdiztP1XyryH2HCd0';
// $ary_config['newebpayHashIV'] = 'Cf68XjuERdjEbkrP';
// $ary_config['newebpayReturnURL'] = $ary_config['websiteUrl'].'proc.php?proc=return';
// 測試

// 正式
$ary_config['newebpayUrl'] = 'https://core.newebpay.com/MPG/mpg_gateway';
$ary_config['newebpayMerchantID'] = 'MS3295649885';
$ary_config['newebpayRespondType'] = 'JSON';
$ary_config['newebpayVersion'] = '1.5';
$ary_config['newebpayHashKey'] = 'bP7BhW0aKBJRLV7EYKnEbZJr4EmRdwN3';
$ary_config['newebpayHashIV'] = 'PRWqwJDCyReAvfEC';
$ary_config['newebpayReturnURL'] = $ary_config['websiteUrl'].'proc.php?proc=return';
// 正式


// 1. 測試環境僅接受以下的測試卡號。
// 4000-2211-1111-1111（一次付清與分期付款）
// 4003-5511-1111-1111（紅利折抵）
// 2. 測試卡號有效月年及卡片背面末三碼，請任意填寫。
// 3. 系統在執行測試刷卡後，以測試授權碼回應模擬付款完成。
// 4. 以測試卡號之外的卡號資料進行交易都會失敗。

// 金流測試位置
// https://cwww.newebpay.com/
// 金流正式位置
// https://www.newebpay.com/
// 統編 :85132827
// 帳號 :amiwu2012
// 密碼 :ami09280928

$ary_config['payment']['1'] = '信用卡';
$ary_config['payment']['2'] = 'ATM轉帳';
$ary_config['payment']['3'] = '貨到付款';
$ary_config['payment']['4'] = '到店取貨';

$ary_config['gender']['1'] = '男';
$ary_config['gender']['2'] = '女';

$ary_config['invoice']['1'] = '公益捐贈';
$ary_config['invoice']['2'] = '二聯式';
$ary_config['invoice']['3'] = '三聯式';

$ary_config['shippment']['1'] = '郵寄';
$ary_config['shippment']['2'] = '到店自取';


$ary_config['bank']['code'] = '700';
$ary_config['bank']['bank'] = '莒光路(郵局)';
$ary_config['bank']['acc'] = '000-1358-089-7632';
$ary_config['bank']['name'] = '李品樂';

$ary_config['adminEmail'] = 'clouderwang@gmail.com;amiwu2012@gmail.com;babyin888@gmail.com;f130150037@gmail.com';
// $ary_config['adminEmail'] = 'clouderwang@gmail.com;amiwu2012@gmail.com';


$ary_config['orderStatus']['0']['title'] = '待確認';
$ary_config['orderStatus']['2']['title'] = '已確認';
$ary_config['orderStatus']['1']['title'] = '已付款';
$ary_config['orderStatus']['3']['title'] = '已出貨';
$ary_config['orderStatus']['4']['title'] = '作廢';

$ary_config['orderStatus']['0']['color'] = '#cccccc';
$ary_config['orderStatus']['2']['color'] = '#000000';
$ary_config['orderStatus']['1']['color'] = '#7ebdf4';
$ary_config['orderStatus']['3']['color'] = '#00ff5a';
$ary_config['orderStatus']['4']['color'] = '#ff0000';


$ary_head['title'] = 'Babyin 寶貝印 印鑑工坊';
$ary_head['keyword'] = '印章店,刻印章,印章 刻印,臍帶章,臍帶印章,肚臍印章,臍帶章推薦,印章開運,手工印章,客製化印章,剃胎毛';


$ary_category = $obj_category -> fetchAll_join('*' , " order by data_pkey ASC, sort DESC ");

foreach($ary_category as $value){
	if($value['data_pkey'] == '0'){
		$ary_nav['ary']['category'][$value['pkey']] = $value;
	}else{
		$ary_categorySubBelong[$value['pkey']] = $value['data_pkey'];
		$ary_nav['ary']['category'][$value['data_pkey']]['subCategory'][] = $value;
	}
}

$ary_articleCategory = $obj_article_category -> fetchAll_join('*', " order by sort DESC ");


if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off"){
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: ' . $redirect);
	exit;
}

// echo '<pre>';
// print_r($ary_categoryRe);
