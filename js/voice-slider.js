// VOICEセクション（口コミ）のスライダー。SPではCSSのscroll-snapで
// スワイプ操作ができるが、それに加えて前へ/次へボタンでも1枚ずつ送れるようにする。
// また、1枚目では前へボタン、最後のカードでは次へボタンを隠す。
export function initVoiceSlider() {
  const sliders = document.querySelectorAll('[data-voice-slider]');

  sliders.forEach((slider) => {
    const list = slider.querySelector('[data-voice-list]');
    const prevBtn = slider.querySelector('[data-voice-prev]');
    const nextBtn = slider.querySelector('[data-voice-next]');
    if (!list || !prevBtn || !nextBtn) return;

    const scrollByOneCard = (direction) => {
      const card = list.querySelector('.card--voice');
      if (!card) return;
      // gapぶんも含めて1枚分だけ送る
      const gap = parseFloat(getComputedStyle(list).columnGap || getComputedStyle(list).gap || '0');
      const amount = card.getBoundingClientRect().width + gap;
      list.scrollBy({ left: amount * direction, behavior: 'smooth' });
    };

    // スクロール位置から「端に到達しているか」を判定してボタンの表示/非表示を切り替える
    const updateNavVisibility = () => {
      const maxScrollLeft = list.scrollWidth - list.clientWidth;
      const atStart = list.scrollLeft <= 1;
      const atEnd = list.scrollLeft >= maxScrollLeft - 1;
      prevBtn.classList.toggle('is-hidden', atStart);
      nextBtn.classList.toggle('is-hidden', atEnd);
    };

    prevBtn.addEventListener('click', () => scrollByOneCard(-1));
    nextBtn.addEventListener('click', () => scrollByOneCard(1));
    list.addEventListener('scroll', updateNavVisibility, { passive: true });
    window.addEventListener('resize', updateNavVisibility);

    updateNavVisibility();
  });
}
