<?php
/**
 * index.php
 *
 * WordPressテーマとして必須の最終フォールバックテンプレート。
 * front-page.php / page.php 等、より具体的なテンプレートが無い場合にのみ使われる。
 * TOPページ等の作り込みはここには置かない（front-page.php側の役割）。
 */

get_header();
$langmate_lang = langmate_get_current_language();
?>

<main id="main">
  <div class="wrapper">
    <?php if ( have_posts() ) : ?>
      <?php
      while ( have_posts() ) :
        the_post();
        ?>
        <article <?php post_class(); ?>>
          <h1><?php the_title(); ?></h1>
          <div><?php the_content(); ?></div>
        </article>
        <?php
      endwhile;
      ?>
    <?php else : ?>
      <p><?php echo ( 'en' === $langmate_lang ) ? 'Nothing found.' : 'コンテンツが見つかりませんでした。'; ?></p>
    <?php endif; ?>
  </div>
</main>

<?php get_footer(); ?>
