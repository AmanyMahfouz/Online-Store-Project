<?php
session_start();
include('include/connected.php');

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user_id'])) {
    echo '
    <script>
        alert("يرجى تسجيل الدخول أولاً!");
        window.location.href="user/login.php";
    </script>
    ';
    exit;
}

$user_id = $_SESSION['user_id'];

// جلب منتجات السلة
$query = "SELECT * FROM cart WHERE user_id='$user_id'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    echo '
    <script>
        alert("السلة فارغة!");
        window.location.href="cart.php";
    </script>
    ';
    exit;
}

// حساب الإجمالي
$total = 0;
$cart_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $cart_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إتمام الطلب</title>
    <style>
/* صفحة كاملة */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    padding: 50px 20px;
}

/* الصندوق الرئيسي */
.container {
    background-color: #fff;
    max-width: 900px;
    margin: auto;
    padding: 40px 30px;
    border-radius: 12px;
    box-shadow: 0 5px 25px rgba(0,0,0,0.1);
}

/* العناوين */
h2 {
    color: #351d08ff;
    text-align: center;
    margin-bottom: 25px;
}

h3 {
    color: #351d08ff;
    margin-top: 30px;
    margin-bottom: 15px;
}

/* جدول السلة */
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 25px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px 10px;
    text-align: center;
    font-size: 15px;
}

table th {
    background-color: #e67e22;
    color: #fff;
    font-weight: bold;
}

table tr:nth-child(even) {
    background-color: #f9f9f9;
}

table tr:hover {
    background-color: #f1f1f1;
}

/* form */
form label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    color: black;

}

form input[type="text"],
form input[type="email"],
form textarea {
    width: 100%;
    padding: 12px 10px;
    margin-bottom: 20px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 15px;
    box-sizing: border-box;
    transition: 0.3s;
}

form input[type="text"]:focus,
form input[type="email"]:focus,
form textarea:focus {
    border-color: #ef8120 ;
    outline: none;
}

/* زر التأكيد */
button {
    display: block;
    width: 100%;
    padding: 15px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #ef8120 ;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #208bef ;
}

/* الإجمالي */
h3#total {
    text-align: right;
    color: #ef8120 ;
    font-size: 18px;
    margin-top: 10px;
}
</style>

</head>
<body>
<div class="container">
    <h2>تفاصـــيل السلـــــة</h2>
    <table>
        <tr>
            <th>المنتج</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>الإجمالي</th>
        </tr>
        <?php foreach($cart_items as $item): ?>
        <tr>
            <td><?= $item['name'] ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= $item['price'] ?></td>
            <td><?= $item['price'] * $item['quantity'] ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <h3>الإجمالي الكلي<?= $total ?> جنيه</h3>

    <h2>معلومات العميل</h2>
    <form action="process_checkout.php" method="post">
        <label>الاسم بالكامل</label>
        <input type="text" name="full_name" required>

        <label>رقم الهاتف</label>
        <input type="text" name="phone" required>

        <label>البريد الإلكتروني</label>
        <input type="email" name="email" required>

        <label>العنوان</label>
        <textarea name="address" required></textarea>

        <label>ملاحظات (اختياري)</label>
        <textarea name="notes"></textarea>

        <button type="submit">تأكيد وإتمام الطلب</button>
    </form>
</div>
</body>
</html>
