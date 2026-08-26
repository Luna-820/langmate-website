// SERVICEセクションのアイコンタブ切り替え
// タブ本文の中身は運用側で手動更新する前提。ここでは表示切り替えの枠組みのみ。
export function initServiceTabs() {
  const wrapper = document.querySelector('[data-service-tabs]');
  if (!wrapper) return;

  const tabs = Array.from(wrapper.querySelectorAll('[data-service-tab]'));
  const panels = tabs.map((tab) => document.getElementById(tab.getAttribute('aria-controls')));

  function selectTab(index) {
    tabs.forEach((tab, i) => {
      const selected = i === index;
      tab.setAttribute('aria-selected', String(selected));
      tab.tabIndex = selected ? 0 : -1;
      if (panels[i]) panels[i].hidden = !selected;
    });
    tabs[index].focus();
  }

  tabs.forEach((tab, index) => {
    tab.addEventListener('click', () => selectTab(index));

    tab.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowRight') selectTab((index + 1) % tabs.length);
      if (e.key === 'ArrowLeft') selectTab((index - 1 + tabs.length) % tabs.length);
    });
  });
}
