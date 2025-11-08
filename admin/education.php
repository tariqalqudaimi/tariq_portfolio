<?php
require_once 'auth.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM education WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } else {
        $id = $_POST['id'];
        $degree_ar = $_POST['degree_ar'];
        $degree_en = $_POST['degree_en'];
        $university_ar = $_POST['university_ar'];
        $university_en = $_POST['university_en'];
        $location_ar = $_POST['location_ar'];
        $location_en = $_POST['location_en'];
        $graduation_year_ar = $_POST['graduation_year_ar'];
        $graduation_year_en = $_POST['graduation_year_en'];
        if (!empty($id)) {
            $stmt = $conn->prepare("UPDATE education SET degree_ar=?, degree_en=?, university_ar=?, university_en=?, location_ar=?, location_en=?, graduation_year_ar=?, graduation_year_en=? WHERE id=?");
            $stmt->bind_param("ssssssssi", $degree_ar, $degree_en, $university_ar, $university_en, $location_ar, $location_en, $graduation_year_ar, $graduation_year_en, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO education (degree_ar, degree_en, university_ar, university_en, location_ar, location_en, graduation_year_ar, graduation_year_en) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $degree_ar, $degree_en, $university_ar, $university_en, $location_ar, $location_en, $graduation_year_ar, $graduation_year_en);
        }
        $stmt->execute();
    }
    header("Location: education.php");
    exit;
}

$edit_data = ['id' => '', 'degree_ar' => '', 'degree_en' => '', 'university_ar' => '', 'university_en' => '', 'location_ar' => '', 'location_en' => '', 'graduation_year_ar' => '', 'graduation_year_en' => ''];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM education WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) $edit_data = $result->fetch_assoc();
}
$items = $conn->query("SELECT * FROM education ORDER BY id DESC");

include 'includes/header.php';
?>

<h1 class="text-3xl font-bold text-neon mb-6">إدارة التعليم</h1>
<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-2xl font-semibold mb-4"><?= $edit_data['id'] ? 'تعديل مؤهل' : 'إضافة مؤهل جديد' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" name="degree_ar" placeholder="الشهادة (عربي)" value="<?= htmlspecialchars($edit_data['degree_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="degree_en" placeholder="Degree (English)" value="<?= htmlspecialchars($edit_data['degree_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="university_ar" placeholder="الجامعة (عربي)" value="<?= htmlspecialchars($edit_data['university_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="university_en" placeholder="University (English)" value="<?= htmlspecialchars($edit_data['university_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="location_ar" placeholder="الموقع (عربي)" value="<?= htmlspecialchars($edit_data['location_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="location_en" placeholder="Location (English)" value="<?= htmlspecialchars($edit_data['location_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="graduation_year_ar" placeholder="سنة التخرج (عربي)" value="<?= htmlspecialchars($edit_data['graduation_year_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="graduation_year_en" placeholder="Graduation Year (English)" value="<?= htmlspecialchars($edit_data['graduation_year_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90"><?= $edit_data['id'] ? 'تحديث' : 'إضافة' ?></button>
        <?php if ($edit_data['id']): ?><a href="education.php" class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-500 mr-2">إلغاء</a><?php endif; ?>
    </form>
</div>
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">قائمة المؤهلات</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2">الشهادة</th>
                    <th class="p-2">الجامعة</th>
                    <th class="p-2">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $items->fetch_assoc()): ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="p-2"><?= htmlspecialchars($row['degree_ar']) ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['university_ar']) ?></td>
                    <td class="p-2 flex gap-2">
                        <a href="?edit=<?= $row['id'] ?>" class="text-blue-400">تعديل</a>
                        <form method="POST" onsubmit="return confirm('هل أنت متأكد؟');">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete" class="text-red-400 bg-transparent border-none cursor-pointer">حذف</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
