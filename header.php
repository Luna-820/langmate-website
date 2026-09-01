<?php
/**
 * header.php
 *
 * <head>〜サイトヘッダー〜モバイルナビ〜floating-dl まで。
 * 既存の静的HTML（index.html等）のDOM構造・class名はそのまま踏襲し、
 * パス・リンク先・言語切り替え部分のみPHP化している。
 */

$langmate_lang       = langmate_get_current_language();
$langmate_theme_uri  = get_template_directory_uri();
$langmate_nav_items  = langmate_get_nav_items();
$langmate_current_key = is_page() ? get_post_meta( get_queried_object_id(), 'translation_key', true ) : '';
if ( is_singular( 'faq' ) ) {
	// FAQ詳細ページでは「よくある質問」のナビ項目をカレント扱いにする
	$langmate_current_key = 'how-can-we-help';
}
?>
<!DOCTYPE html>
<html lang="<?php echo esc_attr( $langmate_lang ); ?>">

<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/logo-langmate.svg" />

  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <a class="skip-link" href="#main"><?php echo ( 'en' === $langmate_lang ) ? 'Skip to main content' : 'メインコンテンツへスキップ'; ?></a>

  <header class="site-header">
    <div class="site-header__inner">
      <a class="site-header__logo" href="<?php echo esc_url( langmate_get_page_url( 'home', $langmate_lang ) ); ?>">
        <img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/logo-langmate.svg" alt="Langmate" width="140" height="40" />
      </a>

      <nav class="global-nav" aria-label="<?php echo ( 'en' === $langmate_lang ) ? 'global navigation' : 'グローバルナビゲーション'; ?>">
        <ul class="global-nav__list">
          <?php foreach ( $langmate_nav_items as $item ) :
            $url   = langmate_get_page_url( $item['key'], $langmate_lang );
            $label = ( 'en' === $langmate_lang ) ? $item['label_en'] : $item['label_ja'];
            $is_current = ( $langmate_current_key === $item['key'] );
          ?>
          <li><a href="<?php echo esc_url( $url ); ?>"<?php echo $is_current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $label ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div class="site-header__actions">
        <div class="language-switcher" data-language-switcher>
          <button class="language-switcher__trigger" type="button" aria-haspopup="listbox" aria-expanded="false"
            aria-controls="language-switcher-list">
            <img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/flag-<?php echo ( 'en' === $langmate_lang ) ? 'us' : 'jp'; ?>.svg" alt="" width="24" height="24" />
            <span class="visually-hidden"><?php echo ( 'en' === $langmate_lang ) ? 'Language' : '言語を選択'; ?></span>
            <span class="language-switcher__caret" aria-hidden="true"></span>
          </button>
          <ul class="language-switcher__list" id="language-switcher-list" role="listbox" hidden>
            <li role="option" data-lang="ja" aria-selected="<?php echo ( 'ja' === $langmate_lang ) ? 'true' : 'false'; ?>">
              <a href="<?php echo esc_url( langmate_get_translation_url( 'ja' ) ); ?>">
                <img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/flag-jp.svg" alt="" width="20" height="20" />日本語
              </a>
            </li>
            <li role="option" data-lang="en" aria-selected="<?php echo ( 'en' === $langmate_lang ) ? 'true' : 'false'; ?>">
              <a href="<?php echo esc_url( langmate_get_translation_url( 'en' ) ); ?>">
                <img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/flag-us.svg" alt="" width="20" height="20" />English
              </a>
            </li>
          </ul>
        </div>

        <button class="hamburger" type="button" aria-expanded="false" aria-controls="mobile-nav"
          data-mobile-nav-trigger>
          <span class="visually-hidden"><?php echo ( 'en' === $langmate_lang ) ? 'Menu' : 'メニューを開く'; ?></span>
          <span class="hamburger__line hamburger__line--top" aria-hidden="true"></span>
          <span class="hamburger__line hamburger__line--middle" aria-hidden="true"></span>
          <span class="hamburger__line hamburger__line--bottom" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </header>

  <?php get_template_part( 'template-parts/mobile-nav', null, array( 'nav_items' => $langmate_nav_items, 'lang' => $langmate_lang, 'current_key' => $langmate_current_key ) ); ?>

  <?php get_template_part( 'template-parts/floating-dl', null, array( 'lang' => $langmate_lang ) ); ?>
