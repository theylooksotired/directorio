<?php
class Navigation_Controller extends Controller{

    public function __construct($GET, $POST, $FILES) {
        parent::__construct($GET, $POST, $FILES);
        $this->adsenseFullPageActive = false;
        $this->ui = new Navigation_Ui($this);
    }

    public function controlActions(){
        switch ($this->action) {
            default:
            	$this->adsenseFullPageActive = true;
                if ($this->action!='') {
                    $this->layoutPage = 'place';
                    $info = explode('-', $this->action);
                    $item = Place::read($info[0]);
                    if ($item->id()!='') {
                        $this->titlePage = $item->getBasicInfo();
                        $this->metaUrl = $item->url('');
                        $this->metaImage = $item->get('image', 'web');
                        $this->metaDescription = 'Dirección, teléfonos, email e información de '.$item->getBasicInfo().' en '.$item->get('city').' '.Params::param('country');
                        $this->metaKeywords = 'directorio, directorio de empresas, guía, guía empresarial, dirección, teléfonos, email, empresa, '.$item->getBasicInfo().', '.$item->get('city').', '.Params::param('country');
                        $this->place = $item;
                        $this->content = ($item->get('promoted')=='1') ? $item->showUi('CompletePromoted') : $item->showUi('Complete');
                        $this->layoutPage = ($item->get('promoted')=='1') ? 'promoted' : $this->layoutPage;
                        $this->breadCrumbs = array(url('ciudad')=>'Ciudades', url('ciudad/'.$item->get('cityUrl'))=>$item->get('city'), $item->url()=>$item->getBasicInfo());
                        return $this->ui->render();
                    } else {
                        header("HTTP/1.1 301 Moved Permanently"); 
                        header('Location: '.url(''));
                    }
                } else {                
                    header("HTTP/1.1 301 Moved Permanently"); 
                    header('Location: '.url(''));
                }
            break;
            case 'intro':
            	$place = new Place();
                $this->layoutPage = 'intro';
                $this->content = '<div class="searchMainWrapper" style="background-image: url('.BASE_URL.'visual/img/cover-'.Params::param('countryCode').'.jpg);">
                                        <div class="searchMain">
                                            <div class="searchMainIns">    
                                                '.Navigation_Ui::search().'
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentWrapper contentWrapperIntro">
                                        '.Adsense::top().'
                                        <div class="introPage">
                                            <div class="introPageLeft">
                                                <div class="introPageLeftTop">
                                                    <h1>'.Params::param('titlePage').'</h1>
                                                    '.str_replace('#LINK_SUSCRIBE', url('inscribir'), str_replace('#COUNTRY', Params::param('country'), HtmlSection::showFile('intro'))).'
                                                </div>
                                                <div class="introPageLeftTop">
                                                    '.$place->showUi('IntroPlaces').'
                                                </div>
                                            </div>
                                            <div class="introPageRight">
                                                '.Adsense::side().'
                                                '.$this->ui->contentSide().'
                                            </div>
                                            <div class="clearer"></div>
                                        </div>
                                    </div>';
                return $this->ui->render();
            break;
            case 'promocion':
                $this->layoutPage = 'clean';
            	$this->titlePage = 'Promocione a su empresa';
                $this->content = '<div class="promotion promotionMain">
										<div class="promotionIns">
											'.HtmlSection::showFile('promotion').'
											<div class="promotionButton">
												<a href="'.url('inscribir').'">Inscriba a su empresa</a>
											</div>
										</div>
									</div>';
                return $this->ui->render();
            break;
            case 'ciudad':
            	$this->adsenseFullPageActive = true;
                $items = new ListObjects('Place', array('where'=>'cityUrl="'.$this->id.'" AND cityUrl!=""', 'order'=>'promoted DESC, titleUrl', 'results'=>'10'));
                if ($items->isEmpty()) {
                    $place = new Place();
                    $this->titlePage = 'Ciudades de '.Params::param('country');
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action);
                    $this->breadCrumbs = array(url('ciudad')=>'Ciudades');
                    $this->content = '<div class="cityList">
                                            '.$place->showUi('CitiesComplete').'
                                        </div>';
                } else {
                    $list = $items->list;
                    $item = $list[0];
                    $page = (isset($_GET['pagina']) && $_GET['pagina']!='') ? ' - Página '.(intval($_GET['pagina'])) : '';
                    $this->titlePage = 'Teléfonos y direcciones de empresas en '.$item->get('city').', '.Params::param('country');
                    $this->titlePageHtml = '<span>Teléfonos y direcciones de empresas en</span> '.$item->get('city').' <em>'.Params::param('country').'</em>';
                    $this->header = $items->metaNavigation();
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action.'/'.$this->id);
                    $this->breadCrumbs = array(url('ciudad')=>'Ciudades', url('ciudad/'.$item->get('cityUrl'))=>$item->get('city'));
                    $this->content = $items->showList(array('function'=>'Public', 'middle'=>Adsense::inline())).'
                                    '.$items->pager();
                }
                return $this->ui->render();
            break;
            case 'tag':
            	$this->adsenseFullPageActive = true;
                $page = (isset($_GET['pagina']) && $_GET['pagina']!='') ? ' - Página '.(intval($_GET['pagina'])) : '';
                $info = explode('-', $this->id);
                $item = Tag::read($info[0]);
                if ($item->id()!='') {
                    if ($this->extraId!='') {
                        $city = Place::readFirst(array('where'=>'cityUrl="'.$this->extraId.'"'));
                        $this->titlePage = $item->getBasicInfo().' en '.$city->get('city').', '.Params::param('country').$page;
                        $this->titlePageHtml = '<span>'.$city->get('city').', '.Params::param('country').'</span> '.$item->getBasicInfo();
                        $query = 'SELECT dir_Place.* FROM dir_Place
                                JOIN dir_PlaceTag ON dir_Place.idPlace=dir_PlaceTag.idPlace
                                WHERE dir_PlaceTag.idTag="'.$item->id().'"
                                AND dir_Place.cityUrl="'.$this->extraId.'"
                                ORDER BY dir_Place.promoted DESC, dir_Place.titleUrl';
                        $queryCount = 'SELECT COUNT(dir_Place.idPlace) as numElements FROM dir_Place
                                        JOIN dir_PlaceTag ON dir_Place.idPlace=dir_PlaceTag.idPlace
                                        WHERE dir_PlaceTag.idTag="'.$item->id().'"
                                        AND dir_Place.cityUrl="'.$this->extraId.'"';
                        $this->breadCrumbs = array($item->url()=>$item->getBasicInfo(), $item->url().'/'.$city->get('cityUrl')=>$city->get('city'));
                    } else {
                        $this->titlePage = 'Teléfonos y direcciones en '.Params::param('country').' sobre '.strtolower($item->getBasicInfo()).$page;
                        $this->titlePageHtml = '<span>Teléfonos y direcciones en '.Params::param('country').' sobre</span> '.$item->getBasicInfo();
                        $query = 'SELECT dir_Place.* FROM dir_Place
                                JOIN dir_PlaceTag ON dir_Place.idPlace=dir_PlaceTag.idPlace
                                WHERE dir_PlaceTag.idTag="'.$item->id().'"
                                ORDER BY dir_Place.promoted DESC, dir_Place.titleUrl';
                        $queryCount = 'SELECT COUNT(dir_Place.idPlace) as numElements FROM dir_Place
                                        JOIN dir_PlaceTag ON dir_Place.idPlace=dir_PlaceTag.idPlace
                                        WHERE dir_PlaceTag.idTag="'.$item->id().'"';
                        $this->breadCrumbs = array($item->url()=>$item->getBasicInfo());
                    }
                    $items = new ListObjects('Place', array('query'=>$query, 'queryCount'=>$queryCount, 'results'=>'10'));
                    $this->header = $items->metaNavigation();
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action.'/'.$this->id);
                    $this->content = $item->showUi('Cities').'
                                    '.$items->showList(array('function'=>'Public', 'middle'=>Adsense::inline())).'
                                    '.$items->pager();
                    return $this->ui->render();                
                } else {
                    $item = Tag::readFirst(array('where'=>'nameUrl="'.$this->id.'"'));
                    if ($item->id()!='') {
                        header("HTTP/1.1 301 Moved Permanently"); 
                        header('Location: '.$item->url());
                    } else {
                        header("HTTP/1.1 301 Moved Permanently"); 
                        header('Location: '.url(''));                        
                    }
                }
            break;
            case 'web':
                $item = Place::readFirst(array('where'=>'titleUrl="'.$this->id.'"'));
                if ($item->id()!='') {
                    header("HTTP/1.1 301 Moved Permanently"); 
                    header('Location: '.$item->url());
                } else {
                    header("HTTP/1.1 301 Moved Permanently"); 
                    header('Location: '.url(''));                        
                }
            break;
            case 'buscar':
                if (isset($this->values['search']) && $this->values['search']!='') {
                    $search = Text::simpleUrl($this->values['search']);
                    header('Location: '.url('buscar/'.$search));
                    exit();
                }
                if ($this->id!='') {
                    $search = str_replace('-', ' ', Text::simpleUrl($this->id));
                    $this->titlePage = 'Resultados de la busqueda - '.ucwords($search);
                    $this->titlePageHtml = '<span>Resultados de la busqueda</span> '.ucwords($search);
                    $items = new ListObjects('Place', array('where'=>'MATCH (search) AGAINST ("'.$search.'") OR search LIKE ("%'.$search.'%")', 'order'=>'promoted DESC, MATCH (search) AGAINST ("'.$search.'") DESC', 'results'=>'10'));
                    if ($items->isEmpty()) {
                        $items = new ListObjects('Place', array('where'=>'search LIKE ("%'.$search.'%")', 'order'=>'promoted DESC, titleUrl', 'results'=>'10'));
                    }
                    $this->content = $items->showListPager(array('function'=>'Public', 'message'=>'<div class="message">Lo sentimos, pero no encontramos resultados para su busqueda.</div>', 'middle'=>Adsense::inline()));
                    return $this->ui->render();
                } else {
                    header("HTTP/1.1 301 Moved Permanently"); 
                    header('Location: '.url(''));
                }
            break;
            case 'terminos-condiciones':
                $this->layoutPage = 'simple';
                $this->titlePage = 'Términos y condiciones';
                $this->metaDescription = 'Términos y condiciones del sitio '.Params::param('titlePage');
                $this->metaKeywords = 'terminos, condiciones, legal, directorio, empresas';
                $this->content = HtmlSection::showFile('terms');
                return $this->ui->render();
            break;




            /**
            * PUBLIC ADMIN
            */
            case 'inscribir':
                $this->layoutPage = 'simple';
                $this->titlePage = 'Inscriba a su empresa en nuestro directorio';
                $this->metaDescription = 'Inscriba de forma totalmente gratuita a su empresa en nuestro directorio.';
                $this->activateJS();
                $placeEditForm = new PlaceEdit_Form();
                if (count($this->values)>0) {
                    $placeEditForm = new PlaceEdit_Form($this->values);
                    $errors = $placeEditForm->isValid();
                    $this->checkCaptcha($errors);
                    if (count($errors) > 0) {
                        $this->messageError = 'Lo sentimos, pero hay errores en el formulario que debe corregir.';
                        $placeEditForm = new PlaceEdit_Form($this->values, $errors);
                    } else {
                        $placeEdit = new PlaceEdit();
                        $placeEdit->insertMail($this->values);
                        $placeEdit = PlaceEdit::read($placeEdit->id());
                        if ($this->values['choicePromotion']=='promoted') {
                            $order = new Order();
                            $order->insert(array('idPlaceEdit'=>$placeEdit->id(),
                                                'name'=>$placeEdit->get('nameEditor'),
                                                'email'=>$placeEdit->get('emailEditor'),
                                                'paymentType'=>'0',
                                                'price'=>'10',
                                                'payed'=>'0'));
                            $order = Order::read($order->id());
                            switch($this->values['choicePayment']) {
                                default:
                                    $placeEdit->sendEmail($placeEdit->get('emailEditor'), 'welcomePlaceEditTransference');
                                    header('Location: '.url('transferencia'));
                                break;
                                case 'khipu':
                                	$order->modifySimple('paymentType', '1');
                                    $placeEdit->sendEmail($placeEdit->get('emailEditor'), 'welcomePlaceEditKhipu');
                                    $order->khipuRequest();
                                break;
                                case 'paypal':
                                	$order->modifySimple('paymentType', '2');
                                    $placeEdit->sendEmail($placeEdit->get('emailEditor'), 'welcomePlaceEditPayPal');
                                    $order->paypalRequest();
                                break;
                            }
                        } else {
                            $placeEdit->sendEmail($placeEdit->get('emailEditor'), 'welcomePlaceEditFree');
                            header('Location: '.url('inscribir-gracias'));
                        }
                        exit();
                    }
                }
                $this->content = HtmlSection::showFile('inscribirTop').'
                                '.$placeEditForm->createPublic();
                return $this->ui->render();
            break;
            case 'modificar':
            case 'promocionar':
                $this->layoutPage = 'simple';
                $this->activateJS();
                $this->header .= '<meta name="robots" content="noindex,nofollow"/>';
                $place = Place::read($this->id);
                if ($place->id()!='') {
                    $placeEditForm = new PlaceEdit_Form();
                    if ($this->action=='modificar') {
                        $this->titlePage = 'Actualizar la información de '.$place->getBasicInfo();
                        $this->titlePageHtml = '<span>Actualizar la información de</span> '.$place->getBasicInfo();
                        $this->content = ($place->get('promoted')=='1') ? $placeEditForm->createPublicPromoted($place) : $placeEditForm->createPublic($place);
                    } else {
                        if ($place->get('promoted')=='1') {
                            $this->titlePage = 'Esta empresa ya se encuentra promocionada';
                            $this->messageError = 'La misma se puede encontrar en<br><a href="'.$place->url().'">'.$place->url().'</a>';
                            return $this->ui->render();
                        }
                        $this->titlePage = 'Promocionar la información de '.$place->getBasicInfo();
                        $this->titlePageHtml = '<span>Promocionar la información de</span> '.$place->getBasicInfo();
                        $this->content = $placeEditForm->createPublicPromote($place);
                    }
                    if (count($this->values)>0) {
                        $placeEditForm = new PlaceEdit_Form($this->values);
                        $errors = $placeEditForm->isValid();
                        $this->checkCaptcha($errors);
                        if (count($errors)>0) {
                            $this->messageError = 'Lo sentimos, pero hay errores en el formulario que debe corregir.';
                            $placeEditForm = new PlaceEdit_Form($this->values, $errors);
                            if ($this->action=='modificar') {
                                $this->content = ($place->get('promoted')=='1') ? $placeEditForm->createPublicPromoted() : $placeEditForm->createPublic();
                            } else {
                                $this->content = $placeEditForm->createPublicPromote();
                            }
                        } else {
                            $this->values['idPlace'] = $place->id();
                            if (!(isset($this->files['image']['name']) && $this->files['image']['name']!='')) {
                                $this->values['image'] = $place->getImageUrl('image', 'huge');
                            }
                            $placeEdit = new PlaceEdit();
                            if ($place->get('promoted')=='1') {
                                $placeEdit->insertMailPromoted($this->values);
                            } else {
                                $placeEdit->insertMail($this->values);
                            }
                            $placeEdit = PlaceEdit::read($placeEdit->id());
                            $placeEdit->sendEmail($placeEdit->get('emailEditor'), 'modifyPlaceEdit');
                            if ((isset($this->values['choicePromotion']) && $this->values['choicePromotion']=='promoted') || $this->action=='promocionar') {
                                $order = new Order();
                                $order->insert(array('idPlaceEdit'=>$placeEdit->id(),
                                                    'name'=>$placeEdit->get('nameEditor'),
                                                    'email'=>$placeEdit->get('emailEditor'),
                                                    'paymentType'=>'0',
                                                    'price'=>'10',
                                                    'payed'=>'0'));
                                $order = Order::read($order->id());
                                switch($this->values['choicePayment']) {
                                    default:
                                        header('Location: '.url('transferencia'));
                                    break;
                                    case 'khipu':
                                    	$order->modifySimple('paymentType', '1');
                                        $order->khipuRequest();
                                    break;
                                    case 'paypal':
                                    	$order->modifySimple('paymentType', '2');
                                        $order->paypalRequest();
                                    break;
                                }
                            } else {
                                header('Location: '.url('modificar-gracias'));
                            }
                            exit();
                        }
                    }
                } else {
                    $this->titlePage = 'La empresa no existe';
                    $this->messageError = 'Lo sentimos, pero la empresa no existe.';
                }
                return $this->ui->render();
            break;
            case 'paypal':
                $this->header = '<meta name="robots" content="noindex,nofollow"/>';
                $url = url('');
                $order = Order::readFirst(array('where'=>'MD5(CONCAT("plasticwebs_'.$this->id.'",idOrder))="'.$this->extraId.'"'));
                $place = Place::read($order->get('idPlace'));
                $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                if ($order->id()!='') {
                    switch ($this->id) {
                        case 'pagado':
                            $order->modifySimple('payed', '1');
                            HtmlMail::sendFromFile($order->get('email'), 'payedThanks', array('NAME'=>$order->get('name')));
                            if ($place->id()!='') {
                                $place->sendEmail(Params::param('email'), 'payedPlace');
                                $url = url('pago-gracias/'.$order->encodeId());
                            } else {
                                $placeEdit->sendEmail(Params::param('email'), 'payedPlaceEdit');
                                $url = url('pago-espera-gracias/'.$order->encodeId());
                            }
                        break;
                        case 'anulado':
                            if ($place->id()!='') {
                                $url = url('pago-anulado/'.$order->encodeId());
                            } else {
                                $url = url('pago-espera-anulado/'.$order->encodeId());
                            }
                        break;
                    }
                }
                header('Location: '.$url);
                exit();
            break;
            case 'khipu':
                $this->header = '<meta name="robots" content="noindex,nofollow"/>';
                $url = url('');
                $order = Order::readFirst(array('where'=>'MD5(CONCAT("plasticwebs_'.$this->id.'",idOrder))="'.$this->extraId.'"'));
                $place = Place::read($order->get('idPlace'));
                $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                if ($order->id()!='') {
                    switch ($this->id) {
                        case 'pagado':
                            $url = url('pago-confirmacion/'.$order->encodeId());
                        break;
                        case 'anulado':
                            if ($place->id()!='') {
                                $url = url('pago-anulado/'.$order->encodeId());
                            } else {
                                $url = url('pago-espera-anulado/'.$order->encodeId());
                            }
                        break;
                        case 'notificado':
                            if (Khipu::notificated()) {
                                $order->modifySimple('payed', '1');
                                HtmlMail::sendFromFile($order->get('email'), 'payedThanks', array('NAME'=>$order->get('name')));
                                if ($place->id()!='') {
                                    $place->sendEmail(Params::param('email'), 'payedPlace');
                                    $url = url('pago-gracias/'.$order->encodeId());
                                } else {
                                    $placeEdit->sendEmail(Params::param('email'), 'payedPlaceEdit');
                                    $url = url('pago-espera-gracias/'.$order->encodeId());
                                }
                            }
                            return '';
                        break;
                    }
                }
                header('Location: '.$url);
                exit();
            break;
            case 'transferencia':
            case 'inscribir-gracias':
            case 'pago-gracias':
            case 'pago-espera-gracias':
            case 'pago-anulado':
            case 'pago-confirmacion':
            case 'pago-espera-anulado':
            case 'modificar-gracias':
            case 'pedido-ya-pagado':
                $this->header = '<meta name="robots" content="noindex,nofollow"/>';
                $this->layoutPage = 'message';
                $order = Order::readCoded($this->id);
                switch($this->action) {
                    case 'transferencia':
                        $this->titlePage = 'Gracias por la inscripción';
                        $this->message = 'Muchas gracias por inscribir a su empresa.<br/>
                                        Estamos a la espera de la transferencia bancaria para activar la misma.';
                        $this->content = '<div class="messageSimple">'.HtmlSection::showFile('transfer').'</div>';
                    break;
                    case 'inscribir-gracias':
                        $this->titlePage = 'Gracias por la inscripción';
                        $this->message = 'Muchas gracias por inscribir a su empresa.<br/>
                                        Vamos a revisar la información y la publicaremos lo antes posible.<br/>
                                        Le informaremos sobre el proceso via email.';
                    break;
                    case 'modificar-gracias':
                        $this->titlePage = 'Gracias por la actualización';
                        $this->message = 'Muchas gracias por actualizar los datos de la empresa.<br/>
                                        Vamos a revisar la información y la publicaremos lo antes posible.<br/>
                                        Le informaremos sobre el proceso via email.';
                    break;
                    case 'pago-gracias':
                        $place = Place::read($order->get('idPlace'));
                        $this->titlePage = 'Gracias por su pago';
                        $this->message = 'Muchas gracias por realizar su pago.<br/>
                                        Puede ver su empresa haciendo click <a href="'.$place->url().'">aquí</a>.';
                    break;
                    case 'pago-espera-gracias':
                        $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                        $this->titlePage = 'Gracias por su pago';
                        $this->messageInfo = 'Muchas gracias por realizar su pago.<br/>
                                        Vamos a revisar la información y la publicaremos lo antes posible.<br/>
                                        Le informaremos sobre el proceso via email.';
                    break;
                    case 'pago-confirmacion':
                        $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                        $this->titlePage = 'Gracias por su pago';
                        $this->messageInfo = 'Muchas gracias por realizar su pago.<br/>
                                        Estamos a la espera de la confirmación por parte de Khipu.<br/>
                                        Le informaremos sobre el proceso via email.';
                    break;
                    /*
                        $place = Place::read($order->get('idPlace'));
                        $this->titlePage = 'Su pago no se realizó';
                        $this->messageError = 'Lo sentimos, no pudimos recibir su pago.<br/>
                                        Si se trata de un error escríbanos a <a href="mailto:info@plasticwebs.com" target="_blank">info@plasticwebs.com</a><br/>
                                        Puede ver la empresa a promocionar haciendo click <a href="'.$place->url().'">aquí</a>.';
                    break;
                    */
                    case 'pago-anulado':
                    case 'pago-espera-anulado':
                        $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                        $paymentsAccepted = explode(':', PAYMENTS_ACCEPTED);
                        $this->titlePage = 'Su pago no se realizó';
                        $btnPaypal = (in_array('paypal', $paymentsAccepted)) ? '<div class="retryPayment retryPaymentPaypal">
							                                                		<a href="'.url('paypal-order/'.$this->id).'" target="_blank">PayPal</a>
							                                                	</div>' : '';
                        $btnKhipu = (in_array('khipu', $paymentsAccepted)) ? '<div class="retryPayment retryPaymentKhipu">
						                                                		<a href="'.url('khipu-order/'.$this->id).'" target="_blank">Khipu</a>
						                                                	</div>' : '';
                        $this->content = '<div class="pageComplete pageCompleteMessage">
                                                <p>Lo sentimos, no pudimos recibir su pago. Si cree que se trata de un error escríbanos a <a href="mailto:info@plasticwebs.com" target="_blank">info@plasticwebs.com</a> con todos los datos posibles para que podamos solucionar el problema.</p>
                                                <p>Si tuvo un problema con el sistema de pagos, puede volver a intentarlo haciendo click en:</p>
                                                <div class="retryPayments">
                                                	'.$btnPaypal.'
                                                	'.$btnKhipu.'
                                                </div>
                                                <p>Mil disculpas por los problemas ocasionados.</p>
                                            </div>';
                    break;
                    case 'pedido-ya-pagado':
                        $this->titlePage = 'El pedido ya ha sido pagado';
                        $this->messageInfo = 'Muchas gracias por realizar su pago, pero este pedido ya ha sido pagado.<br/>
                                        Si se trata de un error escríbanos a <a href="mailto:info@plasticwebs.com" target="_blank">info@plasticwebs.com</a>.';
                    break;
                }
                return $this->ui->render();
            break;
            case 'paypal-order':
            case 'khipu-order':
            	$order = Order::readCoded($this->id);
            	if ($order->get('payed')=='1') {
            		header('Location: '.url('pedido-ya-pagado'));
            	} else {
            		switch ($this->action) {
            			case 'paypal-order':
            				$order->paypalRequest();
            			break;
            			case 'khipu-order':
            				$order->khipuRequest();
            			break;
            		}
            	}
            break;






            /**
            * PRIVATE ADMIN
            */
            case 'lugar-borrar':
            case 'lugar-promocionar':
            case 'lugar-depromocionar':
                $this->header = '<meta name="robots" content="noindex,nofollow"/>';
                $place = Place::readCoded($this->id);
                $this->layoutPage = 'simple';
                if ($place->id()!='') {
                    switch($this->action) {
                        case 'lugar-borrar':
                            $this->message = 'La empresa ha sido borrada. Verifique haciendo click en '.$place->link();
                            $place->delete();
                        break;
                        case 'lugar-promocionar':
                            $this->message = 'La empresa ha sido promocionada. Verifique haciendo click en '.$place->link();
                            $place->modifySimple('promoted', '1');
                        break;
                        case 'lugar-depromocionar':
                            $this->message = 'La empresa ha sido promocionada. Verifique haciendo click en '.$place->link();
                            $place->modifySimple('promoted', '0');
                        break;
                    }
                } else {
                    $this->message = 'La empresa no existe';
                }
                return $this->ui->render();
            break;
            case 'lugar-editar-borrar':
            case 'lugar-editar-publicar':
            case 'lugar-editar-publicar-promocionar':
            case 'lugar-editar-modificar':
                $placeEdit = PlaceEdit::readCoded($this->id);
                $this->activateJS();
                $this->header .= '<meta name="robots" content="noindex,nofollow"/>';
                $this->layoutPage = 'simple';
                if ($placeEdit->id()!='') {
                    switch($this->action) {
                        case 'lugar-editar-borrar':
                            $this->message = 'La empresa ha sido borrada.';
                            $placeEdit->delete();
                        break;
                        case 'lugar-editar-publicar':
                        case 'lugar-editar-publicar-promocionar':
                            $placeEdit->loadTags();
                            $place = Place::read($placeEdit->get('idPlace'));
                            $values = $placeEdit->values;
                            $values['image'] = $placeEdit->getImageUrl('image', 'huge');
                            $values['imageBackground'] = $placeEdit->getImageUrl('imageBackground', 'huge');
                            $values['idTag'] = $placeEdit->tags->showList(array('function'=>'Simple'));
                            $place->insert($values);
                            $place = Place::read($place->id());
                            $place->sendEmail($place->get('emailEditor'), 'publishedPlace');
                            if ($this->action=='lugar-editar-publicar-promocionar') {
                                $place->modifySimple('promoted', '1');
                            }
                            $placeEdit->delete();
                            $this->message = 'La empresa ha sido publicada en '.$place->link();
                        break;
                        case 'lugar-editar-modificar':
                            $this->titlePage = 'Modificar la informacion de una empresa';
                            $placeEditForm = PlaceEdit_Form::newObject($placeEdit);
                            if (count($this->values) > 0) {
                                $placeEditForm = new PlaceEdit_Form($this->values);
                                $errors = $placeEditForm->isValid();
                                if (count($errors) > 0) {
                                    $placeEditForm = new PlaceEdit_Form($this->values, $errors);
                                } else {
                                    $this->values['idPlace'] = $placeEdit->get('idPlace');
                                    $placeEdit->modify($this->values);
                                    $placeEdit = PlaceEdit::read($placeEdit->id());
                                    $placeEditForm = PlaceEdit_Form::newObject($placeEdit);
                                    $this->message = 'El registro ha sido guardado con exito.';
                                }
                            }
                            $this->content = $placeEditForm->createPublicAdmin();
                        break;
                    }
                } else {
                    $this->message = 'La empresa no existe';
                }
                return $this->ui->render();
            break;
            case 'cache-all-console':
                $this->mode = 'ajax';
                File::createDirectory(BASE_FILE.'cache', false);
                if (!is_writable(BASE_FILE.'cache')) {
                    return str_replace('#DIRECTORY', BASE_FILE.'cache', __('directoryNotWritable'));
                } else {
                    Cache::cacheAll();
                    return 'Cached';
                }
            break;

            /**
            * GITHUB
            */
            case 'check-github-now':
                $url = "https://github.com/theylooksotired/directorio/archive/master.zip";
                $zipFile = LOCAL_FILE."master.zip";
                file_put_contents($zipFile, fopen($url, 'r'));
                $zip = new ZipArchive;
                $res = $zip->open($zipFile);
                if ($res === TRUE) {
                    $zip->extractTo('.');
                    $zip->close();
                }
                unlink($zipFile);
                shell_exec('cp -r '.LOCAL_FILE.'directorio-master/* '.LOCAL_FILE);
                shell_exec('rm -rf '.LOCAL_FILE.'directorio-master');
        		if (is_writable(BASE_FILE.'cache')) {
                    Cache::cacheAll();
                }
                header('Location: '.url(''));
                exit();
            break;
        }
    }

    public function activateJS() {
        $this->header = '<script src="https://www.google.com/recaptcha/api.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery-1.10.2.min.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery-ui-1.10.3.custom.min.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery.form.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/public.js?v=4"></script>';
    }

    public function checkCaptcha(&$errors) {
        $catpchaResponse = (isset($this->values['g-recaptcha-response'])) ? $this->values['g-recaptcha-response'] : '';
        $captchaUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $captchaValues = array('secret'=>CAPTCHA_SECRET_KEY, 'response'=>$catpchaResponse);
        $curl = curl_init($captchaUrl);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($captchaValues));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $responseCaptcha = json_decode(curl_exec($curl));
        curl_close($curl);
        if (!$responseCaptcha->{'success'}) {
            $errors['captcha'] = 'Por favor, haga click en el siguiente botón para verificar que no es un robot';
        }
    }

    public function adsenseFullPage() {
    	if ($this->adsenseFullPageActive) {
    		return '<script>
				      (adsbygoogle = window.adsbygoogle || []).push({
				        google_ad_client: "ca-pub-7429223453905389",
				        enable_page_level_ads: true
				      });
				    </script>';
    	}
    }

}
?>
