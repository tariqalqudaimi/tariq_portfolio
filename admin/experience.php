<?php
require_once 'auth.php';
require_once '../config/database.php';

// CRUD Logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM experience WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } else {
        $id = $_POST['id'];
        $title_ar = $_POST['title_ar'];
        $title_en = $_POST['title_en'];
        $company_ar = $_POST['company_ar'];
        $company_en = $_POST['company_en'];
        $period_ar = $_POST['period_ar'];
        $period_en = $_POST['period_en'];
        $description_ar = $_POST['description_ar'];
        $description_en = $_POST['description_en'];
        if (!empty($id)) { // Update
            $stmt = $conn->prepare("UPDATE experience SET title_ar=?, title_en=?, company_ar=?, company_en=?, period_ar=?, period_en=?, description_ar=?, description_en=? WHERE id=?");
            $stmt->bind_param("ssssssssi", $title_ar, $title_en, $company_ar, $company_en, $period_ar, $period_en, $description_ar, $description_en, $id);
        } else { // Insert
            $stmt = $conn->prepare("INSERT INTO experience (title_ar, title_en, company_ar, company_en, period_ar, period_en, description_ar, description_en) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $title_ar, $title_en, $company_ar, $company_en, $period_ar, $period_en, $description_ar, $description_en);
        }
        $stmt->execute();
    }
    header("Location: experience.php");
    exit;
}

$edit_data = ['id' => '', 'title_ar' => '', 'title_en' => '', 'company_ar' => '', 'company_en' => '', 'period_ar' => '', 'period_en' => '', 'description_ar' => '', 'description_en' => ''];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM experience WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

$items = $conn->query("SELECT * FROM experience ORDER BY id DESC");

include 'includes/header.php';
?>

<h1 class="text-3xl font-bold text-neon mb-6">إدارة الخبرة</h1>

<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-2xl font-semibold mb-4"><?= $edit_data['id'] ? 'تعديل خبرة' : 'إضافة خبرة جديدة' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" name="title_ar" placeholder="المسمى (عربي)" value="<?= htmlspecialchars($edit_data['title_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="title_en" placeholder="Title (English)" value="<?= htmlspecialchars($edit_data['title_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="company_ar" placeholder="الشركة (عربي)" value="<?= htmlspecialchars($edit_data['company_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="company_en" placeholder="Company (English)" value="<?= htmlspecialchars($edit_data['company_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="period_ar" placeholder="الفترة (عربي)" value="<?= htmlspecialchars($edit_data['period_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="period_en" placeholder="Period (English)" value="<?= htmlspecialchars($edit_data['period_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <textarea name="description_ar" placeholder="الوصف (عربي) - كل نقطة في سطر" rows="5" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($edit_data['description_ar']) ?></textarea>
            <textarea name="description_en" placeholder="Description (English) - one point per line" rows="5" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($edit_data['description_en']) ?></textarea>
        </div>
        <button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90"><?= $edit_data['id'] ? 'تحديث' : 'إضافة' ?></button>
        <?php if ($edit_data['id']): ?>
            <a href="experience.php" class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-500 mr-2">إلغاء</a>
        <?php endif; ?>
    </form>
</div>

<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">قائمة الخبرات</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2">المسمى</th>
                    <th class="p-2">الشركة</th>
                    <th class="p-2">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $items->fetch_assoc()): ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="p-2"><?= htmlspecialchars($row['title_ar']) ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['company_ar']) ?></td>
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
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
