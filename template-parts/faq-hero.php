<?php
/**
 * template-parts/faq-hero.php
 *
 * FAQ一覧(how-can-we-help)・FAQ詳細(single-faq)で共通のヒーロー部分。
 * how-can-we-help.html / support.html の "===== Hero =====" セクションを
 * そのまま踏襲し、見出しとパンくずだけ呼び出し側から差し替えられるようにした。
 *
 * $args:
 *   lang       : 'ja' | 'en'
 *   heading    : h1に表示するテキスト(省略時は「よくある質問」/「FAQ」)
 *   breadcrumb : array of ['label' => string, 'url' => string|null]
 *                url が null の項目は現在地(aria-current="page")として扱う
 */

$lang       = $args['lang'] ?? 'ja';
$heading    = $args['heading'] ?? ( ( 'en' === $lang ) ? 'FAQ' : 'よくある質問' );
$breadcrumb = $args['breadcrumb'] ?? array();
$theme_uri  = get_template_directory_uri();
?>
<section class="sub-hero faq-hero">
  <picture>
    <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-sp.svg" media="(max-width: 430px)">
    <img class="sub-hero__map faq-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true" width="1280"
      height="500" />
  </picture>
  <div class="wrapper sub-hero__inner faq-hero__inner">
    <svg class="sub-hero__eyebrow faq-hero__eyebrow" viewBox="0 0 220 70" role="img" aria-label="FAQ">
      <path id="faq-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
      <text text-anchor="middle">
        <textPath href="#faq-hero-eyebrow-arc" startOffset="50%">FAQ</textPath>
      </text>
    </svg>
    <h1 class="sub-hero__heading faq-hero__heading"><?php echo esc_html( $heading ); ?></h1>

    <!-- Breadcrumb -->
    <nav class="breadcrumb faq-hero__breadcrumb" aria-label="<?php echo ( 'en' === $lang ) ? 'Breadcrumb' : 'パンくずリスト'; ?>">
      <ol class="breadcrumb__list">
        <?php foreach ( $breadcrumb as $item ) : ?>
        <li class="breadcrumb__item"<?php echo empty( $item['url'] ) ? ' aria-current="page"' : ''; ?>>
          <?php if ( ! empty( $item['url'] ) ) : ?>
          <a href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?></a>
          <?php else : ?>
          <?php echo esc_html( $item['label'] ); ?>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ol>
    </nav>
  </div>
</section>
