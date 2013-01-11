<?php
class Command2 extends \Command {
	public function execute(Message $data) {
		$in = new In2 ();
		Service::copy ( $data, $in );
		if ($in->type == 1) {
			// ×¢²á
			$this->reg ( $in );
		} else if ($in->type == 0) {
			// µÇÂ½
			$this->login ( $in );
		}
	}
	private function reg(In2 $in) {
		$out = new MessageLogin ();
		$uid = $in->uid;
		$crc = Service::getCrc ( $uid );
		
		$info = dbService::getU_account($crc);
		$access = '';
		if ($info == null) {
			$id = ( int ) Service::cinc ( Config::counter_u_id );
			if (dbService::getU_Id($id) == null) {
				$access = Service::getCrc ( $uid . Service::getTime () );
				$uid = new Uid();
				$uid->id = $id;
				$uid->access = $access;
				$uid->crc = $crc;
				dbService::setU_id($uid);
				$u = new Uaccount();
				$u->uid = $in->uid;
				$u->pass = $in->pass;
				$u->id = $id;
				dbService::setU_account($u);
				$msg = 'reg success ' . $access;
			} else {
				$msg = 'reg error ' . $id;
			}
		} else {
			$msg = 'reg error ' . $in->uid . ',' . $in->pass;
		}
		$out->msg = $msg;
		$out->id = $id;
		$out->access = $access;
		Service::pushMessage ( $out );
	}
	private function login(In2 $in) {
		// iconv( 'gb2312','utf-8', 'µÇÂ½³É¹¦')
		$out = new MessageLogin ();
		$uid = $in->uid;
		$crc = Service::getCrc ( $uid );
		$info = dbService::getU_account($crc);
		if ($info == null) {
			$msg = 'login error uid ' . $in->uid;
		} else {
			$u = new Uaccount ();
			Service::copy ( $info, $u );
			if ($u->pass == Service::getCrc ( $in->pass )) {
				$id = $u->id;
				$access = Service::getCrc ( $uid . Service::getTime () );
				$uid = new Uid();
				$uid->access = $access;
				$uid->crc = $crc;
				$uid->id = $id;
				dbService::setU_id($uid);
				$msg = 'login ok ';
			} else {
				$msg = 'login pass error';
			}
		}
		$out->msg = $msg;
		$out->id = $id;
		$out->access = $access;
		Service::pushMessage ( $out );
	}
}
?>