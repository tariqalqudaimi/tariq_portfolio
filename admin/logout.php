<?php
session_start();

// إلغاء تعيين جميع متغيرات الجلسة
$_SESSION = array();

// حذف ملف تعريف الارتباط الخاص بالجلسة
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// أخيرًا، تدمير الجلسة
session_destroy();

// التوجيه إلى صفحة تسجيل الدخول
header("Location: login.php");
exit;
?>
?>
