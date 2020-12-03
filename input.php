<html lang="en">
<link href=alt_styles.css rel=stylesheet />
<body>

<?php

    function decbinned($content, $dbg_str)
    {
        $str = $content;
        $res = '0';

        for($i = 0; $i < strlen($str); $i++){
            $res .= decbin(ord($str[$i]));
        }

        echo "<br>" . "Decbinned: " . $dbg_str . " - " . $res;
    }

    function parse($alph, $content, $dbg_str)
    {
        $a = strlen($alph);
        $c = strlen($content);

        $trimmed = preg_replace("/\s+/", "", $content);
        echo "<br>" . "Trimmed: " . $dbg_str . " - " . $trimmed;
    }

    function _trim($str)
    {
        $trimmed = strtoupper(preg_replace("/\s+/", "", $str));

        return $trimmed;
    }

    $content = file_get_contents($_FILES['pt_source']['tmp_name']);

    echo "Original: " . $content;
    echo "<br>Trimmed: " . _trim($content);

//    decbinned($alph, "content");
//    decbinned($content, "content");
//
//    parse($alph, $content, "alph + content");

    $alph = array(
        "1" => "a",     "8"  => "h", "15" => "o",
        "2" => "b",     "9"  => "i", "16" => "p",   "22" => "v",
        "3" => "c",     "10" => "j", "17" => "q",   "23" => "w",
        "4" => "d",     "11" => "k", "18" => "r",   "24" => "x",
        "5" => "e",     "12" => "l", "19" => "s",   "25" => "y",
        "6" => "f",     "13" => "m", "20" => "t",   "26" => "z",
        "7" => "g",     "14" => "n", "21" => "u",
    );

?>

</body>
</html>