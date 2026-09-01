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

// URLの ?q= があれば検索結果表示、無ければ ?faq_cat= で選択中の親カテゴリーを切り替える。
// どちらも無い時は「All FAQs」(faq_featuredでピン留めした投稿の一覧)を表示する。
$search_query = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$is_search    = ( '' !== $search_query );

$parents = langmate_get_faq_parent_categories();

$requested_slug = isset( $_GET['faq_cat'] ) ? sanitize_title( wp_unslash( $_GET['faq_cat'] ) ) : '';
$active_parent  = null;

if ( ! $is_search ) {
	foreach ( $parents as $parent ) {
		if ( $parent->slug === $requested_slug ) {
			$active_parent = $parent;
			break;
		}
	}
}

$hero_breadcrumb = array(
	array(
		'label' => 'HOME',
		'url'   => langmate_get_page_url( 'home', $lang ),
	),
	array(
		'label' => 'FAQ',
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
			'active_slug'  => $active_parent ? $active_parent->slug : '',
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
	<!-- 「All FAQs」選択時: faq_featuredでピン留めされた投稿をカテゴリー横断で1グループ表示。
	     カテゴリー選択時: 選択中の親カテゴリー配下を、子カテゴリーごと(＋親に直接
	     タグ付けされた分は親自身の名前で)グループ分けして表示する。 -->
	<section class="faq-groups">
	  <div class="wrapper">
	    <?php
	    if ( $active_parent && ! is_wp_error( $active_parent ) ) {
	        $groups = langmate_get_faq_groups_for_parent( $active_parent, $lang );
	    } else {
	        $featured_posts = langmate_get_faq_featured_posts( $lang );
	        $groups         = $featured_posts ? array(
	            array(
	                'title' => langmate_get_faq_all_label( $lang ),
	                'posts' => $featured_posts,
	            ),
	        ) : array();
	    }

	    foreach ( $groups as $group ) : ?>
	    <div class="faq-group">
	      <h2 class="faq-group__title"><?php echo esc_html( $group['title'] ); ?></h2>
	      <ul class="faq-group__list">
	        <?php foreach ( $group['posts'] as $faq_post ) : ?>
	        <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
	        <?php endforeach; ?>
	      </ul>
	    </div>
	    <?php endforeach; ?>
	  </div>
	</section>
	<?php endif; ?>
</main>
