<?php
require_once 'config/database.php';

// --- الخطوة 1: جلب جميع البيانات من قاعدة البيانات وتخزينها في مصفوفات ---
// هذا الأسلوب يحل مشكلة عدم ظهور البيانات ويجعل الكود أكثر تنظيمًا.

// دالة مساعدة لجلب كل النتائج كمصفوفة
function fetch_all_results($result) {
    $data = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    return $data;
}

// جلب المعلومات الشخصية
$info_result = $conn->query("SELECT * FROM personal_info LIMIT 1");
$info = $info_result ? $info_result->fetch_assoc() : [];

// جلب بيانات بقية الجداول وتخزينها في مصفوفات
$services = fetch_all_results($conn->query("SELECT * FROM services ORDER BY id ASC"));
$skills = fetch_all_results($conn->query("SELECT * FROM skills ORDER BY id ASC"));
$soft_skills = fetch_all_results($conn->query("SELECT * FROM soft_skills ORDER BY id ASC"));
$experiences = fetch_all_results($conn->query("SELECT * FROM experience ORDER BY id DESC"));
$projects = fetch_all_results($conn->query("SELECT * FROM projects ORDER BY id DESC"));
$education_result = $conn->query("SELECT * FROM education ORDER BY id DESC ");
$education = $education_result ? $education_result->fetch_assoc() : null;
$certificates = fetch_all_results($conn->query("SELECT * FROM certificates ORDER BY id DESC"));
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title data-ar="طارق القديمي - مطور برمجيات" data-en="Tariq Alqudaimi - Software Developer">طارق القديمي - مطور برمجيات</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');
        :root { --dark-bg: #111827; --light-bg: #F9FAFB; --accent: #10B981; --accent-light: #A7F3D0; --text-dark: #1F2937; --text-light: #D1D5DB; }
        html { scroll-behavior: smooth; }
        body[lang='ar'] { font-family: 'Tajawal', sans-serif; }
        body[lang='en'] { font-family: 'Inter', sans-serif; }
        body { background-color: var(--light-bg); color: var(--text-dark); }
        .dark-section { background-color: var(--dark-bg); color: white; }
        .text-accent { color: var(--accent); }
        .card { background-color: white; border-radius: 0.75rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); transition: transform 0.3s, box-shadow 0.3s; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 600; transition: background-color 0.3s; }
        .btn-primary { background-color: var(--accent); color: white; }
        .btn-primary:hover { background-color: #059669; }
        .ar-content, .en-content { display: none; }
        html[lang="ar"] .ar-content { display: block; }
        html[lang="en"] .en-content { display: block; }
        html[lang="ar"] span.ar-content, html[lang="en"] span.en-content { display: inline; }
    </style>
</head>
<body lang="ar">

    <!-- =========== HEADER =========== -->
    <header class="dark-section sticky top-0 z-50 shadow-lg">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-2xl font-bold"><a href="#home">T<span class="text-accent">A</span>RIQ</a></div>
            <div class="hidden md:flex items-center space-x-6" id="nav-links">
                <a href="#services" class="hover:text-accent transition-colors" data-ar="الخدمات" data-en="Services"></a>
                <a href="#skills" class="hover:text-accent transition-colors" data-ar="المهارات" data-en="Skills"></a>
                <a href="#experience" class="hover:text-accent transition-colors" data-ar="الخبرة" data-en="Experience"></a>
                <a href="#projects" class="hover:text-accent transition-colors" data-ar="المشاريع" data-en="Case Studies"></a>
                <a href="#education" class="hover:text-accent transition-colors" data-ar="التعليم" data-en="Education"></a>
                <a href="#certificates" class="hover:text-accent transition-colors" data-ar="الشهادات" data-en="Certificates"></a>
            </div>
            <button id="lang-toggle" class="btn btn-primary">English</button>
        </nav>
    </header>

    <main>
        <!-- =========== HERO SECTION =========== -->
        <section id="home" class="dark-section pt-16 pb-24">
            <div class="container mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
                <div id="hero-content" class="text-center md:text-right">
                    <h1 class="text-4xl lg:text-5xl font-extrabold leading-tight mb-4">
                        <span class="ar-content">مطور برمجيات يبني <span class="text-accent">تجارب رقمية</span> حديثة</span>
                        <span class="en-content">Software Developer Building Modern <span class="text-accent">Digital Experiences</span></span>
                    </h1>
                    <p class="text-lg text-text-light mb-8">
                        <span class="ar-content"><?= htmlspecialchars($info['job_title_ar'] ?? '') ?></span>
                        <span class="en-content"><?= htmlspecialchars($info['job_title_en'] ?? '') ?></span>
                    </p>
                    <a href="#experience" class="btn btn-primary">
                        <span class="ar-content">شاهد أعمالي</span><span class="en-content">View My Work</span>
                    </a>
                </div>
                <div class="flex justify-center items-center"><div class="relative">
                    <img src="https://placehold.co/400x400/1F2937/FFFFFF?text=Tariq" class="rounded-full w-64 h-64 lg:w-80 lg:h-80 object-cover z-10 relative border-4 border-gray-700">
                    <div id="hero-accent-box" class="absolute -top-4 w-24 h-24 bg-accent rounded-lg -z-10"></div>
                </div></div>
            </div>
        </section>
        
        <!-- =========== SERVICES SECTION =========== -->
        <section id="services" class="py-20">
            <div class="container mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold mb-12"><span class="ar-content">ماذا <span class="text-accent">أقدم</span></span><span class="en-content">What I <span class="text-accent">Offer</span></span></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach($services as $service): ?>
                    <div class="card p-6 text-center">
                        <div class="bg-accent-light text-accent rounded-full p-3 w-16 h-16 mx-auto mb-4 flex items-center justify-center"><i data-lucide="<?= htmlspecialchars($service['icon_name']) ?>" class="w-8 h-8"></i></div>
                        <h3 class="text-xl font-bold mb-2">
                            <span class="ar-content"><?= htmlspecialchars($service['title_ar']) ?></span>
                            <span class="en-content"><?= htmlspecialchars($service['title_en']) ?></span>
                        </h3>
                        <p class="text-gray-500">
                            <span class="ar-content"><?= htmlspecialchars($service['description_ar']) ?></span>
                            <span class="en-content"><?= htmlspecialchars($service['description_en']) ?></span>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- =========== SKILLS SECTION =========== -->
        <section id="skills" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">المهارات <span class="text-accent">التقنية والشخصية</span></span><span class="en-content">Technical & Soft <span class="text-accent">Skills</span></span></h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2">
                        <h3 class="text-2xl font-bold mb-6 text-center lg:text-right ar-content">المهارات التقنية</h3>
                        <h3 class="text-2xl font-bold mb-6 text-center lg:text-left en-content">Technical Skills</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <?php foreach($skills as $skill): ?>
                            <div class="card p-4">
                                <div class="flex items-center gap-4">
                                    <div class="bg-accent-light text-accent rounded-lg p-2"><i data-lucide="<?= htmlspecialchars($skill['icon']) ?>" class="w-6 h-6"></i></div>
                                    <div>
                                        <h4 class="font-bold"><span class="ar-content"><?= htmlspecialchars($skill['category_ar']) ?></span><span class="en-content"><?= htmlspecialchars($skill['category_en']) ?></span></h4>
                                        <p class="text-sm text-gray-500"><?= htmlspecialchars($skill['skills_list']) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold mb-6 text-center lg:text-right ar-content">المهارات الشخصية</h3>
                        <h3 class="text-2xl font-bold mb-6 text-center lg:text-left en-content">Soft Skills</h3>
                        <div class="card p-6">
                            <ul class="space-y-4">
                                <?php foreach($soft_skills as $soft_skill): ?>
                                <li class="flex items-center gap-3">
                                    <i data-lucide="<?= htmlspecialchars($soft_skill['icon_name']) ?>" class="w-5 h-5 text-accent"></i>
                                    <span>
                                        <span class="ar-content"><?= htmlspecialchars($soft_skill['skill_ar']) ?></span>
                                        <span class="en-content"><?= htmlspecialchars($soft_skill['skill_en']) ?></span>
                                    </span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- =========== EXPERIENCE SECTION =========== -->
        <section id="experience" class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">الخبرة <span class="text-accent">العملية</span></span><span class="en-content">Professional <span class="text-accent">Experience</span></span></h2>
                <div class="space-y-8">
                    <?php foreach($experiences as $exp): ?>
                    <div class="card p-6 grid md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-xl font-bold text-accent"><span class="ar-content"><?= htmlspecialchars($exp['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['title_en']) ?></span></h3>
                            <p class="font-semibold"><span class="ar-content"><?= htmlspecialchars($exp['company_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['company_en']) ?></span></p>
                            <p class="text-sm text-gray-500"><span class="ar-content"><?= htmlspecialchars($exp['period_ar']) ?></span><span class="en-content"><?= htmlspecialchars($exp['period_en']) ?></span></p>
                        </div>
                        <div class="md:col-span-2">
                            <ul class="list-disc pr-5 space-y-1 text-gray-600 ar-content">
                                <?php foreach(explode("\n", trim($exp['description_ar'])) as $point): if(!empty($point)): ?><li><?= htmlspecialchars(trim($point)) ?></li><?php endif; endforeach; ?>
                            </ul>
                            <ul class="list-disc pl-5 space-y-1 text-gray-600 en-content">
                                <?php foreach(explode("\n", trim($exp['description_en'])) as $point): if(!empty($point)): ?><li><?= htmlspecialchars(trim($point)) ?></li><?php endif; endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- =========== PROJECTS / CASE STUDIES SECTION =========== -->
        <section id="projects" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">دراسات حالة <span class="text-accent">لمشاريعي</span></span><span class="en-content">Project <span class="text-accent">Case Studies</span></span></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach($projects as $proj): ?>
                    <div class="card flex flex-col p-0 overflow-hidden">
                        <img src="<?= htmlspecialchars($proj['main_image_url'] ?? 'https://placehold.co/600x400/111827/FFFFFF?text=Project') ?>" alt="Project Image" class="w-full h-48 object-cover">
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold mb-2"><span class="ar-content"><?= htmlspecialchars($proj['title_ar']) ?></span><span class="en-content"><?= htmlspecialchars($proj['title_en']) ?></span></h3>
                            <p class="text-gray-600 text-sm mb-4 flex-grow"><span class="ar-content"><?= htmlspecialchars($proj['description_ar']) ?></span><span class="en-content"><?= htmlspecialchars($proj['description_en']) ?></span></p>
                            <button class="btn btn-primary mt-auto self-start"><span class="ar-content">عرض دراسة الحالة</span><span class="en-content">View Case Study</span></button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        
        <!-- =========== EDUCATION SECTION =========== -->
        <section id="education" class="py-20">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">المسار <span class="text-accent">التعليمي</span></span><span class="en-content">Educational <span class="text-accent">Path</span></span></h2>
                <?php if($education): ?>
                <div class="card max-w-2xl mx-auto p-6">
                    <div class="flex items-center gap-4">
                        <i data-lucide="graduation-cap" class="w-12 h-12 text-accent flex-shrink-0"></i>
                        <div>
                            <p class="font-bold text-lg"><span class="ar-content"><?= htmlspecialchars($education['degree_ar']) ?></span><span class="en-content"><?= htmlspecialchars($education['degree_en']) ?></span></p>
                            <p class="text-gray-700"><span class="ar-content"><?= htmlspecialchars($education['university_ar']) ?></span><span class="en-content"><?= htmlspecialchars($education['university_en']) ?></span></p>
                            <p class="text-sm text-gray-500"><span class="ar-content"><?= htmlspecialchars($education['graduation_year_ar']) ?></span><span class="en-content"><?= htmlspecialchars($education['graduation_year_en']) ?></span></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- =========== CERTIFICATES SECTION =========== -->
        <section id="certificates" class="py-20 bg-white">
            <div class="container mx-auto px-6">
                <h2 class="text-3xl font-bold mb-12 text-center"><span class="ar-content">الشهادات <span class="text-accent">الاحترافية</span></span><span class="en-content">Professional <span class="text-accent">Certificates</span></span></h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach($certificates as $cert): ?>
                    <div class="card p-6">
                        <div class="flex items-start gap-4">
                            <i data-lucide="award" class="w-8 h-8 text-accent flex-shrink-0 mt-1"></i>
                            <div>
                                <p class="font-semibold"><span class="ar-content"><?= htmlspecialchars($cert['name_ar']) ?></span><span class="en-content"><?= htmlspecialchars($cert['name_en']) ?></span></p>
                                <p class="text-sm text-gray-500"><span class="ar-content"><?= htmlspecialchars($cert['issuer_ar']) ?></span><span class="en-content"><?= htmlspecialchars($cert['issuer_en']) ?></span></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

    </main>

    <!-- =========== FOOTER =========== -->
    <footer class="dark-section pt-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold mb-2"><span class="ar-content">لنتحدث عن مشروعك القادم</span><span class="en-content">Let's Talk About Your Next Project</span></h2>
            <p class="text-text-light mb-6"><span class="ar-content">أنا متحمس دائمًا لاستكشاف أفكار جديدة.</span><span class="en-content">Always excited to explore new ideas.</span></p>
            <a href="mailto:<?= htmlspecialchars($info['email'] ?? '') ?>" class="btn btn-primary mb-12">
                <i data-lucide="mail" class="w-5 h-5"></i><span class="mx-2"><?= htmlspecialchars($info['email'] ?? '') ?></span>
            </a>
            <div class="border-t border-gray-700 py-4 text-sm text-gray-400">
                 <p>&copy; <span id="copyright-year"></span> Tariq Alqudaimi. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    <script>
        lucide.createIcons();
        document.getElementById('copyright-year').textContent = new Date().getFullYear();
        const langToggle = document.getElementById('lang-toggle');
        const rootHtml = document.documentElement;

        function applyLanguage(lang) {
            rootHtml.setAttribute('lang', lang);
            rootHtml.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
            langToggle.textContent = lang === 'ar' ? 'English' : 'العربية';
            document.title = document.querySelector('title').getAttribute(`data-${lang}`);
            document.querySelectorAll('#nav-links a').forEach(link => { link.textContent = link.getAttribute(`data-${lang}`); });
            const navLinks = document.getElementById('nav-links');
            navLinks.classList.toggle('space-x-reverse', lang === 'ar');
            const heroContent = document.getElementById('hero-content');
            const isMobile = window.innerWidth < 768;
            heroContent.style.textAlign = isMobile ? 'center' : (lang === 'ar' ? 'right' : 'left');
            const heroAccentBox = document.getElementById('hero-accent-box');
            heroAccentBox.style.right = lang === 'ar' ? '-1rem' : 'auto';
            heroAccentBox.style.left = lang === 'ar' ? 'auto' : '-1rem';
        }
        langToggle.addEventListener('click', () => {
            const newLang = rootHtml.getAttribute('lang') === 'ar' ? 'en' : 'ar';
            applyLanguage(newLang);
        });
        window.addEventListener('resize', () => { applyLanguage(rootHtml.getAttribute('lang')); });
        document.addEventListener('DOMContentLoaded', () => { applyLanguage('ar'); });
    </script>
</body>
</html>

