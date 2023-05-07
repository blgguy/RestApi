<?php
    error_reporting(0);
    //security headers
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header('X-Powered-By: PHP');
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    header_remove('Server');

    require('engine.class.php');

    $OBJ = new ENGINE();

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {

        echo $OBJ->dataOut(405,  $_SERVER['REQUEST_METHOD']. ' - Method Not Allowed', 'Request method should be POST');
    
    }else{
    
        $dataIn = json_decode(file_get_contents("php://input"));

        if (!empty($dataIn)) {
            $fullname   = secronize_($dataIn->fullname);
            $email      = secronize_($dataIn->email);
            $number     = secronize_($dataIn->number);
            $password   = secronize_($dataIn->password);
        }else{
            $fullname   = secronize_($_POST['fullname']);
            $email      = secronize_($_POST['email']);
            $number     = secronize_($_POST['number']);
            $password   = secronize_($_POST['password']);
        }
       
    
        $data = "{'fullname': 'John doe','number':'+2348012345678','password': '1234Abcd&', 'email':'amb@gjmahikjl.com'}";
                    
        if (empty($fullname)) {
            echo $OBJ->dataOut(203,  'Full Name required', $data);

        }else if (empty($number)) {
            echo $OBJ->dataOut(203,  'Mobile Number required', $data);

        }else if (empty($password)) {
            echo $OBJ->dataOut(203,  'Password required', $data);

        }else{

         
            $data = array(
                'fullname'  =>  secronize_($fullname),
                'email'     =>  secronize_($email),
                'number'    =>  secronize_($number),
                'password'  =>  secronize_($password)
            );

            $INSERT         = $OBJ->SignUp($fullname, $email, $number, $password);

            switch ($INSERT) {
                case 1:
                    http_response_code(201);
                    echo $OBJ->dataOut(201,  'Ok - Signup successfully', '', $data);
                    break;

                case 2:
                    echo $OBJ->dataOut(502,  'not Signup', '0');
                    break;

                case 3:
                    echo $OBJ->dataOut(409,  'Dublicate Entry', '0');
                    break;
                
                default:
                    echo $OBJ->dataOut(500,  'Internal Server error', '0');        
                    break;
            }
    
        }
    }
?>