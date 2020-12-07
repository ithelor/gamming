<html lang="en">
<link href=alt_styles.css rel=stylesheet />
<body>

<?php

function _trim($str)
{
//    $trimmed = strtoupper(preg_replace("/\s+/", "", $str));
    $trimmed = strtoupper($str);

    return $trimmed;
}

function gamming($pt, $g, $alph)
{

    $result = array();
    $j = 0;

    for ($i = 0; $i < strlen($pt); $i++) {

        if ($j >= strlen($g)) $j = 0;

        $cur_pt_sym = mb_strcut($pt, $i, 1);

//        if ($cur_pt_sym == "/\s+/") array_push($result, ' ');
        if (!array_search($cur_pt_sym, $alph)) { echo "\nPushing " . $cur_pt_sym; array_push($result, $cur_pt_sym); }
        else {

            $cur_g_sym = mb_strcut($g, $j, 1);

            echo "\ncur_pt_sym: " . $cur_pt_sym;
            echo "\ncur_g_sym: " . $cur_g_sym;

            $cur_pt_num = array_search($cur_pt_sym, $alph);
            $cur_g_num = array_search($cur_g_sym, $alph);

            echo "\ncur_pt_num: " . $cur_pt_num;
            echo "\ncur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num + $cur_g_num;

            while ($result_num > count($alph)) {

                echo "\nresult_num: " . $result_num;
                echo "\ncount(alph): " . count($alph);

                $result_num -= (count($alph) - 1);
                echo "\nresult: " . $result_num;
            }

            echo "\nresult_num: " . $result_num;
            echo "\nalph: " . $alph[$result_num];

            array_push($result, $alph[$result_num]);

            $j++;
        }
    }

    return implode($result);
}

function ungamming($ct, $g, $alph)
{

    $result = array();
    $j = 0;

    for ($i = 0; $i < strlen($ct); $i++) {

        if ($j >= strlen($g)) $j = 0;

        $cur_pt_sym = mb_strcut($ct, $i, 1);
        $cur_g_sym = mb_strcut($g, $j, 1);

            echo "\ncur_pt_sym: " . $cur_pt_sym;
            echo "\ncur_g_sym: " . $cur_g_sym;

        $cur_pt_num = array_search($cur_pt_sym, $alph);

        if (!array_search($cur_pt_sym, $alph)) { echo "\nPushing " . $cur_pt_sym; array_push($result, $cur_pt_sym); }
        else {

            $cur_g_num = array_search($cur_g_sym, $alph);

            echo "\ncur_pt_num: " . $cur_pt_num;
            echo "\ncur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num - $cur_g_num;
            while ($result_num > count($alph)) {

                echo "\n$result_num: " . $result_num;
                echo "\ncount(alph): " . count($alph);

                $result_num -= (count($alph) - 1);
                echo "\nresult: " . $result;
            }
            if ($result_num <= 0) $result_num = count($alph) - abs($result_num - 1);

            echo "\nresult_num: " . $result_num;
            echo "\nalph: " . $alph[$result_num];

            array_push($result, $alph[$result_num]);

            $j++;
        }
    }

    return implode($result);
}

$alph = array(
    "0" => null,
);

for ($i = 65; $i < 91; $i++) array_push($alph, chr($i));

var_dump($alph);

$plaintext = file_get_contents($_FILES['pt_source']['tmp_name']);
$gamma = file_get_contents($_FILES['g_source']['tmp_name']);
echo "Original plain text: " . $plaintext . "<br>Original gamma: " . $gamma . "<br>";

$gamma = _trim($gamma); $plaintext = _trim($plaintext);
echo "<br>Trimmed plain text: " . $plaintext . "<br>Trimmed gamma: " . $gamma;

if(isset($_POST['actform']))
{
    $actform = $_POST['actform'];
    if($actform == "encrypt") $result = gamming($plaintext, $gamma, $alph);
    elseif($actform == "decrypt") $result = ungamming($plaintext, $gamma, $alph);

    echo "<br><br>Result: " . $result;
}

file_put_contents("file.txt", $result);

header('Content-type: plain/text');
header('Content-Disposition: attachment; filename="file.txt"');
//readfile('file.txt');

$hostname = "localhost";
$username = "root";
$password = "";
$dbName = "gamming_db";

$conn = mysqli_connect($hostname, $username, $password, $dbName) or die ("Unable to connect"); // подключение к БД по указанным данным

$sql = "INSERT INTO history (id, plaintext, gamma, action, result)
VALUES ('', '$plaintext', '$gamma', '$actform', '$result')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

?>

</body>
</html>