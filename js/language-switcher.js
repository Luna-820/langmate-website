// 言語選択・保存・ページ遷移
// URL構造は /ja/ プレフィックス方式（例: /company/ ⇔ /ja/company/、英語がデフォルト/ルート）。
// セレクターの選択状態(aria-selected)は「今開いているページの実際の言語」を
// 反映する（保存済みの好みではなく、URLから判定した実体に合わせる）。
//
// 遷移先の決め方は<li>の中身によって2通り対応する（静的HTML/WordPress共存のため）:
//   - <li>の中に<a href>がある場合（WordPress側。サーバーでtranslation_keyから解決済み）
//     → そのネイティブな遷移にそのまま任せる
//   - <a>が無い場合（静的HTML側。今まで通り）
//     → JSでURLを組み立てて遷移する
const STORAGE_KEY = 'langmate-lang';

// 現在のページがどの言語版か、URLの/ja/プレフィックスの有無で判定する（英語がデフォルト）
function getCurrentLang() {
  return location.pathname.startsWith('/ja/') ? 'ja' : 'en';
}

// 指定した言語版の、今のページに対応するURLを組み立てる（静的HTML用フォールバック）
// 例: /company/ + 'ja' → /ja/company/　/ja/company/ + 'en' → /company/
function buildUrlForLang(lang) {
  const path = location.pathname;
  const isJa = path.startsWith('/ja/');
  if (lang === 'ja') {
    return isJa ? path : `/ja${path}`;
  }
  return isJa ? path.slice(3) || '/' : path;
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
      const hasNativeLink = !!li.querySelector('a[href]');

      li.addEventListener('click', (e) => {
        const lang = li.dataset.lang;
        localStorage.setItem(STORAGE_KEY, lang);

        if (lang === currentLang) {
          // 今と同じ言語をクリック：遷移不要、パネルを閉じるだけ
          e.preventDefault();
          close();
          return;
        }

        if (hasNativeLink) {
          // WordPress側：<a href>のネイティブな遷移にそのまま任せる
          return;
        }

        // 静的HTML側：<a>が無いのでJSでURLを組み立てて遷移する
        location.href = buildUrlForLang(lang);
      });
    });

    document.addEventListener('click', (e) => {
      if (!switcher.contains(e.target)) close();
    });
  });
}
