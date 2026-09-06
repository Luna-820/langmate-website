<?php
/**
 * template-parts/page-body-contact-webview-ja.php
 *
 * 「アプリ内ページ」用のお問い合わせ(WebView版)。
 * Web版(page-body-contact-ja.php)の装飾ヒーロー(パンくず・
 * 「よくある質問はこちら」CTA・背景マップ)は「ナビなし・内部リンクなし」の
 * WebView仕様に反するため含めない。フォーム部分だけをそのまま流用する
 * (Contact Form 7のID・送信後のcontact-thanksへの遷移はWeb版と共通。
 * 同一サイト内かつAJAX遷移のため、外部リンクとは違いWebView内でも問題ない)。
 */

$lang = 'ja';
?>

<main id="main">
    <section class="legal-hero wrapper">
      <div class="legal-hero__inner">
        <h1 class="legal-hero__title">お問い合わせ</h1>
      </div>
    </section>

    <section class="contact-form-section">
      <div class="wrapper">
        <div class="contact-form" data-contact-thanks-url="<?php echo esc_url( langmate_get_page_url( 'contact-thanks', $lang ) ); ?>">
          <?php echo do_shortcode( '[contact-form-7 id="e4da4e7" title="Draft1 / JP"]' ); ?>
        </div>
      </div>
    </section>
</main>
