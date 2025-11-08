<?php
require_once 'config/database.php';

// --- دالة مساعدة لجلب كل النتائج كمصفوفة ---
function fetch_all_results($result) {
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// --- جلب جميع البيانات من قاعدة البيانات ---
$info_result = $conn->query("SELECT * FROM personal_info LIMIT 1");
$info = $info_result ? $info_result->fetch_assoc() : [];
$services = fetch_all_results($conn->query("SELECT * FROM services ORDER BY id ASC"));
$skills = fetch_all_results($conn->query("SELECT * FROM skills ORDER BY id ASC"));
$soft_skills = fetch_all_results($conn->query("SELECT * FROM soft_skills ORDER BY id ASC"));
$experiences = fetch_all_results($conn->query("SELECT * FROM experience ORDER BY id DESC"));
$projects = fetch_all_results($conn->query("SELECT * FROM projects ORDER BY id DESC"));
// -- تعديل هنا: جلب كل الشهادات التعليمية --
$educations = fetch_all_results($conn->query("SELECT * FROM education ORDER BY id DESC"));
$certificates = fetch_all_results($conn->query("SELECT * FROM certificates ORDER BY id DESC"));
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-ar="طارق القديمي - مطور برمجيات" data-en="Tariq Alqudaimi - Software Developer">طارق القديمي - مطور برمجيات</title>
     <script src="https://cdn.tailwindcss.com"></script> 
    <link rel="stylesheet" href="assets/css/style.css">
    
</head>
<body class="">

    <!-- =========== HEADER (Global) =========== -->
    <header class="header-section sticky top-0 z-50 shadow-lg">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold"><a href="#home">T<span class="text-accent">A</span>RIQ</a></div>
            <div class="hidden md:flex items-center space-x-6" id="nav-links">
                <a href="#services" class="hover:text-accent transition-colors" data-ar="الخدمات" data-en="Services"></a>
                <a href="#skills" class="hover:text-accent transition-colors" data-ar="المهارات" data-en="Skills"></a>
                <a href="#experience" class="hover:text-accent transition-colors" data-ar="الخبرة" data-en="Experience"></a>
                <a href="#projects" class="hover:text-accent transition-colors" data-ar="المشاريع" data-en="Projects"></a>
                <a href="#education" class="hover:text-accent transition-colors" data-ar="التعليم" data-en="Education"></a>
                <a href="#certificates" class="hover:text-accent transition-colors" data-ar="الشهادات" data-en="Certificates"></a>
            </div>
            <div class="flex items-center gap-2 md:gap-4">
                <button id="layout-toggle" class="p-2 rounded-md hover:bg-white/10 transition-colors" title="Switch View"><i data-lucide="layout-grid" class="w-5 h-5"></i></button>
                <button id="theme-toggle" class="p-2 rounded-md hover:bg-white/10 transition-colors" title="Switch Theme"><i data-lucide="sun" class="w-5 h-5"></i></button>
                <button id="lang-toggle" class="btn-primary text-sm px-4 py-2 rounded-md">English</button>
            </div>
        </nav>
    </header>

    <!-- =========== الواجهة الأولى: تصميم الموقع (Portfolio View) =========== -->
    <div id="website-view">
        <main>
            <section id="home" class="header-section pt-16 pb-24"><div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center"><div id="hero-content" class="text-center md:text-right"><h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-4"><span class="ar-content">مطور برمجيات يبني <span class="text-accent">تجارب رقمية</span> حديثة</span><span class="en-content">Software Developer Building Modern <span class="text-accent">Digital Experiences</span></span></h1><p class="text-lg text-muted mb-8"><span class="ar-content"><?= htmlspecialchars($info['job_title_ar'] ?? '') ?></span><span class="en-content"><?= htmlspecialchars($info['job_title_en'] ?? '') ?></span></p><a href="#projects" class="btn-primary"><span class="ar-content">شاهد أعمالي</span><span class="en-content">View My Work</span></a></div><div class="flex justify-center items-center"><img id="header-image" src="<?= htmlspecialchars($info['image_url'] ?? 'https://placehold.co/400x400/?text=Image') ?>" class="rounded-full w-64 h-64 lg:w-80 lg:h-80 object-cover z-10 relative"></div></div></section>
            <section id="services" class="py-20"><div class="container mx-auto px-6 text-center"><h2 class="text-3xl font-bold mb-12"><span class="ar-content">ماذا <span class="text-accent">أقدم</span></span><span class="en-content">What I <span class="text-accent">Offer</span></span></h2><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"><?php foreach($services as $service): ?><div class="card p-6 text-center"><div class="bg-accent-light text-accent rounded-full p-3 w-16 h-16 mx-auto mb-4 flex items-center justify-center"><i data-lucide="<?= htmlspecialchars($service['icon_name']) ?>" class="w-8 h-8"></i></div><h3 class="text-xl font-bold mb-2"><span class="ar-content"><?= htmlspecialchars($service['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($service['title_en']) ?></span></h3><p class="text-muted"><span class="ar-content"><?= htmlspecialchars($service['description_ar']) ?></span><span class="en-content"><?= htmlspecialchars($service['description_en']) ?></span></p></div><?php endforeach; ?></div></div></section>
            <section id="skills" class="py-20"><div class="container mx-auto px-6"><h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">المهارات <span class="text-accent">التقنية والشخصية</span></span><span class="en-content">Technical & Soft <span class="text-accent">Skills</span></span></h2><div class="grid grid-cols-1 lg:grid-cols-3 gap-8"><div class="lg:col-span-2"><h3 class="text-2xl font-bold mb-6 text-center lg:text-right ar-content">المهارات التقنية</h3><h3 class="text-2xl font-bold mb-6 text-center lg:text-left en-content">Technical Skills</h3><div class="grid grid-cols-1 sm:grid-cols-2 gap-6"><?php foreach($skills as $skill): ?><div class="card p-4"><div class="flex items-center gap-4"><div class="bg-accent-light text-accent rounded-lg p-2"><i data-lucide="<?= htmlspecialchars($skill['icon']) ?>" class="w-6 h-6"></i></div><div><h4 class="font-bold"><span class="ar-content"><?= htmlspecialchars($skill['category_ar']) ?></span><span class="en-content"><?= htmlspecialchars($skill['category_en']) ?></span></h4><p class="text-sm text-muted"><?= htmlspecialchars($skill['skills_list']) ?></p></div></div></div><?php endforeach; ?></div></div><div><h3 class="text-2xl font-bold mb-6 text-center lg:text-right ar-content">المهارات الشخصية</h3><h3 class="text-2xl font-bold mb-6 text-center lg:text-left en-content">Soft Skills</h3><div class="card p-6"><ul class="space-y-4"><?php foreach($soft_skills as $soft_skill): ?><li class="flex items-center gap-3"><i data-lucide="<?= htmlspecialchars($soft_skill['icon_name']) ?>" class="w-5 h-5 text-accent"></i><span><span class="ar-content"><?= htmlspecialchars($soft_skill['skill_ar']) ?></span><span class="en-content"><?= htmlspecialchars($soft_skill['skill_en']) ?></span></span></li><?php endforeach; ?></ul></div></div></div></div></section>
            <section id="experience" class="py-20"><div class="container mx-auto px-6"><h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">الخبرة <span class="text-accent">العملية</span></span><span class="en-content">Professional <span class="text-accent">Experience</span></span></h2><div class="space-y-8"><?php foreach($experiences as $exp): ?><div class="card p-6 grid md:grid-cols-3 gap-6"><div class="md:col-span-1"><h3 class="text-xl font-bold text-accent"><span class="ar-content"><?= htmlspecialchars($exp['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['title_en']) ?></span></h3><p class="font-semibold"><span class="ar-content"><?= htmlspecialchars($exp['company_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['company_en']) ?></span></p><p class="text-sm text-muted"><span class="ar-content"><?= htmlspecialchars($exp['period_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['period_en']) ?></span></p></div><div class="md:col-span-2 text-muted"><ul class="list-disc pr-5 space-y-1 ar-content"><?php foreach(explode("\n", trim($exp['description_ar'])) as $point): if(!empty($point)): ?><li><?= htmlspecialchars(trim($point)) ?></li><?php endif; endforeach; ?></ul><ul class="list-disc pl-5 space-y-1 en-content"><?php foreach(explode("\n", trim($exp['description_en'])) as $point): if(!empty($point)): ?><li><?= htmlspecialchars(trim($point)) ?></li><?php endif; endforeach; ?></ul></div></div><?php endforeach; ?></div></div></section>
            <section id="projects" class="py-20"><div class="container mx-auto px-6"><h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">مشاريع <span class="text-accent">مميزة</span></span><span class="en-content">Featured <span class="text-accent">Projects</span></span></h2><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"><?php foreach($projects as $proj): ?><div class="card flex flex-col p-0 overflow-hidden"><img src="<?= htmlspecialchars($proj['main_image_url'] ?? 'https://placehold.co/600x400/?text=Project') ?>" alt="Project Image" class="w-full h-48 object-cover"><div class="p-6 flex flex-col flex-grow"><h3 class="text-xl font-bold mb-2"><span class="ar-content"><?= htmlspecialchars($proj['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($proj['title_en']) ?></span></h3><p class="text-muted text-sm mb-4 flex-grow"><span class="ar-content"><?= htmlspecialchars($proj['description_ar']) ?></span><span class="en-content"><?= htmlspecialchars($proj['description_en']) ?></span></p><a href="#" class="btn-primary mt-auto self-start"><span class="ar-content">عرض المشروع</span><span class="en-content">View Project</span></a></div></div><?php endforeach; ?></div></div></section>
            
            <!-- ====== قسم التعليم (معدّل) ====== -->
            <section id="education" class="py-20">
                <div class="container mx-auto px-6">
                    <h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">المسار <span class="text-accent">التعليمي</span></span><span class="en-content">Educational <span class="text-accent">Path</span></span></h2>
                    <div class="max-w-2xl mx-auto space-y-8">
                        <?php foreach($educations as $edu): ?>
                        <div class="card p-6">
                            <div class="flex items-center gap-4">
                                <i data-lucide="graduation-cap" class="w-12 h-12 text-accent flex-shrink-0"></i>
                                <div>
                                    <p class="font-bold text-lg"><span class="ar-content"><?= htmlspecialchars($edu['degree_ar']) ?></span><span class="en-content"><?= htmlspecialchars($edu['degree_en']) ?></span></p>
                                    <p class="text-muted"><span class="ar-content"><?= htmlspecialchars($edu['university_ar']) ?></span><span class="en-content"><?= htmlspecialchars($edu['university_en']) ?></span></p>
                                    <p class="text-sm text-muted"><span class="ar-content"><?= htmlspecialchars($edu['graduation_year_ar']) ?></span><span class="en-content"><?= htmlspecialchars($edu['graduation_year_en']) ?></span></p>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>

            <section id="certificates" class="py-20"><div class="container mx-auto px-6"><h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">الشهادات <span class="text-accent">الاحترافية</span></span><span class="en-content">Professional <span class="text-accent">Certificates</span></span></h2><div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"><?php foreach($certificates as $cert): ?><div class="card p-6"><div class="flex items-start gap-4"><i data-lucide="award" class="w-8 h-8 text-accent flex-shrink-0 mt-1"></i><div><p class="font-semibold"><span class="ar-content"><?= htmlspecialchars($cert['name_ar']) ?></span><span class="en-content"><?= htmlspecialchars($cert['name_en']) ?></span></p><p class="text-sm text-muted"><span class="ar-content"><?= htmlspecialchars($cert['issuer_ar']) ?></span><span class="en-content"><?= htmlspecialchars($cert['issuer_en']) ?></span></p></div></div></div><?php endforeach; ?></div></div></section>
        </main>
        <footer class="header-section pt-12"><div class="container mx-auto px-6 text-center"><h2 class="text-3xl font-bold mb-2"><span class="ar-content">لنتحدث عن مشروعك القادم</span><span class="en-content">Let's Talk About Your Next Project</span></h2><p class="text-muted mb-6"><span class="ar-content">أنا متحمس دائمًا لاستكشاف أفكار جديدة.</span><span class="en-content">Always excited to explore new ideas.</span></p><a href="mailto:<?= htmlspecialchars($info['email'] ?? '') ?>" class="btn-primary mb-12"><i data-lucide="mail" class="w-5 h-5"></i><span class="mx-2"><?= htmlspecialchars($info['email'] ?? '') ?></span></a><div class="border-t border-gray-700 py-4 text-sm text-gray-400"><p>&copy; <span id="copyright-year-website"></span> <?= htmlspecialchars($info['full_name_en'] ?? '') ?>. All rights reserved.</p></div></div></footer>
    </div>
    
    <!-- =========== الواجهة الثانية: تصميم السيرة الذاتية (Resume View) =========== -->
    <div id="resume-view-wrapper" class="hidden-view">
        <div class="resume-container">
            <header class="resume-header">
                <img src="<?= htmlspecialchars($info['image_url'] ?? 'https://placehold.co/400x400/?text=Image') ?>" alt="Profile Picture">
                <h1><span class="ar-content"><?= htmlspecialchars($info['full_name_ar'] ?? '') ?></span><span class="en-content"><?= htmlspecialchars($info['full_name_en'] ?? '') ?></span></h1>
                <div class="job-title"><span class="ar-content"><?= htmlspecialchars($info['job_title_ar'] ?? '') ?></span><span class="en-content"><?= htmlspecialchars($info['job_title_en'] ?? '') ?></span></div>
                <div class="resume-contact-info">
                    <div><i data-lucide="mail" class="w-4 h-4"></i><span><?= htmlspecialchars($info['email'] ?? '') ?></span></div>
                    <div><i data-lucide="map-pin" class="w-4 h-4"></i><span><span class="ar-content"><?= htmlspecialchars($info['location_ar'] ?? '') ?></span><span class="en-content"><?= htmlspecialchars($info['location_en'] ?? '') ?></span></span></div>
                    <div><i data-lucide="phone" class="w-4 h-4"></i><span><?= htmlspecialchars($info['phone'] ?? '') ?></span></div>
                </div>
            </header>
            <div class="resume-body">
                <div class="resume-main-content">
                    <section class="resume-section"><h2 class="ar-content">عني</h2><h2 class="en-content">About me</h2><p class="leading-relaxed text-muted"><span class="ar-content"><?= htmlspecialchars($info['about_me_ar'] ?? '') ?></span><span class="en-content"><?= htmlspecialchars($info['about_me_en'] ?? '') ?></span></p></section>
                    <section class="resume-section mt-8"><h2 class="ar-content">الخبرة</h2><h2 class="en-content">Experience</h2><?php foreach($experiences as $exp): ?><div class="item-list-item"><h3 class="font-bold text-lg"><span class="ar-content"><?= htmlspecialchars($exp['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['title_en']) ?></span></h3><p class="font-semibold text-muted"><span class="ar-content"><?= htmlspecialchars($exp['company_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['company_en']) ?></span></p></div><?php endforeach; ?></section>
                    <section class="resume-section mt-8"><h2 class="ar-content">المشاريع</h2><h2 class="en-content">Projects</h2><?php foreach($projects as $proj): ?><div class="item-list-item"><h3 class="font-bold text-lg"><span class="ar-content"><?= htmlspecialchars($proj['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($proj['title_en']) ?></span></h3><p class="text-sm text-muted"><span class="ar-content"><?= htmlspecialchars($proj['description_ar']) ?></span><span class="en-content"><?= htmlspecialchars($proj['description_en']) ?></span></p></div><?php endforeach; ?></section>
                    <section class="resume-section mt-8"><h2 class="ar-content">الشهادات</h2><h2 class="en-content">Certificates</h2><?php foreach($certificates as $cert): ?><div class="item-list-item"><h3 class="font-bold text-lg"><span class="ar-content"><?= htmlspecialchars($cert['name_ar']) ?></span><span class="en-content"><?= htmlspecialchars($cert['name_en']) ?></span></h3><p class="text-sm text-muted"><span class="ar-content"><?= htmlspecialchars($cert['issuer_ar']) ?></span><span class="en-content"><?= htmlspecialchars($cert['issuer_en']) ?></span></p></div><?php endforeach; ?></section>
              
                </div>
                <div class="resume-sidebar">
                     <!-- ====== قسم التعليم (معدّل) ====== -->
                     <section class="resume-section"><h2 class="ar-content">التعليم</h2><h2 class="en-content">Education</h2>
                        <?php foreach($educations as $edu): ?>
                        <div class="item-list-item">
                            <h3 class="font-bold text-lg"><span class="ar-content"><?= htmlspecialchars($edu['degree_ar']) ?></span><span class="en-content"><?= htmlspecialchars($edu['degree_en']) ?></span></h3>
                            <p class="font-semibold text-muted">
                                <span class="ar-content"><?= htmlspecialchars($edu['university_ar']) ?></span><span class="en-content"><?= htmlspecialchars($edu['university_en']) ?></span>, 
                                <span class="ar-content"><?= htmlspecialchars($edu['graduation_year_ar']) ?></span><span class="en-content"><?= htmlspecialchars($edu['graduation_year_en']) ?></span>
                            </p>
                        </div>
                        <?php endforeach; ?>
                    </section>
                    <section class="resume-section mt-8"><h2 class="ar-content">المهارات التقنية</h2><h2 class="en-content">Technical Skills</h2><?php foreach($skills as $skill): ?><div class="skill-category mb-4"><h3><span class="ar-content"><?= htmlspecialchars($skill['category_ar']) ?></span><span class="en-content"><?= htmlspecialchars($skill['category_en']) ?></span></h3><div class="skills-pills"><?php foreach(explode(',', $skill['skills_list']) as $item): ?><span class="skill-pill"><?= htmlspecialchars(trim($item)) ?></span><?php endforeach; ?></div></div><?php endforeach; ?></section>
                    <section class="resume-section mt-8"><h2 class="ar-content">المهارات الشخصية</h2><h2 class="en-content">Soft Skills</h2><div class="skills-pills"><?php foreach($soft_skills as $s_skill): ?><span class="skill-pill"><span class="ar-content"><?= htmlspecialchars($s_skill['skill_ar']) ?></span><span class="en-content"><?= htmlspecialchars($s_skill['skill_en']) ?></span></span><?php endforeach; ?></div></section>
               </div>
            </div>
        </div>
    </div>
    <script src="assets/js/lucide.min.js"></script>
    <script>
        document.getElementById('copyright-year-website').textContent = new Date().getFullYear();
        lucide.createIcons();
        const rootHtml = document.documentElement; const body = document.body; const langToggle = document.getElementById('lang-toggle');
        function applyLanguage(lang) {
            rootHtml.setAttribute('lang', lang); rootHtml.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
            langToggle.textContent = lang === 'ar' ? 'English' : 'العربية';
            document.title = document.querySelector('title').getAttribute(`data-${lang}`);
            document.querySelectorAll('#nav-links a').forEach(link => { link.textContent = link.getAttribute(`data-${lang}`); });
            document.getElementById('nav-links').classList.toggle('space-x-reverse', lang === 'ar');
            const heroContent = document.getElementById('hero-content');
            if(heroContent) { heroContent.style.textAlign = window.innerWidth < 768 ? 'center' : (lang === 'ar' ? 'right' : 'left'); }
        }
        langToggle.addEventListener('click', () => { const newLang = rootHtml.getAttribute('lang') === 'ar' ? 'en' : 'ar'; applyLanguage(newLang); localStorage.setItem('language', newLang); });
        window.addEventListener('resize', () => applyLanguage(rootHtml.getAttribute('lang')));
        const themeToggle = document.getElementById('theme-toggle');
        const updateThemeIcon = () => { themeToggle.innerHTML = body.classList.contains('dark-theme') ? '<i data-lucide="sun" class="w-5 h-5"></i>' : '<i data-lucide="moon" class="w-5 h-5"></i>'; lucide.createIcons(); };
        themeToggle.addEventListener('click', () => { body.classList.toggle('dark-theme'); localStorage.setItem('theme', body.classList.contains('dark-theme') ? 'dark' : 'light'); updateThemeIcon(); });
        const layoutToggle = document.getElementById('layout-toggle');
        const websiteView = document.getElementById('website-view');
        const resumeView = document.getElementById('resume-view-wrapper');
        const navLinks = document.getElementById('nav-links');
        function applyLayout(layout) {
            if (layout === 'resume') {
                websiteView.classList.add('hidden-view'); resumeView.classList.remove('hidden-view'); navLinks.classList.add('hidden-view');
                layoutToggle.innerHTML = '<i data-lucide="layout-list" class="w-5 h-5"></i>';
            } else {
                websiteView.classList.remove('hidden-view'); resumeView.classList.add('hidden-view'); navLinks.classList.remove('hidden-view');
                layoutToggle.innerHTML = '<i data-lucide="layout-grid" class="w-5 h-5"></i>';
            }
            lucide.createIcons();
        }
        layoutToggle.addEventListener('click', () => { const newLayout = resumeView.classList.contains('hidden-view') ? 'resume' : 'website'; applyLayout(newLayout); localStorage.setItem('layout', newLayout); });
        document.addEventListener('DOMContentLoaded', () => {
            const savedLang = localStorage.getItem('language') || 'ar'; applyLanguage(savedLang);
            const savedTheme = localStorage.getItem('theme'); if (savedTheme === 'dark') { body.classList.add('dark-theme'); } updateThemeIcon();
            const savedLayout = localStorage.getItem('layout') || 'website'; applyLayout(savedLayout);
        });
    </script>
</body>
</html>