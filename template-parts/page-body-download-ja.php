<?php
/**
 * template-parts/page-body-download-ja.php
 *
 * ダウンロードページ本文（日）。
 * heroは他の下層ページ（会社概要・お問い合わせ等）と同じ .sub-hero 共通
 * コンポーネントを流用。メインはスマホモックアップ画像 + iPhone/Android
 * それぞれのストアバッジ・QRコード。
 * QR/バッジのリンク先は functions.php の LANGMATE_APPSTORE_URL /
 * LANGMATE_GOOGLEPLAY_URL に集約。
 */

$lang      = 'ja';
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
          <!-- about-hero/get-startedと同じアーチ構造・半径を流用 -->
          <path id="download-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#download-hero-eyebrow-arc" startOffset="50%">DOWNLOAD</textPath>
          </text>
        </svg>
        <h1 class="sub-hero__heading download-hero__heading">ダウンロード</h1>
        <nav class="breadcrumb download-hero__breadcrumb" aria-label="パンくずリスト">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>
            <li class="breadcrumb__item" aria-current="page">
              ダウンロード
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- ===== Download ===== -->
    <section class="download">
      <div class="wrapper download__inner">
        <img class="download__mockup" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/img-download.webp"
          alt="Langmateアプリのスマホ画面。累計400万ダウンロード突破、ダウンロードは無料。" width="613" height="944" />

        <div class="download__stores">
          <!-- iPhone -->
          <div class="download__store">
            <span class="download__store-label">iPhone</span>
            <span class="download__store-lead">ダウンロードはこちら</span>
            <span class="download__store-arrow" aria-hidden="true"></span>
            <div class="download__store-card">
              <a class="btn btn--store" href="<?php echo esc_url( $appstore_url ); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-appstore-ja.svg" alt="App Storeからダウンロード" width="160" height="48" />
              </a>
              <img class="download__store-qr" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/qr-appstore.png"
                alt="App Storeのダウンロードページを開くQRコード" width="240" height="240" />
            </div>
          </div>

          <!-- Android -->
          <div class="download__store">
            <span class="download__store-label">Android</span>
            <span class="download__store-lead">ダウンロードはこちら</span>
            <span class="download__store-arrow" aria-hidden="true"></span>
            <div class="download__store-card">
              <a class="btn btn--store" href="<?php echo esc_url( $googleplay_url ); ?>" target="_blank" rel="noopener">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-googleplay-ja.svg" alt="Google Playで手に入れよう" width="160" height="48" />
              </a>
              <img class="download__store-qr" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/qr-googleplay.png"
                alt="Google Playのダウンロードページを開くQRコード" width="240" height="240" />
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
