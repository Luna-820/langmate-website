// FAQ抜粋（TOPページ）のアコーディオン開閉
export function initFaqAccordion() {
  const triggers = document.querySelectorAll('[data-faq-accordion-trigger]');

  triggers.forEach((trigger) => {
    const answer = document.getElementById(trigger.getAttribute('aria-controls'));
    if (!answer) return;

    trigger.addEventListener('click', () => {
      const expanded = trigger.getAttribute('aria-expanded') === 'true';
      trigger.setAttribute('aria-expanded', String(!expanded));
      answer.hidden = expanded;
    });
  });
}
