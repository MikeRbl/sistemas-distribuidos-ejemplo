<?php
namespace Router;

use Config\Jwt\Jwt;
use Config\utils\CustomExceptions as exc;
use App\Controllers\AuthController;

class Router{
    private static $routes=[
        "GET" => [

        ],
        "POST" => [
            "auth/signup" => [AuthController::class, "sign_up", 0],
        ],
        "PUT" => [

        ],
        "DELETE" => [

        ]
        ];
    
    public static function handle(String $method, String $uri, array $HEADERS)
    {
        try {
            // CORRECCIÓN 1: Agregado verificación si la ruta existe para evitar error "Undefined index"
            if (!isset(self::$routes[$method][$uri])) {
                throw new exc('001'); // O error 404
            }

            // CORRECCIÓN 2: Agregado punto y coma al final
            $typeuth = self::$routes[$method][$uri][2];
            
            if(is_null($typeuth)) throw new exc('001');
            
            if(!$typeuth){
                // simple cuando type_auth es 0
                // CORRECCIÓN 3: Quitado el ; después del if
                if(!isset($HEADERS['simple']) || $HEADERS['simple'] !== md5('123456789')) { 
                    throw new exc('006');
                }
            } else {
                // authorization cuando type_auth es 1
                // CORRECCIÓN 3: Quitado el ; después del if
                if(!isset($HEADERS['authorization']) || !Jwt::Check(@$HEADERS['authorization'])) {
                    throw new exc('006');
                }
            }

            $callback = self::$routes[$method][$uri];
            $controllerClass = $callback[0];
            $methodName = $callback[1];

            if(!class_exists($controllerClass)) throw new exc('002');

            $controllerInstance = new $controllerClass();

            if (!method_exists($controllerInstance, $methodName)) throw new exc('003');
            
            $requestData = self::getRequestData($method);
            return call_user_func([$controllerInstance, $methodName], $requestData);

        } catch(exc $e) {
            echo json_encode($e->GetOptions());
        } catch(\Throwable $th) {
            // CORRECCIÓN 4: Cambiado { } por [ ] para array de PHP
            echo json_encode([
                "error"=> true,
                "msg"=> $th->getMessage(),
                "error_code"=> $th->getCode()
            ]);
        }
    }

    private static function getRequestData(string $REQUEST_METHOD){
        if($REQUEST_METHOD === 'GET'){
            $requestData = $_GET['params'] ?? null;
        }else{
            $requestData = file_get_contents("php://input");
        }
        return json_decode($requestData);
    }
}