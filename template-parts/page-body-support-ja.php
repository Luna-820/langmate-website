<?php
/**
 * template-parts/page-body-support-ja.php
 *
 * 既存の support.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'ja';
$theme_uri = get_template_directory_uri();
?>

<main id="main">
    <!-- ===== Hero（faq-archive.htmlと共通） ===== -->
    <section class="sub-hero faq-hero">
      <picture>
        <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-sp.svg" media="(max-width: 430px)">
        <img class="sub-hero__map faq-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true" width="1280"
          height="500" />
      </picture>
      <div class="wrapper sub-hero__inner faq-hero__inner">
        <svg class="sub-hero__eyebrow faq-hero__eyebrow" viewBox="0 0 220 70" role="img" aria-label="FAQ">
          <path id="faq-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#faq-hero-eyebrow-arc" startOffset="50%">FAQ</textPath>
          </text>
        </svg>
        <h1 class="sub-hero__heading faq-hero__heading">よくある質問</h1>

        <!-- Breadcrumb -->
        <nav class="breadcrumb faq-hero__breadcrumb aria-label=" パンくずリスト>
          <ol class="breadcrumb__list">

            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>

            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">よくある質問</a>
            </li>

            <li class="breadcrumb__item" aria-current="page">
              Cardsとは?
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- ===== Search / Categories（faq-archive.htmlと共通） ===== -->
    <section class="faq-search-section">
      <div class="wrapper">
        <form class="faq-search" action="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>" method="get">
          <input class="faq-search__input" type="search" name="q" placeholder="キーワード入力" />
          <button class="faq-search__submit" type="submit">検索</button>
        </form>

        <nav class="faq-categories" aria-label="FAQカテゴリー">
          <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">
            <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>よくある質問
          </a>
          <a class="faq-categories__item faq-categories__item--active" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">
            <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>使い方
          </a>
          <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">
            <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>Langmateについて
          </a>
          <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">
            <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>トラブルシューティング
          </a>
          <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">
            <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>請求と支払い
          </a>
          <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">
            <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>セキュリティ
          </a>
        </nav>
      </div>
    </section>

    <!-- ===== FAQ詳細 =====
         1つの.faq-detail__blockが1件のFAQ投稿に対応する想定（WordPress化後）。
         入れ子の.faq-detail__subは、投稿本文中の見出し+本文のセットとして
         ACFのフレキシブルコンテンツ（繰り返し可能なブロック）に対応しやすい構造にしている。 -->
    <section class="faq-detail-section">
      <div class="wrapper">
        <div class="faq-detail">
          <h1 class="faq-detail__title">FAQ　Title</h1>

          <nav class="faq-detail__breadcrumb" aria-label="パンくずリスト">
            <ol>
              <li><a href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">FAQ</a></li>
              <li><a href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">使い方</a></li>
              <li><a href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">機能について</a></li>
              <li aria-current="page">マッチする方法</li>
            </ol>
          </nav>

          <hr class="faq-detail__divider" />

          <article class="faq-detail__block">
            <h2>ユーザー同士がフレンドリクエストを送り合いマッチしましょう</h2>
            <p>
              ユーザー同士がお互いにフレンドリクエストをするとマッチします。Card表示時に［アイコン］をタップもしくは右にスワイプすると、そのユーザーにフレンドリクエストが送信されます。相手のユーザーも同様に［アイコン］をタップもしくは右にスワイプするとマッチ成立です。ポップアップが表示されるので、すぐにMessagesを始めることができます。
            </p>
          </article>

          <article class="faq-detail__block">
            <h2>新しいマッチリストからメッセージを送る方法</h2>
            <p>下部ボタン、Messageをタップ。画面上部に、フレンドリクエストが表示されます。チャットしたいユーザーの写真をタップします。チャットウィンドウが開きます。下部のテキストバーを使用してメッセージを送信できます。
            </p>
          </article>

          <article class="faq-detail__block">
            <h2>どうやったらもっとマッチできるか？</h2>
            <p>プロフィール画面を充実するとマッチ利率が上がります。</p>

            <div class="faq-detail__sub">
              <h3>良い写真をアップロードしましょう</h3>
              <p>
                ユーザー同士がお互いにフレンドリクエストをするとマッチします。Card表示時に［アイコン］をタップもしくは右にスワイプすると、そのユーザーにフレンドリクエストが送信されます。相手のユーザーも同様に［アイコン］をタップもしくは右にスワイプするとマッチ成立です。ポップアップが表示されるので、すぐにMessagesを始めることができます。
              </p>
            </div>

            <div class="faq-detail__sub">
              <h3>Boostしてアピールする</h3>
              <p>Boostは他のユーザーへアピールする優れた機能です。Boost時は他のユーザーよりも表示回数が増えマッチ率も上がります。</p>
            </div>
          </article>
        </div>
      </div>
    </section>
  </main>
