<?php
class Tag_Controller extends Controller {

	public function controlActions(){
		switch ($this->action) {
			default:
				return parent::controlActions();
			break;
			case 'autocomplete':
				$this->mode = 'json';
                $autocomplete = (isset($_GET['term'])) ? $_GET['term'] : '';
                if ($autocomplete!='') {
                	$query = 'SELECT '.Db::prefixTable('Tag').'.idTag as idItem, '.Db::prefixTable('Tag').'.name as infoItem, COUNT(dir_Tag.idTag) as numItems
                            FROM '.Db::prefixTable('Tag').'
                            JOIN '.Db::prefixTable('PlaceTag').' ON '.Db::prefixTable('Tag').'.idTag='.Db::prefixTable('PlaceTag').'.idTag
                            WHERE '.Db::prefixTable('Tag').'.name LIKE "%'.$autocomplete.'%"
                            GROUP BY '.Db::prefixTable('Tag').'.idTag
                            ORDER BY numItems DESC, '.Db::prefixTable('Tag').'.nameUrl
                            LIMIT 20';
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
		}
	}

}
?>