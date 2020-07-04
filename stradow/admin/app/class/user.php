<?php

	namespace wecor;

	/*
	*	Clase de la capa logica para usuarios
	*
	*	Permite relaizar transacciones con usuarios
	*/
	class user{

		use paginaraux;

		public static $error = [];

		/*
		* Metodo Para crear elemento
		*/
		public static function createUser( $data = [] ){
			$predata = [
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
			];

			$data = array_merge($data, $predata);

			$result = DB::insert('users')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();
				event::fire( 'userCreated', $data );
				return $insertId;
			}
			return 0;
		}
		public static function createProfile( $data = [] ){
			$result = DB::insert('profiles')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();
				event::fire( 'userProfileCreated', $data );
				return $insertId;
			}
			return 0;
		}

		/*
		* Metodo Para editar elemento por su id
		*/
		public static function update( $id, $data ){
			$predata = ['updated' => date('Y-m-d H:i:s')];
			$data = array_merge($data, $predata);
			$result = DB::update('users u')->leftJoin('profiles up', 'u.id', '=', 'up.id')
				->set($data)
				->where('u.id', '=', $id)
				->send();

			$data['id'] = $id;
			event::fire( 'userUpdated', $data );

			return $result;
		}

		/*
		* Metodo Para eliminar elemento por su id
		*/
		public static function delete( $id ){
			return DB::delete('users')
				->set($data)
				->where('id', '=', $id)
				->send();
		}

		/*
		* Metodo Para recuperar datos de un usuario
		*/
		public static function get( $data = array() ){
			$resultado = DB::select('users u')->leftJoin('profiles up', 'u.id', '=', 'up.id');

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);
			if( isset($data['email']) ) $resultado->where('email', '=', $data['email']);
			if( isset($data['nickname']) ) $resultado->where('nickname', '=', $data['nickname']);
			if( isset($data['id']) ) $resultado->where('u.id', '=', $data['id']);
			$resultado->where('state', '>', 0);
			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select('users')->where('state', '!=', 0);
			if( isset($data['columns']) ) $resultado->columns($data['columns']);

			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);

			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}

		/*
		* Metodo Para verificar que se halla iniciado sesion
		*/
		public static function loginCheck(){
			static $check = null;
			if( is_null($check) ){
				if( isset( $_SESSION[S_USERID],$_SESSION[S_USERNAME],$_SESSION[S_STRING] ) ){
					$result = DB::select('users')
						->columns('password')
						->where( 'id', '=', $_SESSION[S_USERID] )
						->where( 'state', '=', 1 )
						->first();
					if( $result ){
						$token = hash('sha512',$result['password'].$_SERVER['HTTP_USER_AGENT']);
						if( $token === $_SESSION[S_STRING] ) $check = 1;
					}
				}
			}
			return $check;
		}


		public static function access($data){
			$userData = DB::select('users')->columns([
				'id','nickname','email','password','salt'
			])->where('state','=',1);
			$filter = filter_var($data['usuario'],FILTER_VALIDATE_EMAIL);
			if( $filter ) $userData->where('email','=',$data['usuario']);
			else $userData->where('nickname','=',$data['usuario']);
			$userData = $userData->first();

			if( $userData ){
				$password = hash('sha512',$data['clave'].$userData['salt']);
				if( $password === $userData['password'] ){
					return self::login([
						'id'=>$userData['id'],
						'nickname'=>$userData['nickname'],
						'email'=>$userData['email'],
						'clave'=>$userData['password'],
					]);
				}else self::$error[] = "clave_incorrecta";
			}else self::$error[] = "usuario_inexistente";
			return 0;
		}

		/*
		* Metodo para establecer sesion como iniciada
		*/
		public static function login($datos){
			$_SESSION[S_USERID] = $datos['id'];
			$_SESSION[S_USERNAME] = $datos['nickname'];
			$_SESSION[S_USERMAIL] = $datos['email'];
			$_SESSION[S_STRING] = hash(
				'sha512', $datos['clave'].$_SERVER['HTTP_USER_AGENT']
			);
			return 1;
		}

		/*
		* Metodo para cifrado de contraseña
		*/
		public static function createPassConfig($pass){
			$data = [];
			$data['salt'] = encrypt::randomHash( 'sha512' );
			if( !encrypt::sha512Validate($pass) ) $pass = hash('sha512', $pass);
			$data['pass'] = hash('sha512',$pass.$data['salt']);
			return $data;
		}

		/*
		* Metodo para validacion de nickname
		*/
		private static function nicknameValidate($data){
			if( preg_match('/^[a-zA-Z0-9\-_]{4,16}$/', $data) ) return 1;
			else self::$error[] = "nickname_error";
			return 0;
		}

		/*
		* Metodo para validacion de email
		*/
		private static function emailValidate($data){
			if( filter_var($data,FILTER_VALIDATE_EMAIL) ) return 1;
			else self::$error[] = "email_error";
			return 0;
		}

		/*
		* Metodo para validacion de grupo de usuario
		*/
		private static function roleValidate($data){
			foreach( $GLOBALS['groups'] as $v ){
				if( $v['id'] == $data ) return 1;
			}
			self::$error[] = "role_error";
			return 0;
		}

		/*
		* Metodo para verificar existencia de usuario
		*/
		private static function userExists($data){
			$info = [];
			$result = DB::select('users')
				->columns([
					'id','nickname','email'
				])
				->where('state','>',0)
				->where(function($query) use($data){
					$query
						->orWhere('email','=',$data['email'])
						->orWhere('nickname','=',$data['nickname']);
				})->first();
			if( $result ){
				if( $result['email'] == $data['email'] ){
					self::$error[] = 'email_duplicated';
					$info[] = 'email';
				}
				if( $result['nickname'] == $data['nickname'] ){
					self::$error[] = 'nickname_duplicated';
					$info[] = 'nickname';
				}
			}
			return $info;
		}


		public static function register( $data ){

			//Validamos los datos del usuario
			$validemail = self::emailValidate($data['email']);
			$validnickname = self::nicknameValidate($data['nickname']);
			$validrole = self::roleValidate($data['role']);

			if( $validemail && $validnickname && $validrole ){

				//Validamos que el nickname y el email no se encuentren registrados
				$userExists = self::userExists([
					'email' => $data['email'],
					'nickname' => $data['nickname'],
				]);

				if( !count($userExists) ){
					$passconfig = self::createPassConfig($data['password']);

					//Creamos el perfil del usuario
					$result = self::createProfile([
						'name' => $data['name'],
						'descrip' => $data['descrip'],
						'social' => $data['social'],
					]);
					//Si se creo el perfil insertamos los datos principales
					if( $result ) return self::createUser([
						'id' => $result,
						'nickname' => $data['nickname'],
						'email' => $data['email'],
						'password' => $passconfig['pass'],
						'salt' => $passconfig['salt'],
						'role' => $data['role'],
						'state' => 1,
					]);
				}

			}

			return 0;
		}
		public static function passchange($data){
			$passconfig = self::createPassConfig($data['password']);
			return self::update( $data['id'], [
				'password' => $passconfig['pass'],
				'salt' => $passconfig['salt'],
			]);
		}
	}
