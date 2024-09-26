<?php 

			// echo '<pre>';
			// print_r($_FILES);
			// exit;

			$ary_DBdata = array(
								'uname' => $ary_post['uname'],
								'tel' => $ary_post['tel'],
								'gender' => $ary_post['gender'],
								'city' => $ary_post['city'],
								'district' => $ary_post['district'],
								'addr' => $ary_post['addr'],
								'bankaccount' => $ary_post['bankaccount'],
								'status' => $ary_post['status'],
								'info' => safe(nl2br($_POST['info']))
			);


			if($ary_post['proc'] == 'add'){
				// $total_data = $obj_products->fetch('count(*) total' , " data_pkey = '".$ary_post['data_pkey']."' ");
				// $ary_DBdata['sort'] = ($total_data['total'] * 5 +200);

				// if($obj_products->create($ary_DBdata)){
				// 	$data_pkey = $mydb->InsertId();


				// 	add_edit_recV2($ary_post['c'] ,$ary_DBdata);
				// 	echo '
				// 	<script type="text/javascript">
				// 	parent.location.href="index.php?msg=succAdd&'.$_SESSION['redirectPageUrl'].'";
				// 	</script>
				// 	';
				// 	exit;
				// }
			}else if($ary_post['proc'] == 'edit'){
				$ary_data = $obj_order->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_order->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){

					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










