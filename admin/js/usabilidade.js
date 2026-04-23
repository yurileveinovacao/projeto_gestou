(function () {
    'use strict';

    var STORAGE_PREFIX_TAB = 'tab:';

    function safeGet(key) {
        try { return sessionStorage.getItem(key); } catch (e) { return null; }
    }

    function safeSet(key, value) {
        try { sessionStorage.setItem(key, value); } catch (e) { /* quota/privacy */ }
    }

    function showTab($, href) {
        var $trigger = $('a[data-toggle="tab"][href="' + href + '"]');
        var $pane = $(href);
        if (!$trigger.length || !$pane.length) return;

        var $nav = $trigger.closest('.nav-tabs, .nav');
        var $content = $pane.closest('.tab-content');

        $nav.find('a[data-toggle="tab"]').removeClass('active').attr('aria-selected', 'false');
        $nav.find('li').removeClass('active');
        $content.find('.tab-pane').removeClass('active show');

        $trigger.addClass('active').attr('aria-selected', 'true');
        $trigger.closest('li').addClass('active');
        $pane.addClass('active show');
    }

    function restoreActiveTab() {
        if (typeof jQuery === 'undefined' || !jQuery.fn) return;
        var $ = jQuery;
        var key = STORAGE_PREFIX_TAB + location.pathname;

        var saved = safeGet(key);
        if (saved) {
            showTab($, saved);
        }

        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function () {
            var href = $(this).attr('href');
            if (href) safeSet(key, href);
        });

        $(document).on('click', 'a[data-toggle="tab"]', function () {
            var href = $(this).attr('href');
            if (href) safeSet(key, href);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', restoreActiveTab);
    } else {
        restoreActiveTab();
    }
})();
