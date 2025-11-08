<?php
// إعدادات قاعدة البيانات
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // اسم المستخدم الافتراضي هو root
define('DB_PASSWORD', ''); // كلمة المرور الافتراضية فارغة
define('DB_NAME', 'tariq_portfolio');

// إنشاء الاتصال
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// ضبط الترميز لضمان دعم اللغة العربية بشكل صحيح
$conn->set_charset("utf8mb4");
?>
