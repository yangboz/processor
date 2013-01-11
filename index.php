<?php
ini_set ( 'display_errors', 0 );
// 自动加载
function __autoload($className) {
	$path = 'lib/' . $className . '.php';
	if (file_exists ( $path )) {
		require_once $path;
		return;
	}
	$path = 'class/' . $className . '.php';
	if (file_exists ( $path )) {
		require_once $path;
		return;
	}
}
// 接收post数据
$data = isset ( $GLOBALS ["HTTP_RAW_POST_DATA"] ) ? $GLOBALS ["HTTP_RAW_POST_DATA"] : '';
if (empty ( $data )) {
	$data = file_get_contents ( 'php://input' );
}
// $data = new ByteArray ();
// $data->writeShort ( 2 ); // 协议号
// $data->writeInt ( 1 ); // id
// $data->writeString ( '222' ); // access
// $data->writeByte ( 1 );
// $data->writeString ( 'lovedna' );
// $data->writeString ( '123456' );
// 开始解析
require 'Service.php';
require 'Processor.php';
require 'Core.php';
require 'Config.php';
$processor = new Processor ();
$processor->input ( $data );
unset ( $processor );
echo Service::getMessage ();
?>
