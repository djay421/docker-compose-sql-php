<?php
// ─── Session Guard ────────────────────────────────────────────────────────────
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.html');
    exit;
}

// ─── DATABASE CONNECTION ──────────────────────────────────────────────────────
// TODO: Replace with your actual database credentials
// $pdo = new PDO('mysql:host=localhost;dbname=cosmos;charset=utf8', 'user', 'pass', [
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
// ]);

// ─── FETCH DATA ───────────────────────────────────────────────────────────────
// TODO: Replace demo arrays with real DB queries like:
// $celestialObjects = $pdo->query("SELECT * FROM celestial_objects ORDER BY name")->fetchAll();
// $observations     = $pdo->query("SELECT * FROM observations ORDER BY date DESC LIMIT 20")->fetchAll();
// $totalObjects     = $pdo->query("SELECT COUNT(*) FROM celestial_objects")->fetchColumn();

// ── Demo data ─────────────────────────────────────────────────────────────────
$celestialObjects = [
    ['id' => '001', 'name' => 'Sirius',           'type' => 'Star',   'constellation' => 'Canis Major', 'magnitude' => '-1.46', 'distance' => '8.6 ly',   'status' => 'observable'],
    ['id' => '002', 'name' => 'Betelgeuse',        'type' => 'Star',   'constellation' => 'Orion',       'magnitude' => '0.50',  'distance' => '680 ly',   'status' => 'observable'],
    ['id' => '003', 'name' => 'Mars',              'type' => 'Planet', 'constellation' => 'Various',     'magnitude' => '-2.01', 'distance' => '225M km',  'status' => 'observable'],
    ['id' => '004', 'name' => 'Andromeda Galaxy',  'type' => 'Galaxy', 'constellation' => 'Andromeda',   'magnitude' => '3.40',  'distance' => '2.5M ly',  'status' => 'observable'],
    ['id' => '005', 'name' => 'Orion Nebula',      'type' => 'Nebula', 'constellation' => 'Orion',       'magnitude' => '4.00',  'distance' => '1,300 ly', 'status' => 'observable'],
    ['id' => '006', 'name' => 'Vega',              'type' => 'Star',   'constellation' => 'Lyra',        'magnitude' => '0.03',  'distance' => '25 ly',    'status' => 'observable'],
    ['id' => '007', 'name' => 'Crab Nebula',       'type' => 'Nebula', 'constellation' => 'Taurus',      'magnitude' => '8.40',  'distance' => '6,500 ly', 'status' => 'inactive'],
];

$observations = [
    ['id' => '001', 'object' => 'Sirius',          'observer' => $_SESSION['username'], 'date' => '2026-05-10', 'quality' => 'excellent', 'notes' => 'Crystal clear seeing'],
    ['id' => '002', 'object' => 'Mars',            'observer' => 'stargazer_pro',       'date' => '2026-05-09', 'quality' => 'good',      'notes' => 'Polar ice caps visible'],
    ['id' => '003', 'object' => 'Orion Nebula',    'observer' => $_SESSION['username'], 'date' => '2026-05-08', 'quality' => 'excellent', 'notes' => 'Trapezium resolved'],
    ['id' => '004', 'object' => 'Andromeda Galaxy','observer' => 'cosmic_eye',          'date' => '2026-05-07', 'quality' => 'good',      'notes' => 'Dust lanes faintly visible'],
    ['id' => '005', 'object' => 'Vega',            'observer' => $_SESSION['username'], 'date' => '2026-05-06', 'quality' => 'excellent', 'notes' => 'Used for alignment'],
];

// ── Stats ─────────────────────────────────────────────────────────────────────
$totalObjects   = count($celestialObjects);
$totalObs       = count($observations);
$starCount      = count(array_filter($celestialObjects, fn($o) => $o['type'] === 'Star'));
$otherCount     = $totalObjects - $starCount;

// ── Type badge map ─────────────────────────────────────────────────────────────
$typeBadge = [
    'Star'   => 'badge--star',
    'Planet' => 'badge--planet',
    'Galaxy' => 'badge--galaxy',
    'Nebula' => 'badge--nebula',
];

