<?php
/**
* @class PlaceCommentUi
*
* This class manages the UI for the PlaceComment objects.
*
* @author Leano Martinet <info@asterion-cms.com>
* @package Asterion
* @version 3.0.1
*/
class PlaceComment_Ui extends Ui{

	public function renderPublic() {
		return '<div class="comment">
					<div class="commentRating">'.PlaceComment_Ui::renderRating(intval($this->object->get('rating'))).'</div>
					<div class="commentIns">'.nl2br($this->object->get('comment')).'</div>
					<div class="commentDate">'.Date::sqlText($this->object->get('created')).'</div>
				</div>';
	}
	
	public function renderMail() {
		$this->object->loadPlace();
		return '<strong>'.__('place').' :</strong> '.$this->object->place->link().'<br/>
				<strong>'.__('rating').' :</strong> '.$this->object->get('rating').'<br/>
				<strong>'.__('comment').' :</strong> '.nl2br($this->object->get('comment'));
	}

	static public function renderRating($rating) {
		return '<div class="ratingWrapper">
					<div class="rating" data-rating="1">
						<i class="icon icon-star'.(($rating<1) ? '-empty' : '').'"></i>
					</div>
					<div class="rating" data-rating="2">
						<i class="icon icon-star'.(($rating<2) ? '-empty' : '').'"></i>
					</div>
					<div class="rating" data-rating="3">
						<i class="icon icon-star'.(($rating<3) ? '-empty' : '').'"></i>
					</div>
					<div class="rating" data-rating="4">
						<i class="icon icon-star'.(($rating<4) ? '-empty' : '').'"></i>
					</div>
					<div class="rating" data-rating="5">
						<i class="icon icon-star'.(($rating<5) ? '-empty' : '').'"></i>
					</div>
				</div>';
	}

}
?>