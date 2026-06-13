<script>
document.addEventListener('DOMContentLoaded', function () {
    var nameInput = document.getElementById('programName');
    var namePreview = document.getElementById('programNamePreview');
    var levelSelect = document.getElementById('programLevel');
    var levelPreview = document.getElementById('programLevelPreview');
    var collegeSelect = document.getElementById('programCollege');
    var collegePreview = document.getElementById('programCollegePreview');
    var departmentSelect = document.getElementById('programDepartment');
    var departmentPreview = document.getElementById('programDepartmentPreview');
    var durationInput = document.getElementById('programDuration');
    var durationPreview = document.getElementById('programDurationPreview');
    var creditsInput = document.getElementById('programCredits');
    var creditsPreview = document.getElementById('programCreditsPreview');
    var iconHero = document.getElementById('programIconHero');

    var levelIcons = {
        bachelor: 'ri-graduation-cap-line',
        master: 'ri-book-mark-line',
        phd: 'ri-award-line'
    };

    function syncName() {
        if (!namePreview) return;
        namePreview.textContent = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'اسم البرنامج';
    }

    function syncLevel() {
        if (!levelSelect) return;
        var option = levelSelect.options[levelSelect.selectedIndex];
        if (levelPreview && option) {
            levelPreview.textContent = option.textContent.trim();
        }
        if (iconHero && option) {
            var icon = levelIcons[option.value] || 'ri-graduation-cap-line';
            iconHero.innerHTML = '<i class="' + icon + '"></i>';
        }
    }

    function syncCollege() {
        if (!collegePreview || !collegeSelect) return;
        var option = collegeSelect.options[collegeSelect.selectedIndex];
        collegePreview.textContent = option && option.value ? option.textContent.trim() : 'اختر الكلية';
    }

    function syncDepartment() {
        if (!departmentPreview || !departmentSelect) return;
        var option = departmentSelect.options[departmentSelect.selectedIndex];
        departmentPreview.textContent = option && option.value ? option.textContent.trim() : 'بدون قسم';
    }

    function syncDuration() {
        if (!durationPreview || !durationInput) return;
        durationPreview.textContent = durationInput.value.trim() || '—';
    }

    function syncCredits() {
        if (!creditsPreview || !creditsInput) return;
        var value = creditsInput.value.trim();
        creditsPreview.textContent = value ? Number(value).toLocaleString('ar') : '—';
    }

    if (nameInput) nameInput.addEventListener('input', syncName);
    if (levelSelect) levelSelect.addEventListener('change', syncLevel);
    if (collegeSelect) collegeSelect.addEventListener('change', syncCollege);
    if (departmentSelect) departmentSelect.addEventListener('change', syncDepartment);
    if (durationInput) durationInput.addEventListener('input', syncDuration);
    if (creditsInput) creditsInput.addEventListener('input', syncCredits);

    syncName();
    syncLevel();
    syncCollege();
    syncDepartment();
    syncDuration();
    syncCredits();
});
</script>
