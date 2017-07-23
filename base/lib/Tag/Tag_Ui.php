<?php
class Tag_Ui extends Ui {

	public function renderPublic() {
		return $this->object->link().' ';
	}

	public function renderSimple() {
		return $this->object->getBasicInfo().', ';
	}

	public function renderMinimal() {
		return $this->object->getBasicInfo().' ';
	}

	public function renderCities() {
		$items = explode(',', $this->object->get('cities'));
		$info = '';
		if (sizeof($items)>0) {
			asort($items);
			foreach($items as $item) {
				$info .= '<a href="'.$this->object->url().'/'.Text::simple($item).'" class="cityLink">'.$item.'</a>, ';
			}
		}
		$info = substr($info, 0, -2);
		return ($info!='') ? '<div class="cityLinks"><p>Ver solamente resultados de: '.$info.'</p></div>' : '';
	}
	
}
?>