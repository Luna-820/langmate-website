<?php
/**
 * template-parts/mobile-nav.php
 *
 * header.php から get_template_part() の $args 経由で
 * 'nav_items' / 'lang' / 'current_key' を受け取る。
 */

$nav_items   = $args['nav_items'] ?? array();
$lang        = $args['lang'] ?? 'ja';
$current_key = $args['current_key'] ?? '';
$theme_uri   = get_template_directory_uri();
?>
<div class="mobile-nav" id="mobile-nav" data-mobile-nav hidden>
  <nav aria-label="<?php echo ( 'en' === $lang ) ? 'Mobile navigation' : 'モバイルナビゲーション'; ?>">
    <ul class="mobile-nav__list">
      <?php foreach ( $nav_items as $item ) :
        $url   = langmate_get_page_url( $item['key'], $lang );
        $label = ( 'en' === $lang ) ? $item['label_en'] : $item['label_ja'];
        $is_current = ( $current_key === $item['key'] );
      ?>
      <li><a href="<?php echo esc_url( $url ); ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a></li>
      <?php endforeach; ?>
    </ul>
  </nav>
  <div class="mobile-nav__sns">
    <!-- <p>公式SNSはこちら<span aria-hidden="true">&#x25BC;</span></p> -->
    <div class="sns__icons"><a href="https://www.instagram.com/langmate_app" target="_blank" rel="noopener"><img
          src="<?php echo esc_url( $theme_uri ); ?>/design-assets/logo-instagram.svg" alt="Instagram" width="24" height="24" /></a>
      <a href="https://x.com/LANGMATE_APP" target="_blank" rel="noopener"><img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/logo-x.svg" alt="X" width="24" height="24" /></a>
      <a href="https://www.tiktok.com/@questions_about_japan" target="_blank" rel="noopener"><img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/logo-tiktok.svg" alt="TikTok"
          width="24" height="24" /></a>
    </div>

  </div>
  <a class="mobile-nav__download" href="#download" data-mobile-download>
    <span><?php echo ( 'en' === $lang ) ? 'Download Here' : 'ダウンロードはこちら'; ?></span>
    <img class="mobile-nav__download-icon" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-DL.svg" alt="" aria-hidden="true">
  </a>
</div>
