<?php
/**
 * template-parts/page-body-contact-ja.php
 *
 * 既存の contact.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'ja';
$theme_uri = get_template_directory_uri();
?>

<main id="main">
    <!-- ===== Hero ===== -->
    <section class="sub-hero contact-hero">
      <picture>
        <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-sp.svg" media="(max-width: 430px)">
        <img class="sub-hero__map contact-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true"
          width="1280" height="500" />
      </picture>
      <div class="wrapper sub-hero__inner contact-hero__inner">
        <svg class="sub-hero__eyebrow contact-hero__eyebrow" viewBox="0 0 220 70" role="img" aria-label="CONTACT">
          <!-- about-hero/get-startedと同じアーチ構造を流用 -->
          <path id="contact-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#contact-hero-eyebrow-arc" startOffset="50%">CONTACT</textPath>
          </text>
        </svg>
        <h1 class="sub-hero__heading contact-hero__heading">お問い合わせ</h1>
        <p class="sub-hero__lead contact-hero__lead">Langmateに関するご質問やご相談など、 お気軽にお問い合わせください。<br>
          営業時間外のお問合せの場合には、返信までにお時間がかかる場合がございます。<br>
          予めご了承くださいませ。</p>
        <p class="contact-hero__note">お問合せ前に、以下のボタンより一般的なヘルプをチェックしてみてください。</p>
        <a class="btn btn--outline contact-hero__cta" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">よくある質問はこちら</a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb contact-hero__breadcrumb" aria-label="パンくずリスト">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>
            <li class="breadcrumb__item" aria-current="page">
              お問い合わせ
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- ===== Form ===== -->
    <section class="contact-form-section">
      <div class="wrapper">
        <div class="contact-form" data-contact-thanks-url="<?php echo esc_url( langmate_get_page_url( 'contact-thanks', $lang ) ); ?>">
          <?php echo do_shortcode( '[contact-form-7 id="e4da4e7" title="Draft1 / JP"]' ); ?>
        </div>
      </div>
    </section>
  </main>
