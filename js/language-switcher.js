// 言語選択・保存・ページ遷移
// URL構造は /en/ プレフィックス方式（例: /about.html ⇔ /en/about.html）。
// セレクターの選択状態(aria-selected)は「今開いているページの実際の言語」を
// 反映する（保存済みの好みではなく、URLから判定した実体に合わせる）。
const STORAGE_KEY = 'langmate-lang';

// 現在のページがどの言語版か、URLの/en/プレフィックスの有無で判定する
function getCurrentLang() {
  return location.pathname.startsWith('/en/') ? 'en' : 'ja';
}

// 指定した言語版の、今のページに対応するURLを組み立てる
// 例: /about.html + 'en' → /en/about.html　/en/about.html + 'ja' → /about.html
// ※ 対応する言語版のページがまだ存在しない場合は404になる（多言語対応を
//   ページ単位で順次進めている間の暫定挙動。翻訳が揃い次第解消する）。
function buildUrlForLang(lang) {
  const path = location.pathname;
  const isEn = path.startsWith('/en/');
  if (lang === 'en') {
    return isEn ? path : `/en${path}`;
  }
  return isEn ? path.slice(3) || '/' : path;
}

export function initLanguageSwitcher() {
  const switchers = document.querySelectorAll('[data-language-switcher]');
  const currentLang = getCurrentLang();

  switchers.forEach((switcher) => {
    const trigger = switcher.querySelector('.language-switcher__trigger');
    const list = switcher.querySelector('.language-switcher__list');
    if (!trigger || !list) return;

    // 初期状態を反映（今表示しているページの言語に合わせる）
    list.querySelectorAll('[data-lang]').forEach((li) => {
      li.setAttribute('aria-selected', String(li.dataset.lang === currentLang));
    });

    const close = () => {
      list.hidden = true;
      trigger.setAttribute('aria-expanded', 'false');
    };

    trigger.addEventListener('click', () => {
      const isOpen = trigger.getAttribute('aria-expanded') === 'true';
      list.hidden = isOpen;
      trigger.setAttribute('aria-expanded', String(!isOpen));
    });

    list.querySelectorAll('[data-lang]').forEach((li) => {
      li.addEventListener('click', () => {
        const lang = li.dataset.lang;
        localStorage.setItem(STORAGE_KEY, lang);

        if (lang === currentLang) {
          close();
          return;
        }
        location.href = buildUrlForLang(lang);
      });
    });

    document.addEventListener('click', (e) => {
      if (!switcher.contains(e.target)) close();
    });
  });
}
