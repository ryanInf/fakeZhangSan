<?php
    $serveraddr = '192.168.100.104';
    $username = 'root';
    $password = 'root';
    $db = 'test';
    $conn = new mysqli($serveraddr, $username, $password, $db);
    // 检测连接
    if($conn->connect_error){
        die("连接失败: " . $conn->connect_error);
    } 
    // $sql = "insert into user (name,pass,email) values ('123', '123', '1234')";
    // $result = $conn->query($sql);
?>