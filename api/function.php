<?php


$connect = mysqli_connect('localhost','root','','cardb');
//$connect = mysqli_connect('localhost','f0787511_yes','UnPlay1337228','f0787511_yes');

$solt = '66df6sdf865';

function checkAuth($connect, $key){
    $keys = mysqli_real_escape_string($connect, $key);
    $post = mysqli_query($connect, "SELECT * FROM `account` WHERE `ApiKey` = '$keys'");
    if(mysqli_num_rows($post) === 0){
        $res = [
            "status" => false,
            "post_id" => "Этот API ключ не авторизован"
        ];
        echo json_encode($res);
        return false;
    }
    else {
        return true;
    }
}
//Функция контроля пользователей
function checkFullInfoForAccount($connect, $key, $func) {
    
    $keys = mysqli_real_escape_string($connect, $key);
    $post = mysqli_query($connect, "SELECT * FROM `account` WHERE `ApiKey` = '$keys'");
    $user = mysqli_fetch_assoc($post);

    //Проверка блокировки
    if($user['Ban'] == 1) {
        $res = [
            "status" => false,
            "result_code" => "1"
        ];
        echo json_encode($res);
        return false;
    }

    //Проверка состояния
    $api_func = mysqli_query($connect, "SELECT * FROM `api_function` WHERE `FuncName` = '$func'");
    $obj_func = mysqli_fetch_assoc($api_func);

    if($obj_func['Status'] == 0) {
        $res = [
            "status" => false,
            "result" => "Функция временно недоступна"
        ];
        echo json_encode($res);
        return false;
    }
    //Проверка уровня
    if($user['LevelApi'] < $obj_func['NeedLevel']){
        $res = [
            "status" => false,
            "result" => "Недостаточно прав для выполнения"
        ];
        echo json_encode($res);
        return false;
    }
    //Логирование... Когда-нибудь.....
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = @$_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
    elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
    else $ip = $remote;
    $date = date("Y-m-d H:i:s");
    $LogsLogin = $user['Login'];
    $LogsRegIp = $user['RegIP'];
    mysqli_query($connect, "INSERT INTO `logs` (`id`, `LoginUser`, `Action`, `DateAction`, `RegIp`, `IP`) VALUES (NULL, '$LogsLogin', '$func', '$date', '$LogsRegIp', '$ip')");
    return true;
}
/**
 *  Вывод поллезных данных
 * 
 */
//Количество пользователей
function GetCountUser($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetCountUser')){
        $post = mysqli_query($connect, "SELECT COUNT(*) AS UserCount FROM `account`");
        $user = mysqli_fetch_assoc($post);
        echo json_encode($user);
    }
}
//Количество поездок
function GetCountDrives($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetCountDrives')){
        $post = mysqli_query($connect, "SELECT COUNT(*) AS drivesCount FROM `drives`");
        $user = mysqli_fetch_assoc($post);
        echo json_encode($user);
    }
}
//Количество успешных вопросов
function GetCountGoodReports($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetCountGoodReports')){
        $post = mysqli_query($connect, "SELECT COUNT(*) AS GoodReportCount FROM `reports` WHERE `status` = 3");
        $user = mysqli_fetch_assoc($post);
        echo json_encode($user);
    }
}
//Количество нерешенных вопросов
function GetCountBadReports($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetCountBadReports')){
        $post = mysqli_query($connect, "SELECT COUNT(*) AS BadReport FROM `reports` WHERE `status` < 3");
        $user = mysqli_fetch_assoc($post);
        echo json_encode($user);
    }
}


/**
 * Функции пользователей
 * 
 */


