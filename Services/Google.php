<?php
/*
 * Created on 05-Feb-09
 * Goooogle :P 
 * it seaarches the data base ofcource in indexed. liner :P
 * naren
 */
 
  function doSearch($searchText){
  	
  	// first search by any chance complete text is there.
  	//$qry = "call google(\"".$searchText."\",1,1)";
  	$qry = "call google('".$searchText."','1','1')";
  	echo "SP Call for the Search ".$qry;
  	$allRes = executeSP($qry);
	return $allRes;  	

  }
  
  function getItemDet($itemId){
  	$qry = "select p.prod_name,p.prod_id,p.prod_desc,c.class_id,c.class_name,r.rating from product_base p join classification_base c on (p.prod_subclass_id = c.class_id) join (select prod_id, round(avg(rating),0) rating from prod_ratings  group by prod_id) r on (p.prod_id = r.prod_id) where p.prod_id = '".$itemId."';";
  	$itemDet = executeQuery($qry);
  	return $itemDet;
  }
?>
