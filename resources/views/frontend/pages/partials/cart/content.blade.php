<div class="row g-5 section-fade-up">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold text-white m-0">العناصر في السلة (<span id="cart-page-count" class="en-text text-accent">0</span>)</h4>
                    <button class="btn btn-sm btn-outline-danger rounded-pill px-3" id="clear-cart-btn" style="display: none;">إفراغ السلة</button>
                </div>

                <div id="cart-items-container" class="d-flex flex-column gap-3">
                    <!-- Loaded via JS -->
                    <div class="text-center py-5 d-none" id="empty-cart-msg">
                        <i class="fas fa-shopping-cart fa-4x text-secondary opacity-50 mb-4"></i>
                        <h4 class="text-white mb-3">سلتك فارغة حالياً</h4>
                        <p class="text-secondary mb-4">اكتشف كورساتنا المميزة وابدأ رحلة التعلم اليوم.</p>
                        <a href="{{ url('/courses') }}" class="btn btn-accent px-4 py-2 rounded-pill">تصفح الكورسات</a>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="col-lg-4">
                <div class="glass-card position-sticky" style="top: 100px; z-index: 10;">
                    <div class="p-4">
                        <h4 class="fw-bold text-white mb-4">ملخص الطلب</h4>
                        
                        <div class="d-flex justify-content-between mb-3 text-secondary">
                            <span>السعر الأصلي:</span>
                            <span class="en-text" id="summary-old-total">$0</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3 text-success">
                            <span>الخصومات:</span>
                            <span class="en-text" id="summary-discount">-$0</span>
                        </div>
                        
                        <hr class="border-secondary border-opacity-25 my-4">
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold text-white m-0">الإجمالي:</h5>
                            <h3 class="fw-bold text-accent m-0 en-text" id="summary-total">$0</h3>
                        </div>

                        <!-- Coupon Form -->
                        <div class="input-group mb-4">
                            <input type="text" class="form-control bg-glass text-white border-secondary" placeholder="أدخل كود الخصم" id="coupon-input">
                            <button class="btn btn-outline-light border-secondary hover-accent" type="button" id="apply-coupon">تطبيق</button>
                        </div>
                        <p id="coupon-msg" class="text-success small d-none mt-neg-3 mb-4"><i class="fas fa-check-circle me-1"></i> تم تطبيق الخصم بنجاح</p>

                        <a href="{{ url('/checkout') }}" class="btn btn-accent w-100 py-3 fw-bold fs-5 shadow rounded-3 mb-3" id="checkout-btn">إتمام الطلب <i class="fas fa-lock ms-2 small"></i></a>
                        <p class="text-center text-secondary small m-0"><i class="fas fa-shield-alt me-1 text-accent"></i> الدفع آمن ومشفّر 100%</p>
                    </div>
                </div>
            </div>
        </div>
