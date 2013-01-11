<?php
// protocol short 协议号
// id int 用户id
// access string 验证
class Processor {
	public function input($data, $debug = 0) {
		$ba = new ByteArray ( $data );
		$ba->position = 0;
		if ($ba->bytesAvailable () == 0) {
			if ($debug == 1) {
				Service::pushMessage ( new Error ( 1, 'empty input' ) );
			}
			return;
		}
		$protocol = $ba->readShort ();
		$in = Protocol::getInput ( $protocol );
		if ($in === false) {
			if ($debug == 1) {
				Service::pushMessage ( new Error ( 2, 'not found input' . $protocol ) );
			}
			return;
		}
		// 用户id
		$id = $ba->readInt ();
		// 验证码
		$access = $ba->readString ();
		// 开妈验证登陆信息
		if ($this->check ( $protocol, $id, $access ) == false) {
			if ($debug == 1) {
				Service::pushMessage ( new Error ( 3, 'access error ' . $protocol ) );
			}
			return;
		}
		// /////////
		try {
			if ($in->decode ( new ByteArray ( $ba->readBytes () ) ) == false) {
				if ($debug == 1) {
					Service::pushMessage ( new Error ( 4, 'input' . $protocol . 'decode error' ) );
				}
				return;
			}
		} catch ( Exception $e ) {
			if ($debug == 1) {
				Service::pushMessage ( new Error ( 4, 'input' . $protocol . 'decode error' ) );
			}
			return;
		}
		$command = Protocol::getCommand ( $protocol );
		if ($command === false) {
			if ($debug == 1) {
				Service::pushMessage ( new Error ( 4, 'not found Command ' . $protocol ) );
			}
			return;
		}
		$command->execute ( $in );
	}
	private function check($protocol, $id, $access) {
		if ($protocol < 3) {
			return true;
		}
		$uid = dbService::getU_Id($id);
		if ($uid == null) {
			return false;
		}
		$userid = new Uid();
		Service::copy ( $uid, $userid );
		if ($userid->access != $access) {
			return false;
		}
		return true;
	}
}
?>