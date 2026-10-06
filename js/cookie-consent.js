// Cookie同意バナー(Consent Mode連携)
//
// PHP側(functions.php: langmate_consent_mode_default)が、GTMより先に
// 分析・広告Cookieを全部「拒否」状態で初期化している。このファイルは
// その後、実際のユーザーの選択(同意/拒否)に応じてgtag('consent','update',...)
// を呼び、同意状態を書き換える役割を持つ。
//
// 選択結果はCookieに保存し(1年間)、次回訪問時はバナーを出さず、
// 保存済みの選択を即座にConsent Modeへ反映する。
const COOKIE_NAME = 'langmate_cookie_consent';
const COOKIE_MAX_AGE_DAYS = 365;

function readConsentCookie() {
  const match = document.cookie.match(new RegExp('(?:^|; )' + COOKIE_NAME + '=([^;]*)'));
  return match ? decodeURIComponent(match[1]) : null;
}

function writeConsentCookie(value) {
  const maxAge = COOKIE_MAX_AGE_DAYS * 24 * 60 * 60;
  document.cookie = `${COOKIE_NAME}=${encodeURIComponent(value)}; max-age=${maxAge}; path=/; SameSite=Lax`;
}

function updateConsent(granted) {
  if (typeof window.gtag !== 'function') return;
  const state = granted ? 'granted' : 'denied';
  window.gtag('consent', 'update', {
    analytics_storage: state,
    ad_storage: state,
    ad_user_data: state,
    ad_personalization: state,
  });
}

export function initCookieConsent() {
  const banner = document.querySelector('[data-cookie-consent]');
  if (!banner) return;

  const existing = readConsentCookie();

  if (existing === 'granted' || existing === 'denied') {
    // 既に選択済み: バナーは出さず、保存済みの選択だけConsent Modeへ反映する。
    updateConsent(existing === 'granted');
    return;
  }

  // 未選択: バナーを表示する。
  banner.hidden = false;

  const acceptBtn = banner.querySelector('[data-cookie-consent-accept]');
  const declineBtn = banner.querySelector('[data-cookie-consent-decline]');

  const close = (granted) => {
    writeConsentCookie(granted ? 'granted' : 'denied');
    updateConsent(granted);
    banner.hidden = true;
  };

  acceptBtn?.addEventListener('click', () => close(true));
  declineBtn?.addEventListener('click', () => close(false));
}
