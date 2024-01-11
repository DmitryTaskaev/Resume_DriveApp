<?php

//Соединяемся с сервером
$conn = mysqli_connect ("localhost", "root", "root", "cardb");
//Формируем запрос на создание таблицы, по структуре аналогичной справочнику пород
/*
$query="
CREATE TABLE api_function (
id INT(122) NOT NULL auto_increment primary key, 
ApiKey VARCHAR(100) NOT NULL,
NeedLevel INT(1) NOT NULL,
Status INT(1) NOT NULL)";
*/

$query="
CREATE TABLE Reports (
id INT(122) NOT NULL auto_increment primary key, 
Login VARCHAR(100) NOT NULL,
Title VARCHAR(100) NOT NULL,
Message VARCHAR(100) NOT NULL,
ReportEmpl VARCHAR(100) NOT NULL,
Status INT(100) NOT NULL,
StartDate DATE NOT NULL,
CloseDate DATE)";
//Выполняем запрос
$result=mysqli_query ($conn, $query);
if ($result == true)
    print ("Таблица базы данных успешно создана"); //Печать сообщения
else
    print ("Запрос не выполнен");

//Закрываем соединение
mysqli_close($conn);
?>