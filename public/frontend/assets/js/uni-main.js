document.addEventListener('DOMContentLoaded', () => {
  const themeToggleButtons = document.querySelectorAll('.theme-toggle');
  const htmlTag = document.documentElement;
  
  const savedTheme = localStorage.getItem('uni_theme') || 'dark';
  htmlTag.setAttribute('data-theme', savedTheme);
  updateThemeIcons(savedTheme);

  themeToggleButtons.forEach(btn => {
    btn.addEventListener('click', () => {
      const currentTheme = htmlTag.getAttribute('data-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      htmlTag.setAttribute('data-theme', newTheme);
      localStorage.setItem('uni_theme', newTheme);
      updateThemeIcons(newTheme);
    });
  });

  function updateThemeIcons(theme) {
    themeToggleButtons.forEach(btn => {
      btn.innerHTML = theme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
    });
  }

  initTypingAnimation();
  initCounters();
  initScrollAnimations();
  initBackToTop();
  initHeroCarousel();

  if(document.getElementById('colleges-container') && !document.getElementById('colleges-container').dataset.ssr) {
    renderColleges();
  }
  
  if(document.getElementById('all-colleges-container') && !document.getElementById('all-colleges-container').dataset.ssr) {
    initCollegesPage();
  }

  if(document.getElementById('departments-container')) {
    initDepartmentsPage();
  }

  if(document.getElementById('programs-container') && !document.getElementById('programs-container').dataset.ssr) {
    initProgramsPage();
  }

  if(document.getElementById('news-container')) {
    renderNews();
  }

  if(document.getElementById('research-container') && !document.getElementById('research-container').dataset.ssr) {
    renderResearch();
  }

  if(document.getElementById('library-container') && document.getElementById('library-container').dataset.ssr) {
    initLibraryPage();
  }

  if(document.getElementById('contact-form')) {
    initContactForm();
  }

  if(document.getElementById('admission-form') && document.getElementById('admission-form').method !== 'post') {
    initAdmissionForm();
  }

  if(document.getElementById('collegeDetailContent') && !document.getElementById('collegeDetailContent').dataset.ssr) {
    initCollegeDetailPage();
  }

  if(document.getElementById('faculty-container') && !document.getElementById('faculty-container').dataset.ssr) {
    initFacultyPage();
  }

  if(document.getElementById('events-container')) {
    initEventsPage();
  }

  if(document.getElementById('eventDetailContent')) {
    initEventDetailPage();
  }

  if(document.getElementById('faq-accordion')) {
    initFaqPage();
  }

  if(document.getElementById('scholarships-container')) {
    initScholarshipsPage();
  }

  if(document.getElementById('tuition-container')) {
    initTuitionPage();
  }

  if(document.getElementById('services-container')) {
    initStudentServicesPage();
  }

  if(document.getElementById('calendar-container')) {
    initCalendarPage();
  }

  if(document.getElementById('staff-leadership-container') && !document.getElementById('staff-leadership-container').dataset.ssr) {
    initStaffPage();
  }

  if(document.getElementById('researchDetailContent') && !document.getElementById('researchDetailContent').dataset.ssr) {
    initResearchDetailPage();
  }

  if(document.getElementById('privacy-sections')) {
    initPrivacyPage();
  }

  if(document.getElementById('terms-sections')) {
    initTermsPage();
  }

  initSsrCollegeFilters();
  initSsrProgramFilters();
});

function initHeroCarousel() {
  const el = document.querySelector('.hero-swiper');
  if (!el || typeof Swiper === 'undefined') return;

  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const autoplayDelay = 8000;

  const swiper = new Swiper('.hero-swiper', {
    effect: 'fade',
    fadeEffect: { crossFade: true },
    loop: true,
    speed: 1400,
    autoplay: reducedMotion ? false : {
      delay: autoplayDelay,
      disableOnInteraction: false,
      pauseOnMouseEnter: true
    },
    pagination: {
      el: '.hero-pagination',
      clickable: true
    },
    navigation: {
      nextEl: '.hero-next',
      prevEl: '.hero-prev'
    },
    on: {
      slideChangeTransitionStart() {
        const content = el.querySelector('.swiper-slide-active .hero-cinematic-content');
        if (content) {
          content.querySelectorAll('*').forEach(child => {
            child.style.animation = 'none';
            child.offsetHeight;
            child.style.animation = '';
          });
        }
      }
    }
  });

  initHeroProgress(swiper, autoplayDelay, reducedMotion);
  initHeroSlideCounter(swiper);

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
      swiper.autoplay.stop();
    } else if (!reducedMotion) {
      swiper.autoplay.start();
    }
  });
}

function initHeroSlideCounter(swiper) {
  const currentEl = document.querySelector('.hero-slide-counter__current');
  const totalEl = document.querySelector('.hero-slide-counter__total');
  if (!currentEl || !totalEl) return;

  const total = swiper.slides.filter(slide => !slide.classList.contains('swiper-slide-duplicate')).length;
  totalEl.textContent = String(total).padStart(2, '0');

  function updateCounter() {
    currentEl.textContent = String(swiper.realIndex + 1).padStart(2, '0');
  }

  updateCounter();
  swiper.on('slideChange', updateCounter);
}

function initHeroProgress(swiper, delay, reducedMotion) {
  const fill = document.querySelector('.hero-progress-fill');
  const heroCarousel = document.querySelector('.hero-carousel');
  if (!fill || reducedMotion) return;

  let rafId = null;
  let startTime = null;
  let paused = false;
  let pausedAt = 0;
  let elapsedBeforePause = 0;

  function resetProgress() {
    fill.style.transition = 'none';
    fill.style.width = '0%';
    fill.offsetHeight;
    fill.style.transition = 'width 0.05s linear';
    startTime = null;
    elapsedBeforePause = 0;
    paused = false;
  }

  function tick(timestamp) {
    if (paused) {
      rafId = requestAnimationFrame(tick);
      return;
    }
    if (!startTime) startTime = timestamp;
    const elapsed = elapsedBeforePause + (timestamp - startTime);
    const pct = Math.min((elapsed / delay) * 100, 100);
    fill.style.width = pct + '%';
    if (pct < 100) {
      rafId = requestAnimationFrame(tick);
    }
  }

  function startProgress() {
    cancelAnimationFrame(rafId);
    resetProgress();
    rafId = requestAnimationFrame(tick);
  }

  function pauseProgress() {
    if (paused) return;
    paused = true;
    elapsedBeforePause += performance.now() - (startTime || performance.now());
  }

  function resumeProgress() {
    if (!paused) return;
    paused = false;
    startTime = performance.now();
    cancelAnimationFrame(rafId);
    rafId = requestAnimationFrame(tick);
  }

  swiper.on('slideChangeTransitionStart', startProgress);
  swiper.on('autoplayStart', startProgress);
  startProgress();

  if (heroCarousel) {
    heroCarousel.addEventListener('mouseenter', pauseProgress);
    heroCarousel.addEventListener('mouseleave', resumeProgress);
  }
}

// ============================================
// University Data
// ============================================
const collegeImages = [
  'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&q=80',
  'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=400&q=80',
  'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=400&q=80',
  'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&q=80',
  'https://images.unsplash.com/photo-1532094349884-543bc11b2345?w=400&q=80',
  'https://images.unsplash.com/photo-1587854692152-cf800784e7f0?w=400&q=80',
  'https://images.unsplash.com/photo-1606811841689-23dfddce3e95?w=400&q=80',
  'https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=400&q=80',
  'https://images.unsplash.com/photo-1589829545855-d10d557cf95f?w=400&q=80',
  'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=400&q=80',
  'https://images.unsplash.com/photo-1456513080510-7bf3a84b82f8?w=400&q=80',
  'https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&q=80'
];

const collegesData = [
  { id: 1, name: 'كلية الهندسة', icon: 'fa-gears', desc: 'برامج في الهندسة المدنية والمعمارية والميكانيكية والكهربائية', depts: 5, programs: 12 },
  { id: 2, name: 'كلية الطب', icon: 'fa-stethoscope', desc: 'إعداد أطباء متميزين في مختلف التخصصات الطبية', depts: 8, programs: 15 },
  { id: 3, name: 'كلية إدارة الأعمال', icon: 'fa-chart-line', desc: 'برامج في الإدارة والمحاسبة والاقتصاد والتسويق', depts: 4, programs: 10 },
  { id: 4, name: 'كلية علوم الحاسب', icon: 'fa-laptop-code', desc: 'تخصصات في البرمجة والذكاء الاصطناعي وأمن المعلومات', depts: 4, programs: 9 },
  { id: 5, name: 'كلية العلوم', icon: 'fa-flask', desc: 'الفيزياء والكيمياء والأحياء والرياضيات التطبيقية', depts: 5, programs: 11 },
  { id: 6, name: 'كلية الصيدلة', icon: 'fa-pills', desc: 'إعداد صيادلة مؤهلين في مجالات الصناعة والبحث السريري', depts: 3, programs: 6 },
  { id: 7, name: 'كلية طب الأسنان', icon: 'fa-tooth', desc: 'تعليم متطور في علوم الفم والأسنان والتقويم', depts: 4, programs: 7 },
  { id: 8, name: 'كلية التربية', icon: 'fa-chalkboard-user', desc: 'إعداد معلمين متخصصين في مختلف المراحل التعليمية', depts: 6, programs: 14 },
  { id: 9, name: 'كلية الحقوق', icon: 'fa-scale-balanced', desc: 'دراسات قانونية متعمقة في الأنظمة المحلية والدولية', depts: 3, programs: 8 },
  { id: 10, name: 'كلية العمارة', icon: 'fa-building', desc: 'تصميم معماري مبتكر وتخطيط حضري مستدام', depts: 3, programs: 6 },
  { id: 11, name: 'كلية اللغات', icon: 'fa-language', desc: 'اللغة الإنجليزية والترجمة واللغات التطبيقية', depts: 4, programs: 9 },
  { id: 12, name: 'كلية التصاميم', icon: 'fa-palette', desc: 'التصميم الجرافيكي والأزياء والديكور الداخلي', depts: 3, programs: 7 }
];

const collegeDetailExtra = {
  1: { vision: 'ريادة في التعليم الهندسي والبحث التطبيقي المستدام.', mission: 'إعداد مهندسين مبتكرين يخدمون التنمية الوطنية بمعايير عالمية.', established: '1998', students: '3,500+', building: 'مبنى الهندسة', accreditation: 'ABET', deanStaffId: 4, deanName: 'د. نورة القحطاني' },
  2: { vision: 'تميز في التعليم الطبي والبحث السريري.', mission: 'تخريج أطباء مؤهلين يرتكزون على الرعاية الإنسانية والابتكار.', established: '2001', students: '2,800+', building: 'مبنى كلية الطب', accreditation: 'NCAA', deanStaffId: 5, deanName: 'أ.د. خالد الدوسري' },
  3: { vision: 'إعداد قادة أعمال ورواد ينافسون عالمياً.', mission: 'تقديم تعليم إداري يربط النظرية بالممارسة وسوق العمل.', established: '2000', students: '4,200+', building: 'مبنى إدارة الأعمال', accreditation: 'AACSB', deanStaffId: 7, deanName: 'أ.د. أحمد الحربي' },
  4: { vision: 'الريادة في علوم الحاسب والذكاء الاصطناعي.', mission: 'بناء كفاءات تقنية تدعم الاقتصاد الرقمي والتحول الوطني.', established: '2005', students: '5,100+', building: 'مبنى علوم الحاسب', accreditation: 'ABET', deanStaffId: 6, deanName: 'د. سارة الشمري' },
  5: { vision: 'تطوير المعرفة العلمية الأساسية والتطبيقية.', mission: 'إعداد باحثين وعلماء في العلوم الطبيعية والرياضيات.', established: '1999', students: '2,400+', building: 'مبنى العلوم', accreditation: 'NCAAA', deanStaffId: 9, deanName: 'أ.د. فهد المطيري' },
  6: { vision: 'التميز في الصيدلة السريرية والبحث الدوائي.', mission: 'تأهيل صيادلة يساهمون في رفع جودة الرعاية الصحية.', established: '2008', students: '1,600+', building: 'مبنى الصيدلة', accreditation: 'ACPE', deanStaffId: 8, deanName: 'د. منال العنزي' },
  7: { vision: 'تعليم طب أسنان متقدم يواكب أحدث التقنيات.', mission: 'إعداد أطباء أسنان متميزين في التشخيص والعلاج.', established: '2012', students: '900+', building: 'عيادات طب الأسنان', accreditation: 'CODA', deanStaffId: null, deanName: 'د. عبدالرحمن السبيعي' },
  8: { vision: 'إعداد معلمين ومربين وفق أفضل الممارسات العالمية.', mission: 'تطوير الكفايات التربوية والتعليمية للمعلمين.', established: '2003', students: '3,000+', building: 'مبنى التربية', accreditation: 'NCAAA', deanStaffId: 10, deanName: 'د. هند السبيعي' },
  9: { vision: 'إعداد قانونيين متميزين في القانون المحلي والدولي.', mission: 'تقديم تعليم قانوني يربط النظرية بالممارسة المهنية.', established: '2006', students: '1,800+', building: 'مبنى الحقوق', accreditation: 'NCAAA', deanStaffId: 11, deanName: 'أ.د. سلطان الرشيدي' },
  10: { vision: 'تصميم معماري مستدام يلبي احتياجات المجتمع.', mission: 'إعداد مهندسين معماريين ومخططين حضريين مبدعين.', established: '2010', students: '1,200+', building: 'استوديو العمارة', accreditation: 'NAAB', deanStaffId: 4, deanName: 'د. نورة القحطاني' },
  11: { vision: 'تعزيز التواصل اللغوي والترجمة في العصر الرقمي.', mission: 'تأهيل متخصصين في اللغات والترجمة والاتصال.', established: '2011', students: '1,400+', building: 'مبنى اللغات', accreditation: 'NCAAA', deanStaffId: null, deanName: 'د. لمى المالكي' },
  12: { vision: 'إبداع بصري يجمع بين الفن والتقنية.', mission: 'تخريج مصممين محترفين في مختلف مجالات التصميم.', established: '2014', students: '1,100+', building: 'مبنى التصاميم', accreditation: 'NASAD', deanStaffId: 12, deanName: 'د. ريم البلوي' }
};

const facultyData = [
  { id: 1, name: 'أ.د. يوسف الغامدي', title: 'أستاذ', collegeId: 1, college: 'كلية الهندسة', department: 'الهندسة المدنية', specialty: 'هندسة الزلازل والإنشاءات', icon: 'fa-user-tie' },
  { id: 2, name: 'د. مريم العتيبي', title: 'أستاذ مساعد', collegeId: 1, college: 'كلية الهندسة', department: 'الهندسة الكهربائية', specialty: 'أنظمة الطاقة المتجددة', icon: 'fa-user-tie' },
  { id: 3, name: 'أ.د. سعد المطيري', title: 'أستاذ', collegeId: 2, college: 'كلية الطب', department: 'قسم الجراحة', specialty: 'الجراحة العامة', icon: 'fa-user-tie' },
  { id: 4, name: 'د. ليلى الحربي', title: 'أستاذ مشارك', collegeId: 2, college: 'كلية الطب', department: 'قسم الباطنة', specialty: 'أمراض القلب', icon: 'fa-user-tie' },
  { id: 5, name: 'د. فيصل القحطاني', title: 'أستاذ مساعد', collegeId: 3, college: 'كلية إدارة الأعمال', department: 'قسم الإدارة', specialty: 'الإدارة الاستراتيجية', icon: 'fa-user-tie' },
  { id: 6, name: 'أ.د. رنا الشمري', title: 'أستاذ', collegeId: 4, college: 'كلية علوم الحاسب', department: 'الذكاء الاصطناعي', specialty: 'تعلم الآلة العميق', icon: 'fa-user-tie' },
  { id: 7, name: 'د. عمر الزهراني', title: 'أستاذ مساعد', collegeId: 4, college: 'كلية علوم الحاسب', department: 'أمن المعلومات', specialty: 'الأمن السيبراني', icon: 'fa-user-tie' },
  { id: 8, name: 'أ.د. نادية الدوسري', title: 'أستاذ', collegeId: 5, college: 'كلية العلوم', department: 'الفيزياء', specialty: 'الفيزياء التطبيقية', icon: 'fa-user-tie' },
  { id: 9, name: 'د. خالد العنزي', title: 'أستاذ مشارك', collegeId: 6, college: 'كلية الصيدلة', department: 'الكيمياء الصيدلية', specialty: 'تطوير الأدوية', icon: 'fa-user-tie' },
  { id: 10, name: 'د. هيفاء السعد', title: 'أستاذ مساعد', collegeId: 8, college: 'كلية التربية', department: 'المناهج وطرق التدريس', specialty: 'التعليم الرقمي', icon: 'fa-user-tie' },
  { id: 11, name: 'أ.د. تركي الرشيدي', title: 'أستاذ', collegeId: 9, college: 'كلية الحقوق', department: 'القانون الدولي', specialty: 'التحكيم التجاري', icon: 'fa-user-tie' },
  { id: 12, name: 'د. دانة البلوي', title: 'أستاذ مساعد', collegeId: 12, college: 'كلية التصاميم', department: 'التصميم الجرافيكي', specialty: 'الهوية البصرية', icon: 'fa-user-tie' },
  { id: 13, name: 'د. بدر الحازمي', title: 'أستاذ مشارك', collegeId: 1, college: 'كلية الهندسة', department: 'الهندسة الميكانيكية', specialty: 'ميكانيكا الموائع', icon: 'fa-user-tie' },
  { id: 14, name: 'د. سمية الفهد', title: 'أستاذ مساعد', collegeId: 4, college: 'كلية علوم الحاسب', department: 'علوم الحاسب', specialty: 'هندسة البرمجيات', icon: 'fa-user-tie' },
  { id: 15, name: 'أ.د. وليد العمري', title: 'أستاذ', collegeId: 3, college: 'كلية إدارة الأعمال', department: 'المحاسبة', specialty: 'التدقيق والمحاسبة المالية', icon: 'fa-user-tie' },
  { id: 16, name: 'د. جنى القحطاني', title: 'أستاذ مساعد', collegeId: 10, college: 'كلية العمارة', department: 'التصميم المعماري', specialty: 'العمارة المستدامة', icon: 'fa-user-tie' }
];

