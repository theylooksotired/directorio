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
		switch ($layoutPage) {
			default:
				return $this->header().'
						<div class="contentWrapper">
							<div class="contentLeft">
								'.$this->breadCrumbs().'
								'.$title.'
								'.$message.'
								'.$messageError.'
								'.$messageInfo.'
								'.Adsense::top().'
								'.$content.'
							</div>
							<div class="contentRight">
								'.Adsense::side().'
								'.$this->contentSide().'
							</div>
						</div>
						'.$this->footer();
			break;
			case 'intro':
				return $this->header().'
						'.$message.'
						'.$messageError.'
						'.$messageInfo.'
						'.$content.'
						'.$this->footer();
			break;
			case 'place':
				return $this->header().'
						<div class="contentWrapper">
							<div class="contentLeft">
								'.$this->breadCrumbs().'
								'.$message.'
								'.$messageError.'
								'.$messageInfo.'
								'.$content.'
							</div>
							<div class="contentRight">
								'.Adsense::side().'
								'.$this->contentSide().'
							</div>
						</div>
						'.$this->footer();
			break;
			case 'promoted':
				return '<div class="pagePromoted">
							<div class="pagePromotedBackground" style="background-color:'.$this->object->place->get('colorBackground').';">
								<div class="pagePromotedBackgroundMask">
									'.$this->header().'
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

	public function header() {
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
								'.Navigation_Ui::search().'
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
									'.HtmlSection::showFile('countries').'
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
						<div class="datajs datajs-tag" data-url="'.url('tag').'"></div>
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

}
?>
