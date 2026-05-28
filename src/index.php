<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RevZone — Premium Scooter Parts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Barlow:wght@300;400;500;600&family=Oswald:wght@300;400;500;600;700&display=swap">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,700&family=Barlow:wght@300;400;500;600&family=Oswald:wght@300;400;500;600;700&display=swap');

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --carbon:      #0a0a0c;
            --carbon-mid:  #111115;
            --carbon-light:#17171e;
            --carbon-panel:#1c1c24;
            --chrome:      #c8cdd8;
            --chrome-dim:  #6e7480;
            --chrome-faint:#2e3040;
            --red:         #e8001a;
            --red-dim:     rgba(232,0,26,0.15);
            --red-border:  rgba(232,0,26,0.35);
            --red-glow:    rgba(232,0,26,0.08);
            --text:        #d4d8e2;
            --text-bright: #f0f2f8;
            --text-muted:  #44475a;
            --ff-display: 'Oswald', sans-serif;
            --ff-condensed:'Barlow Condensed', sans-serif;
            --ff-body:    'Barlow', sans-serif;
            --ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--ff-body);
            background: var(--carbon);
            color: var(--text);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background-image:
                repeating-linear-gradient(45deg, transparent, transparent 2px, rgba(255,255,255,0.012) 2px, rgba(255,255,255,0.012) 4px),
                repeating-linear-gradient(-45deg, transparent, transparent 2px, rgba(255,255,255,0.008) 2px, rgba(255,255,255,0.008) 4px);
            background-size: 8px 8px;
        }

        body::after {
            content: '';
            position: fixed;
            top: 0; left: 0; right: 0;
            height: 3px;
            background: var(--red);
            z-index: 999;
        }

        .topbar {
            position: sticky;
            top: 3px;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 2.5rem;
            height: 64px;
            background: rgba(10,10,12,0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--chrome-faint);
        }

        .topbar__brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            text-decoration: none;
        }

        .topbar__logo-mark {
            width: 38px; height: 38px;
            background: var(--red);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .topbar__logo-mark svg { width: 20px; height: 20px; }

        .topbar__brand-text {
            font-family: var(--ff-display);
            font-size: 1.35rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            color: var(--text-bright);
            text-transform: uppercase;
        }

        .topbar__brand-text em {
            font-style: normal;
            color: var(--red);
        }

        .topbar__nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .topbar__user {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            border-left: 1px solid var(--chrome-faint);
            padding-left: 2rem;
        }

        .topbar__user-dot {
            width: 8px; height: 8px;
            border-radius: 50%;
            background: var(--red);
            box-shadow: 0 0 10px var(--red);
            animation: dot-pulse 2s ease-in-out infinite;
        }

        @keyframes dot-pulse {
            0%,100% { opacity: 1; }
            50% { opacity: 0.4; }
        }

        .topbar__user-name {
            font-family: var(--ff-condensed);
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--chrome-dim);
        }

        .topbar__signout {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.85rem;
            border: 1px solid var(--chrome-faint);
            border-radius: 2px;
            color: var(--chrome-dim);
            font-family: var(--ff-condensed);
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            text-decoration: none;
            transition: all 0.2s;
        }

        .topbar__signout:hover {
            border-color: var(--red-border);
            color: var(--red);
            background: var(--red-glow);
        }

        .page-wrap {
            position: relative;
            z-index: 2;
        }

        .main {
            max-width: 1500px;
            margin: 0 auto;
            padding: 3rem 2.5rem 5rem;
        }

        .page-hero {
            margin-bottom: 3rem;
            padding-bottom: 2.5rem;
            border-bottom: 1px solid var(--chrome-faint);
        }

        .page-hero__label {
            font-family: var(--ff-condensed);
            font-size: 0.72rem;
            font-weight: 600;
            letter-spacing: 0.4em;
            text-transform: uppercase;
            color: var(--red);
            margin-bottom: 0.6rem;
        }

        .page-hero__title {
            font-family: var(--ff-display);
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--text-bright);
            line-height: 0.95;
            margin-bottom: 1rem;
        }

        .page-hero__sub {
            font-size: 0.9rem;
            color: var(--chrome-dim);
            font-weight: 300;
        }

        .stats-bar {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1px;
            background: var(--chrome-faint);
            border: 1px solid var(--chrome-faint);
            margin-bottom: 3rem;
            position: relative;
            overflow: hidden;
        }

        .stat {
            background: var(--carbon-panel);
            padding: 1.5rem 1.75rem;
            position: relative;
        }

        .stat:hover { background: var(--carbon-light); }

        .stat__value {
            font-family: var(--ff-display);
            font-size: 2.6rem;
            font-weight: 700;
            color: var(--text-bright);
            line-height: 1;
            margin-bottom: 0.3rem;
        }

        .stat--red .stat__value { color: var(--red); }

        .stat__label {
            font-family: var(--ff-condensed);
            font-size: 0.65rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--chrome-dim);
        }

        .section-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .section-title-wrap {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .section-tag {
            font-family: var(--ff-condensed);
            font-size: 0.62rem;
            font-weight: 700;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            color: var(--red);
            padding: 0.3rem 0.75rem;
            border: 1px solid var(--red-border);
            border-radius: 3px;
            background: var(--red-glow);
        }

        .section-title {
            font-family: var(--ff-display);
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-bright);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: var(--carbon-light);
            border: 1px solid rgba(200,205,216,0.1);
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s var(--ease);
        }

        .product-card:hover {
            border-color: var(--red);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(232,0,26,0.2);
        }

        .product-card__image {
            width: 100%;
            height: 200px;
            background: var(--carbon-mid);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .product-card__body {
            padding: 1.5rem;
        }

        .product-card__title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-bright);
            margin-bottom: 0.5rem;
        }

        .product-card__price {
            font-family: var(--ff-display);
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--red);
            margin-bottom: 1rem;
        }

        .product-card__button {
            width: 100%;
            padding: 0.75rem;
            background: var(--red);
            border: none;
            border-radius: 4px;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .product-card__button:hover {
            background: #ff2a3a;
        }

        .footer {
            position: relative;
            z-index: 2;
            padding: 3rem 2.5rem;
            border-top: 1px solid var(--chrome-faint);
            background: rgba(10,10,12,0.6);
            text-align: center;
            color: var(--chrome-dim);
            font-size: 0.85rem;
        }

        @media (max-width: 900px) {
            .stats-bar { grid-template-columns: repeat(2, 1fr); }
            .products-grid { grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); }
        }

        @media (max-width: 640px) {
            .main { padding: 2rem 1.5rem 3rem; }
            .topbar { padding: 0 1.5rem; }
            .stats-bar { grid-template-columns: 1fr; }
            .products-grid { grid-template-columns: 1fr; }
            .section-head { flex-direction: column; align-items: flex-start; }
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<header class="topbar">
    <a href="index.php" class="topbar__brand">
        <div class="topbar__logo-mark">
            <svg viewBox="0 0 20 20" fill="white" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2L3 6v8l7 4 7-4V6L10 2z"/>
            </svg>
        </div>
        <span class="topbar__brand-text">REV<em>ZONE</em></span>
    </a>

    <div class="topbar__nav">
        <div class="topbar__user">
            <div class="topbar__user-dot"></div>
            <span class="topbar__user-name"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
            <a href="logout.php" class="topbar__signout">Exit</a>
        </div>
    </div>
</header>

<!-- MAIN -->
<div class="page-wrap">
    <main class="main">
        <!-- Hero -->
        <div class="page-hero">
            <div class="page-hero__label">// Premium Tuning Parts</div>
            <h1 class="page-hero__title">Performance<br><strong style="color: var(--red);">Parts</strong> Catalog</h1>
            <p class="page-hero__sub">Explore our complete collection of high-performance scooter parts and accessories.</p>
        </div>

        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat">
                <div class="stat__value">60+</div>
                <div class="stat__label">Parts Available</div>
            </div>
            <div class="stat stat--red">
                <div class="stat__value">50+</div>
                <div class="stat__label">Brands</div>
            </div>
            <div class="stat">
                <div class="stat__value">15+</div>
                <div class="stat__label">Categories</div>
            </div>
            <div class="stat">
                <div class="stat__value">24/7</div>
                <div class="stat__label">Availability</div>
            </div>
        </div>

        <!-- Products -->
        <div class="section-head">
            <div class="section-title-wrap">
                <span class="section-tag">Shop</span>
                <h2 class="section-title">Featured Parts</h2>
            </div>
        </div>

        <div class="products-grid">
            <div class="product-card">
                <div class="product-card__image">⚙️</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Polini 70cc Cylinder</h3>
                    <div class="product-card__price">€89,99</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">💨</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Leo Vince Exhaust</h3>
                    <div class="product-card__price">€129,99</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">⚡</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Malossi Variator</h3>
                    <div class="product-card__price">€65,50</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">🔩</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Dellorto Carburator</h3>
                    <div class="product-card__price">€65,00</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">💨</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Stage6 Air Filter</h3>
                    <div class="product-card__price">€28,50</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">🛑</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Brembo Brake Set</h3>
                    <div class="product-card__price">€189,99</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">🛞</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">Pirelli MT60 Tire</h3>
                    <div class="product-card__price">€75,00</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>

            <div class="product-card">
                <div class="product-card__image">⚡</div>
                <div class="product-card__body">
                    <h3 class="product-card__title">CDI Ignition Unit</h3>
                    <div class="product-card__price">€84,99</div>
                    <button class="product-card__button">Add to Cart</button>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- FOOTER -->
<footer class="footer">
    <p>© 2026 RevZone. Premium Scooter Performance Parts. All rights reserved.</p>
</footer>

</body>
</html>
