<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');
header('X-Powered-By: Something');
header('Date: time()');
header('Server: Somewhere somewhere');

//require('engine.class.php');

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    $dataOut = 
        [
            'status' => 405,
            'message' => $_SERVER['REQUEST_METHOD']. ' - Method Not Allowed',
            'errCode' => 'E509800'
        ];
    header('HTTP/1.0 405 Method Not Allowed');
    echo json_encode($dataOut);

}else{

    $dataInput = json_decode(file_get_contents('php://input'), true);
    if (empty($dataInput) || $dataInput == '' || $dataInput == NULL) {
        $dataOut = 
            [
                'status' => 301,
                'message' => 'Empty Data',
                'errCode' => 'E407900'
            ];
        header('HTTP/1.0 301 EMPTY DATA');
        echo json_encode($dataOut);
    }else{
        $INSERT = new ENGINE();


        
        $mobile         = secronize_($dataInput['number']);
        $fullName       = secronize_($dataInput['fullname']);
        $password       = secronize_($dataInput['password']);
        $emailAddress   = secronize_($dataInput['email']);
        
        $RefrenceId     = 'REF-'.rand(45678, 12306);
        $transactionId  = 'TRANSC-'.rand(45678, 12306);

        SignUp($name, $email, $phone, $pass)
    }
    
   
}

?>