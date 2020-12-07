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

        if ($cur_pt_sym == ' ') array_push($result, $cur_pt_sym);
        else {

            $cur_g_sym = mb_strcut($g, $j, 1);

            echo "<br><br>cur_pt_sym: " . $cur_pt_sym;
            echo "<br>cur_g_sym: " . $cur_g_sym;

            $cur_pt_num = array_search($cur_pt_sym, $alph);
            $cur_g_num = array_search($cur_g_sym, $alph);

            echo "<br>cur_pt_num: " . $cur_pt_num;
            echo "<br>cur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num + $cur_g_num + 1;

            while ($result_num >= count($alph)) {

                echo "<br>$result_num: " . $result_num;
                echo "<br>count(alph): " . count($alph);

                $result_num -= count($alph);
                echo "<br>result: " . $result_num;
            }

            echo "<br>result_num: " . $result_num;
            echo "<br>alph: " . $alph[$result_num];

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

            echo "<br><br>cur_pt_sym: " . $cur_pt_sym;
            echo "<br>cur_g_sym: " . $cur_g_sym;

        $cur_pt_num = array_search($cur_pt_sym, $alph);

        if ($cur_pt_sym == ' ') array_push($result, $cur_pt_sym);
        else {

            $cur_g_num = array_search($cur_g_sym, $alph);

            echo "<br>cur_pt_num: " . $cur_pt_num;
            echo "<br>cur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num - $cur_g_num - 1;
            while ($result_num > count($alph)) {

                echo "<br>$result_num: " . $result_num;
                echo "<br>count(alph): " . count($alph);

                $result_num -= count($alph);
                echo "<br>result: " . $result;
            }
            if ($result_num <= 0) $result_num = count($alph) - abs($result_num);

            echo "<br>result_num: " . $result_num;
            echo "<br>alph: " . $alph[$result_num];

            array_push($result, $alph[$result_num]);

            $j++;
        }
    }

    return implode($result);
}

//$alph = array(
//    "1" => "A",     "8"  => "H", "15" => "O",
//    "2" => "B",     "9"  => "I", "16" => "P",   "22" => "V",
//    "3" => "C",     "10" => "J", "17" => "Q",   "23" => "W",
//    "4" => "D",     "11" => "K", "18" => "R",   "24" => "X",
//    "5" => "E",     "12" => "L", "19" => "S",   "25" => "Y",
//    "6" => "F",     "13" => "M", "20" => "T",   "26" => "Z",
//    "7" => "G",     "14" => "N", "21" => "U",
//);

$alph = array();

for ($i = 65; $i < 91; $i++) array_push($alph, chr($i));

$plaintext = file_get_contents($_FILES['pt_source']['tmp_name']);
$gamma = file_get_contents($_FILES['g_source']['tmp_name']);

echo "Original plain text: " . $plaintext . "<br>Original gamma: " . $gamma . "<br>";

$gamma = _trim($gamma); $plaintext = _trim($plaintext);

echo "<br>Trimmed plain text: " . $plaintext . "<br>Trimmed gamma: " . $gamma . "<br>";

echo "<br><br>Gamming result: " . gamming($plaintext, $gamma, $alph);
echo "<br><br>Ungamming result: " . ungamming($plaintext, $gamma, $alph);

?>

</body>
</html>