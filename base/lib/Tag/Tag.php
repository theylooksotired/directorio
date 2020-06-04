<?php
class Tag extends Db_Object {

	public function insert($values, $options=array()) {
		parent::insert($values, $options);
		$this->updateTag();
	}

	public function modify($values, $options=array()) {
		parent::modify($values, $options);	
		$this->updateTag();
	}

	public function updateTag() {
		// Update cities
		$query = 'SELECT DISTINCT dir_Place.city
					FROM dir_Place
					JOIN dir_PlaceTag ON dir_Place.idPlace=dir_PlaceTag.idPlace AND dir_PlaceTag.idTag="'.$this->id().'"';
		$info = '';
		foreach (Db::returnAllColumn($query) as $itemIns) {
			$info .= $itemIns.',';
		}
		$info = substr($info, 0, -1);
		$this->modifySimple('cities', $info);
	}

}
?>