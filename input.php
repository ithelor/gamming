<html lang="en">
<link href=alt_styles.css rel=stylesheet />
<body>

<?php

    $alph = array(
        "1" => "A",     "8"  => "H", "15" => "O",
        "2" => "B",     "9"  => "I", "16" => "P",   "22" => "V",
        "3" => "C",     "10" => "J", "17" => "Q",   "23" => "W",
        "4" => "D",     "11" => "K", "18" => "R",   "24" => "X",
        "5" => "E",     "12" => "L", "19" => "S",   "25" => "Y",
        "6" => "F",     "13" => "M", "20" => "T",   "26" => "Z",
        "7" => "G",     "14" => "N", "21" => "U",
    );

    function decbinned($content, $dbg_str)
    {
        $str = $content;
        $res = '0';

        for($i = 0; $i < strlen($str); $i++){
            $res .= decbin(ord($str[$i]));
        }

//        echo "<br>" . "Decbinned: " . $dbg_str . " - " . $res;
    }

    function parse($alph, $content, $dbg_str)
    {
        $a = strlen($alph);
        $c = strlen($content);

        $trimmed = preg_replace("/\s+/", "", $content);
//        echo "<br>" . "Trimmed: " . $dbg_str . " - " . $trimmed;
    }

    function _trim($str)
    {
        $trimmed = strtoupper(preg_replace("/\s+/", "", $str));

        return $trimmed;
    }

    function gamming($pt, $g, $alph)
    {

        $result = array();

        $t = ceil(strlen($pt) / strlen($g));

//        echo "<br><br>t: " . $t;

        $j = 0;

        for ($i = 0; $i < strlen($pt); $i++) {

            if ($j >= strlen($g))
                $j = 0;
//            echo "<br>j: " . $j . "... resetting";

            $cur_pt_sym = mb_strcut($pt, $i, 1);
            $cur_g_sym = mb_strcut($g, $j, 1);

//            echo "<br><br>cur_pt_sym: " . $cur_pt_sym;
//            echo "<br>cur_g_sym: " . $cur_g_sym;

            $cur_pt_num = array_search($cur_pt_sym, $alph);
            $cur_g_num = array_search($cur_g_sym, $alph);

//            echo "<br>cur_pt_num: " . $cur_pt_num;
//            echo "<br>cur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num + $cur_g_num;
            while ($result_num > count($alph)) {

//                    echo "<br>$result_num: " . $result_num;
//                    echo "<br>count(alph): " . count($alph);

                $result_num -= count($alph);
//                    echo "<br>result: " . $result;
            }

//            echo "<br>result_num: " . $result_num;
//            echo "<br>alph: " . $alph[$result_num];

            array_push($result, $alph[$result_num]);

            $j++;
//            echo "<br>j: " . $j . "... normal";

        }

        return implode($result);
    }

    function ungamming($ct, $g, $alph)
    {

        $result = array();

        $t = ceil(strlen($ct) / strlen($g));

//        echo "<br><br>t: " . $t;

        $j = 0;

        for ($i = 0; $i < strlen($ct); $i++) {

            if ($j >= strlen($g))
                $j = 0;
//            echo "<br>j: " . $j . "... resetting";

            $cur_pt_sym = mb_strcut($ct, $i, 1);
            $cur_g_sym = mb_strcut($g, $j, 1);

//            echo "<br><br>cur_pt_sym: " . $cur_pt_sym;
//            echo "<br>cur_g_sym: " . $cur_g_sym;

            $cur_pt_num = array_search($cur_pt_sym, $alph);
            $cur_g_num = array_search($cur_g_sym, $alph);

//            echo "<br>cur_pt_num: " . $cur_pt_num;
//            echo "<br>cur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num - $cur_g_num;
            while ($result_num > count($alph)) {

    //                    echo "<br>$result_num: " . $result_num;
    //                    echo "<br>count(alph): " . count($alph);

                $result_num -= count($alph);
    //                    echo "<br>result: " . $result;
            }
            if ($result_num < 0) $result_num = count($alph) - abs($result_num);

//            echo "<br>result_num: " . $result_num;
//            echo "<br>alph: " . $alph[$result_num];

            array_push($result, $alph[$result_num]);

            $j++;
//            echo "<br>j: " . $j . "... normal";

        }

        return implode($result);
    }

    $plaintext = file_get_contents($_FILES['pt_source']['tmp_name']);
    echo "Original plain text: " . $plaintext;
    $plaintext = _trim($plaintext);
    echo "<br>Trimmed plain text: " . $plaintext;

    $gamma = file_get_contents($_FILES['g_source']['tmp_name']);
    echo "<br><br>Original gamma: " . $gamma;
    $gamma = _trim($gamma);
    echo "<br>Trimmed gamma: " . $gamma;

    echo "<br><br>Gamming result: " . gamming($plaintext, $gamma, $alph);

    echo "<br><br>Ungamming result: " . ungamming(gamming($plaintext, $gamma, $alph), $gamma, $alph);

//    decbinned($alph, "content");
//    decbinned($content, "content");
//
//    parse($alph, $content, "alph + content");

?>

</body>
</html>