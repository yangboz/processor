<?php
class Config {
	//保存用户最大数量
	const counter_u_id = 'game.u.counter';
	const suffix_u_id = '.u.id';
	const suffix_u_account = '.u.account';
}
class Protocol {
	public static $class;
	public static $command;
	public static $id;
	public static function getInput($protocol) {
		$arr = &self::$class;
		if ($arr == null) {
			$arr = array ();
			//
			$arr [1] = 'In1';
			$arr [2] = 'In2';
			//
			self::$class = $arr;
		}
		if (isset ( $arr [$protocol] )) {
			$name = $arr [$protocol];
			$path = 'input/' . $name . '.php';
			if (file_exists ( $path )) {
				require_once $path;
			}
			return new $name ();
		}
		return false;
	}
	public static function getCommand($protocol) {
		$arr = &self::$command;
		if ($arr == null) {
			$arr = array ();
			//
			$arr [1] = 'Command1';
			$arr [2] = 'Command2';
			//
			self::$command = $arr;
		}
		if (isset ( $arr [$protocol] )) {
			$name = $arr [$protocol];
			$path = 'command/' . $name . '.php';
			if (file_exists ( $path )) {
				require_once $path;
			}
			return new $name ();
		}
		return false;
	}
	public static function getProtocol($name) {
		$arr = &self::$id;
		if ($arr == null) {
			$arr = array ();
			//
			$arr ['Error'] = 65535;
			$arr ['TestServer_1'] = 1;
			$arr ['MessageLogin'] = 2;
			//
			self::$id = $arr;
		}
		if (isset ( $arr [$name] )) {
			$name = $arr [$name];
			return $name;
		}
		return false;
	}
}

?>