const eventsData = [
  { id: 1, title: 'المؤتمر الدولي للذكاء الاصطناعي', category: 'conference', categoryLabel: 'مؤتمر', date: { day: '20', month: 'أبريل' }, desc: 'مشاركة أكثر من 100 باحث من 30 دولة في أحدث أبحاث الذكاء الاصطناعي.', location: 'قاعة المؤتمرات الرئيسية', icon: 'fa-microphone' },
  { id: 2, title: 'معرض التوظيف السنوي', category: 'career', categoryLabel: 'توظيف', date: { day: '05', month: 'مايو' }, desc: 'فرصة للطلاب والخريجين للتواصل مع أكثر من 50 شركة رائدة.', location: 'مبنى الأنشطة الطلابية', icon: 'fa-briefcase' },
  { id: 3, title: 'ورشة عمل ريادة الأعمال', category: 'workshop', categoryLabel: 'ورشة', date: { day: '15', month: 'مايو' }, desc: 'تعلم أساسيات إنشاء وإدارة المشاريع الناشئة مع خبراء في المجال.', location: 'مركز الابتكار', icon: 'fa-lightbulb' },
  { id: 4, title: 'حفل التخرج السنوي', category: 'graduation', categoryLabel: 'تخرج', date: { day: '01', month: 'يونيو' }, desc: 'احتفال بتخريج دفعة 2026 من مختلف الكليات والتخصصات.', location: 'القاعة الكبرى', icon: 'fa-graduation-cap' },
  { id: 5, title: 'اليوم المفتوح للجامعة', category: 'open-day', categoryLabel: 'يوم مفتوح', date: { day: '12', month: 'يونيو' }, desc: 'تعرف على الكليات والبرامج والتجول في الحرم الجامعي مع مرشدين أكاديميين.', location: 'الحرم الجامعي الرئيسي', icon: 'fa-door-open' },
  { id: 6, title: 'ندوة الاستدامة والطاقة المتجددة', category: 'conference', categoryLabel: 'ندوة', date: { day: '25', month: 'يونيو' }, desc: 'نقاش علمي حول مستقبل الطاقة النظيفة في المملكة.', location: 'كلية الهندسة', icon: 'fa-leaf' },
  { id: 7, title: 'مسابقة البرمجة الجامعية', category: 'workshop', categoryLabel: 'مسابقة', date: { day: '08', month: 'يوليو' }, desc: 'تحدي برمجي لطلاب علوم الحاسب مع جوائز قيمة للفائزين.', location: 'مختبرات الحاسب', icon: 'fa-code' },
  { id: 8, title: 'أسبوع البحث العلمي', category: 'conference', categoryLabel: 'بحث', date: { day: '20', month: 'يوليو' }, desc: 'عرض أبرز مشاريع وأبحاث طلاب وأساتذة الجامعة.', location: 'مراكز الأبحاث', icon: 'fa-flask' }
];

const eventDetailExtra = {
  1: {
    fullDate: '20 أبريل 2026', time: '9:00 ص – 6:00 م', year: '2026',
    organizer: 'كلية علوم الحاسب — مركز الذكاء الاصطناعي',
    audience: 'باحثون، طلاب الدراسات العليا، أكاديميون',
    capacity: '500 مشارك', registration: true,
    longDesc: 'يستضيف المؤتمر نخبة من الباحثين والخبراء لمناقشة أحدث التطورات في الذكاء الاصطناعي وتعلم الآلة والرؤية الحاسوبية، مع جلسات عملية وورش تطبيقية ومعرض للمشاريع الطلابية.',
    agenda: [
      { time: '9:00 ص', title: 'كلمة افتتاحية وترحيب', speaker: 'رئيس الجامعة' },
      { time: '10:00 ص', title: 'محاضرة رئيسية: مستقبل الذكاء الاصطناعي', speaker: 'د. سارة الشمري' },
      { time: '12:00 م', title: 'جلسات علمية متوازية', speaker: '—' },
      { time: '2:00 م', title: 'ورشة تطبيقية: نماذج اللغة الكبيرة', speaker: 'د. عمر الزهراني' },
      { time: '4:30 م', title: 'حفل ختام وتوزيع شهادات', speaker: '—' }
    ],
    speakers: [
      { name: 'د. سارة الشمري', role: 'عميدة كلية علوم الحاسب' },
      { name: 'د. عمر الزهراني', role: 'أستاذ أمن المعلومات' },
      { name: 'أ.د. رنا الشمري', role: 'باحثة في تعلم الآلة' }
    ],
    stats: { speakers: 12, sessions: 8, countries: 30 }
  },
  2: {
    fullDate: '5 مايو 2026', time: '10:00 ص – 5:00 م', year: '2026',
    organizer: 'عمادة شؤون الطلاب — وحدة التوظيف',
    audience: 'طلاب وخريجو الجامعة',
    capacity: '800 زائر', registration: true,
    longDesc: 'معرض التوظيف السنوي يجمع أكثر من 50 شركة محلية ودولية من قطاعات متنوعة. يتضمن مقابلات فورية، ورش تحضيرية للسيرة الذاتية، وندوات حول سوق العمل.',
    agenda: [
      { time: '10:00 ص', title: 'افتتاح المعرض', speaker: 'عميد شؤون الطلاب' },
      { time: '10:30 ص', title: 'جولة في أجنحة الشركات', speaker: '—' },
      { time: '12:00 م', title: 'ورشة: بناء السيرة الذاتية', speaker: 'وحدة التوظيف' },
      { time: '2:00 م', title: 'مقابلات التوظيف', speaker: '—' },
      { time: '4:00 م', title: 'جلسة: مهارات المقابلة الشخصية', speaker: 'خبراء HR' }
    ],
    speakers: [
      { name: 'د. فيصل القحطاني', role: 'مستشار التوظيف' },
      { name: 'م. نورة العتيبي', role: 'مديرة الشراكات' }
    ],
    stats: { companies: 50, jobs: 200, workshops: 4 }
  },
  3: {
    fullDate: '15 مايو 2026', time: '2:00 م – 6:00 م', year: '2026',
    organizer: 'مركز الابتكار وريادة الأعمال',
    audience: 'طلاب جميع الكليات',
    capacity: '120 مشارك', registration: true,
    longDesc: 'ورشة عملية تغطي رحلة المشروع من الفكرة إلى النموذج الأولي، مع التركيز على نموذج العمل، التمويل، والتسويق الرقمي للشركات الناشئة.',
    agenda: [
      { time: '2:00 م', title: 'مقدمة في ريادة الأعمال', speaker: 'مدرب الورشة' },
      { time: '3:00 م', title: 'تمرين: نموذج العمل التجاري', speaker: '—' },
      { time: '4:30 م', title: 'عرض أفكار المشاريع', speaker: 'المشاركون' },
      { time: '5:30 م', title: 'ملخص وتوصيات', speaker: '—' }
    ],
    speakers: [
      { name: 'د. فيصل القحطاني', role: 'خبير إدارة استراتيجية' },
      { name: 'م. لمى الحربي', role: 'رائدة أعمال' }
    ],
    stats: { hours: 4, exercises: 3, mentors: 6 }
  },
  4: {
    fullDate: '1 يونيو 2026', time: '5:00 م – 9:00 م', year: '2026',
    organizer: 'عمادة شؤون الطلاب',
    audience: 'خريجو دفعة 2026 وعائلاتهم',
    capacity: '3,000 حاضر', registration: false,
    longDesc: 'احتفال رسمي بتخريج دفعة 2026 بحضور قيادات الجامعة وشركاء المجتمع. يتضمن مراسم التخريج، كلمة الخريجين، و حفل عشاء تكريمي.',
    agenda: [
      { time: '5:00 م', title: 'استقبال الخريجين والضيوف', speaker: '—' },
      { time: '6:00 م', title: 'مراسم التخريج الرسمية', speaker: 'رئيس الجامعة' },
      { time: '7:30 م', title: 'كلمة الخريجين', speaker: 'ممثل الدفعة' },
      { time: '8:30 م', title: 'حفل عشاء تكريمي', speaker: '—' }
    ],
    speakers: [
      { name: 'أ.د. خالد الدوسري', role: 'عميد كلية الطب' },
      { name: 'ممثل دفعة 2026', role: 'كلمة الخريجين' }
    ],
    stats: { graduates: 1200, colleges: 12, guests: 3000 }
  },
  5: {
    fullDate: '12 يونيو 2026', time: '9:00 ص – 3:00 م', year: '2026',
    organizer: 'عمادة القبول والتسجيل',
    audience: 'طلاب الثانوية وأولياء الأمور',
    capacity: '2000 زائر', registration: true,
    longDesc: 'فرصة لزيارة الحرم الجامعي والتعرف على الكليات والبرامج والمرافق. يشمل جولات إرشادية، لقاءات مع أساتذة، وعروضاً لأنشطة الطلاب.',
    agenda: [
      { time: '9:00 ص', title: 'تسجيل الوصول والترحيب', speaker: '—' },
      { time: '9:30 ص', title: 'عرض تعريفي عن الجامعة', speaker: 'عمادة القبول' },
      { time: '10:30 ص', title: 'جولات في الكليات', speaker: 'مرشدون أكاديميون' },
      { time: '12:00 م', title: 'جلسة أسئلة وأجوبة', speaker: '—' },
      { time: '1:00 م', title: 'زيارة المختبرات والمكتبة', speaker: '—' }
    ],
    speakers: [
      { name: 'د. منال العنزي', role: 'مسؤولة القبول' },
      { name: 'د. هند السبيعي', role: 'عميدة كلية التربية' }
    ],
    stats: { tours: 8, colleges: 12, guides: 40 }
  },
  6: {
    fullDate: '25 يونيو 2026', time: '11:00 ص – 2:00 م', year: '2026',
    organizer: 'كلية الهندسة — قسم الهندسة الكهربائية',
    audience: 'أكاديميون، طلاب، مهتمون',
    capacity: '300 مشارك', registration: true,
    longDesc: 'ندوة علمية تناقش تحول المملكة نحو الطاقة المتجددة، مع عرض مشاريع بحثية طلابية ومحاضرة من خبراء في مجال الطاقة النظيفة.',
    agenda: [
      { time: '11:00 ص', title: 'افتتاح الندوة', speaker: 'عميد كلية الهندسة' },
      { time: '11:30 ص', title: 'محاضرة: مستقبل الطاقة الشمسية', speaker: 'د. مريم العتيبي' },
      { time: '12:30 م', title: 'عرض مشاريع طلابية', speaker: '—' },
      { time: '1:30 م', title: 'نقاش مفتوح', speaker: '—' }
    ],
    speakers: [
      { name: 'د. مريم العتيبي', role: 'أستاذة الهندسة الكهربائية' },
      { name: 'د. بدر الحازمي', role: 'باحث ميكانيكا الموائع' }
    ],
    stats: { papers: 6, projects: 10, experts: 4 }
  },
  7: {
    fullDate: '8 يوليو 2026', time: '8:00 ص – 8:00 م', year: '2026',
    organizer: 'كلية علوم الحاسب — نادي البرمجة',
    audience: 'طلاب علوم الحاسب',
    capacity: '80 فريق', registration: true,
    longDesc: 'مسابقة برمجية لمدة 12 ساعة لحل تحديات خوارزمية وتطوير تطبيقات. جوائز للمراكز الثلاثة الأولى وفرص تدريب لدى شركات تقنية شريكة.',
    agenda: [
      { time: '8:00 ص', title: 'تسجيل الفرق وتوزيع التحديات', speaker: '—' },
      { time: '9:00 ص', title: 'بدء المسابقة', speaker: '—' },
      { time: '6:00 م', title: 'تسليم المشاريع', speaker: '—' },
      { time: '7:00 م', title: 'إعلان النتائج والجوائز', speaker: 'لجنة التحكيم' }
    ],
    speakers: [
      { name: 'د. سارة الشمري', role: 'رئيسة لجنة التحكيم' },
      { name: 'د. سمية الفهد', role: 'مشرفة هندسة البرمجيات' }
    ],
    stats: { teams: 80, challenges: 5, prizes: 3 }
  },
  8: {
    fullDate: '20–24 يوليو 2026', time: '9:00 ص – 4:00 م', year: '2026',
    organizer: 'عمادة البحث العلمي',
    audience: 'طلاب، أساتذة، باحثون',
    capacity: '600 مشارك', registration: true,
    longDesc: 'أسبوع مخصص لعرض أبرز الأبحاث والمشاريع العلمية في الجامعة، مع ندوات يومية ومعرض للملصقات البحثية وورش منهجية البحث.',
    agenda: [
      { time: 'اليوم 1', title: 'افتتاح ومحاضرة رئيسية', speaker: 'عميد البحث العلمي' },
      { time: 'اليوم 2', title: 'عرض ملصقات طلابية', speaker: '—' },
      { time: 'اليوم 3', title: 'ندوة: نشر البحث العلمي', speaker: '—' },
      { time: 'اليوم 4', title: 'جلسات بحثية متخصصة', speaker: '—' },
      { time: 'اليوم 5', title: 'حفل ختام وتوزيع جوائز', speaker: '—' }
    ],
    speakers: [
      { name: 'أ.د. فهد المطيري', role: 'عميد كلية العلوم' },
      { name: 'أ.د. نادية الدوسري', role: 'باحثة فيزياء تطبيقية' }
    ],
    stats: { projects: 85, posters: 120, days: 5 }
  }
};

const faqData = [
  {
    category: 'admission', categoryLabel: 'القبول والتسجيل',
    items: [
      { q: 'ما هي شروط القبول في برامج البكالوريوس؟', a: 'شهادة الثانوية العامة أو ما يعادلها، مع استيفاء الحد الأدنى للمعدل حسب التخصص، واجتياز اختبارات القدرات والتحصيلي حيث ينطبق.' },
      { q: 'هل يمكن التقديم على أكثر من تخصص؟', a: 'نعم، يمكنك ترتيب رغباتك حتى 5 برامج في نموذج القبول الإلكتروني.' },
      { q: 'متى تُعلن نتائج القبول؟', a: 'تُعلن النتائج الأولية خلال 4–6 أسابيع من إغلاق بوابة التقديم، عبر البريد الإلكتروني وبوابة المتقدم.' }
    ]
  },
  {
    category: 'academic', categoryLabel: 'الشؤون الأكاديمية',
    items: [
      { q: 'كيف أحصل على جدولي الدراسي؟', a: 'يُتاح الجدول عبر بوابة الطلاب بعد أسبوع التسجيل، ويمكن طباعته أو تحميله بصيغة PDF.' },
      { q: 'ما نظام الساعات المعتمدة؟', a: 'تعتمد الجامعة نظام الساعات المعتمدة؛ يختلف عدد الساعات المطلوبة للتخرج حسب البرنامج (132–240 ساعة).' },
      { q: 'هل توجد برامج تعليم عن بعد؟', a: 'تتوفر مقررات وبرامج مختلطة (Hybrid) في بعض التخصصات؛ راجع صفحة البرامج للتفاصيل.' }
    ]
  },
  {
    category: 'financial', categoryLabel: 'الرسوم والمنح',
    items: [
      { q: 'ما هي الرسوم الدراسية التقريبية؟', a: 'تختلف حسب الكلية والبرنامج؛ تتراوح برامج البكالوريوس بين 45,000 و85,000 ريال سنوياً. تفاصيل كاملة في صفحة الرسوم الدراسية.' },
      { q: 'هل تتوفر منح دراسية؟', a: 'نعم، منح للمتفوقين أكاديمياً ومنح رياضية واجتماعية؛ راجع صفحة المنح الدراسية للتفاصيل ومواعيد التقديم.' },
      { q: 'هل يمكن التقسيط؟', a: 'يتوفر نظام دفع بالأقساط الفصلية المعتمدة من إدارة الشؤون المالية.' }
    ]
  },
  {
    category: 'campus', categoryLabel: 'الحرم والخدمات',
    items: [
      { q: 'هل يتوفر سكن للطلاب؟', a: 'نعم، سكن جامعي للطلاب والطالبات بسعة محدودة؛ يُفتح التقديم بعد القبول النهائي.' },
      { q: 'أين تقع الجامعة؟', a: 'الحرم الرئيسي في الرياض، المملكة العربية السعودية، مع مواقف ومواصلات عامة قريبة.' },
      { q: 'كيف أتواصل مع الدعم الفني للبوابة؟', a: 'عبر البريد support@futureuniversity.edu أو هاتف 920000000 خلال أوقات الدوام.' }
    ]
  }
];

