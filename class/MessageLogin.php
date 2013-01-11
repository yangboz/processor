<?php
class MessageLogin extends \Message {
	public $msg;
	public $id;
	public $access;
	public function encode(){
		$data=new ByteArray();
		$data->writeString($this->msg);
		$data->writeInt($this->id);
		$data->writeString($this->access);
		return $data;
	}
}

?>