<?php

namespace Config\database;
//Excepciones especificas 
use Exception;
//Excepcioness generales
use Throwable;
use PDO;
use Config\database\Connection;

class Methods
{
    public static function save(Object $obj)
    {
        $array = [];
        try 
        {
            $db = Connection::connection();
            $stmt = $db->prepare($obj->query); 
            
            // CORRECCIÓN 1: Era 'execute', no 'excute'
            if (!$stmt->execute($obj->params)) {
                 throw new Exception("Falló la ejecución de la consulta.");
            }

            // Nota: En un INSERT, fetchColumn no suele devolver nada,
            // pero lo dejaré comentado por si acaso afecta tu lógica.
            // $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            $db = null;
            $array = ["error" => false, "msg" => "query_executed"];
        } 
        catch (Throwable $th) 
        {
            // CORRECCIÓN 2: Mostramos el error REAL para que puedas arreglarlo
            $array = [
                "error" => true, 
                "msg" => $th->getMessage() 
            ];
        }
        return $array;
    }
}