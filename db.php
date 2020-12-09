<?php

function get_connection()
{
    return new PDO('mysql:host=localhost;dbname=gamming_db', 'root', '');
}

function getIDsList()
{
    $query = 'SELECT * FROM history ORDER BY id DESC LIMIT 5';

    $db = get_connection();
    return $db->query($query,PDO::FETCH_ASSOC);
}