<?php
class PlaceEdit_Controller extends Controller {

	public function controlActions() {
		switch ($this->action) {
			case 'insertView':
			case 'modifyView':
			case 'insertCheck':
			case 'modifyViewCheck':
				$this->header = '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAPxhf6BXDryPyJX-1nwV4jEUrdf5eYac"></script>';
			break;
		}
		return parent::controlActions();
	}

}
?>