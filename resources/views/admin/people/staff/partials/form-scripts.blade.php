<script>
document.addEventListener('DOMContentLoaded', function () {
    var iconInput = document.getElementById('staffIcon');
    var iconPreview = document.getElementById('staffIconPreview');
    var iconHero = document.getElementById('staffIconHero');
    var nameInput = document.getElementById('staffName');
    var namePreview = document.getElementById('staffNamePreview');
    var typeSelect = document.getElementById('staffType');
    var typePreview = document.getElementById('staffTypePreview');
    var positionInput = document.getElementById('staffPosition');
    var positionPreview = document.getElementById('staffPositionPreview');

    function normalizeIconClass(icon) {
        icon = (icon || '').trim() || 'ri-user-line';
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
        namePreview.textContent = nameInput && nameInput.value.trim() ? nameInput.value.trim() : 'اسم العضو';
    }

    function syncType() {
        if (!typeSelect || !typePreview) return;
        var option = typeSelect.options[typeSelect.selectedIndex];
        typePreview.textContent = option ? option.textContent.trim() : '';
    }

    function syncPosition() {
        if (!positionPreview) return;
        positionPreview.textContent = positionInput && positionInput.value.trim() ? positionInput.value.trim() : '—';
    }

    if (iconInput) iconInput.addEventListener('input', syncIcon);
    if (nameInput) nameInput.addEventListener('input', syncName);
    if (typeSelect) typeSelect.addEventListener('change', syncType);
    if (positionInput) positionInput.addEventListener('input', syncPosition);
    syncIcon();
    syncName();
    syncType();
    syncPosition();
});
</script>
