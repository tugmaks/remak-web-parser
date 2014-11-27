<?php
require_once('RemakConnector.php');
header('Content-Type: text/html; charset=utf-8');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$connector = new RemakConnector([
    'login' => 'ADMIN',
    'password' => 'SBTAdmin!',
        ]);
$response = $connector->setPath('http://remak-web-parser.ru/scripts/HMI65100Read.cgi')->run();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>
            Описание параметров
        </title>
        <style>
            td{
                border: 1px solid lightblue;
                padding: 5px;
                font-size: 12px;
                font-family: monospace;
            }
        </style>
    </head>
    <body>
        <table>
            <tr>
                <td>Ответ сервера</td>
                <td>$response->show()</td>
                <td><?= $response->show() ?></td>
            </tr>
            <tr>
                <td>Общее количество сигналов</td>
                <td>$response->getSignalCount()</td>
                <td><?= $response->getSignalCount() ?></td>
            </tr>
            <tr>
                <td>Общее количество аварий</td>
                <td>$response->getAlarmCount()</td>
                <td><?= $response->getAlarmCount() ?></td>
            </tr>
            <tr>
                <td>Сигналы аварий</td>
                <td>$response->getAlarms()</td>
                <td><?= var_dump($response->getAlarms()) ?></td>
            </tr>
        </table>
    </body>
</html>