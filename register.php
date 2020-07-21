<style type="text/css">
    form {
        width: 300px;
        background-color: #49eebe;
        margin-left: 300px;
        margin-top: 30px;
        padding: 30px;
    }

    button {
        margin-top: 20px;
    }
</style>

<form method="post">
    <label>username:<input type="text" name="name"></label>
    <br /><br />
    <label>password:<input type="password" name="pw"></label>
    <br /><br />
    <label>confirm:<input type="password" name="repw"></label>
    <br /><br />
    <label>email:<input type="email" name="email"></label>
    <br />
    <button type="submit" name="submit">register</button>
</form>

<?php

include_once('conn.php');
//通过返回的值来判断是否链接成功数据库
//使用isset（判断变量已经配置）函数来判断submit是否完成提交
if (isset($_POST['submit'])) {
    //如果完成提交，开始判断提交的密码和确认的密码是否一致
    if ($_POST['pw'] == $_POST['repw']) {
        //如果一致，说明这个用户可以注册
        $username = $_POST['name'];
        $password = $_POST['pw'];
        $email = $_POST['email'];
        // 检查邮箱是否合法
        $regex = "/([a-z0-9]*[-_.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[.][a-z]{2,3}([.][a-z]{2})?/i";
        if (preg_match($regex, $email)) {
            // 检查用户名及邮箱是否注册过
            $stmt = $conn->prepare('select email from user where email=?');
            if (!$stmt)
                throw new Exception("prepare query error:" . $conn->error);
            $stmt->bind_param('s', $email);
            // echo var_dump($stmt);
            $stmt->execute();
            $stmt->bind_result($res);
            // $stmt->fetch();
            while ($stmt->fetch()) {
                // echo $username.$res.'<br>'; 
            }
            // echo $stmt->num_rows();
            if ($stmt->num_rows() > 0) {
                echo '<script>alert("邮箱已被注册！")</script>';
            } else {
                //向user表中添加值
                $stmt2 = $conn->prepare("insert into user (name,pass,email) values (?, ?, ?)");
                if ($stmt2) {
                    // echo 'email'.$email;
                    $stmt2->bind_param('sss', $username, $password, $email);
                    // echo var_dump($stmt2);
                    // 如果插入成功，则返回true 
                    if ($stmt2->execute()) {
                        echo '<script>alert("注册成功！");location.href="login.php"</script>';
                        //跳转到登陆页面
                        // header("Location:login.php");
                    } else {
                        echo "注册失败";
                    }
                }
                $stmt2->close();
            }
            $stmt->close();
        } else {
            echo '<script>alert("邮箱格式有误！")</script>';
        }
    } else {
        //js弹窗提醒
        echo "<script>alert('两次输入密码不一致！')</script>";
    }
}


?>