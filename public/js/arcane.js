/* ── Particle Canvas Background ─────────────────────────────────────────── */
(function() {
  const canvas = document.getElementById('particle-canvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');

  function resize() {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  const COUNT = 80;
  const particles = Array.from({ length: COUNT }, () => ({
    x: Math.random() * canvas.width,
    y: Math.random() * canvas.height,
    vx: (Math.random() - 0.5) * 0.3,
    vy: (Math.random() - 0.5) * 0.3,
    radius: Math.random() * 1.5 + 0.3,
    alpha: Math.random() * 0.5 + 0.1,
    color: Math.random() > 0.6 ? '#c9a84c' : Math.random() > 0.5 ? '#7c3aed' : '#ffffff',
  }));

  let mouseX = canvas.width / 2;
  let mouseY = canvas.height / 2;
  window.addEventListener('mousemove', e => { mouseX = e.clientX; mouseY = e.clientY; });

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach(p => {
      const dx = mouseX - p.x;
      const dy = mouseY - p.y;
      const dist = Math.sqrt(dx * dx + dy * dy);
      const repelDist = 120;
      if (dist < repelDist) {
        p.vx -= (dx / dist) * 0.04;
        p.vy -= (dy / dist) * 0.04;
      }
      p.vx *= 0.98;
      p.vy *= 0.98;
      p.x += p.vx;
      p.y += p.vy;
      if (p.x < 0) p.x = canvas.width;
      if (p.x > canvas.width)  p.x = 0;
      if (p.y < 0) p.y = canvas.height;
      if (p.y > canvas.height) p.y = 0;

      ctx.beginPath();
      ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
      ctx.fillStyle = p.color;
      ctx.globalAlpha = p.alpha;
      ctx.fill();
    });
    ctx.globalAlpha = 1;
    requestAnimationFrame(draw);
  }
  draw();
})();

/* ── Navbar Scroll Effect ───────────────────────────────────────────────── */
(function() {
  const navbar = document.getElementById('navbar');
  if (!navbar) return;
  window.addEventListener('scroll', () => {
    navbar.classList.toggle('scrolled', window.scrollY > 20);
  });
})();

/* ── Mobile Menu ────────────────────────────────────────────────────────── */
(function() {
  const toggle = document.getElementById('mobile-toggle');
  const menu   = document.getElementById('mobile-menu');
  if (!toggle || !menu) return;
  toggle.addEventListener('click', () => menu.classList.toggle('open'));
})();

/* ── Magic Cursor ───────────────────────────────────────────────────────── */
(function() {
  const cursor = document.getElementById('magic-cursor');
  if (!cursor) return;
  if (window.innerWidth < 768) { cursor.style.display = 'none'; return; }
  window.addEventListener('mousemove', e => {
    cursor.style.transform = `translate(${e.clientX - 16}px, ${e.clientY - 16}px)`;
  });
})();

/* ── Scroll Fade-In ─────────────────────────────────────────────────────── */
(function() {
  const els = document.querySelectorAll('[data-fadein]');
  if (!els.length) return;
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const delay = entry.target.dataset.delay || 0;
        setTimeout(() => entry.target.classList.add('fade-in-up'), delay);
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1 });
  els.forEach(el => { el.style.opacity = '0'; observer.observe(el); });
})();

/* ── Cart Badge Update ──────────────────────────────────────────────────── */
(function() {
  // Refresh cart badge count from a meta tag (set by PHP layout)
  const badge = document.getElementById('cart-badge');
  const count = document.querySelector('meta[name="cart-count"]');
  if (badge && count) {
    const n = parseInt(count.content || '0');
    badge.textContent = n;
    badge.style.display = n > 0 ? 'flex' : 'none';
  }
})();

/* ── Shop Category Filter (AJAX-free, form submit) ──────────────────────── */
(function() {
  const catBtns = document.querySelectorAll('.sidebar-btn[data-category]');
  catBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const cat = btn.dataset.category;
      const url = new URL(window.location.href);
      if (cat) { url.searchParams.set('category', cat); }
      else { url.searchParams.delete('category'); }
      window.location.href = url.toString();
    });
  });
})();

/* ── Library Tab Filter ─────────────────────────────────────────────────── */
(function() {
  const tabs  = document.querySelectorAll('.library-tab[data-tab]');
  const cards = document.querySelectorAll('[data-category-filter]');
  if (!tabs.length) return;

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      const active = tab.dataset.tab;
      cards.forEach(card => {
        const show = active === 'All' || card.dataset.categoryFilter === active;
        card.style.display = show ? '' : 'none';
      });
    });
  });
})();

/* ── Cart Quantity Controls ─────────────────────────────────────────────── */
(function() {
  document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const form = this.closest('form');
      const input = form.querySelector('input[name="quantity"]');
      let val = parseInt(input.value) || 1;
      if (this.dataset.action === 'inc') val++;
      else if (this.dataset.action === 'dec' && val > 1) val--;
      input.value = val;
      form.submit();
    });
  });
})();