//Информация о пользователе по ключу
function GetOnUserInfo($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetOnUserInfo')){
        $keys = mysqli_real_escape_string($connect, $key);
        $post = mysqli_query($connect, "SELECT * FROM `account` WHERE `ApiKey` = '$keys'");
        $user = mysqli_fetch_assoc($post);
        echo json_encode($user);
    }
}
//Список всех пользователей
function GetAllUser($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetAllUser')){
        $posts = mysqli_query($connect, "SELECT * FROM `account`");
        $postsList = [];
        while($post = mysqli_fetch_assoc($posts)){
            $postsList[] = $post;
        }
        echo json_encode($postsList);
    }
}
//Информация о пользователе по логину
function GetOnUserInfoByLogin($connect, $key, $login){
    if(checkFullInfoForAccount($connect, $key, 'GetOnUserInfoByLogin')){
        $l = mysqli_real_escape_string($connect, $login);
        $post = mysqli_query($connect, "SELECT * FROM `account` WHERE `Login` = '$l'");
        $user = mysqli_fetch_assoc($post);
        if(mysqli_num_rows($post) === 0) {
            $res = [
                "status" => false,
                "code" => "2",
                "result" => "Пользователь не найден"
            ];
            echo json_encode($res);
        }
        else {
            echo json_encode($user);
        }
        
    }
}
/**
 * Функции поездок
 * 
 */
