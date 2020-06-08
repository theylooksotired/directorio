<?php
/**
* @class PlaceCommentController
*
* This class is the controller for the PlaceComment objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class PlaceComment_Controller extends Controller {

	public function controlActions(){
	 	$this->ui = new Navigation_Ui($this);
	 	switch ($this->action) {
	 		case 'comentar':
	 			switch ($this->id) {
	 				default:
						$this->layoutPage = 'simple';
						$this->header = Navigation_Controller::activateJsHeader().'
										<meta name="robots" content="noindex,nofollow"/>';
						$place = Place::read($this->id);
						if ($place->id()!='') {
							$this->titlePage = 'Commentar una empresa';
							$this->metaDescription = 'Commentar una empresa del '.Params::param('titlePage');
							$commentForm = new PlaceComment_Form();
							if (count($this->values)>0) {
								$commentForm = new PlaceComment_Form($this->values);
								$errors = $commentForm->isValid();
								// Captcha error - Begin
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
							    // Captcha error - End
								if (count($errors) > 0) {
									$commentForm = new PlaceComment_Form($this->values, $errors);
								} else {
									$comment = new PlaceComment();
									$this->values['idPlace'] = $place->get('idPlace');
									$this->values['rating'] = intval($this->values['rating']);
									$this->values['active'] = 0;
									$comment->insert($this->values);
									// Send email
									$mailComment = $comment->showUi('Email');
									$mailPlace = $place->showUi('Email');
									$linkActivate = url('comentar/activar/'.$comment->encodeId());
									HtmlMail::sendFromFile(Params::param('email'), 'comment', array('PLACE'=>$mailPlace,
																						'COMMENT'=>$mailComment,
																						'LINK_ACTIVATE'=>$linkActivate));
									header('Location: '.url('comentar/gracias'));
									exit();
								}
							}
							$this->content = '<div class="report">
												<div class="reportTopWrapper">
													<div class="reportTopImage">
														<img src="'.BASE_URL.'visual/img/comment.svg"/>
													</div>
													<div class="reportTopInfo">
														<p>Por favor deje su comentario sobre esta empresa o negocio. Vamos a revisarlo y lo publicaremos.</p>
														<p>Recuerde que no toleramos insultos ni agresiones.</p>
													</div>
												</div>
												<div class="reportPlace">
													'.$place->showUi('Simple').'
												</div>
												'.$commentForm->createPublic().'
											</div>';
							return $this->ui->render();
						} else {
							header('Location: '.url(''));
							exit();
						}
					break;
					case 'activar':
						$this->layoutPage = 'empty';
	                    $comment = PlaceComment::readCoded($this->extraId);
	                    $this->titlePage = 'Comentario activado';
	                    if ($comment->id()!='') {
	                    	$comment->modifySimple('active', '1');
	                    	$place = Place::read($comment->get('idPlace'));
	                    	$this->message = 'El comentario ha sido activado. Puede verlo en: '.$place->link();
	                    } else {
	                    	$this->message = 'El comentario no existe';
	                    }
	                    return $this->ui->render();	                    
					break;
					case 'gracias':
						$this->header = '<meta name="robots" content="noindex,nofollow"/>';
	                    $this->layoutPage = 'message';
	                    $this->messageImage = 'happythanks';
	                    $this->titlePage = 'Gracias por su comentario';
	                    $this->message = '<p>Lo vamos a revisar y lo publicaremos en menos de 48 horas.</p>';
	                    return $this->ui->render();
					break;
	            }
	 		break;
	 	}
        return parent::controlActions();
    }

}
?>