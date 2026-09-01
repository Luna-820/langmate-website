<?php
/**
 * template-parts/faq-search-categories.php
 *
 * FAQ一覧(how-can-we-help)・FAQ詳細(single-faq)で共通の
 * 検索フォーム＋カテゴリーナビ(.faq-search-section)。
 * カテゴリーは faq_category タクソノミーの親タームを動的に出力する
 * (子タームは選択中の親カテゴリー配下として一覧ページ側でグループ表示する)。
 *
 * $args:
 *   lang        : 'ja' | 'en'
 *   active_slug : 現在アクティブな親カテゴリーのslug。
 *                 空文字なら「よくある質問」(ピン留め一覧)側をアクティブ扱いにする。
 *   is_search   : true の場合、検索結果表示中とみなしカテゴリーは
 *                 どれもアクティブ表示にしない。
 *   search_query: 検索欄に復元する現在の検索キーワード。
 */

$lang         = $args['lang'] ?? 'ja';
$active_slug  = $args['active_slug'] ?? '';
$is_search    = $args['is_search'] ?? false;
$search_query = $args['search_query'] ?? '';

$archive_url = langmate_get_faq_archive_url( $lang );
$parents     = langmate_get_faq_parent_categories();
?>
<section class="faq-search-section">
  <div class="wrapper  faq-search-section__inner">
    <form class="faq-search" action="<?php echo esc_url( $archive_url ); ?>" method="get">
      <input class="faq-search__input" type="search" name="q" value="<?php echo esc_attr( $search_query ); ?>" placeholder="<?php echo ( 'en' === $lang ) ? 'Enter a keyword' : 'キーワード入力'; ?>" />
      <button class="faq-search__submit" type="submit"><?php echo ( 'en' === $lang ) ? 'Search' : '検索'; ?></button>
    </form>

    <nav class="faq-categories" aria-label="<?php echo ( 'en' === $lang ) ? 'FAQ categories' : 'FAQカテゴリー'; ?>">
      <a class="faq-categories__item<?php echo ( ! $is_search && '' === $active_slug ) ? ' faq-categories__item--active' : ''; ?>" href="<?php echo esc_url( $archive_url ); ?>">
        <span class="faq-categories__arrow" aria-hidden="true">▶︎</span><?php echo esc_html( langmate_get_faq_all_label( $lang ) ); ?>
      </a>
      <?php foreach ( $parents as $parent ) :
        $label     = langmate_get_faq_category_label( $parent, $lang );
        $url       = langmate_get_faq_archive_url( $lang, $parent->slug );
        $is_active = ( ! $is_search && $active_slug === $parent->slug );
      ?>
      <a class="faq-categories__item<?php echo $is_active ? ' faq-categories__item--active' : ''; ?>" href="<?php echo esc_url( $url ); ?>">
        <span class="faq-categories__arrow" aria-hidden="true">▶︎</span><?php echo esc_html( $label ); ?>
      </a>
      <?php endforeach; ?>
    </nav>
  </div>
</section>
