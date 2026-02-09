<?php
include('../include/connected.php');
?>

<?php
// select start
@$id =$_GET['id'];
if(isset($_GET['id'])){
    $query="SELECT * FROM product WHERE id ='$id'";
    $result=mysqli_query($conn,$query);
    if($result){
        $row = mysqli_fetch_assoc($result);
        //print_r($row);
    }
}
if (isset($_POST['update_pro'])){
    if(isset($_GET['id_new'])){
@$proname =$_POST['proname'];
@$proprice = $_POST['proprice'];
@$prosection = $_POST['prosection'];
@$prodescrip = $_POST['prodescrip'];
@$prosize = $_POST['prosize'];
@$prounv = $_POST['prounv'];
@$proadd = $_POST['proadd'];
@$id_new = $_GET['id_new'];

//img start
@$imageName =$_FILES['proimg']['name'];
@$imageTmp =$_FILES['proimg']['tmp_name'];
//img end
if(empty($prodescrip)){
    echo '<script> alert("الرجاء اضافة تفاصيل المنتج");</script>';
}else{
     $proimg = rand(0, 5000) . "_" . $imageName;
        move_uploaded_file($imageTmp, "../uploads/img/" . $proimg);

        $query="UPDATE product SET
        proname ='$proname',
        proimg ='$proimg',
        proprice ='$proprice',
        prosection ='$prosection',
        prodescrip ='$prodescrip',
        prosize ='$prosize',
        prounv ='$prounv'
        WHERE id= '$id_new'";

        $result= mysqli_query($conn,$query);
        if(isset($result)){
            echo '<script> alert("تم تحديث المنتج بنجاح");</script>';
            header("LOCATION:../index.php");
        }
        else{
             echo '<script> alert("فشل في تحديث المنتج");</script>';
        }
}
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تعديل المنتجات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <main>
            <div class="form_product">
                <h1>إضافة منتج</h1>
                <form action="update.php?id_new=<?php echo $row['id'];?>" method="post" enctype="multipart/form-data">

                    <label for="name">عنوان المنتج</label>
                    <input type="text" name="proname" id="name"
                    value=" <?php echo $row['proname'];?>">

                    <label for="file">صورة المنتج</label>
                    <input type="file" name="proimg" id="file"
                    value=" <?php echo $row['proimg'];?>">

                    <label for="price">سعر المنتج</label>
                    <input type="text" name="proprice" id="price"
                    value=" <?php echo $row['proprice'];?>">

                    <label for="description">تفاصيل المنتج</label>
                    <input type="text" name="prodescrip" id="description"
                    value=" <?php echo $row['prodescrip'];?>">

                    <label for="size">الاحجام المتوفرة</label>
                    <input type="text" name="prosize" id="size"
                    value=" <?php echo $row['prosize'];?>">

                    <label for="unv">توفر المنتج</label>
                    <input type="text" name="prounv" id="unv"
                    value=" <?php echo $row['prounv'];?>">
<!--start section-->
                    <div>
                    <label for="form_control">الاقسام</label>
                    <select name="prosection" id="form_control"
                    value=" <?php echo $row['prosection'];?>">

                    <?php
                    $query = "SELECT * FROM section";
                    $result=mysqli_query($conn,$query);
                    while($row=mysqli_fetch_assoc($result)){
                        echo '<option name="section">' .$row['Sectionname'].'</option>';
                    }

                    ?>
                        
                    </div><br>
                    <br>
<!--end section-->
<input class="button" type="submit" name="update_pro" value="update"></input>

                </form>
            </div>
        </main>
    </center>
</body>
</html>