document.addEventListener('DOMContentLoaded', () => {
  // Theme is handled by uni-main.js when present; fallback for legacy pages only
  if (!document.querySelector('script[src*="uni-main.js"]')) {
    const themeToggleBottons = document.querySelectorAll('.theme-toggle');
    const htmlTag = document.documentElement;
    const savedTheme = localStorage.getItem('uni_theme') || localStorage.getItem('lms_theme') || 'dark';
    htmlTag.setAttribute('data-theme', savedTheme);
    localStorage.setItem('uni_theme', savedTheme);
    updateThemeIcons(savedTheme);

    themeToggleBottons.forEach(btn => {
      btn.addEventListener('click', () => {
        const currentTheme = htmlTag.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        htmlTag.setAttribute('data-theme', newTheme);
        localStorage.setItem('uni_theme', newTheme);
        localStorage.setItem('lms_theme', newTheme);
        updateThemeIcons(newTheme);
      });
    });

    function updateThemeIcons(theme) {
      themeToggleBottons.forEach(btn => {
        btn.innerHTML = theme === 'dark' ? '<i class="fas fa-sun"></i>' : '<i class="fas fa-moon"></i>';
      });
    }
  }

  // Cart Management (Global)
  updateCartBadge();

  // Initialize Tooltips & Popovers from Bootstrap if needed
  // ...

  // UI Initializations
  initTypingAnimation();
  initCounters();
  initScrollAnimations();

  // Load Home Courses if we're on index
  if(document.getElementById('home-courses-container')) {
    renderHomeCourses();
  }
  
  // Courses Page Logic
  if(document.getElementById('all-courses-container')) {
    initCoursesPage();
  }

  // Categories Page Logic
  if(document.getElementById('category-courses-section')) {
    initCategoriesPage();
  }

  // Cart Page Logic
  if(document.getElementById('cart-items-container')) {
    initCartPage();
  }

  // Checkout Page Logic
  if(document.getElementById('checkout-order-items')) {
    initCheckoutPage();
  }
});

// Cart Functions
function getCart() {
  const cart = localStorage.getItem('lms_cart');
  return cart ? JSON.parse(cart) : [];
}

function saveCart(cart) {
  localStorage.setItem('lms_cart', JSON.stringify(cart));
}

function updateCartBadge() {
  const cart = getCart();
  const badges = document.querySelectorAll('.cart-badge');
  badges.forEach(b => {
      b.textContent = cart.length;
      if(cart.length > 0) {
          b.style.transform = 'scale(1.2)';
          setTimeout(() => b.style.transform = 'scale(1)', 200);
      } else {
          b.style.transform = 'scale(0)'; // Hide if empty
      }
  });
}

function addToCart(course) {
  const cart = getCart();
  const exists = cart.find(item => item.id === course.id);
  
  if (exists) {
    showToast('موجود في السلة', 'warning');
  } else {
    cart.push(course);
    saveCart(cart);
    updateCartBadge();
    showToast('تمت الإضافة للسلة!', 'success');
  }
}

function removeFromCart(id) {
  let cart = getCart();
  cart = cart.filter(item => item.id !== id);
  saveCart(cart);
  updateCartBadge();
  if(document.getElementById('cart-items-container')) {
    initCartPage();
  }
}

function clearCart() {
  saveCart([]);
  updateCartBadge();
  if(document.getElementById('cart-items-container')) {
    initCartPage();
  }
}

