<?php
/**
 * template-parts/page-body-how-can-we-help-en.php
 *
 * 「よくある質問」一覧ページ(EN)。
 * デザイン・DOM構造・class名は既存の en/how-can-we-help.html を踏襲したまま、
 * カテゴリー(faq_category タクソノミー)・FAQ投稿(faq)を動的にクエリして描画する。
 * Hero・検索/カテゴリーナビは template-parts/faq-hero.php・
 * template-parts/faq-search-categories.php と共通化している。
 */

$lang      = 'en';
$theme_uri = get_template_directory_uri();

// URLの ?q= があれば検索結果表示、無ければ全カテゴリーの一覧(1カテゴリーあたり
// 最大5件＋もっと見る)を表示する。カテゴリー単体の全件表示は
// /support/{category}/ の実アーカイブページ(taxonomy-faq_category.php)側の役割。
$search_query = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$is_search    = ( '' !== $search_query );

$parents       = langmate_get_faq_parent_categories();
$preview_limit = 5;

$hero_breadcrumb = array(
	array(
		'label' => 'HOME',
		'url'   => langmate_get_page_url( 'home', $lang ),
	),
	array(
		'label' => 'FAQ TOP',
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
	<!-- ===== Search results ===== -->
	<section class="faq-groups">
	  <div class="wrapper">
	    <div class="faq-group">
	      <h2 class="faq-group__title">Search results for "<?php echo esc_html( $search_query ); ?>" (<?php echo count( $search_results ); ?>)</h2>
	      <?php if ( $search_results ) : ?>
	      <ul class="faq-group__list">
	        <?php foreach ( $search_results as $faq_post ) : ?>
	        <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	      <?php else : ?>
	      <p>No matching FAQs found. Please try a different keyword.</p>
	      <?php endif; ?>
	    </div>
	  </div>
	</section>
	<?php else : ?>

	<!-- ===== Groups ===== -->
	<!-- 「All FAQs」: faq_featuredでピン留めされた投稿をカテゴリー横断で1グループ表示。
	     続けて、全カテゴリーをそれぞれ最大<?php echo (int) $preview_limit; ?>件までのプレビューで表示し、
	     それ以上ある場合は/support/{category}/の実アーカイブページへの「See more」リンクを出す。 -->
	<section class="faq-groups">
	  <div class="wrapper">
	    <?php
	    $featured_posts = langmate_get_faq_featured_posts( $lang );
	    if ( $featured_posts ) :
	    ?>
	    <div class="faq-group">
	      <h2 class="faq-group__title"><?php echo esc_html( langmate_get_faq_all_label( $lang ) ); ?></h2>
	      <ul class="faq-group__list">
	        <?php foreach ( $featured_posts as $faq_post ) : ?>
	        <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	    </div>
	    <?php endif; ?>

	    <?php foreach ( $parents as $parent ) :
	        $category_posts = langmate_get_faq_posts_by_term( $parent->term_id, $lang, true );
	        if ( ! $category_posts ) {
	            continue;
	        }
	        $total_count  = count( $category_posts );
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
	          <span class="faq-categories__arrow" aria-hidden="true">▶︎</span>See more
	        </a>
	      </div>
	      <?php endif; ?>
	    </div>
	    <?php endforeach; ?>
	  </div>
	</section>
	<?php endif; ?>
</main>
