// 右端追従DLボタン
// PC / Tablet：クリック・ホバーでパネル開閉(601px以上はQRコード表示)
// 600px以下：iOS/AndroidともApp Store/Google Playへ直接振り分け
// 判定できない端末はパネルを開く(ストアバッジ2つ)
//
// 中継ページ(/app/)経由でOS判定を一本化する案も検討したが、OS自動判定が
// 必要な箇所はこの追従ボタンとinitMobileDownload()(ハンバーガーメニュー内の
// DLリンク)の2箇所のみで、どちらも元々JSが動く場所のため、中継ページを
// 挟むメリットが無い。よって両者とも同じ定数(APP_STORE_URL/GOOGLE_PLAY_URL)
// を参照し、直接ストアへ振り分ける方式に統一する。

const APP_STORE_URL =
  'https://apps.apple.com/jp/app/langmate-%E8%8B%B1%E4%BC%9A%E8%A9%B1%E3%81%A8%E5%A4%96%E5%9B%BD%E4%BA%BA%E3%81%AE%E5%8F%8B%E9%81%94%E4%BD%9C%E3%82%8A/id1093968775';

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
  // ダウンロードページ限定：ストアバッジ(.download__stores)が画面内に
  // 入ったら追従ボタンを隠す（役割が被ってしつこくなるため）。
  // このセクションは当該ページにしか存在しないため、他ページには影響しない
  //
  // - threshold 0.5：高さのある端末だと読込直後からバッジの上端が数十px
  //   だけ画面に入ってしまう(端だけ見えてる状態)ので、0だと即座に隠れて
  //   ボタンが一瞬も表示されない。半分以上見えてから隠す
  // - 一度でも見えたらそのまま隠す(badgesSeen)：バッジを通過してフッター
  //   側までスクロールしても再表示はしない
  // ==========================================================

  const storeBadges = document.querySelector('.download__stores');

  if (storeBadges) {
    // 601px以上はストアバッジが常に本文内に見えているため、追従ボタン自体を
    // 非表示にする(CSS側の `@include mx.nav-collapse` 範囲外＝601px以上で判定)
    el.classList.add('is-download-page');

    let badgesSeen = false;

    const storeObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            badgesSeen = true;
          }
          el.classList.toggle('is-near-store-badges', badgesSeen);
        });
      },
      { threshold: 0.5 }
    );

    storeObserver.observe(storeBadges);
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

    // 600px以下 + iOS / Androidと判定できた場合は直接ストアへ
    if (isMobileLayout && deviceType === 'ios') {
      window.location.href = APP_STORE_URL;
      return;
    }

    if (isMobileLayout && deviceType === 'android') {
      window.location.href = GOOGLE_PLAY_URL;
      return;
    }

    // 601px以上(QRパネルを開閉)
    // または600px以下でも端末判定できない場合(ストアバッジのパネルを開閉)
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