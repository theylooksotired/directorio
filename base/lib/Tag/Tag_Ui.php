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

	public function renderCities($options=[]) {
		$items = explode(',', $this->object->get('cities'));
		$info = '';
		if (sizeof($items)>0) {
			asort($items);
			foreach($items as $item) {
				$info .= '<a href="'.$this->object->url().'/'.Text::simple($item).'" class="cityLink">'.$item.'</a> ';
			}
		}
		return ($info!='') ? '<div class="cityLinks">
								<p>Ver <strong>'.$this->object->getBasicInfo().'</strong> en :</p>
								<div class="cityLinksItems">'.$info.'</div>
							</div>' : '';
	}

	static public function intro($options=[]) {
		$query = 'SELECT t.idTag, t.name, t.nameUrl, COUNT(p.idPlace) as numPlaces
				FROM dir_Tag t
				JOIN dir_PlaceTag pt ON t.idTag=pt.idTag
				JOIN dir_Place p ON p.idPlace=pt.idPlace
				GROUP BY t.idTag
				HAVING numPlaces>1
				ORDER BY t.nameUrl';
		$isCity = (isset($options['place'])) ? true : false;
		if ($isCity) {
			$query = 'SELECT t.idTag, t.name, t.nameUrl, COUNT(p.idPlace) as numPlaces
					FROM dir_Tag t
					JOIN dir_PlaceTag pt ON t.idTag=pt.idTag
					JOIN dir_Place p ON p.idPlace=pt.idPlace
					WHERE p.cityUrl="'.$options['place']->get('cityUrl').'"
					GROUP BY t.idTag
					HAVING numPlaces>1
					ORDER BY t.nameUrl';			
		}
		$items = Db::returnAll($query);
		$groupsTags = [];
		foreach ($items as $item) {
			$url = ($isCity) ? url('tag/'.$item['idTag'].'-'.$item['nameUrl'].'/'.$options['place']->get('cityUrl')) : url('tag/'.$item['idTag'].'-'.$item['nameUrl']);
			$link = '<a href="'.$url.'">'.$item['name'].' <span>('.$item['numPlaces'].')</span></a>';
			$letter = substr(strtoupper($item['nameUrl']), 0, 1);
			if (!isset($groupsTags[$letter])) {
				$groupsTags[$letter] = '';
			}
			$groupsTags[$letter] .= $link;
		}
		$html = '';
		foreach ($groupsTags as $key=>$places) {
			$html .= '<div class="tagsSimpleBlock">
						<div class="tagsSimpleTitle">'.$key.'</div>
						<div class="tagsSimple">'.$places.'</div>
					</div>';
		}
		return '<div class="tagsSimpleWrapper">
					<h1>'.$options['titlePage'].'</h1>
					'.$html.'
				</div>';
	}
	
}
?>