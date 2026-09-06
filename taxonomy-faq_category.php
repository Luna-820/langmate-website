<?php
/**
 * taxonomy-faq_category.php
 *
 * FAQカテゴリー(faq_category)のアーカイブページ。
 * /support/{category-slug}/(EN)・/ja/support/{category-slug}/(JA)で表示される。
 * デザインはhow-can-we-help一覧ページと共通(faq-hero・faq-search-categories・faq-groups)。
 * 子カテゴリーのアーカイブが直接開かれた場合も、そのターム自身の投稿一覧として表示する
 * (URL上は6つの親カテゴリーのみを想定しているが、テンプレート自体は親・子どちらでも動く)。
 */

get_header();

$lang       = langmate_get_current_language();
$term       = get_queried_object();
$label      = ( $term instanceof WP_Term ) ? langmate_get_faq_category_label( $term, $lang ) : '';
$hub_url    = langmate_get_faq_archive_url( $lang );
$hub_label  = ( 'en' === $lang ) ? 'FAQ TOP' : 'よくある質問TOP';
$theme_uri  = get_template_directory_uri();

$hero_breadcrumb = array(
	array(
		'label' => 'HOME',
		'url'   => langmate_get_page_url( 'home', $lang ),
	),
	array(
		'label' => $hub_label,
		'url'   => $hub_url,
	),
	array(
		'label' => $label,
		'url'   => null,
	),
);

get_template_part(
	'template-parts/faq-hero',
	null,
	array(
		'lang'        => $lang,
		'heading'     => $label,
		'heading_url' => $hub_url,
		'breadcrumb'  => $hero_breadcrumb,
	)
);

get_template_part(
	'template-parts/faq-search-categories',
	null,
	array(
		'lang'        => $lang,
		'active_slug' => ( $term instanceof WP_Term ) ? $term->slug : '',
	)
);

$groups = ( $term instanceof WP_Term ) ? langmate_get_faq_groups_for_parent( $term, $lang ) : array();
?>

<!-- ===== Groups =====
     このカテゴリー(親)に直接タグ付けされたFAQ ＋ 子カテゴリーごとのグループを、
     how-can-we-help一覧ページと同じ.faq-groups/.faq-groupの見た目で表示する。 -->
<section class="faq-groups">
  <div class="wrapper">
    <?php if ( $groups ) : ?>
      <?php foreach ( $groups as $group ) : ?>
      <div class="faq-group">
        <h2 class="faq-group__title"><?php echo esc_html( $group['title'] ); ?></h2>
        <ul class="faq-group__list">
          <?php foreach ( $group['posts'] as $faq_post ) : ?>
          <li class="faq-item"><a href="<?php echo esc_url( get_permalink( $faq_post ) ); ?>"><span class="faq-item__icon" aria-hidden="true">Q</span><?php echo esc_html( get_the_title( $faq_post ) ); ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="faq-group">
        <p><?php echo ( 'en' === $lang ) ? 'No FAQs in this category yet.' : 'このカテゴリーにはまだFAQがありません。'; ?></p>
      </div>
    <?php endif; ?>

    <div class="faq-group__more">
      <a class="faq-categories__item" href="<?php echo esc_url( $hub_url ); ?>">
        <span class="faq-categories__arrow" aria-hidden="true">◀︎</span><?php echo ( 'en' === $lang ) ? 'Back to FAQ TOP' : 'よくある質問TOPへ戻る'; ?>
      </a>
    </div>
  </div>
</section>

<?php
get_footer();
