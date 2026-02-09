<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo '
    <script>
        alert("يرجى تسجيل الدخول أولا لإضافة المنتج إلى السلة");
        window.location.href="user/login.php";
    </script>
    ';
    exit;
}
$user_id = $_SESSION['user_id'];
if($user_id <= 0){
    echo '
    <script>
        alert("مستخدم غير صحيح");
        window.location.href="user/login.php";
    </script>
    ';
    exit;
}

include('file/header.php');
?>

<?php
// إضافة منتج جديد إلى السلة
if(isset($_POST['add'])){
    $product_id = $_POST['product_id'];
    $productname = $_POST['h_name'];
    $productprice = $_POST['h_price'];
    $productimg = $_POST['h_img'];
    $producquantity = $_POST['quantity'];

    // التحقق إذا كان المنتج موجود بالفعل في السلة
    $check_cart = "SELECT * FROM cart WHERE product_id='$product_id' AND user_id='$user_id'";
    $result = mysqli_query($conn, $check_cart);

    if(mysqli_num_rows($result) > 0){
        echo '<script>alert("المنتج مضاف بالفعل مسبقا لم تتم الاضافه");</script>';
    } else {
        $insert_cart = "INSERT INTO cart(product_id, name, price, img, quantity, user_id) 
                        VALUES('$product_id', '$productname', '$productprice', '$productimg', '$producquantity', '$user_id')";
        if(mysqli_query($conn, $insert_cart)){
            echo '<script>
                    alert("تمت اضافة المنتج الى السلة بنجاح");
                    window.location.href = "cart.php";
                  </script>';
        } else {
            echo '<script>alert("لم تتم اضافة المنتج الى السلة حدث خطأ ما");</script>';
        }
    }
}

// حذف منتج من السلة
if(isset($_POST['delete_cart'])){
    $cart_id = $_POST['id'];
    if($cart_id > 0){
        $query = "DELETE FROM cart WHERE id='$cart_id' AND user_id='$user_id'";
        if(mysqli_query($conn, $query)){
            echo '<script>
                    alert("تم الحذف بنجاح");
                    window.location.href = "cart.php";
                  </script>';
        } else {
            echo '<script>alert("لم يتم الحذف");</script>';
        }
    }
}

// تحديث الكمية
if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['product_id'];           // id سطر السلة
    $new_quantity = (int)$_POST['quantity'];
    $current_user_id = $_POST['user_id'];

    // لا تسمح بكمية أقل من 1
    if($new_quantity < 1){
        $new_quantity = 1;
    }

    $update_query = "UPDATE cart SET quantity = '$new_quantity' 
                     WHERE id = '$cart_id' AND user_id = '$current_user_id'";

    if(mysqli_query($conn, $update_query)){
        echo '<script>
                alert("تم تحديث الكمية بنجاح");
                window.location.href = "cart.php";
              </script>';
    } else {
        echo '<script>alert("لم يتم تحديث الكمية، حدث خطأ");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة الشراء</title>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    h3{
        font-family: arial ,sans-serif;
    }
    body{
        font-family: arial ,sans-serif;
        background-color: #fff;
        color: #333;
    }
    .cart_container{
        direction: rtl;
        width:80%;
        margin:50px auto;
        background-color: #fff;
        padding: 20px;
        box-shadow: rgba(0,0,0,0.2);
    }
    .cont_head{
        padding: 5px;
        width: 100%;
        height: 100px;
        background-color: #A59D84 ;
    }
    .cont_head img{
        width: 70px;
        height: 70px;
        float: left;
        margin: 5px;
        border-radius: 20px;
    }
    .cont_head h1{
        float: left;
        margin: 20px;
        color: #261609d4;
        font-size: 30px;
        font-weight: bold;
    }
    .cart_table{
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    .cart_table th, td{
        padding: 15px;
        text-align: center;
        border: 1px solid #351d08ff;
    }
    .cart_table th{
        background-color: #ef8120 ;
    }
    .cart_table img{
        width: 70px;
        height: 70px;
    }
    .cart_table td input{
        width: 50px;
        padding:5px;
        text-align: center;
    }
    .remove{
        background-color: #ef8120 ;
        color: white;
        border: none;
        padding: 10px 10px;
        cursor: pointer;
    }
    .remove:hover{
        background-color: #A18D6D ;
    }
    .cart_total h6{
        color:black;
        font-size: large;
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
    }
    .cart_total button{
        padding: 10px 40px;
        transition: transform 0.3s ease;
    }
    .cart_total button a{
        text-decoration: none;
        color: #fff;
    }
    .cart_total button:hover{
        transform: scale(1.2);
    }


</style>
</head>
<body>
    <div class="cart_container">
        <div class="cont_head">
            <h1>🛒 Cart </h1>
        </div>

        <!-- جدول السلة -->
        <table class="cart_table">
            <tr>
                <th>صورة المنتج</th>
                <th>رقم المنتج</th>
                <th>اسم المنتج</th>
                <th>الكمية</th>
                <th>السعر</th>
                <th>الإجمالي</th>
                <th>حذف</th>
                <th>تعديل الكمية</th>
            </tr>

            <?php
            $query = "SELECT * FROM cart WHERE user_id='$user_id'";
            $result = mysqli_query($conn, $query);
            $total = 0;

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    $subtotal = $row['quantity'] * $row['price'];
                    $total += $subtotal;
            ?>
            <tr>
                <td><img src="uploads/img/<?php echo htmlspecialchars($row['img']); ?>" alt="product"></td>
                <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><?php echo number_format($row['price'], 2); ?></td>
                <td><?php echo number_format($subtotal, 2); ?></td>

                <!-- حذف -->
                <td>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button class="remove" type="submit" name="delete_cart">حذف</button>
                    </form>
                </td>

                <!-- تعديل الكمية -->
                <td>
                    <form action="cart.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" min="1" required>
                        <button class="remove" type="submit" name="update_quantity">تعديل</button>
                    </form>
                </td>
            </tr>
            <?php
                }
            } else {
                echo '<tr><td colspan="8">السلة فارغة حاليًا</td></tr>';
            }
            ?>
        </table>

        <div class="cart_total">
            <h6>المجموع: <?php echo number_format($total, 2); ?> </h6>
            <button class="remove"><a href="checkout.php">اتمام الطلب</a></button>
        </div>
    </div>
</body>
</html>