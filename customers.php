<?php
session_start();
include('include/connected.php');

// التحقق من تسجيل الدخول
if (!isset($_SESSION['EMAIL'])) {
    header('location:../index.php');
    exit;
}

// جلب بيانات العملاء
$sql = "SELECT * FROM customers ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>قائمة العملاء</title>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f0f2f5;
    padding: 40px 20px;
}

.container {
    max-width: 1100px;
    margin: auto;
    background-color: #fff;
    padding: 35px;
    border-radius: 12px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 25px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    font-size: 15px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 12px 10px;
    text-align: center;
}

table th {
    background-color: #3498db;
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

a.view-btn {
    display: inline-block;
    padding: 5px 12px;
    background-color: #27ae60;
    color: white;
    border-radius: 5px;
    text-decoration: none;
    transition: 0.3s;
}

a.view-btn:hover {
    background-color: #2ecc71;
}
</style>
</head>
<body>

<div class="container">
    <h2>قائمة العملاء</h2>
    <table>
        <tr>
            <th>الرقم التسلسلي</th>
            <th>الاسم الكامل</th>
            <th>رقم الهاتف</th>
            <th>البريد الإلكتروني</th>
            <th>العنوان</th>
            <th>تاريخ التسجيل</th>
        </tr>
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['full_name']; ?></td>
                    <td><?= $row['phone']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['address']; ?></td>
                    <td><?= $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="6">لا توجد بيانات عملاء حتى الآن.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
