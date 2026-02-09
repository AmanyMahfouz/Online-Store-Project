<?php
session_start();
include('../include/connected.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Start fontawsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--End fontawsome-->
    <link rel="stylesheet" href="style.css">
    <title>لوحة التحكم</title>
</head>
<body>
    <?php
    if(!isset($_SESSION ['EMAIL'])){
        header('location:../index.php');
    }
    else{
    ?>
    <?php
    @$Sectionname =$_POST['Sectionname'];
    @$secadd =$_POST['secadd'];
    @$id =$_GET['id'];

    if(isset($secadd)){
        if(empty($Sectionname)){
            echo '<script> alert ("الحقل فارغ الرجاء ملئ الحقل") </script>';
        }
        elseif($Sectionname <50){
             echo '<script> alert (" اسم القسم طويل جدا") </script>';
        }
        else{
            $query="INSERT INTO section (Sectionname) VALUES('$Sectionname')";
            $result= mysqli_query($conn, $query);
            echo '<script> alert ("تم إضافة القسم بنجاح") </script>';
        }
    }
    ?>

    <?php
    #delete section
    if(isset($id)){
        $query="DELETE FROM section WHERE id='$id'";
        $delet =mysqli_query($conn,$query);
        if(isset($delet)){
            echo '<script> alert("تم الحذف بنجاح"); </script>';
        }else{
            echo '<script> alert("لم يتم الحذف من القسم"); </script>';
        }
    }

    ?>

    <!--sidebar start-->
<div class="sidebar_container">
    <div class="sidebar">
        <h1>لوحة تحكم الادارة</h1>
        <ul>
            <!-- target _blank علشان تظهر في صفحة منفصلة-->
            <li><a href="../index.php" target="_blank">الصفحة الرئيسية <i class="fa-solid fa-house"></i></a></li> 
            <li><a href="product.php" target="_blank">صفحة المنتجات <i class="fa-solid fa-shirt"></i></a></li>
            <li><a href="addproduct.php" target="_blank">اضافة منتج <i class="fa-solid fa-folder-plus"></i></a></li>
            <li><a href="../customers.php" target="_blank">معلومات الاعضاء <i class="fa-solid fa-users"></i></a></li>
            <li><a href="../all_orders.php" target="_blank"> قائمة العملاء <i class="fa-solid fa-folder-open"></i></a></li>
            <li><a href="logout.php" target="_blank">تسجيل الخروج <i class="fa-solid fa-right-from-bracket"></i></a></li>
        </ul>
    </div>

    <!--sidebar end-->

        <!--section start-->
<div class="content_sec">
    <form action="adminpanel.php" method="post">
        <label for="section" > اضافة قسم جديد</label>
        <input type="text" name="Sectionname" id="section">
        <br>
        <button class="add" type="submit" name="secadd">اضافة قسم </button> 
    </form>
    <br>
        <!--table start-->
        <table dir="rtl">
            <tr>
                <th>الرقم التسلسلي</th>
                <th>اسم القسم</th>
                <th>حذف القسم</th>
            </tr>
            <tr>
                <?php
                $query="SELECT * FROM section";
                $result=mysqli_query($conn,$query);
                while($row=mysqli_fetch_assoc($result)){
                    ?>
                
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['Sectionname'];?></td>
                <td><a href="adminpanel.php?id=<?php echo $row['id'];?> "><button type="submit" class="delet">حذف القسم</button></td>
            </tr>
            <?php
            }

?>
        </table>
        <!--table end-->

</div>
        <!--section end-->

</div>

    <?php
    //close else
       }
       ?> 
</body>
</html>