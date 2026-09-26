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
//
// ルートページ(/)には、Cookie/ブラウザ言語からJA/ENを自動判定して振り分ける
// サーバー側の仕組み(functions.php: langmate_root_language_redirect)がある。
// この手動切替でルートへ遷移する場合(JA→ENなど)、遷移直後はCookieがまだ
// 直前の言語のままのタイミングがあり、自動判定にCookie優先で直前の言語へ
// 送り返されてしまう不具合があった。Cookie自体はサーバー側でHttpOnly付きの
// ため、ここ(JS)からは書き換えられない。そこで遷移先URLに?langswitch=<lang>
// を付け、サーバー側でCookieより優先して処理してもらうことで解決する。
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
          // WordPress側：<a href>のネイティブな遷移にそのまま任せるが、
          // 遷移先がルート(/)だと自動言語判定と衝突するため、hrefに
          // ?langswitch=<lang> を付けてサーバー側で最優先判定してもらう
          // (クリックのデフォルト動作が起きる前にhref属性を書き換えれば、
          // ブラウザは書き換え後のURLへ遷移する)。
          const anchor = li.querySelector('a[href]');
          if (anchor) {
            const url = new URL(anchor.getAttribute('href'), location.href);
            url.searchParams.set('langswitch', lang);
            anchor.setAttribute('href', `${url.pathname}${url.search}`);
          }
          return;
        }

        // 静的HTML側：<a>が無いのでJSでURLを組み立てて遷移する
        // (?langswitch=の理由は上記コメントと同じ)
        location.href = `${buildUrlForLang(lang)}?langswitch=${lang}`;
      });
    });

    document.addEventListener('click', (e) => {
      if (!switcher.contains(e.target)) close();
    });
  });
}
