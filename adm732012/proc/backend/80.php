<?php 

			// echo '<pre>';
			// print_r($_FILES);
			// exit;

			$ary_DBdata = array(
								'acc' => $ary_post['acc']
			);
			if($_POST['pwd']){
				$ary_DBdata['pwd'] = shaThis($_POST['pwd']);
			}

			if($ary_post['proc'] == 'add'){

				if($obj_admin->create($ary_DBdata)){

					add_edit_recV2($ary_post['c'] ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succAdd&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}else if($ary_post['proc'] == 'edit'){
				$ary_data = $obj_admin->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_admin->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){

					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










