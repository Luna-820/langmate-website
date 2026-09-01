<?php
/**
 * template-parts/page-body-contact-en.php
 *
 * 既存の en/contact.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'en';
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
        <h1 class="sub-hero__heading contact-hero__heading">Contact Us</h1>
        <p class="sub-hero__lead contact-hero__lead"> If you have any questions or inquiries about Langmate, please feel
          free to contact us.<br>
          Please note that inquiries submitted outside of business hours may take longer to receive a response.<br>
          Thank you for your understanding.</p>
        <p class="contact-hero__note"> Before contacting us, please check our FAQ for answers to common questions.</p>
        <a class="btn btn--outline contact-hero__cta" href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>">View FAQs</a>

        <!-- Breadcrumb -->
        <nav class="breadcrumb contact-hero__breadcrumb" aria-label="Breadcrumb">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>
            <li class="breadcrumb__item" aria-current="page">
              Contact
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- ===== Form ===== -->
    <section class="contact-form-section">
      <div class="wrapper">
        <div class="contact-form" data-contact-thanks-url="<?php echo esc_url( langmate_get_page_url( 'contact-thanks', $lang ) ); ?>">
          <?php echo do_shortcode( '[contact-form-7 id="616e10f" title="Draft1 / EN"]' ); ?>
        </div>
      </div>
    </section>
  </main>
