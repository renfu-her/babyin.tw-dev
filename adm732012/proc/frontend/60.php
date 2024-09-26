<?php

		if($ary_get['proc'] == 'add'){

		}else if($ary_get['proc'] == 'edit'){
			$ary_data = $obj_news->fetch('*' , " pkey = '".$ary_get['pk']."' ");
		}


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

				$('input[name="newsdate"]').datetimepicker({
					format: 'YYYY-MM-DD'
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
					<label class="control-label col-md-3 col-sm-3 col-xs-12">標題</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="title" type="text" class="form-control" placeholder="" value="<?=$ary_data['title']?>" autocomplete="off" maxlength="15" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">副標題</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="des" type="text" class="form-control" placeholder="" value="<?=$ary_data['des']?>" autocomplete="off" maxlength="25">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">圖片 359x398</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="pic" type="file" class="form-control" value="" accept="image/*" >
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">內文</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<textarea name="info" id="editor1" ><?php  echo $ary_data['info']?></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">日期</label>
					<div class="col-md-9 col-sm-9 col-xs-12">
						<input name="newsdate" type="text" class="form-control" placeholder="" value="<?=$ary_data['newsdate']?$ary_data['newsdate']:date('Y-m-d');?>" autocomplete="off" >
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







