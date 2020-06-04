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
		$image = ($this->object->getImageUrl('image', 'small')!='') ? '<img src="'.$this->object->getImageUrl('image', 'small').'" style="width: 120px; margin:0 0 20px; display:block; padding: 5px; background: #fff; border: 1px solid #eee;"/>' : '';
		$tags = new ListObjects('Tag', array('table'=>'Tag, PlaceEditTag', 'object'=>'Tag', 'fields'=>'DISTINCT '.Db::prefixTable('Tag').'.*', 'where'=>''.Db::prefixTable('PlaceEditTag').'.idTag='.Db::prefixTable('Tag').'.idTag AND '.Db::prefixTable('PlaceEditTag').'.idPlaceEdit="'.$this->object->id().'"'));
		return '<div style="width: 120px; height: 10px; background: #efefef; margin: 30px 0;"> </div>
				'.$image.'
				<h2 style="font-weight:bold;padding: 0 0 10px;margin: 0; color:#FFA12C; font-size: 1.6rem;"> '.$this->object->getBasicInfo().'</h2>
				<p style="color: #666666; margin: 0 0 20px; padding: 0;">'.nl2br($this->object->get('shortDescription')).'</p>
				'.$this->renderElement('address', 'Dirección').'
				'.$this->renderElement('city', 'Ciudad').'
				'.$this->renderElement('telephone', 'Teléfono').'
				'.$this->renderElement('mobile', 'Móvil').'
				'.$this->renderElement('whatsapp', 'Whatsapp').'
				'.$this->renderElement('email', 'Email').'
				'.$this->renderElement('web', 'Sitio web').'
				'.$this->renderElement('facebook', 'Facebook').'
				'.$this->renderElement('twitter', 'Twitter').'
				'.$this->renderElement('instagram', 'Instagram').'
				'.$this->renderElement('youtube', 'YouTube').'
				'.$this->renderElement('description', 'Descripción').'
				'.((!$tags->isEmpty()) ? '
				<p style="margin: 0 0 5px; padding: 0;">
					<span style="color:#999999;  font-size: 0.8rem;">Etiquetas : </span><br/>
					<span>'.substr($tags->showList(array('function'=>'Simple')), 0, -2).'</span>
				</p>
				' : '').'
				<p style="margin: 0 0 5px; padding: 0;">
					<span style="color:#999999;  font-size: 0.8rem;">Editor : </span><br/>
					'.$this->object->get('nameEditor').' '.$this->object->get('emailEditor').'
				</p>
				<div style="width: 120px; height: 10px; background: #efefef; margin: 30px 0;"> </div>';
	}

	public function renderElement($attribute, $label) {
		if ($this->object->get($attribute)!='') {
			return '<p style="margin: 0 0 5px; padding: 0;">
						<span style="color:#999999;  font-size: 0.8rem;">'.$label.' : </span><br/>
						<span>'.$this->object->get($attribute).'</span>
					</p>';
		}
	}

}
?>