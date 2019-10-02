<?php
$redis = new Redis();

$i = 1;
while (true) {
        var_dump($redis->connect('127.0.0.1'),$i);
        $redis->close();
        $i++;
}
