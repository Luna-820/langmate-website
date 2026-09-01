<?php
/**
 * page.php
 *
 * カスタムテンプレートを指定していない固定ページ全般のデフォルトテンプレート。
 * 各ページの translation_key と言語(ja/en)から、対応する
 * template-parts/page-body-{key}-{lang}.php を呼び出すだけの薄いディスパッチャー。
 * ページ固有のマークアップは各 page-body ファイル側に持たせる
 * （既存の静的HTMLのデザイン・DOM構造・class名をそのまま踏襲するため）。
 */

get_header();

$langmate_lang = langmate_get_current_language();
$langmate_key  = is_page() ? get_post_meta( get_queried_object_id(), 'translation_key', true ) : '';

$langmate_part = 'template-parts/page-body-' . sanitize_key( $langmate_key );

if ( $langmate_key && locate_template( $langmate_part . '-' . $langmate_lang . '.php' ) ) {
	get_template_part( $langmate_part, $langmate_lang );
} else {
	// 対応するpage-bodyがまだ無い場合のフォールバック（タイトル＋本文をそのまま出す）
	?>
	<main id="main">
		<div class="wrapper">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<h1><?php the_title(); ?></h1>
				<div><?php the_content(); ?></div>
				<?php
			endwhile;
			?>
		</div>
	</main>
	<?php
}

get_footer();
