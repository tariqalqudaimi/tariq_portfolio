<?php require_once 'auth.php'; ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة التحكم</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .text-neon { color: #4ade80; }
        .bg-neon { background-color: #4ade80; }
        .border-neon { border-color: #4ade80; }
        .sidebar-link { display: block; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: background-color 0.2s; }
        .sidebar-link:hover { background-color: #374151; }
        .sidebar-link.active { background-color: #4ade80; color: #111827; font-weight: bold; }
        input:focus, textarea:focus { outline-color: #4ade80; }
    </style>
</head>
<body class="bg-gray-900 text-gray-200">
    
    <!-- الشريط الجانبي الثابت -->
    <aside class="fixed top-0 right-0 h-full w-64 bg-gray-800 p-4 border-l border-gray-700 overflow-y-auto z-10">
        <a href="../index.php" target="_blank" class="text-2xl font-bold text-neon mb-8 text-center block hover:opacity-80 transition-opacity">عرض الموقع</a>
        <nav class="flex flex-col space-y-2">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <a href="dashboard.php" class="sidebar-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">الرئيسية</a>
            <a href="info.php" class="sidebar-link <?= $current_page == 'info.php' ? 'active' : '' ?>">المعلومات الشخصية</a>
            <a href="skills.php" class="sidebar-link <?= $current_page == 'skills.php' ? 'active' : '' ?>">المهارات</a>
            <a href="soft_skills.php" class="sidebar-link <?= $current_page == 'soft_skills.php' ? 'active' : '' ?>"> المهارات الشخصية</a>
            <a href="experience.php" class="sidebar-link <?= $current_page == 'experience.php' ? 'active' : '' ?>">الخبرة</a>
            <a href="projects.php" class="sidebar-link <?= $current_page == 'projects.php' ? 'active' : '' ?>">المشاريع</a>
            <a href="education.php" class="sidebar-link <?= $current_page == 'education.php' ? 'active' : '' ?>">التعليم</a>
            <a href="certificates.php" class="sidebar-link <?= $current_page == 'certificates.php' ? 'active' : '' ?>">الشهادات</a>
            <a href="logout.php" class="sidebar-link mt-10 hover:bg-red-600">تسجيل الخروج</a>
        </nav>
    </aside>

    <!-- المحتوى الرئيسي مع هامش لترك مساحة للشريط الجانبي -->
    <main class="mr-64 p-8">
<body>


<div class="content">
