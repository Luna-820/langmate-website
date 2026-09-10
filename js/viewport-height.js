// モバイルの「アドレスバー分の高さのブレ」対策(--vh CSS変数)
//
// CSSのdvh/svh単位は仕様上「アドレスバー分を考慮した実際の表示高さ」を
// 返すはずだが、ブラウザ(特にLINE等アプリ内ブラウザのWebView)によって
// 実装がバラバラで、100dvhはもちろん、本来はスクロール中も値が変わらない
// はずの100svhでもスクロール中に値が動いてしまうケースが実機で確認できた
// (通常のモバイルSafari/Chromeでは問題なし)。
//
// window.innerHeightはどのブラウザでも一貫して「今実際に見えている高さ」を
// 返すため、この値を元にCSS変数--vhとして1%分の高さを都度計算しておき、
// CSS側はvh/dvh/svhではなくこの--vhを使う。resize/orientationchangeでのみ
// 更新し、意図的にscrollでは更新しない(スクロール中にアドレスバーが
// 収縮しても値を変えずに固定した高さのまま保つことで、.hero__phones等
// 「heroの高さに対する%」で位置を計算している要素がスクロール中に
// 本文と別に動いて見える不具合を防ぐ)。
export function initViewportHeight() {
  const setVH = () => {
    document.documentElement.style.setProperty('--vh', `${window.innerHeight * 0.01}px`);
  };

  setVH();
  window.addEventListener('resize', setVH);
  window.addEventListener('orientationchange', setVH);
}
