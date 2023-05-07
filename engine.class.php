<?php
require_once('db.class.php');
require_once('httpMsg.php');

class ENGINE extends DB
{

    public function wallet($uNo){
       
        $amount = 0;
        $Dtt = time();
        $status = 'not verify';

        $sql    =  "INSERT INTO `_wallet`  (`_uNumber`, `_amount`, `_status`, `timestamp`) VALUES ('$uNo', '$amount', '$status', '$Dtt')";
        $query  =   $this->Jigo->query($sql) or die($this->Jigo->error);
        if ($query) {
            $Task = 'wallet';
            $msg  =  'Successfully create wallet';
            $this->Logs($uNo, $Task, $msg);
            return true;
        }else{
            $Task = 'wallet';
            $msg  =  'having issue creating a wallet : system error!';
            $this->Logs($uNo, $Task, $msg);
            return false;
        }  
    } 

    public function viewUserAll()
    {
        $sql = "SELECT * FROM `_crew` ORDER BY `_date` ASC";
        $query = $this->Jigo->query($sql);
        if($query->num_rows > 0){
            header($_SERVER['SERVER_PROTOCOL']. ' 302 '.getHttpMsg(302));
            $dataArray = array();
            $dataArray['status']    = 'Data found successfully';
            $dataArray['message']   = getHttpMsg(302);
            $dataArray['errCode']   = 302;
            $dataArray['dataCount'] = $query->num_rows;
            $dataArray['hint']      = '';
            $dataArray['data'] = array();

            while ($key = $query->fetch_array()) {
                
                $dataDB = array(
                    'UniqueKey'     =>  $key['_uKey'],
                    'fullname'      =>  $key['_name'],
                    'email'         =>  $key['_email'],
                    'number'        =>  $key['_mobileNo'],
                    'password'      =>  $key['_pass'],
                    'verify'        =>  $key['_ver'],
                    'status'        =>  $key['_status'],
                    'timeStamp'     =>  $key['_date']
                );
                array_push($dataArray['data'], $dataDB);
            }
            return json_encode($dataArray);
        }else{
            return $this->dataOut(204,  'Data not found', '');
        }
    }

    public function viewTransaction($number = NULL)
    {
        if (!empty($number) || $number != '' || $number != NULL) {
            $sql = "SELECT * FROM `_transaction` WHERE `_uNumber` = '".$number."' LIMIT 1";

            $query = $this->Jigo->query($sql);
            if($query->num_rows > 0){
                header($_SERVER['SERVER_PROTOCOL']. ' 302 '.getHttpMsg(302));
                $dataArray = array();
                $dataArray['status']    = 'Data found successfully';
                $dataArray['message']   = getHttpMsg(302);
                $dataArray['errCode']   = 302;
                $dataArray['dataCount'] = $query->num_rows;
                $dataArray['hint']      = '';
                $dataArray['data'] = array();

                while ($key = $query->fetch_array()) {

                    $dataDB = array(
                        'id'            =>  $key['id'],
                        'transactionId' =>  $key['_transactionId'],
                        'userNumber'    =>  $key['_uNumber'],
                        'product'       =>  $key['_product'],
                        'amount'        =>  $key['_amount'],
                        'referenceId'   =>  $key['_refId'],
                        'status'        =>  $key['_status'],
                        'timestamp'     =>  $key['timestamp']
                    );
                    array_push($dataArray['data'], $dataDB);
                }
                return json_encode($dataArray);
            }else{
                return $this->dataOut(204,  'Data not found', '');
            }
        }else{
            $sql = "SELECT * FROM `_transaction` ORDER BY `timestamp` ASC";
            $query = $this->Jigo->query($sql);
            if($query->num_rows > 0){
                header($_SERVER['SERVER_PROTOCOL']. ' 302 '.getHttpMsg(302));
                $dataArray = array();
                $dataArray['status']    = 'Data found successfully';
                $dataArray['message']   = getHttpMsg(302);
                $dataArray['errCode']   = 302;
                $dataArray['dataCount'] = $query->num_rows;
                $dataArray['hint']      = '';
                $dataArray['data'] = array();

                while ($key = $query->fetch_array()) {
                    
                    $dataDB = array(
                        'id'            =>  $key['id'],
                        'transactionId' =>  $key['_transactionId'],
                        'userNumber'    =>  $key['_uNumber'],
                        'product'       =>  $key['_product'],
                        'amount'        =>  $key['_amount'],
                        'referenceId'   =>  $key['_refId'],
                        'status'        =>  $key['_status'],
                        'timestamp'     =>  $key['timestamp']
                    );
                    array_push($dataArray['data'], $dataDB);
                }
                return json_encode($dataArray);
            }else{
                return $this->dataOut(204,  'Data not found', '');
            }
        }
    }

