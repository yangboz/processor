<?php
//ตวยฝ
class In2 extends \Message {
	public $type;
	public $uid;
	public $pass;
	public function decode(ByteArray $data){
		$this->type=$data->readByte();
		$this->uid=$data->readString();
		$this->pass=$data->readString();
		return true;
	}
}
?>