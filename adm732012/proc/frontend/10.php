<?php

		if($ary_get['proc'] == 'add'){

		}else if($ary_get['proc'] == 'edit'){
			$ary_data = $obj_products->fetch('*' , " pkey = '".$ary_get['pk']."' ");
		}


		$ary_category = $obj_category->fetchAll('*' , " data_pkey = '0' order by sort DESC ");
		foreach($ary_category as $value){
			$ary_subCategory = $obj_category->fetchAll('*' , " data_pkey = '".$value['pkey']."' order by sort DESC ");
			foreach($ary_subCategory as $value2){
				$optionSelected = $value2['pkey']==$ary_data['data_pkey']?'selected="selected"':'';
				$categoryOption .= '<option value="'.$value2['pkey'].'" '.$optionSelected.'>'.$value['title'].'-'.$value2['title'].'</option>';
			}
		}


		$ary_prodSpec = explode(',', $ary_data['select1']);
		foreach($ary_prodSpec as $value){
			$ary_prodSpecRe[$value] = '1';
		}

		$ary_spec = $obj_products_select->fetchAll_join('*' , " order by sort DESC ");

		foreach($ary_spec as $value){
			$optionSelected4 = $ary_prodSpecRe[$value['pkey']] == '1' ? 'checked' : '';
			$optionCategory4 .= '<label><input type="checkbox" name="select1[]" value="'.$value['pkey'].'" '.$optionSelected4.'> '.$value['title'].'　</label>';
		}

		// $ary_prodTag = $obj_banner->fetch('*' , " type = '4' ");
		// $ary_page['html']['prodTag'] = $ary_prodTag['title'];
		$ary_tag = $obj_banner->fetchAll('*' , " type = '4' ");


?>

		<script src="js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
			function checkform () {
				if($('input[name="title"]').val() == ''){
					alert('請填寫標題');
					return false;
				}else{
					return true;
				}
			}
			$(function(){


				CKEDITOR.replace( 'editor1',{
					width:'100%',
					height:'400px'
				});

				CKEDITOR.on('dialogDefinition', function( ev ){
					var dialogName = ev.data.name;  
					var dialogDefinition = ev.data.definition;
						 
				});


				$('.addPicItem').click(function(){
					$('.picItem').append('<div class="form-group"><label class="control-label col-md-3 col-sm-3 col-xs-12" style="font-weight:normal;color:#797979;"></label><div class="col-md-9 col-sm-9 col-xs-12"><input name="pic[]" type="file" class="form-control" value="" accept="image/*" ></div></div>');
				});



			});
		</script>
		<style>

			@media (max-width: 767px) {
				.col-xs-12 {
					margin-top:5px;
				}
			}

		</style>

		<div class="col-md-12 col-sm-12 col-xs-12"><div class="x_panel" style="height: auto;"><div class="x_title">
			<h2><small></small></h2>
			<div class="clearfix"></div></div><div class="x_content"><br />
			
			<form class="form-horizontal form-label-left" method="post" action="proc.php" enctype="multipart/form-data" onsubmit="return checkform();">

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">分類</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" name="data_pkey">
							<?=$categoryOption?>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">標題</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="title" type="text" class="form-control" placeholder="" value="<?=$ary_data['title']?>" autocomplete="off" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">副標題</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="subtitle" type="text" class="form-control" placeholder="" value="<?=$ary_data['subtitle']?>" autocomplete="off" maxlength="18">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">列表圖片 268x294</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="listpic" type="file" class="form-control" value="" accept="image/*" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">產品圖片 460x346</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<button type="button" class="btn btn-round btn-info btn-xs addPicItem" style="float: right; margin-top: 11px;">新增</button>
					</div>
				</div>
				<div class="picItem">
					<div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" style="font-weight:normal;color:#797979;">
						</label>
						<div class="col-md-9 col-sm-9 col-xs-12">
							<input name="pic[]" type="file" class="form-control" value="" accept="image/*" >
						</div>

					</div>
				</div>





				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">原價</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="org_price" type="text" class="form-control" placeholder="" value="<?=$ary_data['org_price']?>" autocomplete="off" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">現金價</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="price" type="text" class="form-control" placeholder="" value="<?=$ary_data['price']?>" autocomplete="off" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">預購</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" name="check1">
							<option value="1" <?=$ary_data['check1']=='1'?'selected="selected"':'';?>>是</option>
							<option value="0" <?=$ary_data['check1']=='0'?'selected="selected"':'';?>>否</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">產品標籤</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" name="check2">
							<option value="0" <?=$ary_data['check2']=='0'?'selected="selected"':'';?>>無</option>
							<?php 								foreach($ary_tag as $value){
									$htmlSelected = $ary_data['check2']==$value['pkey']?'selected="selected"':'';
									echo '<option value="'.$value['pkey'].'" '.$htmlSelected.' >'.$value['title'].'</option>';
								}
							?>
							
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">規格</label>
					<div class="col-md-9 col-sm-9 col-xs-12" style="padding-top:8px;">
						<?=$optionCategory4?>
					</div>
				</div>



				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">內文</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="info" id="editor1" ><?php  echo $ary_data['info']?></textarea>
					</div>
				</div>



				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
						<button type="submit" class="btn btn-danger" style="float: right;">送出</button>
					</div>
				</div>


				<input name="c" type="hidden" value="<?php  echo $ary_get['c']?>" />
				<input name="d" type="hidden" value="<?php  echo $ary_get['d']?>" />
				<input name="proc" type="hidden" value="<?php  echo $ary_get['proc']?>" />
				<input name="pk" type="hidden" value="<?php  echo $ary_get['pk']?>" />
				<input name="self_post" type="hidden" value="33" />

			</form>

		</div></div></div>