// Simple Toast Notification Logic
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
  toast.className = `toast align-items-center text-white border-0 glass-panel mb-2`;
  toast.setAttribute('role', 'alert');
  toast.setAttribute('aria-live', 'assertive');
  toast.setAttribute('aria-atomic', 'true');
  toast.style.background = type === 'success' ? 'rgba(40, 167, 69, 0.85)' : type === 'warning' ? 'rgba(255, 193, 7, 0.85)' : 'rgba(220, 53, 69, 0.85)';
  
  toast.innerHTML = `
    <div class="d-flex align-items-center px-3 py-2" style="direction: rtl; gap: 10px;">
      <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'times-circle'}"></i>
      <span class="toast-body py-0 px-0 text-white">${title}</span>
      <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;
  
  toastContainer.appendChild(toast);
  
  try {
    const bsToast = new bootstrap.Toast(toast, { delay: 3000 });
    bsToast.show();
    toast.addEventListener('hidden.bs.toast', () => toast.remove());
  } catch(e) {
    console.error('Bootstrap JS not loaded', e);
    setTimeout(() => toast.remove(), 3500);
  }
}

// ============================================
// Data & Rendering
// ============================================
const coursesData = [
  { id: 1, title: 'الدورة الشاملة في تطوير واجهات الويب المحترفة', category: 'programming', categoryName: 'البرمجة', instructor: 'م. أحمد سعيد', rating: 4.8, students: 12500, oldPrice: 199, newPrice: 49, badge: 'الأكثر مبيعاً', imgIcon: 'fa-laptop-code' },
  { id: 2, title: 'تصميم واجهات المستخدم UI/UX التفاعلية', category: 'design', categoryName: 'التصميم', instructor: 'سارة محمد', rating: 4.9, students: 8400, oldPrice: 150, newPrice: 35, badge: 'جديد', imgIcon: 'fa-pen-nib' },
  { id: 3, title: 'التسويق الرقمي وإدارة الحملات الإعلانية', category: 'marketing', categoryName: 'التسويق', instructor: 'طارق علي', rating: 4.7, students: 5600, oldPrice: 120, newPrice: 29, badge: '', imgIcon: 'fa-bullhorn' },
  { id: 4, title: 'تعلم الذكاء الاصطناعي وبناء النماذج التوليدية', category: 'ai', categoryName: 'الذكاء الاصطناعي', instructor: 'د. يوسف إبراهيم', rating: 4.9, students: 2100, oldPrice: 250, newPrice: 65, badge: 'الأعلى تقييماً', imgIcon: 'fa-robot' },
  { id: 5, title: 'إتقان اللغة الإنجليزية للمحترفين في بيئة العمل', category: 'languages', categoryName: 'اللغات', instructor: 'جون سميث', rating: 4.6, students: 15000, oldPrice: 90, newPrice: 19, badge: '', imgIcon: 'fa-language' },
  { id: 6, title: 'إدارة المشاريع الرشيقة Agile & Scrum', category: 'business', categoryName: 'الأعمال', instructor: 'نهى عبد الرحمن', rating: 4.8, students: 4300, oldPrice: 175, newPrice: 45, badge: 'موصى به', imgIcon: 'fa-chart-pie' }
];

function renderHomeCourses() {
  const container = document.getElementById('home-courses-container');
  let html = '';
  
  coursesData.forEach(course => {
    const badgeHTML = course.badge ? `<span class="course-badge">${course.badge}</span>` : '';
    
    html += `
    <div class="col-md-6 col-lg-4">
        <div class="glass-card h-100 d-flex flex-column">
            <div class="course-img text-white text-center">
                ${badgeHTML}
                <i class="fas ${course.imgIcon} fa-4x opacity-50"></i>
            </div>
            <div class="p-3 d-flex flex-column flex-grow-1">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="badge bg-white bg-opacity-10 text-accent px-2 py-1">${course.categoryName}</span>
                    <div class="text-warning en-text small">
                        <i class="fas fa-star"></i> ${course.rating}
                    </div>
                </div>
                <h5 class="fw-bold mb-3 d-flex flex-grow-1">
                    <a href="course-detail.html?id=${course.id}" class="text-white text-decoration-none text-truncate-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        ${course.title}
                    </a>
                </h5>
                <div class="d-flex align-items-center text-secondary small mb-3">
                    <i class="fas fa-user-tie ms-2 text-accent"></i> <span>${course.instructor}</span>
                    <span class="mx-2 text-white-50">|</span>
                    <i class="fas fa-users ms-2 text-accent"></i> <span class="en-text">${course.students.toLocaleString()}</span> طالب
                </div>
                <hr class="border-secondary mt-auto">
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <div>
                        <span class="old-price ms-2">$${course.oldPrice}</span>
                        <span class="new-price">$${course.newPrice}</span>
                    </div>
                    <button class="btn btn-sm btn-accent rounded-circle" style="width: 35px; height:35px; padding:0" onclick='addToCart(${JSON.stringify(course)})' aria-label="Add to cart">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    `;
  });
  
  container.innerHTML = html;
}

function initCoursesPage() {
  const container = document.getElementById('all-courses-container');
  const countSpan = document.getElementById('courses-count');
  const searchInput = document.getElementById('search-input');
  const priceRange = document.getElementById('price-range');
  const priceVal = document.getElementById('price-val');
  const sortSelect = document.getElementById('sort-select');
  const checkboxes = document.querySelectorAll('.filter-checkbox');
  const resetBtn = document.getElementById('reset-filters');
  const viewBtns = document.querySelectorAll('.toggle-view');
  
  let currentView = 'grid'; // grid or list
  
  // Extended mock data for courses page
  const allCourses = [...coursesData, 
    { id: 7, title: 'احترف برمجة تطبيقات فلاتر (Flutter)', category: 'programming', categoryName: 'البرمجة', instructor: 'م. خالد أحمد', rating: 4.9, students: 6200, oldPrice: 210, newPrice: 55, badge: 'تحديث جديد', imgIcon: 'fa-mobile-alt', level: 'intermediate' },
    { id: 8, title: 'أساسيات المحاسبة والمالية لغير الماليين', category: 'business', categoryName: 'الأعمال', instructor: 'طارق زياد', rating: 4.5, students: 3100, oldPrice: 110, newPrice: 25, badge: '', imgIcon: 'fa-calculator', level: 'beginner' },
    { id: 9, title: 'دورة شاملة في تحليل البيانات Python & Pandas', category: 'ai', categoryName: 'البيانات', instructor: 'ليلى حسن', rating: 4.8, students: 9500, oldPrice: 160, newPrice: 39, badge: 'الأكثر طلباً', imgIcon: 'fa-chart-line', level: 'advanced' },
    { id: 10, title: 'تطوير الألعاب باستخدام Unity', category: 'programming', categoryName: 'البرمجة', instructor: 'عمر مصطفى', rating: 4.7, students: 4800, oldPrice: 180, newPrice: 45, badge: '', imgIcon: 'fa-gamepad', level: 'beginner' }
  ];

  function renderFilteredCourses() {
    let filtered = [...allCourses];
    
    // Search filter
    const term = searchInput.value.toLowerCase();
    if(term) {
      filtered = filtered.filter(c => c.title.toLowerCase().includes(term) || c.instructor.toLowerCase().includes(term));
    }
    
    // Price filter
    const maxPrice = parseInt(priceRange.value);
    filtered = filtered.filter(c => c.newPrice <= maxPrice);
    
    // Categories filter
    const activeCats = Array.from(document.querySelectorAll('.filter-checkbox:not(.level):checked')).map(cb => cb.value);
    if(activeCats.length > 0) {
      filtered = filtered.filter(c => activeCats.includes(c.category));
    }
    
    // Level filter (Mock random level if missing)
    const activeLevels = Array.from(document.querySelectorAll('.filter-checkbox.level:checked')).map(cb => cb.value);
    if(activeLevels.length > 0) {
      filtered = filtered.filter(c => {
         const lvl = c.level || 'beginner'; // fallback mock
         return activeLevels.includes(lvl);
      });
    }
    
    // Sort
    const sortVal = sortSelect.value;
    if(sortVal === 'price-asc') filtered.sort((a,b) => a.newPrice - b.newPrice);
    if(sortVal === 'price-desc') filtered.sort((a,b) => b.newPrice - a.newPrice);
    if(sortVal === 'newest') filtered.sort((a,b) => b.id - a.id);
    if(sortVal === 'popular') filtered.sort((a,b) => b.students - a.students);
    
    countSpan.textContent = filtered.length;
    
    if(filtered.length === 0) {
      container.innerHTML = `<div class="col-12 text-center py-5">
        <i class="fas fa-search fa-3x text-secondary mb-3 opacity-50"></i>
        <h5 class="text-white">لم يتم العثور على كورسات</h5>
        <p class="text-secondary">حاول تغيير معايير البحث أو التصفية</p>
      </div>`;
      return;
    }
    
    let html = '';
    filtered.forEach(course => {
      const badgeHTML = course.badge ? `<span class="course-badge">${course.badge}</span>` : '';
      
      if(currentView === 'grid') {
        html += `
        <div class="col-md-6 col-lg-4">
            <div class="glass-card h-100 d-flex flex-column">
                <div class="course-img text-white text-center">
                    ${badgeHTML}
                    <i class="fas ${course.imgIcon} fa-4x opacity-50"></i>
                </div>
                <!-- ... content ... -->
                <div class="p-3 d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-white bg-opacity-10 text-accent px-2 py-1">${course.categoryName}</span>
                        <div class="text-warning en-text small"><i class="fas fa-star"></i> ${course.rating}</div>
                    </div>
                    <h5 class="fw-bold mb-3 d-flex flex-grow-1">
                        <a href="course-detail.html?id=${course.id}" class="text-white text-decoration-none text-truncate-2" style="-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;">${course.title}</a>
                    </h5>
                    <div class="d-flex align-items-center text-secondary small mb-3">
                        <i class="fas fa-user-tie ms-2 text-accent"></i> <span>${course.instructor}</span>
                        <span class="mx-2 text-white-50">|</span>
                        <i class="fas fa-users ms-2 text-accent"></i> <span class="en-text">${course.students.toLocaleString()}</span> طالب
                    </div>
                    <hr class="border-secondary mt-auto">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>
                            <span class="old-price ms-2">$${course.oldPrice}</span>
                            <span class="new-price">$${course.newPrice}</span>
                        </div>
                        <button class="btn btn-sm btn-accent rounded-circle" style="width:35px; height:35px; padding:0" onclick='addToCart(${JSON.stringify(course)})'><i class="fas fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>`;
      } else {
        html += `
        <div class="col-12">
            <div class="glass-card d-flex flex-column flex-md-row gap-3">
                <div class="course-img list-view-img text-white text-center flex-shrink-0" style="width: 280px; height: 200px">
                    ${badgeHTML}
                    <i class="fas ${course.imgIcon} fa-4x opacity-50"></i>
                </div>
                <div class="p-3 d-flex flex-column flex-grow-1 w-100">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-white bg-opacity-10 text-accent px-2 py-1">${course.categoryName}</span>
                        <div class="text-warning en-text"><i class="fas fa-star"></i> ${course.rating}</div>
                    </div>
                    <h4 class="fw-bold mb-2"><a href="course-detail.html?id=${course.id}" class="text-white text-decoration-none">${course.title}</a></h4>
                    <p class="text-secondary small d-none d-md-block">وصف مختصر للكورس يظهر في عرض القائمة فقط لجذب انتباه الطالب وتوضيح أهمية الكورس وما سيتعلمه...</p>
                    <div class="d-flex align-items-center text-secondary small mb-3">
                        <i class="fas fa-user-tie ms-2 text-accent"></i> <span>${course.instructor}</span>
                        <span class="mx-3 text-white-50">|</span>
                        <i class="fas fa-users ms-2 text-accent"></i> <span class="en-text">${course.students.toLocaleString()}</span> طالب
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary border-opacity-25">
                        <div class="d-flex align-items-baseline">
                            <span class="new-price fs-4">$${course.newPrice}</span>
                            <span class="old-price mx-2">$${course.oldPrice}</span>
                        </div>
                        <button class="btn btn-accent px-4 py-2 text-nowrap" onclick='addToCart(${JSON.stringify(course)})'><i class="fas fa-cart-plus ms-2"></i> أضف للسلة</button>
                    </div>
                </div>
            </div>
        </div>`;
      }
    });
    
    container.innerHTML = html;
  }

  // Event Listeners for filters
  searchInput.addEventListener('input', renderFilteredCourses);
  sortSelect.addEventListener('change', renderFilteredCourses);
  checkboxes.forEach(cb => cb.addEventListener('change', renderFilteredCourses));
  
  priceRange.addEventListener('input', (e) => {
    priceVal.textContent = `$${e.target.value}`;
    renderFilteredCourses();
  });
  
  resetBtn.addEventListener('click', () => {
    searchInput.value = '';
    priceRange.value = 250;
    priceVal.textContent = '$250';
    sortSelect.value = 'popular';
    checkboxes.forEach(cb => cb.checked = false);
    renderFilteredCourses();
  });
  
  // Toggle View
  viewBtns.forEach(btn => {
    btn.addEventListener('click', (e) => {
       viewBtns.forEach(b => b.classList.remove('active'));
       e.currentTarget.classList.add('active');
       currentView = e.currentTarget.getAttribute('data-view');
       renderFilteredCourses();
    });
  });

  // Initial render
  // Initial render
  setTimeout(renderFilteredCourses, 100);
}

