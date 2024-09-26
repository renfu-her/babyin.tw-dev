<?php
/*
Class： 
  MyDB

Extends：
  none

Attributes:
  none

Operators:
  建構式->建立與MySQL的連線，以及設定語系。
  Resource SqlQuery(string sql)->執行SQL語法。
  Resource FetchObj(string sql)->傳回一個SQL執行物件。
  Resource FetchAry(string sql)->傳回一個SQL執行陣列。
  Int NumRows(resource query)->傳回執行總筆數。
  Int NumFields(resource query)->傳回欄位總數。
  Int FieldsName(resource query)->傳回欄位名稱。
  Booleen DataSeek(resource query,int int)->傳回一個SQL執行的結果且將指標移至int。
  String Safe(string data)->跳脫特殊字元。
  Int InsertId(string sql)->傳回上一筆寫入資料庫的Id。
  解構式->關閉與MySQL的連線。
*/


class MyDB{
  
  
  function MyDB($host , $db , $user , $pass , $charset = 'utf8'){
  
    mysql_connect($host , $user , $pass);
    mysql_select_db($db);
    
    $this->SqlQuery('SET NAMES ' . $charset);
    
  }
  
  
  
  function SqlQuery($sql){

	return mysql_query($sql);
  
  }
  
  
  function FetchObj($sql){//in fact, type of $sql is 'resource'
    
    return mysql_fetch_object($sql);
  
  }
  
  
  function FetchAry($sql){
    
    return mysql_fetch_array($sql , MYSQL_ASSOC);
    
  }
  
  
  function NumRows($query){
    
    return mysql_num_rows($query);
  
  }
  
  
  function NumFields($query){
    
    return mysql_num_fields($query);
  
  }
  
  
  function FieldName($query , $int){
    
    return mysql_field_name($query , $int);
  
  }
  
  
  function DataSeek($query , $int){
    
    return mysql_data_seek($query , $int);
  
  }
  
  
  function Safe($content){  
    
	//如果magic_quotes_gpc=Off，那么就开始处理
	if (!get_magic_quotes_gpc()) {
	//判断$content是否为数组
		if (is_array($content)) {
		//如果$content是数组，那么就处理它的每一个单无
			foreach ($content as $key=>$value) {
				$content[$key] = mysql_real_escape_string($value);
			}
		}else{
		//如果$content不是数组，那么就仅处理一次
			mysql_real_escape_string($content);
		}
	}else{
		//如果magic_quotes_gpc=On，那么就不处理
	}
	//返回$content
	return $content;	
	
    //return mysql_real_escape_string($content);
  
  }
  
  
  function InsertId(){
    
    return mysql_insert_id();
  
  }
  
  
  function __destruct(){
    
    mysql_close()or die(mysql_error());
  
  }
  

  
}
?>
