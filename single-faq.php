<?php
/**
 * single-faq.php
 *
 * FAQ投稿(カスタム投稿タイプ faq)の単体テンプレート。
 * support.html の #main 部分(Hero〜検索/カテゴリー〜FAQ詳細)を踏襲し、
 * 「1投稿 = 1つの.faq-detail__block」として投稿本文(the_content)をそのまま出力する。
 * ACFは使わず、見出し(h2/h3)・本文(p)は投稿エディタ側で自由に書いてもらう想定。
 */

get_header();

$lang      = langmate_get_current_language();
$theme_uri = get_template_directory_uri();

while ( have_posts() ) :
	the_post();

	$post_id = get_the_ID();

	// このFAQに割り当てられたカテゴリー(親/子)を取得
	$terms        = wp_get_post_terms( $post_id, 'faq_category' );
	$term         = ( ! is_wp_error( $terms ) && ! empty( $terms ) ) ? $terms[0] : null;
	$parent_term  = null;
	$child_term   = null;

	if ( $term ) {
		if ( $term->parent ) {
			$parent_term = get_term( $term->parent, 'faq_category' );
			$child_term  = $term;
		} else {
			$parent_term = $term;
		}
	}

	$archive_url      = langmate_get_faq_archive_url( $lang );
	$parent_slug      = $parent_term && ! is_wp_error( $parent_term ) ? $parent_term->slug : '';
	$parent_label     = $parent_term && ! is_wp_error( $parent_term ) ? langmate_get_faq_category_label( $parent_term, $lang ) : '';
	$parent_url       = $parent_slug ? langmate_get_faq_archive_url( $lang, $parent_slug ) : $archive_url;
	$child_label      = $child_term && ! is_wp_error( $child_term ) ? langmate_get_faq_category_label( $child_term, $lang ) : '';

	// サブヒーローのパンくず(サイト共通パターン): HOME > よくある質問 > 質問タイトル
	$hero_breadcrumb = array(
		array(
			'label' => 'HOME',
			'url'   => langmate_get_page_url( 'home', $lang ),
		),
		array(
			'label' => ( 'en' === $lang ) ? 'FAQ' : 'よくある質問',
			'url'   => $archive_url,
		),
		array(
			'label' => get_the_title(),
			'url'   => null,
		),
	);

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
			'lang'        => $lang,
			'active_slug' => $parent_slug,
		)
	);
	?>

	<!-- ===== FAQ詳細 =====
	     1つの.faq-detail__blockが1件のFAQ投稿に対応する(投稿本文をそのまま出力)。 -->
	<section class="faq-detail-section">
	  <div class="wrapper">
	    <div class="faq-detail">
	      <h1 class="faq-detail__title"><?php the_title(); ?></h1>

	      <nav class="faq-detail__breadcrumb" aria-label="<?php echo ( 'en' === $lang ) ? 'Breadcrumb' : 'パンくずリスト'; ?>">
	        <ol>
	          <li><a href="<?php echo esc_url( $archive_url ); ?>"><?php echo ( 'en' === $lang ) ? 'FAQ' : 'FAQ'; ?></a></li>
	          <?php if ( $parent_label ) : ?>
	          <li><a href="<?php echo esc_url( $parent_url ); ?>"><?php echo esc_html( $parent_label ); ?></a></li>
	          <?php endif; ?>
	          <?php if ( $child_label ) : ?>
	          <li><a href="<?php echo esc_url( $parent_url ); ?>"><?php echo esc_html( $child_label ); ?></a></li>
	          <?php endif; ?>
	          <li aria-current="page"><?php the_title(); ?></li>
	        </ol>
	      </nav>

	      <hr class="faq-detail__divider" />

	      <?php
	      $faq_content = apply_filters( 'the_content', get_the_content() );

	      // 「目次(セクションリンク)を表示する」がONの投稿だけ、本文のH3/H4から
	      // 自動でジャンプリンク付きの目次を組み立てて本文の直前に出す。
	      if ( get_post_meta( $post_id, 'faq_toc', true ) ) {
	          $toc_data    = langmate_faq_build_toc( $faq_content );
	          $faq_content = $toc_data['content'];
	          echo langmate_faq_render_toc( $toc_data['items'], $lang ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	      }
	      ?>

	      <article class="faq-detail__block">
	        <?php echo $faq_content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
	      </article>
	    </div>
	  </div>
	</section>
	<?php
endwhile;

get_footer();
