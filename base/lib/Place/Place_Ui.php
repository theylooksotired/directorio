<?php
class Place_Ui extends Ui {

	public function renderPublic() {
		if ($this->object->get('promoted')=='1') {
			return $this->renderPublicPromoted();
		}
		$info = '';
		$info .= ($this->object->get('address')!='') ? '<p class="address"><i class="icon icon-address"></i> '.$this->object->get('address').'</p>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> '.$this->object->get('telephone').'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p class="city"><i class="icon icon-city"></i> <span><a href="'.url('ciudad/'.$this->object->get('cityUrl')).'">'.$this->object->get('city').'</a>, '.Params::param('country').'</span></p>' : '';
		$description = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$this->object->loadTags();
		return '<div class="itemPublic">
					<div class="itemPublicInfo">
						<a href="'.$this->object->url().'">
							<h2>'.$this->object->getBasicInfo().'</h2>
							'.$description.'
							<p>'.$info.'</p>
						</a>
						'.$city.'
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
				</div>';
	}

	public function renderSimple() {
		$info = '';
		$info .= ($this->object->get('address')!='') ? '<p class="address"><i class="icon icon-address"></i> '.$this->object->get('address').'</p>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> '.$this->object->get('telephone').'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p class="city"><i class="icon icon-city"></i> <span><a href="'.url('ciudad/'.$this->object->get('cityUrl')).'">'.$this->object->get('city').'</a>, '.Params::param('country').'</span></p>' : '';
		$description = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		return '<div class="itemPublic">
					<div class="itemPublicInfo">
						<a href="'.$this->object->url().'">
							<h2>'.$this->object->getBasicInfo().'</h2>
							'.$description.'
							<p>'.$info.'</p>
						</a>
						'.$city.'
					</div>
				</div>';
	}

	public function renderPublicPromoted() {
		$info = '';
		$info .= ($this->object->get('address')!='') ? '<p class="address"><i class="icon icon-address"></i> '.$this->object->get('address').'</p>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> '.$this->object->get('telephone').'</p>' : '';
		$info .= ($this->object->get('city')!='') ? '<p class="city"><i class="icon icon-city"></i> <span>'.$this->object->get('city').', '.Params::param('country').'</span></p>' : '';
		$description = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$this->object->loadTags();
		return '<div class="itemPublic itemPublicPromoted">
					<div class="itemPublicInfo">
						<a href="'.$this->object->url().'">
							<div class="itemPublicWrapper">
								<div class="itemPublicWrapperLeft">
									'.$this->object->getImage('image', 'web').'
								</div>
								<div class="itemPublicWrapperRight">
									<h2>'.$this->object->getBasicInfo().'</h2>
									'.$description.'
									<p>'.$info.'</p>
								</div>
							</div>
						</a>
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
				</div>';
	}
	
