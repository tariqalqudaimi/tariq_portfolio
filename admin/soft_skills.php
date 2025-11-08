<?php
require_once 'auth.php';
require_once '../config/database.php';

// Logic for handling POST requests (Add, Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM soft_skills WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } else {
        $id = $_POST['id'] ?? null;
        $icon_name = $_POST['icon_name'];
        $skill_ar = $_POST['skill_ar'];
        $skill_en = $_POST['skill_en'];

        if (!empty($id)) {
            // Update existing skill
            $stmt = $conn->prepare("UPDATE soft_skills SET icon_name=?, skill_ar=?, skill_en=? WHERE id=?");
            $stmt->bind_param("sssi", $icon_name, $skill_ar, $skill_en, $id);
        } else {
            // Insert new skill
            $stmt = $conn->prepare("INSERT INTO soft_skills (icon_name, skill_ar, skill_en) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $icon_name, $skill_ar, $skill_en);
        }
        $stmt->execute();
    }
    header("Location: soft_skills.php");
    exit;
}

// Fetch data for editing form
$edit_data = ['id' => '', 'icon_name' => '', 'skill_ar' => '', 'skill_en' => ''];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM soft_skills WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

// Fetch all soft skills for the list
$items = $conn->query("SELECT * FROM soft_skills ORDER BY id DESC");

require_once 'includes/header.php';
?>

<h1 class="text-3xl font-bold text-neon mb-6">إدارة المهارات الشخصية</h1>

<!-- Add/Edit Form -->
<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-2xl font-semibold mb-4"><?= $edit_data['id'] ? 'تعديل مهارة' : 'إضافة مهارة جديدة' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <input type="text" name="icon_name" placeholder="اسم الأيقونة (Lucide)" value="<?= htmlspecialchars($edit_data['icon_name']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="skill_ar" placeholder="اسم المهارة (عربي)" value="<?= htmlspecialchars($edit_data['skill_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="skill_en" placeholder="Skill Name (English)" value="<?= htmlspecialchars($edit_data['skill_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        
        <button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90"><?= $edit_data['id'] ? 'تحديث' : 'إضافة' ?></button>
        <?php if ($edit_data['id']): ?>
            <a href="soft_skills.php" class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-500 ml-2">إلغاء</a>
        <?php endif; ?>
    </form>
</div>

<!-- Soft Skills List Table -->
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">قائمة المهارات الشخصية</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2">المهارة</th>
                    <th class="p-2">الأيقونة</th>
                    <th class="p-2">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $items->fetch_assoc()): ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="p-2"><?= htmlspecialchars($row['skill_ar']) ?></td>
                    <td class="p-2 font-mono text-sm"><?= htmlspecialchars($row['icon_name']) ?></td>
                    <td class="p-2">
                        <div class="flex gap-4">
                            <a href="?edit=<?= $row['id'] ?>" class="text-blue-400 font-semibold">تعديل</a>
                            <form method="POST" onsubmit="return confirm('هل أنت متأكد من الحذف؟');" class="inline">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <button type="submit" name="delete" class="text-red-400 bg-transparent border-none cursor-pointer font-semibold p-0">حذف</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>