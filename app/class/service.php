<?php

	namespace wecor;

	/*
	*	Clase de la capa logica para usuarios
	*
	*	Permite relaizar transacciones con usuarios
	*/
	class service{

		use paginaraux;

		public static $error = [];

		/*
		* Metodo Para crear elemento
		*/
		public static function createAlert( $data = [] ){
			$predata = [
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
			];

			$data = array_merge($data, $predata);

			$result = DB::insert('service_alert')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();
				event::fire( 'serviceCreated', $data );
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
			$result = DB::update('service_alert')
				->set($data)
				->where('id', '=', $id)
				->send();

			$data['id'] = $id;
			event::fire( 'serviceUpdated', $data );

			return $result;
		}

		/*
		* Metodo Para eliminar elemento por su id
		*/
		public static function delete( $id ){
			return DB::delete('service_alert')
				->where('id', '=', $id)
				->send();
		}

		/*
		* Metodo Para recuperar datos
		*/
		public static function get( $data = array() ){
			$resultado = DB::select('service_alert sa')
				->leftJoin('users u', 'sa.autor', '=', 'u.id')
				->leftJoin('profiles up', 'sa.autor', '=', 'up.id')
				->where('state', '>', 0);
			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);
			if( isset($data['id']) ) $resultado->where('id', '=', $data['id']);
			if( isset($data['autor']) ) $resultado->where('autor', '=', $data['autor']);
			if( isset($data['server']) ) $resultado->where('server', '=', $data['server']);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select('service_alert sa')
				->leftJoin('users u', 'sa.autor', '=', 'u.id')
				->leftJoin('profiles up', 'sa.autor', '=', 'up.id')
				->where('sa.state', '>', 0);
			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);
			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}

		/*
		* Metodo para registrar usuario nuevo
		*/
		public static function serviceAlertRegister(){
			if( user::loginCheck() ){
				$result = [
					'state' => 0,
					'data' => [],
					'error' => [],
				];

				$query = self::createAlert([
					'autor' => $_SESSION[S_USERID],
				]);

				if( $query ){
					$result['state'] = 1;
					$result['data'] = [
						'id' => $query
					];
				}

				echo json_encode($result);
			}else extras::e404();
		}

		public static function updateAlert(){
			if( user::loginCheck() ){
				$result = [
					'state' => 0,
					'data' => [],
					'error' => [],
				];


				echo json_encode($result);
			}else extras::e404();
		}

		public static function checkAlertStatus(){
			if( user::loginCheck() ){
				$result = [
					'state' => 0,
					'data' => [],
					'error' => [],
				];

				/*$query = self::get([
					'autor' => $_SESSION[S_USERID]
				]);

				if( $query ){
					if( $query['server'] )
				}*/


				echo json_encode($result);
			}else extras::e404();
		}

	}