	public function renderComplete() {
		$info = '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> <em>Teléfonos :</em> <span itemprop="telephone">'.$this->object->get('telephone').'</span></p>' : '';
		$info .= ($this->object->get('email')!='') ? '<p class="email"><i class="icon icon-email"></i> <em>Email :</em> <a href="mailto:'.$this->object->get('email').'">'.$this->object->get('email').'</a></p>' : '';
		$info .= ($this->object->get('web')!='') ? '<p class="web"><i class="icon icon-globe"></i> <em>Sitio web :</em> <a href="'.Url::format($this->object->get('web')).'" target="_blank">'.Url::format($this->object->get('web')).'</a></p>' : '';
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription"><strong>'.$this->object->get('shortDescription').'</strong></p>' : '';
		$description = ($this->object->get('description')!='') ? '<p class="description">'.$this->object->get('description').'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p><i class="icon icon-city"></i> <em>Ciudad :</em> <a href="'.url('ciudad/'.$this->object->get('cityUrl')).'"><span itemprop="addressLocality">'.$this->object->get('city').'</span></a>, <span itemprop="addressRegion">'.Params::param('country').'</span></p>' : '';
		$address = ($this->object->get('address')!='') ? '<p><i class="icon icon-address"></i> <em>Dirección :</em> <span itemprop="streetAddress">'.$this->object->get('address').'</span></p>' : '';
		$this->object->loadTags();
		return '<div class="itemComplete" itemscope itemtype="http://schema.org/LocalBusiness">
					<h1 itemprop="name">'.$this->object->getBasicInfo().'</h1>
					'.Adsense::top().'
					<div class="itemCompleteInfo">
						'.$shortDescription.'
						'.$description.'
						'.$info.'
						<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
							'.$address.'
							'.$city.'
						</div>
						'.$this->share(array('facebook'=>true, 'twitter'=>true, 'linkedin'=>true, 'title'=>'Compartir en: ')).'
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
					<div class="actions">
						<div class="action action-update">
							<a rel="nofollow" href="'.url('modificar/'.$this->object->id()).'"><i class="icon icon-edit"></i> Actualizar<span> esta información</span></a>
						</div>
						<div class="action action-promote">
							<a rel="nofollow" href="'.url('promocionar/'.$this->object->id()).'"><i class="icon icon-promotion"></i> Promocionar</a>
						</div>
						<div class="action action-report">
							<a rel="nofollow" href="'.url('reportar/'.$this->object->id()).'"><i class="icon icon-warning"></i> Reportar</a>
						</div>
					</div>
					'.Adsense::inline().'
				</div>
				'.Adsense::linksAll().'
				'.$this->renderRelated();
	}

	public function renderInfo() {
		$this->object->loadTags();
		return '<div class="itemInfo">
					<p><em>Nombre de la empresa :</em> '.$this->object->getBasicInfo().'</p>
					<p><em>Teléfonos :</em> '.$this->object->get('telephone').'</p>
					<p><em>Email :</em> '.$this->object->get('email').'</p>
					<p><em>Sitio web :</em> '.Url::format($this->object->get('web')).'</p>
					<p><em>Dirección :</em> '.$this->object->get('address').'</p>
					<p><em>Ciudad :</em> '.$this->object->get('city').'</p>
					<p><em>Descripcion corta :</em> '.$this->object->get('shortDescription').'</p>
					<p><em>Descripcion :</em> '.$this->object->get('description').'</p>
					<p><em>Tags :</em> '.$this->object->tags->showList(array('function'=>'Simple')).'</p>
					<p><em>Imagen :</em> '.$this->object->getImageUrl('image', 'web').'</p>
					<p><em>Color de fondo :</em> '.$this->object->get('colorBackground').'</p>
				</div>';
	}

	public function renderCompletePromoted() {
		$info = '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> <em>Teléfonos :</em> <span itemprop="telephone">'.$this->object->get('telephone').'</span></p>' : '';
		$info .= ($this->object->get('email')!='') ? '<p class="email"><i class="icon icon-email"></i> <em>Email :</em> <a href="mailto:'.$this->object->get('email').'">'.$this->object->get('email').'</a></p>' : '';
		$info .= ($this->object->get('web')!='') ? '<p class="web"><i class="icon icon-globe"></i> <em>Sitio web :</em> <a href="'.Url::format($this->object->get('web')).'" target="_blank">'.Url::format($this->object->get('web')).'</a></p>' : '';
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription"><strong>'.$this->object->get('shortDescription').'</strong></p>' : '';
		$description = ($this->object->get('description')!='') ? '<p class="description">'.$this->object->get('description').'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p><i class="icon icon-city"></i> <em>Ciudad :</em> <a href="'.url('ciudad/'.$this->object->get('cityUrl')).'"><span itemprop="addressLocality">'.$this->object->get('city').'</span></a>, <span itemprop="addressRegion">'.Params::param('country').'</span></p>' : '';
		$address = ($this->object->get('address')!='') ? '<p><i class="icon icon-address"></i> <em>Dirección :</em> <span itemprop="streetAddress">'.$this->object->get('address').'</span></p>' : '';
		$this->object->loadTags();
		return '<div class="itemComplete itemCompletePromoted" itemscope itemtype="http://schema.org/LocalBusiness">
					<div class="itemCompleteIns">
						<h1 itemprop="name">'.$this->object->getBasicInfo().'</h1>
						<div class="itemCompleteWrapper">
							<div class="itemCompleteWrapperLeft">
								'.$this->object->getImage('image', 'web').'
							</div>
							<div class="itemCompleteWrapperRight">
								<div class="itemCompleteInfo">
									'.$shortDescription.'
									'.$description.'
								</div>
							</div>
						</div>
						<div class="itemCompleteInfoWrapper itemCompleteInfo">
							<div class="itemCompleteInfoLeft" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
								'.$address.'
								'.$city.'
							</div>
							<div class="itemCompleteInfoRight">
								'.$info.'
							</div>
						</div>
						<div class="tagsPlace">
							'.$this->object->tags->showList(array('function'=>'Public')).'
						</div>
					</div>
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
				<strong>Enlace público :</strong> '.$this->object->link().'<br/>
				<br/>=====<br/><br/>
				<strong>Descripción corta:</strong> '.nl2br($this->object->get('shortDescription')).'<br/><br/>
				<strong>Descripción:</strong> '.nl2br($this->object->get('description')).'<br/>';
	}
	
