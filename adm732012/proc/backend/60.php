<?php

			// echo '<pre>';
			// print_r($_FILES);
			// exit;

			$ary_DBdata = array(
								'title' => $ary_post['title'],
								'des' => $ary_post['des'],
								'newsdate' => $ary_post['newsdate'],
								'is_brand' => '0'
			);
			$ary_DBdata['info'] = safe(strip_magic_slashes($_POST['info']));


			if($_FILES['pic']['error'] == 0){
				$banner = pic_upload_proc($_FILES['pic']['name'], $_FILES['pic']['tmp_name'] ,'359' ,'398');
				if($banner == 'sizeErr'){
					echo '<script type="text/javascript">alert("列表圖片尺寸錯誤");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
					exit;
				}
				$ary_DBdata['pic'] = $banner;
			}


			if($ary_post['proc'] == 'add'){
				if(!$ary_DBdata['pic']){
					echo '<script type="text/javascript">alert("請上傳列表圖片");parent.location.href="index.php?msg=err&'.$_SESSION['redirectPageUrl'].'";</script>';
					exit;
				}

				if($obj_news->create($ary_DBdata)){
					$data_pkey = $mydb->InsertId();

					add_edit_recV2($ary_post['c'] ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succAdd&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}else if($ary_post['proc'] == 'edit'){
				$ary_data = $obj_news->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_news->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){

					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










