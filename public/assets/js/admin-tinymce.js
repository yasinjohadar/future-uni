/**
 * Shared TinyMCE initializer for admin forms (colleges, departments, etc.).
 */
(function (window) {
    'use strict';

    var defaultConfig = {
        height: 560,
        directionality: 'rtl',
        language: 'ar',
        language_url: 'https://cdn.jsdelivr.net/npm/tinymce-i18n@latest/langs6/ar.js',
        promotion: false,
        branding: false,
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code codesample fullscreen insertdatetime media table help wordcount emoticons directionality',
        toolbar: 'undo redo | blocks | bold italic underline | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist | link image media table | codesample code | fullscreen | help',
        menubar: 'file edit view insert format tools table help',
        content_style: 'body { font-family: "Segoe UI", Tahoma, Arial, sans-serif; font-size: 14px; direction: rtl; }',
        relative_urls: false,
        remove_script_host: false,
        image_advtab: true,
        paste_data_images: true,
        codesample_global_prismjs: true,
        codesample_languages: [
            { text: 'HTML/XML', value: 'markup' },
            { text: 'JavaScript', value: 'javascript' },
            { text: 'CSS', value: 'css' },
            { text: 'PHP', value: 'php' },
            { text: 'Python', value: 'python' },
            { text: 'SQL', value: 'sql' },
            { text: 'JSON', value: 'json' }
        ]
    };

    function initEditor(selector, height) {
        if (typeof tinymce === 'undefined') {
            return false;
        }

        var el = document.querySelector(selector);
        if (!el || el.dataset.tinymceInit) {
            return true;
        }

        el.dataset.tinymceInit = '1';

        var config = Object.assign({}, defaultConfig, {
            selector: selector,
            height: height || defaultConfig.height
        });

        tinymce.init(config).catch(function (err) {
            console.error('TinyMCE init error for ' + selector + ':', err);
        });

        return true;
    }

    function bindFormSave(form) {
        if (!form || form.dataset.tinymceSaveBound) {
            return;
        }

        form.dataset.tinymceSaveBound = '1';
        form.addEventListener('submit', function () {
            if (typeof tinymce !== 'undefined') {
                tinymce.triggerSave();
            }
        });
    }

    window.AdminTinyMCE = {
        init: function (options) {
            options = options || {};
            var selectors = options.selectors || ['#description'];
            var heights = options.heights || {};
            var delay = options.delay || 200;

            function run() {
                if (typeof tinymce === 'undefined') {
                    setTimeout(run, 100);
                    return;
                }

                selectors.forEach(function (selector) {
                    initEditor(selector, heights[selector]);
                });

                if (options.form) {
                    var form = typeof options.form === 'string'
                        ? document.querySelector(options.form)
                        : options.form;
                    bindFormSave(form);
                }
            }

            setTimeout(run, delay);
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-tinymce-form]').forEach(function (form) {
            var selectors = [];

            try {
                selectors = JSON.parse(form.dataset.tinymceSelectors || '[]');
            } catch (e) {
                selectors = [];
            }

            if (!selectors.length) {
                form.querySelectorAll('textarea[data-tinymce]').forEach(function (textarea) {
                    if (textarea.id) {
                        selectors.push('#' + textarea.id);
                    }
                });
            }

            if (selectors.length) {
                window.AdminTinyMCE.init({ selectors: selectors, form: form });
            }
        });
    });
})(window);
