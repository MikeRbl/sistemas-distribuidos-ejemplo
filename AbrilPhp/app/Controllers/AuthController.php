<?php
namespace App\Controllers;
use App\Models\AuthModel;

class AuthController
{
    public static function sign_up($data){
        echo json_encode(AuthModel::sign_up($data->name,$data->password,$data->email,$data->phone));
    }
}