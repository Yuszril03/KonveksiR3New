<?php

namespace App\Controllers;

use App\Models\Activity\M_ActivityEmploye;
use App\Models\Activity\M_ActivityProduct;
use App\Models\Activity\M_ActivityQueueTransaction;
use App\Models\Activity\M_ActivityStockProduct;
use App\Models\Activity\M_ActivityTransaction;
use App\Models\Master\M_AccountEmployee;
use DateTime;

class C_Activity extends BaseController
{
    protected $M_ActivityEmploye;
    protected $M_ActivityStockProduct;
    protected $M_ActivityTransaction;
    protected $M_ActivityQueueTransaction;
    protected $M_AccountEmployee;
    protected $M_ActivityProduct;
    public function __construct()
    {

        $this->M_ActivityEmploye = new M_ActivityEmploye();
        $this->M_ActivityStockProduct = new M_ActivityStockProduct();
        $this->M_ActivityTransaction = new M_ActivityTransaction();
        $this->M_ActivityQueueTransaction = new M_ActivityQueueTransaction();
        $this->M_AccountEmployee = new M_AccountEmployee();
        $this->M_ActivityProduct = new M_ActivityProduct();
    }
    public function Employee($username, $Description, $Status, $Activity)
    {
        $data = [
            'id_session' => session()->get('SessionID'),
            'Username' => $username,
            'Activity' => $Activity,
            'Description' => $Description,
            'Device' => $this->CheckDevice(),
            'Status' => $Status
        ];
        $this->M_ActivityEmploye->saveData($data);
    }

    public function OpenTrans($idTrans)
    {
        $whereClose = [
            'Id_Transaction' => $idTrans,
            'Status' => 13
        ];
        $dataClose = [
            'Status' => 14
        ];
        $this->M_ActivityQueueTransaction->updateData($dataClose, $whereClose);
        $data = [
            'Id_Transaction' => $idTrans,
            'Id_Session' => session()->get('SessionID'),
            'Username' => session()->get('Username'),
            'Status' => 13
        ];
        $this->M_ActivityQueueTransaction->saveData($data);
    }
    public function CloseTrans($idTrans)
    {
        $whereClose = [
            'Id_Transaction' => $idTrans,
            'Status' => 13
        ];
        $dataClose = [
            'Status' => 14
        ];
        $this->M_ActivityQueueTransaction->updateData($dataClose, $whereClose);
    }
    public function checkTrans($idTrans)
    {
        $whereOpen = [
            'Id_Transaction' => $idTrans,
            'Username' => session()->get('Username'),
            'Status' => 13
        ];
        return $this->M_ActivityQueueTransaction->getData($whereOpen)->getNumRows();
    }
    public function LastActiveUser()
    {
        $date = new DateTime();
        $resultDate = $date->format('Y-m-d H:i:s');
        $where = [
            'Username' => session()->get('Username'),
            'IdSession' => session()->get('SessionID')
        ];
        $data = [
            'LastActive' => $resultDate
        ];
        $this->M_AccountEmployee->updateData($data, $where);
    }
    public function LogoutActiveUser()
    {
        $date = new DateTime();
        $resultDate = $date->format('Y-m-d H:i:s');
        $where = [
            'Username' => session()->get('Username'),
            'IdSession' => session()->get('SessionID')
        ];
        $data = [
            // 'Status' => 0,
            'IdSession' => null,
            'LastActive' => $resultDate
        ];
        $this->M_AccountEmployee->updateData($data, $where);
    }
    public function CreateQueueTransaction($idTrans, $username)
    {
        $data = [
            'Id_Transaction' => $idTrans,
            'Id_Session' => session()->get('SessionID'),
            'Username' => session()->get('Username'),
            'Status' => 11
        ];
        $this->M_ActivityQueueTransaction->saveData($data);
    }
    public function SetLogStock($id, $name, $stock, $type)
    {
        $data = [
            'IdProduct' => $id,
            'NameProduct' => $name,
            'Stock' => $stock,
            'Type_Stock' => $type,
            'CreatedBy' => session()->get('Username')
        ];
        $this->M_ActivityStockProduct->saveData($data);
    }
    public function SetLogTransaction($id, $des, $type, $Image = null, $Payment = 0, $OverPay = 0, $ChangePay = 0, $Status)
    {
        $data = [
            'Id_Transaction' => $id,
            'Description' => $des,
            'TypeTransaction' => $type,
            'Payment' => $Payment,
            'OverPay' => $OverPay,
            'ChangePay' => $ChangePay,
            'Status' => $Status,
            'Image' => $Image,
            'CreatedBy' => session()->get('Username')
        ];
        $this->M_ActivityTransaction->saveData($data);
    }
    public function getLogTransaksi($where)
    {
        return $this->M_ActivityTransaction->getData($where)->getResult('array');
    }


