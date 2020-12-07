<?php

function get_connection()
{
    return new PDO('mysql:host=localhost;dbname=wp_db', 'root', '');
}

function insert(array $data)
{
    $query = 'INSERT INTO users (name, email, password, created_at) VALUES(?, ?, ?, ?)';
    $db = get_connection();
    $stmt = $db->prepare($query);
    return $stmt->execute($data);
}

function getUserByEmail(string $email)
{
    $query = 'SELECT * FROM users WHERE email = ?';

    $db = get_connection();
    $stmt = $db->prepare($query);
    $stmt->execute([$email]);

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result;
    }

    return false;
}

function getIdList()
{
    $query = 'SELECT * FROM cypher ORDER BY id DESC';

    $db = get_connection();
    return $db->query($query,PDO::FETCH_ASSOC);
}