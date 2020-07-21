<style type="text/css">
    form {
        width: 300px;
        background-color: #EEE0E5;
        margin-left: 300px;
        margin-top: 30px;
        padding: 30px;
    }
</style>

<form method="post">
    <label>email&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<input type="email" name="email"></label>
    <br /><br />
    <label>password:<input type="password" name="pw"></label>
    <br /><br />
    <button type="submit" name="submit">login</button>
    <a href="register.php" name="register">register</a>
</form>
<?php
include_once('conn.php');
//如果点击登陆按钮
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['pw'];
    $stmt = $conn->prepare('select email from user where email=? and pass=?');
    if (!$stmt)
        throw new Exception("prepare query error:" . $conn->error);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($email);
    // $stmt->fetch();
    while ($stmt->fetch()) {
        // echo $email . '<br>';
    }
    // echo $stmt->num_rows();
    if ($stmt->num_rows() > 0) {
        session_start();
        $_SESSION["admin"] = true;
        $_SESSION["email"] = $email;
        echo '<script>alert("登陆成功！")</script>';
        header("Location:index.php");
    } else {
        session_unset();
        echo '<script>alert("登陆失败！")</script>';
    }
}

?>