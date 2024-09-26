<?php

			$ary_DBdata = array(
								'title' => $ary_post['title'],
								'data_pkey' => $ary_post['data_pkey']
			);


			if($ary_post['proc'] == 'add'){
				$total_data = $obj_category->fetch('count(*) total' , " data_pkey = '".$ary_post['data_pkey']."' ");
				$ary_DBdata['sort'] = ($total_data['total'] * 5 +200);

				if($obj_category->create($ary_DBdata)){

					add_edit_recV2($ary_post['c'] ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succAdd&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}else if($ary_post['proc'] == 'edit'){
				$ary_data = $obj_category->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_category->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){


					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










