<script>
document.addEventListener('DOMContentLoaded', function () {
    var iconInput = document.getElementById('collegeIcon');
    var iconPreview = document.getElementById('collegeIconPreview');
    var iconHero = document.getElementById('collegeIconHero');
    var nameInput = document.getElementById('collegeName');
    var namePreview = document.getElementById('collegeNamePreview');

    function normalizeIconClass(icon) {
        icon = (icon || '').trim() || 'ri-building-line';
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
        var name = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'اسم الكلية';
        namePreview.textContent = name;
    }

    if (iconInput) iconInput.addEventListener('input', syncIcon);
    if (nameInput) nameInput.addEventListener('input', syncName);
    syncIcon();
    syncName();
});
</script>
