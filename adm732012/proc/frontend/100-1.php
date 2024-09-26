<?php

		if($ary_get['proc'] == 'add'){

		}else if($ary_get['proc'] == 'edit'){
			$ary_data = $obj_order->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$js_city = '$(\'select[name="invoiceCity"] option[value="'.$ary_data['invoiceCity'].'"]\').attr("selected",true);$(\'select[name="invoiceCity"]\').change();$(\'select[name="invoiceDistrict"] option[value="'.$ary_data['invoiceDistrict'].'"]\').attr("selected",true);';
		}


?>

		<script src="js/ckeditor/ckeditor.js"></script>
		<script src="js/city.js"></script>
		<script type="text/javascript">
			function checkform () {
				return true;
			}
			$(function(){


				var htmlOption_dist;


				$('select[name="invoiceCity"]').change(function(){
					if($('select[name="invoiceCity"] option:selected').val() != '0'){
						var fthis = $(this);
						htmlOption_dist = '<option value="0">請選擇</option>';
						city[fthis.find('option:selected').index()].forEach(function(item, index, array){
							htmlOption_dist += '<option value="'+item+'">'+item+'</option>';
						});
						$('select[name="invoiceDistrict"]').html(htmlOption_dist);
					}
				});


				<?=$js_city?>


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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">發票</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name="invoice" class="form-control">
							<option value="1" <?=($ary_data['invoice']=='1')?'selected="selected"':'';?>>公益捐贈</option>
							<option value="2" <?=($ary_data['invoice']=='2')?'selected="selected"':'';?>>二聯式</option>
							<option value="3" <?=($ary_data['invoice']=='3')?'selected="selected"':'';?>>三聯式</option>
						</select>
					</div>
				</div>


				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">縣市</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" name="invoiceCity">
							<option value="0">請選擇</option>
							<option value="基隆巿">基隆巿</option>
							<option value="臺北市">臺北市</option>
							<option value="新北市">新北市</option>
							<option value="桃園市">桃園市</option>
							<option value="新竹市">新竹市</option>
							<option value="新竹縣">新竹縣</option>
							<option value="宜蘭縣">宜蘭縣</option>
							<option value="苗栗縣">苗栗縣</option>
							<option value="臺中市">臺中市</option>
							<option value="彰化縣">彰化縣</option>
							<option value="南投縣">南投縣</option>
							<option value="雲林縣">雲林縣</option>
							<option value="嘉義巿">嘉義巿</option>
							<option value="嘉義縣">嘉義縣</option>
							<option value="臺南市">臺南市</option>
							<option value="高雄巿">高雄巿</option>
							<option value="屏東縣">屏東縣</option>
							<option value="花蓮縣">花蓮縣</option>
							<option value="臺東縣">臺東縣</option>
							<option value="連江縣">連江縣</option>
							<option value="金門縣">金門縣</option>
							<option value="澎湖縣">澎湖縣</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">鄉鎮市區</label>
					<div class="col-md-9 col-sm-9 col-xs-12" >
						<select class="form-control" name="invoiceDistrict">
							<option value="0">請選擇</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">地址</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="invoiceAddr" type="text" class="form-control" placeholder="" value="<?=$ary_data['invoiceAddr']?>" autocomplete="off" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">發票抬頭</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="invoiceTitle" type="text" class="form-control" placeholder="" value="<?=$ary_data['invoiceTitle']?>" autocomplete="off">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">發票統編</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="invoiceTaxid" type="text" class="form-control" placeholder="" value="<?=$ary_data['invoiceTaxid']?>" autocomplete="off">
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







