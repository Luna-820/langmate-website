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

  // ==========================================================================
  // 静的HTML用フォーム送信
  // ==========================================================================
  //
  // 静的HTML側：バックエンド未実装のため、必須項目チェックのみ行い、
  // 正常なら contact-thanks.html へ遷移する。
  //
  // WordPress側：.contact-form は <form> ではなく、
  // Contact Form 7 を囲む <div> として使用する（実際の送信処理はCF7、
  // サンクスページ遷移は cf7-redirect.js の wpcf7mailsent イベントが担当）。
  // そのため「form.contact-form が存在する場合のみ」静的HTML用の処理を行う。
  // ==========================================================================

  const form = document.querySelector('form.contact-form');
  if (!form) return;

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
