// ハンバーガーメニュー開閉
export function initMobileNav() {
  const trigger = document.querySelector('[data-mobile-nav-trigger]');
  const closeBtn = document.querySelector('[data-mobile-nav-close]');
  const nav = document.querySelector('[data-mobile-nav]');
  if (!trigger || !nav) return;

  const TRANSITION_MS = 350; // .mobile-navのtransform transition(0.35s)と合わせる
  let scrollY = 0;

  const lockScroll = () => {
    // body{overflow:hidden}だけだとiOS Safariでは背面が touch-scroll できてしまうため、
    // 現在のスクロール位置を保持したままbodyをposition:fixedで固定する
    scrollY = window.scrollY;
    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollY}px`;
    document.body.style.left = '0';
    document.body.style.right = '0';
  };

  const unlockScroll = () => {
    document.body.style.position = '';
    document.body.style.top = '';
    document.body.style.left = '';
    document.body.style.right = '';
    window.scrollTo(0, scrollY);
  };

  const open = () => {
    // [hidden]を先に外してdisplay:flex(閉じた状態=translateX(100%))にし、
    // 次フレームで.is-openを付けてtranslateX(0)へtransitionさせる
    // （[hidden]解除と同フレームでクラスを付けるとtransitionが発火しないブラウザがあるため）
    nav.hidden = false;
    requestAnimationFrame(() => {
      nav.classList.add('is-open');
    });
    trigger.setAttribute('aria-expanded', 'true');
    lockScroll();
    nav.querySelector('a, button')?.focus();
  };

  const close = () => {
    nav.classList.remove('is-open'); // translateX(0)→100%のtransitionを開始
    trigger.setAttribute('aria-expanded', 'false');
    unlockScroll();
    trigger.focus();
    // transitionが終わってから[hidden]に戻す（a11y・操作不可を確実にする）
    window.setTimeout(() => {
      nav.hidden = true;
    }, TRANSITION_MS);
  };

  // トリガー(ハンバーガー⇄×)はopen/closeを兼ねるトグルボタンなので、
  // 現在の開閉状態を見て呼び分ける（固定でopenだけ呼ぶと×クリックで閉じなかった）
  trigger.addEventListener('click', () => {
    if (trigger.getAttribute('aria-expanded') === 'true') {
      close();
    } else {
      open();
    }
  });
  closeBtn?.addEventListener('click', close);

  nav.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });
}
