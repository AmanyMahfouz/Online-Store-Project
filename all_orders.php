<?php
session_start();
include('include/connected.php');

if (!isset($_SESSION['user_id'])) {
    echo '<script>alert("يرجى تسجيل الدخول أولاً!"); window.location.href="user/login.php";</script>';
    exit;
}

// جلب الطلبات مع بيانات العميل مرتبة تصاعدياً حسب رقم الطلب (من الأصغر للأكبر)
$sql = "SELECT o.id AS order_id, o.total_price, o.status, o.notes, o.created_at,
               c.full_name, c.phone, c.email, c.address
        FROM orders o
        JOIN customers c ON o.customer_id = c.id
        ORDER BY o.id ASC"; // ASC = من الأصغر للأكبر، لتغيير الترتيب يمكن استخدام DESC
$result = mysqli_query($conn, $sql);

// جلب تفاصيل كل طلب مسبقًا
$order_details = [];
$total_all_orders = 0; // لتجميع إجمالي كل الطلبات
if(mysqli_num_rows($result) > 0){
    mysqli_data_seek($result, 0);
    while($row = mysqli_fetch_assoc($result)){
        $order_id_detail = $row['order_id'];
        $sql_items = "SELECT * FROM order_items WHERE order_id = $order_id_detail";
        $res_items = mysqli_query($conn, $sql_items);
        $details = [];
        while($r = mysqli_fetch_assoc($res_items)){
            $details[] = $r;
        }
        $order_details[$order_id_detail] = ['order'=>$row,'items'=>$details];
        $total_all_orders += $row['total_price'];
    }
}
?>

<!-- -- --- -- --- --- ---- -- - -- --  HTML  -- --- --- --- --- -- --- -->
<!DOCTYPE html>
<html lang="ar">
<head>
<meta charset="UTF-8">
<title>قائمة الطلبات</title>
<link rel="icon" href="img/img1.jpg"/>
<meta name="title" content="Online Store - The Best Program to Enroll for Exchange">
<meta name="description" content="This is an Online Store">

<!-- --- -- --  -- -- -- -- -- CSS -- -- -- -- -- -- -- -- -- --  -->
<style>
body 
{ font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f0f2f5; 
  padding: 40px 20px; 
}

.container
 { max-width: 1100px;
   margin:auto; 
   background:#fff; 
   padding:35px; 
   border-radius:12px; 
   box-shadow:0 8px 25px rgba(0,0,0,0.1);
}

h2
 { 
    text-align:center; 
    color: #351d08ff; 
    font-weight: bold;
    margin-bottom:25px;
}

table 
{ width:100%; 
  border-collapse:collapse; 
  margin-top:20px; 
  font-size:15px;
}

table th, table td
 {  border:1px solid rgba(221, 221, 221, 1); 
    padding:12px 10px; 
    text-align:center;
}

table th
 { background-color:#e67e22; 
   color:#351d08ff; 
   font-weight:bold;
}

table tr:nth-child(even) 
{ background-color: #f8f9fa;}

table tr:hover 
{ 
  background-color: #f1f1f1; 
  transition:0.3s;
}

a.view-btn, a.hide-btn
 { 
    display:inline-block; 
    padding:5px 12px;
    color:white; 
    border-radius:5px;
    text-decoration:none; 
    margin:2px; 
    cursor:pointer; 
}

a.view-btn
 { 
    background-color: #A18D6D;
} 
a.view-btn:hover 
{ 
    background-color: #e67e22;
}

a.hide-btn
{ 
    background-color: #703B3B;
} 

a.hide-btn:hover 
{ 
    background-color: #c0392b;
}

h3 
{ 
    color:#351d08ff; 
    margin-top:20px; 
    margin-bottom:15px;
}

.details-table th 
{ 
    background-color:#e67e22; 
    color:#351d08ff;
}

.details-table td 
{ text-align:center;}

.details-container
 { 
    display:none; 
    background: #f8f9fa;
 }

.details-container div 
{ padding:20px; }

tfoot td
 { 
    font-weight:bold;
    background: #ecf0f1; 
}
</style> 
<!-- End CSS -->

<!-- --- -- --  -- -- -- -- -- JavaScript -- -- -- -- -- -- -- -- -- --  -->
<script>
function toggleDetails(id, show){
    var elem = document.getElementById('details-'+id);
    if(show) elem.style.display='table-row';
    else elem.style.display='none';
}
</script>
 <!-- End JavaScript -->
</head>

<body>
<div class="container">
<h2>قائمــــة الطلبــــات</h2>
<table>
<thead>
<tr>
    <th>رقم الطلب</th>
    <th>العميل</th>
    <th>الهاتف</th>
    <th>البريد الإلكتروني</th>
    <th>العنوان</th>
    <th>الإجمالي</th>
    <th>الحالة</th>
    <th>ملاحظات</th>
    <th>تاريخ الطلب</th>
    <th>الإجراءات</th>
</tr>
</thead>

<tbody>
<?php if(!empty($order_details)): ?>

    <?php foreach($order_details as $order_id=>$data): ?>

        <?php $order = $data['order']; $items=$data['items']; ?>

        <tr>
            <td><?= $order['order_id']; ?></td>
            <td><?= $order['full_name']; ?></td>
            <td><?= $order['phone']; ?></td>
            <td><?= $order['email']; ?></td>
            <td><?= $order['address']; ?></td>
            <td><?= number_format($order['total_price'],2); ?></td>
            <td><?= $order['status']; ?></td>
            <td><?= $order['notes']; ?></td>
            <td><?= $order['created_at']; ?></td>
            <td>
                <a class="view-btn" onclick="toggleDetails(<?= $order_id ?>, true)">عرض</a>
                <a class="hide-btn" onclick="toggleDetails(<?= $order_id ?>, false)">إخفـاء</a>
            </td>
        </tr>

        <tr id="details-<?= $order_id ?>" class="details-container">
            <td colspan="10">
                <div>
                    <h3>تفاصيل المنتجات للطلب رقم: <?= $order_id ?></h3>
                    <table class="details-table">
                        <tr>
                            <th>اسم المنتج</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الإجمالي</th>
                        </tr>
                        <?php foreach($items as $item): ?>
                        <tr>
                            <td><?= $item['product_name'] ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['price'],2) ?></td>
                            <td><?= number_format($item['quantity'] * $item['price'],2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </td>
        </tr>

    <?php endforeach; ?>

  <?php else: ?>

  <tr><td colspan="10">لا توجد طلبات حتى الآن.</td></tr>

  <?php endif; ?>
</tbody>


<tfoot>
<tr>
    <td colspan="5">الإجمالي الكلي لكل الطلبات:</td>
    <td colspan="5"><?= number_format($total_all_orders,2) ?></td>
</tr>
</tfoot>


</table>
</div>
</body>
</html>
 <!-- End HTML -->
