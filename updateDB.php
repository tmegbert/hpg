<?php
function updateDB($famId, $visitId, $value) {
    $m = new MongoClient();
    $db = $m->hpg;

    $familiesC = $db->families;

    $family = $familiesC->findOne(array("_id" => $famId));
    
    $family["visits"][$visitId] = $value;
    $familiesC->update(array("_id" => $famId), $family);

    return "";
}

echo updateDB(trim($_REQUEST['famId']),trim($_REQUEST['visitId']),trim($_REQUEST['value']));
?>
