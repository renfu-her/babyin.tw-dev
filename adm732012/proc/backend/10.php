<?php 

			// echo '<pre>';
			// print_r($_FILES);
			// exit;

			$ary_DBdata = array(
								'data_pkey' => $ary_post['data_pkey'],
								'title' => $ary_post['title'],
								'subtitle' => $ary_post['subtitle'],
								'org_price' => $ary_post['org_price'],
								'price' => $ary_post['price'],
								'check1' => $ary_post['check1'],
								'check2' => $ary_post['check2']
			);
			$ary_DBdata['info'] = safe(strip_magic_slashes($_POST['info']));

			if($_POST['select1']){
				foreach($_POST['select1'] as $value){
					$ary_DBdata['select1'] .= safe($value).',';
				}
			}else{
				$ary_DBdata['select1'] = '';
			}

			if($_FILES['listpic']['error'] == 0){
				$banner = pic_upload_proc($_FILES['listpic']['name'], $_FILES['listpic']['tmp_name'] ,'268' ,'294');
				if($banner == 'sizeErr'){
					echo '<script type="text/javascript">alert("列表圖片尺寸錯誤");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
					exit;
				}
				$ary_DBdata['listpic'] = $banner;
			}

			foreach($_FILES['pic']['error'] as $key => $value){
				if($value == 0){
					$pic = pic_upload_proc($_FILES['pic']['name'][$key], $_FILES['pic']['tmp_name'][$key] ,'460' ,'346');
					if($pic == 'sizeErr'){
						echo '<script type="text/javascript">alert("產品圖片尺寸錯誤");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
						exit;
					}
					$ary_picData[] = $pic;
				}
			}


			if($ary_post['proc'] == 'add'){
				if(!$ary_DBdata['listpic']){
					echo '<script type="text/javascript">alert("請上傳列表圖片");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
					exit;
				}
				$total_data = $obj_products->fetch('count(*) total' , " data_pkey = '".$ary_post['data_pkey']."' ");
				$ary_DBdata['sort'] = ($total_data['total'] * 5 +200);

				if($obj_products->create($ary_DBdata)){
					$data_pkey = $mydb->InsertId();

					if($ary_picData){
						$picTotal = count($ary_picData) * 100;
						foreach($ary_picData as $value){
							$ary_DBdataPic['data_pkey'] = $data_pkey;
							$ary_DBdataPic['pic'] = $value;
							$ary_DBdataPic['sort'] = $picTotal;
							$obj_products_pic->create($ary_DBdataPic);
							$picTotal -= 10;
							$ary_DBdata['pic'][] = $ary_DBdataPic;
						}
					}

					add_edit_recV2($ary_post['c'] ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succAdd&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}else if($ary_post['proc'] == 'edit'){
				$ary_data = $obj_products->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_products->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){

					if($ary_picData){
						$total_data = $obj_products_pic->fetch('count(*) total' , " data_pkey = '".$ary_post['pk']."' ");
						$picTotal = ($total_data['total'] * 500 +200);

						foreach($ary_picData as $value){
							$ary_DBdataPic['data_pkey'] = $ary_post['pk'];
							$ary_DBdataPic['pic'] = $value;
							$ary_DBdataPic['sort'] = $picTotal;
							$obj_products_pic->create($ary_DBdataPic);
							$picTotal -= 10;
							$ary_DBdata['pic'][] = $ary_DBdataPic;
						}
					}


					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