//Список всех поездок
function GetAllDrives($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetAllDrives')){
        $posts = mysqli_query($connect, "SELECT * FROM `drives`");
        $postsList = [];
        while($post = mysqli_fetch_assoc($posts)){
            $postsList[] = $post;
        }
        echo json_encode($postsList);
    }
}
//Поездки пользователя
function GetDrivesOnUser($connect, $key, $login){
    if(checkFullInfoForAccount($connect, $key, 'GetDrivesOnUser')){
        $l = mysqli_real_escape_string($connect, $login);
        $posts = mysqli_query($connect, "SELECT * FROM `drives` WHERE `NameDriver` = '$l'");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "3",
                "result" => "Поездок не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
}
//Все поездки в город
function GetDrivesOnCity($connect, $key, $city) {
    if(checkFullInfoForAccount($connect, $key, 'GetDrivesOnCity')){
        $l = mysqli_real_escape_string($connect, $city);
        $posts = mysqli_query($connect, "SELECT * FROM `drives` WHERE `City` = '$l'");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "3",
                "result" => "Поездок не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
}
//Все поездки пользователя
function GetAllDrivesOnUser($connect, $key, $login){
    if(checkFullInfoForAccount($connect, $key, 'GetAllDrivesOnUser')){
        $l = mysqli_real_escape_string($connect, $login);
        $posts = mysqli_query($connect, "SELECT * FROM `drives` WHERE `NameDriver` = '$l'");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "3",
                "result" => "Поездок не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
}
//Добавить поездку
function AddDrives($connect, $key, $data){
    $login = $data['login'];
    $city1 = $data['city1'];
    $city2 = $data['city2'];
    $time = $data['time'];
    $login = $data['login'];
    $city = $data['city'];
    $email = $data['email'];
    $phone = $data['phone'];
}

/**
 * Авторизация ргистрация
 * 
 * 
 */

function RegisterUser($connect, $key,$data) {
    if(checkFullInfoForAccount($connect, $key, 'RegisterUser')){
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;
        $name = $data['name'];
        $family = $data['family'];
        $pass = $data['password'];
        $twopass = $data['twopass'];
        $login = $data['login'];
        $city = $data['city'];
        $email = $data['email'];
        $phone = $data['phone'];
        $regip = $ip;
        $lastip = $ip;
    
        if(empty($name)){
            $res = [
                "status" => false,
                "code" => "001",
                "result" => "Не введено имя"
            ];
            echo json_encode($res);
        } 
        elseif(empty($family)){
            $res = [
                "status" => false,
                "code" => "002",
                "result" => "Не введена фамилия"
            ];
            echo json_encode($res);
        }
        elseif(empty($login)){
            $res = [
                "status" => false,
                "code" => "003",
                "result" => "Не введене логин"
            ];
            echo json_encode($res);
        }
        elseif(empty($email)){
            $res = [
                "status" => false,
                "code" => "004",
                "result" => "Не введена почта"
            ];
            echo json_encode($res);
        }
        elseif(empty($phone)){
            $res = [
                "status" => false,
                "code" => "005",
                "result" => "Не введен телефон"
            ];
            echo json_encode($res);
        }
        elseif(empty($city)){
            $res = [
                "status" => false,
                "code" => "006",
                "result" => "Не введен город"
            ];
            echo json_encode($res);
        }
        elseif(empty($pass)){
            $res = [
                "status" => false,
                "code" => "007",
                "result" => "Не введен пароль"
            ];
            echo json_encode($res);
        } elseif(empty($twopass)) {
            $res = [
                "status" => false,
                "code" => "008",
                "result" => "Не введено подтверждение пароля"
            ];
            echo json_encode($res);
        } elseif($pass != $twopass){
            $res = [
                "status" => false,
                "code" => "009",
                "result" => "Пароли не совпадают"
            ];
            echo json_encode($res);
        } else {
            $temp1 = mysqli_query($connect, "SELECT * FROM `account` WHERE `Login` = '$login'");
            $temp2 = mysqli_query($connect, "SELECT * FROM `account` WHERE `Email` = '$email'");
            $temp3 = mysqli_query($connect, "SELECT * FROM `account` WHERE `Phone` = '$phone'");
            if(mysqli_num_rows($temp1) === 0){
                if(mysqli_num_rows($temp2) === 0){
                    if(mysqli_num_rows($temp3) === 0){
                        $password = md5(md5(trim($pass)));
                        $api_key = md5($login.$solt);
                        $res = [
                            "status" => false,
                            "code" => "0013",
                            "result" => "Пользователь зарегестрирован"
                        ];
                        echo json_encode($res);
                        $n = mysqli_real_escape_string($connect, $name);
                        $f = mysqli_real_escape_string($connect, $family);
                        $l = mysqli_real_escape_string($connect, $login);
                        $p = mysqli_real_escape_string($connect, $password);
                        $ph = mysqli_real_escape_string($connect, $phone);
                        $em = mysqli_real_escape_string($connect, $email);
                        $c = mysqli_real_escape_string($connect, $city);
                        $ap = mysqli_real_escape_string($connect, $api_key);
                        $rip = mysqli_real_escape_string($connect, $regip);
                        $lip = mysqli_real_escape_string($connect, $lastip);
                        mysqli_query($connect, "INSERT INTO `account` (`id`, `Name`, `Family`, `Login`, `Password`, `Phone`, `Email`, `Type`, `City`, `Online`, `CountDrive`, `LevelApi`, `ApiKey`, `RegIP`, `LastIP`, `LastOnline`, `Warn`, `Ban`) 
                        VALUES (NULL, '$n', '$f', '$l', '$p', '$ph', '$em', 1, '$c', 0, 0, 5, '$ap', '$rip', '$lip', '0', 0, 0)");
                    }
                    else {
                        $res = [
                            "status" => false,
                            "code" => "0010",
                            "result" => "Пользователь с таким номером уже сущетсвует"
                        ];
                        echo json_encode($res);
                    }
                }
                else {
                    $res = [
                        "status" => false,
                        "code" => "0011",
                        "result" => "Почта занята"
                    ];
                    echo json_encode($res);
                }
            }
            else {
                $res = [
                    "status" => false,
                    "code" => "0012",
                    "result" => "Логин занят"
                ];
                echo json_encode($res);
            }
        }
    }
}
function LoginUser($connect, $data){
    if(checkFullInfoForAccount($connect, $key, 'LoginUser')){
        $login = $data['login'];
        $password = $data['password'];
        if(empty($login)){
            $res = [
                "status" => false,
                "code" => "003",
                "result" => "Не ввели логин"
            ];
            echo json_encode($res);
        } elseif (empty($password)){
            $res = [
                "status" => false,
                "code" => "007",
                "result" => "Не ввели пароль"
            ];
            echo json_encode($res);
        } else {
            $post = mysqli_query($connect, "SELECT * FROM `account` WHERE `Login` = '$login'");
            if(mysqli_num_rows($post) != 0){
                $us = mysqli_fetch_assoc($post);
                if(md5(md5($password)) === $us['Password']){
                    $res = [
                        "status" => true,
                        "code" => "0016",
                        "result" => "Успешная авторизация",
                        "apiKey" => $us['ApiKey'],
                        "Level" => $us['LevelApi']
                    ];
                    echo json_encode($res);
                } else {
                    $res = [
                        "status" => false,
                        "code" => "0014",
                        "result" => "Неверный парль"
                    ];
                    echo json_encode($res);
                }
            }
            else {
                $res = [
                    "status" => false,
                    "code" => "0015",
                    "result" => "Пользователь не найден"
                ];
                echo json_encode($res);
            }
    
        }
    }
}

/**
 * Работа с логами
 * 
 */
function GetAllLogs($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetAllLogs')){
        $posts = mysqli_query($connect, "SELECT * FROM `logs`");
        $postsList = [];
        while($post = mysqli_fetch_assoc($posts)){
            $postsList[] = $post;
        }
        echo json_encode($postsList);
    }
}
function GetLogsByAction($connect, $key, $act){
    if(checkFullInfoForAccount($connect, $key, 'GetLogsByAction')){
        $ac = mysqli_real_escape_string($connect, $act);
        $posts = mysqli_query($connect, "SELECT * FROM `logs` WHERE `Action` = '$ac'");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "3",
                "result" => "Не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
}
function GetLogsByUser($connect, $key, $login){
    if(checkFullInfoForAccount($connect, $key, 'GetLogsByUser')){
        $l = mysqli_real_escape_string($connect, $login);
        $posts = mysqli_query($connect, "SELECT * FROM `logs` WHERE `LoginUser` = '$l' LIMIT 100");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "3",
                "result" => "Не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
}

/**
 * 
 * РАБОТА С ТЕХ ПОДДЕРЖКОЙ
 * 
 */

 function GetActiveReport($connect, $key) {
    if(checkFullInfoForAccount($connect, $key, 'GetActiveReport')){
        $l = mysqli_real_escape_string($connect, $login);
        $posts = mysqli_query($connect, "SELECT * FROM `reports` WHERE `Status` < 3 ORDER BY `Status` ASC");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "0001",
                "result" => "Не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
 }
 function GetInfoOnReport($connect, $key, $repid) {
    if(checkFullInfoForAccount($connect, $key, 'GetInfoOnReport')){
        $l = mysqli_real_escape_string($connect, $login);
        $post = mysqli_query($connect, "SELECT * FROM `reports` WHERE `id` = '$repid'");
        $user = mysqli_fetch_assoc($post);
        if(mysqli_num_rows($post) === 0) {
            $res = [
                "status" => false,
                "code" => "0002",
                "result" => "Репорт не найден"
            ];
            echo json_encode($res);
        }
        else {
            echo json_encode($user);
        }
    }
}
function CheckReport($connect, $key, $repid) {
    if(checkFullInfoForAccount($connect, $key, 'CheckReport')){
        $l = mysqli_real_escape_string($connect, $repid);
        $post = mysqli_query($connect, "UPDATE `reports` SET `Status` = 1 WHERE `id` = '$l'");
        if($post == false) {
            $res = [
                "status" => false,
                "code" => "0002",
                "result" => "Репорт не найден"
            ];
            echo json_encode($res);
        }
    }
}
function CloseReport($connect, $key, $repid) {
    if(checkFullInfoForAccount($connect, $key, 'CloseReport')){
        $l = mysqli_real_escape_string($connect, $repid);
        $post = mysqli_query($connect, "UPDATE `reports` SET `Status` = 3 WHERE `id` = '$l'");
        if($post == false) {
            $res = [
                "status" => false,
                "code" => "0002",
                "result" => "Репорт не закрыт"
            ];
            echo json_encode($res);
        }
    }
}
function AddAnswer($connect, $key, $data){
    if(checkFullInfoForAccount($connect, $key, 'AddAnswer')){
        $answer = $data['answ'];
        $id = $data['repid'];
        $keys = mysqli_real_escape_string($connect, $key);
        $acc = mysqli_query($connect, "SELECT * FROM `account` WHERE `ApiKey` = '$keys'");
        $Empl = mysqli_fetch_assoc($acc);
        if(strlen($answer) <= 400) {
            if(!empty($answer)){
                $data = date('Y-m-d');
                $lEmpl = $Empl['Login'];
                $l = mysqli_real_escape_string($connect, $login);
                $post = mysqli_query($connect, "UPDATE `reports` SET `ReportEmpl` = '$lEmpl' , `Answer` = '$answer' , `CloseDate` = '$data' WHERE `id` = '$id'");
                if($post == false) {
                    $res = [
                        "status" => false,
                        "code" => "0004",
                        "result" => "Ответ не добавлен"
                    ];
                    echo json_encode($res);
                }
            }
            else {
                $res = [
                    "status" => false,
                    "code" => "0005",
                    "result" => "Пустой ответ"
                ];
                echo json_encode($res);
            }

        }
        else {
            $res = [
                "status" => false,
                "code" => "0003",
                "result" => "Превышена длина значения"
            ];
            echo json_encode($res);
        }
    }
}



/**
 * 
 * РАБОТА С API ФУНКЦИЯМИ
 * 
 * 
 */
function GetAllApiFunction($connect, $key){
    if(checkFullInfoForAccount($connect, $key, 'GetAllApiFunction')){
        $l = mysqli_real_escape_string($connect, $login);
        $posts = mysqli_query($connect, "SELECT * FROM `api_function`");
        if(mysqli_num_rows($posts) === 0) {
            $res = [
                "status" => false,
                "code" => "0001",
                "result" => "Не найдено"
            ];
            echo json_encode($res);
        }
        else {
            $postsList = [];
            while($post = mysqli_fetch_assoc($posts)){
                $postsList[] = $post;
            }
            echo json_encode($postsList);
        }
    }
}
function OnOffApiFunction($connect, $key, $id){
    if(checkFullInfoForAccount($connect, $key, 'OnOffApiFunction')){
        $l = mysqli_real_escape_string($connect, $id);
        $post = mysqli_query($connect, "SELECT * FROM `api_function` WHERE `id` = '$l'");
        $func = mysqli_fetch_assoc($post);
        if($func['Status'] == 0){
            mysqli_query($connect, "UPDATE `api_function` SET `Status` = 1 WHERE `id` = '$l'");
            $res = [
                "status" => false,
                "code" => "00001",
                "result" => "Функция включена"
            ];
            echo json_encode($res);
        }
        if($func['Status'] == 1){
            mysqli_query($connect, "UPDATE `api_function` SET `Status` = 0 WHERE `id` = '$l'");
            $res = [
                "status" => false,
                "code" => "00002",
                "result" => "Функция выключена"
            ];
            echo json_encode($res);
        }
    }
}
function UpdateLevelApiFunction($connect, $key, $data) {
    if(checkFullInfoForAccount($connect, $key, 'UpdateLevelApiFunction')){
        $level = $data['level'];
        $id = $data['id'];
        $cl = mysqli_real_escape_string($connect, $level);
        $cid = mysqli_real_escape_string($connect, $id);
        if($cl <= 5){
            if(is_numeric($cl)){
                mysqli_query($connect, "UPDATE `api_function` SET `NeedLevel` = '$cl' WHERE `id` = '$cid'");
                $res = [
                    "status" => false,
                    "code" => "00003",
                    "result" => "Уровень обновлён"
                ];
                echo json_encode($res);
            }
            else {
                $res = [
                    "status" => false,
                    "code" => "00004",
                    "result" => "Недоступное значение"
                ];
                echo json_encode($res);
            }
        }
        else {
            $res = [
                "status" => false,
                "code" => "00004",
                "result" => "Недоступное значение"
            ];
            echo json_encode($res);
        }
    }
}
function GetInfoByFunctionId($connect, $key, $id) {
    if(checkFullInfoForAccount($connect, $key, 'GetInfoByFunctionId')){
        $l = mysqli_real_escape_string($connect, $id);
        $post = mysqli_query($connect, "SELECT * FROM `api_function` WHERE `id` = '$l'");
        $user = mysqli_fetch_assoc($post);
        if(mysqli_num_rows($post) === 0) {
            $res = [
                "status" => false,
                "code" => "0005",
                "result" => "Функция не найдена"
            ];
            echo json_encode($res);
        }
        else {
            echo json_encode($user);
        }
    }
}

/**
 *  Выдача наказаний, блокировки
 * 
 */

 function AddBan(){

 }

 function AddWarn(){

 }