<?php

namespace App\Controller;


use App\Helpers\JWTHelper;
use Core\Controller\Controller;


class AppController extends  Controller
{
    protected $viewPath;
    protected $template = 'default';
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('User');
    }

    protected function User($key){
        //Get the user from session or from jwt
        if(!isset($_SESSION['user'])){
            return null;
        }
        $user = $_SESSION['user'];
        if(!isset($user->$key)){
            return null;
        }
        return $user->$key;
    }

    protected function CurrentUser($key = '') {
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $user = null;
        if(!empty($_SESSION['user'])) {
            $user = $_SESSION['user'];
        }
        //Check if the user working from api
        else if(strpos($requestContentType,'application/json') !== false) {
            $jwt = JWTHelper::getBearerToken();
            $jwt = JWTHelper::decodeAndValidateJWT($jwt);
            if(isset($jwt['object']['id']->data)) {
                $id = (int)$jwt['object']['id']->data;
                if ($id) {
                    $full_version = true;
                    return $this->User->find($id, $full_version);
                }
            }
        }
        if(empty($key)) {
            return (object)$user;
        }
        else {
            if(!isset($user->$key)){
                return null;
            }
            return $user->$key;
        }
    }

    protected function canUser($perm_name) {
        $user = $this->CurrentUser();
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        if(!isset($user->id)) {
            //Check if this is an api call
            if(strpos($requestContentType,'application/json') !== false){
                $this->restHandler->setHttpHeaders($requestContentType, 401);
                $response = json_encode([
                    'object' => [],
                    'error' => 'Unauthorized user',
                    'code' => 401
                ]);
                echo $response;
                exit();
            }
            return false;
        }
        $perm_value = $user->$perm_name;
        if(!$perm_value) {
            if(strpos($requestContentType,'application/json') !== false){
                $this->restHandler->setHttpHeaders($requestContentType, 401);
                $response = json_encode([
                    'object' => [],
                    'error' => 'Forbidden',
                    'code' => 403
                ]);
                echo $response;
                exit;
            }
        }

        return $perm_value;
    }

}