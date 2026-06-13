<script>
document.addEventListener('DOMContentLoaded', function () {
    var iconInput = document.getElementById('departmentIcon');
    var iconPreview = document.getElementById('departmentIconPreview');
    var iconHero = document.getElementById('departmentIconHero');
    var nameInput = document.getElementById('departmentName');
    var namePreview = document.getElementById('departmentNamePreview');
    var collegeSelect = document.getElementById('departmentCollege');
    var collegePreview = document.getElementById('departmentCollegePreview');

    function normalizeIconClass(icon) {
        icon = (icon || '').trim() || 'ri-node-tree';
        if (icon.indexOf(' ') === -1 && icon.indexOf('fa-') === 0) {
            return 'fas ' + icon;
        }
        return icon;
    }

    function syncIcon() {
        if (!iconInput) return;
        var iconClass = normalizeIconClass(iconInput.value);
        var html = '<i class="' + iconClass + '"></i>';
        if (iconPreview) iconPreview.innerHTML = html;
        if (iconHero) iconHero.innerHTML = html;
    }

    function syncName() {
        if (!namePreview) return;
        namePreview.textContent = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'اسم القسم';
    }

    function syncCollege() {
        if (!collegePreview || !collegeSelect) return;
        var option = collegeSelect.options[collegeSelect.selectedIndex];
        collegePreview.textContent = option && option.value ? option.textContent.trim() : 'اختر الكلية';
    }

    if (iconInput) iconInput.addEventListener('input', syncIcon);
    if (nameInput) nameInput.addEventListener('input', syncName);
    if (collegeSelect) collegeSelect.addEventListener('change', syncCollege);
    syncIcon();
    syncName();
    syncCollege();
});
</script>
