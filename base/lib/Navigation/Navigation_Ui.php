<?php
class Navigation_Ui extends Ui {

	public function render() {
		$layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
		$title = (isset($this->object->titlePage)) ? '<h1>'.$this->object->titlePage.'</h1>' : '';
		$title = (isset($this->object->titlePageHtml)) ? '<h1>'.$this->object->titlePageHtml.'</h1>' : $title;
		$message = (isset($this->object->message)) ? '<div class="message">'.$this->object->message.'</div>' : '';
		$messageError = (isset($this->object->messageError)) ? '<div class="message messageError">'.$this->object->messageError.'</div>' : '';
		$messageInfo = (isset($this->object->messageInfo)) ? '<div class="message messageInfo">'.$this->object->messageInfo.'</div>' : '';
		$content = (isset($this->object->content)) ? $this->object->content : '';
		$amp = ($layoutPage=='amp' || (isset($this->object->mode) && $this->object->mode=='amp')) ? true : false;
		switch ($layoutPage) {
			default:
				return $this->header($amp).'
						<div class="contentWrapper">
							<div class="contentLeft">
								'.$this->breadCrumbs().'
								'.$title.'
								'.$message.'
								'.$messageError.'
								'.$messageInfo.'
								'.(($amp) ? Adsense::amp() : Adsense::top()).'
								'.$content.'
							</div>
							<div class="contentRight">
								'.(($amp) ? Adsense::ampInline() : Adsense::side()).'
								'.$this->contentSide().'
							</div>
						</div>
						'.$this->footer();
			break;
			case 'intro':
				return $this->header($amp).'
						'.$message.'
						'.$messageError.'
						'.$messageInfo.'
						'.$content.'
						'.$this->footer();
			break;
			case 'place':
				return $this->header(true).'
						<div class="contentWrapper">
							<div class="contentLeft">
								'.$this->breadCrumbs().'
								'.$message.'
								'.$messageError.'
								'.$messageInfo.'
								'.$content.'
							</div>
							<div class="contentRight">
								'.Adsense::ampInline().'
								'.$this->contentSide().'
							</div>
						</div>
						'.$this->footer();
			break;
			case 'promoted':
				return '<div class="pagePromoted">
							<div class="pagePromotedBackground" style="background-color:'.$this->object->place->get('colorBackground').';">
								<div class="pagePromotedBackgroundMask">
									'.$this->header(true).'
									'.$content.'
								</div>
							</div>
							'.$this->footer().'
						</div>';
			break;
			case 'simple':
				return $this->header().'
						<div class="contentWrapper contentWrapperSimple contentWrapper-'.$layoutPage.'">
							'.$title.'
							'.$message.'
							'.$messageError.'
							'.$messageInfo.'
							'.$content.'
						</div>
						'.$this->footer();
			break;
			case 'clean':
			case 'promotion':
				return $this->header().'
						<div class="contentWrapper contentWrapperSimple contentWrapper-'.$layoutPage.'">
							'.$content.'
						</div>
						'.$this->footer();
			break;
			case 'message':
				return $this->header().'
						<div class="contentWrapper contentWrapperMessage contentWrapper-simple">
							<div class="message">
								'.$title.'
								<div class="messageIns">
									'.$this->object->message.'
								</div>
							</div>
							<div class="buttonHome">
								<a href="'.url('').'">
									<span>Ir a la página de inicio</span>
									<i class="icon icon-arrow-right"></i>
								</a>
							</div>
						</div>
						'.$this->footer();
			break;
		}
	}

	public function header($amp=false) {
		$subscribeTop = '';
		$layoutPage = (isset($this->object->layoutPage)) ? $this->object->layoutPage : '';
		if ($this->object->action!='inscribir' && $layoutPage!='simple') {
			$subscribeTop = '<div class="subscribeTop">
								<a href="'.url('inscribir').'"><i class="icon icon-edit"></i> Inscribir a mi empresa</a>
							</div>';
		}
		return '<header class="header">
					<div class="headerIns">
				        <div class="headerLeft">
					    	<div class="logo">
					    		<a href="'.url('').'">
					    			<strong>'.Params::param('titlePage').'</strong>
					    			<span>'.Params::param('country').'</span>
					    		</a>
					    	</div>
				        </div>
				        <div class="headerRight">
							'.$subscribeTop.'
							<div class="searchTop">
								'.(($amp) ? Navigation_Ui::searchAmp() : Navigation_Ui::search()).'
							</div>
						</div>
					</div>
				</header>';
	}

