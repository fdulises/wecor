<?php

	namespace wecor;

	/*
	*	Clase de la capa logica para posts
	*
	*	Permite relaizar transacciones con posts
	*/
	class collection{

		use paginaraux;

		public static $error = [];
		private static $table = 'collections';
		private static $tableas = 'collections cols';

		/*
		* Metodo Para crear elemento
		*/
		public static function create( $data = [] ){
			$predata = [
				'created' => date('Y-m-d H:i:s'),
				'updated' => date('Y-m-d H:i:s'),
			];

			$data = array_merge($data, $predata);

			$result = DB::insert(self::$table)
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();

				if( !isset($data['verof']) ) self::update($insertId, [
					'verof' => $insertId,
				]);

				event::fire( self::$table.'_created', $data );

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
			$result = DB::update(self::$table)
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
			return DB::delete(self::$table)
				->where('id', '=', $id)
				->send();
		}

		/*
		* Metodo Para recuperar datos de una categoria
		*/
		public static function get( $data = array() ){
			$resultado = DB::select(self::$table);

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);
			if( isset($data['title']) ) $resultado->where('title', '=', $data['title']);

			if( isset($data['id'], $data['lang']) ) $resultado->where(function( $query ){
				global $data;
				$query->where('id', '=', $data['id'])->orWhere('verof', '=', $data['id']);
			});
			else if( isset($data['id']) ) $resultado->where('id', '=', $data['id']);
			if( isset($data['slug']) ) $resultado->where('slug', '=', $data['slug']);

			if( isset($data['lang']) ) $resultado->where('lang', '=', $data['lang']);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select(self::$table);

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('type', '=', $data['type']);
			if( isset($data['slug']) ) $resultado->where('slug', '=', $data['slug']);

			if( isset($data['state']) ){
				if(is_array($data['state'])){
					$resultado->where(function($r){
						global $data;
						foreach ($data['state'] as $v) $r->orWhere('p.state', '=', $v);
					});
				}else $resultado->where('state', '=', $data['state']);
			}else $resultado->where('state', '=', 1);

			if( isset($data['verof']) ){
				$resultado->where('verof', '=', $data['verof']);
			}else if( isset($data['lang'], $data['verof']) ){
				$resultado->where('lang', '=', $data['lang'])
					->where('verof', '=', $data['verof']);
			}else if( isset($data['lang']) ) $resultado->where('lang', '=', $data['lang']);
			else $resultado->where('verof = id');

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);

			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}

		public static function add( $data = [] ){
			$collection = self::get([
				'columns' => ['id'],
				'type' => $data['type'],
				'slug' => $data['slug'],
			]);
			if($collection){

			}
		}
	}
