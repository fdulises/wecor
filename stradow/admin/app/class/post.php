<?php

	namespace wecor;

	/*
	*	Clase de la capa logica para posts
	*
	*	Permite relaizar transacciones con posts
	*/
	class post{

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

			$result = DB::insert('posts')
				->columns(array_keys($data))
				->values(array_values($data))
				->send();

			if( $result ){
				$insertId = DBConnector::insertId();

				if( !isset($data['verof']) ) post::update($insertId, [
					'verof' => $insertId,
				]);

				event::fire( 'postCreated', $data );
				return $insertId;
			}
			return 0;
		}

		/*
		* Metodo Para editar elemento por su id
		*/
		public static function update( $id = 0, $data ){
			$predata = ['updated' => date('Y-m-d H:i:s')];
			$data = array_merge($data, $predata);
			$result = DB::update('posts p')
				->set($data)
				->where('p.id', '=', $id)
				->send();

			$data['id'] = $id;
			event::fire( 'postUpdated', $data );

			return $result;
		}


		public static function updateBySlug( $slug, $data ){
			$predata = ['updated' => date('Y-m-d H:i:s')];
			$data = array_merge($data, $predata);
			$result = DB::update('posts p')
				->set($data)
				->where('p.slug', '=', $slug)
				->send();

			$data['slug'] = $slug;
			event::fire( 'postUpdated', $data );

			return $result;
		}

		/*
		* Metodo Para eliminar elemento por su id
		*/
		public static function delete( $id ){
			return DB::delete('posts')
				->where('id', '=', $id)
				->send();
		}

		/*
		* Metodo Para recuperar datos de un post
		*/
		public static function get( $data = array() ){
			$resultado = DB::select('posts p')
				->leftJoin('users u', 'p.autor', '=', 'u.id')
				->leftJoin('profiles up', 'u.id', '=', 'up.id');

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('p.type', '=', $data['type']);

			if( isset($data['id'], $data['lang']) ) $resultado->where(function( $query ){
				global $data;
				$query->where('p.id', '=', $data['id'])->orWhere('p.verof', '=', $data['id']);
			});
			else if( isset($data['id']) ) $resultado->where('p.id', '=', $data['id']);
			if( isset($data['slug']) ) $resultado->where('p.slug', '=', $data['slug']);

			if( isset($data['lang']) ) $resultado->where('p.lang', '=', $data['lang']);

			return $resultado->first();
		}

		/*
		* Metodo Para recuperar lista de elementos
		*/
		public static function getList( $data = array() ){
			$resultado = DB::select('posts p')
				->leftJoin('users u', 'p.autor', '=', 'u.id')
				->leftJoin('profiles up', 'u.id', '=', 'up.id')
				->leftJoin('cats c', 'c.id', '=', 'p.cat');

			if( isset($data['columns']) ) $resultado->columns($data['columns']);
			if( isset($data['type']) ) $resultado->where('p.type', '=', $data['type']);
			if( isset($data['cat']) ) $resultado->where('cat', '=', $data['cat']);
			if( isset($data['catslug']) ) $resultado->where('c.slug', '=', $data['catslug']);

			if( isset($data['state']) ){
				if(is_array($data['state'])){
					$resultado->where(function($r){
						global $data;
						foreach ($data['state'] as $v) $r->orWhere('p.state', '=', $v);
					});
				}else $resultado->where('p.state', '=', $data['state']);
			}else $resultado->where('p.state', '=', 1);

			if( isset($data['verof']) ){
				$resultado->where('p.verof', '=', $data['verof']);
			}else if( isset($data['lang'], $data['verof']) ){
				$resultado->where('p.lang', '=', $data['lang'])
					->where('p.verof', '=', $data['verof']);
			}else if( isset($data['lang']) ){
				$resultado->where('p.lang', '=', $data['lang']);
			}else{
				$resultado->where('p.verof = p.id');
			}

			if( isset($data['search']) ){
				$resultado->fullTextSearch(['p.title', 'p.descrip'], $data['search'], 'score');
			}

			if( isset($data['limit'], $data['offset']) )
				$resultado->limit($data['limit'], $data['offset']);
			else if( isset($data['limit']) ) $resultado->limit($data['limit']);

			if( isset($data['order']) ) $resultado->order($data['order']);

			return self::getSelect($resultado->getSQL());
		}

		/*
		* Metodo Para procesar portada de entrada
		*/
		public static function uploadCover($id){
			if( isset($_FILES['cover']) ){
				if( $_FILES['cover']['error'] == 0 ){
					$type = strtolower(substr(strrchr( $_FILES['cover']['name'] ,"."),1));
					if($type == 'jpeg') $type = 'jpg';
					$result = move_uploaded_file( $_FILES['cover']['tmp_name'], MEDIA_DIR."/covers/{$id}.{$type}");
					if( $result ){
						return post::update( $id, ['coverlocal' => "$id.$type"] );
					}
				}
			}
			return 0;
		}

		public static function getPostCover($actualudata){
			if( empty($actualudata['coverlocal']) ){
				if( empty($actualudata['cover']) ) return config::get('site_url').'/media/covers/default.jpg';
				else return $actualudata['cover'];
			}else return config::get('site_url').'/media/covers/'.$actualudata['coverlocal'];
		}
	}
