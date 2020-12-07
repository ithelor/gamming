<?php

function register(array $data)
{
    $values = [
        $data['id'],
        $data['plaintext'],
        $data['gamma'],
        $data['action'],
        $data['result'],
    ];

    return insert($values);
}

function validate(array $request)
{
    $errors = [];

    if (!isset($request['email']) || strlen($request['email']) == 0) {
        $errors[]['email'] = 'E-Mail not specified';
    } elseif (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[]['email'] = 'Invalid E-Mail format';
    } elseif (strlen($request['email']) < 4) {
        $errors[]['email'] = 'E-Mail must contain more than 4 symbols';
    } elseif (isEmailAlreadyExists($request['email'])) {
        $errors[]['email'] = 'E-Mail already user';
    }

    if (!isset($request['name']) || empty($request['name'])) {
        $errors[]['name'] = 'Nickname not specified';
    }

    if (!isset($request['password']) || empty($request['password'])) {
        $errors[]['password'] = 'Password not specified';
    }

    if (!isset($request['repeat-password']) || empty($request['repeat-password'])) {
        $errors[]['repeat-password'] = 'You must repeat password';
    } elseif ((isset($request['password']) && isset($request['repeat-password'])) && ($request['password'] != $request['repeat-password'])) {
        $errors[]['repeat-password'] = 'Passwords do not match';
    }

    return $errors;
}

function isEmailAlreadyExists(string $email)
{
    if (getUserById($email)) {
        return true;
    }

    return false;
}