const scholarshipsData = [
  { id: 1, title: 'منحة التفوق الأكاديمي', type: 'merit', typeLabel: 'تفوق أكاديمي', coverage: '100%', desc: 'تغطية كاملة للرسوم الدراسية للمتفوقين أكاديمياً في الثانوية العامة.', requirements: 'معدل 95% فأعلى — اختبار قبول', deadline: '30 يونيو 2026', icon: 'fa-award' },
  { id: 2, title: 'منحة نصف التغطية', type: 'merit', typeLabel: 'تفوق أكاديمي', coverage: '50%', desc: 'خصم 50% من الرسوم الدراسية للطلاب ذوي المعدلات المرتفعة.', requirements: 'معدل 90% – 94.9%', deadline: '30 يونيو 2026', icon: 'fa-medal' },
  { id: 3, title: 'منحة رياضية', type: 'sports', typeLabel: 'رياضية', coverage: '75%', desc: 'دعم للرياضيين المتميزين المشاركين في فرق الجامعة المعتمدة.', requirements: 'إنجاز رياضي موثق — مقابلة', deadline: '15 يوليو 2026', icon: 'fa-futbol' },
  { id: 4, title: 'منحة أبناء الشهداء', type: 'social', typeLabel: 'اجتماعية', coverage: '100%', desc: 'تغطية كاملة لأبناء شهداء الواجب من وزارة الداخلية والدفاع.', requirements: 'وثائق رسمية معتمدة', deadline: 'مفتوح', icon: 'fa-heart' },
  { id: 5, title: 'منحة ذوي الدخل المحدود', type: 'social', typeLabel: 'اجتماعية', coverage: '60%', desc: 'مساندة مالية للطلاب المحتاجين وفق معايير الضمان الاجتماعي.', requirements: 'تقرير دخل — دراسة حالة', deadline: '1 أغسطس 2026', icon: 'fa-hand-holding-heart' },
  { id: 6, title: 'منحة الطلاب الدوليين', type: 'international', typeLabel: 'دولية', coverage: '40%', desc: 'تشجيع الطلاب من خارج المملكة على الالتحاق ببرامج الجامعة.', requirements: 'قبول أكاديمي — تأشيرة دراسية', deadline: '30 يونيو 2026', icon: 'fa-globe' },
  { id: 7, title: 'منحة البحث العلمي', type: 'merit', typeLabel: 'تفوق أكاديمي', coverage: '100%', desc: 'لطلاب الدراسات العليا المشاركين في مشاريع بحثية معتمدة.', requirements: 'معدل 3.75 فأعلى — قبول برنامج علمي', deadline: '15 سبتمبر 2026', icon: 'fa-flask' },
  { id: 8, title: 'منحة التميز في الفنون', type: 'social', typeLabel: 'اجتماعية', coverage: '50%', desc: 'دعم للموهوبين في التصميم والفنون والإبداع البصري.', requirements: 'معرض أعمال — لجنة تقييم', deadline: '20 يوليو 2026', icon: 'fa-palette' }
];

const tuitionFeesData = [
  { id: 1, college: 'كلية الهندسة', level: 'bachelor', levelLabel: 'بكالوريوس', annual: 65000, semester: 32500, registration: 2000 },
  { id: 2, college: 'كلية الطب', level: 'bachelor', levelLabel: 'بكالوريوس', annual: 85000, semester: 42500, registration: 3000 },
  { id: 3, college: 'كلية علوم الحاسب', level: 'bachelor', levelLabel: 'بكالوريوس', annual: 58000, semester: 29000, registration: 2000 },
  { id: 4, college: 'كلية إدارة الأعمال', level: 'bachelor', levelLabel: 'بكالوريوس', annual: 48000, semester: 24000, registration: 1500 },
  { id: 5, college: 'كلية الصيدلة', level: 'bachelor', levelLabel: 'بكالوريوس', annual: 72000, semester: 36000, registration: 2500 },
  { id: 6, college: 'كلية العمارة', level: 'bachelor', levelLabel: 'بكالوريوس', annual: 62000, semester: 31000, registration: 2000 },
  { id: 7, college: 'كلية إدارة الأعمال', level: 'master', levelLabel: 'ماجستير', annual: 55000, semester: 27500, registration: 2000 },
  { id: 8, college: 'كلية علوم الحاسب', level: 'master', levelLabel: 'ماجستير', annual: 60000, semester: 30000, registration: 2000 },
  { id: 9, college: 'كلية الهندسة', level: 'master', levelLabel: 'ماجستير', annual: 58000, semester: 29000, registration: 2000 },
  { id: 10, college: 'كلية الهندسة', level: 'phd', levelLabel: 'دكتوراه', annual: 45000, semester: 22500, registration: 1500 },
  { id: 11, college: 'كلية العلوم', level: 'phd', levelLabel: 'دكتوراه', annual: 42000, semester: 21000, registration: 1500 },
  { id: 12, college: 'كلية إدارة الأعمال', level: 'phd', levelLabel: 'دكتوراه', annual: 48000, semester: 24000, registration: 1500 }
];

const studentServicesData = [
  { id: 1, title: 'الإرشاد الأكاديمي', category: 'academic', categoryLabel: 'أكاديمي', desc: 'مساعدة الطلاب في اختيار المقررات والتخصصات ووضع الخطط الدراسية.', hours: '8:00 ص – 4:00 م', contact: 'advising@futureuniversity.edu', icon: 'fa-user-graduate' },
  { id: 2, title: 'التسجيل والسجلات', category: 'academic', categoryLabel: 'أكاديمي', desc: 'إصدار كشوف الدرجات والشهادات وتحديث البيانات الأكاديمية.', hours: '8:00 ص – 3:00 م', contact: 'registrar@futureuniversity.edu', icon: 'fa-file-lines' },
  { id: 3, title: 'المركز الطبي الجامعي', category: 'health', categoryLabel: 'صحي', desc: 'رعاية صحية أولية وتحويلات طبية للطلاب والموظفين.', hours: '7:30 ص – 8:00 م', contact: 'clinic@futureuniversity.edu', icon: 'fa-heart-pulse' },
  { id: 4, title: 'الدعم النفسي والاجتماعي', category: 'health', categoryLabel: 'صحي', desc: 'جلسات إرشاد نفسي وبرامج دعم للتكيف الجامعي.', hours: '9:00 ص – 5:00 م', contact: 'counseling@futureuniversity.edu', icon: 'fa-hands-holding-child' },
  { id: 5, title: 'مركز التوظيف', category: 'career', categoryLabel: 'مهني', desc: 'تدريب مهني، CV، مقابلات، وربط مع شركات التوظيف.', hours: '8:00 ص – 4:00 م', contact: 'career@futureuniversity.edu', icon: 'fa-briefcase' },
  { id: 6, title: 'السكن الجامعي', category: 'campus', categoryLabel: 'حرم', desc: 'إدارة طلبات السكن والصيانة والخدمات داخل المجمع السكني.', hours: '24/7', contact: 'housing@futureuniversity.edu', icon: 'fa-bed' },
  { id: 7, title: 'خدمات ذوي الاحتياجات', category: 'campus', categoryLabel: 'حرم', desc: 'تسهيلات ومرافق ودعم أكاديمي للطلاب ذوي الإعاقة.', hours: '8:00 ص – 4:00 م', contact: 'accessibility@futureuniversity.edu', icon: 'fa-wheelchair' },
  { id: 8, title: 'الدعم الفني للبوابة', category: 'digital', categoryLabel: 'رقمي', desc: 'مساعدة في الدخول للأنظمة الأكاديمية والبريد الجامعي.', hours: '24/7', contact: 'support@futureuniversity.edu', icon: 'fa-headset' },
  { id: 9, title: 'المكتبة الرقمية', category: 'digital', categoryLabel: 'رقمي', desc: 'وصول للمصادر الإلكترونية ودورات البحث العلمي.', hours: '8:00 ص – 10:00 م', contact: 'library@futureuniversity.edu', icon: 'fa-book-open' },
  { id: 10, title: 'الأنشطة الطلابية', category: 'campus', categoryLabel: 'حرم', desc: 'نوادي، فعاليات، وبرامج قيادية للطلاب.', hours: '9:00 ص – 6:00 م', contact: 'activities@futureuniversity.edu', icon: 'fa-users' }
];

const academicCalendarData = [
  { id: 1, title: 'بداية التقديم للفصل الأول', semester: 'fall', semesterLabel: 'الفصل الأول', date: '1 يونيو 2026', type: 'admission', icon: 'fa-door-open' },
  { id: 2, title: 'إغلاق التقديم', semester: 'fall', semesterLabel: 'الفصل الأول', date: '15 يوليو 2026', type: 'admission', icon: 'fa-hourglass-end' },
  { id: 3, title: 'إعلان نتائج القبول', semester: 'fall', semesterLabel: 'الفصل الأول', date: '1 أغسطس 2026', type: 'admission', icon: 'fa-bullhorn' },
  { id: 4, title: 'التسجيل في المقررات', semester: 'fall', semesterLabel: 'الفصل الأول', date: '18–22 أغسطس 2026', type: 'registration', icon: 'fa-clipboard-list' },
  { id: 5, title: 'بداية الفصل الدراسي الأول', semester: 'fall', semesterLabel: 'الفصل الأول', date: '25 أغسطس 2026', type: 'start', icon: 'fa-flag' },
  { id: 6, title: 'الانسحاب بدون رصيد', semester: 'fall', semesterLabel: 'الفصل الأول', date: '15 سبتمبر 2026', type: 'deadline', icon: 'fa-calendar-xmark' },
  { id: 7, title: 'إجازة اليوم الوطني', semester: 'fall', semesterLabel: 'الفصل الأول', date: '23 سبتمبر 2026', type: 'holiday', icon: 'fa-star' },
  { id: 8, title: 'بداية الاختبارات النصفية', semester: 'fall', semesterLabel: 'الفصل الأول', date: '20 أكتوبر 2026', type: 'exam', icon: 'fa-pen-to-square' },
  { id: 9, title: 'نهاية الاختبارات النصفية', semester: 'fall', semesterLabel: 'الفصل الأول', date: '31 أكتوبر 2026', type: 'exam', icon: 'fa-pen-to-square' },
  { id: 10, title: 'إجازة منتصف الفصل', semester: 'fall', semesterLabel: 'الفصل الأول', date: '1–5 نوفمبر 2026', type: 'holiday', icon: 'fa-umbrella-beach' },
  { id: 11, title: 'بداية الاختبارات النهائية', semester: 'fall', semesterLabel: 'الفصل الأول', date: '15 ديسمبر 2026', type: 'exam', icon: 'fa-file-circle-check' },
  { id: 12, title: 'نهاية الفصل الدراسي الأول', semester: 'fall', semesterLabel: 'الفصل الأول', date: '25 ديسمبر 2026', type: 'end', icon: 'fa-flag-checkered' },
  { id: 13, title: 'بداية الفصل الدراسي الثاني', semester: 'spring', semesterLabel: 'الفصل الثاني', date: '12 يناير 2027', type: 'start', icon: 'fa-flag' },
  { id: 14, title: 'إجازة عيد الفطر', semester: 'spring', semesterLabel: 'الفصل الثاني', date: '21–25 مارس 2027', type: 'holiday', icon: 'fa-moon' },
  { id: 15, title: 'نهاية الفصل الدراسي الثاني', semester: 'spring', semesterLabel: 'الفصل الثاني', date: '20 مايو 2027', type: 'end', icon: 'fa-flag-checkered' },
  { id: 16, title: 'بداية الفصل الصيفي', semester: 'summer', semesterLabel: 'الفصل الصيفي', date: '5 يونيو 2027', type: 'start', icon: 'fa-sun' },
  { id: 17, title: 'نهاية الفصل الصيفي', semester: 'summer', semesterLabel: 'الفصل الصيفي', date: '30 يوليو 2027', type: 'end', icon: 'fa-flag-checkered' }
];

const departmentsData = {
  1: [
    { name: 'قسم الهندسة المدنية', icon: 'fa-road', desc: 'تصميم وبناء البنى التحتية والمنشآت', programs: 3, faculty: 25 },
    { name: 'قسم الهندسة المعمارية', icon: 'fa-building', desc: 'التصميم المعماري والتخطيط العمراني', programs: 3, faculty: 20 },
    { name: 'قسم الهندسة الميكانيكية', icon: 'fa-gear', desc: 'أنظمة الطاقة والتصنيع المتقدم', programs: 2, faculty: 22 },
    { name: 'قسم الهندسة الكهربائية', icon: 'fa-bolt', desc: 'الطاقة والاتصالات والإلكترونيات', programs: 2, faculty: 18 },
    { name: 'قسم الهندسة الكيميائية', icon: 'fa-atom', desc: 'عمليات التصنيع والبتروكيماويات', programs: 2, faculty: 15 }
  ],
  2: [
    { name: 'قسم التشريح', icon: 'fa-heart-pulse', desc: 'دراسة تركيب جسم الإنسان', programs: 2, faculty: 12 },
    { name: 'قسم الباطنة', icon: 'fa-lungs', desc: 'أمراض الجهاز الهضمي والتنفس', programs: 3, faculty: 30 },
    { name: 'قسم الجراحة', icon: 'fa-scalpel-line-dashed', desc: 'الجراحة العامة والتخصصية', programs: 3, faculty: 28 },
    { name: 'قسم طب الأطفال', icon: 'fa-baby', desc: 'رعاية صحة الأطفال', programs: 2, faculty: 18 }
  ],
  3: [
    { name: 'قسم الإدارة', icon: 'fa-users', desc: 'الإدارة الاستراتيجية والموارد البشرية', programs: 3, faculty: 20 },
    { name: 'قسم المحاسبة', icon: 'fa-calculator', desc: 'المحاسبة المالية والتدقيق', programs: 2, faculty: 15 },
    { name: 'قسم التسويق', icon: 'fa-bullhorn', desc: 'التسويق الرقمي وإدارة العلامات التجارية', programs: 2, faculty: 12 },
    { name: 'قسم الاقتصاد', icon: 'fa-coins', desc: 'الاقتصاد الكلي والجزئي والمالي', programs: 3, faculty: 18 }
  ],
  4: [
    { name: 'قسم علوم الحاسب', icon: 'fa-code', desc: 'البرمجة وهندسة البرمجيات', programs: 3, faculty: 22 },
    { name: 'قسم الذكاء الاصطناعي', icon: 'fa-robot', desc: 'تعلم الآلة ومعالجة اللغات', programs: 2, faculty: 15 },
    { name: 'قسم أمن المعلومات', icon: 'fa-shield-halved', desc: 'الأمن السيبراني وحماية البيانات', programs: 2, faculty: 12 },
    { name: 'قسم نظم المعلومات', icon: 'fa-database', desc: 'إدارة قواعد البيانات وتحليل النظم', programs: 2, faculty: 14 }
  ]
};