function initCategoriesPage() {
  const catCards = document.querySelectorAll('.category-card-interactive');
  const catCoursesSection = document.getElementById('category-courses-section');
  const catNameSpan = document.getElementById('current-category-name');
  const dynamicContainer = document.getElementById('cat-dynamic-courses');
  const filterTabs = document.querySelectorAll('#cat-filter-tabs .nav-link');
  
  let currentCategory = 'programming';
  let currentLevel = 'all';

  // Make sure we have mock data
  const allCourses = [...coursesData, 
    { id: 7, title: 'احترف برمجة تطبيقات فلاتر', category: 'programming', categoryName: 'البرمجة', instructor: 'م. خالد أحمد', rating: 4.9, students: 6200, oldPrice: 210, newPrice: 55, badge: 'تحديث', imgIcon: 'fa-mobile-alt', level: 'intermediate' },
    { id: 8, title: 'أساسيات المحاسبة والمالية', category: 'business', categoryName: 'الأعمال', instructor: 'طارق زياد', rating: 4.5, students: 3100, oldPrice: 110, newPrice: 25, badge: '', imgIcon: 'fa-calculator', level: 'beginner' },
    { id: 9, title: 'دورة تحليل البيانات Python', category: 'ai', categoryName: 'البيانات', instructor: 'ليلى حسن', rating: 4.8, students: 9500, oldPrice: 160, newPrice: 39, badge: 'الأكثر طلباً', imgIcon: 'fa-chart-line', level: 'advanced' },
    { id: 10, title: 'تطوير الألعاب بـ Unity', category: 'programming', categoryName: 'البرمجة', instructor: 'عمر مصطفى', rating: 4.7, students: 4800, oldPrice: 180, newPrice: 45, badge: '', imgIcon: 'fa-gamepad', level: 'beginner' },
    { id: 11, title: 'تصميم الشعارات والهوية البصرية', category: 'design', categoryName: 'التصميم', instructor: 'سارة محمد', rating: 4.8, students: 4200, oldPrice: 130, newPrice: 30, badge: '', imgIcon: 'fa-pen-nib', level: 'intermediate' }
  ];

  catCards.forEach(card => {
    card.addEventListener('click', () => {
       // Scroll to section smoothly with fade
       currentCategory = card.getAttribute('data-cat');
       const catTitle = card.querySelector('h4').textContent;
       catNameSpan.textContent = catTitle;
       
       catCoursesSection.classList.remove('d-none');
       catCoursesSection.classList.remove('visible');
       catCoursesSection.classList.add('section-fade-up');
       
       setTimeout(() => {
           catCoursesSection.classList.add('visible');
           catCoursesSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
       }, 50);

       // Reset tab to all
       filterTabs.forEach(t => t.classList.remove('active', 'border-accent'));
       filterTabs[0].classList.add('active');
       currentLevel = 'all';

       renderCatCourses();
    });
  });

  filterTabs.forEach(tab => {
     tab.addEventListener('click', (e) => {
         filterTabs.forEach(t => t.classList.remove('active', 'border-accent'));
         e.currentTarget.classList.add('active');
         currentLevel = e.currentTarget.getAttribute('data-filter');
         
         // Add small transition
         dynamicContainer.style.opacity = '0';
         setTimeout(() => {
             renderCatCourses();
             dynamicContainer.style.opacity = '1';
         }, 300);
     });
  });

  function renderCatCourses() {
     let filtered = allCourses.filter(c => c.category === currentCategory);
     
     if(currentLevel !== 'all') {
         filtered = filtered.filter(c => (c.level || 'beginner') === currentLevel);
     }
     
     if(filtered.length === 0) {
        dynamicContainer.innerHTML = `<div class="col-12 text-center py-5">
            <h5 class="text-white">لم يتم العثور على كورسات بهذا المستوى حالياً في هذا القسم.</h5>
        </div>`;
        return;
     }

     let html = '';
     filtered.forEach(course => {
        const badgeHTML = course.badge ? `<span class="course-badge">${course.badge}</span>` : '';
        html += `
        <div class="col-md-6 col-lg-4">
            <div class="glass-card h-100 d-flex flex-column">
                <div class="course-img text-white text-center">
                    ${badgeHTML}
                    <i class="fas ${course.imgIcon} fa-4x opacity-50"></i>
                </div>
                <!-- content -->
                <div class="p-3 d-flex flex-column flex-grow-1">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-white bg-opacity-10 text-accent px-2 py-1">${course.categoryName}</span>
                        <div class="text-warning en-text small"><i class="fas fa-star"></i> ${course.rating}</div>
                    </div>
                    <h5 class="fw-bold mb-3 d-flex flex-grow-1">
                        <a href="course-detail.html?id=${course.id}" class="text-white text-decoration-none text-truncate-2" style="-webkit-line-clamp: 2; display: -webkit-box; -webkit-box-orient: vertical; overflow: hidden;">${course.title}</a>
                    </h5>
                    <div class="d-flex align-items-center text-secondary small mb-3">
                        <i class="fas fa-user-tie ms-2 text-accent"></i> <span>${course.instructor}</span>
                    </div>
                    <hr class="border-secondary mt-auto">
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <div>
                            <span class="old-price ms-2">$${course.oldPrice}</span>
                            <span class="new-price">$${course.newPrice}</span>
                        </div>
                        <button class="btn btn-sm btn-accent rounded-circle" style="width:35px; height:35px; padding:0" onclick='addToCart(${JSON.stringify(course)})'><i class="fas fa-cart-plus"></i></button>
                    </div>
                </div>
            </div>
        </div>`;
     });
     dynamicContainer.innerHTML = html;
     dynamicContainer.style.transition = 'opacity 0.3s ease';
  }
}

