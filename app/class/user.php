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

		/*
		* Metodo para insertar datos de usuario en tabla perfil
		*/
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
				->where('id', '=', $id)
				->send();
		}

		/*
		* Metodo Para recuperar datos de un usuario
		*/
		public static function get( $data = array() ){
			$resultado = DB::select('users u')
				->leftJoin('profiles up', 'u.id', '=', 'up.id')
				->where('state', '=', 1);
			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);

			if( isset($data['email']) ) $resultado->where('email', '=', $data['email']);
			if( isset($data['nickname']) ) $resultado->where('nickname', '=', $data['nickname']);
			if( isset($data['id']) ) $resultado->where('u.id', '=', $data['id']);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select('users')
				->leftJoin('profiles up', 'u.id', '=', 'up.id')
				->where('state', '', 1);
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
						if( self::tokenGenerate($result['password']) === $_SESSION[S_STRING] ) $check = 1;
					}
				}
			}
			return $check;
		}

		/*
		* Metodo para procesar inicio de sesion
		*/
		public static function access($data){
			$userData = DB::select('users')->columns([
				'id','nickname','email','password','salt', 'role'
			])->where('state','=',1);
			$filter = filter_var($data['usuario'],FILTER_VALIDATE_EMAIL);
			if( $filter ) $userData->where('email','=',$data['usuario']);
			else $userData->where('nickname','=',$data['usuario']);
			$userData = $userData->first();

			if( $userData ){

				$password = self::getPassConfig([
					'pass' => $data['clave'],
					'salt' => $userData['salt'],
				]);
				if( $password === $userData['password'] ){
					return self::login([
						'id'=>$userData['id'],
						'nickname'=>$userData['nickname'],
						'email'=>$userData['email'],
						'clave'=>$userData['password'],
						'role'=>$userData['role'],
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
			$_SESSION[S_STRING] = self::tokenGenerate($datos['clave']);
			$_SESSION[S_ROLE] = $datos['role'];
			return [
				'id' => $datos['id'],
				'nickname' => $datos['nickname'],
				'email' => $datos['email'],
				'role' => $datos['role'],
			];
		}

		/*
		* Metodo para generar token a usar en la sesion de usuario
		*/
		private static function tokenGenerate($data){
			return hash('sha512',$data.$_SERVER['HTTP_USER_AGENT']);
		}

		/*
		* Metodo para cifrado de contraseña
		*/
		private static function getPassConfig($data){
			if( !encrypt::sha512Validate($data['pass']) ) $data['pass'] = hash('sha512', $data['pass']);
			return hash('sha512',$data['pass'].$data['salt']);
		}

		/*
		* Metodo para generar clave cifrada y sal
		*/
		public static function createPassConfig($pass){
			//Ciframos la clave si esta no viene cifrada
			if( !encrypt::sha512Validate($pass) ) $pass = hash('sha512', $pass);
			$data = [
				'salt' => encrypt::randomHash( 'sha512' ),
			];
			$data['pass'] = self::getPassConfig([
				'pass' => $pass,
				'salt' => $data['salt'],
			]);
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
				->where('state','=',0)
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

		/*
		* Metodo para registrar usuario nuevo
		*/
		public static function register( $data ){

			//Validamos los datos del usuario
			$validemail = self::emailValidate($data['email']);
			$validnickname = self::nicknameValidate($data['nickname']);
			$data['role'] = (INT) $data['role'];
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

		/*
		* Metodo para actualizar clave de usuario
		*/
		public static function passchange($data){
			$passconfig = self::createPassConfig($data['password']);
			return self::update( $data['id'], [
				'password' => $passconfig['pass'],
				'salt' => $passconfig['salt'],
			]);
		}

		public static function singin(){
			if( isset($_POST['username'], $_POST['password']) ){
				$result = [
					'state' => 0,
					'data' => [],
					'error' => [],
				];
				event::fire( 'beforeUserSingIn' );
				if( isset($_POST['redirect']) ) $result['data']['redirect'] = $_POST['redirect'];
				if( isset($_GET['redirect']) ) $result['data']['redirect'] = $_GET['redirect'];
				$loginresult = self::access([
					'usuario' => $_POST['username'],
					'clave' => $_POST['password'],
				]);
				if( $loginresult ){
					$result['state'] = 1;
					$result['data'] = array_merge($result['data'], $loginresult);
				}else $result['error'] = self::$error;

				event::fire( 'userSingIn', $result );

				echo json_encode($result);
			}else extras::e404();
		}

		public static function singUp(){
			if( isset($_POST['nickname'], $_POST['email'], $_POST['password'], $_POST['usertype']) ){
				$result = [
					'state' => 0,
					'data' => [],
					'error' => [],
				];
				event::fire( 'beforeUserSingUp' );
				if( isset($_POST['redirect']) ) $result['data']['redirect'] = $_POST['redirect'];
				if( isset($_GET['redirect']) ) $result['data']['redirect'] = $_GET['redirect'];

				$singupresult = user::register([
					'nickname' => $_POST['nickname'],
					'email' => $_POST['email'],
					'password' => $_POST['password'],
					'role' => $_POST['usertype'],
					'state' => 1,
					'name' => '',
					'descrip' => '',
				]);
				if( $singupresult ){
					$result['state'] = 1;
					$result['data'] = array_merge($result['data'], [
						'id' => $singupresult,
						'nickname'=>$_POST['nickname'],
						'email'=>$_POST['email'],
					]);
				}else $result['error'] = self::$error;
				event::fire( 'userSingUp', $result );

				echo json_encode($result);
			}else extras::e404();
		}

		public static function logout(){
			session::destroy();
			header('location: login');
		}

		public static function updateacount(){
			if( user::loginCheck() ){
				$result = [
					'state' => 0,
					'data' => [],
					'error' => [],
				];

				$columns = [
					'u.updated' => date('Y-m-d H:i:s'),
				];

				if( isset($_POST['name']) ) $columns['up.name'] = $_POST['name'];
				if( isset($_POST['nickname']) ) $columns['u.nickname'] = $_POST['nickname'];
				if( isset($_POST['descrip']) ) $columns['up.descrip'] = $_POST['descrip'];
				if( isset($_POST['email']) ) $columns['u.email'] = $_POST['email'];

				$query = self::update( $_SESSION[S_USERID], $columns);

				if( $query ) $result['state'] = 1;

				echo json_encode($result);
			}else extras::e404();
		}
	}
