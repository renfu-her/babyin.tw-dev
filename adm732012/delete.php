<?php
require_once '../config.php';


if($_SESSION['AdminLogin'] != true ){
	header("Location:./index.php");
	exit;
}




switch($ary_get['c']){


	case '10':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_products->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_products->drop(" pkey = '".$ary_get['pk']."' ");
			$obj_products_pic->drop(" data_pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;

	case '10-1':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_products_pic->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_products_pic->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '15':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_banner->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_banner->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;

	case '17':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_products_select->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_products_select->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;



	case '20':

		if(is_numeric($ary_get['pk'])){
			$ary_data = $obj_category->fetchAll('*' , " data_pkey = '".$ary_get['pk']."' ");
			$ary_DBdata[] = $ary_data;
			$obj_category->drop(" pkey = '".$ary_get['pk']."' ");
			$obj_category->drop(" data_pkey = '".$ary_get['pk']."' ");
			foreach($ary_data as $value){
				$ary_prod = $obj_products->fetchAll('*' , " data_pkey = '".$value['pkey']."' ");
				$obj_products->drop(" data_pkey = '".$value['pkey']."' ");
				$ary_DBdata[] = $ary_prod;
				foreach($ary_prod as $value2){
					$obj_products_pic->drop(" data_pkey = '".$value2['pkey']."' ");
				}
			}
			delect_recV2($ary_get['c'] ,$ary_DBdata);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '30':

		if(is_numeric($ary_get['pk'])){
			$ary_data = $obj_category->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$ary_DBdata[] = $ary_data;
			$obj_category->drop(" pkey = '".$ary_get['pk']."' ");
			$ary_prod = $obj_products->fetchAll('*' , " data_pkey = '".$ary_get['pk']."' ");
			$obj_products->drop(" data_pkey = '".$ary_get['pk']."' ");
			$ary_DBdata[] = $ary_prod;
			foreach($ary_prod as $value2){
				$obj_products_pic->drop(" data_pkey = '".$value2['pkey']."' ");
			}
			delect_recV2($ary_get['c'] ,$ary_DBdata);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '40':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_banner->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_banner->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '50':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_news->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_news->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '60':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_news->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_news->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '70':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_member->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$ary_data[] = $obj_order->fetchAll('*' , " data_pkey = '".$ary_get['pk']."' ");
			$ary_data[] = $obj_order_list->fetchAll('*' , " user_pkey = '".$ary_get['pk']."' ");
			$obj_member->drop(" pkey = '".$ary_get['pk']."' ");
			$obj_order->drop(" data_pkey = '".$ary_get['pk']."' ");
			$obj_order_list->drop(" user_pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;

	case '80':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_admin->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_admin->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;





	case '90':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_contact->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_contact->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '110':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_faq_category->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$ary_data[] = $obj_faq->fetchAll('*' , " data_pkey = '".$ary_get['pk']."' ");
			$obj_faq_category->drop(" pkey = '".$ary_get['pk']."' ");
			$obj_faq->drop(" data_pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '113':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_faq->fetchAll('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_faq->drop(" pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;

	case '120':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_article_category->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$ary_data[] = $obj_article->fetchAll('*' , " data_pkey = '".$ary_get['pk']."' ");
			$obj_article_category->drop(" pkey = '".$ary_get['pk']."' ");
			$obj_article->drop(" data_pkey = '".$ary_get['pk']."' ");
			delect_recV2($ary_get['c'] ,$ary_data);
		}
		header("Location:./index.php?msg=succ_del&".$_SESSION['redirectPageUrl']."");
		exit;

	break;


	case '123':

		if(is_numeric($ary_get['pk'])){
			$ary_data[] = $obj_article->fetchAll('*' , " pkey = '".$ary_get['pk']."' ");
			$obj_article->drop(" pkey = '".$ary_get['pk']."' ");
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