<?php
class Place_Ui extends Ui {

	public function renderPublic() {
		if ($this->object->get('promoted')=='1') {
			return $this->renderPublicPromoted();
		}
		$info = '<h2>'.$this->object->getBasicInfo().'</h2>';
		$info .= ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$info .= ($this->object->get('address')!='') ? '<p class="address"><i class="icon icon-address"></i> '.$this->object->get('address').'</p>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> '.$this->object->get('telephone').'</p>' : '';
		$city = ($this->object->get('city')!='') ? '<p class="city"><i class="icon icon-city"></i> <span><a href="'.url('ciudad/'.$this->object->get('cityUrl')).'">'.$this->object->get('city').'</a>, '.Params::param('country').'</span></p>' : '';
		$this->object->loadTags();
		$image = $this->object->getImageAmp('image', 'small');
		return '<div class="itemPublic">
					<div class="itemPublicInfo">
						<a href="'.$this->object->url().'">
							'.(($image!='') ? '
								<div class="itemPublicWrapper">
									<div class="itemPublicWrapperLeft">'.$image.'</div>
									<div class="itemPublicWrapperRight">
										'.$info.'
									</div>
								</div>
							' : $info).'
						</a>
						'.$city.'
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
				</div>';
	}

	public function renderSimple() {
		$info = '<h2>'.$this->object->getBasicInfo().'</h2>';
		$info .= ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$info .= ($this->object->get('address')!='') ? '<p class="address"><i class="icon icon-address"></i> '.$this->object->get('address').'</p>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> '.$this->object->get('telephone').'</p>' : '';
		$info .= ($this->object->get('city')!='') ? '<p class="citySimple"><i class="icon icon-city"></i> <span>'.$this->object->get('city').', '.Params::param('country').'</span></p>' : '';
		return '<div class="itemPublic">
					<div class="itemPublicInfo">
						<a href="'.$this->object->url().'">
							'.$info.'
						</a>
					</div>
				</div>';
	}

	public function renderPublicPromoted() {
		$info = '<h2>'.$this->object->getBasicInfo().'</h2>';
		$info .= ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$info .= ($this->object->get('address')!='') ? '<p class="address"><i class="icon icon-address"></i> '.$this->object->get('address').'</p>' : '';
		$info .= ($this->object->get('telephone')!='') ? '<p class="telephone"><i class="icon icon-telephone"></i> '.$this->object->get('telephone').'</p>' : '';
		$this->object->loadTags();
		$image = $this->object->getImageAmp('image', 'small');
		return '<div class="itemPublic itemPublicPromoted">
					<div class="itemPublicInfo">
						<a href="'.$this->object->url().'">
							'.(($image!='') ? '
								<div class="itemPublicWrapper">
									<div class="itemPublicWrapperLeft">'.$image.'</div>
									<div class="itemPublicWrapperRight">
										'.$info.'
									</div>
								</div>
							' : '<div class="itemPublicWrapperSimple">'.$info.'</div>').'
							<div class="itemPublicPromotedStar">
								<i class="icon icon-promotion"></i>
								<span>Promocionada</span>
							</div>
						</a>
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
				</div>';
	}

