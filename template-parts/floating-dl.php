<?php
/**
 * template-parts/floating-dl.php
 *
 * header.php から get_template_part() の $args 経由で 'lang' を受け取る。
 *
 * 600px以下(SP)はApp Store/Google Playバッジ2つを表示、601px以上
 * (PC/タブレット)はQRコード表示に切り替える。どちらもリンク先は
 * 各ストアの直接URL(中継ページは挟まない。理由はjs/floating-dl.js
 * 冒頭コメント参照)。
 *
 * QRコードはApp Store用・Google Play用の2つ(スマホで見分けなくても
 * どちらを読み取ればいいか分かるように)。
 */

$lang      = $args['lang'] ?? 'ja';
$theme_uri = get_template_directory_uri();

$appstore_url   = LANGMATE_APPSTORE_URL;
$googleplay_url = LANGMATE_GOOGLEPLAY_URL;

$badge_suffix   = ( 'en' === $lang ) ? 'en' : 'ja';
$appstore_alt   = ( 'en' === $lang ) ? 'Download from the App Store' : 'App Storeからダウンロード';
$googleplay_alt = ( 'en' === $lang ) ? 'Get it on Google Play' : 'Google Playで手に入れよう';
?>
<div class="floating-dl" data-floating-dl>
  <div class="floating-dl__box">

    <button class="floating-dl__trigger" type="button" aria-expanded="false" aria-controls="floating-dl-panel"
      data-floating-dl-trigger>
      <span class="floating-dl__text">Download</span> <img class="floating-dl__icon" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-DL.svg"
        alt="" aria-hidden="true" />
    </button>

    <!-- 600px以下: ストアバッジ2つ(iOS/Androidを自動判定できない端末向けのフォールバック) -->
    <div class="floating-dl__panel floating-dl__panel--store" id="floating-dl-panel">
      <a href="<?php echo esc_url( $appstore_url  ); ?>" class="btn btn--store">
        <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-appstore-<?php echo esc_attr( $badge_suffix ); ?>.svg" alt="<?php echo esc_attr( $appstore_alt ); ?>" width="160" height="48" />
      </a>

      <a href="<?php echo esc_url( $googleplay_url ); ?>" class="btn btn--store">
        <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-googleplay-<?php echo esc_attr( $badge_suffix ); ?>.svg" alt="<?php echo esc_attr( $googleplay_alt ); ?>" width="160" height="48" />
      </a>
    </div>

    <!-- 601px以上: QRコード(App Store用・Google Play用の2つ) -->
    <div class="floating-dl__panel floating-dl__panel--qr">
      <a class="floating-dl__qr" href="<?php echo esc_url( $appstore_url ); ?>" target="_blank" rel="noopener">
        <span class="floating-dl__qr-frame">
          <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/qr-appstore.png" alt="<?php echo esc_attr( $appstore_alt ); ?>" width="400" height="400" />
        </span>
        <span class="floating-dl__qr-caption">App Store</span>
      </a>

      <a class="floating-dl__qr" href="<?php echo esc_url( $googleplay_url ); ?>" target="_blank" rel="noopener">
        <span class="floating-dl__qr-frame">
          <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/qr-googleplay.png" alt="<?php echo esc_attr( $googleplay_alt ); ?>" width="400" height="400" />
        </span>
        <span class="floating-dl__qr-caption">Google Play</span>
      </a>
    </div>

  </div>
</div>
