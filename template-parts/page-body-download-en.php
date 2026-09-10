<?php
/**
 * template-parts/page-body-download-en.php
 *
 * ダウンロードページ本文（英）。日本語版(page-body-download-ja.php)と
 * DOM構造・class名は同一。文言と、モックアップ画像(img-download-en.webp)、
 * バッジのロケール(-en)だけが異なる。
 */

$lang      = 'en';
$theme_uri = get_template_directory_uri();

$appstore_url   = LANGMATE_APPSTORE_URL;
$googleplay_url = LANGMATE_GOOGLEPLAY_URL;
?>

<main id="main">
    <!-- ===== Hero ===== -->
    <section class="sub-hero download-hero">
      <picture>
        <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-sp.svg" media="(max-width: 430px)">
        <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-wide.svg" media="(min-width: 1441px)">
        <img class="sub-hero__map download-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true"
          width="1280" height="500" />
      </picture>
      <div class="wrapper sub-hero__inner download-hero__inner">
        <svg class="sub-hero__eyebrow download-hero__eyebrow" viewBox="0 0 220 70" role="img" aria-label="DOWNLOAD">
          <path id="download-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#download-hero-eyebrow-arc" startOffset="50%">DOWNLOAD</textPath>
          </text>
        </svg>
        <h1 class="sub-hero__heading download-hero__heading">Download</h1>
        <nav class="breadcrumb download-hero__breadcrumb" aria-label="Breadcrumb">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>
            <li class="breadcrumb__item" aria-current="page">
              Download
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- ===== Download ===== -->
    <section class="download">
      <div class="wrapper download__inner">
        <img class="download__mockup" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/img-download-en.webp"
          alt="The Langmate app on a phone screen. Over 4M downloads. Free to download." width="613" height="944" />

        <div class="download__stores">
          <!-- iPhone -->
          <div class="download__store">
            <span class="download__store-label">iPhone</span>
            <span class="download__store-lead">Download here</span>
            <span class="download__store-arrow" aria-hidden="true"></span>
            <div class="download__store-card">
              <a class="btn btn--store" href="<?php echo esc_url( $appstore_url ); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-appstore-en.svg" alt="Download from the App Store" width="160" height="48" />
              </a>
              <img class="download__store-qr" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/qr-appstore.png"
                alt="QR code linking to the App Store download page" width="240" height="240" />
            </div>
          </div>

          <!-- Android -->
          <div class="download__store">
            <span class="download__store-label">Android</span>
            <span class="download__store-lead">Download here</span>
            <span class="download__store-arrow" aria-hidden="true"></span>
            <div class="download__store-card">
              <a class="btn btn--store" href="<?php echo esc_url( $googleplay_url ); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-googleplay-en.svg" alt="Get it on Google Play" width="160" height="48" />
              </a>
              <img class="download__store-qr" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/qr-googleplay.png"
                alt="QR code linking to the Google Play download page" width="240" height="240" />
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
