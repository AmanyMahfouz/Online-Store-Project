<?php
session_start();
include('include/connected.php');

if(!isset($_GET['order'])){
    echo "<h2>لا يوجد عملية شراء تمت!</h2>";
    exit;
}

$order_id = $_GET['order'];

// جلب بيانات الطلب والعميل
$sql = "SELECT o.id AS order_id, o.total_price, o.notes, o.created_at, 
               c.full_name, c.phone, c.email, c.address
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

// جلب تفاصيل المنتجات في الطلب
$sql_items = "SELECT * FROM order_items WHERE order_id = ?";
$stmt_items = $conn->prepare($sql_items);
$stmt_items->bind_param("i", $order_id);
$stmt_items->execute();
$result_items = $stmt_items->get_result();
$order_items = [];
while($row = $result_items->fetch_assoc()){
    $order_items[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
/* صفحة كاملة */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    padding: 50px 20px;
    margin: 0;
}

/* الصندوق الرئيسي */
.container {
    background-color: #fff;
    max-width: 900px;
    margin: auto;
    padding: 40px 35px;
    border-radius: 15px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1);
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
    font-size: 15px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px 10px;
    text-align: center;
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
    transition: 0.3s;
}

/* النموذج */
form label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #351d08ff;
}

form input[type="text"],
form input[type="email"],
form textarea {
    width: 100%;
    padding: 14px 12px;
    margin-bottom: 20px;
    border-radius: 8px;
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
    padding: 16px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #A18D6D ;
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: 0.3s;
}

button:hover {
    background-color: #ef8120 ;
}

/* الإجمالي */
h3#total {
    text-align: right;
    color: #ef8120 ;
    font-size: 18px;
    margin-top: 10px;
}

/* تحسين الملاحظات */
textarea {
    min-height: 80px;
}

/* تحسين المسافات بين الأقسام */
h2, h3 {
    margin-top: 25px;
    margin-bottom: 15px;
}
</style>

<body>
    <div class="box">
    <h1>✔ تم إتمام الطلب بنجاح</h1>
    <p>رقم الطلب الخاص بك هو:</p>
    <h2>#<?= $order['order_id']; ?></h2>

    <h3>بيانات العميل:</h3>
    <p>الاسم: <?= $order['full_name']; ?></p>
    <p>الهاتف: <?= $order['phone']; ?></p>
    <p>البريد الإلكتروني: <?= $order['email']; ?></p>
    <p>العنوان: <?= $order['address']; ?></p>

    <h3>تفاصيل الطلب:</h3>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>المنتج</th>
            <th>الكمية</th>
            <th>السعر</th>
            <th>الإجمالي</th>
        </tr>
        <?php foreach($order_items as $item): ?>
        <tr>
            <td><?= $item['product_name']; ?></td>
            <td><?= $item['quantity']; ?></td>
            <td><?= $item['price']; ?></td>
            <td><?= $item['price'] * $item['quantity']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <p>الإجمالي الكلي: <?= $order['total_price']; ?> جنيه</p>
    <?php if(!empty($order['notes'])): ?>
    <p>ملاحظات: <?= $order['notes']; ?></p>
    <?php endif; ?>

    <a href="index.php">العودة للصفحة الرئيسية</a>
</div>


</body>
</html>

