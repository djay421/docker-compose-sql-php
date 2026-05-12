<?php
session_start();
// Redirect if not logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home — Vault</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Mono:wght@400;500&family=DM+Sans:wght@300;400;500&display=swap">
  <link rel="stylesheet" href="css/style.css">
</head>
<body class="home-page">

  <!-- Top bar -->
  <header class="topbar">
    <div class="topbar__logo">VAULT</div>
    <nav class="topbar__nav">
      <span class="topbar__user">
        <span class="dot dot--green pulse"></span>
        <?php echo htmlspecialchars($_SESSION['username']); ?>
      </span>
      <a href="logout.php" class="topbar__logout">
        Sign out
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/></svg>
      </a>
    </nav>
  </header>

  <main class="home-main">

    <!-- Hero section -->
    <section class="hero">
      <div class="hero__meta">
        <div class="hero__issue">VOL. I — DASHBOARD</div>
        <div class="hero__date"><?php echo date('d M Y'); ?></div>
      </div>
      <div class="hero__headline">
        <h1>Good to<br>see you,<br><em><?php echo htmlspecialchars($_SESSION['username']); ?>.</em></h1>
        <div class="hero__subtext">Your personal vault is secure and ready. Everything is in its place.</div>
      </div>
      <div class="hero__rule"></div>
    </section>

    <!-- Stats strip -->
    <section class="stats-strip">
      <div class="stat-card">
        <div class="stat-card__num">01</div>
        <div class="stat-card__label">Active Session</div>
        <div class="stat-card__sub">Since login</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__num">∞</div>
        <div class="stat-card__label">Access</div>
        <div class="stat-card__sub">Unlimited</div>
      </div>
      <div class="stat-card">
        <div class="stat-card__num">0</div>
        <div class="stat-card__label">Alerts</div>
        <div class="stat-card__sub">All clear</div>
      </div>
      <div class="stat-card stat-card--accent">
        <div class="stat-card__num">✓</div>
        <div class="stat-card__label">Verified</div>
        <div class="stat-card__sub">Identity confirmed</div>
      </div>
    </section>

    <!-- Content columns -->
    <section class="columns">
      <div class="col col--wide">
        <div class="col-header">
          <span class="col-tag">RECENT</span>
          <h2 class="col-title">Activity</h2>
        </div>
        <div class="activity-list">
          <div class="activity-item">
            <span class="activity-icon">→</span>
            <div class="activity-body">
              <div class="activity-title">Logged in successfully</div>
              <div class="activity-time">Just now</div>
            </div>
            <span class="activity-badge activity-badge--ok">OK</span>
          </div>
          <div class="activity-item">
            <span class="activity-icon">◎</span>
            <div class="activity-body">
              <div class="activity-title">Session initialized</div>
              <div class="activity-time">Just now</div>
            </div>
            <span class="activity-badge activity-badge--ok">OK</span>
          </div>
          <div class="activity-item activity-item--muted">
            <span class="activity-icon">·</span>
            <div class="activity-body">
              <div class="activity-title">No previous activity on record</div>
              <div class="activity-time">—</div>
            </div>
          </div>
        </div>
      </div>

      <div class="col col--narrow">
        <div class="col-header">
          <span class="col-tag">PROFILE</span>
          <h2 class="col-title">You</h2>
        </div>
        <div class="profile-card">
          <div class="profile-avatar">
            <?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?>
          </div>
          <div class="profile-name"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
          <div class="profile-role">Member</div>
          <div class="profile-detail"><span>Status</span><span class="status-ok">● Active</span></div>
          <div class="profile-detail"><span>Auth</span><span>Session</span></div>
          <div class="profile-detail"><span>Level</span><span>Standard</span></div>
          <a href="logout.php" class="profile-signout">Sign out of Vault</a>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer rule -->
  <footer class="home-footer">
    <div class="home-footer__left">VAULT — Personal Platform</div>
    <div class="home-footer__right"><?php echo date('Y'); ?> · All sessions encrypted</div>
  </footer>

</body>
</html>