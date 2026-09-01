<?php
/**
 * footer.php
 *
 * 既存の静的HTML（index.html等）のsite-footerブロックをそのまま踏襲。
 * DOM構造・class名は不変、パスと言語依存テキストのみPHP化している。
 */

$langmate_lang      = langmate_get_current_language();
$langmate_theme_uri = get_template_directory_uri();
$langmate_nav_items = langmate_get_nav_items();

$langmate_brand_tagline = ( 'en' === $langmate_lang )
	? 'Meet People in Japan. Make Real Friends.'
	: '外国人の友達になれる国際交流アプリ';

$langmate_badge_suffix   = ( 'en' === $langmate_lang ) ? 'en' : 'ja';
$langmate_appstore_alt   = ( 'en' === $langmate_lang ) ? 'Download from the App Store' : 'App Storeからダウンロード';
$langmate_googleplay_alt = ( 'en' === $langmate_lang ) ? 'Get it on Google Play' : 'Google Playで手に入れよう';
$langmate_sns_label      = ( 'en' === $langmate_lang ) ? 'Follow Us on Social Media' : '公式SNSはこちら';
?>
  <footer class="site-footer">
    <div class="site-footer__inner">
      <div class="site-footer__brand">
        <p><?php echo esc_html( $langmate_brand_tagline ); ?></p>
        <img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/logo-langmate.svg" alt="Langmate" />
        <div class="site-footer__badges">
          <a href="https://apps.apple.com/us/app/langmate-japanese-friends/id1093968775" target="_blank" rel="noopener"><img
              src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/badge-appstore-<?php echo esc_attr( $langmate_badge_suffix ); ?>.svg" alt="<?php echo esc_attr( $langmate_appstore_alt ); ?>" width="120" height="36" /></a>
          <a href="https://play.google.com/store/apps/details?id=co.thoron.langmate" target="_blank" rel="noopener"><img
              src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/badge-googleplay-<?php echo esc_attr( $langmate_badge_suffix ); ?>.svg" alt="<?php echo esc_attr( $langmate_googleplay_alt ); ?>" width="120" height="36" /></a>
        </div>
      </div>

      <nav class="site-footer__nav" aria-label="<?php echo ( 'en' === $langmate_lang ) ? 'Footer navigation' : 'フッターナビゲーション'; ?>">
        <ul>
          <?php foreach ( $langmate_nav_items as $index => $item ) :
            $url   = langmate_get_page_url( $item['key'], $langmate_lang );
            $label = ( 'en' === $langmate_lang ) ? $item['label_en'] : $item['label_ja'];
            // フッターだけ FAQ→FAQs、Contact→Contact Us の表記(既存静的HTMLの慣例)
            if ( 'en' === $langmate_lang ) {
              if ( 'how-can-we-help' === $item['key'] ) {
                $label = 'FAQs';
              } elseif ( 'contact' === $item['key'] ) {
                $label = 'Contact Us';
              }
            }
            $is_home_item = ( 0 === $index );
          ?>
          <li<?php echo $is_home_item ? ' class="site-footer__nav-home"' : ''; ?>><a href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $label ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </nav>

      <div class="site-footer__sns">
        <!-- <p><?php echo esc_html( $langmate_sns_label ); ?></p> -->
        <div>
          <a href="https://www.instagram.com/langmate_app" target="_blank" rel="noopener"><img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/logo-instagram.svg" alt="Instagram"
              width="24" height="24" /></a>
          <a href="https://x.com/LANGMATE_APP" target="_blank" rel="noopener"><img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/logo-x.svg" alt="X" width="24" height="24" /></a>
          <a href="https://www.tiktok.com/@questions_about_japan" target="_blank" rel="noopener"><img src="<?php echo esc_url( $langmate_theme_uri ); ?>/design-assets/logo-tiktok.svg" alt="TikTok"
              width="24" height="24" /></a>
        </div>
      </div>
    </div>
    <nav class="site-footer__legal" aria-label="法的情報">
      <a href="<?php echo esc_url( langmate_get_page_url( 'terms', $langmate_lang ) ); ?>"><?php echo ( 'en' === $langmate_lang ) ? 'Terms of Service' : '利用規約'; ?></a>
      <a href="<?php echo esc_url( langmate_get_page_url( 'privacy', $langmate_lang ) ); ?>"><?php echo ( 'en' === $langmate_lang ) ? 'Privacy Policy' : 'プライバシーポリシー'; ?></a>
    </nav>
    <p class="site-footer__copyright">Copyright &copy; 2026 Langmate Inc.</p>
  </footer>

  <?php wp_footer(); ?>
</body>

</html>
