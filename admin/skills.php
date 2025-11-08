<?php
require_once 'auth.php';
require_once '../config/database.php';

// --- Handle POST Actions (Create, Update, Delete) ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } else {
        $id = $_POST['id'];
        $category_ar = $_POST['category_ar']; $category_en = $_POST['category_en']; $skills_list = $_POST['skills_list']; $icon = $_POST['icon'];
        if (!empty($id)) {
            $stmt = $conn->prepare("UPDATE skills SET category_ar=?, category_en=?, skills_list=?, icon=? WHERE id=?");
            $stmt->bind_param("ssssi", $category_ar, $category_en, $skills_list, $icon, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO skills (category_ar, category_en, skills_list, icon) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $category_ar, $category_en, $skills_list, $icon);
        }
        $stmt->execute();
    }
    header("Location: skills.php"); exit;
}

// --- Prepare Edit Form Data ---
$edit_data = ['id' => '', 'category_ar' => '', 'category_en' => '', 'skills_list' => '', 'icon' => 'code'];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM skills WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) $edit_data = $result->fetch_assoc();
}
$skills_result = $conn->query("SELECT * FROM skills ORDER BY id ASC");

require_once 'includes/header.php';
?>

<h1 class="text-3xl font-bold text-neon mb-6">إدارة المهارات</h1>

<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-2xl font-semibold mb-4"><?= $edit_data['id'] ? 'تعديل مهارة' : 'إضافة مهارة جديدة' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" name="category_ar" placeholder="الفئة (عربي)" value="<?= htmlspecialchars($edit_data['category_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="category_en" placeholder="Category (English)" value="<?= htmlspecialchars($edit_data['category_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div class="mb-4">
            <textarea name="skills_list" placeholder="قائمة المهارات (مثال: HTML, CSS)" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($edit_data['skills_list']) ?></textarea>
        </div>
        <div class="mb-4">
            <label for="icon-input" class="block mb-2">أيقونة Lucide (مثال: code, database, smartphone)</label>
            <div class="flex items-center gap-4">
                <input type="text" id="icon-input" name="icon" placeholder="أيقونة Lucide" value="<?= htmlspecialchars($edit_data['icon']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
                <span id="icon-preview" class="bg-gray-700 p-2 rounded"><i data-lucide="<?= htmlspecialchars($edit_data['icon']) ?>"></i></span>
            </div>
        </div>
        <button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90"><?= $edit_data['id'] ? 'تحديث' : 'إضافة' ?></button>
        <?php if ($edit_data['id']): ?>
            <a href="skills.php" class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-500 mr-2">إلغاء</a>
        <?php endif; ?>
    </form>
</div>

<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">قائمة المهارات</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2">الفئة</th>
                    <th class="p-2">المهارات</th>
                    <th class="p-2">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $skills_result->fetch_assoc()): ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="p-2"><?= htmlspecialchars($row['category_ar']) ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['skills_list']) ?></td>
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

<script>
document.getElementById('icon-input').addEventListener('input', function() {
    const iconName = this.value.trim();
    const preview = document.getElementById('icon-preview');
    preview.innerHTML = `<i data-lucide="${iconName}"></i>`;
    lucide.createIcons();
});
</script>

<?php
require_once 'includes/footer.php';
$conn->close();
?>
