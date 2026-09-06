<?php
/**
 * template-parts/floating-dl.php
 *
 * header.php から get_template_part() の $args 経由で 'lang' を受け取る。
 *
 * リンク先は /app/ のスマートリンク(OS判定でストアへ振り分ける専用ページ、
 * 新規作成予定)に統一する。600px以下(SP)は従来通りApp Store/Google Play
 * バッジ2つを表示、601px以上(PC/タブレット)はQRコード表示に切り替える。
 *
 * QRコードはApp Store用・Google Play用の2つ(スマホで見分けなくても
 * どちらを読み取ればいいか分かるように)。画像は後日差し替え予定なので、
 * 今は枠だけ用意している。QR自体はストアへ直接飛ばしたいものなので、
 * リンク先も(/app/ではなく)各ストアの直接URLにしている。
 */

$lang      = $args['lang'] ?? 'ja';
$theme_uri = get_template_directory_uri();

// /app/ はまだ実体が無い(新規作成予定)が、リンク先としては先にここへ統一しておく。
$app_link = home_url( '/app/' );

// QRコードは「どちらを読み取るか」が画像自体で分かるものなので、
// /app/を経由せず各ストアへ直接。
$appstore_url   = 'https://apps.apple.com/jp/app/langmate-%E8%8B%B1%E4%BC%9A%E8%A9%B1%E3%81%A8%E5%A4%96%E5%9B%BD%E4%BA%BA%E3%81%AE%E5%8F%8B%E9%81%94%E4%BD%9C%E3%82%8A/id1093968775';
$googleplay_url = 'https://play.google.com/store/apps/details?id=co.thoron.langmate';

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
