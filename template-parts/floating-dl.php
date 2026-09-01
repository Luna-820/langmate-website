<?php
/**
 * template-parts/floating-dl.php
 *
 * header.php から get_template_part() の $args 経由で 'lang' を受け取る。
 */

$lang      = $args['lang'] ?? 'ja';
$theme_uri = get_template_directory_uri();

$badge_suffix = ( 'en' === $lang ) ? 'en' : 'ja';
$appstore_alt = ( 'en' === $lang ) ? 'Download from the App Store' : 'App Storeからダウンロード';
$googleplay_alt = ( 'en' === $lang ) ? 'Get it on Google Play' : 'Google Playで手に入れよう';
?>
<div class="floating-dl" data-floating-dl>
  <div class="floating-dl__box">

    <button class="floating-dl__trigger" type="button" aria-expanded="false" aria-controls="floating-dl-panel"
      data-floating-dl-trigger>
      <span class="floating-dl__text">Download</span> <img class="floating-dl__icon" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-DL.svg"
        alt="" aria-hidden="true" />
    </button>

    <div class="floating-dl__panel" id="floating-dl-panel">
      <a href="https://apps.apple.com/us/app/langmate-japanese-friends/id1093968775" target="_blank" rel="noopener" class="btn btn--store"
        target="_blank" rel="noopener">
        <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-appstore-<?php echo esc_attr( $badge_suffix ); ?>.svg" alt="<?php echo esc_attr( $appstore_alt ); ?>" width="160" height="48" />
      </a>

      <a href="https://play.google.com/store/apps/details?id=co.thoron.langmate" target="_blank" rel="noopener" class="btn btn--store"
        target="_blank" rel="noopener">
        <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-googleplay-<?php echo esc_attr( $badge_suffix ); ?>.svg" alt="<?php echo esc_attr( $googleplay_alt ); ?>" width="160" height="48" />
      </a>
    </div>

  </div>
</div>
