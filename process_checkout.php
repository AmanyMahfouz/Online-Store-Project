<?php
session_start();
include('include/connected.php');

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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $phone     = $_POST['phone'];
    $email     = $_POST['email'];
    $address   = $_POST['address'];
    $notes     = $_POST['notes'] ?? '';

    // 1️⃣ إضافة العميل
    $stmt = $conn->prepare("INSERT INTO customers (full_name, phone, email, address) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $full_name, $phone, $email, $address);
    $stmt->execute();
    $customer_id = $stmt->insert_id;

    // 2️⃣ جلب منتجات السلة
    $query = "SELECT * FROM cart WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo '<script>alert("السلة فارغة!"); window.location.href="cart.php";</script>';
        exit;
    }

    // 3️⃣ حساب الإجمالي
    $total = 0;
    $cart_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subtotal = $row['price'] * $row['quantity'];
        $total += $subtotal;
        $cart_items[] = $row;
    }

    // 4️⃣ إنشاء الطلب
    $stmt = $conn->prepare("INSERT INTO orders (customer_id, total_price, notes) VALUES (?, ?, ?)");
    $stmt->bind_param("ids", $customer_id, $total, $notes);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // 5️⃣ تخزين تفاصيل الطلب
    $stmt_item = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($cart_items as $item) {
        $stmt_item->bind_param("isid", $order_id, $item['name'], $item['quantity'], $item['price']);
        $stmt_item->execute();
    }

    // 6️⃣ مسح السلة
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id'");

    // 7️⃣ تحويل لصفحة نجاح الطلب
    header("Location: ordersuccess.php?order=$order_id");
    exit;
}
?>
