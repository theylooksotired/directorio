<?php
class PlaceEdit extends Db_Object {

	public function loadTags() {
		$this->tags = new ListObjects('Tag', array('query'=>'SELECT DISTINCT dir_Tag.* FROM dir_Tag
															JOIN dir_PlaceEditTag ON dir_Tag.idTag=dir_PlaceEditTag.idTag AND dir_PlaceEditTag.idPlaceEdit="'.$this->id().'"'));
	}

	public function insertMail($values, $options=array()) {
		parent::insert($values, $options);
		$this->sendEmail(Params::param('email'), 'placeEditNew');
	}

	public function insertMailPromoted($values, $options=array()) {
		parent::insert($values, $options);
		$this->sendEmail(Params::param('email'), 'placeEditNewPromoted');
	}

	public function modifyMail($values, $options=array()) {
		parent::modify($values, $options);	
		$this->sendEmail(Params::param('email'), 'placeEditModified');
	}

	public function encodeId() {
		return PlaceEdit::encodeIdSimple($this->id());
	}

	static public function encodeIdSimple($id) {
		return md5('plasticwebs_placeedit_'.$id);
	}

	static public function readCoded($code) {
		return PlaceEdit::readFirst(array('where'=>'MD5(CONCAT("plasticwebs_placeedit_",idPlaceEdit))="'.$code.'"'));
	}
	
	public function sendEmail($emailTo, $typeEmail='placeEditNew') {
		$mailPlaceEdit = $this->showUi('Email');
		$encodedId = $this->encodeId();
		$linkDelete = url('lugar-editar-borrar/'.$encodedId);
		$linkUpdate = url('lugar-editar-modificar/'.$encodedId);
		$linkPublish = url('lugar-editar-publicar/'.$encodedId);
		$linkPublishPromote = url('lugar-editar-publicar-promocionar/'.$encodedId);
		HtmlMail::send($emailTo, $typeEmail, array('NAME'=>$this->get('nameEditor'),
												'PLACE'=>$mailPlaceEdit,
												'LINK_DELETE'=>$linkDelete,
												'LINK_UPDATE'=>$linkUpdate,
												'LINK_PUBLISH'=>$linkPublish,
												'LINK_DIRECT_PROMOTE'=>$linkPublishPromote));
	}

}
?>