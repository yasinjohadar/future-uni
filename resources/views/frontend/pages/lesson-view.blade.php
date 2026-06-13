@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - مشاهدة الدرس')
@section('body_class', 'lesson-view-page')

@section('content')
    @include('frontend.pages.partials.lesson-view.content')
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush

@push('scripts')
<script>
// Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const lessonSidebar = document.querySelector('.lesson-sidebar');

        sidebarToggle.addEventListener('click', () => {
            lessonSidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('show');
        });

        sidebarOverlay.addEventListener('click', () => {
            lessonSidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
        });

        // Video player controls interaction
        const videoPlayerBox = document.querySelector('.video-player-box');
        const videoControls = document.querySelector('.video-controls');
        let controlsTimeout;

        videoPlayerBox.addEventListener('mousemove', () => {
            videoControls.classList.add('visible');
            clearTimeout(controlsTimeout);
            controlsTimeout = setTimeout(() => {
                videoControls.classList.remove('visible');
            }, 3000);
        });

        videoPlayerBox.addEventListener('mouseleave', () => {
            videoControls.classList.remove('visible');
        });

        // Play button toggle
        const playBtn = document.querySelector('.play-btn');
        playBtn.addEventListener('click', () => {
            const icon = playBtn.querySelector('i');
            icon.classList.toggle('fa-play');
            icon.classList.toggle('fa-pause');
        });
</script>
@endpush
