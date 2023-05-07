<?php
    error_reporting(0);
    //security headers
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('X-Content-Type-Options: nosniff');

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header('X-Powered-By: PHP');
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    header_remove('Server');

    require('engine.class.php');

    $OBJ = new ENGINE();

    if ($_SERVER['REQUEST_METHOD'] != 'PUT') {

        echo $OBJ->dataOut(405,  $_SERVER['REQUEST_METHOD']. ' '. getHttpMsg(405), 'Request method should be GET');
    
    }else{
        //$getKey = $_GET['ukey'];
        $dataIn = json_decode(file_get_contents("php://input"));

        if (!empty($dataIn)) {
            $getUserName        = $dataIn->name;
            $getUserEmail       = $dataIn->email;
            $getUserNumber      = $dataIn->userNumber;
            $getUserPasssword   = $dataIn->password;
            $getUserVerify      = $dataIn->verify;
            $getUserStatus      = $dataIn->status;
        }else{
            $getUserName        = $_POST['name'];
            $getUserEmail       = $_POST['email'];
            $getUserNumber      = $_POST['userNumber'];
            $getUserPasssword   = $_POST['password'];
            $getUserVerify      = $_POST['verify'];
            $getUserStatus      = $_POST['status'];
        }
        
        if (!empty($getUserNumber) || $getUserNumber != NULL || $getUserNumber != '') {
            $hint = "use correct phone e.g {'userNumber': 'phone number', 'name': 'fullname', 'email': 'email@domain.com', 'userNumber': 'mobile no', 'password': '*****', 'verify': '0 or 1', 'status': 'Verify/not verify/ban'}";
           
            $getUserName         = secronize_($getUserName);
            $getUserEmail        = secronize_($getUserEmail);
            $getUserNumber       = secronize_($getUserNumber);
            $getUserPasssword    = secronize_($getUserPasssword);
            $getUserVerify       = secronize_($getUserVerify);
            $getUserStatus       = secronize_($getUserStatus);
            
            $UPDATE         = $OBJ->updateUser($getUserName, $getUserEmail, $getUserNumber, $getUserPasssword, $getUserVerify, $getUserStatus);
            if ($UPDATE) {
                
                echo $OBJ->dataOut(200,  'Updated successfully', '');
                
            }else{
                echo $OBJ->dataOut(304,  'Not Updated', $hint);
                    
            }

        }else{

            echo $OBJ->dataOut(203,  'User Number Empty', $hint, $data);
        }
    }
?>