const programsData = [
  { id: 1, name: 'بكالوريوس الهندسة المدنية', level: 'bachelor', levelLabel: 'بكالوريوس', college: 'كلية الهندسة', duration: '5 سنوات', desc: 'إعداد مهندسين مدنيين مؤهلين لتصميم وبناء المشاريع الهندسية', requirements: 'ثانوية علمية - معدل 90% فأعلى' },
  { id: 2, name: 'بكالوريوس الطب والجراحة', level: 'bachelor', levelLabel: 'بكالوريوس', college: 'كلية الطب', duration: '6 سنوات', desc: 'برنامج طبي متكامل لإعداد أطباء متميزين', requirements: 'ثانوية علمية - معدل 95% فأعلى - اختبار القدرات' },
  { id: 3, name: 'بكالوريوس علوم الحاسب', level: 'bachelor', levelLabel: 'بكالوريوس', college: 'كلية علوم الحاسب', duration: '4 سنوات', desc: 'دراسة شاملة في البرمجة وهندسة البرمجيات', requirements: 'ثانوية علمية - معدل 85% فأعلى' },
  { id: 4, name: 'بكالوريوس إدارة الأعمال', level: 'bachelor', levelLabel: 'بكالوريوس', college: 'كلية إدارة الأعمال', duration: '4 سنوات', desc: 'تأهيل كوادر إدارية مؤهلة لسوق العمل', requirements: 'ثانوية - معدل 80% فأعلى' },
  { id: 5, name: 'بكالوريوس الصيدلة', level: 'bachelor', levelLabel: 'بكالوريوس', college: 'كلية الصيدلة', duration: '5 سنوات', desc: 'إعداد صيادلة متخصصين في الصناعة والبحث', requirements: 'ثانوية علمية - معدل 92% فأعلى' },
  { id: 6, name: 'بكالوريوس العمارة', level: 'bachelor', levelLabel: 'بكالوريوس', college: 'كلية العمارة', duration: '5 سنوات', desc: 'تصميم معماري مبتكر ومستدام', requirements: 'ثانوية - معدل 85% فأعلى - اختبار قدرات' },
  { id: 7, name: 'ماجستير إدارة الأعمال MBA', level: 'master', levelLabel: 'ماجستير', college: 'كلية إدارة الأعمال', duration: 'سنتين', desc: 'برنامج متقدم في الإدارة التنفيذية والقيادة', requirements: 'بكالوريوس - خبرة 3 سنوات - اختبار GMAT' },
  { id: 8, name: 'ماجستير الذكاء الاصطناعي', level: 'master', levelLabel: 'ماجستير', college: 'كلية علوم الحاسب', duration: 'سنتين', desc: 'دراسة متعمقة في تعلم الآلة والشبكات العصبية', requirements: 'بكالوريوس حاسب - معدل 3.5 فأعلى' },
  { id: 9, name: 'ماجستير الهندسة الإنشائية', level: 'master', levelLabel: 'ماجستير', college: 'كلية الهندسة', duration: 'سنتين', desc: 'تخصص في تصميم وتحليل المنشآت المتقدمة', requirements: 'بكالوريوس هندسة مدنية - معدل 3.0 فأعلى' },
  { id: 10, name: 'ماجستير المحاسبة المالية', level: 'master', levelLabel: 'ماجستير', college: 'كلية إدارة الأعمال', duration: 'سنتين', desc: 'تخصص في المحاسبة والتدقيق المالي المتقدم', requirements: 'بكالوريوس محاسبة - معدل 3.0 فأعلى' },
  { id: 11, name: 'دكتوراه في علوم الحاسب', level: 'phd', levelLabel: 'دكتوراه', college: 'كلية علوم الحاسب', duration: '4 سنوات', desc: 'بحث متخصص في مجالات الحوسبة المتقدمة', requirements: 'ماجستير - معدل 3.75 فأعلى - مقترح بحثي' },
  { id: 12, name: 'دكتوراه في الإدارة', level: 'phd', levelLabel: 'دكتوراه', college: 'كلية إدارة الأعمال', duration: '4 سنوات', desc: 'بحث أكاديمي في الإدارة والقيادة التنظيمية', requirements: 'ماجستير إدارة - معدل 3.75 فأعلى' },
  { id: 13, name: 'دكتوراه في الهندسة الطبية', level: 'phd', levelLabel: 'دكتوراه', college: 'كلية الهندسة', duration: '4 سنوات', desc: 'بحث في التقنيات الطبية الحيوية المتقدمة', requirements: 'ماجستير هندسة - معدل 3.75 فأعلى' },
  { id: 14, name: 'دكتوراه في القانون الدولي', level: 'phd', levelLabel: 'دكتوراه', college: 'كلية الحقوق', duration: '4 سنوات', desc: 'بحث في القانون الدولي والعلاقات الدولية', requirements: 'ماجستير قانون - معدل 3.75 فأعلى' }
];

const staffData = [
  { id: 1, tier: 'leadership', name: 'أ.د. عبدالله الراشد', position: 'رئيس الجامعة', icon: 'fa-user-tie', bio: 'خبير في الإدارة الأكاديمية والتخطيط الاستراتيجي بخبرة تتجاوز 30 عاماً في التعليم العالي.' },
  { id: 2, tier: 'leadership', name: 'أ.د. فاطمة الزهراني', position: 'نائب الرئيس للشؤون الأكاديمية', icon: 'fa-user-tie', bio: 'متخصصة في تطوير المناهج والبرامج الأكاديمية المعتمدة دولياً.' },
  { id: 3, tier: 'leadership', name: 'أ.د. محمد العتيبي', position: 'نائب الرئيس للبحث العلمي', icon: 'fa-user-tie', bio: 'باحث متميز في مجال الذكاء الاصطناعي وتطبيقاته في التعليم.' },
  { id: 4, tier: 'dean', name: 'د. نورة القحطاني', position: 'عميدة كلية الهندسة', icon: 'fa-user-tie', bio: 'خبيرة في الهندسة المدنية والتصميم المستدام' },
  { id: 5, tier: 'dean', name: 'أ.د. خالد الدوسري', position: 'عميد كلية الطب', icon: 'fa-user-tie', bio: 'استشاري في الجراحة العامة وزراعة الأعضاء' },
  { id: 6, tier: 'dean', name: 'د. سارة الشمري', position: 'عميدة كلية علوم الحاسب', icon: 'fa-user-tie', bio: 'متخصصة في أمن المعلومات والحوسبة السحابية' },
  { id: 7, tier: 'dean', name: 'أ.د. أحمد الحربي', position: 'عميد كلية إدارة الأعمال', icon: 'fa-user-tie', bio: 'خبير في الإدارة الاستراتيجية والتطوير المؤسسي' },
  { id: 8, tier: 'dean', name: 'د. منال العنزي', position: 'عميدة كلية الصيدلة', icon: 'fa-user-tie', bio: 'باحثة في مجال تطوير الأدوية والعلاج الجيني' },
  { id: 9, tier: 'dean', name: 'أ.د. فهد المطيري', position: 'عميد كلية العلوم', icon: 'fa-user-tie', bio: 'متخصص في الفيزياء التطبيقية والطاقة المتجددة' },
  { id: 10, tier: 'dean', name: 'د. هند السبيعي', position: 'عميدة كلية التربية', icon: 'fa-user-tie', bio: 'خبيرة في المناهج التعليمية والتربية الخاصة' },
  { id: 11, tier: 'dean', name: 'أ.د. سلطان الرشيدي', position: 'عميد كلية الحقوق', icon: 'fa-user-tie', bio: 'متخصص في القانون الدولي والتحكيم التجاري' },
  { id: 12, tier: 'dean', name: 'د. ريم البلوي', position: 'عميدة كلية التصاميم', icon: 'fa-user-tie', bio: 'مصممة محترفة في التصميم الجرافيكي والهوية البصرية' }
];

const newsData = [
  { id: 1, title: 'الجامعة تحقق مراكز متقدمة في التصنيف العالمي 2026', category: 'إنجازات', date: { day: '15', month: 'مارس' }, icon: 'fa-trophy', color: '#0EA5E9', excerpt: 'حققت جامعة المستقبل قفزة نوعية في التصنيفات العالمية لتتقدم 50 مركزاً عن العام السابق.' },
  { id: 2, title: 'توقيع اتفاقية شراكة مع جامعة MIT الأمريكية', category: 'شراكات', date: { day: '10', month: 'مارس' }, icon: 'fa-handshake', color: '#059669', excerpt: 'وقعت الجامعة اتفاقية تعاون أكاديمي وبحثي مع معهد ماساتشوستس للتكنولوجيا.' },
  { id: 3, title: 'افتتاح مركز أبحاث الذكاء الاصطناعي الجديد', category: 'بحث علمي', date: { day: '05', month: 'مارس' }, icon: 'fa-flask', color: '#7c3aed', excerpt: 'تم افتتاح مركز أبحاث الذكاء الاصطناعي المجهز بأحدث التقنيات والبنية التحتية.' },
  { id: 4, title: 'انطلاق فعاليات الأسبوع العلمي الخامس', category: 'فعاليات', date: { day: '28', month: 'فبراير' }, icon: 'fa-calendar-check', color: '#dc2626', excerpt: 'تنطلق فعاليات الأسبوع العلمي بمشاركة أكثر من 50 باحثاً ومتحدثاً دولياً.' },
  { id: 5, title: 'حصول برنامج الهندسة على الاعتماد الدولي ABET', category: 'اعتماد', date: { day: '20', month: 'فبراير' }, icon: 'fa-certificate', color: '#d97706', excerpt: 'حصلت برامج كلية الهندسة على الاعتماد الدولي من هيئة ABET الأمريكية.' },
  { id: 6, title: 'تخريج الدفعة الخامسة عشرة من طلاب الجامعة', category: 'تخرج', date: { day: '15', month: 'فبراير' }, icon: 'fa-graduation-cap', color: '#0891b2', excerpt: 'احتفلت الجامعة بتخريج أكثر من 3000 طالب وطالبة من مختلف الكليات.' }
];

const researchData = [
  { id: 1, title: 'مركز أبحاث الذكاء الاصطناعي', icon: 'fa-robot', desc: 'بحث متقدم في تعلم الآلة ومعالجة اللغات الطبيعية والرؤية الحاسوبية', projects: 25, publications: 120 },
  { id: 2, title: 'مركز أبحاث الطاقة المتجددة', icon: 'fa-solar-panel', desc: 'دراسات في الطاقة الشمسية وطاقة الرياح وتخزين الطاقة', projects: 18, publications: 85 },
  { id: 3, title: 'مركز أبحاث العلوم الطبية', icon: 'fa-dna', desc: 'أبحاث في العلاج الجيني والطب الشخصي والأمراض المزمنة', projects: 30, publications: 200 },
  { id: 4, title: 'مركز أبحاث الأمن السيبراني', icon: 'fa-shield-halved', desc: 'حماية البيانات وأمن الشبكات والتشفير المتقدم', projects: 15, publications: 65 },
  { id: 5, title: 'مركز أبحاث الاستدامة البيئية', icon: 'fa-leaf', desc: 'دراسات في التغير المناخي وإدارة الموارد الطبيعية', projects: 12, publications: 50 },
  { id: 6, title: 'مركز أبحاث التقنية الحيوية', icon: 'fa-microscope', desc: 'أبحاث في الهندسة الوراثية والتطبيقات الطبية الحيوية', projects: 20, publications: 95 }
];

const researchDetailExtra = {
  1: {
    director: 'أ.د. محمد العتيبي', established: '2018', college: 'كلية علوم الحاسب',
    email: 'ai.research@futureuniversity.edu', phone: '+966 11 234 5601',
    longDesc: 'يُعد مركز أبحاث الذكاء الاصطناعي من أبرز مراكز الجامعة، ويركز على تطوير حلول تعلم الآلة ومعالجة اللغات الطبيعية والرؤية الحاسوبية لخدمة القطاعات التعليمية والصحية والصناعية.',
    focusAreas: ['تعلم الآلة', 'معالجة اللغات الطبيعية', 'الرؤية الحاسوبية', 'الذكاء الاصطناعي التفسيري'],
    activeProjects: [
      { title: 'نماذج لغوية للتعليم بالعربية', status: 'جاري' },
      { title: 'كشف الأمراض بالتصوير الطبي', status: 'جاري' },
      { title: 'أتمتة خدمات الطلاب', status: 'مكتمل' }
    ],
    partners: ['Google Research', 'IBM', 'SDAIA'],
    stats: { researchers: 45, labs: 4, grants: 12 }
  },
  2: {
    director: 'أ.د. فهد المطيري', established: '2016', college: 'كلية الهندسة',
    email: 'energy.research@futureuniversity.edu', phone: '+966 11 234 5602',
    longDesc: 'يعمل المركز على دراسات الطاقة الشمسية وطاقة الرياح وتخزين الطاقة، بما يتماشى مع رؤية المملكة 2030 في التحول نحو الطاقة النظيفة.',
    focusAreas: ['الطاقة الشمسية', 'طاقة الرياح', 'تخزين الطاقة', 'كفاءة المباني'],
    activeProjects: [
      { title: 'محطات شمسية للحرم الجامعي', status: 'جاري' },
      { title: 'بطاريات ليثيوم متقدمة', status: 'جاري' },
      { title: 'تحليل بيانات استهلاك الطاقة', status: 'مكتمل' }
    ],
    partners: ['KACST', 'NEOM', 'Saudi Aramco'],
    stats: { researchers: 32, labs: 3, grants: 9 }
  },
  3: {
    director: 'أ.د. خالد الدوسري', established: '2015', college: 'كلية الطب',
    email: 'medical.research@futureuniversity.edu', phone: '+966 11 234 5603',
    longDesc: 'يركز المركز على أبحاث العلاج الجيني والطب الشخصي والأمراض المزمنة، بالتعاون مع مستشفيات الجامعة ومراكز التجارب السريرية.',
    focusAreas: ['العلاج الجيني', 'الطب الشخصي', 'الأمراض المزمنة', 'الأبحاث السريرية'],
    activeProjects: [
      { title: 'علاج جيني للسكري', status: 'جاري' },
      { title: 'مؤشرات حيوية للأورام', status: 'جاري' },
      { title: 'سجل طبي إلكتروني للبحث', status: 'مكتمل' }
    ],
    partners: ['وزارة الصحة', 'King Faisal Specialist Hospital'],
    stats: { researchers: 58, labs: 6, grants: 18 }
  },
  4: {
    director: 'د. سارة الشمري', established: '2019', college: 'كلية علوم الحاسب',
    email: 'cyber.research@futureuniversity.edu', phone: '+966 11 234 5604',
    longDesc: 'يختص المركز بحماية البيانات وأمن الشبكات والتشفير المتقدم، ويقدم استشارات أمنية للجهات الحكومية والخاصة.',
    focusAreas: ['أمن الشبكات', 'التشفير', 'التحليل الجنائي الرقمي', 'أمن IoT'],
    activeProjects: [
      { title: 'كشف التسلل بالذكاء الاصطناعي', status: 'جاري' },
      { title: 'بروتوكولات تشفير ما بعد الكم', status: 'جاري' },
      { title: 'منصة تدريب أمن سيبراني', status: 'مكتمل' }
    ],
    partners: ['NCA', 'Cisco', 'Microsoft Security'],
    stats: { researchers: 28, labs: 2, grants: 7 }
  },
  5: {
    director: 'د. نورة القحطاني', established: '2017', college: 'كلية الهندسة',
    email: 'sustainability@futureuniversity.edu', phone: '+966 11 234 5605',
    longDesc: 'يدرس المركز التغير المناخي وإدارة الموارد الطبيعية والتصميم المستدام للمدن والمباني.',
    focusAreas: ['التغير المناخي', 'إدارة المياه', 'التصميم المستدام', 'الاقتصاد الدائري'],
    activeProjects: [
      { title: 'خريطة حرارية للرياض', status: 'جاري' },
      { title: 'إعادة تدوير مياه الصرف', status: 'جاري' },
      { title: 'مؤشر الاستدامة للحرم', status: 'مكتمل' }
    ],
    partners: ['UNEP', 'Ministry of Environment'],
    stats: { researchers: 22, labs: 2, grants: 6 }
  },
  6: {
    director: 'د. منال العنزي', established: '2020', college: 'كلية الصيدلة',
    email: 'biotech@futureuniversity.edu', phone: '+966 11 234 5606',
    longDesc: 'يركز على الهندسة الوراثية والتطبيقات الطبية الحيوية وتطوير الأدوية الحيوية.',
    focusAreas: ['الهندسة الوراثية', 'الأدوية الحيوية', 'مختبرات الأحياء الدقيقة', 'التشخيص الجزيئي'],
    activeProjects: [
      { title: 'لقاحات RNA رسول محلية', status: 'جاري' },
      { title: 'CRISPR للأمراض الوراثية', status: 'جاري' },
      { title: 'مكتبة جينات للبحث', status: 'مكتمل' }
    ],
    partners: ['SFDA', 'Pfizer Research'],
    stats: { researchers: 35, labs: 5, grants: 11 }
  }
};

