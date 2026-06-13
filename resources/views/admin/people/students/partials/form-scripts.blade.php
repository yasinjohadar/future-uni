<script>
document.addEventListener('DOMContentLoaded', function () {
    var nameInput = document.getElementById('studentName');
    var numberInput = document.getElementById('studentNumber');
    var statusSelect = document.getElementById('studentStatus');
    var programSelect = document.getElementById('studentProgram');
    var enrollmentInput = document.getElementById('studentEnrollmentDate');
    var namePreview = document.getElementById('studentNamePreview');
    var numberPreview = document.getElementById('studentNumberPreview');
    var statusPreview = document.getElementById('studentStatusPreview');
    var initialPreview = document.getElementById('studentInitialPreview');
    var programPreview = document.getElementById('studentProgramPreview');
    var enrollmentPreview = document.getElementById('studentEnrollmentPreview');

    function syncName() {
        var name = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'اسم الطالب';
        if (namePreview) namePreview.textContent = name;
        if (initialPreview) initialPreview.textContent = name.charAt(0).toUpperCase();
    }

    function syncNumber() {
        if (!numberPreview) return;
        numberPreview.textContent = numberInput && numberInput.value.trim() ? numberInput.value.trim() : '—';
    }

    function syncStatus() {
        if (!statusSelect || !statusPreview) return;
        var option = statusSelect.options[statusSelect.selectedIndex];
        statusPreview.textContent = option ? option.textContent.trim() : '';
    }

    function syncProgram() {
        if (!programSelect || !programPreview) return;
        var option = programSelect.options[programSelect.selectedIndex];
        programPreview.textContent = option && option.value ? option.textContent.trim() : 'بدون برنامج';
    }

    function syncEnrollment() {
        if (!enrollmentPreview || !enrollmentInput) return;
        enrollmentPreview.textContent = enrollmentInput.value || '—';
    }

    if (nameInput) nameInput.addEventListener('input', syncName);
    if (numberInput) numberInput.addEventListener('input', syncNumber);
    if (statusSelect) statusSelect.addEventListener('change', syncStatus);
    if (programSelect) programSelect.addEventListener('change', syncProgram);
    if (enrollmentInput) enrollmentInput.addEventListener('change', syncEnrollment);

    syncName();
    syncNumber();
    syncStatus();
    syncProgram();
    syncEnrollment();
});
</script>
