// 実績バッジなどがスクロールで画面に入った時にポップイン表示する
export function initStatPop() {
  const targets = document.querySelectorAll('[data-pop]');
  const earlyTargets = document.querySelectorAll('[data-pop-early]');

  if (!targets.length && !earlyTargets.length) return;

  const reduceMotion = window.matchMedia(
    '(prefers-reduced-motion: reduce)'
  ).matches;

  if (reduceMotion) {
    targets.forEach((el) => el.classList.add('is-visible'));
    earlyTargets.forEach((el) => el.classList.add('is-visible'));
    return;
  }

  // 通常のPop
  if (targets.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.4,
      }
    );

    targets.forEach((el) => observer.observe(el));
  }

  // FV直下など、少し早めに発火させたいPop
  if (earlyTargets.length) {
    const earlyPopObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            earlyPopObserver.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0,
        rootMargin: '0px 0px 10% 0px',
      }
    );

    earlyTargets.forEach((el) => earlyPopObserver.observe(el));
  }
}