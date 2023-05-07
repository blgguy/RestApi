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
            $getUserNumber   = $dataIn->userNumber;
            $getUserBalance  = $dataIn->balance;
            $getUserStatus   = $dataIn->status;
        }else{
            $getUserNumber   = $_POST['userNumber'];
            $getUserBalance  = $_POST['balance'];
            $getUserStatus   = $_POST['status'];
        }
        
        if (!empty($getUserNumber) || $getUserNumber != NULL || $getUserNumber != '') {
            $hint = "use correct phone e.g {'userNumber': 'phone number', 'balance': 'balance in digit', 'status': 'Verify/not verify/ban'}";

            if (empty($getUserBalance) || empty($getUserStatus)) {
                echo $OBJ->dataOut(203,  'Number/Status Empty', $hint, $data);
            }else{

                $getUserBalance = secronize_($getUserBalance);
                $getUserStatus = secronize_($getUserStatus);
                
                $UPDATE         = $OBJ->updateWallet($getUserNumber, $getUserBalance, $getUserStatus);
                if ($UPDATE) {
                    
                    echo $OBJ->dataOut(200,  'Updated successfully', '');
                    
                }else{
                    echo $OBJ->dataOut(304,  'Not Updated', $hint);
                        
                }
            }

        }else{

            echo $OBJ->dataOut(203,  'User Number Empty', $hint, $data);
        }
    }
?>