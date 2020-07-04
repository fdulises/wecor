<?php
	function randomHash( $hash = 'md5' ){
		if(is_callable('openssl_random_pseudo_bytes'))
			$randomString = openssl_random_pseudo_bytes(16);
		else $randomString = mt_rand(1, mt_getrandmax());

		return hash( $hash, $randomString );
	}

	function sha512Validate($cadena){
		if( (strlen($cadena) == 128) && ctype_xdigit($cadena) ) return 1;
		return 0;
	}

	function createPassConfig($pass){
		$data = [];
		$data['salt'] = randomHash( 'sha512' );
		if( !sha512Validate($pass) ) $pass = hash('sha512', $pass);
		$data['pass'] = hash('sha512',$pass.$data['salt']);
		return $data;
	}
