<?php
class Place extends Db_Object {

	public function loadTags() {
		if (!isset($this->tags)) {
			$this->tags = new ListObjects('Tag', array('query'=>'SELECT DISTINCT dir_Tag.* FROM dir_Tag
																JOIN dir_PlaceTag ON dir_Tag.idTag=dir_PlaceTag.idTag AND dir_PlaceTag.idPlace="'.$this->id().'"'));
		}
	}

	public function encodeId() {
		return Place::encodeIdSimple($this->id());
	}

	static public function encodeIdSimple($id) {
		return md5('plasticwebs_place_'.$id);
	}

	static public function readCoded($code) {
		return Place::readFirst(array('where'=>'MD5(CONCAT("plasticwebs_place_",idPlace))="'.$code.'"'));
	}

	public function insert($values, $options=array()) {
		parent::insert($values, $options);
		$this->updatePlace();
	}

	public function modify($values, $options=array()) {
		parent::modify($values, $options);	
		$this->updatePlace();
	}

	public function updatePlace() {
		// Search field
		$this->loadTags();
		$search = '';
		$search .= $this->get('title').' ';
		$search .= $this->tags->showList(array('function'=>'Minimal')).' ';
		$search .= $this->get('address').' ';
		$search .= $this->get('telephone').' ';
		$search .= $this->get('web').' ';
		$search .= $this->get('email').' ';
		$search .= $this->get('city').' ';
		$search .= $this->get('shortDescription').' ';
		$search .= $this->get('description').' ';
		$this->modifySimple('search', substr($search, 0, -1));
		// Related field
		$query = 'SELECT dir_Tag.idTag
					FROM dir_Tag
					JOIN dir_PlaceTag ON dir_Tag.idTag=dir_PlaceTag.idTag AND dir_PlaceTag.idPlace="'.$this->id().'"
					LIMIT 1';
		$result = Db::returnAllColumn($query);
		if (isset($result[0]) && $result[0]!='') {	
			$query = 'SELECT dir_Place.* 
					FROM dir_Place
					LEFT JOIN dir_PlaceTag 
					ON dir_Place.idPlace=dir_PlaceTag.idPlace 
					WHERE dir_PlaceTag.idTag="'.$result[0].'"
					AND dir_Place.idPlace!="'.$this->id().'"
					LIMIT 5';
			$info = '';
			$itemsIns = Db::returnAll($query);
			foreach ($itemsIns as $itemIns) {
				$info .= $itemIns['idPlace'].',';
			}
			$info = substr($info, 0, -1);
			$this->modifySimple('related', $info);
		}
		// Tags
		/*
		foreach($this->tags->list as $tag) {
			$tag->updateTag();
		}
		*/
	}

	public function sendEmail($emailTo, $typeEmail='placeNew') {
		HtmlMail::sendFromFile($emailTo, $typeEmail, array('NAME'=>$this->get('nameEditor'),
												'PLACE_LINK'=>$this->url(),
												'LINK_MODIFY'=>url('modificar/'.$this->id()),
												'LINK_PROMOTE'=>url('lugar-promocionar/'.$this->encodeId()),
												'LINK_DEPROMOTE'=>url('lugar-depromocionar/'.$this->encodeId()),
												'PLACE'=>$this->showUi('Email')));
	}

}
?>