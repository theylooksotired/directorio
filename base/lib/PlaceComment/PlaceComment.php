<?php
/**
* @class PlaceComment
*
* This class represents a category for contact forms.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class PlaceComment extends Db_Object {

	public function loadPlace() {
		$this->place = Place::read($this->get('idPlace'));
	}

	public function encodeId() {
		return PlaceComment::encodeIdSimple($this->id());
	}

	static public function encodeIdSimple($id) {
		return md5('plasticwebs_comment_'.$id);
	}

	static public function readCoded($code) {
		return PlaceComment::readFirst(array('where'=>'MD5(CONCAT("plasticwebs_comment_",idPlaceComment))="'.$code.'"'));
	}

}
?>