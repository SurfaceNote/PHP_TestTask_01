<?php

class Database
{
    private static string $dsn = 'pgsql:host=localhost;dbname=TestTask';
    private static string $username = '';
    private static string $password = '';

    public static function InfoForConnection()
    {
        return [
            'dsn' => self::$dsn,
            'username' => self::$username,
            'password' => self::$password
        ];
    }
}