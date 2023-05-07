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
        //$getKey = $_GET['ukey'];
        $dataIn = json_decode(file_get_contents("php://input"));

        $getKey   = $dataIn->ukey;

        $hint = "use correct uniqueKey, phone or email e.g {'ukey': 'uniqueKey/phone/email'}";
        
        if (!empty($getKey) || $getKey != NULL || $getKey != '') {
            $getKey = secronize_($getKey);
           
               
            $VIEW         = $OBJ->updateByUniqueKey($getKey);

            if ($VIEW) {
                foreach ($VIEW as $key) {
                    $data = array(
                        'UniqueKey'     =>  $key['_uKey'],
                        'fullname'      =>  $key['_name'],
                        'email'         =>  $key['_email'],
                        'number'        =>  $key['_mobileNo'],
                        'password'      =>  $key['_pass'],
                        'verify'        =>  $key['_ver'],
                        'status'        =>  $key['_status'],
                        'timeStamp'     =>  $key['_date']
                    );
                }
                    echo $OBJ->dataOut(302,  'Data found', $hint, $data);
                
                
            }else{
                echo $OBJ->dataOut(404,  'Data not found', $hint);
                    
            }

        }else{
              
            echo $OBJ->dataOut(401,  'pleas Error', $hint);

        }
    }
?>