<?php
define('APP_FOLDER', 'base');
require_once('base/config/config_test.php');

Url::init();
Lang::init();
Params::init();

$order = Order::readFirst(array('order'=>'created DESC'));
$order->khipuRequest();

/*
$items = HtmlMail::readList();
foreach ($items as $item) {
    echo "'".$item->get('code')."'=>'".$item->get('subject_es')."',\n";
    $path = BASE_FILE.'data/HtmlMail/';
    File::saveFile($path.$item->get('code').'.html', $item->get('mail_es'));
}

/*
for ($i=0; $i<=60; $i++) {
    $items = Tag::readList(array('order'=>'nameUrl', 'limit'=>($i*1000).', 1000'));
    foreach($items as $item) {
        $values = array('name'=>html_entity_decode($item->get('name')));
        $item->modify($values);
        echo $item->getBasicInfo()."\n";
    }
}

echo '=========';

for ($i=0; $i<=110; $i++) {
    $items = Place::readList(array('order'=>'titleUrl', 'limit'=>($i*1000).', 1000'));
    foreach($items as $item) {
        $item->loadTags();
        if (count($item->tags->list)==0) {
            $item->delete();
        } else {
            $values = array('title'=>html_entity_decode($item->get('title')),
                            'address'=>html_entity_decode($item->get('address')),
                            'telephone'=>html_entity_decode($item->get('telephone')),
                            'web'=>html_entity_decode($item->get('web')),
                            'email'=>html_entity_decode($item->get('email')),
                            'city'=>html_entity_decode($item->get('city')),
                            'idTag'=>substr($item->tags->showList(array('function'=>'Simple')), 0, -2),
                            'shortDescription'=>html_entity_decode($item->get('shortDescription')),
                            'description'=>html_entity_decode($item->get('description')));
            $item->modify($values);
        }
        echo $item->getBasicInfo()."\n";
    }
}


/*
//STEP 1 - GET TAGS
for ($i=0; $i<=60; $i++) {
    $items = Place::readList(array('order'=>'titleUrl', 'limit'=>($i*1000).', 1000'));
    foreach($items as $item) {
        $item->loadTags();
        Db::execute('UPDATE dir_Place
                        SET tag="'.substr($item->tags->showList(array('function'=>'Simple')), 0, -2).'"
                        WHERE idPlace="'.$item->id().'"');
        echo $item->getBasicInfo()."\n";
    }
}
//STEP 2 - REWRITE TAGS
for ($i=0; $i<=60; $i++) {
    $items = Place::readList(array('order'=>'titleUrl', 'limit'=>($i*1000).', 1000'));
    foreach($items as $item) {
        $values = array('title'=>html_entity_decode($item->get('title')),
                        'address'=>html_entity_decode($item->get('address')),
                        'telephone'=>html_entity_decode($item->get('telephone')),
                        'web'=>html_entity_decode($item->get('web')),
                        'email'=>html_entity_decode($item->get('email')),
                        'city'=>html_entity_decode($item->get('city')),
                        'idTag'=>html_entity_decode($item->get('tag')),
                        'shortDescription'=>html_entity_decode($item->get('shortDescription')),
                        'description'=>html_entity_decode($item->get('description')));
        $item->modify($values);
        echo $item->getBasicInfo()."\n";
    }
}
*/

?>
