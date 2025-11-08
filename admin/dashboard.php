<?php
require_once 'auth.php';
require_once 'includes/header.php';
?>

<div class="container-fluid">
    <h1 class="mt-4">Dashboard</h1>
    <p>Welcome to the admin panel, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
    <p>From here you can manage your portfolio content.</p>
</div>

<h1 class="text-3xl font-bold text-neon mb-6">أهلاً بك, <?= htmlspecialchars($_SESSION['username']) ?>!</h1>
<p class="text-lg text-gray-400">
    هذه هي لوحة التحكم الخاصة بموقعك الشخصي.
    <br>
    اختر أحد الأقسام من القائمة الجانبية للبدء في إدارة المحتوى.
</p>

<?php
require_once 'includes/footer.php';
?>
