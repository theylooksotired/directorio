<?php
/**
* @class PlaceReportController
*
* This class is the controller for the PlaceReport objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class PlaceReport_Controller extends Controller {

	public function controlActions(){
	 	$this->ui = new Navigation_Ui($this);
	 	switch ($this->action) {
	 		case 'reportar':
	 			switch ($this->id) {
	 				default:
						$this->layoutPage = 'simple';
						$this->header = '<meta name="robots" content="noindex,nofollow"/>
										<script src="https://www.google.com/recaptcha/api.js"></script>';
						$place = Place::read($this->id);
						if ($place->id()!='') {
							$this->titlePage = 'Reportar una empresa';
							$this->metaDescription = 'Reportar una empresa del '.Params::param('titlePage');
							$reportForm = new PlaceReport_Form();
							if (count($this->values)>0) {
								$reportForm = new PlaceReport_Form($this->values);
								$errors = $reportForm->isValid();
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
									$reportForm = new PlaceReport_Form($this->values, $errors);
								} else {
									$report = new PlaceReport();
									$this->values['idPlace'] = $place->get('idPlace');
									$report->insert($this->values);
									// Send email
									$mailReport = $report->showUi('Email');
									$mailPlace = $place->showUi('Email');
									$linkDelete = url('lugar-borrar/'.$place->encodeId());
									HtmlMail::sendFromFile(Params::param('email'), 'report', array('PLACE'=>$mailPlace,
																						'REPORT'=>$mailReport,
																						'LINK_DELETE'=>$linkDelete));
									header('Location: '.url('reportar/gracias'));
									exit();
								}
							}
							$this->content = '<div class="report">
												<div class="reportTopWrapper">
													<div class="reportTopImage">
														<img src="'.BASE_URL.'visual/img/warning.svg"/>
													</div>
													<div class="reportTopInfo">
														<p>Por favor <strong>diganos claramente la razón</strong> por la que desea reportar esta información.</p>
														<p>De acuerdo a la gravedad o cantidad de reportes eliminaremos los registros de nuestro sitio web.</p>
													</div>
												</div>
												<div class="reportPlace">
													'.$place->showUi('Simple').'
												</div>
												'.$reportForm->createPublic().'
											</div>';
							return $this->ui->render();
						} else {
							header('Location: '.url(''));
							exit();
						}
					break;
					case 'gracias':
						$this->header = '<meta name="robots" content="noindex,nofollow"/>';
	                    $this->layoutPage = 'message';
	                    $this->messageImage = 'warning';
	                    $this->titlePage = 'Gracias por su reporte';
	                    $this->message = '<p>Vamos a analizar la situación y daremos de baja el registro de la empresa si es necesario.</p>';
	                    return $this->ui->render();
					break;
	            }
	 		break;
	 	}
        return parent::controlActions();
    }

}
?>