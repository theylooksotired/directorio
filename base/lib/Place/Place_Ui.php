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
									'.$this->object->getImageAmpFill('image', 'web').'
								</div>
								<div class="itemPublicWrapperRight">
									<h2>'.$this->object->getBasicInfo().'</h2>
									'.$description.'
									<p>'.$info.'</p>
									<div class="itemPublicPromotedStar">
										<i class="icon icon-promotion"></i>
										<span>Empresa promocionada</span>
									</div>
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
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> <em>Teléfonos :</em> <span>'.$this->object->get('telephone').'</span></p>' : '';
		$info .= ($this->object->get('email')!='') ? '<p class="email"><i class="icon icon-email"></i> <em>Email :</em> <a href="mailto:'.$this->object->get('email').'">'.$this->object->get('email').'</a></p>' : '';
		$info .= ($this->object->get('web')!='') ? '<p class="web"><i class="icon icon-globe"></i> <em>Sitio web :</em> <a href="'.Url::format($this->object->get('web')).'" target="_blank">'.Url::format($this->object->get('web')).'</a></p>' : '';
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription"><strong>'.$this->object->get('shortDescription').'</strong></p>' : '';
		$description = ($this->object->get('description')!='') ? '<p class="description">'.$this->object->get('description').'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p><i class="icon icon-city"></i> <em>Ciudad :</em> <a href="'.url('ciudad/'.$this->object->get('cityUrl')).'"><span>'.$this->object->get('city').'</span></a>, <span>'.Params::param('country').'</span></p>' : '';
		$address = ($this->object->get('address')!='') ? '<p><i class="icon icon-address"></i> <em>Dirección :</em> <span>'.$this->object->get('address').'</span></p>' : '';
		$this->object->loadTags();
		return '<div class="itemComplete">
					<h1>'.$this->object->getBasicInfo().'</h1>
					'.Adsense::amp().'
					<div class="itemCompleteInfo">
						'.$shortDescription.'
						'.$description.'
						'.$info.'
						<div class="itemCompleteAddress">
							'.$address.'
							'.$city.'
						</div>
						'.$this->share(array('facebook'=>true, 'twitter'=>true, 'linkedin'=>true, 'title'=>'Compartir en: ')).'
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
					<div class="actionsPlace">
						<div class="actionPlace actionPlace-update">
							<div class="actionPlaceIns">
								<h3>¿Esta empresa es de su propiedad?</h3>
								<p>Actualice la información de la misma de forma gratuita o promocione a su empresa para que salga en los primeros resultados de búsqueda de nuestro sitio.</p>
							</div>
							<a rel="nofollow" href="'.url('modificar/'.$this->object->id()).'"><i class="icon icon-edit"></i> Editar</a>
						</div>
						<div class="actionPlace actionPlace-report">
							<div class="actionPlaceIns">
								<h3>¿Esta información es incorrecta o la empresa no existe?</h3>
								<p>Por favor, escríbanos si los datos de esta empresa no corresponden o si esta información le molesta de alguna manera.</p>
							</div>
							<a rel="nofollow" href="'.url('reportar/'.$this->object->id()).'"><i class="icon icon-warning"></i> Reportar</a>
						</div>
					</div>
					'.Adsense::ampInline().'
				</div>
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
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> <em>Teléfonos :</em> <span>'.$this->object->get('telephone').'</span></p>' : '';
		$info .= ($this->object->get('email')!='') ? '<p class="email"><i class="icon icon-email"></i> <em>Email :</em> <a href="mailto:'.$this->object->get('email').'">'.$this->object->get('email').'</a></p>' : '';
		$info .= ($this->object->get('web')!='') ? '<p class="web"><i class="icon icon-globe"></i> <em>Sitio web :</em> <a href="'.Url::format($this->object->get('web')).'" target="_blank">'.Url::format($this->object->get('web')).'</a></p>' : '';
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription"><strong>'.$this->object->get('shortDescription').'</strong></p>' : '';
		$description = ($this->object->get('description')!='') ? '<p class="description">'.nl2br($this->object->get('description')).'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p><i class="icon icon-city"></i> <em>Ciudad :</em> <a href="'.url('ciudad/'.$this->object->get('cityUrl')).'"><span>'.$this->object->get('city').'</span></a>, <span>'.Params::param('country').'</span></p>' : '';
		$address = ($this->object->get('address')!='') ? '<p><i class="icon icon-address"></i> <em>Dirección :</em> <span>'.$this->object->get('address').'</span></p>' : '';
		$this->object->loadTags();
		return '<div class="itemComplete itemCompletePromoted">
					<div class="itemCompleteIns">
						<h1 >'.$this->object->getBasicInfo().'</h1>
						<div class="itemCompleteWrapper">
							<div class="itemCompleteWrapperLeft">
								'.$this->object->getImageAmp('image', 'web').'
							</div>
							<div class="itemCompleteWrapperRight">
								<div class="itemCompleteInfo">
									'.$shortDescription.'
									'.$description.'
								</div>
							</div>
						</div>
						<div class="itemCompleteInfoWrapper itemCompleteInfo">
							<div class="itemCompleteInfoLeft">
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

	public function renderJsonHeader() {
		$info = array("@context" => "http://schema.org/",
					"@type" => "LocalBusiness",
					"name" => $this->object->getBasicInfo(),
					"image" => $this->object->getImageUrl('image', 'web', BASE_URL.'visual/img/directorio.jpg'),
					"telephone" => $this->object->get('telephone'),
					"address" => array("@type" => "PostalAddress", "streetAddress" => $this->object->get('address'), "addressLocality"=>$this->object->get('city'), "addressRegion"=>Params::param('country'))
					);
		return '<script type="application/ld+json">'.json_encode($info).'</script>';
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
		$query = 'SELECT t.idTag, t.name, t.nameUrl, COUNT(t.idTag) as numElements
					FROM dir_Tag t, dir_PlaceTag pt
					WHERE t.idTag=pt.idTag
					GROUP BY t.nameUrl
					ORDER BY numElements DESC
					LIMIT 36';
		$items = Db::returnAll($query);
		$html = '';
		foreach ($items as $item) {
			$html .= '<a href="'.url('tag/'.$item['idTag'].'-'.$item['nameUrl']).'">'.$item['name'].'</a> ';
		}
		return $html;
	}

}
?>