    public function delWallet($number)
    {
        $sql    = "DELETE FROM `_wallet` WHERE `_uNumber` = '".$number."'";
        $query  = $this->Jigo->query($sql);
        if ($query) {
            return true;
        }else{
        return false;
        }
    }

    public function viewUserWallet($number = NULL)
    {
        if (!empty($number) || $number != '' || $number != NULL) {
            $sql = "SELECT * FROM `_wallet` WHERE `_uNumber` = '".$number."' LIMIT 1";

            $array = array();
            $query = $this->Jigo->query($sql);
            if($query->num_rows > 0){
                header($_SERVER['SERVER_PROTOCOL']. ' 302 '.getHttpMsg(302));
                $dataArray = array();
                $dataArray['status']    = 'Data found successfully';
                $dataArray['message']   = getHttpMsg(302);
                $dataArray['errCode']   = 302;
                $dataArray['dataCount'] = $query->num_rows;
                $dataArray['hint']      = '';
                $dataArray['data'] = array();

                while ($key = $query->fetch_array()) {
                    
                    $dataDB = array(
                        'id'           =>  $key['id'],
                        'userNumber'   =>  $key['_uNumber'],
                        'balance'       =>  $key['_amount'],
                        'status'       =>  $key['_status'],
                        'timestamp'    =>  $key['timestamp']
                    );
                    array_push($dataArray['data'], $dataDB);
                }
                return json_encode($dataArray);
            }else{
                return $this->dataOut(204,  'Data not found', '');
            }
        }else{
            $sql = "SELECT * FROM `_wallet` ORDER BY `timestamp` ASC";
            $query = $this->Jigo->query($sql);
            if($query->num_rows > 0){
                header($_SERVER['SERVER_PROTOCOL']. ' 302 '.getHttpMsg(302));
                $dataArray = array();
                $dataArray['status']    = 'Data found successfully';
                $dataArray['message']   = getHttpMsg(302);
                $dataArray['errCode']   = 302;
                $dataArray['dataCount'] = $query->num_rows;
                $dataArray['hint']      = '';
                $dataArray['data'] = array();

                while ($key = $query->fetch_array()) {
                    
                    $dataDB = array(
                        'id'           =>  $key['id'],
                        'userNumber'   =>  $key['_uNumber'],
                        'balance'       =>  $key['_amount'],
                        'status'       =>  $key['_status'],
                        'timestamp'    =>  $key['timestamp']
                    );
                    array_push($dataArray['data'], $dataDB);
                }
                return json_encode($dataArray);
            }else{
                return $this->dataOut(204,  'Data not found', '');
            }
        }
    }

    public function updateWallet($number, $amount, $status)
    {
        $sql    =  "UPDATE `_wallet` SET `_uNumber` = '$number', `_amount` = '$amount', `_status` = '$status' WHERE `_uNumber` = '".$number."'";
        $query  =   $this->Jigo->query($sql);
        if ($query) {
            return true;
        }else{
            return false;
        }
        
       
    }

    public function viewByUniqueKey($uKey)
    {

        $sql = "SELECT * FROM `_crew` WHERE `_uKey` = '".$uKey."' || `_email` = '".$uKey."' || `_mobileNo` = '".$uKey."' LIMIT 1";

        $array = array();
        $query = $this->Jigo->query($sql);
        if($query->num_rows > 0){
            while ($row = $query->fetch_array()) {
                $array[] = $row;
            }
            return $array;
        }else{
            return false;
        }
    }

