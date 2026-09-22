/**
 * script.js — shared behaviour for the portfolio
 *  1. Theme toggle (dark/light) stored in localStorage
 *  2. Mobile hamburger menu
 *  3. IntersectionObserver scroll-reveal animations
 *  4. Confirmation dialog for admin "delete message" buttons
 *
 * All DOM lookups are defensive: elements that are missing (e.g. on admin
 * pages without a navbar) are simply skipped.
 */
(function () {
    'use strict';

    /* ══════════════════ 1. THEME TOGGLE ══════════════════ */
    var docEl = document.documentElement;
    var themeToggle = document.getElementById('themeToggle');

    function applyTheme(theme) {
        docEl.setAttribute('data-theme', theme);
        try { localStorage.setItem('ak-theme', theme); } catch (e) { /* private mode */ }
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            var current = docEl.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            applyTheme(current === 'dark' ? 'light' : 'dark');
        });
    }

    /* ══════════════════ 2. MOBILE MENU ══════════════════ */
    var navToggle = document.getElementById('navToggle');
    var navMenu   = document.getElementById('navMenu');

    if (navToggle && navMenu) {
        navToggle.addEventListener('click', function () {
            var isOpen = navMenu.classList.toggle('is-open');
            navToggle.classList.toggle('is-open', isOpen);
            navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        // Close the menu after tapping a link (mobile UX)
        navMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                navMenu.classList.remove('is-open');
                navToggle.classList.remove('is-open');
                navToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    /* ══════════════════ 3. SCROLL REVEAL ══════════════════ */
    var revealEls = document.querySelectorAll('.reveal');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if (revealEls.length) {
        if (reduceMotion || !('IntersectionObserver' in window)) {
            // No animation: show everything immediately
            revealEls.forEach(function (el) { el.classList.add('is-visible'); });
        } else {
            var io = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        io.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.12 });

            revealEls.forEach(function (el) { io.observe(el); });
        }
    }

    /* ══════════════════ 4. DELETE CONFIRMATION ══════════════════ */
    document.querySelectorAll('.js-confirm-delete').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            if (!window.confirm('Delete this message? This cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
})();