	public function renderComplete() {
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$description = ($this->object->get('description')!='') ? '<div class="description">'.$this->object->get('description').'</div>' : '';
		$this->object->loadTags();
		$image = $this->object->getImageAmp('image', 'small');
		$image = ($image!='') ? '<div class="descriptionTopImage">'.$image.'</div>' : '';
		return '<div class="itemComplete">
					<h1>'.$this->object->getBasicInfo().'</h1>
					'.Adsense::amp().'
					<div class="itemCompleteInfo">
						'.(($image!='' || $shortDescription!='') ? '
						<div class="descriptionTop">
							'.$image.'
							'.$shortDescription.'
						</div>
						' : '').'
						<div class="infoBlocks infoBlocksAddress">
							'.$this->renderInfoBlock('address', 'Dirección').'
							'.$this->renderInfoBlock('city', 'Ciudad').'
						</div>
						<div class="infoBlocks">
							'.$this->renderInfoBlock('telephone', 'Teléfono').'
							'.$this->renderInfoBlock('mobile', 'Móvil').'
							'.$this->renderInfoBlock('whatsapp', 'Whatsapp').'
						</div>
						<div class="infoBlocks">
							'.$this->renderInfoBlock('email', 'Email').'
							'.$this->renderInfoBlock('web', 'Sitio web').'
						</div>
						'.$this->renderInfoBlockIcons().'
						'.$description.'
						'.$this->share(array('facebook'=>true, 'twitter'=>true, 'linkedin'=>true, 'title'=>'Compartir en: ')).'
					</div>
					<div class="tagsPlace">
						'.$this->object->tags->showList(array('function'=>'Public')).'
					</div>
					<div class="actionsPlace">
						<div class="actionPlace actionPlace-update">
							<a rel="nofollow" href="'.url('modificar/'.$this->object->id()).'">
								<img src="'.BASE_URL.'visual/img/owner.svg"/>
								<div class="actionPlaceIns">
									<h3>¿Esta empresa es de su propiedad?</h3>
									<p>Actualice la información de la misma de forma gratuita o promocione a su empresa para que salga en los primeros resultados de búsqueda de nuestro sitio.</p>
									<span class="actionsPlaceButtonWrapper">
										<span class="actionsPlaceButton"><i class="icon icon-edit"></i> Editar</span>
									</span>
								</div>
							</a>
						</div>
						<div class="actionPlace actionPlace-report">
							<a rel="nofollow" href="'.url('reportar/'.$this->object->id()).'">
								<img src="'.BASE_URL.'visual/img/warning.svg"/>
								<div class="actionPlaceIns">
									<h3>¿Esta información es incorrecta o la empresa no existe?</h3>
									<p>Por favor, escríbanos si los datos de esta empresa no corresponden o si esta información le molesta de alguna manera.</p>
									<span class="actionsPlaceButtonWrapper">
										<span class="actionsPlaceButton"><i class="icon icon-warning"></i> Reportar</span>
									</span>
								</div>
							</a>
						</div>
					</div>
					'.Adsense::ampInline().'
				</div>
				'.$this->renderRelated();
	}

	public function renderCompletePromoted() {
		$shortDescription = ($this->object->get('shortDescription')!='') ? '<p class="shortDescription">'.$this->object->get('shortDescription').'</p>' : '';
		$description = ($this->object->get('description')!='') ? '<div class="description">'.$this->object->get('description').'</div>' : '';
		$this->object->loadTags();
		$image = $this->object->getImageAmp('image', 'small');
		$image = ($image!='') ? '<div class="descriptionTopImage">'.$image.'</div>' : '';
		return '<div class="itemComplete itemCompletePromoted">
					<div class="itemCompleteIns">
						<h1 >'.$this->object->getBasicInfo().'</h1>
						<div class="itemCompleteInfo">
							<div class="descriptionTop">
								'.$image.'
								'.$shortDescription.'
							</div>
							<div class="infoBlocks infoBlocksAddress">
								'.$this->renderInfoBlock('address', 'Dirección').'
								'.$this->renderInfoBlock('city', 'Ciudad').'
							</div>
							<div class="infoBlocks">
								'.$this->renderInfoBlock('telephone', 'Teléfono').'
								'.$this->renderInfoBlock('mobile', 'Móvil').'
								'.$this->renderInfoBlock('whatsapp', 'Whatsapp').'
							</div>
							<div class="infoBlocks">
								'.$this->renderInfoBlock('email', 'Email').'
								'.$this->renderInfoBlock('web', 'Sitio web').'
							</div>
							'.$this->renderInfoBlockIcons().'
							'.$description.'
							'.$this->share(array('facebook'=>true, 'twitter'=>true, 'linkedin'=>true, 'title'=>'Compartir en: ')).'
						</div>
						<div class="tagsPlace">
							'.$this->object->tags->showList(array('function'=>'Public')).'
						</div>
					</div>
				</div>';
	}