const privacySections = [
  { id: 'intro', title: 'مقدمة', content: 'تحترم جامعة المستقبل خصوصيتك وتلتزم بحماية بياناتك الشخصية وفقاً للأنظمة المعمول بها في المملكة العربية السعودية. توضّح هذه السياسة كيفية جمع واستخدام وحماية معلوماتك عند استخدام موقع الجامعة وخدماتها الرقمية.' },
  { id: 'collection', title: 'البيانات التي نجمعها', content: 'قد نجمع: الاسم، البريد الإلكتروني، رقم الهاتف، رقم الهوية أو الإقامة (لطلبات القبول)، بيانات أكاديمية، عنوان IP، وسجلات التصفح. تُجمع هذه البيانات عند التسجيل، تقديم طلبات القبول، استخدام بوابة الطلاب، أو التواصل معنا.' },
  { id: 'usage', title: 'كيف نستخدم بياناتك', content: 'نستخدم بياناتك لمعالجة طلبات القبول والتسجيل، تقديم الخدمات الأكاديمية، التواصل بشأن الفعاليات والمنح، تحسين تجربة الموقع، والامتثال للمتطلبات القانونية. لن نبيع بياناتك لأطراف ثالثة.' },
  { id: 'sharing', title: 'مشاركة البيانات', content: 'قد نشارك بياناتك مع: الجهات الحكومية ذات الصلة (مثل وزارة التعليم)، مزودي الخدمات التقنية المعتمدين، والشركاء الأكاديمي المعتمدين — وذلك فقط للأغراض المذكورة في هذه السياسة وبموجب اتفاقيات سرية.' },
  { id: 'cookies', title: 'ملفات تعريف الارتباط', content: 'يستخدم الموقع ملفات تعريف الارتباط (Cookies) لتحسين الأداء وتذكر تفضيلاتك مثل وضع العرض (فاتح/داكن). يمكنك التحكم في إعدادات المتصفح لرفض بعض ملفات الارتباط، مع العلم أن ذلك قد يؤثر على بعض وظائف الموقع.' },
  { id: 'security', title: 'أمن البيانات', content: 'نطبّق إجراءات تقنية وإدارية لحماية بياناتك، تشمل التشفير، التحكم في الوصول، والمراجعة الدورية. لا يمكن ضمان أمان مطلق عبر الإنترنت، لكننا نبذل جهوداً معقولة للحد من المخاطر.' },
  { id: 'rights', title: 'حقوقك', content: 'يحق لك طلب الوصول إلى بياناتك أو تصحيحها أو حذفها (وفقاً للقيود القانونية)، وسحب موافقتك على المعالجة، والاعتراض على بعض الاستخدامات. للتواصل: privacy@futureuniversity.edu' },
  { id: 'updates', title: 'تحديثات السياسة', content: 'قد نحدّث هذه السياسة من وقت لآخر. سننشر أي تغييرات على هذه الصفحة مع تاريخ آخر تحديث. ننصحك بمراجعتها دورياً. آخر تحديث: يونيو 2026.' }
];

const termsSections = [
  { id: 'acceptance', title: 'قبول الشروط', content: 'باستخدامك لموقع جامعة المستقبل وخدماتها، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا لم توافق، يرجى عدم استخدام الموقع.' },
  { id: 'services', title: 'الخدمات المقدمة', content: 'يوفر الموقع معلومات عن الجامعة، برامج القبول، الخدمات الطلابية، والموارد الأكاديمية. المعلومات للأغراض الإرشادية وقد تتغير دون إشعار مسبق.' },
  { id: 'accounts', title: 'حسابات المستخدمين', content: 'أنت مسؤول عن سرية بيانات دخولك إلى بوابة الطلاب. يجب إبلاغ الجامعة فوراً عن أي استخدام غير مصرح به. تحتفظ الجامعة بحق تعليق الحسابات المخالفة.' },
  { id: 'admission', title: 'طلبات القبول', content: 'تقديم طلب القبول لا يضمن القبول. الجامعة تحتفظ بحق قبول أو رفض أي طلب وفق معاييرها الأكاديمية. يجب أن تكون جميع المعلومات المقدمة صحيحة وكاملة.' },
  { id: 'ip', title: 'الملكية الفكرية', content: 'جميع محتويات الموقع (نصوص، شعارات، صور، تصاميم) مملوكة لجامعة المستقبل أو مرخّصة لها. يُحظر النسخ أو إعادة النشر دون إذن كتابي.' },
  { id: 'conduct', title: 'سلوك المستخدم', content: 'يُحظر استخدام الموقع لأغراض غير قانونية، أو نشر محتوى مسيء، أو محاولة اختراق الأنظمة، أو جمع بيانات المستخدمين الآخرين.' },
  { id: 'liability', title: 'إخلاء المسؤولية', content: 'تُقدّم الخدمات "كما هي". لا تتحمل الجامعة مسؤولية عن أضرار غير مباشرة ناتجة عن استخدام الموقع أو انقطاع الخدمة، ضمن حدود ما يسمح به النظام.' },
  { id: 'law', title: 'القانون الواجب التطبيق', content: 'تخضع هذه الشروط لأنظمة المملكة العربية السعودية. أي نزاع يُحال إلى المحاكم المختصة في الرياض. آخر تحديث: يونيو 2026.' }
];

// ============================================
// Rendering Functions
// ============================================
function renderColleges() {
  const container = document.getElementById('colleges-container');
  if (!container) return;
  let html = '';
  collegesData.slice(0, 6).forEach((college) => {
    html += `
    <div class="col-6 col-md-4 col-lg-2">
      <a href="/college-detail?id=${college.id}" class="text-decoration-none">
        <div class="uni-card uni-card--college h-100">
          <div class="uni-card--college__head">
            <div class="college-icon"><i class="fas ${college.icon}"></i></div>
          </div>
          <div class="uni-card--college__body">
            <h6>${college.name}</h6>
            <span class="uni-card--college__link">استكشف <i class="fas fa-arrow-left"></i></span>
          </div>
        </div>
      </a>
    </div>`;
  });
  container.innerHTML = html;
}

