@extends('frontend.layouts.master')

@section('title', $post->title . ' | جامعة المستقبل')
@section('body_class', 'blog-detail-page')
@section('active_nav', 'news')

@section('content')
    <div class="reading-progress">
        <div class="reading-progress-bar" id="readingProgressBar"></div>
    </div>

    @include('frontend.pages.partials.blog-detail.hero')
    @include('frontend.pages.partials.blog-detail.highlights')
    @include('frontend.pages.partials.blog-detail.article')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const progressBar = document.getElementById('readingProgressBar');
    if (progressBar) {
        window.addEventListener('scroll', () => {
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = docHeight > 0 ? (window.scrollY / docHeight) * 100 : 0;
            progressBar.style.width = progress + '%';
        });
    }

    const content = document.querySelector('.blog-detail-content');
    const tocNav = document.getElementById('blogDetailToc');
    if (content && tocNav) {
        const headings = content.querySelectorAll('h2');
        if (headings.length) {
            headings.forEach((heading, index) => {
                if (!heading.id) {
                    heading.id = 'section' + (index + 1);
                }
                const link = document.createElement('a');
                link.href = '#' + heading.id;
                link.className = 'blog-detail-toc__item' + (index === 0 ? ' active' : '');
                link.textContent = heading.textContent;
                tocNav.appendChild(link);
            });

            const tocItems = tocNav.querySelectorAll('.blog-detail-toc__item');
            window.addEventListener('scroll', () => {
                let current = '';
                headings.forEach(heading => {
                    if (window.scrollY >= heading.offsetTop - 150) {
                        current = heading.id;
                    }
                });
                tocItems.forEach(item => {
                    item.classList.toggle('active', item.getAttribute('href') === '#' + current);
                });
            });
        } else {
            tocNav.closest('.blog-detail-panel')?.remove();
        }
    }

    const commentForm = document.getElementById('comment-form');
    if (commentForm) {
        commentForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const btn = commentForm.querySelector('button[type="submit"]');
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin ms-2"></i> جارٍ الإرسال...';
            setTimeout(() => {
                if (typeof showToast === 'function') {
                    showToast('تم إرسال تعليقك بنجاح!', 'success');
                }
                commentForm.reset();
                btn.disabled = false;
                btn.innerHTML = 'إرسال التعليق <i class="fas fa-paper-plane ms-2"></i>';
            }, 1500);
        });
    }
});

function copyBlogLink(e) {
    e.preventDefault();
    navigator.clipboard.writeText(window.location.href).then(() => {
        if (typeof showToast === 'function') {
            showToast('تم نسخ الرابط!', 'success');
        }
    });
}
</script>
@endpush
