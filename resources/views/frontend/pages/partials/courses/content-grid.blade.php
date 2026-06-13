<!-- Courses Grid -->
            <div class="col-lg-9">
                <!-- Top actions -->
                <div class="glass-panel p-3 mb-4 section-fade-up d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="text-secondary small">
                        عرض <span id="courses-count" class="text-white fw-bold en-text">0</span> نتيجة
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <label class="text-secondary whitespace-nowrap mb-0 small text-nowrap">ترتيب حسب:</label>
                            <select class="form-select form-select-sm bg-glass text-white border-secondary rounded-3" id="sort-select" style="min-width: 150px">
                                <option value="popular">الأكثر شعبية</option>
                                <option value="newest">الأحدث</option>
                                <option value="price-asc">السعر: من الأقل للأعلى</option>
                                <option value="price-desc">السعر: من الأعلى للأقل</option>
                            </select>
                        </div>
                        <div class="d-none d-md-flex gap-1 border border-secondary border-opacity-25 rounded-3 p-1">
                            <button class="btn btn-sm btn-glass border-0 active toggle-view" data-view="grid"><i class="fas fa-th-large"></i></button>
                            <button class="btn btn-sm btn-glass border-0 toggle-view" data-view="list"><i class="fas fa-list"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Courses Container -->
                <div class="row g-4 section-fade-up" id="all-courses-container">
                    <!-- Populated by JS -->
                </div>

                <!-- Pagination -->
                <nav class="mt-5 section-fade-up">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link bg-glass border-secondary text-white rounded-start-pill px-3" href="#" tabindex="-1">السابق</a>
                        </li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link border-secondary" style="background-color: var(--accent-color); color: white" href="#">1</a>
                        </li>
                        <li class="page-item"><a class="page-link bg-glass border-secondary text-white" href="#">2</a></li>
                        <li class="page-item"><a class="page-link bg-glass border-secondary text-white" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link bg-glass border-secondary text-white rounded-end-pill px-3" href="#">التالي</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
