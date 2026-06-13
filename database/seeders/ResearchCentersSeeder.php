<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\HomepageStat;
use App\Models\ResearchCenter;
use App\Models\StaffMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ResearchCentersSeeder extends Seeder
{
    private array $collegeMap = [
        'كلية علوم الحاسب' => 'computer-science',
        'كلية الهندسة' => 'engineering',
        'كلية الطب' => 'medicine',
        'كلية الصيدلة' => 'pharmacy',
    ];

    public function run(): void
    {
        $centers = $this->centersData();

        foreach ($centers as $index => $data) {
            $collegeId = null;
            if (! empty($data['college_slug'])) {
                $collegeId = College::where('slug', $data['college_slug'])->value('id');
            }

            $directorId = null;
            if (! empty($data['director_name'])) {
                $directorId = StaffMember::where('name', $data['director_name'])->value('id');
            }

            $slug = Str::slug($data['name'], '-', 'ar') ?: 'research-center-' . ($index + 1);

            ResearchCenter::updateOrCreate(
                ['slug' => $slug],
                [
                    'name' => $data['name'],
                    'icon' => $data['icon'],
                    'description' => $data['description'],
                    'long_description' => $data['long_description'],
                    'college_id' => $collegeId,
                    'director_id' => $directorId,
                    'director_title' => $data['director_name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],
                    'established' => $data['established'],
                    'projects_count' => $data['projects_count'],
                    'publications_count' => $data['publications_count'],
                    'stats' => $data['stats'],
                    'focus_areas' => $data['focus_areas'],
                    'active_projects' => $data['active_projects'],
                    'partners' => $data['partners'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }

        $count = ResearchCenter::count();
        HomepageStat::where('label', 'like', '%مركز بحث%')->update(['value' => (string) $count]);
    }

    private function centersData(): array
    {
        return [
            [
                'name' => 'مركز أبحاث الذكاء الاصطناعي',
                'icon' => 'fa-robot',
                'description' => 'بحث متقدم في تعلم الآلة ومعالجة اللغات الطبيعية والرؤية الحاسوبية',
                'long_description' => '<p>يُعد مركز أبحاث الذكاء الاصطناعي من أبرز مراكز الجامعة، ويركز على تطوير حلول تعلم الآلة ومعالجة اللغات الطبيعية والرؤية الحاسوبية لخدمة القطاعات التعليمية والصحية والصناعية.</p>',
                'college_slug' => 'computer-science',
                'director_name' => 'أ.د. محمد العتيبي',
                'email' => 'ai.research@futureuniversity.edu',
                'phone' => '+966 11 234 5601',
                'established' => '2018',
                'projects_count' => 25,
                'publications_count' => 120,
                'stats' => ['researchers' => 45, 'labs' => 4, 'grants' => 12],
                'focus_areas' => ['تعلم الآلة', 'معالجة اللغات الطبيعية', 'الرؤية الحاسوبية', 'الذكاء الاصطناعي التفسيري'],
                'active_projects' => [
                    ['title' => 'نماذج لغوية للتعليم بالعربية', 'status' => 'جاري'],
                    ['title' => 'كشف الأمراض بالتصوير الطبي', 'status' => 'جاري'],
                    ['title' => 'أتمتة خدمات الطلاب', 'status' => 'مكتمل'],
                ],
                'partners' => ['Google Research', 'IBM', 'SDAIA'],
            ],
            [
                'name' => 'مركز أبحاث الطاقة المتجددة',
                'icon' => 'fa-solar-panel',
                'description' => 'دراسات في الطاقة الشمسية وطاقة الرياح وتخزين الطاقة',
                'long_description' => '<p>يعمل المركز على دراسات الطاقة الشمسية وطاقة الرياح وتخزين الطاقة، بما يتماشى مع رؤية المملكة 2030 في التحول نحو الطاقة النظيفة.</p>',
                'college_slug' => 'engineering',
                'director_name' => 'أ.د. فهد المطيري',
                'email' => 'energy.research@futureuniversity.edu',
                'phone' => '+966 11 234 5602',
                'established' => '2016',
                'projects_count' => 18,
                'publications_count' => 85,
                'stats' => ['researchers' => 32, 'labs' => 3, 'grants' => 9],
                'focus_areas' => ['الطاقة الشمسية', 'طاقة الرياح', 'تخزين الطاقة', 'كفاءة المباني'],
                'active_projects' => [
                    ['title' => 'محطات شمسية للحرم الجامعي', 'status' => 'جاري'],
                    ['title' => 'بطاريات ليثيوم متقدمة', 'status' => 'جاري'],
                    ['title' => 'تحليل بيانات استهلاك الطاقة', 'status' => 'مكتمل'],
                ],
                'partners' => ['KACST', 'NEOM', 'Saudi Aramco'],
            ],
            [
                'name' => 'مركز أبحاث العلوم الطبية',
                'icon' => 'fa-dna',
                'description' => 'أبحاث في العلاج الجيني والطب الشخصي والأمراض المزمنة',
                'long_description' => '<p>يركز المركز على أبحاث العلاج الجيني والطب الشخصي والأمراض المزمنة، بالتعاون مع مستشفيات الجامعة ومراكز التجارب السريرية.</p>',
                'college_slug' => 'medicine',
                'director_name' => 'أ.د. خالد الدوسري',
                'email' => 'medical.research@futureuniversity.edu',
                'phone' => '+966 11 234 5603',
                'established' => '2015',
                'projects_count' => 30,
                'publications_count' => 200,
                'stats' => ['researchers' => 58, 'labs' => 6, 'grants' => 18],
                'focus_areas' => ['العلاج الجيني', 'الطب الشخصي', 'الأمراض المزمنة', 'الأبحاث السريرية'],
                'active_projects' => [
                    ['title' => 'علاج جيني للسكري', 'status' => 'جاري'],
                    ['title' => 'مؤشرات حيوية للأورام', 'status' => 'جاري'],
                    ['title' => 'سجل طبي إلكتروني للبحث', 'status' => 'مكتمل'],
                ],
                'partners' => ['وزارة الصحة', 'King Faisal Specialist Hospital'],
            ],
            [
                'name' => 'مركز أبحاث الأمن السيبراني',
                'icon' => 'fa-shield-halved',
                'description' => 'حماية البيانات وأمن الشبكات والتشفير المتقدم',
                'long_description' => '<p>يختص المركز بحماية البيانات وأمن الشبكات والتشفير المتقدم، ويقدم استشارات أمنية للجهات الحكومية والخاصة.</p>',
                'college_slug' => 'computer-science',
                'director_name' => 'د. سارة الشمري',
                'email' => 'cyber.research@futureuniversity.edu',
                'phone' => '+966 11 234 5604',
                'established' => '2019',
                'projects_count' => 15,
                'publications_count' => 65,
                'stats' => ['researchers' => 28, 'labs' => 2, 'grants' => 7],
                'focus_areas' => ['أمن الشبكات', 'التشفير', 'التحليل الجنائي الرقمي', 'أمن IoT'],
                'active_projects' => [
                    ['title' => 'كشف التسلل بالذكاء الاصطناعي', 'status' => 'جاري'],
                    ['title' => 'بروتوكولات تشفير ما بعد الكم', 'status' => 'جاري'],
                    ['title' => 'منصة تدريب أمن سيبراني', 'status' => 'مكتمل'],
                ],
                'partners' => ['NCA', 'Cisco', 'Microsoft Security'],
            ],
            [
                'name' => 'مركز أبحاث الاستدامة البيئية',
                'icon' => 'fa-leaf',
                'description' => 'دراسات في التغير المناخي وإدارة الموارد الطبيعية',
                'long_description' => '<p>يدرس المركز التغير المناخي وإدارة الموارد الطبيعية والتصميم المستدام للمدن والمباني.</p>',
                'college_slug' => 'engineering',
                'director_name' => 'د. نورة القحطاني',
                'email' => 'sustainability@futureuniversity.edu',
                'phone' => '+966 11 234 5605',
                'established' => '2017',
                'projects_count' => 12,
                'publications_count' => 50,
                'stats' => ['researchers' => 22, 'labs' => 2, 'grants' => 6],
                'focus_areas' => ['التغير المناخي', 'إدارة المياه', 'التصميم المستدام', 'الاقتصاد الدائري'],
                'active_projects' => [
                    ['title' => 'خريطة حرارية للرياض', 'status' => 'جاري'],
                    ['title' => 'إعادة تدوير مياه الصرف', 'status' => 'جاري'],
                    ['title' => 'مؤشر الاستدامة للحرم', 'status' => 'مكتمل'],
                ],
                'partners' => ['UNEP', 'Ministry of Environment'],
            ],
            [
                'name' => 'مركز أبحاث التقنية الحيوية',
                'icon' => 'fa-microscope',
                'description' => 'أبحاث في الهندسة الوراثية والتطبيقات الطبية الحيوية',
                'long_description' => '<p>يركز على الهندسة الوراثية والتطبيقات الطبية الحيوية وتطوير الأدوية الحيوية.</p>',
                'college_slug' => 'pharmacy',
                'director_name' => 'د. منال العنزي',
                'email' => 'biotech@futureuniversity.edu',
                'phone' => '+966 11 234 5606',
                'established' => '2020',
                'projects_count' => 20,
                'publications_count' => 95,
                'stats' => ['researchers' => 35, 'labs' => 5, 'grants' => 11],
                'focus_areas' => ['الهندسة الوراثية', 'الأدوية الحيوية', 'مختبرات الأحياء الدقيقة', 'التشخيص الجزيئي'],
                'active_projects' => [
                    ['title' => 'لقاحات RNA رسول محلية', 'status' => 'جاري'],
                    ['title' => 'CRISPR للأمراض الوراثية', 'status' => 'جاري'],
                    ['title' => 'مكتبة جينات للبحث', 'status' => 'مكتمل'],
                ],
                'partners' => ['SFDA', 'Pfizer Research'],
            ],
        ];
    }
}
