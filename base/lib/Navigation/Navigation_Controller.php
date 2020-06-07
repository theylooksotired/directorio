<?php
class Navigation_Controller extends Controller{

    public function __construct($GET, $POST, $FILES) {
        parent::__construct($GET, $POST, $FILES);
        $this->adsenseFullPageActive = false;
        $this->ui = new Navigation_Ui($this);
    }

    public function controlActions(){
        $this->metaImage = BASE_URL.'visual/img/cover-'.Params::param('countryCode').'.jpg';
        switch ($this->action) {
            default:
            	$this->adsenseFullPageActive = true;
                if ($this->action!='') {
                    $this->layoutPage = 'place';
                    $info = explode('-', $this->action);
                    $item = Place::read($info[0]);
                    if ($item->id()!='') {
                        if (strpos($this->action, '_')!==false) {
                            header("HTTP/1.1 301 Moved Permanently");
                            header('Location: '.$item->url());
                            exit();
                        }
                        $this->mode = 'amp';
                        $this->header = $item->showUi('JsonHeader');
                        $this->titlePage = $item->getBasicInfo();
                        $this->metaUrl = $item->url('');
                        $this->metaImage = $item->getImageUrl('image', 'web');
                        $this->metaDescription = 'Dirección, teléfonos, email e información de '.$item->getBasicInfo().' en '.$item->get('city').' '.Params::param('country');
                        $this->metaKeywords = 'directorio, directorio de empresas, guía, guía empresarial, dirección, teléfonos, email, empresa, '.$item->getBasicInfo().', '.$item->get('city').', '.Params::param('country');
                        $this->place = $item;
                        $this->content = ($item->get('promoted')=='1') ? $item->showUi('CompletePromoted') : $item->showUi('Complete');
                        $this->layoutPage = ($item->get('promoted')=='1') ? 'promoted' : $this->layoutPage;
                        $this->metaAds = ($item->get('promoted')=='1') ? false : true;
                        $this->breadCrumbs = array(url('ciudad')=>'Ciudades', url('ciudad/'.$item->get('cityUrl'))=>$item->get('city'), $item->url()=>$item->getBasicInfo());
                        return $this->ui->render();
                    } else {
                        header("HTTP/1.1 301 Moved Permanently");
                        header('Location: '.url(''));
                        exit();
                    }
                } else {
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.url(''));
                    exit();
                }
            break;
            case 'intro':
                $this->mode = 'amp';
            	$place = new Place();
                $this->layoutPage = 'intro';
                $this->content = '<div class="searchMainWrapper" style="background-image: url('.BASE_URL.'visual/img/cover-'.Params::param('countryCode').'.jpg);">
                                        <div class="searchMain">
                                            <div class="searchMainIns">
                                                '.Navigation_Ui::searchAmp().'
                                            </div>
                                        </div>
                                    </div>
                                    <div class="contentWrapper contentWrapperIntro">
                                        '.Adsense::amp().'
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
                                                '.Adsense::ampInline().'
                                                '.$this->ui->contentSide().'
                                            </div>
                                            <div class="clearer"></div>
                                        </div>
                                    </div>';
                return $this->ui->render();
            break;
            case 'ciudad':
                $this->mode = 'amp';
                $this->layoutPage = 'amp';
                $this->adsenseFullPageActive = true;
                if ($this->extraId!='') {
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.url($this->action.'/'.$this->id));
                    exit();
                }
                $items = new ListObjects('Place', array('where'=>'cityUrl="'.$this->id.'" AND cityUrl!=""', 'order'=>'promoted DESC, titleUrl', 'results'=>'10'));
                if ($items->isEmpty()) {
                    $this->layoutPage = 'clean';
                    $place = new Place();
                    $this->titlePage = 'Ciudades de '.Params::param('country');
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action);
                    $this->breadCrumbs = array(url('ciudad')=>'Ciudades');
                    $this->content = '<h1>'.$this->titlePage.'</h1>
                                        <div class="cityList">
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
                    $this->content = $items->showList(array('function'=>'Public', 'middle'=>Adsense::ampInline())).'
                                    '.$items->pager();
                }
                return $this->ui->render();
            break;
            case 'ciudad-tag':
                $this->mode = 'amp';
                $this->layoutPage = 'amp';
                $this->adsenseFullPageActive = true;
                $item = Place::readFirst(['where'=>'cityUrl="'.$this->id.'" AND cityUrl!=""']);
                if ($item->id()!='') {
                    $this->layoutPage = 'clean';
                    $this->titlePage = 'Empresas y negocios en '.$item->get('city').', '.Params::param('country');
                    $this->titlePageIns = '<span>Empresas y negocios en</span> '.$item->get('city').', '.Params::param('country');
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action);
                    $this->content = Tag_Ui::intro(['place'=>$item, 'titlePage'=>$this->titlePageIns]);
                    return $this->ui->render();
                } else {
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.url('ciudad/'.$this->id));
                    exit();
                }
            break;
            case 'tag':
                $this->mode = 'amp';
                $this->layoutPage = 'amp';
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
                    if ($items->isEmpty()) {
                        header("HTTP/1.1 301 Moved Permanently");
                        header('Location: '.url(''));
                        exit();
                    }
                    $this->header = $items->metaNavigation();
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action.'/'.$this->id);
                    $this->content = (($this->extraId!='') ? '' : $item->showUi('Cities')).'
                                    '.$items->showList(array('function'=>'Public', 'middle'=>Adsense::ampInline())).'
                                    '.$items->pager();
                    return $this->ui->render();
                } else {
                    $this->layoutPage = 'clean';
                    $this->titlePage = 'Empresas y negocios en '.Params::param('country');
                    $this->titlePageIns = '<span>Empresas y negocios en</span> '.Params::param('country');
                    $this->metaDescription = $this->titlePage;
                    $this->metaUrl = url($this->action);
                    $this->content = Tag_Ui::intro(['titlePage'=>$this->titlePageIns]);
                    return $this->ui->render();
                }
            break;
            case 'buscar':
                if (isset($this->values['search']) && $this->values['search']!='') {
                    $search = Text::simpleUrl($this->values['search']);
                    header('Location: '.url('buscar/'.$search));
                    exit();
                }
                if (isset($_GET['search']) && $_GET['search']!='') {
                    $search = Text::simpleUrl($_GET['search']);
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.url('buscar/'.$search));
                    exit();
                }
                if ($this->id!='') {
                    $this->mode = 'amp';
                    $this->layoutPage = 'amp';
                    $this->adsenseFullPageActive = true;
                    $search = str_replace('-', ' ', Text::simpleUrl($this->id));
                    $this->titlePage = 'Resultados de la busqueda - '.ucwords($search);
                    $this->titlePageHtml = '<span>Resultados de la busqueda</span> '.ucwords($search);
                    $items = new ListObjects('Place', array('where'=>'MATCH (search) AGAINST ("'.$search.'") OR search LIKE ("%'.$search.'%")', 'order'=>'promoted DESC, MATCH (search) AGAINST ("'.$search.'") DESC', 'results'=>'10'));
                    if ($items->isEmpty()) {
                        $items = new ListObjects('Place', array('where'=>'search LIKE ("%'.$search.'%")', 'order'=>'promoted DESC, titleUrl', 'results'=>'10'));
                    }
                    $this->header = $items->metaNavigation();
                    $this->content = $items->showListPager(array('function'=>'Public', 'message'=>'<div class="message">Lo sentimos, pero no encontramos resultados para su busqueda.</div>', 'middle'=>Adsense::ampInline()));
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
                $this->metaUrl = url($this->action);
                $this->content = HtmlSection::showFile('terms');
                return $this->ui->render();
            break;




            /**
            * PUBLIC ADMIN
            */
            case 'inscribir':
                $this->layoutPage = 'form';
                $this->titlePage = 'Inscriba a su empresa en nuestro directorio';
                $this->metaDescription = 'Inscriba de forma totalmente gratuita a su empresa en nuestro directorio.';
                $this->activateJS();
                $placeEditForm = new PlaceEdit_Form();
                $withErrors = false;
                if (count($this->values)>0) {
                    $this->values['city'] = (isset($this->values['cityOther']) && $this->values['cityOther']!='') ? $this->values['cityOther'] : (isset($this->values['city']) ? $this->values['city'] : '');
                    $this->values['description'] = (isset($this->values['description'])) ? preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', strip_tags($this->values['description'], '<p><ul><ol><li><u><em><strong>')) : '';
                    $placeEditForm = new PlaceEdit_Form($this->values);
                    $errors = $placeEditForm->isValid();
                    $this->checkCaptcha($errors);
                    if (count($errors) > 0) {
                        $withErrors = true;
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
                $this->content = ($withErrors) ? $placeEditForm->createPublicUpdate() : $placeEditForm->createPublic();
                return $this->ui->render();
            break;
            case 'modificar':
                $this->layoutPage = 'simple';
                $this->activateJS();
                $this->header .= '<meta name="robots" content="noindex,nofollow"/>';
                $place = Place::read($this->id);
                if ($place->id()!='' && $place->get('promoted')!='1') {
                    $placeEditValues = $place->valuesArray();
                    unset($placeEditValues['nameEditor']);
                    unset($placeEditValues['emailEditor']);
                    $placeEditForm = new PlaceEdit_Form($placeEditValues);
                    if ($this->action=='modificar') {
                        $this->titlePage = 'Actualizar la información de '.$place->getBasicInfo();
                        $this->titlePageHtml = '<span>Actualizar la información de</span> '.$place->getBasicInfo();
                        $this->content = $placeEditForm->createPublic(['update'=>true]);
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
                                $this->content = $placeEditForm->createPublic();
                            } else {
                                $this->content = $placeEditForm->createPublicPromote();
                            }
                        } else {
                            $this->values['idPlace'] = $place->id();
                            if (!(isset($this->files['image']['name']) && $this->files['image']['name']!='')) {
                                $this->values['image'] = $place->getImageUrl('image', 'huge');
                            }
                            $placeEdit = new PlaceEdit();
                            $placeEdit->insertMail($this->values);
                            $placeEdit = PlaceEdit::read($placeEdit->id());
                            $placeEdit->sendEmail($placeEdit->get('emailEditor'), 'modifyPlaceEdit');
                            if ((isset($this->values['choicePromotion']) && $this->values['choicePromotion']=='promoted')) {
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
                } elseif ($place->id()!='' && $place->get('promoted')=='1') {
                    $this->layoutPage = 'message';
                    $this->messageImage = 'sadthanks';
                    $this->titlePage = 'Su empresa ya está promocionada';
                    $this->message = '<p>Cualquier modificación se realizará por email.</p>';
                } else {
                    $this->layoutPage = 'message';
                    $this->messageImage = 'sadthanks';
                    $this->titlePage = 'La empresa no existe';
                }
                return $this->ui->render();
            break;
            case 'tag-autocomplete':
                $this->mode = 'json';
                $autocomplete = (isset($_GET['term'])) ? $_GET['term'] : '';
                if ($autocomplete!='' && strlen($autocomplete)>=3) {
                    $query = 'SELECT '.Db::prefixTable('Tag').'.idTag as idItem, '.Db::prefixTable('Tag').'.name as infoItem, COUNT(dir_Tag.idTag) as numItems
                            FROM '.Db::prefixTable('Tag').'
                            JOIN '.Db::prefixTable('PlaceTag').' ON '.Db::prefixTable('Tag').'.idTag='.Db::prefixTable('PlaceTag').'.idTag
                            WHERE '.Db::prefixTable('Tag').'.name LIKE "%'.$autocomplete.'%"
                            GROUP BY '.Db::prefixTable('Tag').'.idTag
                            ORDER BY numItems DESC, '.Db::prefixTable('Tag').'.nameUrl
                            LIMIT 5';
                    $results = array();
                    $resultsAll = Db::returnAll($query);
                    foreach ($resultsAll as $result) {
                        $resultsIns = array();
                        $resultsIns['id'] = $result['idItem'];
                        $resultsIns['value'] = $result['infoItem'];
                        $resultsIns['label'] = $result['infoItem'].' ('.$result['numItems'].')';
                        array_push($results, $resultsIns);
                    }
                    return json_encode($results);
                }
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
                        $this->messageImage = 'happythanks';
                        $this->message = '<p>Le hemos enviado a su email los datos para realizar la transferencia o giro bancario.</p>
                                            <p>Estaremos a la espera para activar la promoción de su empresa.</p>';
                        $this->content = '<div class="messageSimple">'.HtmlSection::showFile('transfer').'</div>';
                    break;
                    case 'inscribir-gracias':
                        $this->titlePage = 'Gracias por la inscripción';
                        $this->messageImage = 'happythanks';
                        $this->message = '<p>Vamos a revisar la información y la publicaremos lo antes posible.</p>
                                        <p>Le informaremos sobre el proceso via email.</p>';
                    break;
                    case 'modificar-gracias':
                        $this->titlePage = 'Gracias por la actualización';
                        $this->messageImage = 'happythanks';
                        $this->message = '<p>Vamos a revisar la información y la publicaremos lo antes posible.</p>
                                        <p>Le informaremos sobre el proceso via email.</p>';
                    break;
                    case 'pago-gracias':
                        $place = Place::read($order->get('idPlace'));
                        $this->messageImage = 'happythanks';
                        $this->titlePage = 'Gracias por su pago';
                        $this->message = '<p>Puede ver su empresa haciendo click <a href="'.$place->url().'">aquí</a>.</p>';
                    break;
                    case 'pago-espera-gracias':
                        $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                        $this->messageImage = 'happythanks';
                        $this->titlePage = 'Gracias por su pago';
                        $this->message = '<p>Vamos a revisar la información y la publicaremos lo antes posible.</p>
                                        <p>Le informaremos sobre el proceso via email.</p>';
                    break;
                    case 'pago-anulado':
                    case 'pago-espera-anulado':
                        $placeEdit = PlaceEdit::read($order->get('idPlaceEdit'));
                        $this->titlePage = 'Su pago no se realizó';
                        $this->messageImage = 'sadthanks';
                        $this->message = '<p>Lo sentimos, no pudimos recibir su pago.</p>
                                            <p>Si tuvo un problema con el sistema de pagos, puede volver a intentarlo haciendo click en:</p>
                                            <div class="retryPayments">
                                            	<div class="retryPayment retryPaymentPaypal">
                                                    <a href="'.url('paypal-order/'.$this->id).'" target="_blank">PayPal</a>
                                                </div>
                                            </div>';
                    break;
                    case 'pedido-ya-pagado':
                        $this->titlePage = 'El pedido ya ha sido pagado';
                        $this->messageImage = 'happythanks';
                        $this->messageInfo = '<p>Muchas gracias por realizar su pago, pero este pedido ya ha sido pagado.</p>';
                    break;
                }
                return $this->ui->render();
            break;
            case 'paypal-order':
            	$order = Order::readCoded($this->id);
            	if ($order->get('payed')=='1') {
            		header('Location: '.url('pedido-ya-pagado'));
            	} else {
            		$order->paypalRequest();
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
                $this->layoutPage = 'empty';
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
                $this->layoutPage = 'empty';
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

            /**
            * CACHE ALL
            **/
            case 'cache-all-console':
                $this->mode = 'ajax';
                $this->checkAuthorization();
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
                $this->mode = 'ajax';
                $this->checkAuthorization();
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
                return 'DONE';
            break;

            case 'check-github-all':
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.plasticmails.net/directorio/check-github-now &> /dev/null');

                shell_exec('wget --header="Authorization: plastic" -qO- https://www.argentina-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.directorio.com.bo/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.directorio-chile.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.colombia-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.ecuador-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.directorio-guatemala.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.directorio-honduras.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.mexico-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.directorio-panama.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.paraguay-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.peru-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.telefono.do/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.uruguay-directorio.com/check-github-now &> /dev/null');
                shell_exec('wget --header="Authorization: plastic" -qO- https://www.venezuela-directorio.com/check-github-now &> /dev/null');
            break;

            case 'fix':
                $this->mode = 'ajax';
                $this->checkAuthorization();
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="mobile", translation_es="Teléfono móvil"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="whatsapp", translation_es="Whatsapp"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="facebook", translation_es="Facebook"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="instagram", translation_es="Instagram"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="youtube", translation_es="Youtube"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="twitter", translation_es="Twitter"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="tagsLabel", translation_es="Escriba etiquetas descriptivas separas por comas"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="cityDoesNotAppear", translation_es="Mi ciudad no aparece en la lista"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="namePlace", translation_es="Nombre de la empresa o negocio"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="nameEditorLabel", translation_es="Nombre de la persona de contacto"');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="emailEditorLabel", translation_es="Email de la persona de contacto"');
                // Db::execute('ALTER TABLE `dir_PlaceEdit` ADD `mobile` VARCHAR(255) NULL, ADD `whatsapp` VARCHAR(255) NULL, ADD `facebook` VARCHAR(255) NULL, ADD `instagram` VARCHAR(255) NULL, ADD `youtube` VARCHAR(255) NULL;');
                // Db::execute('ALTER TABLE `dir_PlaceEdit` ADD `twitter` VARCHAR(255) NULL;');
                // Db::execute('ALTER TABLE `dir_Place` ADD `mobile` VARCHAR(255) NULL, ADD `whatsapp` VARCHAR(255) NULL, ADD `facebook` VARCHAR(255) NULL, ADD `instagram` VARCHAR(255) NULL, ADD `youtube` VARCHAR(255) NULL, ADD `twitter` VARCHAR(255) NULL;');
                // Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="tagsLabel3", translation_es="Escriba las categorías de su empresa. Puede tener un máximo 3."');
                Db::execute('INSERT INTO '.Db::prefixTable('LangTrans').' SET code="tagsLabelMax3", translation_es="Escriba las categorías de su empresa. Puede tener máximo 3."');
            break;

        }
    }

    public function activateJS() {
        $this->header = '<script src="https://www.google.com/recaptcha/api.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery-1.10.2.min.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery-ui-1.10.3.custom.min.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/jquery/jquery.form.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/tagit/tag-it.min.js"></script>
                        <link href="'.BASE_URL.'libjs/tagit/jquery.tagit.css" rel="stylesheet" type="text/css" />
                        <script type="text/javascript" src="'.url('NavigationAdmin/base-info', true).'"></script>
                        <script type="text/javascript" src="'.APP_URL.'helpers/ckeditor/ckeditor.js"></script>
                        <script type="text/javascript" src="'.BASE_URL.'libjs/public.js?v=10"></script>';
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

    function checkAuthorization() {
        $headers = apache_request_headers();
        if (!isset($headers) || !isset($headers['Authorization']) || $headers['Authorization']!='plastic') {
            header('Location: '.url(''));
            exit();
        }
    }

}
?>