	public function renderInfoBlock($attribute, $label) {
		$value = $this->object->get($attribute);
		if ($attribute=='telephone' || $attribute=='mobile') {
			$value = str_replace(';', ',', $value);
			$items = explode(',', $value);
			$value = '';
			foreach ($items as $item) {
				$item = str_replace(' ', '', $item);
				$value .= '<a href="tel:'.$item.'" class="infoBlockNoWrap">'.$item.'</a> ';
			}
		}
		if ($attribute=='email') {
			$value = '<a href="mailto:'.$value.'">'.$value.'</a>';
		}
		if ($attribute=='web') {
			$value = '<a href="mailto:'.Url::format($value).'">'.Url::format($value).'</a>';
		}
		if ($attribute=='whatsapp') {
			$value = '<a href="https://api.whatsapp.com/send?phone='.urlencode($value).'">'.$value.'</a>';
		}
		return ($this->object->get($attribute)!='') ? '
				<div class="infoBlock">
					<i class="icon icon-'.$attribute.'"></i>
					<div class="infoBlockIns">
						<strong>'.$label.' :</strong>
						<span>'.$value.'</span>
					</div>
				</div>' : '';
	}

	public function renderInfoBlockIcons() {
		if ($this->object->get('facebook')!='' || $this->object->get('instagram')!='' || $this->object->get('youtube')!='' || $this->object->get('twitter')!='') {
			return '<div class="infoBlocksIcons">
						'.$this->renderInfoBlockIcon('facebook', 'Facebook').'
						'.$this->renderInfoBlockIcon('instagram', 'Instragram').'
						'.$this->renderInfoBlockIcon('youtube', 'Youtube').'
						'.$this->renderInfoBlockIcon('twitter', 'Twitter').'
					</div>';
		}
	}

	public function renderInfoBlockIcon($attribute, $label) {
		$value = $this->object->get($attribute);
		$url = Url::format($value);
		return ($this->object->get($attribute)!='') ? '
				<div class="infoBlockIcon">
					<a href="'.$url.'" class="infoBlockIconIns" target="_blank">
						<i class="icon icon-'.$attribute.'"></i>
						<span>'.$label.'</span>
					</a>
				</div>' : '';
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
				<div style="width: 120px; height: 10px; background: #efefef; margin: 30px 0;"> </div>';
	}

	public function renderRelated() {
		$where = '1=1';
		if ($this->object->get('related')!='') {
			$whereRelated = [];
			foreach (explode(',', $this->object->get('related')) as $item) {
				$whereRelated[] = 'idPlace="'.$item.'"';
			}
			$where = (count($whereRelated) > 0) ? join($whereRelated, ' OR ') : $where;
		}
		$items = new ListObjects('Place', ['where'=>$where, 'limit'=>'5']);
		return '<div class="related">
					<h3 class="title">Vea también :</h3>
					'.$items->showList().'
				</div>';
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
		return Place_Ui::renderCitiesOptions();
	}

	/**
	* @cache
	*/
	static public function renderCitiesTag() {
		return Place_Ui::renderCitiesOptions(['urlBase'=>'ciudad-tag']);
	}

	static public function renderCitiesOptions($options=[]) {
		$query = 'SELECT dir_Place.city, dir_Place.cityUrl, COUNT(dir_Place.idPlace) as numElements
					FROM dir_Place
					GROUP BY dir_Place.cityUrl
					HAVING numElements>20
					ORDER BY numElements DESC
					LIMIT 24';
		$items = Db::returnAll($query);
		$html = '';
		$urlBase = (isset($options['urlBase'])) ? $options['urlBase'] : 'ciudad';
		foreach ($items as $item) {
			$html .= ($item['city']!='') ? '<a href="'.url($urlBase.'/'.$item['cityUrl']).'">'.$item['city'].'</a> ' : '';
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
					HAVING numElements>2
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
					LIMIT 24';
		$items = Db::returnAll($query);
		$html = '';
		foreach ($items as $item) {
			$html .= '<a href="'.url('tag/'.$item['idTag'].'-'.$item['nameUrl']).'">'.$item['name'].'</a> ';
		}
		return $html;
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
