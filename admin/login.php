<?php
session_start(); // يجب أن تبدأ الجلسة في بداية الملف
require_once '../config/database.php';

// إذا كان المستخدم مسجلاً دخوله بالفعل، يتم توجيهه إلى لوحة التحكم
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // إعادة إنشاء معرف الجلسة لمنع هجمات تثبيت الجلسة
            session_regenerate_id(true);
            
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            
            // حفظ بيانات الجلسة وإغلاقها قبل إعادة التوجيه
            session_write_close();
            header('Location: dashboard.php');
            exit;
        }
    }
    $error = 'اسم المستخدم أو كلمة المرور غير صحيحة.';
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول - لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .text-neon { color: #4ade80; }
        .border-neon { border-color: #4ade80; }
        .cta-button { background: linear-gradient(90deg, #4ade80 0%, #10b981 100%); color: #1a1a1a; font-weight: bold; padding: 0.75rem 1.5rem; border-radius: 0.5rem; transition: all 0.3s ease; }
        .cta-button:hover { opacity: 0.9; }
    </style>
</head>
<body class="bg-gray-900 text-white flex items-center justify-center min-h-screen">
    <div class="bg-gray-800 p-8 rounded-lg shadow-lg w-full max-w-sm">
        <h2 class="text-2xl font-bold text-center text-neon mb-6">لوحة التحكم</h2>
        <?php if ($error): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4 text-center"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" action="login.php">
            <div class="mb-4">
                <label for="username" class="block mb-2">اسم المستخدم</label>
                <input type="text" name="username" id="username" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-neon" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2">كلمة المرور</label>
                <input type="password" name="password" id="password" class="w-full bg-gray-700 border border-gray-600 rounded p-2 focus:outline-none focus:border-neon" required>
            </div>
            <button type="submit" class="w-full cta-button">تسجيل الدخول</button>
        </form>
    </div>
</body>
</html>
</html>
