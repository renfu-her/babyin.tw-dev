<?php

			// echo '<pre>';
			// print_r($_FILES);
			// exit;

			$ary_DBdata = array(
								'title' => $ary_post['title'],
								'type' => '4'
			);

			if($ary_post['proc'] == 'add'){

				if($obj_banner->create($ary_DBdata)){
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










