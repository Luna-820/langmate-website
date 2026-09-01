// Contact Form 7 送信成功後、言語に応じたcontact-thanksページへ自動遷移する。
// フォームを囲む要素(.contact-form)のdata-contact-thanks-url属性を
// page-body-contact-{ja,en}.php側でPHPが言語ごとに出し分けているので、
// ここではそれを読むだけ。
export function initCf7Redirect() {
  document.addEventListener('wpcf7mailsent', (event) => {
    const wrapper = event.target.closest('[data-contact-thanks-url]');
    const url = wrapper?.dataset.contactThanksUrl;
    if (url) {
      location.href = url;
    }
  });
}
