<?php
namespace App\Services;

use Config\database\Methods as db;
// 1. IMPORTANTE: Importamos tu clase Utils para crear el ID
use Config\utils\Utils; 

class AuthService { 
    
    public static function sign_up(String $id,String $name, String $password, String $phone, String $email){
        
        // 2. Generamos el ID único antes de guardar
        // Asegúrate de que tu clase Utils tenga el método uuid() funcionando
        // Si te da error en Utils, puedes probar temporalmente con: $id = uniqid();
       // $id = Utils::uuid(); 
        
        // 3. Encriptamos la contraseña de una vez (buena práctica)
        //$hashed_password = Utils::hash($password);

        $query = (object)[
            // 4. Agregamos 'id' al INSERT
            'query' => "INSERT INTO users (id, name,password, phone, email) VALUES (?,?,?,?,?)",
            
            // 5. Pasamos el $id y la contraseña encriptada en el array
            'params' => [$id, $name, $phone, $email, $password]
        ];

        return db::save($query);
    }
}