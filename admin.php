<?php
session_start();
include('../include/connected.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
</head>

<style>
    body{
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }
    .container{
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: #fff;
        box-shadow:0 0 10px rgba(0,0,0,0.1);
    }
    h1{
        text-align: center;
        margin-bottom: 20px;
    }
    form{
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    label{
        display: block;
        margin-bottom: 5px;
    }
    input[type="text"],[type="email"]{
        width: 100%;
        padding: 10px;
        border:1px solid #ccc;
        margin-bottom: 15px;
    }
    button{
        width: 100%;
        padding: 10px 20px;
        background-color: #ef8120;
        color: #fff;
        border:none;
        cursor: pointer;
    }
</style>

<body>
    <main>
        <?php // creat variables
        @$ADemail =$_POST['email'];
        @$ADpassword =$_POST['password'];
        @$ADadd =$_POST['add'];

        if(isset($ADadd)){
            if(empty($ADemail) || empty($ADpassword)){
                echo'<script>alert ("الرجاء ادخال البريد الاليكتروني ورقم السر")</script>';
            }
            else{
                $query ="SELECT *FROM admin WHERE EMAIL='$ADemail' AND password='$ADpassword' ";
                $result=mysqli_query($conn,$query);
                if(mysqli_num_rows($result) ==1)
                    {
                    $_SESSION ['EMAIL']=$ADemail;
                    echo'<script>alert ("مرحبا بك ايها المدير سيتم تحويلك الى لوحة التحكم")</script>';
                    header("REFRESH:2; URL = adminpanel.php");
                    }
                else
                    {
                       echo'<script>alert ("مرحبا بك ليس مسموح لك دخول هذه الصفحة سوف يتم تحويلك الى المتجر مباشرة")</script>';
                     header("REFRESH:2; URL = ../index.php");
                    }
            }
        } 
        ?>
        <div class="container">
            <h1>تسجيل الدخول</h1>
            <form action="admin.php" method="post">
                <label for="em">البريد الإلكتروني</label>
                <input type="email" name="email" id="em">

                <label for="pass">الرقم السري</label>
                <input type="text" name="password" id="pass">
                <br>
                <button type="submit" name="add">تسجيل الدخول

                </button>
            </form>
        </div>
    </main>
</body>
</html>