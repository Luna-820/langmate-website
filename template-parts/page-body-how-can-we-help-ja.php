<?php
/**
 * template-parts/page-body-how-can-we-help-ja.php
 *
 * 「よくある質問」一覧ページ。
 * デザイン・DOM構造・class名は既存の how-can-we-help.html を踏襲したまま、
 * カテゴリー(faq_category タクソノミー)・FAQ投稿(faq)を動的にクエリして描画する。
 * Hero・検索/カテゴリーナビは template-parts/faq-hero.php・
 * template-parts/faq-search-categories.php と共通化している。
 */

$lang      = 'ja';
$theme_uri = get_template_directory_uri();

// URLの ?q= があれば検索結果表示、無ければ全カテゴリーの一覧(1カテゴリーあたり
// 最大5件＋もっと見る)を表示する。カテゴリー単体の全件表示は
// /ja/support/{category}/ の実アーカイブページ(taxonomy-faq_category.php)側の役割。
$search_query = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$is_search    = ( '' !== $search_query );

$parents       = langmate_get_faq_parent_categories();
$preview_limit = 5;

// 「よくある質問」ボタンの表示名(設定 > FAQ表示設定)と同じ名前の
// FAQカテゴリーが存在すると、featured枠(下記)とこのカテゴリーの
// グループが同じタイトル「よくある質問」で並んで表示され、同じ質問が
// 二重に出ているように見えてしまう。そのカテゴリーだけはここで除外する
// (カテゴリー自体やFAQへの分類は残したまま、このグループ表示だけ省く)。
//
// 日本語名・英語名(name_en)のどちらか一方だけがラベルと一致するケースも
// 除外できるよう、表示中の言語だけでなく両言語のラベルと突き合わせる
// (例: カテゴリーの日本語名は「よくある質問」のままでも、name_enだけ
// 「General」に変更されていると、英語ページ側では一致判定をすり抜けて
// しまっていた)。
// 除外したカテゴリーは、featured枠の「もっと見る」リンク先として再利用する
// (featured枠自体には専用のアーカイブページが無いため。実運用上、同名の
// このカテゴリーにfeatured対象のFAQもまとめて分類してもらう想定)。
$faq_all_label_ja      = langmate_get_faq_all_label( 'ja' );
$faq_all_label_en      = langmate_get_faq_all_label( 'en' );
$featured_archive_term = null;
$filtered_parents      = array();
foreach ( $parents as $parent ) {
	$name_en = get_term_meta( $parent->term_id, 'name_en', true );
	$is_all_faqs_category = ( $parent->name === $faq_all_label_ja )
		|| ( $name_en && $name_en === $faq_all_label_en );

	if ( $is_all_faqs_category ) {
		$featured_archive_term = $parent;
		continue;
	}

	$filtered_parents[] = $parent;
}
$parents = $filtered_parents;

$hero_breadcrumb = array(
	array(
		'label' => 'HOME',
		'url'   => langmate_get_page_url( 'home', $lang ),
	),
	array(
		'label' => 'よくある質問TOP',
		'url'   => null,
	),
);
?>

<main id="main">
	<?php
	get_template_part(
		'template-parts/faq-hero',
		null,
		array(
			'lang'       => $lang,
			'breadcrumb' => $hero_breadcrumb,
		)
	);

	get_template_part(
		'template-parts/faq-search-categories',
		null,
		array(
			'lang'         => $lang,
			'active_slug'  => '',
			'is_search'    => $is_search,
			'search_query' => $search_query,
		)
	);

	if ( $is_search ) :
		$search_results = langmate_search_faq_posts( $search_query, $lang );
		?>
	<!-- ===== 検索結果 ===== -->
	<section class="faq-groups">
	  <div class="wrapper">
	    <div class="faq-group">
	      <h2 class="faq-group__title">「<?php echo esc_html( $search_query ); ?>」の検索結果(<?php echo count( $search_results ); ?>件)</h2>
	      <?php if ( $search_results ) : ?>
	      <ul class="faq-group__list">
	        <?php foreach ( $search_results as $faq_post ) : ?>
	        <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	      <?php else : ?>
	      <p>該当するFAQが見つかりませんでした。別のキーワードでお試しください。</p>
	      <?php endif; ?>
	    </div>
	  </div>
	</section>
	<?php else : ?>

	<!-- ===== Groups ===== -->
	<!-- 「よくある質問」: faq_featuredでピン留めされた投稿をカテゴリー横断で1グループ表示。
	     続けて、全カテゴリーをそれぞれ最大<?php echo (int) $preview_limit; ?>件までのプレビューで表示し、
	     それ以上ある場合は/ja/support/{category}/の実アーカイブページへの「もっと見る」リンクを出す。 -->
	<section class="faq-groups">
	  <div class="wrapper">
	    <?php
	    $featured_posts         = langmate_get_faq_featured_posts( $lang );
	    $featured_total_count   = count( $featured_posts );
	    $featured_preview_posts = array_slice( $featured_posts, 0, $preview_limit );
	    if ( $featured_posts ) :
	    ?>
	    <div class="faq-group">
	      <h2 class="faq-group__title"><?php echo esc_html( langmate_get_faq_all_label( $lang ) ); ?></h2>
	      <ul class="faq-group__list">
	        <?php foreach ( $featured_preview_posts as $faq_post ) : ?>
	        <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	      <?php if ( $featured_total_count > $preview_limit && $featured_archive_term ) : ?>
	      <div class="faq-group__more">
	        <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_faq_category_archive_url( $featured_archive_term, $lang ) ); ?>">
	          <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>もっと見る
	        </a>
	      </div>
	      <?php endif; ?>
	    </div>
	    <?php endif; ?>

	    <?php foreach ( $parents as $parent ) :
	        $category_posts = langmate_get_faq_posts_by_term( $parent->term_id, $lang, true );
	        if ( ! $category_posts ) {
	            continue;
	        }
	        $total_count   = count( $category_posts );
	        $preview_posts = array_slice( $category_posts, 0, $preview_limit );
	    ?>
	    <div class="faq-group">
	      <h2 class="faq-group__title"><?php echo esc_html( langmate_get_faq_category_label( $parent, $lang ) ); ?></h2>
	      <ul class="faq-group__list">
	        <?php foreach ( $preview_posts as $faq_post ) : ?>
	        <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	      <?php if ( $total_count > $preview_limit ) : ?>
	      <div class="faq-group__more">
	        <a class="faq-categories__item" href="<?php echo esc_url( langmate_get_faq_category_archive_url( $parent, $lang ) ); ?>">
	          <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>もっと見る
	        </a>
	      </div>
	      <?php endif; ?>
	    </div>
	    <?php endforeach; ?>
	  </div>
	</section>
	<?php endif; ?>
</main>
