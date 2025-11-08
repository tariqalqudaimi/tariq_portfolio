<?php
require_once 'auth.php';
require_once '../config/database.php';

// Logic for handling POST requests (Add, Edit, Delete)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $_POST['id']);
        $stmt->execute();
    } else {
        // Collect all data from form, including new case study fields
        $id = $_POST['id'] ?? null;
        $title_ar = $_POST['title_ar'];
        $title_en = $_POST['title_en'];
        $description_ar = $_POST['description_ar'];
        $description_en = $_POST['description_en'];
        $technologies = $_POST['technologies'];
        // New Case Study Fields
        $problem_ar = $_POST['problem_ar'];
        $problem_en = $_POST['problem_en'];
        $solution_ar = $_POST['solution_ar'];
        $solution_en = $_POST['solution_en'];
        $outcome_ar = $_POST['outcome_ar'];
        $outcome_en = $_POST['outcome_en'];
        $main_image_url = $_POST['main_image_url'];
        
        // Note: The 'impact' fields are now replaced by 'problem', 'solution', 'outcome'
        // If you still need 'impact', you can add it back here.

        if (!empty($id)) {
            // Update existing project
            $stmt = $conn->prepare("UPDATE projects SET 
                title_ar=?, title_en=?, description_ar=?, description_en=?, technologies=?, 
                problem_ar=?, problem_en=?, solution_ar=?, solution_en=?, 
                outcome_ar=?, outcome_en=?, main_image_url=? 
                WHERE id=?");
            $stmt->bind_param("ssssssssssssi", 
                $title_ar, $title_en, $description_ar, $description_en, $technologies,
                $problem_ar, $problem_en, $solution_ar, $solution_en,
                $outcome_ar, $outcome_en, $main_image_url, $id);
        } else {
            // Insert new project
            $stmt = $conn->prepare("INSERT INTO projects (
                title_ar, title_en, description_ar, description_en, technologies, 
                problem_ar, problem_en, solution_ar, solution_en, 
                outcome_ar, outcome_en, main_image_url
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssssssss", 
                $title_ar, $title_en, $description_ar, $description_en, $technologies,
                $problem_ar, $problem_en, $solution_ar, $solution_en,
                $outcome_ar, $outcome_en, $main_image_url);
        }
        $stmt->execute();
    }
    header("Location: projects.php");
    exit;
}

// Fetch data for editing form
$edit_data = [];
if (isset($_GET['edit'])) {
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $_GET['edit']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    }
}

// Fetch all projects for the list
$items = $conn->query("SELECT id, title_ar, technologies FROM projects ORDER BY id DESC");

require_once 'includes/header.php';
?>

<h1 class="text-3xl font-bold text-neon mb-6">إدارة المشاريع ودراسات الحالة</h1>

<!-- Add/Edit Form -->
<div class="bg-gray-800 p-6 rounded-lg mb-8">
    <h2 class="text-2xl font-semibold mb-4"><?= !empty($edit_data['id']) ? 'تعديل مشروع' : 'إضافة مشروع جديد' ?></h2>
    <form method="POST" class="space-y-6">
        <input type="hidden" name="id" value="<?= $edit_data['id'] ?? '' ?>">

        <!-- Basic Project Info -->
        <fieldset class="border border-gray-600 p-4 rounded-lg">
            <legend class="px-2 text-neon font-semibold">المعلومات الأساسية</legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="title_ar" placeholder="عنوان المشروع (عربي)" value="<?= htmlspecialchars($edit_data['title_ar'] ?? '') ?>" class="w-full bg-gray-700 p-2 rounded" required>
                <input type="text" name="title_en" placeholder="Project Title (English)" value="<?= htmlspecialchars($edit_data['title_en'] ?? '') ?>" class="w-full bg-gray-700 p-2 rounded" required>
                <textarea name="description_ar" placeholder="الوصف (عربي)" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($edit_data['description_ar'] ?? '') ?></textarea>
                <textarea name="description_en" placeholder="Description (English)" class="w-full bg-gray-700 p-2 rounded" required><?= htmlspecialchars($edit_data['description_en'] ?? '') ?></textarea>
                <input type="text" name="technologies" placeholder="التقنيات (مفصولة بفاصلة ,)" value="<?= htmlspecialchars($edit_data['technologies'] ?? '') ?>" class="w-full bg-gray-700 p-2 rounded" required>
                <input type="url" name="main_image_url" placeholder="رابط الصورة الرئيسية للمشروع" value="<?= htmlspecialchars($edit_data['main_image_url'] ?? '') ?>" class="w-full bg-gray-700 p-2 rounded">
            </div>
        </fieldset>

        <!-- Case Study Details -->
        <fieldset class="border border-gray-600 p-4 rounded-lg">
            <legend class="px-2 text-neon font-semibold">تفاصيل دراسة الحالة</legend>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Problem -->
                <textarea name="problem_ar" placeholder="المشكلة/التحدي (عربي)" class="w-full bg-gray-700 p-2 rounded"><?= htmlspecialchars($edit_data['problem_ar'] ?? '') ?></textarea>
                <textarea name="problem_en" placeholder="Problem/Challenge (English)" class="w-full bg-gray-700 p-2 rounded"><?= htmlspecialchars($edit_data['problem_en'] ?? '') ?></textarea>
                <!-- Solution -->
                <textarea name="solution_ar" placeholder="الحل المقدم (عربي)" class="w-full bg-gray-700 p-2 rounded"><?= htmlspecialchars($edit_data['solution_ar'] ?? '') ?></textarea>
                <textarea name="solution_en" placeholder="Solution Provided (English)" class="w-full bg-gray-700 p-2 rounded"><?= htmlspecialchars($edit_data['solution_en'] ?? '') ?></textarea>
                <!-- Outcome -->
                <textarea name="outcome_ar" placeholder="النتيجة/الأثر (عربي)" class="w-full bg-gray-700 p-2 rounded"><?= htmlspecialchars($edit_data['outcome_ar'] ?? '') ?></textarea>
                <textarea name="outcome_en" placeholder="Outcome/Impact (English)" class="w-full bg-gray-700 p-2 rounded"><?= htmlspecialchars($edit_data['outcome_en'] ?? '') ?></textarea>
            </div>
        </fieldset>
        
        <div>
            <button type="submit" class="bg-neon text-gray-900 font-bold py-2 px-6 rounded hover:opacity-90"><?= !empty($edit_data['id']) ? 'تحديث' : 'إضافة' ?></button>
            <?php if (!empty($edit_data['id'])): ?>
                <a href="projects.php" class="bg-gray-600 text-white py-2 px-6 rounded hover:bg-gray-500 ml-2">إلغاء</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Projects List Table -->
<div class="bg-gray-800 p-6 rounded-lg">
    <h2 class="text-2xl font-semibold mb-4">قائمة المشاريع</h2>
    <div class="overflow-x-auto">
        <table class="w-full text-right">
            <thead>
                <tr class="border-b border-gray-700">
                    <th class="p-2">العنوان</th>
                    <th class="p-2">التقنيات</th>
                    <th class="p-2">إجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $items->fetch_assoc()): ?>
                <tr class="border-b border-gray-700 hover:bg-gray-700">
                    <td class="p-2"><?= htmlspecialchars($row['title_ar']) ?></td>
                    <td class="p-2"><?= htmlspecialchars($row['technologies']) ?></td>
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