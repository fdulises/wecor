<?php
	namespace wecor;

	class stpost{
		private $columns = [];
		public $id = null;

		public function __construct( $id = null ){
			if( !is_null($id) ){
				$result = post::get([
					'id' => $id,
					'columns' => ['p.title', 'p.descrip', 'p.content', 'p.slug', 'p.state'],
				]);
				if( $result ){
					$this->columns = $result;
					$this->id = $id;
				}
			}
		}

		public function save(){
			if( !is_null($this->id) )
				post::update($this->id, $this->columns);
			else{
				$result = post::create($this->columns);
				if($result) $this->id = $result;
			}
		}
		public function delete(){
			return post::delete($this->id);
		}
		public function __set($name,$value){
			$this->columns[$name] = $value;
		}
		public function __get($name){
			if( isset($this->columns[$name]) )
				return $this->columns[$name];
			return null;
		}

	}
