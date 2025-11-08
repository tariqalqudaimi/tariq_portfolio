<?php
require_once 'auth.php';
require_once '../config/database.php';

$message = '';
// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $conn->prepare("UPDATE personal_info SET name_ar=?, name_en=?, job_title_ar=?, job_title_en=?, phone=?, email=?, location_ar=?, location_en=? WHERE id=1");
    $stmt->bind_param("ssssssss", 
        $_POST['name_ar'], $_POST['name_en'], $_POST['job_title_ar'], $_POST['job_title_en'], 
        $_POST['phone'], $_POST['email'], $_POST['location_ar'], $_POST['location_en']
    );
    if ($stmt->execute()) {
        $message = '<div class="bg-green-600 text-white p-3 rounded mb-4">تم تحديث المعلومات بنجاح.</div>';
    } else {
        $message = '<div class="bg-red-600 text-white p-3 rounded mb-4">حدث خطأ.</div>';
    }
}

// Fetch current data
$info = $conn->query("SELECT * FROM personal_info WHERE id=1")->fetch_assoc();

require_once 'includes/header.php';
?>

<h1 class="text-3xl font-bold text-neon mb-6">إدارة المعلومات الشخصية</h1>
<?= $message ?>
<div class="bg-gray-800 p-6 rounded-lg">
    <form method="POST">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div><label class="block mb-2">الاسم (عربي)</label><input type="text" name="name_ar" value="<?= htmlspecialchars($info['name_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required></div>
            <div><label class="block mb-2">Name (English)</label><input type="text" name="name_en" value="<?= htmlspecialchars($info['name_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required></div>
            <div><label class="block mb-2">المسمى الوظيفي (عربي)</label><textarea name="job_title_ar" rows="4" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($info['job_title_ar']) ?></textarea></div>
            <div><label class="block mb-2">Job Title (English)</label><textarea name="job_title_en" rows="4" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($info['job_title_en']) ?></textarea></div>
            <div><label class="block mb-2">رقم الهاتف</label><input type="text" name="phone" value="<?= htmlspecialchars($info['phone']) ?>" class="w-full bg-gray-700 p-2 rounded" required></div>
            <div><label class="block mb-2">البريد الإلكتروني</label><input type="email" name="email" value="<?= htmlspecialchars($info['email']) ?>" class="w-full bg-gray-700 p-2 rounded" required></div>
            <div><label class="block mb-2">الموقع (عربي)</label><input type="text" name="location_ar" value="<?= htmlspecialchars($info['location_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required></div>
            <div><label class="block mb-2">Location (English)</label><input type="text" name="location_en" value="<?= htmlspecialchars($info['location_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required></div>
        </div>
        <div class="mt-6"><button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90">تحديث المعلومات</button></div>
    </form>
</div>

<?php
require_once 'includes/footer.php';
?>

