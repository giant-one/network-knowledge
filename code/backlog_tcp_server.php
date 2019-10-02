<?php
/**
 * Created by PhpStorm.
 * User: xuce
 * Date: 2019-09-27
 * Time: 12:55
 */
$server = new Swoole\Server('127.0.0.1','9999',SWOOLE_BASE);
$server->set(array(
    'worker_num' => 1,
    'backlog'=>128
));

$server->on('connect', function ($server,$fd) {
    var_dump("Clinet:connect.\n");
    sleep(10000);
});

$server->on('receive', function ($server,$fd,$reactor_id,$data) {
    var_dump($data);
});

$server->on('close', function ($server,$fd) {
    var_dump("close.\n");
});

$server->start();
