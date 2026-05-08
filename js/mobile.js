/* ============================================================
   LASU CV GENERATOR — MOBILE JS HELPERS
   File: js/mobile.js

   HOW TO USE:
   Add this ONE script tag to the bottom of every .php page,
   just before </body>:
     <script src="js/mobile.js"></script>

   dashboard.php and builder.php also need the hamburger
   button + overlay added to their HTML (see below).
   ============================================================ */


/* ─────────────────────────────────────────────────────────
   1. HAMBURGER MENU TOGGLE
   Works with .sidebar, .sidebar-overlay, and
   .mobile-menu-btn elements.

   HTML TO ADD in dashboard.php and builder.php:
   ─────────────────────────────────────────────
   a) Right before <div class="sidebar"> (inside .dashboard):
      <div class="sidebar-overlay" onclick="toggleMobileMenu()"></div>

   b) Inside .top-nav, as the FIRST child (before .tabs):
      <button class="mobile-menu-btn" onclick="toggleMobileMenu()"
              aria-label="Open navigation menu">
        <span></span>
        <span></span>
        <span></span>
      </button>

   preview.php already has both — no changes needed there.
   ──────────────────────────────────────────────────────── */

function toggleMobileMenu() {
  const sidebar  = document.querySelector('.sidebar');
  const overlay  = document.querySelector('.sidebar-overlay');
  if (!sidebar) return;
  sidebar.classList.toggle('open');
  if (overlay) overlay.classList.toggle('open');
}

// Close the sidebar if user clicks a menu link on mobile
document.addEventListener('DOMContentLoaded', function () {
  const menuLinks = document.querySelectorAll('.sidebar .menu a, .sidebar .logout');
  menuLinks.forEach(function (link) {
    link.addEventListener('click', function () {
      if (window.innerWidth <= 768) {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        if (sidebar) sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
      }
    });
  });
});


/* ─────────────────────────────────────────────────────────
   2. CV PAPER DYNAMIC SCALE (preview.php only)
   Reads the actual viewport width and calculates the exact
   scale factor so the A4 CV paper (794px wide) fits without
   horizontal scroll. Re-runs on window resize (orientation
   change, etc.).
   ──────────────────────────────────────────────────────── */

function scaleCVPaper() {
  const paper = document.querySelector('.cv-paper');
  if (!paper) return;                      // Not on the preview page

  const PAPER_WIDTH = 794;                 // A4 at 96dpi
  const PADDING     = 32;                  // 16px each side

  if (window.innerWidth <= 768) {
    const availableWidth = window.innerWidth - PADDING;
    const scale = Math.min(availableWidth / PAPER_WIDTH, 1); // Never scale up

    // Write as a CSS variable so the media query can use it too
    document.documentElement.style.setProperty('--cv-scale', scale);
    paper.style.transform       = 'scale(' + scale + ')';
    paper.style.transformOrigin = 'top center';

    // Compensate for the height collapse caused by scaling
    const paperHeight    = paper.offsetHeight || 1123; // A4 height at 96dpi
    const scaledHeight   = paperHeight * scale;
    const heightLoss     = paperHeight - scaledHeight;
    paper.style.marginBottom = '-' + heightLoss + 'px';
  } else {
    // Desktop: reset everything
    document.documentElement.style.removeProperty('--cv-scale');
    paper.style.transform    = '';
    paper.style.marginBottom = '';
  }
}

// Run once on load, then on every resize
window.addEventListener('load',   scaleCVPaper);
window.addEventListener('resize', scaleCVPaper);
