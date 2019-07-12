<?php

namespace Contacts\Components;

use PDO;

class DB
{
    public static function getConnection()
    {
        $paramsPath = ROOT . '/Configs/db_params.php';
        $params = include($paramsPath);

        $dsn = "mysql:host={$params['host']};port={$params['port']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, FALSE );

        return $db;
    }
}