<?php 

			// echo '<pre>';
			// print_r($_FILES);
			// exit;

			$ary_DBdata = array(
								'title' => $ary_post['title'],
								'info' => $ary_post['info'],
								'type' => '2'
			);

			if($_FILES['pic']['error'] == 0){
				$banner = pic_upload_proc($_FILES['pic']['name'], $_FILES['pic']['tmp_name'] ,'552' ,'344');
				if($banner == 'sizeErr'){
					echo '<script type="text/javascript">alert("圖片尺寸錯誤");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
					exit;
				}
				$ary_DBdata['pic'] = $banner;
			}


			if($ary_post['proc'] == 'add'){
				// if(!$ary_DBdata['pic']){
				// 	echo '<script type="text/javascript">alert("請上傳圖片");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
				// 	exit;
				// }
				// $total_data = $obj_banner->fetch('count(*) total' , " type = '2' ");
				// $ary_DBdata['sort'] = ($total_data['total'] * 5 +200);

				// if($obj_banner->create($ary_DBdata)){
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
				$ary_data = $obj_banner->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_banner->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){

					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










