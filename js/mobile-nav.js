// ハンバーガーメニュー開閉
export function initMobileNav() {
  const trigger = document.querySelector('[data-mobile-nav-trigger]');
  const closeBtn = document.querySelector('[data-mobile-nav-close]');
  const nav = document.querySelector('[data-mobile-nav]');
  if (!trigger || !nav) return;

  const TRANSITION_MS = 350; // .mobile-navのheight transition(0.35s)と合わせる

  const open = () => {
    // [hidden]を先に外してdisplay:flex(height:0)の状態にし、
    // 次フレームで.is-openを付けてheight:100vhへtransitionさせる
    // （[hidden]解除と同フレームでクラスを付けるとtransitionが発火しないブラウザがあるため）
    nav.hidden = false;
    requestAnimationFrame(() => {
      nav.classList.add('is-open');
    });
    trigger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    nav.querySelector('a, button')?.focus();
  };

  const close = () => {
    nav.classList.remove('is-open'); // height:100vh→0のtransitionを開始
    trigger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    trigger.focus();
    // transitionが終わってから[hidden]に戻す（a11y・操作不可を確実にする）
    window.setTimeout(() => {
      nav.hidden = true;
    }, TRANSITION_MS);
  };

  trigger.addEventListener('click', open);
  closeBtn?.addEventListener('click', close);

  nav.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });
}