    public function activityUserEmploye()
    {
        $selisih = $this->request->getVar('Selisih');
        $dataArray = array();
        for ($i = 0; $i <= $selisih; $i++) {
            $dateStart = date_create($this->request->getVar('startDate'));
            $dateEnd = date_create($this->request->getVar('startDate'));
            date_add($dateStart, date_interval_create_from_date_string($i . " days"));
            date_add($dateEnd, date_interval_create_from_date_string($i + 1 . " days"));
            $where = "CreatedDate >='" . date_format($dateStart, "Y-m-d") . "' AND CreatedDate <'" . date_format($dateEnd, "Y-m-d") . "'";
            $jumlah = $this->M_ActivityEmploye->getData($where)->getNumRows();
            $tempArray = [
                'Name' => date_format($dateStart, "d-M-y"),
                'Value' => $jumlah
            ];
            array_push($dataArray, $tempArray);
        }
        echo json_encode($dataArray);
    }

    public function insertActivityProduk($IdProduct, $Status, $Satuan, $Stock, $Des, $IsDone)
    {
        $data = [
            'Id_Product' => $IdProduct,
            'Status' => $Status,
            'Satuan' => $Satuan,
            'Stock' => $Stock,
            'Description' => $Des,
            'CreatedBy' => session()->get('Username'),
            'isDone' => $IsDone,
        ];
        $this->M_ActivityProduct->saveData($data);
    }

    public function CheckDevice()
    {

        // Check if the "mobile" word exists in User-Agent 
        $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));

        // Check if the "tablet" word exists in User-Agent 
        $isTab = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "tablet"));

        // Platform check  
        $isWin = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "windows"));
        $isAndroid = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "android"));
        $isIPhone = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "iphone"));
        $isIPad = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "ipad"));
        $isIOS = $isIPhone || $isIPad;
        $deviceName = '';
        if ($isMob) {
            if ($isTab) {
                $deviceName = $deviceName . 'Tablet-';
            } else {
                $deviceName = $deviceName . 'Mobile-';
            }
        } else {
            $deviceName = $deviceName . 'Desktop-';
        }

        if ($isIOS) {
            $deviceName = $deviceName . 'IOS';
            // echo 'iOS';
        } elseif ($isAndroid) {
            $deviceName = $deviceName . 'Android';
            // echo 'ANDROID';
        } elseif ($isWin) {
            $deviceName = $deviceName . 'Windows';
            // echo 'WINDOWS';
        } else {
            $deviceName = $deviceName . 'Other';
        }

        return $deviceName;
    }

    public function sms()
    {

        $to = '083877354684';
        $msg = 'Mencoba API SMS';
        //init SMS gateway, look at android SMS gateway
        $idmesin = "445";
        $pin = "032811";

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, "https://sms.indositus.com/sendsms.php?idmesin=$idmesin&pin=$pin&to=$to&text=$msg");

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);
        print_r($output);
    }
}
