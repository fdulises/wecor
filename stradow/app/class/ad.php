<?php

	namespace wecor;

	/*
	*	Clase de la capa logica para posts
	*
	*	Permite relaizar transacciones con posts
	*/
	class ad{

		use paginaraux;

		public static $error = [];

		/*
		* Metodo Para crear elemento
		*/
		public static function create( $data = [] ){

			$result = DB::insert('ads')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();
				event::fire( 'adCreated', $data );
				return $insertId;
			}
			return 0;
		}

		/*
		* Metodo Para editar elemento por su id
		*/
		public static function update( $id, $data ){
			$result = DB::update('ads a')
				->set($data)
				->where('a.id', '=', $id)
				->send();

			$data['id'] = $id;
			event::fire( 'adUpdated', $data );

			return $result;
		}

		/*
		* Metodo Para recuperar datos de un post
		*/
		public static function get( $data = array() ){
			$resultado = DB::select('ads a')
				->leftJoin('users u', 'a.autor', '=', 'u.id');

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('a.type', '=', $data['type']);
			if( isset($data['id']) ) $resultado->where('a.id', '=', $data['id']);
			$resultado->where('a.state', '=', 1);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select('ads a')
				->leftJoin('ads_groups ag', 'ag.id', '=', 'a.groupid')
				->where('a.state', '=', 1);

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);
			if( isset($data['groupid']) ) $resultado->where('groupid', '=', $data['groupid']);

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);

			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}


		public static function createGroup( $data = [] ){

			$result = DB::insert('ads_groups')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();
				event::fire( 'adGroupCreated', $data );
				return $insertId;
			}
			return 0;
		}

		/*
		* Metodo Para editar elemento por su id
		*/
		public static function updateGroup( $id, $data ){
			$result = DB::update('ads_groups')
				->set($data)
				->where('id', '=', $id)
				->send();

			$data['id'] = $id;
			event::fire( 'adGroupUpdated', $data );

			return $result;
		}

		/*
		* Metodo Para recuperar datos de un post
		*/
		public static function getGroup( $data = array() ){
			$resultado = DB::select('ads_groups ag');

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('ag.type', '=', $data['type']);
			if( isset($data['id']) ) $resultado->where('ag.id', '=', $data['id']);
			$resultado->where('ag.state', '=', 1);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getGroupList( $data = array() ){
			$resultado = DB::select('ads_groups ag')
				->where('ag.state', '=', 1);

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);

			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}
	}