function initCollegesPage() {
  const container = document.getElementById('all-colleges-container');
  const filterTabs = document.querySelectorAll('#college-filter-tabs .nav-link');
  
  function renderColleges(filter = 'all') {
    let filtered = filter === 'all' ? collegesData : collegesData.filter((_, i) => {
      if (filter === 'medical') return [1, 4, 5].includes(i);
      if (filter === 'engineering') return [0, 9].includes(i);
      if (filter === 'business') return [2, 8].includes(i);
      if (filter === 'science') return [3, 4, 10].includes(i);
      return true;
    });
    
    let html = '';
    filtered.forEach((college, i) => {
      const img = collegeImages[college.id - 1] || collegeImages[0];
      html += `
      <div class="col-md-6 col-lg-4">
        <a href="/college-detail?id=${college.id}" class="text-decoration-none">
          <article class="college-card has-image h-100">
            <div class="college-bg" style="background-image: url('${img}');"></div>
            <div class="college-scrim"></div>
            <div class="college-card__body">
              <div class="college-icon"><i class="fas ${college.icon}"></i></div>
              <h3 class="college-card__title">${college.name}</h3>
              <p class="college-card__desc">${college.desc}</p>
              <div class="college-card__stats">
                <span><i class="fas fa-layer-group"></i>${college.depts} أقسام</span>
                <span><i class="fas fa-book"></i>${college.programs} برنامج</span>
              </div>
            </div>
          </article>
        </a>
      </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      const filter = e.currentTarget.getAttribute('data-filter');
      container.style.opacity = '0';
      setTimeout(() => {
        renderColleges(filter);
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderColleges();
}

function initDepartmentsPage() {
  const params = new URLSearchParams(window.location.search);
  const collegeId = parseInt(params.get('college')) || 1;
  const college = collegesData.find(c => c.id === collegeId);
  
  const collegeNameEl = document.getElementById('current-college-name');
  if (collegeNameEl && college) collegeNameEl.textContent = college.name;

  const collegeLinkEl = document.getElementById('dept-college-link');
  if (collegeLinkEl && college) {
    collegeLinkEl.textContent = college.name;
    collegeLinkEl.href = `/college-detail?id=${collegeId}`;
  }
  
  const container = document.getElementById('departments-container');
  const depts = departmentsData[collegeId] || departmentsData[1];

  const totalPrograms = depts.reduce((sum, d) => sum + d.programs, 0);
  const totalFaculty = depts.reduce((sum, d) => sum + d.faculty, 0);

  const deptCountEl = document.getElementById('dept-count');
  const programsCountEl = document.getElementById('dept-programs-count');
  const facultyCountEl = document.getElementById('dept-faculty-count');
  const collegeHighlightEl = document.getElementById('dept-college-name');

  if (deptCountEl) deptCountEl.textContent = depts.length;
  if (programsCountEl) programsCountEl.textContent = totalPrograms;
  if (facultyCountEl) facultyCountEl.textContent = totalFaculty;
  if (collegeHighlightEl && college) {
    collegeHighlightEl.textContent = college.name.replace('كلية ', '');
  }

  if (college) {
    document.title = college.name + ' — الأقسام | جامعة المستقبل';
  }
  
  let html = '';
  depts.forEach(dept => {
    html += `
    <div class="col-md-6 col-lg-4">
      <a href="/programs" class="text-decoration-none">
      <article class="dept-card h-100">
        <div class="dept-card__icon"><i class="fas ${dept.icon}"></i></div>
        <h3 class="dept-card__title">${dept.name}</h3>
        <p class="dept-card__desc">${dept.desc}</p>
        <div class="dept-card__stats">
          <span><i class="fas fa-book"></i>${dept.programs} برامج</span>
          <span><i class="fas fa-users"></i>${dept.faculty} عضو تدريس</span>
        </div>
      </article>
      </a>
    </div>`;
  });
  container.innerHTML = html;
}

function initProgramsPage() {
  const container = document.getElementById('programs-container');
  const filterTabs = document.querySelectorAll('#program-filter-tabs .nav-link');

  const totalEl = document.getElementById('programs-total-count');
  const bachelorEl = document.getElementById('programs-bachelor-count');
  const masterEl = document.getElementById('programs-master-count');
  const phdEl = document.getElementById('programs-phd-count');

  if (totalEl) totalEl.textContent = programsData.length;
  if (bachelorEl) bachelorEl.textContent = programsData.filter(p => p.level === 'bachelor').length;
  if (masterEl) masterEl.textContent = programsData.filter(p => p.level === 'master').length;
  if (phdEl) phdEl.textContent = programsData.filter(p => p.level === 'phd').length;
  
  function renderPrograms(filter = 'all') {
    let filtered = filter === 'all' ? programsData : programsData.filter(p => p.level === filter);
    
    let html = '';
    filtered.forEach(program => {
      html += `
      <div class="col-md-6 col-lg-4">
        <a href="/program-detail?id=${program.id}" class="text-decoration-none">
          <article class="program-card h-100">
            <div class="program-card__head">
              <span class="program-level-badge level-${program.level}">${program.levelLabel}</span>
              <span class="program-card__duration"><i class="fas fa-clock"></i>${program.duration}</span>
            </div>
            <h3 class="program-card__title">${program.name}</h3>
            <p class="program-card__desc">${program.desc}</p>
            <p class="program-card__college"><i class="fas fa-building-columns"></i>${program.college}</p>
            <div class="program-card__requirements">
              <i class="fas fa-clipboard-list"></i>${program.requirements}
            </div>
            <span class="read-more-link">عرض التفاصيل <i class="fas fa-arrow-left"></i></span>
          </article>
        </a>
      </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      const filter = e.currentTarget.getAttribute('data-filter');
      container.style.opacity = '0';
      setTimeout(() => {
        renderPrograms(filter);
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderPrograms();
}

// ============================================
// College Detail Page
// ============================================
function initCollegeDetailPage() {
  const container = document.getElementById('collegeDetailContent');
  if (!container) return;

  const params = new URLSearchParams(window.location.search);
  const collegeId = parseInt(params.get('id')) || 1;
  const college = collegesData.find(c => c.id === collegeId);
  const extra = collegeDetailExtra[collegeId];

  if (!college || !extra) {
    container.innerHTML = `
      <section class="page-hero">
        <div class="container">
          <div class="page-hero-content">
            <div class="page-hero-icon"><i class="fas fa-building-columns"></i></div>
            <h1 class="page-hero-title">الكلية غير موجودة</h1>
            <p class="page-hero-subtitle">عذراً، لم يتم العثور على الكلية المطلوبة</p>
            <div class="page-hero-breadcrumb">
              <a href="/">الرئيسية</a>
              <span class="sep"><i class="fas fa-chevron-left"></i></span>
              <a href="/colleges">الكليات</a>
              <span class="sep"><i class="fas fa-chevron-left"></i></span>
              <span class="current">غير موجود</span>
            </div>
          </div>
        </div>
      </section>
      <section class="college-detail-section">
        <div class="container text-center">
          <a href="/colleges" class="btn btn-accent px-5">العودة للكليات</a>
        </div>
      </section>`;
    return;
  }

  document.title = college.name + ' | جامعة المستقبل';
  const pageTitle = document.getElementById('pageTitle');
  if (pageTitle) pageTitle.textContent = college.name + ' | جامعة المستقبل';

  const depts = departmentsData[collegeId] || [];
  const collegePrograms = programsData.filter(p => p.college === college.name);
  const shortName = college.name.replace('كلية ', '');

  let deptsHTML = '';
  if (depts.length) {
    depts.forEach(dept => {
      deptsHTML += `
        <div class="col-md-6 col-lg-4">
          <a href="/departments?college=${collegeId}" class="text-decoration-none">
            <article class="dept-card h-100">
              <div class="dept-card__icon"><i class="fas ${dept.icon}"></i></div>
              <h3 class="dept-card__title">${dept.name}</h3>
              <p class="dept-card__desc">${dept.desc}</p>
              <div class="dept-card__stats">
                <span><i class="fas fa-book"></i>${dept.programs} برامج</span>
                <span><i class="fas fa-users"></i>${dept.faculty} عضو تدريس</span>
              </div>
            </article>
          </a>
        </div>`;
    });
  } else {
    deptsHTML = `
      <div class="col-12">
        <div class="college-detail-empty">
          <i class="fas fa-layer-group"></i>
          <p>تضم ${college.name} <strong>${college.depts}</strong> أقسام أكاديمية متخصصة.</p>
          <a href="/departments?college=${collegeId}" class="btn btn-accent btn-sm">عرض الأقسام</a>
        </div>
      </div>`;
  }

  let programsHTML = '';
  if (collegePrograms.length) {
    collegePrograms.forEach(program => {
      programsHTML += `
        <div class="col-md-6">
          <a href="/program-detail?id=${program.id}" class="text-decoration-none">
            <article class="college-detail-program">
              <span class="program-level-badge level-${program.level}">${program.levelLabel}</span>
              <h4 class="college-detail-program__title">${program.name}</h4>
              <p class="college-detail-program__desc">${program.desc}</p>
              <span class="read-more-link">عرض التفاصيل <i class="fas fa-arrow-left"></i></span>
            </article>
          </a>
        </div>`;
    });
  } else {
    programsHTML = `
      <div class="col-12">
        <div class="college-detail-empty">
          <i class="fas fa-book-open"></i>
          <p>تقدم ${college.name} أكثر من <strong>${college.programs}</strong> برنامجاً أكاديمياً.</p>
          <a href="/programs" class="btn btn-accent btn-sm">استكشف البرامج</a>
        </div>
      </div>`;
  }

  const deanLink = extra.deanStaffId
    ? `/staff-detail?id=${extra.deanStaffId}`
    : '/contact';

  container.innerHTML = `
    <section class="page-hero">
      <div class="container">
        <div class="page-hero-content">
          <div class="page-hero-icon"><i class="fas ${college.icon}"></i></div>
          <h1 class="page-hero-title">${college.name}</h1>
          <p class="page-hero-subtitle">${college.desc}</p>
          <div class="page-hero-breadcrumb">
            <a href="/">الرئيسية</a>
            <span class="sep"><i class="fas fa-chevron-left"></i></span>
            <a href="/colleges">الكليات</a>
            <span class="sep"><i class="fas fa-chevron-left"></i></span>
            <span class="current">${shortName}</span>
          </div>
        </div>
      </div>
    </section>

    <section class="college-detail-highlights section-fade-up">
      <div class="container">
        <div class="college-detail-highlights__grid">
          <div class="college-detail-highlight">
            <span class="college-detail-highlight__icon"><i class="fas fa-calendar"></i></span>
            <div>
              <strong class="college-detail-highlight__value en-text">${extra.established}</strong>
              <span class="college-detail-highlight__label">سنة التأسيس</span>
            </div>
          </div>
          <div class="college-detail-highlight">
            <span class="college-detail-highlight__icon"><i class="fas fa-users"></i></span>
            <div>
              <strong class="college-detail-highlight__value en-text">${extra.students}</strong>
              <span class="college-detail-highlight__label">طالب وطالبة</span>
            </div>
          </div>
          <div class="college-detail-highlight">
            <span class="college-detail-highlight__icon"><i class="fas fa-layer-group"></i></span>
            <div>
              <strong class="college-detail-highlight__value en-text">${college.depts}</strong>
              <span class="college-detail-highlight__label">قسم أكاديمي</span>
            </div>
          </div>
          <div class="college-detail-highlight">
            <span class="college-detail-highlight__icon"><i class="fas fa-certificate"></i></span>
            <div>
              <strong class="college-detail-highlight__value en-text">${extra.accreditation}</strong>
              <span class="college-detail-highlight__label">اعتماد أكاديمي</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="college-detail-section">
      <div class="container">
        <div class="row g-4 g-xl-5">
          <div class="col-lg-8">
            <div class="college-detail-panel section-fade-up">
              <h3 class="college-detail-panel__title"><i class="fas fa-eye ms-2"></i>الرؤية</h3>
              <p class="text-secondary mb-0" style="line-height: 1.9;">${extra.vision}</p>
            </div>
            <div class="college-detail-panel section-fade-up">
              <h3 class="college-detail-panel__title"><i class="fas fa-bullseye ms-2"></i>الرسالة</h3>
              <p class="text-secondary mb-0" style="line-height: 1.9;">${extra.mission}</p>
            </div>
            <div class="college-detail-panel section-fade-up">
              <h3 class="college-detail-panel__title"><i class="fas fa-layer-group ms-2"></i>الأقسام الأكاديمية</h3>
              <div class="row g-3">${deptsHTML}</div>
            </div>
            <div class="college-detail-panel section-fade-up">
              <h3 class="college-detail-panel__title"><i class="fas fa-book-open ms-2"></i>البرامج الأكاديمية</h3>
              <div class="row g-3">${programsHTML}</div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="college-detail-sidebar">
              <div class="college-detail-panel section-fade-up">
                <h3 class="college-detail-panel__title"><i class="fas fa-user-tie ms-2"></i>عميد الكلية</h3>
                <div class="college-detail-dean">
                  <div class="college-detail-dean__avatar"><i class="fas fa-user-tie"></i></div>
                  <h5 class="college-detail-dean__name">${extra.deanName}</h5>
                  <p class="college-detail-dean__role">عميد ${shortName}</p>
                  <a href="${deanLink}" class="btn btn-accent btn-sm w-100">الملف التعريفي</a>
                </div>
              </div>
              <div class="college-detail-panel section-fade-up">
                <h3 class="college-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>معلومات الكلية</h3>
                <div class="college-detail-info-row">
                  <span class="college-detail-info-row__label">المبنى</span>
                  <span class="college-detail-info-row__value">${extra.building}</span>
                </div>
                <div class="college-detail-info-row">
                  <span class="college-detail-info-row__label">البرامج</span>
                  <span class="college-detail-info-row__value en-text">${college.programs}+</span>
                </div>
                <div class="college-detail-info-row">
                  <span class="college-detail-info-row__label">الاعتماد</span>
                  <span class="college-detail-info-row__value en-text">${extra.accreditation}</span>
                </div>
              </div>
              <div class="college-detail-panel college-detail-cta-card section-fade-up">
                <h3 class="college-detail-panel__title"><i class="fas fa-graduation-cap ms-2"></i>انضم إلينا</h3>
                <p class="text-secondary small mb-3">قدّم طلب القبول في ${college.name} أو تواصل مع فريق القبول.</p>
                <a href="/admission" class="btn btn-accent w-100 mb-2">قدم الآن</a>
                <a href="/faculty" class="btn btn-glass w-100 btn-sm">هيئة التدريس</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="college-detail-cta section-fade-up">
      <div class="container">
        <div class="college-detail-cta__inner">
          <div>
            <h2 class="college-detail-cta__title">استكشف ${college.name}</h2>
            <p class="college-detail-cta__desc mb-0">تصفّح الأقسام والبرامج أو تواصل معنا للاستفسار.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <a href="/departments?college=${collegeId}" class="btn btn-accent px-4">الأقسام <i class="fas fa-arrow-left ms-2"></i></a>
            <a href="/programs" class="btn btn-glass college-detail-cta__btn-outline">البرامج</a>
          </div>
        </div>
      </div>
    </section>`;

  initScrollAnimations();
}

// ============================================
// Faculty Page
// ============================================
function initFacultyPage() {
  const container = document.getElementById('faculty-container');
  const filterTabs = document.querySelectorAll('#faculty-filter-tabs .nav-link');
  if (!container) return;

  const totalEl = document.getElementById('faculty-total-count');
  const collegesEl = document.getElementById('faculty-colleges-count');
  const professorsEl = document.getElementById('faculty-professors-count');
  const departmentsEl = document.getElementById('faculty-departments-count');

  const uniqueColleges = [...new Set(facultyData.map(f => f.collegeId))].length;
  const uniqueDepts = [...new Set(facultyData.map(f => f.department))].length;
  const professors = facultyData.filter(f => f.title === 'أستاذ' || f.title === 'أستاذ مشارك').length;

  if (totalEl) totalEl.textContent = facultyData.length;
  if (collegesEl) collegesEl.textContent = uniqueColleges;
  if (professorsEl) professorsEl.textContent = professors;
  if (departmentsEl) departmentsEl.textContent = uniqueDepts;

  function renderFaculty(filter = 'all') {
    const filtered = filter === 'all'
      ? facultyData
      : facultyData.filter(f => f.collegeId === parseInt(filter));

    let html = '';
    filtered.forEach(member => {
      html += `
        <div class="col-md-6 col-lg-4 col-xl-3">
          <article class="faculty-card h-100">
            <div class="faculty-card__avatar"><i class="fas ${member.icon}"></i></div>
            <h3 class="faculty-card__name">${member.name}</h3>
            <p class="faculty-card__title">${member.title}</p>
            <p class="faculty-card__college"><i class="fas fa-building-columns ms-1"></i>${member.college}</p>
            <p class="faculty-card__dept">${member.department}</p>
            <span class="faculty-card__specialty">${member.specialty}</span>
          </article>
        </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      const filter = e.currentTarget.getAttribute('data-filter');
      container.style.opacity = '0';
      setTimeout(() => {
        renderFaculty(filter);
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderFaculty();
}

// ============================================
// Events Page
// ============================================
function initEventsPage() {
  const container = document.getElementById('events-container');
  const filterTabs = document.querySelectorAll('#events-filter-tabs .nav-link');
  if (!container) return;

  const totalEl = document.getElementById('events-total-count');
  const confEl = document.getElementById('events-conference-count');
  const workshopEl = document.getElementById('events-workshop-count');
  const careerEl = document.getElementById('events-career-count');

  if (totalEl) totalEl.textContent = eventsData.length;
  if (confEl) confEl.textContent = eventsData.filter(e => e.category === 'conference').length;
  if (workshopEl) workshopEl.textContent = eventsData.filter(e => e.category === 'workshop').length;
  if (careerEl) careerEl.textContent = eventsData.filter(e => ['career', 'graduation', 'open-day'].includes(e.category)).length;

  function renderEvents(filter = 'all') {
    const filtered = filter === 'all'
      ? eventsData
      : eventsData.filter(e => e.category === filter);

    let html = '';
    filtered.forEach(event => {
      html += `
        <div class="col-md-6">
          <a href="/event-detail?id=${event.id}" class="text-decoration-none">
            <article class="news-event-item h-100">
              <div class="news-event-item__date">
                <span class="day en-text">${event.date.day}</span>
                <span class="month">${event.date.month}</span>
              </div>
              <div class="news-event-item__body">
                <span class="events-card__badge"><i class="fas ${event.icon} ms-1"></i>${event.categoryLabel}</span>
                <h3 class="news-event-item__title">${event.title}</h3>
                <p class="news-event-item__desc">${event.desc}</p>
                <span class="news-event-item__location"><i class="fas fa-map-marker-alt ms-1"></i>${event.location}</span>
                <span class="read-more-link d-block mt-2">التفاصيل <i class="fas fa-arrow-left"></i></span>
              </div>
            </article>
          </a>
        </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      const filter = e.currentTarget.getAttribute('data-filter');
      container.style.opacity = '0';
      setTimeout(() => {
        renderEvents(filter);
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderEvents();
}

// ============================================
// Event Detail Page
// ============================================
function initEventDetailPage() {
  const container = document.getElementById('eventDetailContent');
  if (!container) return;

  const params = new URLSearchParams(window.location.search);
  const eventId = parseInt(params.get('id')) || 1;
  const event = eventsData.find(e => e.id === eventId);
  const extra = eventDetailExtra[eventId];

  if (!event || !extra) {
    container.innerHTML = `
      <section class="page-hero">
        <div class="container">
          <div class="page-hero-content">
            <div class="page-hero-icon"><i class="fas fa-calendar-xmark"></i></div>
            <h1 class="page-hero-title">الفعالية غير موجودة</h1>
            <p class="page-hero-subtitle">عذراً، لم يتم العثور على الفعالية المطلوبة</p>
            <div class="page-hero-breadcrumb">
              <a href="/">الرئيسية</a>
              <span class="sep"><i class="fas fa-chevron-left"></i></span>
              <a href="/events">الفعاليات</a>
              <span class="sep"><i class="fas fa-chevron-left"></i></span>
              <span class="current">غير موجود</span>
            </div>
          </div>
        </div>
      </section>
      <section class="event-detail-section">
        <div class="container text-center">
          <a href="/events" class="btn btn-accent px-5">العودة للفعاليات</a>
        </div>
      </section>`;
    return;
  }

  document.title = event.title + ' | جامعة المستقبل';
  const pageTitle = document.getElementById('pageTitle');
  if (pageTitle) pageTitle.textContent = event.title + ' | جامعة المستقبل';

  let agendaHTML = '';
  extra.agenda.forEach(item => {
    agendaHTML += `
      <div class="event-detail-agenda__item">
        <span class="event-detail-agenda__time en-text">${item.time}</span>
        <div>
          <h6 class="event-detail-agenda__title">${item.title}</h6>
          ${item.speaker !== '—' ? `<p class="event-detail-agenda__speaker"><i class="fas fa-user" aria-hidden="true"></i><span>${item.speaker}</span></p>` : ''}
        </div>
      </div>`;
  });

  let speakersHTML = '';
  extra.speakers.forEach(s => {
    speakersHTML += `
      <div class="event-detail-speaker">
        <div class="event-detail-speaker__avatar"><i class="fas fa-user-tie"></i></div>
        <div>
          <h6 class="event-detail-speaker__name">${s.name}</h6>
          <p class="event-detail-speaker__role">${s.role}</p>
        </div>
      </div>`;
  });

  const related = eventsData.filter(e => e.category === event.category && e.id !== event.id).slice(0, 3);
  let relatedHTML = '';
  related.forEach(r => {
    relatedHTML += `
      <a href="/event-detail?id=${r.id}" class="event-detail-related">
        <span class="event-detail-related__date en-text">${r.date.day} ${r.date.month}</span>
        <span class="event-detail-related__title">${r.title}</span>
        <i class="fas fa-arrow-left event-detail-related__arrow"></i>
      </a>`;
  });
  if (!relatedHTML) {
    relatedHTML = '<p class="text-secondary small mb-0">لا توجد فعاليات مشابهة حالياً.</p>';
  }

  const registerBtn = extra.registration
    ? `<button type="button" class="btn btn-accent w-100 mb-2" id="eventRegisterBtn">سجّل حضورك</button>`
    : `<p class="text-secondary small mb-3">الحضور بدعوة أو تسجيل مسبق عبر عمادة شؤون الطلاب.</p>`;

  container.innerHTML = `
    <section class="page-hero">
      <div class="container">
        <div class="page-hero-content">
          <div class="page-hero-icon"><i class="fas ${event.icon}"></i></div>
          <h1 class="page-hero-title">${event.title}</h1>
          <p class="page-hero-subtitle">
            <span class="events-card__badge"><i class="fas ${event.icon} ms-1"></i>${event.categoryLabel}</span>
            · ${extra.fullDate}
          </p>
          <div class="page-hero-breadcrumb">
            <a href="/">الرئيسية</a>
            <span class="sep"><i class="fas fa-chevron-left"></i></span>
            <a href="/events">الفعاليات</a>
            <span class="sep"><i class="fas fa-chevron-left"></i></span>
            <span class="current">${event.title.length > 30 ? event.title.slice(0, 30) + '…' : event.title}</span>
          </div>
        </div>
      </div>
    </section>

    <section class="event-detail-highlights section-fade-up">
      <div class="container">
        <div class="event-detail-highlights__grid">
          <div class="event-detail-highlight">
            <span class="event-detail-highlight__icon"><i class="fas fa-calendar"></i></span>
            <div>
              <strong class="event-detail-highlight__value">${extra.fullDate}</strong>
              <span class="event-detail-highlight__label">التاريخ</span>
            </div>
          </div>
          <div class="event-detail-highlight">
            <span class="event-detail-highlight__icon"><i class="fas fa-clock"></i></span>
            <div>
              <strong class="event-detail-highlight__value en-text">${extra.time}</strong>
              <span class="event-detail-highlight__label">الوقت</span>
            </div>
          </div>
          <div class="event-detail-highlight">
            <span class="event-detail-highlight__icon"><i class="fas fa-map-marker-alt"></i></span>
            <div>
              <strong class="event-detail-highlight__value">${event.location}</strong>
              <span class="event-detail-highlight__label">المكان</span>
            </div>
          </div>
          <div class="event-detail-highlight">
            <span class="event-detail-highlight__icon"><i class="fas fa-users"></i></span>
            <div>
              <strong class="event-detail-highlight__value">${extra.capacity}</strong>
              <span class="event-detail-highlight__label">السعة</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="event-detail-section">
      <div class="container">
        <div class="row g-4 g-xl-5">
          <div class="col-lg-8">
            <div class="event-detail-panel section-fade-up">
              <h3 class="event-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>عن الفعالية</h3>
              <p class="text-secondary mb-0" style="line-height: 1.9;">${extra.longDesc}</p>
            </div>
            <div class="event-detail-panel section-fade-up">
              <h3 class="event-detail-panel__title"><i class="fas fa-list-check ms-2"></i>جدول الفعالية</h3>
              <div class="event-detail-agenda">${agendaHTML}</div>
            </div>
            <div class="event-detail-panel section-fade-up">
              <h3 class="event-detail-panel__title"><i class="fas fa-microphone ms-2"></i>المتحدثون</h3>
              <div class="event-detail-speakers">${speakersHTML}</div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="event-detail-sidebar">
              <div class="event-detail-panel event-detail-register section-fade-up">
                <h3 class="event-detail-panel__title"><i class="fas fa-ticket ms-2"></i>التسجيل</h3>
                ${registerBtn}
                <a href="/contact" class="btn btn-glass w-100 btn-sm">استفسار</a>
              </div>
              <div class="event-detail-panel section-fade-up">
                <h3 class="event-detail-panel__title"><i class="fas fa-clipboard-list ms-2"></i>معلومات الفعالية</h3>
                <div class="event-detail-info-row">
                  <span class="event-detail-info-row__label">المنظم</span>
                  <span class="event-detail-info-row__value">${extra.organizer}</span>
                </div>
                <div class="event-detail-info-row">
                  <span class="event-detail-info-row__label">الجمهور</span>
                  <span class="event-detail-info-row__value">${extra.audience}</span>
                </div>
                <div class="event-detail-info-row">
                  <span class="event-detail-info-row__label">السنة</span>
                  <span class="event-detail-info-row__value en-text">${extra.year}</span>
                </div>
                <div class="event-detail-info-row">
                  <span class="event-detail-info-row__label">المكان</span>
                  <span class="event-detail-info-row__value">${event.location}</span>
                </div>
              </div>
              <div class="event-detail-panel section-fade-up">
                <h3 class="event-detail-panel__title"><i class="fas fa-calendar-days ms-2"></i>فعاليات ذات صلة</h3>
                ${relatedHTML}
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="event-detail-cta section-fade-up">
      <div class="container">
        <div class="event-detail-cta__inner">
          <div>
            <h2 class="event-detail-cta__title">لا تفوّت ${event.title}</h2>
            <p class="event-detail-cta__desc mb-0">سجّل حضورك أو تصفّح المزيد من فعاليات الجامعة.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            ${extra.registration ? `<button type="button" class="btn btn-accent px-4" id="eventRegisterBtnCta">سجّل الآن <i class="fas fa-arrow-left ms-2"></i></button>` : ''}
            <a href="/events" class="btn btn-glass event-detail-cta__btn-outline">كل الفعاليات</a>
          </div>
        </div>
      </div>
    </section>`;

  const registerHandler = () => showToast('تم تسجيل اهتمامك! سنتواصل معك قريباً.', 'success');
  document.getElementById('eventRegisterBtn')?.addEventListener('click', registerHandler);
  document.getElementById('eventRegisterBtnCta')?.addEventListener('click', registerHandler);

  initScrollAnimations();
}

// ============================================
// FAQ Page
// ============================================
function initFaqPage() {
  const accordion = document.getElementById('faq-accordion');
  const filterTabs = document.querySelectorAll('#faq-filter-tabs .nav-link');
  if (!accordion) return;

  const totalEl = document.getElementById('faq-total-count');
  const categoriesEl = document.getElementById('faq-categories-count');
  const admissionEl = document.getElementById('faq-admission-count');

  const totalQuestions = faqData.reduce((sum, cat) => sum + cat.items.length, 0);
  const admissionQuestions = faqData.find(c => c.category === 'admission')?.items.length || 0;

  if (totalEl) totalEl.textContent = totalQuestions;
  if (categoriesEl) categoriesEl.textContent = faqData.length;
  if (admissionEl) admissionEl.textContent = admissionQuestions;

  let accordionIndex = 0;

  function buildAccordion(categories) {
    let html = '';
    categories.forEach(cat => {
      cat.items.forEach(item => {
        const id = `faq-${accordionIndex}`;
        html += `
          <div class="accordion-item faq-accordion-item" data-category="${cat.category}">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#${id}" aria-expanded="false" aria-controls="${id}">
                <span class="faq-accordion-item__cat">${cat.categoryLabel}</span>
                ${item.q}
              </button>
            </h2>
            <div id="${id}" class="accordion-collapse collapse" data-bs-parent="#faq-accordion">
              <div class="accordion-body faq-accordion-item__body">${item.a}</div>
            </div>
          </div>`;
        accordionIndex++;
      });
    });
    accordion.innerHTML = html;
  }

  function renderFaq(filter = 'all') {
    accordionIndex = 0;
    const categories = filter === 'all'
      ? faqData
      : faqData.filter(c => c.category === filter);
    buildAccordion(categories);
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      const filter = e.currentTarget.getAttribute('data-filter');
      accordion.style.opacity = '0';
      setTimeout(() => {
        renderFaq(filter);
        accordion.style.opacity = '1';
      }, 200);
    });
  });

  renderFaq();
}

// ============================================
// Scholarships Page
// ============================================
function initScholarshipsPage() {
  const container = document.getElementById('scholarships-container');
  const filterTabs = document.querySelectorAll('#scholarships-filter-tabs .nav-link');
  if (!container) return;

  const totalEl = document.getElementById('scholarships-total-count');
  const meritEl = document.getElementById('scholarships-merit-count');
  const maxEl = document.getElementById('scholarships-max-coverage');
  const typesEl = document.getElementById('scholarships-types-count');

  if (totalEl) totalEl.textContent = scholarshipsData.length;
  if (meritEl) meritEl.textContent = scholarshipsData.filter(s => s.type === 'merit').length;
  if (maxEl) maxEl.textContent = '100%';
  if (typesEl) typesEl.textContent = [...new Set(scholarshipsData.map(s => s.type))].length;

  function renderScholarships(filter = 'all') {
    const filtered = filter === 'all' ? scholarshipsData : scholarshipsData.filter(s => s.type === filter);
    let html = '';
    filtered.forEach(s => {
      html += `
        <div class="col-md-6 col-lg-4">
          <article class="resource-card h-100">
            <div class="resource-card__head">
              <span class="resource-card__badge">${s.typeLabel}</span>
              <span class="resource-card__coverage en-text">${s.coverage}</span>
            </div>
            <div class="resource-card__icon"><i class="fas ${s.icon}"></i></div>
            <h3 class="resource-card__title">${s.title}</h3>
            <p class="resource-card__desc">${s.desc}</p>
            <ul class="resource-card__meta list-unstyled mb-3">
              <li><i class="fas fa-clipboard-check"></i>${s.requirements}</li>
              <li><i class="fas fa-calendar"></i>آخر موعد: ${s.deadline}</li>
            </ul>
            <button type="button" class="btn btn-accent btn-sm w-100 scholarship-apply-btn" data-title="${s.title}">قدّم طلب المنحة</button>
          </article>
        </div>`;
    });
    container.innerHTML = html;
    container.querySelectorAll('.scholarship-apply-btn').forEach(btn => {
      btn.addEventListener('click', () => showToast(`تم تسجيل اهتمامك بـ «${btn.dataset.title}»`, 'success'));
    });
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      container.style.opacity = '0';
      setTimeout(() => {
        renderScholarships(e.currentTarget.getAttribute('data-filter'));
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderScholarships();
}

// ============================================
// Tuition Fees Page
// ============================================
function initTuitionPage() {
  const container = document.getElementById('tuition-container');
  const filterTabs = document.querySelectorAll('#tuition-filter-tabs .nav-link');
  if (!container) return;

  const avgEl = document.getElementById('tuition-avg-count');
  const bachelorEl = document.getElementById('tuition-bachelor-count');
  const masterEl = document.getElementById('tuition-master-count');
  const phdEl = document.getElementById('tuition-phd-count');

  const bachelorFees = tuitionFeesData.filter(f => f.level === 'bachelor');
  const avg = Math.round(tuitionFeesData.reduce((s, f) => s + f.annual, 0) / tuitionFeesData.length);

  if (avgEl) avgEl.textContent = avg.toLocaleString('ar-SA');
  if (bachelorEl) bachelorEl.textContent = bachelorFees.length;
  if (masterEl) masterEl.textContent = tuitionFeesData.filter(f => f.level === 'master').length;
  if (phdEl) phdEl.textContent = tuitionFeesData.filter(f => f.level === 'phd').length;

  function renderTuition(filter = 'all') {
    const filtered = filter === 'all' ? tuitionFeesData : tuitionFeesData.filter(f => f.level === filter);
    let html = '';
    filtered.forEach(f => {
      html += `
        <div class="col-md-6 col-lg-4">
          <article class="resource-card resource-card--fee h-100">
            <div class="resource-card__head">
              <span class="resource-card__badge level-${f.level}">${f.levelLabel}</span>
            </div>
            <h3 class="resource-card__title">${f.college}</h3>
            <div class="tuition-fee-row">
              <span class="tuition-fee-row__label">رسوم سنوية</span>
              <strong class="tuition-fee-row__value en-text">${f.annual.toLocaleString('ar-SA')} <small>ر.س</small></strong>
            </div>
            <div class="tuition-fee-row">
              <span class="tuition-fee-row__label">رسوم فصلية</span>
              <strong class="tuition-fee-row__value en-text">${f.semester.toLocaleString('ar-SA')} <small>ر.س</small></strong>
            </div>
            <div class="tuition-fee-row">
              <span class="tuition-fee-row__label">رسوم تسجيل</span>
              <strong class="tuition-fee-row__value en-text">${f.registration.toLocaleString('ar-SA')} <small>ر.س</small></strong>
            </div>
          </article>
        </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      container.style.opacity = '0';
      setTimeout(() => {
        renderTuition(e.currentTarget.getAttribute('data-filter'));
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderTuition();
}

// ============================================
// Student Services Page
// ============================================
function initStudentServicesPage() {
  const container = document.getElementById('services-container');
  const filterTabs = document.querySelectorAll('#services-filter-tabs .nav-link');
  if (!container) return;

  const totalEl = document.getElementById('services-total-count');
  const academicEl = document.getElementById('services-academic-count');
  const digitalEl = document.getElementById('services-digital-count');
  const supportEl = document.getElementById('services-support-count');

  if (totalEl) totalEl.textContent = studentServicesData.length;
  if (academicEl) academicEl.textContent = studentServicesData.filter(s => s.category === 'academic').length;
  if (digitalEl) digitalEl.textContent = studentServicesData.filter(s => s.category === 'digital').length;
  if (supportEl) supportEl.textContent = studentServicesData.filter(s => s.hours === '24/7').length;

  function renderServices(filter = 'all') {
    const filtered = filter === 'all' ? studentServicesData : studentServicesData.filter(s => s.category === filter);
    let html = '';
    filtered.forEach(s => {
      html += `
        <div class="col-md-6 col-lg-4">
          <article class="resource-card h-100">
            <div class="resource-card__icon"><i class="fas ${s.icon}"></i></div>
            <span class="resource-card__badge">${s.categoryLabel}</span>
            <h3 class="resource-card__title">${s.title}</h3>
            <p class="resource-card__desc">${s.desc}</p>
            <ul class="resource-card__meta list-unstyled mb-0">
              <li><i class="fas fa-clock"></i>${s.hours}</li>
              <li><i class="fas fa-envelope"></i><span class="en-text">${s.contact}</span></li>
            </ul>
          </article>
        </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      container.style.opacity = '0';
      setTimeout(() => {
        renderServices(e.currentTarget.getAttribute('data-filter'));
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderServices();
}

// ============================================
// Academic Calendar Page
// ============================================
function initCalendarPage() {
  const container = document.getElementById('calendar-container');
  const filterTabs = document.querySelectorAll('#calendar-filter-tabs .nav-link');
  if (!container) return;

  const totalEl = document.getElementById('calendar-total-count');
  const fallEl = document.getElementById('calendar-fall-count');
  const examEl = document.getElementById('calendar-exam-count');
  const holidayEl = document.getElementById('calendar-holiday-count');

  if (totalEl) totalEl.textContent = academicCalendarData.length;
  if (fallEl) fallEl.textContent = academicCalendarData.filter(e => e.semester === 'fall').length;
  if (examEl) examEl.textContent = academicCalendarData.filter(e => e.type === 'exam').length;
  if (holidayEl) holidayEl.textContent = academicCalendarData.filter(e => e.type === 'holiday').length;

  const typeLabels = {
    admission: 'قبول', registration: 'تسجيل', start: 'بداية', end: 'نهاية',
    exam: 'اختبار', holiday: 'إجازة', deadline: 'موعد نهائي'
  };

  function renderCalendar(filter = 'all') {
    const filtered = filter === 'all' ? academicCalendarData : academicCalendarData.filter(e => e.semester === filter);
    let html = '';
    filtered.forEach(item => {
      html += `
        <div class="calendar-timeline__item">
          <div class="calendar-timeline__marker"><i class="fas ${item.icon}"></i></div>
          <article class="calendar-timeline__card">
            <div class="calendar-timeline__head">
              <span class="calendar-timeline__semester">${item.semesterLabel}</span>
              <span class="calendar-timeline__type">${typeLabels[item.type] || item.type}</span>
            </div>
            <h3 class="calendar-timeline__title">${item.title}</h3>
            <span class="calendar-timeline__date"><i class="fas fa-calendar ms-1"></i>${item.date}</span>
          </article>
        </div>`;
    });
    container.innerHTML = html;
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      container.style.opacity = '0';
      setTimeout(() => {
        renderCalendar(e.currentTarget.getAttribute('data-filter'));
        container.style.opacity = '1';
      }, 200);
    });
  });

  renderCalendar();
}

// ============================================
// Staff Page
// ============================================
function initStaffPage() {
  const leadershipEl = document.getElementById('staff-leadership-container');
  const deansEl = document.getElementById('staff-deans-container');
  if (!leadershipEl && !deansEl) return;

  const leadership = staffData.filter(s => s.tier === 'leadership');
  const deans = staffData.filter(s => s.tier === 'dean');

  const leadershipCount = document.getElementById('staff-leadership-count');
  const deansCount = document.getElementById('staff-deans-count');
  const collegesCount = document.getElementById('staff-colleges-count');
  const totalCount = document.getElementById('staff-total-count');

  if (leadershipCount) leadershipCount.textContent = leadership.length;
  if (deansCount) deansCount.textContent = deans.length;
  if (collegesCount) collegesCount.textContent = deans.length;
  if (totalCount) totalCount.textContent = staffData.length;

  function cardHTML(staff, large) {
    const imgSize = large ? 'style="width:140px;height:140px;"' : '';
    const iconSize = large ? 'style="font-size:3.5rem;"' : '';
    const colClass = large ? 'col-md-6 col-lg-4' : 'col-md-6 col-lg-4 col-xl-3';
    const padding = large ? 'p-5' : 'p-4';
    const heading = large ? 'h4' : 'h5';
    return `
    <div class="${colClass}">
      <a href="/staff-detail?id=${staff.id}" class="text-decoration-none">
        <div class="glass-card staff-card ${padding} text-center h-100">
          <div class="staff-image" ${imgSize}>
            <i class="fas ${staff.icon}" ${iconSize}></i>
          </div>
          <${heading} class="fw-bold text-white mb-1">${staff.name}</${heading}>
          <p class="staff-position mb-${large ? '3' : '2'}">${staff.position}</p>
          <p class="text-secondary small${large ? '' : ' mb-3'}">${staff.bio}</p>
        </div>
      </a>
    </div>`;
  }

  if (leadershipEl) {
    leadershipEl.innerHTML = leadership.map(s => cardHTML(s, true)).join('');
  }
  if (deansEl) {
    deansEl.innerHTML = deans.map(s => cardHTML(s, false)).join('');
  }
}

// ============================================
// Research Detail Page
// ============================================
function initResearchDetailPage() {
  const container = document.getElementById('researchDetailContent');
  if (!container) return;

  const params = new URLSearchParams(window.location.search);
  const researchId = parseInt(params.get('id')) || 1;
  const research = researchData.find(r => r.id === researchId);
  const extra = researchDetailExtra[researchId];

  if (!research || !extra) {
    container.innerHTML = `
      <section class="page-hero">
        <div class="container">
          <div class="page-hero-content">
            <div class="page-hero-icon"><i class="fas fa-flask"></i></div>
            <h1 class="page-hero-title">مركز البحث غير موجود</h1>
            <p class="page-hero-subtitle">عذراً، لم يتم العثور على مركز البحث المطلوب</p>
            <div class="page-hero-breadcrumb">
              <a href="/">الرئيسية</a>
              <span class="sep"><i class="fas fa-chevron-left"></i></span>
              <a href="/research">البحث العلمي</a>
              <span class="sep"><i class="fas fa-chevron-left"></i></span>
              <span class="current">غير موجود</span>
            </div>
          </div>
        </div>
      </section>
      <section class="research-detail-section">
        <div class="container text-center">
          <a href="/research" class="btn btn-accent px-5">العودة للبحث العلمي</a>
        </div>
      </section>`;
    return;
  }

  document.title = research.title + ' | جامعة المستقبل';
  const pageTitle = document.getElementById('pageTitle');
  if (pageTitle) pageTitle.textContent = research.title + ' | جامعة المستقبل';

  let focusHTML = '';
  extra.focusAreas.forEach(area => {
    focusHTML += `<span class="research-detail-tag">${area}</span>`;
  });

  let projectsHTML = '';
  extra.activeProjects.forEach(p => {
    const statusClass = p.status === 'مكتمل' ? 'research-detail-project__status--done' : '';
    projectsHTML += `
      <div class="research-detail-project">
        <span class="research-detail-project__title">${p.title}</span>
        <span class="research-detail-project__status ${statusClass}">${p.status}</span>
      </div>`;
  });

  let partnersHTML = '';
  extra.partners.forEach(p => {
    partnersHTML += `<li><i class="fas fa-handshake"></i>${p}</li>`;
  });

  const related = researchData.filter(r => r.id !== research.id).slice(0, 3);
  let relatedHTML = '';
  related.forEach(r => {
    relatedHTML += `
      <a href="/research-detail?id=${r.id}" class="research-detail-related">
        <span class="research-detail-related__icon"><i class="fas ${r.icon}"></i></span>
        <span class="research-detail-related__title">${r.title}</span>
        <i class="fas fa-arrow-left research-detail-related__arrow"></i>
      </a>`;
  });

  container.innerHTML = `
    <section class="page-hero">
      <div class="container">
        <div class="page-hero-content">
          <div class="page-hero-icon"><i class="fas ${research.icon}"></i></div>
          <h1 class="page-hero-title">${research.title}</h1>
          <p class="page-hero-subtitle">${research.desc}</p>
          <div class="page-hero-breadcrumb">
            <a href="/">الرئيسية</a>
            <span class="sep"><i class="fas fa-chevron-left"></i></span>
            <a href="/research">البحث العلمي</a>
            <span class="sep"><i class="fas fa-chevron-left"></i></span>
            <span class="current">${research.title}</span>
          </div>
        </div>
      </div>
    </section>

    <section class="research-detail-highlights section-fade-up">
      <div class="container">
        <div class="research-detail-highlights__grid">
          <div class="research-detail-highlight">
            <span class="research-detail-highlight__icon"><i class="fas fa-folder-open"></i></span>
            <div>
              <strong class="research-detail-highlight__value en-text">${research.projects}</strong>
              <span class="research-detail-highlight__label">مشروع بحثي</span>
            </div>
          </div>
          <div class="research-detail-highlight">
            <span class="research-detail-highlight__icon"><i class="fas fa-file-lines"></i></span>
            <div>
              <strong class="research-detail-highlight__value en-text">${research.publications}</strong>
              <span class="research-detail-highlight__label">منشور علمي</span>
            </div>
          </div>
          <div class="research-detail-highlight">
            <span class="research-detail-highlight__icon"><i class="fas fa-users"></i></span>
            <div>
              <strong class="research-detail-highlight__value en-text">${extra.stats.researchers}</strong>
              <span class="research-detail-highlight__label">باحث</span>
            </div>
          </div>
          <div class="research-detail-highlight">
            <span class="research-detail-highlight__icon"><i class="fas fa-calendar"></i></span>
            <div>
              <strong class="research-detail-highlight__value en-text">${extra.established}</strong>
              <span class="research-detail-highlight__label">سنة التأسيس</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="research-detail-section section-fade-up">
      <div class="container">
        <div class="row g-4">
          <div class="col-lg-8">
            <article class="research-detail-panel">
              <h2 class="research-detail-panel__title"><i class="fas fa-circle-info"></i> نبذة عن المركز</h2>
              <p class="research-detail-panel__text">${extra.longDesc}</p>
              <div class="research-detail-tags">${focusHTML}</div>
            </article>
            <article class="research-detail-panel mt-4">
              <h2 class="research-detail-panel__title"><i class="fas fa-flask"></i> المشاريع النشطة</h2>
              <div class="research-detail-projects">${projectsHTML}</div>
            </article>
          </div>
          <div class="col-lg-4">
            <aside class="research-detail-sidebar">
              <div class="research-detail-panel">
                <h3 class="research-detail-panel__title"><i class="fas fa-address-card"></i> معلومات المركز</h3>
                <div class="research-detail-info-row">
                  <span class="research-detail-info-row__label">المدير</span>
                  <span class="research-detail-info-row__value">${extra.director}</span>
                </div>
                <div class="research-detail-info-row">
                  <span class="research-detail-info-row__label">الكلية</span>
                  <span class="research-detail-info-row__value">${extra.college}</span>
                </div>
                <div class="research-detail-info-row">
                  <span class="research-detail-info-row__label">البريد</span>
                  <span class="research-detail-info-row__value en-text" dir="ltr">${extra.email}</span>
                </div>
                <div class="research-detail-info-row">
                  <span class="research-detail-info-row__label">الهاتف</span>
                  <span class="research-detail-info-row__value en-text" dir="ltr">${extra.phone}</span>
                </div>
                <div class="research-detail-info-row">
                  <span class="research-detail-info-row__label">المختبرات</span>
                  <span class="research-detail-info-row__value en-text">${extra.stats.labs}</span>
                </div>
                <div class="research-detail-info-row">
                  <span class="research-detail-info-row__label">المنح البحثية</span>
                  <span class="research-detail-info-row__value en-text">${extra.stats.grants}</span>
                </div>
              </div>
              <div class="research-detail-panel mt-4">
                <h3 class="research-detail-panel__title"><i class="fas fa-handshake"></i> الشركاء</h3>
                <ul class="research-detail-partners">${partnersHTML}</ul>
              </div>
              <div class="research-detail-panel mt-4">
                <h3 class="research-detail-panel__title"><i class="fas fa-link"></i> مراكز أخرى</h3>
                <div class="research-detail-related-list">${relatedHTML}</div>
              </div>
              <a href="/research" class="btn btn-accent w-100 mt-3">جميع مراكز البحث <i class="fas fa-arrow-left ms-2"></i></a>
            </aside>
          </div>
        </div>
      </div>
    </section>`;
}

// ============================================
// Privacy & Terms Pages
// ============================================
function buildLegalSections(container, sections) {
  if (!container) return;
  let html = '<div class="accordion legal-accordion" id="legal-accordion">';
  sections.forEach((section, index) => {
    const id = `legal-${section.id}`;
    const expanded = index === 0 ? 'true' : 'false';
    const collapsed = index === 0 ? '' : ' collapsed';
    const show = index === 0 ? ' show' : '';
    html += `
      <div class="accordion-item legal-accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button${collapsed}" type="button" data-bs-toggle="collapse" data-bs-target="#${id}" aria-expanded="${expanded}" aria-controls="${id}">
            <span class="legal-accordion-item__num en-text">${index + 1}</span>
            ${section.title}
          </button>
        </h2>
        <div id="${id}" class="accordion-collapse collapse${show}" data-bs-parent="#legal-accordion">
          <div class="accordion-body legal-accordion-item__body">${section.content}</div>
        </div>
      </div>`;
  });
  html += '</div>';
  container.innerHTML = html;
}

function initPrivacyPage() {
  const container = document.getElementById('privacy-sections');
  const sectionsCount = document.getElementById('privacy-sections-count');
  if (sectionsCount) sectionsCount.textContent = privacySections.length;
  buildLegalSections(container, privacySections);
}

function initTermsPage() {
  const container = document.getElementById('terms-sections');
  const sectionsCount = document.getElementById('terms-sections-count');
  if (sectionsCount) sectionsCount.textContent = termsSections.length;
  buildLegalSections(container, termsSections);
}

function renderNews() {
  const container = document.getElementById('news-container');
  if (!container) return;
  let html = '';
  newsData.forEach(news => {
    html += `
    <div class="col-md-6 col-lg-4">
      <a href="/blog" class="text-decoration-none">
      <article class="news-card h-100">
        <div class="news-image">
          <span class="news-date-badge"><span class="day">${news.date.day}</span><span class="month">${news.date.month}</span></span>
          <div class="news-placeholder d-flex align-items-center justify-content-center" style="background-color: ${news.color}; height: 220px;">
            <i class="fas ${news.icon} fa-3x text-white opacity-50"></i>
          </div>
        </div>
        <div class="news-card__body">
          <span class="news-card__category">${news.category}</span>
          <h3 class="news-card__title">${news.title}</h3>
          <p class="news-card__excerpt">${news.excerpt}</p>
          <span class="read-more-link">اقرأ المزيد <i class="fas fa-arrow-left"></i></span>
        </div>
      </article>
      </a>
    </div>`;
  });
  container.innerHTML = html;
}

function renderStaff() {
  const container = document.getElementById('staff-container');
  if (!container) return;
  let html = '';
  staffData.forEach((staff, index) => {
    html += `
    <div class="col-md-6 col-lg-4 col-xl-3">
      <a href="/staff-detail?id=${staff.id}" class="text-decoration-none">
      <div class="glass-card staff-card p-4 text-center h-100">
        <div class="staff-image">
          <i class="fas ${staff.icon}"></i>
        </div>
        <h5 class="fw-bold mb-1">${staff.name}</h5>
        <p class="staff-position mb-2">${staff.position}</p>
        <p class="text-secondary small mb-3">${staff.bio}</p>
      </div>
      </a>
    </div>`;
  });
  container.innerHTML = html;
}

function renderResearch() {
  const container = document.getElementById('research-container');
  if (!container) return;
  let html = '';
  researchData.forEach(research => {
    html += `
    <div class="col-md-6 col-lg-4">
      <a href="/research-detail?id=${research.id}" class="text-decoration-none">
      <article class="research-card h-100">
        <div class="research-card__icon"><i class="fas ${research.icon}"></i></div>
        <h3 class="research-card__title">${research.title}</h3>
        <p class="research-card__desc">${research.desc}</p>
        <div class="research-card__stats">
          <span><i class="fas fa-folder-open"></i>${research.projects} مشروع</span>
          <span><i class="fas fa-file-lines"></i>${research.publications} منشور</span>
        </div>
      </article>
      </a>
    </div>`;
  });
  container.innerHTML = html;
}

// ============================================
// Contact Form
// ============================================
function initContactForm() {
  const form = document.getElementById('contact-form');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const name = form.querySelector('[name="name"]').value.trim();
    const email = form.querySelector('[name="email"]').value.trim();
    const subject = form.querySelector('[name="subject"]').value.trim();
    const message = form.querySelector('[name="message"]').value.trim();
    
    if (!name || !email || !message) {
      showToast('يرجى تعبئة جميع الحقول المطلوبة', 'warning');
      return;
    }
    
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin ms-2"></i> جارٍ الإرسال...';
    
    setTimeout(() => {
      showToast('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً', 'success');
      form.reset();
      btn.disabled = false;
      btn.innerHTML = 'إرسال الرسالة <i class="fas fa-paper-plane ms-2"></i>';
    }, 2000);
  });
}

// ============================================
// Library Page
// ============================================
function initLibraryPage() {
  const container = document.getElementById('library-container');
  if (!container || !container.dataset.searchUrl) return;

  const filterTabs = document.querySelectorAll('#library-filter-tabs .nav-link');
  const searchInput = document.getElementById('library-search');
  const totalCount = document.getElementById('total-books-count');
  const searchUrl = container.dataset.searchUrl;
  let currentFilter = document.querySelector('#library-filter-tabs .nav-link.active')?.getAttribute('data-filter') || 'all';
  let currentSearch = searchInput ? searchInput.value.trim() : '';
  let fetchController = null;

  function fetchBooks() {
    if (fetchController) fetchController.abort();
    fetchController = new AbortController();

    const params = new URLSearchParams();
    if (currentFilter && currentFilter !== 'all') params.set('category', currentFilter);
    if (currentSearch) params.set('q', currentSearch);

    container.style.opacity = '0.5';

    fetch(`${searchUrl}?${params.toString()}`, {
      headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
      signal: fetchController.signal,
    })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          container.innerHTML = data.html;
          if (totalCount) totalCount.textContent = data.count;
        }
      })
      .catch(err => {
        if (err.name !== 'AbortError') console.error('Library search failed:', err);
      })
      .finally(() => {
        container.style.opacity = '1';
      });
  }

  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      e.currentTarget.classList.add('active');
      currentFilter = e.currentTarget.getAttribute('data-filter');
      fetchBooks();
    });
  });

  if (searchInput) {
    let debounce;
    searchInput.addEventListener('input', (e) => {
      clearTimeout(debounce);
      debounce = setTimeout(() => {
        currentSearch = e.target.value.trim();
        fetchBooks();
      }, 300);
    });
  }
}

// ============================================
// Admission Form
// ============================================
function initAdmissionForm() {
  const form = document.getElementById('admission-form');
  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const requiredFields = form.querySelectorAll('[required]');
    let allFilled = true;
    requiredFields.forEach(field => {
      if (field.type === 'checkbox' && !field.checked) {
        allFilled = false;
        field.classList.add('is-invalid');
      } else if (!field.value.trim()) {
        allFilled = false;
        field.classList.add('is-invalid');
      } else {
        field.classList.remove('is-invalid');
      }
    });
    if (!allFilled) {
      showToast('يرجى تعبئة جميع الحقول المطلوبة والموافقة على الشروط', 'warning');
      return;
    }
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin ms-2"></i> جارٍ إرسال الطلب...';
    setTimeout(() => {
      const refNum = 'APP-' + Date.now().toString().slice(-6);
      showToast('تم إرسال طلبك بنجاح! رقم المرجع: ' + refNum, 'success');
      form.reset();
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-paper-plane ms-2"></i>إرسال طلب القبول';
    }, 2500);
  });
  form.querySelectorAll('input, select').forEach(field => {
    field.addEventListener('focus', () => field.classList.remove('is-invalid'));
  });
}

// ============================================
// Animations
// ============================================
function initTypingAnimation() {
  const typingElement = document.querySelector('.typing-text');
  if (!typingElement) return;
  const texts = JSON.parse(typingElement.getAttribute('data-text')) || [];
  let textIndex = 0, charIndex = 0, isDeleting = false;
  
  function type() {
    const currentText = texts[textIndex];
    if (isDeleting) {
      typingElement.textContent = currentText.substring(0, charIndex - 1);
      charIndex--;
    } else {
      typingElement.textContent = currentText.substring(0, charIndex + 1);
      charIndex++;
    }
    let typeSpeed = isDeleting ? 50 : 100;
    if (!isDeleting && charIndex === currentText.length) { typeSpeed = 2000; isDeleting = true; }
    else if (isDeleting && charIndex === 0) { isDeleting = false; textIndex = (textIndex + 1) % texts.length; typeSpeed = 500; }
    setTimeout(type, typeSpeed);
  }
  setTimeout(type, 1000);
}

function initCounters() {
  const counters = document.querySelectorAll('.counter');
  const duration = 2000;
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = entry.target;
        const finalValue = parseInt(target.getAttribute('data-target'));
        const startTime = performance.now();
        function updateCounter(currentTime) {
          const elapsed = currentTime - startTime;
          if (elapsed < duration) {
            const current = Math.floor((elapsed / duration) * finalValue);
            target.innerText = current >= 1000 ? (current/1000).toFixed(1) + 'K+' : current;
            requestAnimationFrame(updateCounter);
          } else {
            target.innerText = finalValue >= 1000 ? (finalValue/1000).toFixed(0) + 'K+' : finalValue;
          }
        }
        requestAnimationFrame(updateCounter);
        observer.unobserve(target);
      }
    });
  }, { threshold: 0.5 });
  counters.forEach(c => observer.observe(c));
}

