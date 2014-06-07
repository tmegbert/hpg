<?php
$email = $_COOKIE['hpgid'];

$m = new MongoClient();
$db = $m->hpg;

$teachersC = $db->teachers;
$familiesC = $db->families;

if($email) {
    $teacher = $teachersC->findOne(array("email" => $email));

    $families = array();
    foreach($teacher["families"] as $familyId) {
        $families[$familyId] = $familiesC->findOne(array("_id" => $familyId));
    }
} else {
    if ($_GET['id']) {
        $email = $_GET['id'];
        $teacher = $teachersC->findOne(array("email" => $email));
        if ($teacher) {
            if(empty($teacher['pin'])) {
                $pin = $_GET['pin'];
                $teacher['pin'] = $pin;
                $teachersC->update(array("email" => $email), $teacher); 
                setcookie('hpgid', $email);
                header("Location: http://www.nerkasoft.info/hpg/hpg.php");
                exit();
            } else if($teacher['pin'] == $_GET['pin']) {
                setcookie('hpgid', $email);
                header("Location: http://www.nerkasoft.info/hpg/hpg.php");
                exit();
            } else {
                header("Location: http://www.nerkasoft.info/hpg/notfound.php");
                exit();
            }
        } else {
            header("Location: http://www.nerkasoft.info/hpg/notfound.php");
            exit();
        }
        continue;
    } 
    header("Location: http://www.nerkasoft.info/hpg/login.php");
    exit();
}
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="hpg.css">
</head>
<body>
    <script src="hpg.js"></script>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td class="teacher"><?= $teacher['name']?></td>
            <td><form action="resetId.php">
                    <button type="submit">Change ID</button>
                </form>
            </td>
        </tr>
    </table>
    <div>
        <table cellpadding="0" cellspacing="0" border="2">
            <tr class="header_row">
                <th class="name">Family</th>
                <th class="center">J</th>
                <th class="center">F</th>
                <th class="center">M</th>
                <th class="center">A</th>
                <th class="center">M</th>
                <th class="center">J</th>
                <th class="center">J</th>
                <th class="center">A</th>
                <th class="center">S</th>
                <th class="center">O</th>
                <th class="center">N</th>
                <th class="center">D</th>
            </tr>
<?php
    $q = "qm3.jpg";
    $c = "cm3.jpg";
    $d = "d3.jpg";
    foreach($families as $famId => $family){
        echo "<tr class=\"icon_row\">";
        echo "    <td class=\"name\">" . $family['name'] . "</td>";
        $visits = $family['visits'];
        for($i = 0; $i < strlen($visits); ++$i){
            switch($visits[$i]) {
                case '0': $icon = $q; break;
                case '1': $icon = $c; break;
                case '2': $icon = $d; break;
            }
            $elementId = $famId . "-" . $i;
            echo "<td class=\"center\"><img id=\"$elementId\" onClick=\"switchIcon(this)\" src=\"$icon\"/></td>";
        }
        echo "</tr>";
        $famNum++;
    }
?>
        </table>
    </div>
</body>
</html>
