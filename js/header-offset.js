// 内部リンク(#reason等)でのアンカー着地位置が、position:fixedのヘッダーに
// 隠れてしまう問題への対策。
//
// ヘッダーの実際の高さ(top位置＋バー自体の高さ。clampで画面幅ごとに変わる)を
// 都度測ってCSS変数--header-offsetにセットしておき、CSS側は
// scroll-margin-topでこの変数を参照する。resize/orientationchangeで更新
// (--vhと同じ考え方。viewport-height.js参照)。
export function initHeaderOffset() {
  const header = document.querySelector('.site-header');

  if (!header) return;

  const setHeaderOffset = () => {
    const rect = header.getBoundingClientRect();
    document.documentElement.style.setProperty('--header-offset', `${Math.round(rect.bottom)}px`);
  };

  setHeaderOffset();
  window.addEventListener('resize', setHeaderOffset);
  window.addEventListener('orientationchange', setHeaderOffset);
}
