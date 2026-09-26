<?php
/**
 * template-parts/contact-notice.php
 *
 * お問い合わせフォーム直上に出す、障害・注意お知らせバナー。
 * Web版(page-body-contact-*.php)・WebView版(page-body-contact-webview-*.php)、
 * 日英とも共通で呼び出す。表示内容は設定画面(設定 → お問い合わせ お知らせ設定)。
 * OFF、または本文が空の時は「通常時文言」を表示し、常に何らかの
 * ステータスが見える状態にする。
 *
 * $args:
 *   lang : 'ja' | 'en'
 */

$lang   = $args['lang'] ?? 'ja';
$notice = langmate_get_contact_notice( $lang );
$badge  = langmate_get_contact_notice_badge_label( $notice['type'], $lang );
?>
<div class="contact-notice contact-notice--<?php echo esc_attr( $notice['type'] ); ?>">
  <span class="contact-notice__badge"><?php echo esc_html( $badge ); ?></span>
  <p class="contact-notice__text"><?php echo nl2br( esc_html( $notice['text'] ) ); ?></p>
</div>
