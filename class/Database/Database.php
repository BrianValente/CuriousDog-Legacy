<?php
/**
 * Created by IntelliJ IDEA.
 * User: brianvalente
 * Date: 6/1/17
 * Time: 16:58
 */

namespace Ask\Database;

use mysqli;

class Database {
    private static $mysqli;

    /**
     * @return mysqli
     */
    public static function getConnection(): mysqli {
        if (!self::$mysqli) {
            self::$mysqli = mysqli_connect("DB_HOST", "DB_USER", "DB_PASSWORD", "DB");
            self::$mysqli->set_charset("utf8mb4");
        }

        return self::$mysqli;
    }

    public static function query(): Query {
        return new Query();

    }
}