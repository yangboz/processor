<?php
class Error extends \Message {
	public $id;
	public $msg;
	public function __construct($id,$msg){
		$this->id=$id;
		$this->msg=$msg;
	}
	public function encode(){
		$data=new ByteArray();
		$data->writeByte($this->id);
		$data->writeString($this->msg);
		return $data;
	}
}

?>