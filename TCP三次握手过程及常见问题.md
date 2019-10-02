### TCP三次握手






![三次握手](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp%E4%B8%89%E6%AC%A1%E6%8F%A1%E6%89%8B.png)


   + 首先客户端发送SYN包到服务端。
   + 服务端收到后将fd放入SYS_QUEUE中并向客户端发送SYN+ACK。
   + 客户端回复ACK

##### 建立连接为什么需要三次握手呢
    考虑一下以下场景
        客户端发送一个SYN包,中间由于网络原因过了很久都没到达服务端
        这时客户端迟迟没有收到确认报文，又重新发送SYN,经过两次握手成功
        建立连接，此时网络通畅了，原来滞留的报文又重新传送到服务端,因为
        是两次握手机制，所以服务器不知道这是一个失效连接，这就导致不必要
        的资源浪费。
        如果是三次握手就不会出现这样的问题，当失效报文传到服务端时，服务
        回复确认报文，但是客户端不会发确认，因此服务端会认为这是一个失效
        的连接。从而避免了资源的浪费。
        
##### 三次握手经常会出现的问题
   + 连接拒绝

    本文以swoole的方式展示
    
 ```php
    <?php
    $clinet = new Swoole\Client(SWOOLE_SOCK_TCP,SWOOLE_SOCK_SYNC);
    $clinet->connect('127.0.0.1','6666'); 
    //当我们试着连接一个服务端没有监听的端口时可以看到以下报错
 ```    
![连接被拒绝](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp-02.png)
   + Operation now in progress
   
    代码在code/xxxxx
    丢包、错误ip、backlig满了&阻塞&tcp_abort_on_overflow=0
    
      + 错误ip
![连接被拒绝](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp-03.png)  
    
      + backlig满了&阻塞&tcp_abort_on_overflow=0
![连接被拒绝](https://github.com/yigebanchengxuyuan/network-knowledge/blob/master/image/tcp-04.png)
      
   + min(maxconn,backlog)  ss -lt
     
        
        
          

