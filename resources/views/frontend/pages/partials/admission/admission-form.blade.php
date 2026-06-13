<section class="admission-form-section section-fade-up" id="application-form">
            <div class="container">
                <div class="section-head text-center mb-4">
                    <span class="section-head__eyebrow">نموذج التقديم</span>
                    <h2 class="section-head__title">قدم طلب القبول الآن</h2>
                    <p class="section-head__desc mx-auto mb-0" style="max-width: 560px;">أدخل بياناتك بدقة لبدء عملية التقديم في جامعة المستقبل.</p>
                </div>

                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <form id="admission-form" class="admission-form-panel" action="{{ route('admission.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                            </div>
                            @endif
                            @if(empty($openCycle))
                            <div class="alert alert-warning">بوابة القبول مغلقة حالياً.</div>
                            @endif
                            <h4 class="admission-form__section-title">
                                <i class="fas fa-user ms-2"></i>البيانات الشخصية
                            </h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="admission-form__label">الاسم الأول *</label>
                                    <input type="text" name="firstName" class="form-control" placeholder="أدخل اسمك الأول" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">اسم العائلة *</label>
                                    <input type="text" name="lastName" class="form-control" placeholder="أدخل اسم العائلة" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">رقم الهوية / الإقامة *</label>
                                    <input type="text" name="nationalId" class="form-control" placeholder="أدخل رقم الهوية" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">تاريخ الميلاد *</label>
                                    <input type="date" name="birthDate" class="form-control" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">الجنسية *</label>
                                    <select name="nationality" class="form-select" required>
                                        <option value="" class="bg-dark">اختر الجنسية</option>
                                        <option value="saudi" class="bg-dark">سعودي</option>
                                        <option value="non-saudi" class="bg-dark">غير سعودي</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">الجنس *</label>
                                    <select name="gender" class="form-select" required>
                                        <option value="" class="bg-dark">اختر الجنس</option>
                                        <option value="male" class="bg-dark">ذكر</option>
                                        <option value="female" class="bg-dark">أنثى</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Contact Info -->
                            <h4 class="admission-form__section-title">
                                <i class="fas fa-phone ms-2"></i>معلومات التواصل
                            </h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="admission-form__label">البريد الإلكتروني *</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">رقم الجوال *</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="05XXXXXXXX" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">المدينة *</label>
                                    <select name="city" class="form-select" required>
                                        <option value="" class="bg-dark">اختر المدينة</option>
                                        <option value="riyadh" class="bg-dark">الرياض</option>
                                        <option value="jeddah" class="bg-dark">جدة</option>
                                        <option value="dammam" class="bg-dark">الدمام</option>
                                        <option value="makkah" class="bg-dark">مكة المكرمة</option>
                                        <option value="madinah" class="bg-dark">المدينة المنورة</option>
                                        <option value="other" class="bg-dark">أخرى</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">العنوان</label>
                                    <input type="text" name="address" class="form-control" placeholder="الحي - الشارع">
                                </div>
                            </div>

                            <!-- Academic Info -->
                            <h4 class="admission-form__section-title">
                                <i class="fas fa-graduation-cap ms-2"></i>البيانات الأكاديمية
                            </h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="admission-form__label">نوع الشهادة *</label>
                                    <select name="degreeType" class="form-select" required>
                                        <option value="" class="bg-dark">اختر نوع الشهادة</option>
                                        <option value="bachelor" class="bg-dark">بكالوريوس</option>
                                        <option value="master" class="bg-dark">ماجستير</option>
                                        <option value="phd" class="bg-dark">دكتوراه</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">البرنامج المطلوب *</label>
                                    <select name="program_id" class="form-select" required {{ empty($openCycle) ? 'disabled' : '' }}>
                                        <option value="" class="bg-dark">اختر البرنامج</option>
                                        @foreach($programs ?? [] as $program)
                                        <option value="{{ $program->id }}" class="bg-dark" @selected(old('program_id') == $program->id)>
                                            {{ $program->name }} — {{ $program->college?->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">اسم المدرسة / الجامعة السابقة *</label>
                                    <input type="text" name="prevSchool" class="form-control" placeholder="اسم المدرسة أو الجامعة" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="admission-form__label">المعدل *</label>
                                    <input type="number" name="gpa" class="form-control" placeholder="المعدل" min="0" max="100" step="0.01" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="admission-form__label">سنة التخرج *</label>
                                    <input type="number" name="gradYear" class="form-control" placeholder="2026" min="2000" max="2026" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">درجة اختبار القدرات</label>
                                    <input type="number" name="qudrat" class="form-control" placeholder="درجة القدرات" min="0" max="100" step="0.01">
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">درجة التحصيلي</label>
                                    <input type="number" name="tahsili" class="form-control" placeholder="درجة التحصيلي" min="0" max="100" step="0.01">
                                </div>
                            </div>

                            <!-- Preferences -->
                            <h4 class="admission-form__section-title">
                                <i class="fas fa-list-check ms-2"></i>الرغبات والتخصصات
                            </h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="admission-form__label">الرغبة الأولى *</label>
                                    <select name="pref1" class="form-select" required>
                                        <option value="" class="bg-dark">اختر التخصص</option>
                                        <option value="ce" class="bg-dark">الهندسة المدنية</option>
                                        <option value="me" class="bg-dark">الهندسة المعمارية</option>
                                        <option value="cs" class="bg-dark">علوم الحاسب</option>
                                        <option value="ai" class="bg-dark">الذكاء الاصطناعي</option>
                                        <option value="med" class="bg-dark">الطب والجراحة</option>
                                        <option value="pharm" class="bg-dark">الصيدلة</option>
                                        <option value="bus" class="bg-dark">إدارة الأعمال</option>
                                        <option value="acc" class="bg-dark">المحاسبة</option>
                                        <option value="law" class="bg-dark">القانون</option>
                                        <option value="edu" class="bg-dark">التربية</option>
                                        <option value="sci" class="bg-dark">العلوم</option>
                                        <option value="des" class="bg-dark">التصميم</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">الرغبة الثانية</label>
                                    <select name="pref2" class="form-select">
                                        <option value="" class="bg-dark">اختر التخصص</option>
                                        <option value="ce" class="bg-dark">الهندسة المدنية</option>
                                        <option value="me" class="bg-dark">الهندسة المعمارية</option>
                                        <option value="cs" class="bg-dark">علوم الحاسب</option>
                                        <option value="ai" class="bg-dark">الذكاء الاصطناعي</option>
                                        <option value="med" class="bg-dark">الطب والجراحة</option>
                                        <option value="pharm" class="bg-dark">الصيدلة</option>
                                        <option value="bus" class="bg-dark">إدارة الأعمال</option>
                                        <option value="acc" class="bg-dark">المحاسبة</option>
                                        <option value="law" class="bg-dark">القانون</option>
                                        <option value="edu" class="bg-dark">التربية</option>
                                        <option value="sci" class="bg-dark">العلوم</option>
                                        <option value="des" class="bg-dark">التصميم</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="admission-form__label">الرغبة الثالثة</label>
                                    <select name="pref3" class="form-select">
                                        <option value="" class="bg-dark">اختر التخصص</option>
                                        <option value="ce" class="bg-dark">الهندسة المدنية</option>
                                        <option value="me" class="bg-dark">الهندسة المعمارية</option>
                                        <option value="cs" class="bg-dark">علوم الحاسب</option>
                                        <option value="ai" class="bg-dark">الذكاء الاصطناعي</option>
                                        <option value="med" class="bg-dark">الطب والجراحة</option>
                                        <option value="pharm" class="bg-dark">الصيدلة</option>
                                        <option value="bus" class="bg-dark">إدارة الأعمال</option>
                                        <option value="acc" class="bg-dark">المحاسبة</option>
                                        <option value="law" class="bg-dark">القانون</option>
                                        <option value="edu" class="bg-dark">التربية</option>
                                        <option value="sci" class="bg-dark">العلوم</option>
                                        <option value="des" class="bg-dark">التصميم</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Uploads -->
                            <h4 class="admission-form__section-title">
                                <i class="fas fa-cloud-arrow-up ms-2"></i>رفع المستندات
                            </h4>
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <label class="admission-form__label">صورة الشهادة *</label>
                                    <input type="file" name="certificate" class="form-control" accept=".pdf,.jpg,.png" required>
                                    <small class="text-secondary">PDF أو صورة - الحد الأقصى 5MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">صورة الهوية *</label>
                                    <input type="file" name="idCard" class="form-control" accept=".pdf,.jpg,.png" required>
                                    <small class="text-secondary">PDF أو صورة - الحد الأقصى 5MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">نتيجة القدرات</label>
                                    <input type="file" name="qudratResult" class="form-control" accept=".pdf,.jpg,.png">
                                    <small class="text-secondary">PDF أو صورة - الحد الأقصى 5MB</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="admission-form__label">صورة شخصية</label>
                                    <input type="file" name="photo" class="form-control" accept=".jpg,.png">
                                    <small class="text-secondary">صورة بخلفية بيضاء - الحد الأقصى 2MB</small>
                                </div>
                            </div>

                            <!-- Agreement -->
                            <div class="admission-form__agreement">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="agreeTerms" name="agreeTerms" value="1" required>
                                    <label class="form-check-label" for="agreeTerms">
                                        أقر بأن جميع البيانات المدخلة صحيحة وأتحمل المسؤولية في حال ثبوت خلاف ذلك.
                                    </label>
                                </div>
                                <div class="form-check mt-2">
                                    <input class="form-check-input" type="checkbox" id="agreePrivacy" required>
                                    <label class="form-check-label" for="agreePrivacy">
                                        أوافق على <a href="#" class="text-accent">سياسة الخصوصية</a> و <a href="#" class="text-accent">شروط الاستخدام</a>.
                                    </label>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-accent btn-lg px-5 py-3 rounded-pill" {{ empty($openCycle) ? 'disabled' : '' }}>
                                    <i class="fas fa-paper-plane ms-2"></i>إرسال طلب القبول
                                </button>
                                <p class="text-secondary small mt-3">سيتم مراجعة طلبك والتواصل معك خلال 5-7 أيام عمل.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
