<?php
session_start();
include_once('conn.php');
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
    echo "您已经成功登陆<br>";
    $email = $_SESSION["email"];
    $sql = "select name FROM user where email='".$email."'";
    // echo $sql;
    $result = $conn->query($sql);
    while($row = $result->fetch_assoc()){
        $username = $row['name'];
        // echo '当前用户：'.$username;
        // echo var_dump($row);
        $sql = "select name FROM user where name='".$username."'";
        // echo $sql;
        $result2 = $conn->query($sql);
        while($row = $result2->fetch_assoc()){
            // echo var_dump($row);
            $name = $row['name'];
            echo '当前用户：<span class="user-name">'.$name.'</span>';
            break 2;
        }
    }

} else {
    //  验证失败，将 $_SESSION["admin"] 置为 false
    $_SESSION["admin"] = false;
    echo '您无权访问';
    header("Location:login.php");
}
?>