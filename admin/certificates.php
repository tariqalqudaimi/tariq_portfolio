<?php
require_once 'auth.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM certificates WHERE id = ?"); $stmt->bind_param("i", $_POST['id']); $stmt->execute();
    } else {
        $id = $_POST['id']; $name_ar = $_POST['name_ar']; $name_en = $_POST['name_en']; $issuer_ar = $_POST['issuer_ar']; $issuer_en = $_POST['issuer_en'];
        if (!empty($id)) {
            $stmt = $conn->prepare("UPDATE certificates SET name_ar=?, name_en=?, issuer_ar=?, issuer_en=? WHERE id=?");
            $stmt->bind_param("ssssi", $name_ar, $name_en, $issuer_ar, $issuer_en, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO certificates (name_ar, name_en, issuer_ar, issuer_en) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name_ar, $name_en, $issuer_ar, $issuer_en);
        }
        $stmt->execute();
    }
    header("Location: certificates.php"); exit;
}
$edit_data = ['id' => '', 'name_ar' => '', 'name_en' => '', 'issuer_ar' => '', 'issuer_en' => ''];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM certificates WHERE id = ?"); $stmt->bind_param("i", $_GET['edit']); $stmt->execute(); $result = $stmt->get_result();
    if ($result->num_rows > 0) $edit_data = $result->fetch_assoc();
}
$items = $conn->query("SELECT * FROM certificates ORDER BY id DESC");

require_once 'includes/header.php';
?>
<h1 class="text-3xl font-bold text-neon mb-6">إدارة الشهادات</h1>
<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-2xl font-semibold mb-4"><?= $edit_data['id'] ? 'تعديل شهادة' : 'إضافة شهادة جديدة' ?></h2>
    <form method="POST">
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" name="name_ar" placeholder="اسم الشهادة (عربي)" value="<?= htmlspecialchars($edit_data['name_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="name_en" placeholder="Certificate Name (English)" value="<?= htmlspecialchars($edit_data['name_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="issuer_ar" placeholder="جهة الإصدار (عربي)" value="<?= htmlspecialchars($edit_data['issuer_ar']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
            <input type="text" name="issuer_en" placeholder="Issuer (English)" value="<?= htmlspecialchars($edit_data['issuer_en']) ?>" class="w-full bg-gray-700 p-2 rounded" required>
        </div>
        <button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90"><?= $edit_data['id'] ? 'تحديث' : 'إضافة' ?></button>
        <?php if ($edit_data['id']): ?><a href="certificates.php" class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-500 mr-2">إلغاء</a><?php endif; ?>
    </form>
</div>
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">قائمة الشهادات</h2>
    <div class="overflow-x-auto"><table class="w-full text-right">
        <thead><tr class="border-b border-gray-700"><th class="p-2">الشهادة</th><th class="p-2">جهة الإصدار</th><th class="p-2">إجراءات</th></tr></thead>
        <tbody>
            <?php while($row = $items->fetch_assoc()): ?>
            <tr class="border-b border-gray-700 hover:bg-gray-700">
                <td class="p-2"><?= htmlspecialchars($row['name_ar']) ?></td><td class="p-2"><?= htmlspecialchars($row['issuer_ar']) ?></td>
                <td class="p-2 flex gap-2"><a href="?edit=<?= $row['id'] ?>" class="text-blue-400">تعديل</a>
                    <form method="POST" onsubmit="return confirm('هل أنت متأكد؟');"><input type="hidden" name="id" value="<?= $row['id'] ?>"><button type="submit" name="delete" class="text-red-400 bg-transparent border-none cursor-pointer">حذف</button></form>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table></div>
</div>
<?php include 'includes/footer.php'; ?>
    </table></div>
</div>
<?php include 'includes/footer.php'; ?>
