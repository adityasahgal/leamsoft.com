(function () {
    var root = document.getElementById('chat');
    if (!root) return;

    var launch = document.getElementById('chat-launch');
    var panel = document.getElementById('chat-panel');
    var log = document.getElementById('chat-log');
    var form = document.getElementById('chat-form');
    var input = document.getElementById('chat-input');
    var chips = document.getElementById('chat-chips');
    var leadForm = document.getElementById('chat-lead');
    var leadErr = document.getElementById('chat-lead-err');
    var tokenMeta = document.querySelector('meta[name="csrf-token"]');
    var STORE = 'leamsoft.chat.v1';
    var busy = false;
    var transcript = [];

    var GREETING = {
        role: 'bot',
        text: 'Hi! I’m the Leamsoft assistant. Ask me about our services, pricing or timelines — or book a free 30-minute call with an engineer.',
        actions: []
    };

    // ---------- storage (per tab, best effort) ----------
    function save() {
        try { sessionStorage.setItem(STORE, JSON.stringify({ t: transcript.slice(-40), open: !panel.hidden })); } catch (e) {}
    }
    function load() {
        try { return JSON.parse(sessionStorage.getItem(STORE) || 'null'); } catch (e) { return null; }
    }

    // ---------- rendering ----------
    // Turns http(s) URLs into links; everything else stays text (no innerHTML)
    function appendRich(el, text) {
        var re = /(https?:\/\/[^\s<>"')]+)/g, last = 0, m;
        while ((m = re.exec(text))) {
            if (m.index > last) el.appendChild(document.createTextNode(text.slice(last, m.index)));
            var url = m[1].replace(/[.,;:!?]+$/, '');
            var a = document.createElement('a');
            a.href = url;
            a.textContent = url.replace(/^https?:\/\/(www\.)?/, '');
            if (url.indexOf(location.origin) !== 0) { a.target = '_blank'; a.rel = 'noopener'; }
            el.appendChild(a);
            // Trailing punctuation we trimmed off the URL stays as plain text
            last = m.index + url.length;
            re.lastIndex = last;
        }
        if (last < text.length) el.appendChild(document.createTextNode(text.slice(last)));
    }

    function bubble(msg) {
        var row = document.createElement('div');
        row.className = 'chat__msg chat__msg--' + msg.role;
        var b = document.createElement('div');
        b.className = 'chat__bubble';
        appendRich(b, msg.text);
        row.appendChild(b);

        if (msg.actions && msg.actions.length) {
            var acts = document.createElement('div');
            acts.className = 'chat__acts';
            msg.actions.forEach(function (act) {
                var a = document.createElement('a');
                a.href = act.url;
                a.textContent = act.label;
                if (act.url.indexOf(location.origin) !== 0 && /^https?:/.test(act.url)) { a.target = '_blank'; a.rel = 'noopener'; }
                acts.appendChild(a);
            });
            row.appendChild(acts);
        }
        log.appendChild(row);
        log.scrollTop = log.scrollHeight;
    }

    function add(msg) {
        transcript.push(msg);
        bubble(msg);
        save();
    }

    function typing(on) {
        var el = document.getElementById('chat-typing');
        if (on && !el) {
            el = document.createElement('div');
            el.id = 'chat-typing';
            el.className = 'chat__msg chat__msg--bot';
            el.innerHTML = '<div class="chat__bubble chat__typing" aria-label="Assistant is typing"><i></i><i></i><i></i></div>';
            log.appendChild(el);
            log.scrollTop = log.scrollHeight;
        } else if (!on && el) {
            el.remove();
        }
    }

    // ---------- open / close ----------
    function setOpen(open) {
        panel.hidden = !open;
        root.classList.toggle('is-open', open);
        launch.setAttribute('aria-expanded', open ? 'true' : 'false');
        if (open) {
            if (!transcript.length) add(GREETING);
            setTimeout(function () { input.focus(); }, 30);
        } else {
            launch.focus();
        }
        save();
    }

    launch.addEventListener('click', function () { setOpen(panel.hidden); });
    document.getElementById('chat-close').addEventListener('click', function () { setOpen(false); });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !panel.hidden) setOpen(false);
    });

    document.getElementById('chat-new').addEventListener('click', function () {
        transcript = [];
        log.innerHTML = '';
        post(root.getAttribute('data-reset'), {}).catch(function () {});
        add(GREETING);
    });

    // ---------- network ----------
    function post(url, body) {
        return fetch(url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': tokenMeta ? tokenMeta.content : ''
            },
            body: JSON.stringify(body)
        }).then(function (res) {
            return res.json().catch(function () { return {}; }).then(function (data) {
                if (!res.ok) { data.status = res.status; throw data; }
                return data;
            });
        });
    }

    function errorText(err) {
        if (err && err.status === 419) return 'Your session expired. Please refresh the page and try again.';
        if (err && err.status === 429) return 'You’re sending messages quickly — please wait a few seconds and try again.';
        if (err && err.errors) return Object.values(err.errors)[0][0];
        return 'Sorry, something went wrong on our side. You can still reach us on the contact page.';
    }

    function send(text) {
        text = (text || '').trim();
        if (!text || busy) return;
        busy = true;
        add({ role: 'user', text: text });
        input.value = '';
        grow();
        typing(true);

        post(root.getAttribute('data-endpoint'), { message: text })
            .then(function (data) {
                typing(false);
                add({ role: 'bot', text: data.reply, actions: data.actions || [] });
            })
            .catch(function (err) {
                typing(false);
                add({ role: 'bot', text: errorText(err), actions: [{ label: 'Contact us', url: '/contact-us' }] });
            })
            .then(function () { busy = false; input.focus(); });
    }

    form.addEventListener('submit', function (e) { e.preventDefault(); send(input.value); });
    input.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); send(input.value); }
    });
    function grow() {
        input.style.height = 'auto';
        input.style.height = Math.min(input.scrollHeight, 120) + 'px';
    }
    input.addEventListener('input', grow);

    chips.addEventListener('click', function (e) {
        var b = e.target.closest('[data-ask]');
        if (b) send(b.getAttribute('data-ask'));
    });

    // ---------- callback form ----------
    function showLead(show) {
        leadForm.hidden = !show;
        form.hidden = show;
        chips.hidden = show;
        leadErr.textContent = '';
        if (show) leadForm.querySelector('input').focus();
    }
    root.addEventListener('click', function (e) {
        if (e.target.closest('[data-open-lead]')) showLead(true);
        if (e.target.closest('[data-close-lead]')) showLead(false);
    });

    leadForm.addEventListener('submit', function (e) {
        e.preventDefault();
        var fd = new FormData(leadForm);
        var body = {};
        fd.forEach(function (v, k) { body[k] = v; });
        var btn = leadForm.querySelector('button[type="submit"]');
        btn.disabled = true;
        post(root.getAttribute('data-lead'), body)
            .then(function (data) {
                leadForm.reset();
                showLead(false);
                add({ role: 'bot', text: data.reply, actions: data.actions || [] });
            })
            .catch(function (err) { leadErr.textContent = errorText(err); })
            .then(function () { btn.disabled = false; });
    });

    // ---------- restore ----------
    var saved = load();
    if (saved && saved.t && saved.t.length) {
        transcript = saved.t;
        transcript.forEach(bubble);
        if (saved.open) setOpen(true);
    }
})();
