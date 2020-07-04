<?php

	namespace wecor;

	/*
	*	Clase de la capa logica para posts
	*
	*	Permite relaizar transacciones con posts
	*/
	class cat{

		use paginaraux;

		public static $error = [];

		/*
		* Metodo Para crear elemento
		*/
		public static function create( $data = [] ){
			$predata = [
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
			];

			$data = array_merge($data, $predata);

			$result = DB::insert('cats')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();

				if( !isset($data['verof']) ) cat::update($insertId, [
					'verof' => $insertId,
				]);

				event::fire( 'catCreated', $data );


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
			$result = DB::update('cats')
				->set($data)
				->where('id', '=', $id)
				->send();

			$data['id'] = $id;
			event::fire( 'catUpdated', $data );

			return $result;
		}

		/*
		* Metodo Para eliminar elemento por su id
		*/
		public static function delete( $id ){
			return DB::delete('cats')
				->where('id', '=', $id)
				->send();
		}

		/*
		* Metodo Para recuperar datos de una categoria
		*/
		public static function get( $data = array() ){
			$resultado = DB::select('cats c');

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('c.type', '=', $data['type']);

			if( isset($data['id'], $data['lang']) ) $resultado->where(function( $query ){
				global $data;
				$query->where('c.id', '=', $data['id'])->orWhere('c.verof', '=', $data['id']);
			});
			else if( isset($data['id']) ) $resultado->where('c.id', '=', $data['id']);
			if( isset($data['slug']) ) $resultado->where('c.slug', '=', $data['slug']);

			if( isset($data['lang']) ) $resultado->where('c.lang', '=', $data['lang']);

			$resultado->where('c.state', '=', 1);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select('cats c')->where('c.state', '=', 1);

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('c.type', '=', $data['type']);
			if( isset($data['slug']) ) $resultado->where('c.slug', '=', $data['slug']);
			if( isset($data['verof']) ){
				$resultado->where('c.verof', '=', $data['verof']);
			}else if( isset($data['lang'], $data['verof']) ){
				$resultado->where('c.lang', '=', $data['lang'])
					->where('c.verof', '=', $data['verof']);
			}else if( isset($data['lang']) ) $resultado->where('c.lang', '=', $data['lang']);
			else $resultado->where('c.verof = c.id');

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);

			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}
	}
