<?php
class PlaceEdit_Ui extends Ui {

	public function renderComplete() {
		$info = '';
		$info .= ($this->object->get('telephone')!='') ? '<p><em>Teléfonos :</em> <span>'.$this->object->get('telephone').'</span></p>' : '';
		$info .= ($this->object->get('email')!='') ? '<p><em>Email :</em> <a href="mailto:'.$this->object->get('email').'">'.$this->object->get('email').'</a></p>' : '';
		$info .= ($this->object->get('web')!='') ? '<p><em>Sitio web :</em> <a href="'.Url::format($this->object->get('web')).'" target="_blank">'.Url::format($this->object->get('web')).'</a></p>' : '';
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p><strong>'.$this->object->get('shortDescription').'</strong></p>' : '';
		$description = ($this->object->get('description')!='') ? '<p>'.$this->object->get('description').'</p>' : '';
		$tags = new ListObjects('Tag', array('table'=>'Tag, PlaceEditTag', 'object'=>'Tag', 'fields'=>'DISTINCT '.Db::prefixTable('Tag').'.*', 'where'=>''.Db::prefixTable('PlaceEditTag').'.idTag='.Db::prefixTable('Tag').'.idTag AND '.Db::prefixTable('PlaceEditTag').'.idPlaceEdit="'.$this->object->id().'"'));
		return '<div class="itemEditComplete">
					<h1>'.$this->object->getBasicInfo().'</h1>
					'.$info.'
					<p><em>Dirección :</em> <span itemprop="streetAddress">'.$this->object->get('address').'</span></p>
					<p><em>Ciudad :</em> <a href="'.url('ciudad/'.$this->object->get('cityUrl')).'"><span itemprop="addressLocality">'.$this->object->get('city').'</span></a>, <span itemprop="addressRegion">'.Params::param('country').'</span></p>
					'.$shortDescription.'
					'.$description.'
					<p><em>Tags :</em> <span>'.substr($tags->showList(array('function'=>'Simple')), 0, -2).'</span></p>
				</div>';
	}

	public function renderEmail() {
		$image = ($this->object->getImageUrl('image', 'small')!='') ? '<img src="'.$this->object->getImageUrl('image', 'small').'" style="margin:auto auto 20px auto;display:block;padding: 5px;background: #fff; border: 1px solid #eee;"/><br/>' : '';
		return $image.'
				<strong>Nombre:</strong> '.$this->object->get('title').'<br/>
				<strong>Dirección:</strong> '.$this->object->get('address').'<br/>
				<strong>Ciudad:</strong> '.$this->object->get('city').'<br/>
				<strong>Teléfonos:</strong> '.$this->object->get('telephone').'<br/>
				<strong>Sitio web:</strong> '.$this->object->get('web').'<br/>
				<strong>Email:</strong> '.$this->object->get('email').'<br/>
				<br/>=====<br/><br/>
				<strong>Descripción corta:</strong> '.nl2br($this->object->get('shortDescription')).'<br/><br/>
				<strong>Descripción:</strong> '.nl2br($this->object->get('description')).'<br/>
				<br/>=====<br/><br/>
				<strong>Editor:</strong> '.$this->object->get('nameEditor').' '.$this->object->get('emailEditor');
	}

}
?>