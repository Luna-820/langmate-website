<?php
/**
 * template-parts/page-body-contact-thanks-en.php
 *
 * 既存の en/contact-thanks.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'en';
$theme_uri = get_template_directory_uri();
?>

<main id="main">
    <section class="sub-hero contact-hero contact-hero--thanks">
      <img class="sub-hero__map contact-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true" width="1280"
        height="500" />
    </section>

    <!-- ===== Thanks ===== -->
    <section class="contact-thanks">
      <div class="wrapper contact-thanks__inner">
        <span class="contact-thanks__icon" aria-hidden="true">
          <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-contact.svg" alt="" width="120" height="97" />
        </span>
        <!-- TODO: クライアント提供の英訳が届いたら、下記の仮訳(Claudeによる翻訳)と差し替える -->
        <h1 class="contact-thanks__heading">Thank You for<br>Contacting Us</h1>
        <p class="contact-thanks__text">We've received your inquiry.<br>
          A confirmation email has been sent to the address you provided.<br>
          Our team will review your message and get back to you shortly.</p>
      </div>
    </section>
  </main>