$qualityBadge = [
    'excellent' => 'badge--excellent',
    'good'      => 'badge--good',
    'poor'      => 'badge--poor',
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard — Cosmos Observatory</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&family=Space+Mono:ital,wght@0,400;0,700;1,400&family=Syne:wght@400;500;600;700;800&display=swap">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="nebula-bg"></div>

<!-- ─── TOP NAV ──────────────────────────────────────────────────────────────── -->
<header class="topbar">
  <a href="index.php" class="topbar__brand">
    <div class="topbar__brand-mark">
      <!-- Simple SVG star mark -->
      <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <circle cx="16" cy="16" r="15" stroke="rgba(125,232,245,0.2)" stroke-width="1"/>
        <circle cx="16" cy="16" r="10" stroke="rgba(125,232,245,0.15)" stroke-width="1"/>
        <circle cx="16" cy="16" r="4" fill="rgba(125,232,245,0.9)"/>
        <line x1="16" y1="1" x2="16" y2="7"  stroke="rgba(125,232,245,0.5)" stroke-width="1"/>
        <line x1="16" y1="25" x2="16" y2="31" stroke="rgba(125,232,245,0.5)" stroke-width="1"/>
        <line x1="1" y1="16" x2="7" y2="16"  stroke="rgba(125,232,245,0.5)" stroke-width="1"/>
        <line x1="25" y1="16" x2="31" y2="16" stroke="rgba(125,232,245,0.5)" stroke-width="1"/>
      </svg>
    </div>
    <span class="topbar__brand-text">COSMOS<span>.</span></span>
  </a>

  <nav class="topbar__nav">
    <div class="topbar__status">
      <div class="status-dot"></div>
      System Online
    </div>
    <div class="topbar__user"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
    <a href="logout.php" class="topbar__signout">
      <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4M16 17l5-5-5-5M21 12H9"/>
      </svg>
      Sign Out
    </a>
  </nav>
</header>

<!-- ─── MAIN ─────────────────────────────────────────────────────────────────── -->
<div class="page-wrapper">
<main class="main-content">

  <!-- Page Header -->
  <div class="page-header">
    <div>
      <div class="page-header__eyebrow">// Astronomy Catalog System</div>
      <h1 class="page-header__title">Welcome, <em><?php echo htmlspecialchars($_SESSION['username']); ?></em></h1>
    </div>
    <div class="page-header__meta">
      <?php echo strtoupper(date('l, d M Y')); ?><br>
      <?php echo strtoupper(date('H:i')); ?> UTC &mdash; Session Active
    </div>
  </div>

  <!-- Stats Strip -->
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-card__value"><?php echo $totalObjects; ?></div>
      <div class="stat-card__label">Celestial Objects</div>
      <div class="stat-card__sub">In catalog</div>
    </div>
    <div class="stat-card stat-card--rose">
      <div class="stat-card__value"><?php echo $totalObs; ?></div>
      <div class="stat-card__label">Observations</div>
      <div class="stat-card__sub">Logged this month</div>
    </div>
    <div class="stat-card stat-card--gold">
      <div class="stat-card__value"><?php echo $starCount; ?></div>
      <div class="stat-card__label">Stars Cataloged</div>
      <div class="stat-card__sub">Stellar objects</div>
    </div>
    <div class="stat-card stat-card--violet">
      <div class="stat-card__value"><?php echo $otherCount; ?></div>
      <div class="stat-card__label">Other Objects</div>
      <div class="stat-card__sub">Planets, galaxies, nebulae</div>
    </div>
  </div>

  <!-- ─── CELESTIAL OBJECTS TABLE ─────────────────────────────────────────────── -->
  <div class="crud-section">
    <div class="crud-section__head">
      <div class="crud-section__label">
        <span class="section-tag">Catalog</span>
        <h2 class="crud-section__title">Celestial Objects</h2>
      </div>
      <div class="crud-section__actions">
        <div class="search-box">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
          </svg>
          <input type="text" id="objSearch" placeholder="search catalog..." oninput="filterTable('objBody', this.value)">
        </div>
        <button class="btn btn--primary" onclick="openModal('object', 'add')">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
          Add Object
        </button>
        <!-- Export hook — wire to export.php -->
        <a href="export.php?table=celestial_objects" class="btn btn--ghost">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
          Export
        </a>
      </div>
    </div>

    <div class="table-scroll">
      <table class="data-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Name</th>
            <th>Type</th>
            <th>Constellation</th>
            <th>Magnitude</th>
            <th>Distance</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="objBody">
          <?php if (empty($celestialObjects)): ?>
          <tr>
            <td colspan="8">
              <div class="empty-state">
                <span class="empty-state__icon">◎</span>
                <div class="empty-state__text">No objects in catalog — add one to begin</div>
              </div>
            </td>
          </tr>
          <?php else: foreach ($celestialObjects as $obj): ?>
          <tr data-id="<?php echo htmlspecialchars($obj['id']); ?>">
            <td class="col-id"><?php echo htmlspecialchars($obj['id']); ?></td>
            <td class="col-name"><?php echo htmlspecialchars($obj['name']); ?></td>
            <td>
              <span class="badge <?php echo $typeBadge[$obj['type']] ?? 'badge--inactive'; ?>">
                <?php echo htmlspecialchars($obj['type']); ?>
              </span>
            </td>
            <td class="col-type"><?php echo htmlspecialchars($obj['constellation']); ?></td>
            <td class="col-type"><?php echo htmlspecialchars($obj['magnitude']); ?></td>
            <td class="col-type"><?php echo htmlspecialchars($obj['distance']); ?></td>
            <td>
              <span class="badge badge--<?php echo htmlspecialchars(strtolower($obj['status'])); ?>">
                <?php echo htmlspecialchars(ucfirst($obj['status'])); ?>
              </span>
            </td>
            <td>
              <div class="row-actions">
                <button class="row-btn row-btn--view" onclick="viewObject('<?php echo htmlspecialchars($obj['id']); ?>')">View</button>
                <button class="row-btn row-btn--edit" onclick="openModal('object', 'edit', <?php echo "'" . htmlspecialchars(json_encode($obj)) . "'"; ?>)">Edit</button>
                <button class="row-btn row-btn--delete" onclick="confirmDelete('celestial_object', '<?php echo htmlspecialchars($obj['id']); ?>', '<?php echo htmlspecialchars(addslashes($obj['name'])); ?>')">Delete</button>
              </div>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <div class="pagination">
      <div class="pagination__info">
        Showing <?php echo count($celestialObjects); ?> of <?php echo $totalObjects; ?> objects
      </div>
      <div class="pagination__controls">
        <button class="page-btn">&lsaquo;</button>
        <button class="page-btn page-btn--active">1</button>
        <button class="page-btn">&rsaquo;</button>
      </div>
    </div>
  </div>

  <!-- ─── OBSERVATIONS TABLE ──────────────────────────────────────────────────── -->
  <div class="crud-section">
    <div class="crud-section__head">
      <div class="crud-section__label">
        <span class="section-tag section-tag--rose">Observations</span>
        <h2 class="crud-section__title">Recent Log</h2>
      </div>
      <div class="crud-section__actions">
        <div class="search-box">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/>
          </svg>
          <input type="text" id="obsSearch" placeholder="search log..." oninput="filterTable('obsBody', this.value)">
        </div>
        <button class="btn btn--primary" onclick="openModal('observation', 'add')">
          <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
          Log Observation
        </button>
      </div>
    </div>

    <div class="table-scroll">
      <table class="data-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Object</th>
            <th>Observer</th>
            <th>Date</th>
            <th>Seeing Quality</th>
            <th>Notes</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody id="obsBody">
          <?php if (empty($observations)): ?>
          <tr>
            <td colspan="7">
              <div class="empty-state">
                <span class="empty-state__icon">◎</span>
                <div class="empty-state__text">No observations logged yet</div>
              </div>
            </td>
          </tr>
          <?php else: foreach ($observations as $obs): ?>
          <tr data-id="<?php echo htmlspecialchars($obs['id']); ?>">
            <td class="col-id"><?php echo htmlspecialchars($obs['id']); ?></td>
            <td class="col-name"><?php echo htmlspecialchars($obs['object']); ?></td>
            <td class="col-type"><?php echo htmlspecialchars($obs['observer']); ?></td>
            <td class="col-type"><?php echo htmlspecialchars($obs['date']); ?></td>
            <td>
              <span class="badge <?php echo $qualityBadge[$obs['quality']] ?? 'badge--inactive'; ?>">
                <?php echo htmlspecialchars(ucfirst($obs['quality'])); ?>
              </span>
            </td>
            <td class="col-type"><?php echo htmlspecialchars($obs['notes']); ?></td>
            <td>
              <div class="row-actions">
                <button class="row-btn row-btn--edit" onclick="openModal('observation', 'edit', <?php echo "'" . htmlspecialchars(json_encode($obs)) . "'"; ?>)">Edit</button>
                <button class="row-btn row-btn--delete" onclick="confirmDelete('observation', '<?php echo htmlspecialchars($obs['id']); ?>', '<?php echo htmlspecialchars(addslashes($obs['object'])); ?>')">Delete</button>
              </div>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>

    <div class="pagination">
      <div class="pagination__info">
        Showing <?php echo count($observations); ?> of <?php echo $totalObs; ?> observations
      </div>
      <div class="pagination__controls">
        <button class="page-btn">&lsaquo;</button>
        <button class="page-btn page-btn--active">1</button>
        <button class="page-btn">&rsaquo;</button>
      </div>
    </div>
  </div>

</main>
</div>

<!-- ─── FOOTER ──────────────────────────────────────────────────────────────── -->
<footer class="site-footer">
  <div class="site-footer__left">Cosmos Observatory — <?php echo date('Y'); ?></div>
  <div class="site-footer__right">Session Active &middot; Transmissions Secured</div>
</footer>

<!-- ─── CELESTIAL OBJECT MODAL ───────────────────────────────────────────────── -->
<div class="modal-backdrop" id="objectModal" onclick="closeOnBackdrop(event, 'objectModal')">
  <div class="modal">
    <div class="modal__header">
      <div>
        <div class="modal__eyebrow" id="objModalEyebrow">New Entry</div>
        <div class="modal__title" id="objModalTitle">Add Celestial Object</div>
      </div>
      <button class="modal__close" onclick="closeModal('objectModal')">&times;</button>
    </div>

    <form method="POST" action="object_process.php">
      <input type="hidden" name="action" id="objFormAction" value="add">
      <input type="hidden" name="id"     id="objFormId"     value="">

      <div class="modal__body">
        <div class="field-row">
          <div class="field-group">
            <label class="field-label">// Name</label>
            <input class="field-input" type="text" name="name" id="objName" placeholder="Sirius" required>
          </div>
          <div class="field-group">
            <label class="field-label">// Type</label>
            <select class="field-select" name="type" id="objType">
              <option value="Star">Star</option>
              <option value="Planet">Planet</option>
              <option value="Galaxy">Galaxy</option>
              <option value="Nebula">Nebula</option>
              <option value="Cluster">Cluster</option>
              <option value="Other">Other</option>
            </select>
          </div>
        </div>

        <div class="field-group">
          <label class="field-label">// Constellation</label>
          <input class="field-input" type="text" name="constellation" id="objConstellation" placeholder="Canis Major">
        </div>

        <div class="field-row">
          <div class="field-group">
            <label class="field-label">// Magnitude</label>
            <input class="field-input" type="text" name="magnitude" id="objMagnitude" placeholder="-1.46">
          </div>
          <div class="field-group">
            <label class="field-label">// Distance</label>
            <input class="field-input" type="text" name="distance" id="objDistance" placeholder="8.6 ly">
          </div>
        </div>

        <div class="field-group">
          <label class="field-label">// Status</label>
          <select class="field-select" name="status" id="objStatus">
            <option value="observable">Observable</option>
            <option value="inactive">Not Visible</option>
            <option value="pending">Pending Verification</option>
          </select>
        </div>
      </div>

      <div class="modal__footer">
        <button type="button" class="btn btn--ghost" onclick="closeModal('objectModal')">Cancel</button>
        <button type="submit" class="btn btn--primary" id="objSubmitBtn">Add Object</button>
      </div>
    </form>
  </div>
</div>

<!-- ─── OBSERVATION MODAL ────────────────────────────────────────────────────── -->
<div class="modal-backdrop" id="observationModal" onclick="closeOnBackdrop(event, 'observationModal')">
  <div class="modal">
    <div class="modal__header">
      <div>
        <div class="modal__eyebrow" id="obsModalEyebrow">New Entry</div>
        <div class="modal__title" id="obsModalTitle">Log Observation</div>
      </div>
      <button class="modal__close" onclick="closeModal('observationModal')">&times;</button>
    </div>

    <form method="POST" action="observation_process.php">
      <input type="hidden" name="action" id="obsFormAction" value="add">
      <input type="hidden" name="id"     id="obsFormId"     value="">

      <div class="modal__body">
        <div class="field-row">
          <div class="field-group">
            <label class="field-label">// Object Name</label>
            <input class="field-input" type="text" name="object" id="obsObject" placeholder="Sirius" required>
          </div>
          <div class="field-group">
            <label class="field-label">// Observer</label>
            <input class="field-input" type="text" name="observer" id="obsObserver" value="<?php echo htmlspecialchars($_SESSION['username']); ?>" required>
          </div>
        </div>

        <div class="field-row">
          <div class="field-group">
            <label class="field-label">// Date</label>
            <input class="field-input" type="date" name="date" id="obsDate" value="<?php echo date('Y-m-d'); ?>" required>
          </div>
          <div class="field-group">
            <label class="field-label">// Seeing Quality</label>
            <select class="field-select" name="quality" id="obsQuality">
              <option value="excellent">Excellent</option>
              <option value="good">Good</option>
              <option value="poor">Poor</option>
            </select>
          </div>
        </div>

        <div class="field-group">
          <label class="field-label">// Notes</label>
          <textarea class="field-textarea" name="notes" id="obsNotes" placeholder="Observation notes, conditions, equipment used..."></textarea>
        </div>
      </div>

      <div class="modal__footer">
        <button type="button" class="btn btn--ghost" onclick="closeModal('observationModal')">Cancel</button>
        <button type="submit" class="btn btn--primary" id="obsSubmitBtn">Log Observation</button>
      </div>
    </form>
  </div>
</div>

<!-- ─── CONFIRM DIALOG ───────────────────────────────────────────────────────── -->
<div class="confirm-dialog" id="confirmDialog">
  <div class="confirm-box">
    <span class="confirm-box__icon">⚠</span>
    <div class="confirm-box__title">Confirm Deletion</div>
    <div class="confirm-box__text" id="confirmText">This action cannot be undone.</div>
    <div class="confirm-box__actions">
      <button class="btn btn--ghost" onclick="closeConfirm()">Cancel</button>
      <a class="btn btn--danger" id="confirmAction" href="#">Delete Record</a>
    </div>
  </div>
</div>

<!-- ─── SCRIPTS ──────────────────────────────────────────────────────────────── -->
<script src="js/starfield.js"></script>
<script>
// ── Modal handlers ────────────────────────────────────────────────────────────
function openModal(type, mode, dataJson) {
  const modalId = type === 'object' ? 'objectModal' : 'observationModal';
  const modal   = document.getElementById(modalId);

  if (type === 'object') {
    const isEdit = mode === 'edit';
    document.getElementById('objModalEyebrow').textContent = isEdit ? 'Edit Record' : 'New Entry';
    document.getElementById('objModalTitle').textContent   = isEdit ? 'Edit Celestial Object' : 'Add Celestial Object';
    document.getElementById('objFormAction').value         = mode;
    document.getElementById('objSubmitBtn').textContent    = isEdit ? 'Save Changes' : 'Add Object';

    if (isEdit && dataJson) {
      const d = JSON.parse(dataJson);
      document.getElementById('objFormId').value         = d.id ?? '';
      document.getElementById('objName').value           = d.name ?? '';
      document.getElementById('objConstellation').value  = d.constellation ?? '';
      document.getElementById('objMagnitude').value      = d.magnitude ?? '';
      document.getElementById('objDistance').value       = d.distance ?? '';
      setSelectValue('objType',   d.type);
      setSelectValue('objStatus', d.status);
    } else {
      modal.querySelector('form').reset();
      document.getElementById('objFormId').value = '';
    }
  }

  if (type === 'observation') {
    const isEdit = mode === 'edit';
    document.getElementById('obsModalEyebrow').textContent = isEdit ? 'Edit Record' : 'New Entry';
    document.getElementById('obsModalTitle').textContent   = isEdit ? 'Edit Observation' : 'Log Observation';
    document.getElementById('obsFormAction').value         = mode;
    document.getElementById('obsSubmitBtn').textContent    = isEdit ? 'Save Changes' : 'Log Observation';

    if (isEdit && dataJson) {
      const d = JSON.parse(dataJson);
      document.getElementById('obsFormId').value    = d.id ?? '';
      document.getElementById('obsObject').value    = d.object ?? '';
      document.getElementById('obsObserver').value  = d.observer ?? '';
      document.getElementById('obsDate').value      = d.date ?? '';
      document.getElementById('obsNotes').value     = d.notes ?? '';
      setSelectValue('obsQuality', d.quality);
    } else {
      modal.querySelector('form').reset();
      document.getElementById('obsFormId').value = '';
      document.getElementById('obsObserver').value = '<?php echo htmlspecialchars($_SESSION['username']); ?>';
      document.getElementById('obsDate').value = '<?php echo date('Y-m-d'); ?>';
    }
  }

  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeModal(id) {
  document.getElementById(id).classList.remove('open');
  document.body.style.overflow = '';
}

function closeOnBackdrop(e, id) {
  if (e.target === document.getElementById(id)) closeModal(id);
}

function setSelectValue(id, value) {
  const sel = document.getElementById(id);
  if (!sel || !value) return;
  for (const opt of sel.options) {
    if (opt.value.toLowerCase() === value.toLowerCase()) { opt.selected = true; break; }
  }
}

// ── Quick view (placeholder — wire to detail page) ────────────────────────────
function viewObject(id) {
  window.location.href = `view.php?id=${id}&table=celestial_objects`;
}

// ── Confirm delete ────────────────────────────────────────────────────────────
function confirmDelete(table, id, name) {
  document.getElementById('confirmText').textContent =
    `You are about to permanently delete "${name}" (ID: ${id}). This cannot be undone.`;
  document.getElementById('confirmAction').href =
    `delete.php?table=${encodeURIComponent(table)}&id=${encodeURIComponent(id)}`;
  document.getElementById('confirmDialog').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeConfirm() {
  document.getElementById('confirmDialog').classList.remove('open');
  document.body.style.overflow = '';
}

document.getElementById('confirmDialog').addEventListener('click', function(e) {
  if (e.target === this) closeConfirm();
});

// ── Table search filter ───────────────────────────────────────────────────────
function filterTable(tbodyId, query) {
  const tbody = document.getElementById(tbodyId);
  if (!tbody) return;
  const q = query.toLowerCase().trim();
  tbody.querySelectorAll('tr').forEach(row => {
    row.style.display = !q || row.textContent.toLowerCase().includes(q) ? '' : 'none';
  });
}

// ── Keyboard: Escape closes modals ───────────────────────────────────────────
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') {
    closeModal('objectModal');
    closeModal('observationModal');
    closeConfirm();
  }
});
</script>
</body>
</html>