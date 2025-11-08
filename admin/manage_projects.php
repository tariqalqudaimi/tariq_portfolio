<?php
require_once '../config/database.php'; // تأكد من صحة المسار

// Logic for Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect all data from form
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

    if ($id) { // Update existing project
        $stmt = $conn->prepare("UPDATE projects SET title_ar=?, title_en=?, description_ar=?, description_en=?, technologies=?, problem_ar=?, problem_en=?, solution_ar=?, solution_en=?, outcome_ar=?, outcome_en=?, main_image_url=? WHERE id=?");
        $stmt->bind_param("ssssssssssssi", $title_ar, $title_en, $description_ar, $description_en, $technologies, $problem_ar, $problem_en, $solution_ar, $solution_en, $outcome_ar, $outcome_en, $main_image_url, $id);
    } else { // Insert new project
        $stmt = $conn->prepare("INSERT INTO projects (title_ar, title_en, description_ar, description_en, technologies, problem_ar, problem_en, solution_ar, solution_en, outcome_ar, outcome_en, main_image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $title_ar, $title_en, $description_ar, $description_en, $technologies, $problem_ar, $problem_en, $solution_ar, $solution_en, $outcome_ar, $outcome_en, $main_image_url);
    }
    
    $stmt->execute();
    header("Location: manage_projects.php");
    exit();
}

// Logic for Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_projects.php");
    exit();
}

// Fetch all projects for listing
$projects = $conn->query("SELECT id, title_ar, title_en FROM projects ORDER BY id DESC");
$project_to_edit = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $project_to_edit = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>إدارة المشاريع ودراسات الحالة</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">إدارة المشاريع (دراسات الحالة)</h1>

        <!-- Add/Edit Form -->
        <form method="POST" class="bg-white p-8 rounded-lg shadow-md mb-8 space-y-6">
            <input type="hidden" name="id" value="<?= $project_to_edit['id'] ?? '' ?>">
            
            <!-- Basic Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 border-b pb-6">
                <div>
                    <label class="block font-semibold text-gray-700">العنوان (عربي):</label>
                    <input type="text" name="title_ar" value="<?= $project_to_edit['title_ar'] ?? '' ?>" class="w-full p-2 border rounded mt-1" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">العنوان (إنجليزي):</label>
                    <input type="text" name="title_en" value="<?= $project_to_edit['title_en'] ?? '' ?>" class="w-full p-2 border rounded mt-1" required>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">الوصف (عربي):</label>
                    <textarea name="description_ar" class="w-full p-2 border rounded mt-1" required><?= $project_to_edit['description_ar'] ?? '' ?></textarea>
                </div>
                 <div>
                    <label class="block font-semibold text-gray-700">الوصف (إنجليزي):</label>
                    <textarea name="description_en" class="w-full p-2 border rounded mt-1" required><?= $project_to_edit['description_en'] ?? '' ?></textarea>
                </div>
                 <div>
                    <label class="block font-semibold text-gray-700">التقنيات (مفصولة بفاصلة):</label>
                    <input type="text" name="technologies" value="<?= $project_to_edit['technologies'] ?? '' ?>" class="w-full p-2 border rounded mt-1" required>
                </div>
                 <div>
                    <label class="block font-semibold text-gray-700">رابط الصورة الرئيسية:</label>
                    <input type="url" name="main_image_url" value="<?= $project_to_edit['main_image_url'] ?? '' ?>" class="w-full p-2 border rounded mt-1" placeholder="https://...">
                </div>
            </div>

            <!-- Case Study Fields -->
            <h2 class="text-xl font-bold text-gray-800">تفاصيل دراسة الحالة</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold text-gray-700">المشكلة/التحدي (عربي):</label>
                    <textarea name="problem_ar" rows="4" class="w-full p-2 border rounded mt-1"><?= $project_to_edit['problem_ar'] ?? '' ?></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">المشكلة/التحدي (إنجليزي):</label>
                    <textarea name="problem_en" rows="4" class="w-full p-2 border rounded mt-1"><?= $project_to_edit['problem_en'] ?? '' ?></textarea>
                </div>
                 <div>
                    <label class="block font-semibold text-gray-700">الحل المقدم (عربي):</label>
                    <textarea name="solution_ar" rows="4" class="w-full p-2 border rounded mt-1"><?= $project_to_edit['solution_ar'] ?? '' ?></textarea>
                </div>
                 <div>
                    <label class="block font-semibold text-gray-700">الحل المقدم (إنجليزي):</label>
                    <textarea name="solution_en" rows="4" class="w-full p-2 border rounded mt-1"><?= $project_to_edit['solution_en'] ?? '' ?></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">النتيجة/الأثر (عربي):</label>
                    <textarea name="outcome_ar" rows="4" class="w-full p-2 border rounded mt-1"><?= $project_to_edit['outcome_ar'] ?? '' ?></textarea>
                </div>
                <div>
                    <label class="block font-semibold text-gray-700">النتيجة/الأثر (إنجليزي):</label>
                    <textarea name="outcome_en" rows="4" class="w-full p-2 border rounded mt-1"><?= $project_to_edit['outcome_en'] ?? '' ?></textarea>
                </div>
            </div>
            
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-lg"><?= $project_to_edit ? 'تحديث' : 'إضافة' ?> المشروع</button>
        </form>

        <!-- Projects List -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4">قائمة المشاريع</h2>
            <?php while($row = $projects->fetch_assoc()): ?>
            <div class="flex justify-between items-center border-b p-3 hover:bg-gray-50">
                <span><?= $row['title_ar'] ?> / <?= $row['title_en'] ?></span>
                <div class="flex items-center gap-4">
                    <a href="?edit=<?= $row['id'] ?>" class="text-blue-500 font-semibold">تعديل</a>
                    <a href="?delete=<?= $row['id'] ?>" class="text-red-500 font-semibold" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>