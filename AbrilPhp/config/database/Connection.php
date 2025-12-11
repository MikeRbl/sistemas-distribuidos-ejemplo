<?php

namespace Config\database;

use PDO;
use \PDOException;

class Connection{
    // DATOS DE CONEXIÓN
    private static $host = "localhost";
    private static $db_name = "postgres"; // ¿Seguro que tu base se llama 'postgres'?
    private static $user_name = "postgres";   // EN POSTGRES EL USUARIO SUELE SER 'postgres', NO 'root'
    private static $password = "123456789";
    private static $port = "5432";
    
    public static function connection(){
        try 
        {
            // OJO: Esto intenta conectar a PostgreSQL. 
            // Si usas MySQL (XAMPP), esto fallará.
            return new PDO(
                'pgsql:host='.self::$host.';port='.self::$port.';dbname='.self::$db_name,
                self::$user_name,
                self::$password
            );
        }
        catch(PDOException $e)
        {
            // CAMBIO IMPORTANTE:
            // En vez de return null, matamos el proceso y mostramos el error
            // para saber qué está pasando.
            die(json_encode([
                "error" => true, 
                "msg" => "Connection failed: " . $e->getMessage()
            ]));
        }
    }
}