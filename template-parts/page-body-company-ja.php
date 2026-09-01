<?php
/**
 * template-parts/page-body-company-ja.php
 *
 * 既存の company.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'ja';
$theme_uri = get_template_directory_uri();
?>

<main id="main">
    <!-- ===== Hero ===== -->
    <section class="sub-hero about-hero">
      <picture>
        <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-sp.svg" media="(max-width: 430px)">
        <img class="sub-hero__map about-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true"
          width="1280" height="500" />
      </picture>
      <div class="wrapper sub-hero__inner about-hero__inner">
        <svg class="sub-hero__eyebrow about-hero__eyebrow" viewBox="0 0 220 70" role="img" aria-label="ABOUT US">
          <!-- get-started(.gs-hero__eyebrow)と同じアーチ構造・半径を流用 -->
          <path id="about-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#about-hero-eyebrow-arc" startOffset="50%">ABOUT US</textPath>
          </text>
        </svg>
        <h1 class="sub-hero__heading about-hero__heading">Langmateについて</h1>
        <nav class="breadcrumb about-hero__breadcrumb" aria-label="パンくずリスト">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>
            <li class="breadcrumb__item" aria-current="page">
              会社概要
            </li>
          </ol>
        </nav>
      </div>
    </section>

    <!-- ===== Intro ===== -->
    <section class="about-intro">
      <div class="wrapper">
        <img class="about-intro__image" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/img-page-about.webp" alt="世界中のいろいろな言語の「こんにちは」が集まったワードクラウド"
          width="1080" height="300" />
        <hr class="about-intro__divider" />
        <div class="about-intro__text">
          <p>
            株式会社ラングメイトは、日本と世界中の人々を繋ぐ国際交流・語学学習プラットフォーム「Langmate」を運営しています。私たちのミッションは、言語や国境の壁を越えて、誰もが気軽に世界とつながれる日常を創り出すことです。
            <br><br>
            2015年のサービス開始以来、日本文化を愛する世界中の親日外国人ユーザーと、実践的な国際交流を楽しみたい日本人ユーザーに支持され、現在では累計400万ダウンロードに迫るグローバルプラットフォームへと成長しました。
          </p>
          <p>
            「語学力」と「国際力」をアップデートする場所。「生きた英語や外国語を日常的に学びたい」「海外のリアルな文化に触れたい」「日本にいながら外国人の友達を作りたい」。Langmateは、そんなユーザーの想いに応えるマッチングアプリです。
            <br><br>
            私たちはアプリを通じて、単なる出会いではなく、ネイティブスピーカーとの言語交換（ランゲージエクスチェンジ）の場を提供しています。誰もが簡単に世界とつながる体験を通じて、外国語への苦手意識をなくし、グローバルな視野を広げる機会をこれからも提供し続けます。
          </p>
        </div>
      </div>
    </section>

    <!-- ===== Company ===== -->
    <!-- 前セクション(cream)から青セクションへの上端アーチ。border-radiusの近似をやめてFigma提供のSVGに差し替え -->
    <img class="about-company__top" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/about-company-top.svg" alt="" aria-hidden="true" width="1280"
      height="200" />
    <section class="about-company">
      <img class="about-company__deco about-company__deco--tl" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/about-company-stripes.svg" alt=""
        aria-hidden="true" width="355" />
      <img class="about-company__deco about-company__deco--br" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/about-company-stripes.svg" alt=""
        aria-hidden="true" width="282" />
      <div class="wrapper about-company__inner">
        <svg class="about-company__eyebrow" viewBox="0 0 220 70" role="img" aria-label="COMPANY">
          <!-- about-hero/get-startedと同じアーチ構造を流用 -->
          <path id="about-company-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#about-company-eyebrow-arc" startOffset="50%">COMPANY</textPath>
          </text>
        </svg>
        <h2 class="about-company__heading">会社概要</h2>

        <dl class="about-company__table">
          <div class="about-company__row">
            <dt>会社名</dt>
            <dd>株式会社ラングメイト<br>（英語表記：Langmate Inc.）</dd>
          </div>
          <div class="about-company__row">
            <dt>創立</dt>
            <dd>2017年7月28日</dd>
          </div>
          <div class="about-company__row">
            <dt>資本金</dt>
            <dd>900万円</dd>
          </div>
          <div class="about-company__row">
            <dt>事業内容</dt>
            <dd>国際交流アプリの開発、制作及び運営等</dd>
          </div>
          <div class="about-company__row">
            <dt>所在地</dt>
            <dd>〒105-0003<br>東京都港区浜松町2-2-15浜松町ダイヤビル2F</dd>
          </div>
          <div class="about-company__row">
            <dt>代表取締役</dt>
            <dd>桑原　大</dd>
          </div>
          <div class="about-company__row">
            <dt>取引銀行</dt>
            <dd>三菱UFJ銀行　田町支店</dd>
          </div>
          <div class="about-company__row">
            <dt>会計監査</dt>
            <dd>児島会計事務所</dd>
          </div>
        </dl>
      </div>
    </section>
    <!-- 青セクションの下端アーチ。上端と同じSVGを上下反転して流用 -->
    <img class="about-company__bottom" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/about-company-top.svg" alt="" aria-hidden="true" width="1280"
      height="200" />

    <!-- ===== Recruit ===== -->
    <section class="about-recruit">
      <img class="about-recruit__bg" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-about.svg" alt="" aria-hidden="true" width="1280"
        height="1328" />
      <div class="wrapper">
        <svg class="about-recruit__eyebrow" viewBox="0 0 220 70" role="img" aria-label="RECRUIT">
          <!-- about-hero/get-startedと同じアーチ構造を流用 -->
          <path id="about-recruit-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#about-recruit-eyebrow-arc" startOffset="50%">RECRUIT</textPath>
          </text>
        </svg>
        <h2 class="about-recruit__heading">求人募集</h2>

        <div class="about-recruit__items">
          <div class="about-recruit__item">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              iOSデベロッパー募集概要
            </h3>
            <p>Langmateのサービスの特徴：<br>
              Langmateは、異なる文化や背景を持つ人々をつなぎ、言語交換や文化交流を促進するためのユニークなサービスです。</p>
          </div>

          <div class="about-recruit__item about-recruit__item--team">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              私たちのチーム
            </h3>
            <p>開発メンバーはチームマネジャーを除いて全員が非日本人で構成されており、国際色豊かな交流が日常的に行われています。また、私たちはフルリモートで働くことができます。</p>
            <img class="about-recruit__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-recruit-01.svg" alt="" aria-hidden="true"
              width="200" height="168" />
          </div>

          <div class="about-recruit__item about-recruit__item--member">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              募集している人材
            </h3>
            <p class="about-recruit__lead">高度な技能を持つモバイルアプリエンジニア</p>
            <ul class="about-recruit__list">
              <li>エンジニアとして高度な技能を習得していること。</li>
              <li>高度情報処理技術者試験の合格に相当する能力を有していること。</li>
              <li>高い作業遂行力と実務経験を持ち、自他ともに認められる方。</li>
              <li>マッチングアプリの開発経験がある方を歓迎します。</li>
              <li>英語を話せる方も歓迎しますが、日本語のみでも問題ありません。</li>
            </ul>
            <img class="about-recruit__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-recruit-02.svg" alt="" aria-hidden="true"
              width="300" height="274" />
          </div>

          <div class="about-recruit__item about-recruit__item--apply">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              応募方法
            </h3>
            <p>面談を希望される方は、職務経歴書をこちらよりお送りください。<br>
              Langmateでのキャリアにご興味のある方からのご応募をお待ちしております！</p>
            <img class="about-recruit__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-recruit-03.svg" alt="" aria-hidden="true"
              width="300" height="193" />
          </div>
        </div>
      </div>
    </section>
  </main>