function initScrollAnimations() {
  const fadeElements = document.querySelectorAll('.section-fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  fadeElements.forEach(el => observer.observe(el));
}

function initBackToTop() {
  const btn = document.getElementById('backToTop');
  if (!btn) return;
  window.addEventListener('scroll', () => {
    btn.classList.toggle('visible', window.scrollY > 400);
  });
  btn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ============================================
// Toast
// ============================================
function showToast(title, type='success') {
  let toastContainer = document.getElementById('toast-container');
  if (!toastContainer) {
    toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    toastContainer.style.position = 'fixed';
    toastContainer.style.bottom = '20px';
    toastContainer.style.left = '20px';
    toastContainer.style.zIndex = '9999';
    document.body.appendChild(toastContainer);
  }
  const toast = document.createElement('div');
  toast.className = 'toast align-items-center text-white border-0 glass-panel mb-2';
  toast.setAttribute('role', 'alert');
  toast.style.background = type === 'success' ? 'rgba(40, 167, 69, 0.85)' : type === 'warning' ? 'rgba(255, 193, 7, 0.85)' : 'rgba(220, 53, 69, 0.85)';
  toast.innerHTML = `
    <div class="d-flex align-items-center px-3 py-2" style="direction: rtl; gap: 10px;">
      <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'times-circle'}"></i>
      <span class="toast-body py-0 px-0 text-white">${title}</span>
      <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>`;
  toastContainer.appendChild(toast);
  try {
    const bsToast = new bootstrap.Toast(toast, { delay: 3500 });
    bsToast.show();
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
  } catch(e) {
    setTimeout(() => toast.remove(), 4000);
  }
}

function initSsrCollegeFilters() {
  const container = document.getElementById('all-colleges-container');
  const filterTabs = document.querySelectorAll('#college-filter-tabs .nav-link');
  if (!container || !container.dataset.ssr || !filterTabs.length) return;

  const items = container.querySelectorAll('.college-item');
  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const filter = tab.getAttribute('data-filter');
      container.style.opacity = '0';
      setTimeout(() => {
        items.forEach(item => {
          const cat = item.getAttribute('data-category');
          item.style.display = (filter === 'all' || cat === filter) ? '' : 'none';
        });
        container.style.opacity = '1';
      }, 200);
    });
  });
}

function initSsrProgramFilters() {
  const container = document.getElementById('programs-container');
  const filterTabs = document.querySelectorAll('#program-filter-tabs .nav-link');
  if (!container || !container.dataset.ssr || !filterTabs.length) return;

  const items = container.querySelectorAll('.program-item');
  filterTabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      filterTabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const filter = tab.getAttribute('data-filter');
      items.forEach(item => {
        const level = item.getAttribute('data-level');
        item.style.display = (filter === 'all' || level === filter) ? '' : 'none';
      });
    });
  });
}
