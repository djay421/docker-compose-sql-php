/* js/starfield.js — Cosmos Starfield + Shooting Stars */

(function () {
  const canvas = document.createElement('canvas');
  canvas.id = 'star-canvas';
  document.body.prepend(canvas);

  const ctx = canvas.getContext('2d');
  let W, H, stars = [], shooters = [];

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }

  function randBetween(a, b) { return a + Math.random() * (b - a); }

  function initStars() {
    stars = [];
    const count = Math.floor((W * H) / 4500);
    for (let i = 0; i < count; i++) {
      stars.push({
        x: Math.random() * W,
        y: Math.random() * H,
        r: randBetween(0.2, 1.4),
        base: randBetween(0.2, 0.9),
        speed: randBetween(0.003, 0.012),
        phase: Math.random() * Math.PI * 2,
        hue: Math.random() < 0.15 ? 'violet' : Math.random() < 0.1 ? 'rose' : 'white',
      });
    }
  }

  function spawnShooter() {
    const startX = randBetween(W * 0.1, W * 0.9);
    const startY = randBetween(0, H * 0.4);
    const angle  = randBetween(25, 55) * Math.PI / 180;
    shooters.push({
      x: startX, y: startY,
      dx: Math.cos(angle) * 8,
      dy: Math.sin(angle) * 8,
      len: randBetween(80, 160),
      life: 1,
      decay: randBetween(0.015, 0.03),
    });
  }

  function starColor(s, alpha) {
    if (s.hue === 'violet') return `rgba(179,157,219,${alpha})`;
    if (s.hue === 'rose')   return `rgba(240,98,146,${alpha})`;
    return `rgba(200,216,240,${alpha})`;
  }

  function draw(ts) {
    ctx.clearRect(0, 0, W, H);

    // Stars
    stars.forEach(s => {
      const twinkle = s.base + Math.sin(ts * s.speed + s.phase) * 0.3;
      const alpha = Math.max(0, Math.min(1, twinkle));
      ctx.beginPath();
      ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
      ctx.fillStyle = starColor(s, alpha);
      if (s.r > 0.9) {
        ctx.shadowBlur = 4;
        ctx.shadowColor = starColor(s, 0.5);
      } else {
        ctx.shadowBlur = 0;
      }
      ctx.fill();
    });
    ctx.shadowBlur = 0;

    // Shooting stars
    shooters = shooters.filter(sh => sh.life > 0);
    shooters.forEach(sh => {
      const tailX = sh.x - sh.dx * (sh.len / 8);
      const tailY = sh.y - sh.dy * (sh.len / 8);
      const grad = ctx.createLinearGradient(tailX, tailY, sh.x, sh.y);
      grad.addColorStop(0, `rgba(125,232,245,0)`);
      grad.addColorStop(0.6, `rgba(125,232,245,${sh.life * 0.4})`);
      grad.addColorStop(1, `rgba(255,255,255,${sh.life})`);
      ctx.beginPath();
      ctx.moveTo(tailX, tailY);
      ctx.lineTo(sh.x, sh.y);
      ctx.strokeStyle = grad;
      ctx.lineWidth = 1.2;
      ctx.stroke();

      sh.x += sh.dx;
      sh.y += sh.dy;
      sh.life -= sh.decay;
    });

    requestAnimationFrame(draw);
  }

  // Spawn shooters periodically
  function scheduleShooter() {
    spawnShooter();
    setTimeout(scheduleShooter, randBetween(3500, 9000));
  }

  resize();
  initStars();
  scheduleShooter();
  requestAnimationFrame(draw);
  window.addEventListener('resize', () => { resize(); initStars(); });
})();
