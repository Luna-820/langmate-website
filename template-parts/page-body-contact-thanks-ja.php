<?php
/**
 * template-parts/page-body-contact-thanks-ja.php
 *
 * 既存の contact-thanks.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'ja';
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
        <h1 class="contact-thanks__heading">お問い合わせ<br>ありがとうございます</h1>
        <p class="contact-thanks__text">お問合せを受け付けました。<br>
          ご登録いただいたメールアドレスへ、確認の自動返信メールをお送りしております。<br>
          内容確認後、担当者よりご連絡いたしますので、少々お待ちください。</p>
      </div>
    </section>
  </main>
