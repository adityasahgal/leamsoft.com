(function () {
    var header = document.getElementById('header');
    var burger = document.getElementById('burger');
    var drawer = document.getElementById('drawer');

    // Hairline under the sticky header once the page scrolls
    if (header) {
        var onScroll = function () { header.classList.toggle('scrolled', window.scrollY > 4); };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    // Mobile drawer
    if (burger && drawer) {
        var setDrawer = function (open) {
            drawer.classList.toggle('open', open);
            burger.setAttribute('aria-expanded', open ? 'true' : 'false');
            burger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
            burger.querySelector('use').setAttribute('href', open ? '#i-x' : '#i-menu');
            document.body.style.overflow = open ? 'hidden' : '';
        };
        burger.addEventListener('click', function () { setDrawer(!drawer.classList.contains('open')); });
        drawer.querySelectorAll('a').forEach(function (a) {
            a.addEventListener('click', function () { setDrawer(false); });
        });
        window.addEventListener('resize', function () { if (window.innerWidth > 1080) setDrawer(false); });
    }

    // Services mega menu: hover opens it via CSS, click/keyboard toggles it here
    document.querySelectorAll('.has-mega').forEach(function (li) {
        var btn = li.querySelector('button');
        if (!btn) return;
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            var open = !li.classList.contains('open');
            li.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        document.addEventListener('click', function (e) {
            if (!li.contains(e.target)) {
                li.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                li.classList.remove('open');
                btn.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // Reveal-on-scroll
    var items = document.querySelectorAll('.rv');
    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    en.target.classList.add('in');
                    io.unobserve(en.target);
                }
            });
        }, { rootMargin: '0px 0px -8% 0px', threshold: 0.05 });
        items.forEach(function (el) { io.observe(el); });
    } else {
        items.forEach(function (el) { el.classList.add('in'); });
    }

    // Password fields: show/hide toggle
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
        var input = document.getElementById(btn.getAttribute('data-toggle-password'));
        if (!input) return;
        btn.addEventListener('click', function () {
            var show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            btn.setAttribute('aria-pressed', show ? 'true' : 'false');
            btn.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            btn.querySelector('use').setAttribute('href', show ? '#i-eye-off' : '#i-eye');
            input.focus();
        });
    });

    // Caps Lock hint on password fields
    document.querySelectorAll('[data-caps-for]').forEach(function (hint) {
        var input = document.getElementById(hint.getAttribute('data-caps-for'));
        if (!input) return;
        var check = function (e) {
            if (e.getModifierState) hint.classList.toggle('on', e.getModifierState('CapsLock'));
        };
        input.addEventListener('keydown', check);
        input.addEventListener('keyup', check);
        input.addEventListener('blur', function () { hint.classList.remove('on'); });
    });

    // Forms that should show progress and block double submits
    document.querySelectorAll('[data-loading-form]').forEach(function (form) {
        form.addEventListener('submit', function () {
            var btn = form.querySelector('button[type="submit"]');
            if (!btn) return;
            btn.classList.add('is-loading');
            btn.setAttribute('aria-busy', 'true');
            var arrow = btn.querySelector('use');
            if (arrow) arrow.setAttribute('href', '#i-ai');
        });
    });

    window.addEventListener('pageshow', function (e) {
        if (!e.persisted) return;
        document.querySelectorAll('.btn.is-loading').forEach(function (b) {
            b.classList.remove('is-loading');
            b.removeAttribute('aria-busy');
            var u = b.querySelector('use');
            if (u) u.setAttribute('href', '#i-arrow');
        });
    });

    // Bring the visitor back to the form after a submit round-trip
    var flagged = document.querySelector('[data-scroll-here]');
    if (flagged) {
        setTimeout(function () { flagged.scrollIntoView({ block: 'start' }); }, 60);
    }
})();
