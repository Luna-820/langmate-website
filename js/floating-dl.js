// 右端追従DLボタン
// PC / Tablet：クリック・ホバーでパネル開閉
// 600px以下：iOSはApp Store、AndroidはGoogle Playへ直接
// 判定できない端末はパネルを開く

const APP_STORE_URL =
  'https://apps.apple.com/us/app/langmate-japanese-friends/id1093968775';

const GOOGLE_PLAY_URL =
  'https://play.google.com/store/apps/details?id=co.thoron.langmate';

// ==========================================================
// Device detection
// ==========================================================

function getDeviceType() {
  const isIOS =
    /iPhone|iPad|iPod/i.test(navigator.userAgent) ||
    (
      navigator.platform === 'MacIntel' &&
      navigator.maxTouchPoints > 1
    );

  if (isIOS) {
    return 'ios';
  }

  if (/Android/i.test(navigator.userAgent)) {
    return 'android';
  }

  return 'other';
}

// ==========================================================
// Floating Download
// ==========================================================

export function initFloatingDl() {
  const el = document.querySelector('[data-floating-dl]');
  const trigger = document.querySelector('[data-floating-dl-trigger]');

  if (!el || !trigger) return;

  const deviceType = getDeviceType();

  // ==========================================================
  // FV(hero)通過後に表示（600px以下のみ。CSS側で範囲を絞っている）
  // ==========================================================

  const hero = document.querySelector('.hero');

  if (hero) {
    const heroObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          el.classList.toggle('is-past-hero', !entry.isIntersecting);
        });
      },
      { threshold: 0 }
    );

    heroObserver.observe(hero);
  } else {
    // heroが無いページでは常時表示のまま
    el.classList.add('is-past-hero');
  }

  // ==========================================================
  // Open / Close
  // ==========================================================

  const close = () => {
    el.dataset.open = 'false';
    trigger.setAttribute('aria-expanded', 'false');
  };

  const toggle = () => {
    const isOpen = el.dataset.open === 'true';
    const nextOpen = !isOpen;

    el.dataset.open = String(nextOpen);
    trigger.setAttribute('aria-expanded', String(nextOpen));
  };

  // ==========================================================
  // Trigger click
  // ==========================================================

  trigger.addEventListener('click', () => {
    const isMobileLayout =
      window.matchMedia('(max-width: 600px)').matches;

    // 600px以下 + iPhone / iPad
    if (isMobileLayout && deviceType === 'ios') {
      window.location.href = APP_STORE_URL;
      return;
    }

    // 600px以下 + Android
    if (isMobileLayout && deviceType === 'android') {
      window.location.href = GOOGLE_PLAY_URL;
      return;
    }

    // 601px以上
    // または600px以下でも端末判定できない場合
    toggle();
  });

  // ==========================================================
  // 欄外クリックで閉じる
  // ==========================================================

  document.addEventListener('click', (e) => {
    if (!el.contains(e.target)) {
      close();
    }
  });

  // ==========================================================
  // Escキーで閉じる
  // ==========================================================

  el.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
      close();
      trigger.focus();
    }
  });

  // ==========================================================
  // 画面サイズ変更時にリセット
  // ==========================================================

  window.addEventListener('resize', close);
}

// ==========================================================
// Mobile Navigation Download
// ==========================================================

export function initMobileDownload() {
  const mobileDownload = document.querySelector('[data-mobile-download]');

  if (!mobileDownload) return;

  const deviceType = getDeviceType();

  mobileDownload.addEventListener('click', (e) => {
    if (deviceType === 'ios') {
      e.preventDefault();
      window.location.href = APP_STORE_URL;
      return;
    }

    if (deviceType === 'android') {
      e.preventDefault();
      window.location.href = GOOGLE_PLAY_URL;
      return;
    }

    // その他の端末はHTMLの href="#download" をそのまま使用
  });
}