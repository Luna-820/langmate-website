// ハンバーガーメニュー開閉
export function initMobileNav() {
  const trigger = document.querySelector('[data-mobile-nav-trigger]');
  const closeBtn = document.querySelector('[data-mobile-nav-close]');
  const nav = document.querySelector('[data-mobile-nav]');
  if (!trigger || !nav) return;

  const open = () => {
    nav.hidden = false;
    trigger.setAttribute('aria-expanded', 'true');
    document.body.style.overflow = 'hidden';
    nav.querySelector('a, button')?.focus();
  };

  const close = () => {
    nav.hidden = true;
    trigger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
    trigger.focus();
  };

  trigger.addEventListener('click', open);
  closeBtn?.addEventListener('click', close);

  nav.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });
}
