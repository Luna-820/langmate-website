<?php
/**
 * template-parts/page-body-contact-webview-en.php
 *
 * 「アプリ内ページ」用のお問い合わせ(WebView版、EN)。
 * page-body-contact-webview-ja.php と同じ考え方。
 * Web版(page-body-contact-en.php)の装飾ヒーロー(パンくず・FAQ CTA・
 * 背景マップ)は「ナビなし・内部リンクなし」のWebView仕様に反するため
 * 含めない。フォーム部分だけをそのまま流用する。
 */

$lang = 'en';
?>

<main id="main">
    <section class="legal-hero wrapper">
      <div class="legal-hero__inner">
        <h1 class="legal-hero__title">Contact Us</h1>
      </div>
    </section>

    <section class="contact-form-section">
      <div class="wrapper">
        <div class="contact-form" data-contact-thanks-url="<?php echo esc_url( langmate_get_page_url( 'contact-thanks', $lang ) ); ?>">
          <?php echo do_shortcode( '[contact-form-7 id="616e10f" title="Draft1 / EN"]' ); ?>
        </div>
      </div>
    </section>
</main>
