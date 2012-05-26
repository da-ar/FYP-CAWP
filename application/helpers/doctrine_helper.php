<?php
/**
 * Doctrine Helper
 * 
 */

function getIds($obj){
    // takes a doctrine model object and returns an array of the ids    
    $idArr = array();

    foreach($obj as $item){
        if(property_exists($item, 'id')){
            array_push($idArr, $item->id);
        }        
    }

    return $idArr;

}


/* End of file doctrine_helper.php */
/* Location: ./application/helpers/doctrine_helper.php */