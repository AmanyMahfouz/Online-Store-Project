<?php
// بدء جلسة php
session_start();

// حذف لكل السشن التي تم حفظها داخل المتصفح
session_unset();

// تدمير او تحطيم الجلسه
session_destroy();
// اعادة توجيه للمستخدم
header('location:admin.php');
?>