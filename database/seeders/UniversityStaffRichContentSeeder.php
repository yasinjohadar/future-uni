<?php

namespace Database\Seeders;

use App\Models\StaffMember;
use Illuminate\Database\Seeder;

class UniversityStaffRichContentSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->profiles() as $name => $profile) {
            $member = StaffMember::where('name', $name)->first();
            if (! $member) {
                continue;
            }

            $member->update([
                'bio' => $this->bioHtml($profile),
                'email' => $profile['email'] ?? null,
                'phone' => $profile['phone'] ?? null,
                'office' => $profile['office'] ?? null,
                'stats' => $profile['stats'] ?? null,
                'education' => $profile['education'] ?? null,
                'experience_history' => $profile['experience'] ?? null,
                'publications' => $profile['publications'] ?? null,
                'awards' => $profile['awards'] ?? null,
                'skills' => $profile['skills'] ?? null,
            ]);
        }
    }

    private function bioHtml(array $profile): string
    {
        $intro = $profile['bio'] ?? '';
        $html = '<p>' . e($intro) . '</p>';

        foreach ($profile['bio_extra'] ?? [] as $paragraph) {
            $html .= '<p>' . e($paragraph) . '</p>';
        }

        if (! empty($profile['bio_highlights'])) {
            $html .= '<ul>';
            foreach ($profile['bio_highlights'] as $item) {
                $html .= '<li>' . e($item) . '</li>';
            }
            $html .= '</ul>';
        }

        if (! empty($profile['bio_quote'])) {
            $html .= '<blockquote><p><em>' . e($profile['bio_quote']) . '</em></p></blockquote>';
        }

        return $html;
    }

    private function profiles(): array
    {
        return [
            'أ.د. عبدالله الراشد' => [
                'bio' => 'خبير في الإدارة الأكاديمية والتخطيط الاستراتيجي بخبرة تتجاوز 30 عاماً في التعليم العالي.',
                'bio_extra' => [
                    'قاد العديد من مبادرات التطوير الجامعي وحصل على جوائز دولية في التميز الأكاديمي.',
                    'يركز على بناء شراكات أكاديمية دولية ورفع تصنيفات الجامعة في التصنيفات العالمية.',
                ],
                'bio_highlights' => ['قيادة استراتيجية للجامعة', 'تطوير الحوكمة الأكاديمية', 'اعتمادات دولية للبرامج'],
                'bio_quote' => 'الجامعة المتميزة تُبنى على رؤية واضحة وقيادة ملتزمة بالجودة.',
                'email' => 'a.alrashed@futureuniversity.edu',
                'phone' => '+966 11 234 5601',
                'office' => 'المبنى الإداري - الطابق 5 - مكتب 501',
                'education' => [
                    ['year' => '1990', 'degree' => 'بكالوريوس إدارة تعليم', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '1995', 'degree' => 'ماجستير إدارة تعليم عالي', 'institution' => 'جامعة ولاية بنسلفانيا، USA'],
                    ['year' => '2000', 'degree' => 'دكتوراه في التخطيط الاستراتيجي', 'institution' => 'جامعة هارفارد، USA'],
                ],
                'experience' => [
                    ['year' => '2018 - الآن', 'role' => 'رئيس جامعة المستقبل', 'desc' => 'قيادة الجامعة وتحقيق تصنيفات عالمية متقدمة'],
                    ['year' => '2010 - 2018', 'role' => 'نائب الرئيس للشؤون الأكاديمية', 'desc' => 'تطوير البرامج الأكاديمية والحصول على الاعتمادات الدولية'],
                    ['year' => '2002 - 2010', 'role' => 'عميد كلية التربية', 'desc' => 'إدارة الكلية وتطوير المناهج الدراسية'],
                ],
                'publications' => [
                    ['title' => 'التخطيط الاستراتيجي في الجامعات العربية', 'journal' => 'مجلة التعليم العالي', 'year' => '2024'],
                    ['title' => 'نماذج القيادة الأكاديمية في القرن الحادي والعشرين', 'journal' => 'Journal of Higher Education', 'year' => '2023'],
                    ['title' => 'تأثير الاعتماد الدولي على جودة التعليم', 'journal' => 'Arab Journal of Education', 'year' => '2022'],
                ],
                'skills' => [
                    ['name' => 'الإدارة الاستراتيجية', 'level' => 95],
                    ['name' => 'التخطيط الأكاديمي', 'level' => 90],
                    ['name' => 'القيادة التنظيمية', 'level' => 92],
                    ['name' => 'إدارة الجودة الشاملة', 'level' => 88],
                ],
                'stats' => ['publications' => 45, 'citations' => 1200, 'hIndex' => 18, 'experience' => 30],
                'awards' => ['جائزة التميز في الإدارة الأكاديمية 2023', 'وسام الملك عبدالعزيز من الدرجة الأولى 2020'],
            ],
            'أ.د. فاطمة الزهراني' => [
                'bio' => 'متخصصة في تطوير المناهج والبرامج الأكاديمية المعتمدة دولياً.',
                'bio_extra' => ['قادت عملية اعتماد أكثر من 20 برنامجاً أكاديمياً من هيئات اعتماد عالمية.'],
                'email' => 'f.alzahrani@futureuniversity.edu',
                'phone' => '+966 11 234 5602',
                'office' => 'المبنى الإداري - الطابق 4 - مكتب 401',
                'education' => [
                    ['year' => '1992', 'degree' => 'بكالوريوس تربية', 'institution' => 'جامعة الملك عبدالعزيز'],
                    ['year' => '1998', 'degree' => 'ماجستير تطوير مناهج', 'institution' => 'جامعة لندن، UK'],
                    ['year' => '2003', 'degree' => 'دكتوراه في تطوير المناهج', 'institution' => 'جامعة كولومبيا، USA'],
                ],
                'experience' => [
                    ['year' => '2019 - الآن', 'role' => 'نائب الرئيس للشؤون الأكاديمية', 'desc' => 'الإشراف على جميع البرامج الأكاديمية والاعتمادات'],
                    ['year' => '2012 - 2019', 'role' => 'وكيلة الجامعة للتطوير', 'desc' => 'قيادة مبادرات التطوير الأكاديمي والجودة'],
                ],
                'publications' => [
                    ['title' => 'معايير الاعتماد الأكاديمي الدولية', 'journal' => 'مجلة الجودة في التعليم', 'year' => '2024'],
                    ['title' => 'تطوير المناهج القائمة على الكفايات', 'journal' => 'Curriculum Studies Journal', 'year' => '2023'],
                ],
                'skills' => [
                    ['name' => 'تطوير المناهج', 'level' => 96],
                    ['name' => 'الاعتماد الأكاديمي', 'level' => 94],
                    ['name' => 'ضمان الجودة', 'level' => 90],
                ],
                'stats' => ['publications' => 38, 'citations' => 850, 'hIndex' => 14, 'experience' => 26],
                'awards' => ['جائزة التميز في تطوير المناهج 2023', 'جائزة أفضل بحث تربوي 2021'],
            ],
            'أ.د. محمد العتيبي' => [
                'bio' => 'باحث متميز في مجال الذكاء الاصطناعي وتطبيقاته في التعليم.',
                'bio_extra' => ['نشر أكثر من 60 بحثاً في مجلات عالمية مصنفة وقاد مشاريع بحثية ممولة من مدينة الملك عبدالعزيز للعلوم والتقنية.'],
                'email' => 'm.alotaibi@futureuniversity.edu',
                'phone' => '+966 11 234 5603',
                'office' => 'المبنى الإداري - الطابق 4 - مكتب 402',
                'education' => [
                    ['year' => '1994', 'degree' => 'بكالوريوس علوم حاسب', 'institution' => 'جامعة الملك فهد للبترول والمعادن'],
                    ['year' => '1999', 'degree' => 'ماجستير ذكاء اصطناعي', 'institution' => 'MIT، USA'],
                    ['year' => '2004', 'degree' => 'دكتوراه في تعلم الآلة', 'institution' => 'جامعة Stanford، USA'],
                ],
                'experience' => [
                    ['year' => '2020 - الآن', 'role' => 'نائب الرئيس للبحث العلمي', 'desc' => 'إدارة البحث العلمي ومراكز الأبحاث في الجامعة'],
                    ['year' => '2012 - 2020', 'role' => 'مدير مركز أبحاث الذكاء الاصطناعي', 'desc' => 'تأسيس وإدارة المركز وتمويل المشاريع البحثية'],
                ],
                'publications' => [
                    ['title' => 'Deep Learning Approaches for Arabic NLP', 'journal' => 'IEEE Transactions on AI', 'year' => '2024'],
                    ['title' => 'AI in Higher Education: A Systematic Review', 'journal' => 'Computers & Education', 'year' => '2023'],
                ],
                'skills' => [
                    ['name' => 'الذكاء الاصطناعي', 'level' => 97],
                    ['name' => 'تعلم الآلة', 'level' => 95],
                    ['name' => 'إدارة البحث العلمي', 'level' => 90],
                ],
                'stats' => ['publications' => 62, 'citations' => 2400, 'hIndex' => 22, 'experience' => 22],
                'awards' => ['جائزة الملك فيصل للعلوم 2023', 'جائزة أفضل بحث في AI 2022'],
            ],
            'د. نورة القحطاني' => [
                'bio' => 'خبيرة في الهندسة المدنية والتصميم المستدام.',
                'bio_extra' => ['حصلت على اعتماد ABET لبرامج الكلية وقادت مشاريع بحثية في مجال البناء الأخضر.'],
                'email' => 'n.alqahtani@futureuniversity.edu',
                'phone' => '+966 11 234 5604',
                'office' => 'مبنى كلية الهندسة - الطابق 3 - مكتب 301',
                'education' => [
                    ['year' => '1996', 'degree' => 'بكالوريوس هندسة مدنية', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '2001', 'degree' => 'ماجستير هندسة إنشائية', 'institution' => 'جامعة كاليفورنيا، Berkeley'],
                    ['year' => '2006', 'degree' => 'دكتوراه في الهندسة المستدامة', 'institution' => 'جامعة كامبريدج، UK'],
                ],
                'experience' => [
                    ['year' => '2018 - الآن', 'role' => 'عميدة كلية الهندسة', 'desc' => 'إدارة الكلية والحصول على اعتماد ABET'],
                    ['year' => '2012 - 2018', 'role' => 'رئيسة قسم الهندسة المدنية', 'desc' => 'تطوير البرامج الدراسية والمختبرات'],
                ],
                'publications' => [
                    ['title' => 'Sustainable Building Materials in Hot Climates', 'journal' => 'Construction and Building Materials', 'year' => '2024'],
                    ['title' => 'Green Concrete: A Comprehensive Review', 'journal' => 'Journal of Cleaner Production', 'year' => '2023'],
                ],
                'skills' => [
                    ['name' => 'الهندسة المدنية', 'level' => 95],
                    ['name' => 'التصميم المستدام', 'level' => 92],
                    ['name' => 'هندسة الزلازل', 'level' => 85],
                ],
                'stats' => ['publications' => 35, 'citations' => 780, 'hIndex' => 13, 'experience' => 20],
                'awards' => ['جائزة التميز في الهندسة المستدامة 2023', 'جائزة أفضل عميدة 2021'],
            ],
            'أ.د. خالد الدوسري' => [
                'bio' => 'استشاري في الجراحة العامة وزراعة الأعضاء.',
                'bio_extra' => ['أجرى أكثر من 3000 عملية جراحية وشارك في برامج تدريبية دولية.'],
                'email' => 'k.aldosari@futureuniversity.edu',
                'phone' => '+966 11 234 5605',
                'office' => 'مبنى كلية الطب - الطابق 2 - مكتب 201',
                'education' => [
                    ['year' => '1990', 'degree' => 'بكالوريوس طب وجراحة', 'institution' => 'جامعة الملك عبدالعزيز'],
                    ['year' => '1996', 'degree' => 'زمالة جراحة عامة', 'institution' => 'الكلية الملكية للجراحين، UK'],
                    ['year' => '2000', 'degree' => 'زمالة زراعة أعضاء', 'institution' => 'جامعة جونز هوبكنز، USA'],
                ],
                'experience' => [
                    ['year' => '2017 - الآن', 'role' => 'عميد كلية الطب', 'desc' => 'إدارة الكلية وتطوير البرامج الطبية'],
                    ['year' => '2010 - 2017', 'role' => 'رئيس قسم الجراحة', 'desc' => 'إدارة القسم والإشراف على العمليات الجراحية'],
                ],
                'publications' => [
                    ['title' => 'Advances in Liver Transplantation', 'journal' => 'The Lancet', 'year' => '2024'],
                    ['title' => 'Minimally Invasive Surgery Techniques', 'journal' => 'Annals of Surgery', 'year' => '2023'],
                ],
                'skills' => [
                    ['name' => 'الجراحة العامة', 'level' => 98],
                    ['name' => 'زراعة الأعضاء', 'level' => 95],
                    ['name' => 'التدريب الجراحي', 'level' => 92],
                ],
                'stats' => ['publications' => 40, 'citations' => 950, 'hIndex' => 16, 'experience' => 26],
                'awards' => ['جائزة التميز في الجراحة 2023', 'وسام الصحة العالمي 2021'],
            ],
            'د. سارة الشمري' => [
                'bio' => 'متخصصة في أمن المعلومات والحوسبة السحابية.',
                'bio_extra' => [
                    'قادت مشاريع بحثية ممولة من أرامكو السعودية وشركة STC في مجال الأمن السيبراني.',
                    'تشرف على تطوير برامج الأمن السيبراني ومراكز الابتكار في الكلية.',
                ],
                'bio_highlights' => ['أمن المعلومات', 'الحوسبة السحابية', 'Zero Trust Architecture'],
                'email' => 's.alshamari@futureuniversity.edu',
                'phone' => '+966 11 234 5606',
                'office' => 'مبنى كلية علوم الحاسب - الطابق 2 - مكتب 201',
                'education' => [
                    ['year' => '1998', 'degree' => 'بكالوريوس علوم حاسب', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '2003', 'degree' => 'ماجستير أمن معلومات', 'institution' => 'جامعة Carnegie Mellon، USA'],
                    ['year' => '2008', 'degree' => 'دكتوراه في الحوسبة السحابية', 'institution' => 'جامعة MIT، USA'],
                ],
                'experience' => [
                    ['year' => '2019 - الآن', 'role' => 'عميدة كلية علوم الحاسب', 'desc' => 'إدارة الكلية وتطوير برامج الحوسبة'],
                    ['year' => '2012 - 2019', 'role' => 'رئيسة قسم أمن المعلومات', 'desc' => 'تطوير برامج الأمن السيبراني'],
                ],
                'publications' => [
                    ['title' => 'Cloud Security in Enterprise Environments', 'journal' => 'IEEE Transactions on Cloud Computing', 'year' => '2024'],
                    ['title' => 'Zero Trust Architecture for Universities', 'journal' => 'Computers & Security', 'year' => '2023'],
                    ['title' => 'AI-Powered Threat Detection Systems', 'journal' => 'ACM Computing Surveys', 'year' => '2022'],
                ],
                'skills' => [
                    ['name' => 'أمن المعلومات', 'level' => 96],
                    ['name' => 'الحوسبة السحابية', 'level' => 93],
                    ['name' => 'الأمن السيبراني', 'level' => 94],
                ],
                'stats' => ['publications' => 32, 'citations' => 680, 'hIndex' => 12, 'experience' => 18],
                'awards' => ['جائزة التميز في الأمن السيبراني 2023', 'جائزة أفضل باحثة 2021'],
            ],
            'أ.د. أحمد الحربي' => [
                'bio' => 'خبير في الإدارة الاستراتيجية والتطوير المؤسسي.',
                'bio_extra' => ['حاصل على اعتماد AACSB للكلية وقاد شراكات مع جامعات عالمية.'],
                'email' => 'a.alharbi@futureuniversity.edu',
                'phone' => '+966 11 234 5607',
                'office' => 'مبنى كلية إدارة الأعمال - الطابق 3 - مكتب 301',
                'education' => [
                    ['year' => '1993', 'degree' => 'بكالوريوس إدارة أعمال', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '1998', 'degree' => 'ماجستير إدارة', 'institution' => 'جامعة Harvard، USA'],
                    ['year' => '2003', 'degree' => 'دكتوراه في الإدارة الاستراتيجية', 'institution' => 'جامعة Oxford، UK'],
                ],
                'experience' => [
                    ['year' => '2017 - الآن', 'role' => 'عميد كلية إدارة الأعمال', 'desc' => 'إدارة الكلية والحصول على اعتماد AACSB'],
                ],
                'publications' => [
                    ['title' => 'Strategic Leadership in Arab Universities', 'journal' => 'Journal of Management Studies', 'year' => '2024'],
                ],
                'skills' => [
                    ['name' => 'الإدارة الاستراتيجية', 'level' => 95],
                    ['name' => 'التطوير المؤسسي', 'level' => 92],
                ],
                'stats' => ['publications' => 42, 'citations' => 1100, 'hIndex' => 17, 'experience' => 23],
                'awards' => ['جائزة التميز في إدارة الأعمال 2023'],
            ],
            'د. منال العنزي' => [
                'bio' => 'باحثة في مجال تطوير الأدوية والعلاج الجيني.',
                'bio_extra' => ['نشرت أبحاثها في مجلات Nature و Science.'],
                'email' => 'm.alenezi@futureuniversity.edu',
                'phone' => '+966 11 234 5608',
                'office' => 'مبنى كلية الصيدلة - الطابق 2 - مكتب 201',
                'education' => [
                    ['year' => '1995', 'degree' => 'بكالوريوس صيدلة', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '2000', 'degree' => 'ماجستير كيمياء صيدلية', 'institution' => 'جامعة لندن، UK'],
                    ['year' => '2005', 'degree' => 'دكتوراه في تطوير الأدوية', 'institution' => 'جامعة جونز هوبكنز، USA'],
                ],
                'experience' => [
                    ['year' => '2018 - الآن', 'role' => 'عميدة كلية الصيدلة', 'desc' => 'إدارة الكلية وتطوير برامج الصيدلة السريرية'],
                ],
                'publications' => [
                    ['title' => 'Gene Therapy for Genetic Disorders', 'journal' => 'Nature Medicine', 'year' => '2024'],
                ],
                'skills' => [
                    ['name' => 'تطوير الأدوية', 'level' => 97],
                    ['name' => 'العلاج الجيني', 'level' => 94],
                ],
                'stats' => ['publications' => 48, 'citations' => 1800, 'hIndex' => 20, 'experience' => 21],
                'awards' => ['جائزة الملك فيصل للعلوم الطبية 2024'],
            ],
            'أ.د. فهد المطيري' => [
                'bio' => 'متخصص في الفيزياء التطبيقية والطاقة المتجددة.',
                'bio_extra' => ['قاد مشاريع بحثية في الطاقة الشمسية بالتعاون مع مدينة الملك عبدالعزيز للعلوم والتقنية.'],
                'email' => 'f.almutairi@futureuniversity.edu',
                'phone' => '+966 11 234 5609',
                'office' => 'مبنى كلية العلوم - الطابق 3 - مكتب 301',
                'education' => [
                    ['year' => '1992', 'degree' => 'بكالوريوس فيزياء', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '1997', 'degree' => 'ماجستير فيزياء تطبيقية', 'institution' => 'جامعة Cambridge، UK'],
                    ['year' => '2002', 'degree' => 'دكتوراه في الطاقة المتجددة', 'institution' => 'جامعة Stanford، USA'],
                ],
                'experience' => [
                    ['year' => '2016 - الآن', 'role' => 'عميد كلية العلوم', 'desc' => 'إدارة الكلية وتطوير برامج العلوم الأساسية'],
                ],
                'publications' => [
                    ['title' => 'Perovskite Solar Cells: Next Generation', 'journal' => 'Nature Energy', 'year' => '2024'],
                ],
                'skills' => [
                    ['name' => 'الفيزياء التطبيقية', 'level' => 95],
                    ['name' => 'الطاقة المتجددة', 'level' => 93],
                ],
                'stats' => ['publications' => 50, 'citations' => 1500, 'hIndex' => 19, 'experience' => 24],
                'awards' => ['جائزة التميز في الطاقة المتجددة 2023'],
            ],
            'د. هند السبيعي' => [
                'bio' => 'خبيرة في المناهج التعليمية والتربية الخاصة.',
                'bio_extra' => ['طورت برامج دمج ذوي الاحتياجات الخاصة في التعليم العام.'],
                'email' => 'h.alsubaie@futureuniversity.edu',
                'phone' => '+966 11 234 5610',
                'office' => 'مبنى كلية التربية - الطابق 2 - مكتب 201',
                'education' => [
                    ['year' => '1994', 'degree' => 'بكالوريوس تربية خاصة', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '1999', 'degree' => 'ماجستير مناهج وطرق تدريس', 'institution' => 'جامعة لندن، UK'],
                    ['year' => '2004', 'degree' => 'دكتوراه في التربية الخاصة', 'institution' => 'جامعة Columbia، USA'],
                ],
                'experience' => [
                    ['year' => '2017 - الآن', 'role' => 'عميدة كلية التربية', 'desc' => 'إدارة الكلية وتطوير برامج إعداد المعلمين'],
                ],
                'publications' => [
                    ['title' => 'Inclusive Education in Arab Countries', 'journal' => 'International Journal of Inclusive Education', 'year' => '2024'],
                ],
                'skills' => [
                    ['name' => 'التربية الخاصة', 'level' => 96],
                    ['name' => 'دمج التعليم', 'level' => 94],
                ],
                'stats' => ['publications' => 30, 'citations' => 520, 'hIndex' => 11, 'experience' => 22],
                'awards' => ['جائزة التميز في التربية الخاصة 2023'],
            ],
            'أ.د. سلطان الرشيدي' => [
                'bio' => 'متخصص في القانون الدولي والتحكيم التجاري.',
                'bio_extra' => ['عمل مستشاراً قانونياً في عدة منظمات دولية.'],
                'email' => 's.alrashidi@futureuniversity.edu',
                'phone' => '+966 11 234 5611',
                'office' => 'مبنى كلية الحقوق - الطابق 2 - مكتب 201',
                'education' => [
                    ['year' => '1991', 'degree' => 'بكالوريوس قانون', 'institution' => 'جامعة الملك سعود'],
                    ['year' => '1996', 'degree' => 'ماجستير قانون دولي', 'institution' => 'جامعة Oxford، UK'],
                    ['year' => '2001', 'degree' => 'دكتوراه في القانون التجاري الدولي', 'institution' => 'جامعة Harvard، USA'],
                ],
                'experience' => [
                    ['year' => '2016 - الآن', 'role' => 'عميد كلية الحقوق', 'desc' => 'إدارة الكلية وتطوير برامج القانون'],
                ],
                'publications' => [
                    ['title' => 'International Commercial Arbitration in the GCC', 'journal' => 'Journal of International Arbitration', 'year' => '2024'],
                ],
                'skills' => [
                    ['name' => 'القانون الدولي', 'level' => 96],
                    ['name' => 'التحكيم التجاري', 'level' => 94],
                ],
                'stats' => ['publications' => 36, 'citations' => 720, 'hIndex' => 14, 'experience' => 25],
                'awards' => ['جائزة التميز في القانون الدولي 2023'],
            ],
            'د. ريم البلوي' => [
                'bio' => 'مصممة محترفة في التصميم الجرافيكي والهوية البصرية.',
                'bio_extra' => ['فازت بجوائز دولية في التصميم وأقامت معارض فنية متعددة.'],
                'email' => 'r.albalawi@futureuniversity.edu',
                'phone' => '+966 11 234 5612',
                'office' => 'مبنى كلية التصاميم - الطابق 2 - مكتب 201',
                'education' => [
                    ['year' => '1997', 'degree' => 'بكالوريوس تصميم جرافيكي', 'institution' => 'جامعة الملك عبدالعزيز'],
                    ['year' => '2002', 'degree' => 'ماجستير تصميم بصري', 'institution' => 'جامعة Parsons، USA'],
                    ['year' => '2007', 'degree' => 'دكتوراه في التصميم الإبداعي', 'institution' => 'جامعة RCA لندن، UK'],
                ],
                'experience' => [
                    ['year' => '2018 - الآن', 'role' => 'عميدة كلية التصاميم', 'desc' => 'إدارة الكلية وتطوير برامج التصميم'],
                ],
                'publications' => [
                    ['title' => 'Arabic Typography in Digital Age', 'journal' => 'Design Issues', 'year' => '2024'],
                ],
                'skills' => [
                    ['name' => 'التصميم الجرافيكي', 'level' => 97],
                    ['name' => 'الهوية البصرية', 'level' => 95],
                ],
                'stats' => ['publications' => 22, 'citations' => 350, 'hIndex' => 9, 'experience' => 19],
                'awards' => ['جائزة التميز في التصميم العربي 2023', 'جائزة أفضل معرض فني 2022'],
            ],
            'أ.د. يوسف الغامدي' => $this->facultyProfile(
                'أستاذ في الهندسة المدنية متخصص في هندسة الزلازل والإنشاءات.',
                'y.ghamdi@futureuniversity.edu', '+966 11 234 5701', 'مبنى الهندسة - مكتب 102',
                'الهندسة المدنية', 'هندسة الزلازل',
                ['publications' => 28, 'citations' => 620, 'hIndex' => 11, 'experience' => 22]
            ),
            'د. مريم العتيبي' => $this->facultyProfile(
                'أستاذة مساعدة في الهندسة الكهربائية، متخصصة في أنظمة الطاقة المتجددة.',
                'm.alotaibi@futureuniversity.edu', '+966 11 234 5702', 'مبنى الهندسة - مكتب 205',
                'الهندسة الكهربائية', 'أنظمة الطاقة المتجددة',
                ['publications' => 18, 'citations' => 340, 'hIndex' => 8, 'experience' => 12]
            ),
            'أ.د. سعد المطيري' => $this->facultyProfile(
                'أستاذ في الجراحة العامة، خبرة واسعة في الجراحة التنظيرية.',
                's.almutairi@futureuniversity.edu', '+966 11 234 5703', 'مبنى الطب - مكتب 305',
                'الجراحة', 'الجراحة العامة',
                ['publications' => 34, 'citations' => 890, 'hIndex' => 14, 'experience' => 20]
            ),
            'د. ليلى الحربي' => $this->facultyProfile(
                'أستاذة مشاركة في أمراض القلب والقسطرة التداخلية.',
                'l.alharbi@futureuniversity.edu', '+966 11 234 5704', 'مبنى الطب - مكتب 210',
                'الباطنة', 'أمراض القلب',
                ['publications' => 22, 'citations' => 510, 'hIndex' => 10, 'experience' => 15]
            ),
            'د. فيصل القحطاني' => $this->facultyProfile(
                'أستاذ مساعد في الإدارة الاستراتيجية وريادة الأعمال.',
                'f.alqahtani@futureuniversity.edu', '+966 11 234 5705', 'مبنى إدارة الأعمال - مكتب 108',
                'الإدارة', 'الإدارة الاستراتيجية',
                ['publications' => 16, 'citations' => 280, 'hIndex' => 7, 'experience' => 10]
            ),
            'أ.د. رنا الشمري' => $this->facultyProfile(
                'أستاذة في الذكاء الاصطناعي وتعلم الآلة العميق.',
                'r.alshamari@futureuniversity.edu', '+966 11 234 5706', 'مبنى علوم الحاسب - مكتب 310',
                'الذكاء الاصطناعي', 'تعلم الآلة العميق',
                ['publications' => 41, 'citations' => 1100, 'hIndex' => 16, 'experience' => 18]
            ),
            'د. عمر الزهراني' => $this->facultyProfile(
                'أستاذ مساعد في الأمن السيبراني واختبار الاختراق.',
                'o.alzahrani@futureuniversity.edu', '+966 11 234 5707', 'مبنى علوم الحاسب - مكتب 215',
                'أمن المعلومات', 'الأمن السيبراني',
                ['publications' => 19, 'citations' => 420, 'hIndex' => 9, 'experience' => 11]
            ),
            'أ.د. نادية الدوسري' => $this->facultyProfile(
                'أستاذة في الفيزياء التطبيقية والنانوتكنولوجي.',
                'n.aldosari@futureuniversity.edu', '+966 11 234 5708', 'مبنى العلوم - مكتب 401',
                'الفيزياء', 'الفيزياء التطبيقية',
                ['publications' => 33, 'citations' => 760, 'hIndex' => 13, 'experience' => 19]
            ),
        ];
    }

    private function facultyProfile(
        string $bio,
        string $email,
        string $phone,
        string $office,
        string $field,
        string $specialty,
        array $stats
    ): array {
        return [
            'bio' => $bio,
            'bio_extra' => [
                'تشارك في الإشراف على مشاريع التخرج والبحث العلمي في ' . $field . '.',
                'تهتم بتطوير مهارات الطلاب العملية وربط التعليم باحتياجات سوق العمل.',
            ],
            'bio_highlights' => ['التدريس الجامعي', 'البحث العلمي', 'الإشراف على الطلاب'],
            'email' => $email,
            'phone' => $phone,
            'office' => $office,
            'education' => [
                ['year' => '2005', 'degree' => 'بكالوريوس في ' . $field, 'institution' => 'جامعة الملك سعود'],
                ['year' => '2009', 'degree' => 'ماجستير في ' . $specialty, 'institution' => 'جامعة دولية'],
                ['year' => '2014', 'degree' => 'دكتوراه في ' . $specialty, 'institution' => 'جامعة دولية'],
            ],
            'experience' => [
                ['year' => '2018 - الآن', 'role' => 'عضو هيئة تدريس', 'desc' => 'التدريس والبحث في ' . $specialty],
                ['year' => '2014 - 2018', 'role' => 'باحث ما بعد الدكتوراه', 'desc' => 'بحث تطبيقي في ' . $field],
            ],
            'publications' => [
                ['title' => 'Recent Advances in ' . $specialty, 'journal' => 'International Research Journal', 'year' => '2024'],
                ['title' => 'Applied Studies in ' . $field, 'journal' => 'Academic Review', 'year' => '2023'],
            ],
            'skills' => [
                ['name' => $specialty, 'level' => 92],
                ['name' => 'البحث العلمي', 'level' => 88],
                ['name' => 'التدريس الجامعي', 'level' => 90],
            ],
            'stats' => $stats,
            'awards' => ['جائزة التميز في التدريس 2023'],
        ];
    }
}
