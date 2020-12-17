<?php

function _trim($str)
// приведение строки к верхнему регистру с удалением пробелов, переносов строки и т.п.
{
    return strtoupper(preg_replace("/\s+/", "", $str));
}

function gamming($pt, $g, $alph)
// функция гаммирования
{

    $result = array(); $j = 0;

    for ($i = 0; $i < strlen($pt); $i++) {
    // [0; длина строки исходного текста)

        if ($j >= strlen($g)) $j = 0;

        $cur_pt_sym = mb_strcut($pt, $i, 1);
        // чтение одного символа строки исходного текста
        echo "\n\ncur_pt_sym: " . $cur_pt_sym;

        if (!array_search($cur_pt_sym, $alph)) { echo "\nPushing " . $cur_pt_sym; array_push($result, $cur_pt_sym); }
        // символ не входит в алфавит -> игнорирование символа (внесение в шифр-текст)
        else {

            $cur_g_sym = mb_strcut($g, $j, 1);
            // чтение одного символа строки гаммы

            echo "\ncur_g_sym: " . $cur_g_sym;

            $cur_pt_num = array_search($cur_pt_sym, $alph);
            // поиск номера текущего символа строки исходного текста в алфавите
            $cur_g_num = array_search($cur_g_sym, $alph);
            // поиск номера текущего символа строки гаммы в алфавите

            echo "\ncur_pt_num: " . $cur_pt_num . "\ncur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num + $cur_g_num;
            // номер символа шифр-текста = номер символа исходного текста + номер символа гаммы

            while ($result_num > count($alph)) {
            // если номер символа шифр-текста выходит за пределы массива алфавита

                echo "\nresult_num: " . $result_num . "\ncount(alph): " . count($alph);

                $result_num -= (count($alph) - 1);
                // смещение номера символа шифр текста

                echo "\nresult: " . $result_num;
            }

            echo "\nresult_num: " . $result_num . "\nalph: " . $alph[$result_num];

            // внесение символа шифр-текста в итоговый массив
            array_push($result, $alph[$result_num]);

            $j++;
        }
    }

    return implode($result);
    // возвращаемое значение - строка элементов итогового массива

}

function ungamming($ct, $g, $alph)
// функция обратного гаммирования
{

    $result = array(); $j = 0;

    for ($i = 0; $i < strlen($ct); $i++) {
    // [0; длина строки исходного текста)

        if ($j >= strlen($g)) $j = 0;

        $cur_pt_sym = mb_strcut($ct, $i, 1);
        // чтение одного символа строки исходного текста
        echo "\n\ncur_pt_sym: " . $cur_pt_sym;

        if (!array_search($cur_pt_sym, $alph)) { echo "\nPushing " . $cur_pt_sym; array_push($result, $cur_pt_sym); }
        else {

            $cur_g_sym = mb_strcut($g, $j, 1);
            // чтение одного символа строки гаммы

            echo "\ncur_g_sym: " . $cur_g_sym;

            $cur_pt_num = array_search($cur_pt_sym, $alph);
            // поиск номера текущего символа строки исходного текста в алфавите
            $cur_g_num = array_search($cur_g_sym, $alph);
            // поиск номера текущего символа строки гаммы в алфавите

            echo "\ncur_pt_num: " . $cur_pt_num . "\ncur_g_num: " . $cur_g_num;

            $result_num = $cur_pt_num - $cur_g_num;
            // номер символа шифр-текста = номер символа исходного текста + номер символа гаммы

            while ($result_num > count($alph)) {
            // если номер символа шифр-текста выходит за пределы массива алфавита

                echo "\n$result_num: " . $result_num . "\ncount(alph): " . count($alph);

                $result_num -= (count($alph) - 1);
                // смещение номера символа шифр текста
                echo "\nresult: " . $result;
            }
            if ($result_num <= 0) $result_num = count($alph) - abs($result_num - 1);

            echo "\nresult_num: " . $result_num . "\nalph: " . $alph[$result_num];

            // внесение символа шифр-текста в итоговый массив
            array_push($result, $alph[$result_num]);

            $j++;
        }
    }

    return implode($result);
    // возвращаемое значение - строка элементов итогового массива
}

function isInputEmpty()
// функция проверки наличия входных данных
{
    $isEmpty = false;
    if (empty(file_get_contents($_FILES['pt_source']['tmp_name'])) || empty(file_get_contents($_FILES['g_source']['tmp_name']))) {
    // если файл исходного текста пуст / отсутствует ИЛИ файл гаммы пуст / отсутствует
        header($_SERVER['SERVER_PROTOCOL'] . ' Input stream cannot be empty');
        $isEmpty = true;
    }
    return $isEmpty;
}

if (!isInputEmpty())
// проверка наличия входных данных
{

    $alph = array(
        "0" => null,
    );

    for ($i = 65; $i < 91; $i++) array_push($alph, chr($i));
    // заполнение массива алфавита в кодировке ASCII

    $plaintext = file_get_contents($_FILES['pt_source']['tmp_name']);
    // чтение исходного текста из файла
    $gamma = file_get_contents($_FILES['g_source']['tmp_name']);
    // чтение гаммы из файла
    echo "Original plain text: " . $plaintext . "\nOriginal gamma: " . $gamma . "\n";

    $plaintext = strtoupper($plaintext); $gamma = _trim($gamma);
    // преобразование входных данных
    echo "\nTrimmed plain text: " . $plaintext . "\nTimmed gamma: " . $gamma;

    $actform = $_POST['actform'];
    if ($actform == "decrypt") $result = ungamming($plaintext, $gamma, $alph);
    else $result = gamming($plaintext, $gamma, $alph);
    // выбор типа операции в соответствии с radio-кнопками и ее выполнение

    file_put_contents("file.txt", $result);
    // запись результата в файл на сервере
    echo "\n\nResult: " . $result;

    $hostname = "localhost"; $username = "root"; $password = ""; $dbName = "gamming_db";
    $conn = mysqli_connect($hostname, $username, $password, $dbName) or die ("Unable to connect");
    // подключение к базе данных по вышеуказанным данным

    $plaintext = _trim($plaintext); $result = _trim($result);
    $sql = "INSERT INTO history (id, plaintext, gamma, action, result) VALUES ('', '$plaintext', '$gamma', '$actform', '$result')";
    // определение sql-запроса внесения данных в таблицу (ведение истории операций)

    if (mysqli_query($conn, $sql)) {
        echo "\nHisrory updated";
    } else {
        echo "Error: " . $sql . "\n" . mysqli_error($conn);
    } // выполнение sql-запроса и проверка его успешности

}

?>