// ============================================
// Animations
// ============================================

// Typing Animation
function initTypingAnimation() {
  const typingElement = document.querySelector('.typing-text');
  if(!typingElement) return;
  
  const texts = JSON.parse(typingElement.getAttribute('data-text')) || [];
  let textIndex = 0;
  let charIndex = 0;
  let isDeleting = false;
  
  function type() {
    const currentText = texts[textIndex];
    if(isDeleting) {
      typingElement.textContent = currentText.substring(0, charIndex - 1);
      charIndex--;
    } else {
      typingElement.textContent = currentText.substring(0, charIndex + 1);
      charIndex++;
    }
    
    let typeSpeed = isDeleting ? 50 : 100;
    
    if(!isDeleting && charIndex === currentText.length) {
      typeSpeed = 2000; // pause at end
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      textIndex = (textIndex + 1) % texts.length;
      typeSpeed = 500; // pause before typing next
    }
    
    setTimeout(type, typeSpeed);
  }
  
  setTimeout(type, 1000);
}

// CountUp Animation using Intersection Observer
function initCounters() {
  const counters = document.querySelectorAll('.counter');
  const duration = 2000;
  
  const observerOptions = { threshold: 0.5 };
  
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        const target = entry.target;
        const finalValue = parseInt(target.getAttribute('data-target'));
        const startTime = performance.now();
        
        function updateCounter(currentTime) {
          const elapsedTime = currentTime - startTime;
          if(elapsedTime < duration) {
            const currentValue = Math.floor((elapsedTime / duration) * finalValue);
            target.innerText = currentValue >= 1000 ? (currentValue/1000).toFixed(1) + 'K+' : currentValue;
            requestAnimationFrame(updateCounter);
          } else {
            target.innerText = finalValue >= 1000 ? (finalValue/1000).toFixed(1) + 'K+' : finalValue;
          }
        }
        
        requestAnimationFrame(updateCounter);
        observer.unobserve(target); // Only animate once
      }
    });
  }, observerOptions);
  
  counters.forEach(counter => observer.observe(counter));
}

