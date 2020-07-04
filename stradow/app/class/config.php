<?php

	namespace wecor;

	abstract class config{

		private static $info = [];

		public static function get( $data = [] ){
			if( empty($data) ){
				if(empty(self::$info)){
					$result = DB::select('config')->columns('name, value')
						->where('autoload', '=', '1')->get();
					foreach ($result as $v) {
						self::$info[$v['name']] = $v['value'];
					}
				}
				return self::$info;
			}else{
				if( is_array($data) ){
					$dataresult = [];
					$missingresult = [];
					foreach ($data as $v) {
						if( isset(self::$info[$v]) ) $dataresult[$v] = self::$info[$v];
						else $missingresult[] = "name='$v'";
					}
					if( $missingresult ){
						$result = DB::select('config')->columns('value')
							->where(implode(' or ', $missingresult))->get();
						foreach ($result as $v) {
							$dataresult[$v['name']] = $v['value'];
							self::$info[$v['name']] = $v['value'];
						}
					}
					return $dataresult;
				}else{
					if( isset(self::$info[$data]) ) return self::$info[$data];
					else{
						$result = DB::select('config')->columns('value')
							->where("name='$data'")->first();
						if( $result ){
							self::$info[$data] = $result['value'];
							return $result['value'];
						}
					}
				}
			}
			return false;
		}

		public static function set( $name, $value = '', $auto = 0 ){
			if( is_array($name) ){
				foreach ($name as $k => $v) self::set($k, $v);
			}else{
				if( isset(self::$info[$name]) ) self::$info[$name] = $value;
				$actual = DB::select('config')->columns('value')->where("name='$name'")->first();
				if( $actual ) $result = DB::update('config')->set("value='$value'")
				->where('name', '=', $name)->send();
				else $result = DB::insert('config')->columns(['name','value'])
				->values([$name, $value])->send();
			}
			return true;
		}

		public static function delete( $data ){
			if(is_array($data)){
				foreach ($data as $v) self::delete($v);
			}else{
				$result = DB::delete('config')->where('name', '=', $data)->send();
				if( $result ) if( isset(self::$info[$data]) ) unset(self::$info[$data]);
			}
		}

	}