	public function footer() {
		$place = new Place();
		return '<footer class="footer">
					<div class="footerIns">
						<div class="footerListWrapper">
							<div class="footerList footerCities">
								<div class="footerTitle">Ciudades de '.Params::param('country').'</div>
								<div class="footerListItems">
									'.$place->showUi('cities').'
								</div>
							</div>
							<div class="footerList footerCountries">
								<div class="footerTitle">Otros directorios</div>
								<div class="footerListItems">
									<p>
										<a href="http://www.argentina-directorio.com" target="_blank" title="Directorio de empresas de Argentina">Argentina</a>
										<a href="http://www.directorio.com.bo" target="_blank" title="Directorio de empresas de Bolivia">Bolivia</a>
										<a href="http://www.directorio-chile.com" target="_blank" title="Directorio de empresas de Chile">Chile</a>
										<a href="http://www.colombia-directorio.com" target="_blank" title="Directorio de empresas de Colombia">Colombia</a>
										<a href="http://www.ecuador-directorio.com" target="_blank" title="Directorio de empresas de Ecuador">Ecuador</a>
										<a href="http://www.directorio-guatemala.com" target="_blank" title="Directorio de empresas de Guatemala">Guatemala</a>
										<a href="http://www.directorio-honduras.com" target="_blank" title="Directorio de empresas de Honduras">Honduras</a>
										<a href="http://www.mexico-directorio.com" target="_blank" title="Directorio de empresas de México">México</a>
										<a href="http://www.directorio-panama.com" target="_blank" title="Directorio de empresas de Panamá">Panamá</a>
										<a href="http://www.paraguay-directorio.com" target="_blank" title="Directorio de empresas de Paraguay">Paraguay</a>
										<a href="http://www.peru-directorio.com" target="_blank" title="Directorio de empresas de Perú">Perú</a>
										<a href="http://www.telefono.do" target="_blank" title="Directorio de empresas de República Dominicana">República Dominicana</a>
										<a href="http://www.uruguay-directorio.com" target="_blank" title="Directorio de empresas de Uruguay">Uruguay</a>
										<a href="http://www.venezuela-directorio.com" target="_blank" title="Directorio de empresas de Venezuela">Venezuela</a>
									</p>
								</div>
							</div>
							<div class="clearer"></div>
						</div>
						<div class="footerDown">
							<div class="btnContact">
								<a href="'.url('inscribir').'">Inscribir a mi empresa</a>
							</div>
							<div class="footerDownIns">
								'.str_replace('#EMAIL', Params::param('email'), str_replace('#COUNTRY', Params::param('country'), HtmlSection::showFile('footer'))).'
							</div>
						</div>
					</div>
					<div class="datajs">
						<div class="datajs datajs-tag" data-url="'.url('tag-autocomplete').'"></div>
					</div>
				</footer>';
	}

	public function contentSide() {
		$place = new Place();
		return '<aside class="contentSide">
					<h2>Categorías más buscadas</h2>
					'.$place->showUi('Tags').'
				</aside>';
	}

	static public function search() {
		return '<form action="'.url('buscar').'" method="post" enctype="multipart/form-data" class="formSearchSimple" accept-charset="UTF-8">
					<fieldset>
						<div class="text formField">
							<input type="search" name="search" size="50" placeholder="Buscar..."/>
						</div>
						<div class="formFieldSubmit">
							<button type="submit" class="formSubmit">
							<i class="icon icon-search"></i><span>Buscar</span>
							</button>
						</div>
					</fieldset>
				</form>';
	}

	static public function searchAmp() {
		return '<form accept-charset="UTF-8" class="formSearchSimple" action="'.url('buscar').'" method="GET" target="_top">
					<fieldset>
						<div class="text formField">
							<input type="search" name="search" size="50" placeholder="Buscar..."/>
						</div>
						<div class="formFieldSubmit">
							<button type="submit" class="formSubmit">
							<i class="icon icon-search"></i><span>Buscar</span>
							</button>
						</div>
					</fieldset>
				</form>';
	}

	public function breadCrumbs() {
		$html = '';
		if (isset($this->object->breadCrumbs) && is_array($this->object->breadCrumbs)) {
			$html .= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="'.url('').'" itemprop="url"><span itemprop="title">Inicio</span></a>
					</span> &raquo;';
			foreach ($this->object->breadCrumbs as $url=>$title) {
				$html .= '<span itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
								<a href="'.$url.'" itemprop="url"><span itemprop="title">'.$title.'</span></a>
							</span> &raquo;';
			}
			return '<div class="breadcrumbs">
						'.substr($html, 0, -8).'
					</div>';
		}
	}

	static public function analytics() {
		return '<script async src="https://www.googletagmanager.com/gtag/js?id='.Params::param('metainfo-google-analytics').'"></script>
			    <script>
			      window.dataLayer = window.dataLayer || [];
			      function gtag(){dataLayer.push(arguments);}
			      gtag(\'js\', new Date());
			      gtag(\'config\', \''.Params::param('metainfo-google-analytics').'\');
			    </script>';
	}

	static public function analyticsAmp() {
		return '<amp-analytics type="googleanalytics">
			<script type="application/json">{"vars": {"account": "'.Params::param('metainfo-google-analytics').'"}, "triggers": { "trackPageview": { "on": "visible", "request": "pageview"}}}</script>
		</amp-analytics>';
	}

	static public function autoadsAmp() {
		return '<amp-auto-ads type="adsense" data-ad-client="ca-pub-7429223453905389"></amp-auto-ads>';
	}

}
?>
