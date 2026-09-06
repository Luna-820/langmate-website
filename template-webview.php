<?php
/**
 * Template Name: WebView(アプリ内ページ専用)
 *
 * アプリ内(WebView)から直接読み込まれる固定ページ専用テンプレート。
 * 対象(予定): 「アプリ内ページ」配下の お問い合わせ / プライバシーポリシー / 利用規約 の3枚。
 *
 * 通常のheader.php/footer.php(サイトナビ・言語切替・追従DLボタン等)は一切呼ばず、
 * 本文だけを最小限のHTMLで返す。理由:
 *   1. 現行仕様が「ナビなし・内部リンクなし」のため、それをそのまま踏襲する
 *   2. WebView内から外部リンク(App Store等)に飛ぶと、アプリ側の画面遷移が
 *      壊れる可能性があるため、そもそも追従DLボタン等の外部リンクを含む
 *      要素自体をこのテンプレートに載せない
 *   3. 検索結果に出てほしくないため noindex にする
 *
 * header.php側のfloating-dl出し分け(is_page_template('template-webview.php'))は、
 * 将来このテンプレートがget_header()を使う形に変わっても追従ボタンが
 * 出てしまわないようにするための保険。
 *
 * ---- 中身はWeb版と同じ内容を流用する ----
 * プライバシーポリシー・利用規約はWeb版(page-body-privacy-* および page-body-terms-*)と
 * 完全に同じ本文でよく、パンくず等の内部リンクも元々含まれていないため、
 * そのまま読み込んで使い回す(1箇所直せば両方に反映される)。
 * お問い合わせは、Web版のヒーロー部分(パンくず・「よくある質問はこちら」CTA)が
 * 「内部リンクなし」の方針に反するため、フォーム部分だけを抜き出した専用の
 * page-body-contact-webview-*.php を用意している。
 *
 * このテンプレートを選んだページ側で、translation_keyカスタムフィールドに
 * 以下のいずれかを入れておくこと(page.php側の固定ページと衝突しないよう、
 * Web版とは別のキーにしている):
 *   - privacy-policy-webview … プライバシーポリシー(page-body-privacy-*を流用)
 *   - terms-webview          … 利用規約(page-body-terms-*を流用)
 *   - contact-webview        … お問い合わせ(専用のpage-body-contact-webview-*)
 */

$langmate_lang = langmate_get_current_language();
$langmate_key  = is_page() ? get_post_meta( get_queried_object_id(), 'translation_key', true ) : '';

// Web版のpage-bodyをそのまま流用するもの(内部リンクを含まないページのみ)。
$langmate_webview_source_map = array(
	'privacy-policy-webview' => 'privacy',
	'terms-webview'          => 'terms',
);

$langmate_source_key = $langmate_webview_source_map[ $langmate_key ] ?? $langmate_key;
$langmate_part       = 'template-parts/page-body-' . sanitize_key( $langmate_source_key );
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex, nofollow">
<title><?php echo esc_html( get_the_title() ); ?></title>
<?php wp_head(); ?>
</head>
<body <?php body_class( 'webview-page' ); ?>>

<?php
if ( $langmate_source_key && locate_template( $langmate_part . '-' . $langmate_lang . '.php' ) ) {
	get_template_part( $langmate_part, $langmate_lang );
} else {
	// 対応するpage-bodyがまだ無い場合のフォールバック(タイトル＋本文をそのまま出す)
	?>
<main id="main" class="webview-page__main">
  <div class="wrapper">
    <?php
    while ( have_posts() ) :
        the_post();
        ?>
    <h1 class="webview-page__title"><?php the_title(); ?></h1>
    <div class="webview-page__content"><?php the_content(); ?></div>
        <?php
    endwhile;
    ?>
  </div>
</main>
	<?php
}
?>

<?php wp_footer(); ?>
</body>
</html>
