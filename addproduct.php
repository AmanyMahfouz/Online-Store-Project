<?php
include('../include/connected.php');
?>
<?php
@$proname =$_POST['proname'];
@$proprice = $_POST['proprice'];
@$prosection = $_POST['prosection'];
@$prodescrip = $_POST['prodescrip'];
@$prosize = $_POST['prosize'];
@$prounv = $_POST['prounv'];
@$proadd = $_POST['proadd'];

//img start
@$imageName =$_FILES['proimg']['name'];
@$imageTmp =$_FILES['proimg']['tmp_name'];
//img end
if (isset($proadd)) {
    if (empty($proname) || empty($proprice) || empty($prosection) || empty($prodescrip) || empty($prosize)) {
        echo '<script>alert("الرجاء ملئ جميع الحقول");</script>';
    }
    else {
        $proimg = rand(0, 5000) . "_" . $imageName;
        move_uploaded_file($imageTmp, "../uploads/img/" . $proimg);

        $query = "INSERT INTO product(proname, proimg, proprice, prosection, prodescrip, prosize, prounv)
        VALUES('$proname', '$proimg', '$proprice', '$prosection', '$prodescrip', '$prosize', '$prounv')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo '<script>alert("تم إضافة المنتج بنجاح");</script>';
        } else {
            echo '<script>alert("لم يتم إضافة المنتج");</script>';
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة منتجات</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <center>
        <main>
            <div class="form_product">
                <h1>إضافة منتج</h1>
                <form action="addproduct.php" method="post" enctype="multipart/form-data">

                    <label for="name">عنوان المنتج</label>
                    <input type="text" name="proname" id="name">

                    <label for="file">صورة المنتج</label>
                    <input type="file" name="proimg" id="file">

                    <label for="price">سعر المنتج</label>
                    <input type="text" name="proprice" id="price">

                    <label for="description">تفاصيل المنتج</label>
                    <input type="text" name="prodescrip" id="description">

                    <label for="size">الاحجام المتوفرة</label>
                    <input type="text" name="prosize" id="size">

                    
<!--start section-->
                    <div>
                    <label for="form_control">الاقسام</label>
                    <select name="prosection" id="form_control">

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
<input class="button" type="submit" name="proadd"></input>

                </form>
            </div>
        </main>
    </center>
</body>
</html>