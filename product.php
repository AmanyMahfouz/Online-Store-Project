<?php
include('../include/connected.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة المنتجات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body><br>

<?php
//start delete
@$id = $_GET['id'];
if(isset($id)){
    $query="DELETE FROM product WHERE id='$id'";
    $delete=mysqli_query($conn,$query);
    if(isset($delete)){
        echo "<script>alert('تم حذف المنتج بنجاح');</script>";
    }
    else{
        echo "<script>alert('فشل في حذف المنتج');</script>";
    }
}

//start delete
?>

    <div class="sidebar_container">
        <!--table start-->
        <table dir="rtl">
            <tr>
                <th>رقم المنتج</th>
                <th>صورة المنتج</th>
                <th>عنوان المنتج</th>
                <th>سعر المنتج</th>
                <th>الاحجام المتوفرة</th>
                <th>توفر المنتج</th>
                <th>الاقسام</th>
                <th>تفاصيل المنتج</th>
                <th>حذف المنتج</th>
                <th>تعديل المنتج</th>
            </tr>
            <?php
            $query="SELECT * FROM product";
            $result=mysqli_query($conn,$query);
            while($row=mysqli_fetch_assoc($result)){

            
            ?>

            <tr>
                <td><?php echo $row['id'];?></td>
                <!--img-->
                <td><img src="../uploads/img//<?php echo $row['proimg'];?>"></td>
                <!--img-->
                <td><?php echo $row['proname'];?></td>
                <td><?php echo $row['proprice'];?></td>
                <td><?php echo $row['prosize'];?></td>
                <td><?php echo $row['prounv'];?></td>
                <td><?php echo $row['prosection'];?></td>
                <td><?php echo $row['prodescrip'];?></td>

                

                <td><a href="product.php?id= <?php echo $row['id'];?>"><button type="submit" class="delet">حذف المنتج</button></td></a></td>
                <td><a href="update.php?id=<?php echo $row['id'];?>"><button type="submit" class="update">تعديل المنتج</button></td></a></td>
            </tr>

</div>
<?php
}
?>

    
</body>
</html>