	public function renderRelated() {
		if ($this->object->get('related')!='') {
			$html = '';
			$info = explode(',', $this->object->get('related'));
			if (sizeof($info)>0) {
				foreach ($info as $item) {
					$place = Place::read($item);
					$html .= $place->showUi('Public');
				}
			}
			return ($html!='') ? '<div class="related">
										<h3 class="title">Vea también :</h3>
										'.$html.'
									</div>' : '';
		}
	}

	static public function renderIntroPlaces() {
		$items = new ListObjects('Place', array('order'=>'((promoted > 0) and promoted is not null) DESC, RAND()', 'limit'=>'5'));
		return '<div class="introPlaces">
					<h3>Algunas de las empresas en nuestro directorio</h3>
					'.$items->showList(array('function'=>'Public')).'
				</div>';
	}

	/**
	* @cache
	*/
	static public function renderCities() {
		$query = 'SELECT dir_Place.city, dir_Place.cityUrl, COUNT(dir_Place.idPlace) as numElements
					FROM dir_Place 
					GROUP BY dir_Place.cityUrl
					ORDER BY numElements DESC
					LIMIT 24';
		$items = Db::returnAll($query);
		$html = '';
		foreach ($items as $item) {
			$html .= ($item['city']!='') ? '<a href="'.url('ciudad/'.$item['cityUrl']).'">'.$item['city'].'</a> ' : '';
		}
		return $html;
	}

	/**
	* @cache
	*/
	static public function renderCitiesComplete() {
		$query = 'SELECT dir_Place.city, dir_Place.cityUrl, COUNT(dir_Place.idPlace) as numElements
					FROM dir_Place 
					GROUP BY dir_Place.cityUrl
					ORDER BY city';
		$items = Db::returnAll($query);
		$html = '';
		foreach ($items as $item) {
			$html .= ($item['city']!='') ? '<a href="'.url('ciudad/'.$item['cityUrl']).'">'.$item['city'].'</a> ' : '';
		}
		return $html;
	}

	/**
	* @cache
	*/
	static public function renderTags() {
		$query = 'SELECT t.name, t.nameUrl, COUNT(t.idTag) as numElements
					FROM dir_Tag t, dir_PlaceTag pt 
					WHERE t.idTag=pt.idTag
					GROUP BY t.nameUrl
					ORDER BY numElements DESC
					LIMIT 36';
		$items = Db::returnAll($query);
		$html = '';
		foreach ($items as $item) {
			$html .= '<a href="'.url('tag/'.$item['nameUrl']).'">'.$item['name'].'</a> ';
		}
		return $html;
	}

}
?>