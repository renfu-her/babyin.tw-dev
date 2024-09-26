<?php

		if($ary_get['proc'] == 'add'){

		}else if($ary_get['proc'] == 'edit'){
			$ary_data = $obj_order->fetch('*' , " pkey = '".$ary_get['pk']."' ");
			$ary_list = $obj_order_list->fetchAll('*' , " data_pkey = '".$ary_get['pk']."' ");
			$ary_user = $obj_member->fetch('*' , " pkey = '".$ary_data['data_pkey']."' ");
			$js_city = '$(\'select[name="city"] option[value="'.$ary_data['city'].'"]\').attr("selected",true);$(\'select[name="city"]\').change();$(\'select[name="district"] option[value="'.$ary_data['district'].'"]\').attr("selected",true);';
		}


?>

		<script src="js/ckeditor/ckeditor.js"></script>
		<script src="js/city.js"></script>
		<script type="text/javascript">
			function checkform () {
				return true;
			}
			$(function(){


				$('input[name="birthday"]').datetimepicker({
					format: 'YYYY-MM-DD'
				});


				var htmlOption_dist;


				$('select[name="city"]').change(function(){
					if($('select[name="city"] option:selected').val() != '0'){
						var fthis = $(this);
						htmlOption_dist = '<option value="0">請選擇</option>';
						city[fthis.find('option:selected').index()].forEach(function(item, index, array){
							htmlOption_dist += '<option value="'+item+'">'+item+'</option>';
						});
						$('select[name="district"]').html(htmlOption_dist);
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
					<div class="col-md-12 col-sm-12 col-xs-12">
							<table style="width: 95%;font-size: 12px;margin: 15px auto 35px;">
								<tr>
									<td colspan="10">訂單時間：<?=$ary_data['createdate']?></td>
								</tr>
								<tr>
									<td colspan="10">訂單編號：<?=date('Ymd',strtotime($ary_data['createdate'])) . str_pad($ary_data['pkey'],6,'0',STR_PAD_LEFT) ?></td>
								</tr>
								<tr>
									<td colspan="10">會員帳號：<?=$ary_user['email']?></td>
								</tr>
								<tr>
									<td colspan="10">會員名稱：<?=$ary_user['uname']?></td>
								</tr>
								<tr>
									<td colspan="10">購買金額：<?=$ary_data['total']?></td>
								</tr>
								<tr>
									<td>　</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<tr style="background-color: #dbdbdb;">
									<td></td>
									<td>產品名稱</td>
									<td>數量</td>
									<td>單價</td>
									<td>小計</td>
								</tr>
								<?php 									foreach($ary_list as $value){
										$ary_prod = $obj_products->fetch('*' , " pkey = '".$value['prod_pkey']."' ");
										echo '
								<tr>
									<td><img src="'.$ary_config['websiteUrl'].'uploads/'.$ary_prod['listpic'].'" height="90px"></td>
									<td>'.$value['prod_title'].' '.$value['s1_title'].' '.$value['s2_title'].'</td>
									<td>'.$value['total'].'</td>
									<td>'.$value['price'].'</td>
									<td>'.($value['total']*$value['price']).'</td>
								</tr>
										';
									}
								?>
								<tr>
									<td></td>
									<td></td>
									<td>運費 : <?=$ary_data['shippingfee']?></td>
									<td>小計 : <?=($ary_data['total']-$ary_data['shippingfee'])?></td>
									<td>總計 : <?=$ary_data['total']?></td>
								</tr>
							</table>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人姓名</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="uname" type="text" class="form-control" placeholder="" value="<?=$ary_data['uname']?>" autocomplete="off" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人電話</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="tel" type="text" class="form-control" placeholder="" value="<?=$ary_data['tel']?>" autocomplete="off">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人性別</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select name="gender" class="form-control">
							<option value="1" <?=($ary_data['gender']=='1')?'selected="selected"':'';?>>男</option>
							<option value="2" <?=($ary_data['gender']=='2')?'selected="selected"':'';?>>女</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人縣市</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<select class="form-control" name="city">
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人鄉鎮市區</label>
					<div class="col-md-9 col-sm-9 col-xs-12" >
						<select class="form-control" name="district">
							<option value="0">請選擇</option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人地址</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="addr" type="text" class="form-control" placeholder="" value="<?=$ary_data['addr']?>" autocomplete="off" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">收件人匯款帳號</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="bankaccount" type="text" class="form-control" placeholder="" value="<?=$ary_data['bankaccount']?>" autocomplete="off">
					</div>
				</div>

				<?php 					if($ary_data['payment'] == 1 || $ary_data['payment'] == 2){
				?>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">訂單狀態</label>
					<div class="col-md-9 col-sm-9 col-xs-12" >
						<select class="form-control" name="status">
						<?php 							foreach($ary_config['orderStatus'] as $key => $value){
								$optionSelected = ($ary_data['status'] == $key) ? 'selected="selected"' : '';
								echo '<option value="'.$key.'" '.$optionSelected.' >'.$value['title'].'</option>';
							}
						?>
						</select>
					</div>
				</div>

				<?php 					}
				?>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">備註</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="info" id="editor1" class="form-control"><?php  echo $ary_data['info']?></textarea>
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







