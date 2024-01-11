<?php


header('Content-type: json/application');
require 'function.php';

$method = $_SERVER['REQUEST_METHOD'];

//$connect = mysqli_connect('localhost','f0787511_yes','UnPlay1337228','f0787511_yes');
$connect = mysqli_connect('localhost','root','','cardb');

$q = $_GET['q'];
$params = explode('/',$q);

$key = $params[0];
$type = $params[1];
$id = $params[2];
if(checkAuth($connect,$key)){
    if($method === 'GET'){
        switch ($type) {
            case 'GetOnUserInfo':
                GetOnUserInfo($connect, $key);
                break;
            case 'GetOnUserInfoByLogin':
                GetOnUserInfoByLogin($connect, $key, $id);
                break;
            case 'GetAllDrives':
                GetAllDrives($connect, $key);
                break;
            case 'GetDrivesOnUser':
                GetDrivesOnUser($connect, $key, $id);
                break;
            case 'GetDrivesOnCity':
                GetDrivesOnCity($connect, $key, $id);
                break;
            case 'GetAllDrivesOnUser':
                GetAllDrivesOnUser($connect, $key, $id);
                break;
            case 'GetAllUser':
                GetAllUser($connect, $key);
                break;
            case 'GetAllLogs':
                GetAllLogs($connect, $key);
                break;
            case 'GetLogsByAction':
                GetLogsByAction($connect, $key, $id);
                break;
            case 'GetLogsByUser':
                GetLogsByUser($connect, $key, $id);
                break;
            case 'GetActiveReport':
                GetActiveReport($connect, $key);
                break;
            case 'GetInfoOnReport':
                GetInfoOnReport($connect, $key, $id);
                break;
            case 'CheckReport':
                CheckReport($connect, $key, $id);
                break;
            case 'CloseReport':
                CloseReport($connect, $key, $id);
                break;
            case 'GetAllApiFunction':
                GetAllApiFunction($connect, $key);
                break;
            case 'OnOffApiFunction':
                OnOffApiFunction($connect, $key, $id);
                break;
            case 'GetInfoByFunctionId':
                GetInfoByFunctionId($connect, $key, $id);
                break;
            case 'GetCountUser':
                GetCountUser($connect, $key);
                break;
            case 'GetCountDrives':
                GetCountDrives($connect, $key);
                break;
            case 'GetCountGoodReports':
                GetCountGoodReports($connect, $key);
                break;
            case 'GetCountBadReports':
                GetCountBadReports($connect, $key);
                break;
            case 'AddBan':
                AddBanUser($connect, $key, $user);
                break;
            case 'AddWarn':
                AddBanUser($connect, $key, $user);
                break;
            default:
                $res =[
                    "status" => false,
                    "message" => "Method not found"
                ];
                echo json_encode($res);
                break;
        }
    } elseif ($method === 'POST'){

        switch($type) {
            case 'RegisterUser':
                RegisterUser($connect, $key ,$_POST);
                break;
            case 'LoginUser':
                LoginUser($connect, $_POST);
                break;
            case 'AddAnswer':
                AddAnswer($connect, $key, $_POST);
                break;
            case 'UpdateLevelApiFunction':
                UpdateLevelApiFunction($connect, $key, $_POST);
                break;
            default:
                $res =[
                    "status" => false,
                    "message" => "Method not found"
                ];
                echo json_encode($res);
                break;
        }
    }
}