// Scroll Fade-Up animations
function initScrollAnimations() {
  const fadeElements = document.querySelectorAll('.section-fade-up');
  
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if(entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  
  fadeElements.forEach(el => observer.observe(el));
}

// ============================================
// Cart Page
// ============================================
function initCartPage() {
  const container = document.getElementById('cart-items-container');
  const emptyMsg  = document.getElementById('empty-cart-msg');
  const countSpan = document.getElementById('cart-page-count');
  const clearBtn  = document.getElementById('clear-cart-btn');
  const checkoutBtn = document.getElementById('checkout-btn');
  const sumOld    = document.getElementById('summary-old-total');
  const sumDisc   = document.getElementById('summary-discount');
  const sumTotal  = document.getElementById('summary-total');

  const cart = getCart();
  if (countSpan) countSpan.textContent = cart.length;

  if (cart.length === 0) {
    container.innerHTML = '';
    if (emptyMsg) { emptyMsg.classList.remove('d-none'); container.appendChild(emptyMsg); }
    if (clearBtn) clearBtn.style.display = 'none';
    if (checkoutBtn) checkoutBtn.classList.add('disabled');
    if (sumOld) sumOld.textContent = '$0';
    if (sumDisc) sumDisc.textContent = '-$0';
    if (sumTotal) sumTotal.textContent = '$0';
    return;
  }

  if (emptyMsg) emptyMsg.classList.add('d-none');
  if (clearBtn) clearBtn.style.display = 'inline-block';
  if (checkoutBtn) checkoutBtn.classList.remove('disabled');

  let oldTotal = 0, newTotal = 0, html = '';
  cart.forEach(item => {
    oldTotal += (item.oldPrice || item.newPrice);
    newTotal += item.newPrice;
    html += `
    <div class="glass-card p-3 d-flex flex-column flex-md-row gap-3 align-items-center">
      <div class="course-img text-white text-center flex-shrink-0 rounded-3" style="width:140px;height:95px;background:var(--glass-bg);">
        <i class="fas ${item.imgIcon || 'fa-laptop-code'} fa-3x mt-3 opacity-50"></i>
      </div>
      <div class="flex-grow-1 text-center text-md-start">
        <h6 class="fw-bold text-white mb-1">${item.title}</h6>
        <div class="text-secondary small"><i class="fas fa-user-tie text-accent me-1"></i>${item.instructor || ''}</div>
      </div>
      <div class="text-center d-flex flex-column align-items-end justify-content-between py-1">
        <span class="text-accent fw-bold fs-5 en-text">$${item.newPrice}</span>
        <button class="btn btn-sm text-danger bg-transparent border-0 p-0 mt-2 text-decoration-underline small" onclick="removeFromCart(${item.id})">
          <i class="fas fa-trash-alt me-1"></i>إزالة
        </button>
      </div>
    </div>`;
  });

  container.innerHTML = html;

  if (sumOld) sumOld.textContent = '$' + oldTotal;
  if (sumDisc) sumDisc.textContent = '-$' + (oldTotal - newTotal);
  if (sumTotal) sumTotal.textContent = '$' + newTotal;

  // Coupon
  const applyBtn   = document.getElementById('apply-coupon');
  const couponInp  = document.getElementById('coupon-input');
  const couponMsg  = document.getElementById('coupon-msg');
  if (applyBtn) {
    const fresh = applyBtn.cloneNode(true);
    applyBtn.parentNode.replaceChild(fresh, applyBtn);
    fresh.addEventListener('click', () => {
      const val = couponInp.value.trim().toUpperCase();
      if (val === 'LMS20') {
        sumTotal.textContent = '$' + (newTotal * 0.8).toFixed(2);
        couponMsg.textContent = 'تم تطبيق خصم 20%!';
        couponMsg.className = 'text-success small mb-4';
      } else if (val === '') {
        sumTotal.textContent = '$' + newTotal;
        couponMsg.className = 'd-none';
      } else {
        couponMsg.textContent = 'كود الخصم غير صالح';
        couponMsg.className = 'text-danger small mb-4';
        sumTotal.textContent = '$' + newTotal;
      }
    });
  }

  if (clearBtn) {
    const freshClear = clearBtn.cloneNode(true);
    clearBtn.parentNode.replaceChild(freshClear, clearBtn);
    freshClear.addEventListener('click', clearCart);
  }
}

// ============================================
// Checkout Page
// ============================================
function initCheckoutPage() {
  const cart = getCart();
  const itemsEl   = document.getElementById('checkout-order-items');
  const subtotalEl = document.getElementById('checkout-subtotal');
  const discEl    = document.getElementById('checkout-discount');
  const totalEl   = document.getElementById('checkout-total');
  if (!itemsEl) return;

  if (cart.length === 0) {
    itemsEl.innerHTML = '<p class="text-secondary text-center">لا توجد عناصر في السلة. <a href="courses.html" class="text-accent">تصفح الكورسات</a></p>';
    return;
  }

  let old = 0, fresh = 0, html = '';
  cart.forEach(item => {
    old += (item.oldPrice || item.newPrice);
    fresh += item.newPrice;
    html += `<div class="d-flex justify-content-between align-items-center text-secondary small border-bottom border-secondary border-opacity-25 pb-2 mb-2">
      <span class="text-white">${item.title}</span>
      <span class="en-text text-accent fw-bold">$${item.newPrice}</span>
    </div>`;
  });
  itemsEl.innerHTML = html;
  if (subtotalEl) subtotalEl.textContent = '$' + old;
  if (discEl) discEl.textContent = '-$' + (old - fresh);
  if (totalEl) totalEl.textContent = '$' + fresh;
}

// Card Live Preview Functions
function updateCardPreview() {
  const numEl    = document.getElementById('card-number-display');
  const holderEl = document.getElementById('card-holder-display');
  const expEl    = document.getElementById('card-exp-display');
  const cvvEl    = document.getElementById('card-cvv-display');
  const typeEl   = document.getElementById('card-type-icon');

  const num    = document.getElementById('card-number')?.value || '';
  const holder = document.getElementById('card-name')?.value || '';
  const exp    = document.getElementById('card-expiry')?.value || '';
  const cvv    = document.getElementById('card-cvv')?.value || '';

  if (numEl) numEl.textContent = num.padEnd(19, '•').replace(/(.{4})/g, '$1 ').trim() || '•••• •••• •••• ••••';
  if (holderEl) holderEl.textContent = holder.toUpperCase() || 'FULL NAME';
  if (expEl) expEl.textContent = exp || 'MM/YY';
  if (cvvEl) cvvEl.textContent = cvv ? '•'.repeat(cvv.length) : '•••';

  // Detect card type
  if (typeEl) {
    const first = num.replace(/\s/g,'')[0];
    if (first === '4') typeEl.innerHTML = '<i class="fab fa-cc-visa fa-2x text-white opacity-75"></i>';
    else if (first === '5') typeEl.innerHTML = '<i class="fab fa-cc-mastercard fa-2x text-white opacity-75"></i>';
    else if (first === '3') typeEl.innerHTML = '<i class="fab fa-cc-amex fa-2x text-white opacity-75"></i>';
    else typeEl.innerHTML = '<i class="fab fa-cc-visa fa-2x text-white opacity-75"></i>';
  }
}

function formatCardNumber(input) {
  let v = input.value.replace(/\D/g, '').substring(0, 16);
  input.value = v.match(/.{1,4}/g)?.join(' ') || v;
}

function formatExpiry(input) {
  let v = input.value.replace(/\D/g, '').substring(0, 4);
  if (v.length > 2) v = v.substring(0, 2) + '/' + v.substring(2);
  input.value = v;
}

function flipCard(show) {
  const preview = document.getElementById('card-preview');
  if (preview) preview.classList.toggle('flipped', show);
}

function submitOrder() {
  // Basic validation
  const firstName = document.getElementById('first-name')?.value.trim();
  const email     = document.getElementById('email')?.value.trim();
  const cardNum   = document.getElementById('card-number')?.value.replace(/\s/g,'');
  const cardName  = document.getElementById('card-name')?.value.trim();
  const expiry    = document.getElementById('card-expiry')?.value.trim();
  const cvv       = document.getElementById('card-cvv')?.value.trim();

  if (!firstName || !email || cardNum.length < 16 || !cardName || expiry.length < 5 || cvv.length < 3) {
    showToast('يرجى تعبئة جميع الحقول بشكل صحيح', 'danger');
    return;
  }

  // Simulate processing
  const btn = document.getElementById('submit-order');
  if (btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin ms-2"></i> جارٍ المعالجة...';
  }

  setTimeout(() => {
    clearCart();
    const successEl = document.getElementById('order-success');
    if (successEl) successEl.classList.remove('d-none');
    if (btn) btn.classList.add('d-none');
    showToast('تم تأكيد طلبك بنجاح!', 'success');
    const checkoutItems = document.getElementById('checkout-order-items');
    if (checkoutItems) checkoutItems.innerHTML = '<p class="text-success text-center fw-bold"><i class="fas fa-check-circle me-2"></i>تم الدفع بنجاح!</p>';
  }, 2000);
}
