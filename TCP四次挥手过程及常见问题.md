### TCP四次挥手

![四次挥手](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp%E5%9B%9B%E6%AC%A1%E6%8C%A5%E6%89%8B.png)

#### 挥手过程 
    
   + 客户端发送FIN包（客户端状态变为FIN_WAIT1）
   + 服务端收到关闭请求后发送ACK（服务端状态变为CLOSE_WAIT）客户端收到
     服务端发来的确认包（客户端状态变为FIN_WAIT2）
   + 服务端发送FIN包给客户端（服务端状态变为LAST_ACK）
   + 客户端收到FIN包后回复ACK(客户端状态变为TIME_WAIT)服务端收到ACK包
     后连接关闭 需要注意此时客户端TIME_WAIT状态会持续一分钟之久
     
#### 三次挥手不行吗
    
    因为tcp是全双工的连接，需要2+2次通信才能确认关闭。客户端发送FIN服务端回复ACK这时只能
    说是处于半关闭状态，只能说明客户端不在像服务端传送数据了，但是服务端还有可能给客户端传
    送数据，所以需要服务端再次发送FIN包告诉客户端，我也不给你发送数据了，关闭链接吧，客户端
    此时在回复ACK,这样一个TCP连接才可以说是关闭了。
    
#### 挥手过程中经常出现的问题

   1. time wait 引起的问题

   + Cannot assign requested address

![tcp-05](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp-05.png)

    代码在code/redis_time_wait.php
    这种错误是因为本地频繁的建立redis连接，然后关闭。因为tcp客户端存在一个TIME_WAIT
    一分钟（linux系统）在这一分钟期间，连接资源是不会释放的比如端口。
    
   
   + Address already in use
    
    这个也是由于time_wait引起的，端口处于time_wait状态没有被释放
    通畅的解决办法
    
    net.ipv4.tcp_timestaps=1
    net.ipv4.tcp_tw_reuse=1
    net.ipv4.ip_local_port_range调大
    不要开启net.ipv4.tcp_tw_recycle=1
    
   2. close_wait 引起的问题

![tcp-06](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp-06.png)

    有时候看服务器会出现大量的close_wait状态
    代码示例code/close_wait_server.php和close_wait_client.php
    这个会导致连接泄露，另外多说一句，SWOOLE_BASE 模式是不会有这个问题
    的，具体原因请看后续文章swoole进程模型。
   
    