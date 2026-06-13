<?php

namespace Database\Seeders;

use App\Enums\ProgramLevel;
use App\Enums\StaffType;
use App\Models\Accreditation;
use App\Models\AdmissionCycle;
use App\Models\College;
use App\Models\Department;
use App\Models\HomepageHeroSlide;
use App\Models\HomepageStat;
use App\Models\Program;
use App\Models\StaffMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UniversitySeeder extends Seeder
{
    private array $collegeSlugs = [
        1 => 'engineering',
        2 => 'medicine',
        3 => 'business',
        4 => 'computer-science',
        5 => 'science',
        6 => 'pharmacy',
        7 => 'dentistry',
        8 => 'education',
        9 => 'law',
        10 => 'architecture',
        11 => 'languages',
        12 => 'design',
    ];

    private array $collegeCategories = [
        1 => 'engineering', 2 => 'medical', 3 => 'business', 4 => 'engineering',
        5 => 'science', 6 => 'medical', 7 => 'medical', 8 => 'science',
        9 => 'business', 10 => 'engineering', 11 => 'science', 12 => 'science',
    ];

    public function run(): void
    {
        $this->seedColleges();
        $this->seedDepartments();
        $this->seedPrograms();
        $this->seedStaff();
        $this->seedFaculty();
        $this->seedHomepage();
        $this->seedAdmissionCycle();
        $this->linkDeans();
    }

    private function seedColleges(): void
    {
        $colleges = [
            [1, 'كلية الهندسة', 'fa-gears', 'برامج في الهندسة المدنية والمعمارية والميكانيكية والكهربائية', 5, 12],
            [2, 'كلية الطب', 'fa-stethoscope', 'إعداد أطباء متميزين في مختلف التخصصات الطبية', 8, 15],
            [3, 'كلية إدارة الأعمال', 'fa-chart-line', 'برامج في الإدارة والمحاسبة والاقتصاد والتسويق', 4, 10],
            [4, 'كلية علوم الحاسب', 'fa-laptop-code', 'تخصصات في البرمجة والذكاء الاصطناعي وأمن المعلومات', 4, 9],
            [5, 'كلية العلوم', 'fa-flask', 'الفيزياء والكيمياء والأحياء والرياضيات التطبيقية', 5, 11],
            [6, 'كلية الصيدلة', 'fa-pills', 'إعداد صيادلة مؤهلين في مجالات الصناعة والبحث السريري', 3, 6],
            [7, 'كلية طب الأسنان', 'fa-tooth', 'تعليم متطور في علوم الفم والأسنان والتقويم', 4, 7],
            [8, 'كلية التربية', 'fa-chalkboard-user', 'إعداد معلمين متخصصين في مختلف المراحل التعليمية', 6, 14],
            [9, 'كلية الحقوق', 'fa-scale-balanced', 'دراسات قانونية متعمقة في الأنظمة المحلية والدولية', 3, 8],
            [10, 'كلية العمارة', 'fa-building', 'تصميم معماري مبتكر وتخطيط حضري مستدام', 3, 6],
            [11, 'كلية اللغات', 'fa-language', 'اللغة الإنجليزية والترجمة واللغات التطبيقية', 4, 9],
            [12, 'كلية التصاميم', 'fa-palette', 'التصميم الجرافيكي والأزياء والديكور الداخلي', 3, 7],
        ];

        $extras = [
            1 => ['vision' => 'ريادة في التعليم الهندسي والبحث التطبيقي المستدام.', 'mission' => 'إعداد مهندسين مبتكرين يخدمون التنمية الوطنية بمعايير عالمية.', 'established' => '1998', 'students' => '3,500+', 'building' => 'مبنى الهندسة', 'accreditation' => 'ABET'],
            2 => ['vision' => 'تميز في التعليم الطبي والبحث السريري.', 'mission' => 'تخريج أطباء مؤهلين يرتكزون على الرعاية الإنسانية والابتكار.', 'established' => '2001', 'students' => '2,800+', 'building' => 'مبنى كلية الطب', 'accreditation' => 'NCAA'],
            3 => ['vision' => 'إعداد قادة أعمال ورواد ينافسون عالمياً.', 'mission' => 'تقديم تعليم إداري يربط النظرية بالممارسة وسوق العمل.', 'established' => '2000', 'students' => '4,200+', 'building' => 'مبنى إدارة الأعمال', 'accreditation' => 'AACSB'],
            4 => ['vision' => 'الريادة في علوم الحاسب والذكاء الاصطناعي.', 'mission' => 'بناء كفاءات تقنية تدعم الاقتصاد الرقمي والتحول الوطني.', 'established' => '2005', 'students' => '5,100+', 'building' => 'مبنى علوم الحاسب', 'accreditation' => 'ABET'],
            5 => ['vision' => 'تطوير المعرفة العلمية الأساسية والتطبيقية.', 'mission' => 'إعداد باحثين وعلماء في العلوم الطبيعية والرياضيات.', 'established' => '1999', 'students' => '2,400+', 'building' => 'مبنى العلوم', 'accreditation' => 'NCAAA'],
            6 => ['vision' => 'التميز في الصيدلة السريرية والبحث الدوائي.', 'mission' => 'تأهيل صيادلة يساهمون في رفع جودة الرعاية الصحية.', 'established' => '2008', 'students' => '1,600+', 'building' => 'مبنى الصيدلة', 'accreditation' => 'ACPE'],
            7 => ['vision' => 'تعليم طب أسنان متقدم يواكب أحدث التقنيات.', 'mission' => 'إعداد أطباء أسنان متميزين في التشخيص والعلاج.', 'established' => '2012', 'students' => '900+', 'building' => 'عيادات طب الأسنان', 'accreditation' => 'CODA'],
            8 => ['vision' => 'إعداد معلمين ومربين وفق أفضل الممارسات العالمية.', 'mission' => 'تطوير الكفايات التربوية والتعليمية للمعلمين.', 'established' => '2003', 'students' => '3,000+', 'building' => 'مبنى التربية', 'accreditation' => 'NCAAA'],
            9 => ['vision' => 'إعداد قانونيين متميزين في القانون المحلي والدولي.', 'mission' => 'تقديم تعليم قانوني يربط النظرية بالممارسة المهنية.', 'established' => '2006', 'students' => '1,800+', 'building' => 'مبنى الحقوق', 'accreditation' => 'NCAAA'],
            10 => ['vision' => 'تصميم معماري مستدام يلبي احتياجات المجتمع.', 'mission' => 'إعداد مهندسين معماريين ومخططين حضريين مبدعين.', 'established' => '2010', 'students' => '1,200+', 'building' => 'استوديو العمارة', 'accreditation' => 'NAAB'],
            11 => ['vision' => 'تعزيز التواصل اللغوي والترجمة في العصر الرقمي.', 'mission' => 'تأهيل متخصصين في اللغات والترجمة والاتصال.', 'established' => '2011', 'students' => '1,400+', 'building' => 'مبنى اللغات', 'accreditation' => 'NCAAA'],
            12 => ['vision' => 'إبداع بصري يجمع بين الفن والتقنية.', 'mission' => 'تخريج مصممين محترفين في مختلف مجالات التصميم.', 'established' => '2014', 'students' => '1,100+', 'building' => 'مبنى التصاميم', 'accreditation' => 'NASAD'],
        ];

        foreach ($colleges as [$id, $name, $icon, $desc, $depts, $programs]) {
            $extra = $extras[$id];
            College::updateOrCreate(
                ['slug' => $this->collegeSlugs[$id]],
                [
                    'name' => $name,
                    'category' => $this->collegeCategories[$id],
                    'icon' => $icon,
                    'description' => $desc,
                    'vision' => $extra['vision'],
                    'mission' => $extra['mission'],
                    'established' => $extra['established'],
                    'students_count' => $extra['students'],
                    'building' => $extra['building'],
                    'accreditation' => $extra['accreditation'],
                    'departments_count' => $depts,
                    'programs_count' => $programs,
                    'sort_order' => $id,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedDepartments(): void
    {
        $data = [
            1 => [
                ['قسم الهندسة المدنية', 'fa-road', 'تصميم وبناء البنى التحتية والمنشآت', 3, 25],
                ['قسم الهندسة المعمارية', 'fa-building', 'التصميم المعماري والتخطيط العمراني', 3, 20],
                ['قسم الهندسة الميكانيكية', 'fa-gear', 'أنظمة الطاقة والتصنيع المتقدم', 2, 22],
                ['قسم الهندسة الكهربائية', 'fa-bolt', 'الطاقة والاتصالات والإلكترونيات', 2, 18],
                ['قسم الهندسة الكيميائية', 'fa-atom', 'عمليات التصنيع والبتروكيماويات', 2, 15],
            ],
            2 => [
                ['قسم التشريح', 'fa-heart-pulse', 'دراسة تركيب جسم الإنسان', 2, 12],
                ['قسم الباطنة', 'fa-lungs', 'أمراض الجهاز الهضمي والتنفس', 3, 30],
                ['قسم الجراحة', 'fa-scalpel-line-dashed', 'الجراحة العامة والتخصصية', 3, 28],
                ['قسم طب الأطفال', 'fa-baby', 'رعاية صحة الأطفال', 2, 18],
            ],
            3 => [
                ['قسم الإدارة', 'fa-users', 'الإدارة الاستراتيجية والموارد البشرية', 3, 20],
                ['قسم المحاسبة', 'fa-calculator', 'المحاسبة المالية والتدقيق', 2, 15],
                ['قسم التسويق', 'fa-bullhorn', 'التسويق الرقمي وإدارة العلامات التجارية', 2, 12],
                ['قسم الاقتصاد', 'fa-coins', 'الاقتصاد الكلي والجزئي والمالي', 3, 18],
            ],
            4 => [
                ['قسم علوم الحاسب', 'fa-code', 'البرمجة وهندسة البرمجيات', 3, 22],
                ['قسم الذكاء الاصطناعي', 'fa-robot', 'تعلم الآلة ومعالجة اللغات', 2, 15],
                ['قسم أمن المعلومات', 'fa-shield-halved', 'الأمن السيبراني وحماية البيانات', 2, 12],
                ['قسم نظم المعلومات', 'fa-database', 'إدارة قواعد البيانات وتحليل النظم', 2, 14],
            ],
        ];

        foreach ($data as $collegeId => $departments) {
            $college = College::where('slug', $this->collegeSlugs[$collegeId])->first();
            if (! $college) {
                continue;
            }
            foreach ($departments as $i => [$name, $icon, $desc, $programs, $faculty]) {
                Department::updateOrCreate(
                    ['college_id' => $college->id, 'slug' => Str::slug($name, '-', 'ar') ?: 'dept-' . $collegeId . '-' . ($i + 1)],
                    [
                        'name' => $name,
                        'icon' => $icon,
                        'description' => $desc,
                        'programs_count' => $programs,
                        'faculty_count' => $faculty,
                        'sort_order' => $i + 1,
                        'is_active' => true,
                    ]
                );
            }
        }
    }

    private function seedPrograms(): void
    {
        $collegeMap = [
            'كلية الهندسة' => 'engineering',
            'كلية الطب' => 'medicine',
            'كلية إدارة الأعمال' => 'business',
            'كلية علوم الحاسب' => 'computer-science',
            'كلية الصيدلة' => 'pharmacy',
            'كلية العمارة' => 'architecture',
            'كلية الحقوق' => 'law',
        ];

        $programs = [
            ['بكالوريوس الهندسة المدنية', 'bachelor', 'كلية الهندسة', '5 سنوات', 'إعداد مهندسين مدنيين مؤهلين لتصميم وبناء المشاريع الهندسية', 'ثانوية علمية - معدل 90% فأعلى'],
            ['بكالوريوس الطب والجراحة', 'bachelor', 'كلية الطب', '6 سنوات', 'برنامج طبي متكامل لإعداد أطباء متميزين', 'ثانوية علمية - معدل 95% فأعلى - اختبار القدرات'],
            ['بكالوريوس علوم الحاسب', 'bachelor', 'كلية علوم الحاسب', '4 سنوات', 'دراسة شاملة في البرمجة وهندسة البرمجيات', 'ثانوية علمية - معدل 85% فأعلى'],
            ['بكالوريوس إدارة الأعمال', 'bachelor', 'كلية إدارة الأعمال', '4 سنوات', 'تأهيل كوادر إدارية مؤهلة لسوق العمل', 'ثانوية - معدل 80% فأعلى'],
            ['بكالوريوس الصيدلة', 'bachelor', 'كلية الصيدلة', '5 سنوات', 'إعداد صيادلة متخصصين في الصناعة والبحث', 'ثانوية علمية - معدل 92% فأعلى'],
            ['بكالوريوس العمارة', 'bachelor', 'كلية العمارة', '5 سنوات', 'تصميم معماري مبتكر ومستدام', 'ثانوية - معدل 85% فأعلى - اختبار قدرات'],
            ['ماجستير إدارة الأعمال MBA', 'master', 'كلية إدارة الأعمال', 'سنتين', 'برنامج متقدم في الإدارة التنفيذية والقيادة', 'بكالوريوس - خبرة 3 سنوات - اختبار GMAT'],
            ['ماجستير الذكاء الاصطناعي', 'master', 'كلية علوم الحاسب', 'سنتين', 'دراسة متعمقة في تعلم الآلة والشبكات العصبية', 'بكالوريوس حاسب - معدل 3.5 فأعلى'],
            ['ماجستير الهندسة الإنشائية', 'master', 'كلية الهندسة', 'سنتين', 'تخصص في تصميم وتحليل المنشآت المتقدمة', 'بكالوريوس هندسة مدنية - معدل 3.0 فأعلى'],
            ['ماجستير المحاسبة المالية', 'master', 'كلية إدارة الأعمال', 'سنتين', 'تخصص في المحاسبة والتدقيق المالي المتقدم', 'بكالوريوس محاسبة - معدل 3.0 فأعلى'],
            ['دكتوراه في علوم الحاسب', 'phd', 'كلية علوم الحاسب', '4 سنوات', 'بحث متخصص في مجالات الحوسبة المتقدمة', 'ماجستير - معدل 3.75 فأعلى - مقترح بحثي'],
            ['دكتوراه في الإدارة', 'phd', 'كلية إدارة الأعمال', '4 سنوات', 'بحث أكاديمي في الإدارة والقيادة التنظيمية', 'ماجستير إدارة - معدل 3.75 فأعلى'],
            ['دكتوراه في الهندسة الطبية', 'phd', 'كلية الهندسة', '4 سنوات', 'بحث في التقنيات الطبية الحيوية المتقدمة', 'ماجستير هندسة - معدل 3.75 فأعلى'],
            ['دكتوراه في القانون الدولي', 'phd', 'كلية الحقوق', '4 سنوات', 'بحث في القانون الدولي والعلاقات الدولية', 'ماجستير قانون - معدل 3.75 فأعلى'],
        ];

        foreach ($programs as $i => [$name, $level, $collegeName, $duration, $desc, $requirements]) {
            $slug = $collegeMap[$collegeName] ?? 'general';
            $college = College::where('slug', $slug)->first();
            if (! $college) {
                continue;
            }
            Program::updateOrCreate(
                ['slug' => Str::slug($name, '-', 'ar') ?: 'program-' . ($i + 1)],
                [
                    'college_id' => $college->id,
                    'name' => $name,
                    'level' => ProgramLevel::from($level),
                    'duration' => $duration,
                    'description' => $desc,
                    'requirements' => $requirements,
                    'sort_order' => $i + 1,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedStaff(): void
    {
        $staff = [
            ['leadership', 'أ.د. عبدالله الراشد', 'رئيس الجامعة', 'خبير في الإدارة الأكاديمية والت planning الاستراتيجي بخبرة تتجاوز 30 عاماً في التعليم العالي.', null, 1, true],
            ['leadership', 'أ.د. فاطمة الزهراني', 'نائب الرئيس للشؤون الأكاديمية', 'متخصصة في تطوير المناهج والبرامج الأكاديمية المعتمدة دولياً.', null, 2, true],
            ['leadership', 'أ.د. محمد العتيبي', 'نائب الرئيس للبحث العلمي', 'باحث متميز في مجال الذكاء الاصطناعي وتطبيقاته في التعليم.', null, 3, true],
            ['dean', 'د. نورة القحطاني', 'عميدة كلية الهندسة', 'خبيرة في الهندسة المدنية والتصميم المستدام', 'engineering', 4, true],
            ['dean', 'أ.د. خالد الدوسري', 'عميد كلية الطب', 'استشاري في الجراحة العامة وزراعة الأعضاء', 'medicine', 5, true],
            ['dean', 'د. سارة الشمري', 'عميدة كلية علوم الحاسب', 'متخصصة في أمن المعلومات والحوسبة السحابية', 'computer-science', 6, true],
            ['dean', 'أ.د. أحمد الحربي', 'عميد كلية إدارة الأعمال', 'خبير في الإدارة الاستراتيجية والتطوير المؤسسي', 'business', 7, true],
            ['dean', 'د. منال العنزي', 'عميدة كلية الصيدلة', 'باحثة في مجال تطوير الأدوية والعلاج الجيني', 'pharmacy', 8, false],
            ['dean', 'أ.د. فهد المطيري', 'عميد كلية العلوم', 'متخصص في الفيزياء التطبيقية والطاقة المتجددة', 'science', 9, false],
            ['dean', 'د. هند السبيعي', 'عميدة كلية التربية', 'خبيرة في المناهج التعليمية والتربية الخاصة', 'education', 10, false],
            ['dean', 'أ.د. سلطان الرشيدي', 'عميد كلية الحقوق', 'متخصص في القانون الدولي والتحكيم التجاري', 'law', 11, false],
            ['dean', 'د. ريم البلوي', 'عميدة كلية التصاميم', 'مصممة محترفة في التصميم الجرافيكي والهوية البصرية', 'design', 12, false],
        ];

        foreach ($staff as [$type, $name, $position, $bio, $collegeSlug, $order, $featured]) {
            $collegeId = $collegeSlug ? College::where('slug', $collegeSlug)->value('id') : null;
            StaffMember::updateOrCreate(
                ['slug' => Str::slug($name, '-', 'ar') ?: 'staff-' . $order],
                [
                    'type' => StaffType::from($type),
                    'name' => $name,
                    'position' => $position,
                    'bio' => $bio,
                    'college_id' => $collegeId,
                    'icon' => 'fa-user-tie',
                    'sort_order' => $order,
                    'is_featured' => $featured,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedFaculty(): void
    {
        $faculty = [
            ['أ.د. يوسف الغامدي', 'أستاذ', 'engineering', 'الهندسة المدنية', 'هندسة الزلازل والإنشاءات'],
            ['د. مريم العتيبي', 'أستاذ مساعد', 'engineering', 'الهندسة الكهربائية', 'أنظمة الطاقة المتجددة'],
            ['أ.د. سعد المطيري', 'أستاذ', 'medicine', 'قسم الجراحة', 'الجراحة العامة'],
            ['د. ليلى الحربي', 'أستاذ مشارك', 'medicine', 'قسم الباطنة', 'أمراض القلب'],
            ['د. فيصل القحطاني', 'أستاذ مساعد', 'business', 'قسم الإدارة', 'الإدارة الاستراتيجية'],
            ['أ.د. رنا الشمري', 'أستاذ', 'computer-science', 'الذكاء الاصطناعي', 'تعلم الآلة العميق'],
            ['د. عمر الزهراني', 'أستاذ مساعد', 'computer-science', 'أمن المعلومات', 'الأمن السيبراني'],
            ['أ.د. نادية الدوسري', 'أستاذ', 'science', 'الفيزياء', 'الفيزياء التطبيقية'],
        ];

        foreach ($faculty as $i => [$name, $title, $collegeSlug, $deptName, $specialty]) {
            $college = College::where('slug', $collegeSlug)->first();
            $department = $college
                ? Department::where('college_id', $college->id)->where('name', 'like', '%' . mb_substr($deptName, 0, 8) . '%')->first()
                : null;

            StaffMember::updateOrCreate(
                ['slug' => 'faculty-' . ($i + 1)],
                [
                    'type' => StaffType::Faculty,
                    'name' => $name,
                    'academic_title' => $title,
                    'specialty' => $specialty,
                    'college_id' => $college?->id,
                    'department_id' => $department?->id,
                    'icon' => 'fa-user-tie',
                    'sort_order' => 100 + $i,
                    'is_featured' => false,
                    'is_active' => true,
                ]
            );
        }
    }

    private function seedHomepage(): void
    {
        if (HomepageHeroSlide::count() === 0) {
            $slides = [
                ['جامعة معتمدة عالمياً', 'نحو مستقبل أكاديمي', 'متميز ومبتكر', 'نقدم برامج أكاديمية رائدة وبيئة بحثية متطورة لإعداد كوادر مؤهلة تقود مسيرة التنمية والتطوير في المملكة.', 'استكشف الكليات', '/colleges', 'عن الجامعة', '/about'],
                ['التسجيل مفتوح 2026', 'بوابة القبول', 'مفتوحة الآن', 'انضم إلى أكثر من 25,000 طالب وطالبة في رحلة أكاديمية استثنائية. قدّم طلبك اليوم وابدأ مستقبلك مع جامعة المستقبل.', 'قدم الآن', '/admission', 'البرامج الأكاديمية', '/programs'],
                ['35 مركزاً بحثياً', 'ابتكار يصنع', 'المستقبل', 'مراكز بحثية متطورة وشراكات عالمية في الذكاء الاصطناعي والعلوم الطبية والهندسة المستدامة.', 'البحث العلمي', '/research', 'المكتبة', '/library'],
                ['حياة جامعية نابضة', 'بيئة تعليمية', 'حيوية ومتنوعة', 'أنشطة طلابية وفعاليات علمية ورياضية وثقافية تُثري تجربتك الجامعية وتبني شخصيتك القيادية.', 'الأخبار والفعاليات', '/news', 'تواصل معنا', '/contact'],
            ];
            foreach ($slides as $i => $s) {
                HomepageHeroSlide::create([
                    'badge' => $s[0], 'title' => $s[1], 'title_accent' => $s[2], 'description' => $s[3],
                    'primary_btn_label' => $s[4], 'primary_btn_url' => $s[5],
                    'secondary_btn_label' => $s[6], 'secondary_btn_url' => $s[7],
                    'sort_order' => $i + 1, 'is_active' => true,
                ]);
            }
        }

        if (HomepageStat::count() === 0) {
            $stats = [
                ['fa-building-columns', '12', 'كلية أكاديمية'],
                ['fa-book-open', '85', 'برنامج أكاديمي'],
                ['fa-chalkboard-user', '800', 'عضو هيئة تدريس'],
                ['fa-flask', '35', 'مركز بحثي'],
            ];
            foreach ($stats as $i => [$icon, $value, $label]) {
                HomepageStat::create(['icon' => $icon, 'value' => $value, 'label' => $label, 'sort_order' => $i + 1, 'is_active' => true]);
            }
        }

        if (Accreditation::count() === 0) {
            $items = [
                ['ABET', 'fa-certificate', 'اعتماد برامج الهندسة'],
                ['AACSB', 'fa-award', 'اعتماد إدارة الأعمال'],
                ['NCAAA', 'fa-star', 'اعتماد أكاديمي وطني'],
                ['ACPE', 'fa-pills', 'اعتماد الصيدلة'],
            ];
            foreach ($items as $i => [$name, $icon, $desc]) {
                Accreditation::create(['name' => $name, 'icon' => $icon, 'description' => $desc, 'sort_order' => $i + 1, 'is_active' => true]);
            }
        }
    }

    private function seedAdmissionCycle(): void
    {
        AdmissionCycle::updateOrCreate(
            ['academic_year' => '2026-2027'],
            [
                'name' => 'القبول للفصل الأول 2026',
                'start_date' => '2026-06-01',
                'end_date' => '2026-07-15',
                'is_open' => true,
                'description' => 'بوابة القبول للفصل الدراسي الأول للعام الأكاديمي 2026-2027',
            ]
        );
    }

    private function linkDeans(): void
    {
        $map = [
            'engineering' => 'د. نورة القحطاني',
            'medicine' => 'أ.د. خالد الدوسري',
            'computer-science' => 'د. سارة الشمري',
            'business' => 'أ.د. أحمد الحربي',
            'pharmacy' => 'د. منال العنزي',
            'science' => 'أ.د. فهد المطيري',
            'education' => 'د. هند السبيعي',
            'law' => 'أ.د. سلطان الرشيدي',
            'design' => 'د. ريم البلوي',
        ];

        foreach ($map as $slug => $deanName) {
            $college = College::where('slug', $slug)->first();
            $dean = StaffMember::where('name', $deanName)->first();
            if ($college && $dean) {
                $college->update(['dean_id' => $dean->id]);
            }
        }
    }
}
