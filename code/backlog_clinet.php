<?php
$i = 0;
while (true) {
        $arr[$i] = new swoole_client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);
        var_dump($arr[$i]->connect('127.0.0.1',9999));
        $i++;
}
