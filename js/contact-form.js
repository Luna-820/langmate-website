// お問い合わせフォームの「ユーザーIDを追加する方法」開閉（faq-accordion.jsと同じパターン）
export function initContactForm() {
  const triggers = document.querySelectorAll('[data-contact-user-id-trigger]');

  triggers.forEach((trigger) => {
    const panel = document.getElementById(trigger.getAttribute('aria-controls'));
    if (!panel) return;

    trigger.addEventListener('click', () => {
      const expanded = trigger.getAttribute('aria-expanded') === 'true';
      trigger.setAttribute('aria-expanded', String(!expanded));
      panel.hidden = expanded;
    });
  });

  // フォーム送信：バックエンド未実装のため、必須項目チェックのみ行い
  // 送信成功とみなしてサンクスページへ遷移する（実際のAPI連携は別途実装予定）
  const form = document.querySelector('.contact-form');
  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      // form自体はnovalidateだが、checkValidity/reportValidityは手動で呼べば機能する
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      window.location.href = 'contact-thanks.html';
    });
  }
}
