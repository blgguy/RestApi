<?php
    error_reporting(0);
    //security headers
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header('X-Powered-By: PHP');
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    header_remove('Server');

    require('engine.class.php');

    $OBJ = new ENGINE();

    if ($_SERVER['REQUEST_METHOD'] != 'GET') {

        echo $OBJ->dataOut(405,  $_SERVER['REQUEST_METHOD']. ' '. getHttpMsg(405), 'Request method should be GET');
    
    }else{

        $dataIn = json_decode(file_get_contents("php://input"));

        if (!empty($dataIn)) {
            $getUserNumber   = $dataIn->userNumber;
        }else{
            $getUserNumber   = $_POST['userNumber'];
        }
        
        if (!empty($getUserNumber) || $getUserNumber != NULL || $getUserNumber != '') {
            $getUserNumber = secronize_($getUserNumber);
           
            $hint = "use correct uniqueKey, phone or email e.g {'userNumber': 'uniqueKey/phone/email'}";
               
            $VIEW         = $OBJ->viewTransaction($getUserNumber);
            echo $VIEW;

        }else{

            $VIEW         = $OBJ->viewTransaction();
            echo $VIEW;
        }
    }
?>