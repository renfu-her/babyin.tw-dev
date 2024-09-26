<?php

			$ary_DBdata = array(
								'title' => $ary_post['title']
			);


			if($ary_post['proc'] == 'add'){
				$total_data = $obj_article_category->fetch('count(*) total' , " pkey != '0' ");
				$ary_DBdata['sort'] = ($total_data['total'] * 5 +200);

				if($obj_article_category->create($ary_DBdata)){

					add_edit_recV2($ary_post['c'] ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succAdd&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}else if($ary_post['proc'] == 'edit'){
				$ary_data = $obj_article_category->fetch('*' , " pkey = '".$ary_post['pk']."' ");
				if($obj_article_category->edit($ary_DBdata , " pkey = '".$ary_post['pk']."' ")){


					add_edit_recV2($ary_post['c'] ,$ary_data ,$ary_DBdata);
					echo '
					<script type="text/javascript">
					parent.location.href="index.php?msg=succEdit&'.$_SESSION['redirectPageUrl'].'";
					</script>
					';
					exit;
				}
			}










