<script>
(function () {
    var theme = localStorage.getItem('uni_theme') || 'dark';
    document.documentElement.setAttribute('data-theme', theme);
})();
</script>
<style>
    html[data-theme="dark"] { background-color: #0f172a; }
    html[data-theme="light"] { background-color: #f8fafc; }
</style>
