// 右端追従DLボタンの開閉（ホバーに加えて、クリック・キーボード操作にも対応）
export function initFloatingDl() {
  const el = document.querySelector('[data-floating-dl]');
  const trigger = document.querySelector('[data-floating-dl-trigger]');
  if (!el || !trigger) return;

  const close = () => {
    el.dataset.open = 'false';
    trigger.setAttribute('aria-expanded', 'false');
  };

  trigger.addEventListener('click', () => {
    const isOpen = el.dataset.open === 'true';
    el.dataset.open = String(!isOpen);
    trigger.setAttribute('aria-expanded', String(!isOpen));
  });

  // 欄外クリックで閉じる
  document.addEventListener('click', (e) => {
    if (!el.contains(e.target)) close();
  });

  // Escキーで閉じる
  el.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') close();
  });
}
