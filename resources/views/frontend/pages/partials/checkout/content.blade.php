<div class="row g-5">
            <!-- Left: Checkout Form -->
            <div class="col-lg-7">
                <!-- Billing Info -->
                <div class="glass-panel p-4 mb-4 section-fade-up">
                    <h5 class="fw-bold text-white mb-4"><i class="fas fa-user-circle text-accent ms-2"></i> معلومات المشتري</h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label text-secondary small">الاسم الأول</label>
                            <input type="text" class="form-control bg-glass text-white border-secondary" id="first-name" placeholder="أحمد">
                            <div class="invalid-feedback">الاسم مطلوب</div>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label text-secondary small">الاسم الأخير</label>
                            <input type="text" class="form-control bg-glass text-white border-secondary" id="last-name" placeholder="سعيد">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small">البريد الإلكتروني</label>
                            <input type="email" class="form-control bg-glass text-white border-secondary" id="email" placeholder="ahmed@example.com">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small">رقم الهاتف</label>
                            <input type="tel" class="form-control bg-glass text-white border-secondary" id="phone" placeholder="+971 50 000 0000">
                        </div>
                    </div>
                </div>

                <!-- Card Preview -->
                <div class="glass-panel p-4 mb-4 section-fade-up">
                    <h5 class="fw-bold text-white mb-4"><i class="fas fa-credit-card text-accent ms-2"></i> بيانات البطاقة</h5>

                    <!-- Live Card Visual -->
                    <div class="credit-card-preview mb-4" id="card-preview">
                        <div class="card-inner">
                            <!-- Front -->
                            <div class="card-front">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <i class="fas fa-graduation-cap fa-2x text-white opacity-50"></i>
                                    <div id="card-type-icon"><i class="fab fa-cc-visa fa-2x text-white opacity-75"></i></div>
                                </div>
                                <div class="card-chip mb-3">
                                    <i class="fas fa-microchip fa-2x text-white opacity-50"></i>
                                </div>
                                <div class="card-number-display en-text mb-3" id="card-number-display">•••• •••• •••• ••••</div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div>
                                        <div class="text-white-50 small mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">CARD HOLDER</div>
                                        <div class="card-holder-display en-text" id="card-holder-display">FULL NAME</div>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-white-50 small mb-1" style="font-size: 0.65rem; letter-spacing: 1px;">EXPIRES</div>
                                        <div class="card-exp-display en-text" id="card-exp-display">MM/YY</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Back -->
                            <div class="card-back">
                                <div class="card-stripe"></div>
                                <div class="card-cvv-strip">
                                    <span class="small text-secondary me-2">CVV</span>
                                    <div class="cvv-display en-text" id="card-cvv-display">•••</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Form -->
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label text-secondary small">اسم حامل البطاقة</label>
                            <input type="text" class="form-control bg-glass text-white border-secondary text-uppercase" id="card-name" placeholder="AHMED SAID" maxlength="26" onkeyup="updateCardPreview()">
                        </div>
                        <div class="col-12">
                            <label class="form-label text-secondary small">رقم البطاقة</label>
                            <input type="text" class="form-control bg-glass text-white border-secondary en-text" id="card-number" placeholder="1234 5678 9012 3456" maxlength="19" oninput="formatCardNumber(this); updateCardPreview()">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small">تاريخ الانتهاء</label>
                            <input type="text" class="form-control bg-glass text-white border-secondary en-text" id="card-expiry" placeholder="MM/YY" maxlength="5" oninput="formatExpiry(this); updateCardPreview()">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-secondary small">رمز CVV</label>
                            <input type="password" class="form-control bg-glass text-white border-secondary en-text" id="card-cvv" placeholder="•••" maxlength="4" onfocus="flipCard(true)" onblur="flipCard(false)" oninput="updateCardPreview()">
                        </div>
                    </div>

                    <!-- Payment Method Badges -->
                    <div class="d-flex gap-2 flex-wrap mt-4 align-items-center">
                        <span class="text-secondary small ms-2">نقبل:</span>
                        <i class="fab fa-cc-visa fa-2x text-secondary opacity-75"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-secondary opacity-75"></i>
                        <i class="fab fa-cc-paypal fa-2x text-secondary opacity-75"></i>
                        <i class="fab fa-cc-amex fa-2x text-secondary opacity-75"></i>
                    </div>
                </div>

                <!-- Submit -->
                <button class="btn btn-accent w-100 py-3 fw-bold fs-5 shadow rounded-3 mb-2 section-fade-up" id="submit-order" onclick="submitOrder()">
                    <i class="fas fa-lock ms-2"></i> تأكيد الدفع وإتمام الطلب
                </button>
                <p class="text-center text-secondary small"><i class="fas fa-shield-alt me-1 text-accent"></i> جميع بياناتك محمية ومشفرة 100%</p>
            </div>

            <!-- Right: Order Summary -->
            <div class="col-lg-5">
                <div class="glass-card position-sticky section-fade-up" style="top: 100px; z-index: 10;">
                    <div class="p-4">
                        <h5 class="fw-bold text-white mb-4"><i class="fas fa-receipt text-accent ms-2"></i> ملخص الطلب</h5>

                        <div id="checkout-order-items" class="d-flex flex-column gap-3 mb-4">
                            <!-- populated by JS -->
                        </div>

                        <hr class="border-secondary border-opacity-25">

                        <div class="d-flex justify-content-between text-secondary mb-2">
                            <span>المجموع:</span>
                            <span class="en-text" id="checkout-subtotal">$0</span>
                        </div>
                        <div class="d-flex justify-content-between text-success mb-2">
                            <span>الخصم:</span>
                            <span class="en-text" id="checkout-discount">-$0</span>
                        </div>
                        <hr class="border-secondary border-opacity-25">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-white m-0">الإجمالي:</h5>
                            <h3 class="fw-bold text-accent m-0 en-text" id="checkout-total">$0</h3>
                        </div>
                    </div>
                    
                    <!-- Success Message (hidden by default) -->
                    <div id="order-success" class="d-none p-4 text-center border-top border-secondary border-opacity-25">
                        <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                        <h5 class="fw-bold text-white">تم تأكيد طلبك بنجاح!</h5>
                        <p class="text-secondary">سيتم إرسال تفاصيل الطلب على بريدك الإلكتروني.</p>
                        <a href="{{ url('/courses') }}" class="btn btn-accent rounded-pill px-4 mt-2">تصفح المزيد من الكورسات</a>
                    </div>
                </div>
            </div>
        </div>