    public function dataOut($CODE, $msg, $hint, array $data = null)
    {
        if (empty($data) || $data == '' || $data == NULL) {
            $dataOut = [
                'status'  => $msg,
                'message' => getHttpMsg($CODE),
                'errCode' => $CODE,
                'hint'    => $hint
            ];
        }else{
            if ($data['UniqueKey']  == NULL) {
                $dataOut = [
                    'status'  => $msg,
                    'message' => getHttpMsg($CODE),
                    'errCode' => $CODE,
                    'hint'    => $hint,
                    'data'    => [
                        'fullname'  =>  $data['fullname'],
                        'email'     =>  $data['email'],
                        'number'    =>  $data['number'],
                        'password'  =>  $data['password'],
                        'timeStamp' =>  time(),
                    ]
                ];
            }else{
                $dataOut = [
                    'status'  => $msg,
                    'message' => getHttpMsg($CODE),
                    'errCode' => $CODE,
                    'hint'    => $hint,
                    'data'    => [
                        'UniqueKey' =>  $data['UniqueKey'],
                        'fullname'  =>  $data['fullname'],
                        'email'     =>  $data['email'],
                        'number'    =>  $data['number'],
                        'password'  =>  $data['password'],
                        'verify'    =>  $data['verify'],
                        'status'    =>  $data['status'],
                        'timeStamp' =>  $data['timeStamp'],
                    ]
                ];
            }
        }
        //http_response_code(201);
        header($_SERVER['SERVER_PROTOCOL']. ' ' .$CODE.' '.$msg);
        return json_encode($dataOut);
    }

    public function Logs($userName, $Task, $msg){
        $Dtt = time();
        $IppA = $this->ipAddress();

        $sql    =  "INSERT INTO `logs` (`username`, `task`, `msg`, `ip`, `date`) 
        VALUES ('$userName', '$Task', '$msg', '$IppA', '$Dtt')";
        $query  =   $this->Jigo->query($sql);
        if ($query) {
            return true;
        }else{
            false;
        }
    } 


    public function updateUser($name, $email, $number, $pass, $verify, $status)
    {
        $ddte   =   time();
        $sql    =   "UPDATE `_crew` SET `_name` = '$name', `_email` = '$email', `_mobileNo` = '$number', `_pass` = '$pass', `_ver` = '$verify', `_status` = '$status', `_Update` = '$ddte' WHERE `_mobileNo` = '".$number."'";
        $query  =   $this->Jigo->query($sql);
        if ($query) {
            return true;
        }else{
            return false;
        }
        
       
    }

    public function delUser($number)
    {
        $sql    = "DELETE FROM `_crew` WHERE `_mobileNo` = '".$number."'";
        $query  = $this->Jigo->query($sql);
        if ($query) {
            return true;
        }else{
        return false;
        }
    }

    public function SignUp($name, $email, $phone, $pass){

        $query      = "SELECT * from `_crew` WHERE `_email` = '$email' OR  `_mobileNo` = '$phone' ";
        $result     = $this->Jigo->query($query) or die($this->Jigo->error);
        $count_row  = $result->num_rows;
        if ($count_row > 0) {
            $Task = 'signup';
            $msg  =  'Dublicate : trying to signup with the same email or phone number.';
            $this->Logs($phone, $Task, $msg);
            return 3; // email / phone found!
           
        }else{
            $verify = 0;
            $Dtt = time();
            $status = 'not verify';
            $Keys =  genRandomKeys(40);

            $sql    =  "INSERT INTO `_crew`  (`_uKey`, `_name`, `_email`, `_mobileNo`, `_pass`, `_ver`, `_status`, `_date`) 
            VALUES ('$Keys', '$name', '$email', '$phone', '$pass', '$verify', '$status', '$Dtt')";
            $query  =   $this->Jigo->query($sql) or die($this->Jigo->error);
            if ($query) {
                $Task = 'signup';
                $msg  =  'Successfully signup';
                $this->Logs($phone, $Task, $msg);
                $this->wallet($phone);
                return 1; // SignUp successfully
            }else{
                $Task = 'signup';
                $msg  =  'having issue in signup : system error!';
                $this->Logs($phone, $Task, $msg);
                return 2; // Not SignUp
            }
        }   
    } 

    /**
     * Check user IP Address.
     *
     */
    public function ipAddress()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            $ip = $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            $ip = $_SERVER["HTTP_FORWARDED"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])) {
            $ip = $_SERVER["REMOTE_ADDR"];
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
        
        if(strpos($ip, ',') !== false){
            $ip = explode(',', $ip)[0];
        }

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return 'unknown';
        }

        return $ip;
    }

}


?>