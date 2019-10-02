<?php
$clinet = new Swoole\Client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);

$clinet->connect('127.0.0.1','9999');

$clinet->send('hello server');

$clinet->close();

sleep(1000);
