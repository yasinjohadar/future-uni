<aside class="col-lg-3"><div class="glass-panel p-4 sticky-top section-fade-up" style="top: 100px; z-index: 10;">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold m-0"><i class="fas fa-filter text-accent me-2"></i> تصفية</h5>
                        <button class="btn btn-sm btn-outline-secondary py-0 border-0" id="reset-filters" style="font-size: 0.85rem">إعادة ضبط</button>
                    </div>

                    <!-- Search -->
                    <div class="mb-4">
                        <input type="text" id="search-input" class="form-control bg-glass text-white rounded-3 border-secondary" placeholder="ابحث عن كورس...">
                    </div>

                    <!-- Category Filter -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">التصنيف</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox" type="checkbox" value="programming" id="cat-prog">
                            <label class="form-check-label text-secondary" for="cat-prog">البرمجة والتطوير</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox" type="checkbox" value="design" id="cat-design">
                            <label class="form-check-label text-secondary" for="cat-design">التصميم الجرافيكي</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox" type="checkbox" value="marketing" id="cat-marketing">
                            <label class="form-check-label text-secondary" for="cat-marketing">التسويق الرقمي</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox" type="checkbox" value="languages" id="cat-languages">
                            <label class="form-check-label text-secondary" for="cat-languages">اللغات</label>
                        </div>
                    </div>

                    <hr class="border-secondary border-opacity-25 mb-4">

                    <!-- Price Filter -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">السعر (أقل من: <span id="price-val" class="text-accent en-text fw-bold">$200</span>)</h6>
                        <input type="range" class="form-range" min="0" max="250" value="250" id="price-range">
                    </div>

                    <hr class="border-secondary border-opacity-25 mb-4">

                    <!-- Level -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">المستوى</h6>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox level" type="checkbox" value="beginner" id="lvl-beg">
                            <label class="form-check-label text-secondary" for="lvl-beg">مبتدئ</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox level" type="checkbox" value="intermediate" id="lvl-med">
                            <label class="form-check-label text-secondary" for="lvl-med">متوسط</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input bg-glass border-secondary filter-checkbox level" type="checkbox" value="advanced" id="lvl-adv">
                            <label class="form-check-label text-secondary" for="lvl-adv">متقدم</label>
                        </div>
                    </div>

                </div>
            </aside>
