<?php
	namespace wecor;

	/**
	*
	*/
	class navLink{

		public $id;
		public $parent;
		public $title;
		public $url;
		public $icon;
		public $meta;
		private $navlinks = [];

		public function __construct( $data ){
			$this->id = isset( $data['id'] ) ? $data['id'] : '';
			$this->parent = isset( $data['parent'] ) ? $data['parent'] : '';
			$this->title = isset( $data['title'] ) ? $data['title'] : '';
			$this->url = isset( $data['url'] ) ? $data['url'] : '';
			$this->icon = isset( $data['icon'] ) ? $data['icon'] : '';
			$this->meta = isset( $data['meta'] ) ? $data['meta'] : [];
		}

		public function setChildren( $newlink ){
			if( isset( $this->navlinks[$newlink->id] ) )
				$this->navlinks[$newlink->id] = $newlink;
			else $this->navlinks[] = $newlink;
		}

		public function getLinkList(){
			return $this->navlinks;
		}
	}

	/**
	*
	*/
	class navMenu{

		private $navlinks = [];

		public function addLink( $data ){
			$newlink = new navLink($data);
			if( isset( $data['parent'] ) ){
				if( isset($this->navlinks[$data['parent']]) )
					$this->navlinks[$data['parent']]->setChildren( $newlink );
			}else{
				if( isset( $data['id'] ) ) $this->navlinks[$data['id']] = $newlink;
				else $this->navlinks[] = $newlink;
			}
		}

		public function removeLink( $id ){
			if( isset( $this->navlinks[$id] ) ) unset($this->navlinks[$id]);
		}

		public function getLinkList(){
			return $this->navlinks;
		}

		/*public function setLink( $data ){
			if( isset($data['id']) ){
				if( isset( $this->navlinks[$data['id']] ) ){
					if( isset( $data['parent'] ) )
						$this->navlinks[$data['id']]['parent'] = $data['parent'];
					if( isset( $data['title'] ) )
						$this->navlinks[$data['id']]['title'] = $data['title'];
					if( isset( $data['url'] ) )
						$this->navlinks[$data['id']]['url'] = $data['url'];
					if( isset( $data['icon'] ) )
						$this->navlinks[$data['id']]['icon'] = $data['icon'];
					if( isset( $data['meta'] ) )
						$this->navlinks[$data['id']]['meta'] = $data['meta'];
				}else $this->addLink( $data );
			}
		}*/
	}
