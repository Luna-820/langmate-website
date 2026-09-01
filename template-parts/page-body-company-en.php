<?php
/**
 * template-parts/page-body-company-en.php
 *
 * 既存の en/company.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'en';
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
        <h1 class="sub-hero__heading about-hero__heading">About Langmate</h1>
        <nav class="breadcrumb about-hero__breadcrumb" aria-label="Breadcrumb">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>
            <li class="breadcrumb__item" aria-current="page">
              Company
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
            Langmate is a Japanese company based in Tokyo. We started in 2015 with one simple idea: make it easier for
            Japanese people and people around the world to meet, talk, and connect through language.
            Our mission is to make connecting across languages and borders feel like a normal part of everyday life.
            <br><br>
            Since 2015, Langmate has brought together Japanese people who want to meet the world and people from around
            the world who love Japan, its language, and its culture. Today, the app has grown into a global community
            with over 4 million downloads.
          </p>
          <p>
            Maybe you want to use the Japanese you’ve been studying in a real conversation. Maybe you’re curious about
            life and culture in Japan. Or maybe you simply want to make Japanese friends.
            <br><br>
            Langmate gives you a place to
            do that.
            It’s more than just meeting someone new.
            You can talk with real people, use the language they actually speak, and learn from each other along the
            way.
            <br><br>
            We’ll keep making it easier for people everywhere to meet Japanese people, make friends, and connect through
            language—from Tokyo to the world.
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
        <h2 class="about-company__heading">Company Profile</h2>

        <dl class="about-company__table">
          <div class="about-company__row">
            <dt>Company Name</dt>
            <dd>Langmate Inc.</dd>
          </div>
          <div class="about-company__row">
            <dt>Established</dt>
            <dd>July 28, 2017</dd>
          </div>
          <div class="about-company__row">
            <dt>Capital</dt>
            <dd>JPY 9 million</dd>
          </div>
          <div class="about-company__row">
            <dt>Business Activities</dt>
            <dd>Development, production, and operation of international exchange apps and related services</dd>
          </div>
          <div class="about-company__row">
            <dt>Address</dt>
            <dd>Hamamatsucho Dia Bldg. 2F, 2-2-15 Hamamatsucho, Minato-ku, Tokyo 105-0003, Japan</dd>
          </div>
          <div class="about-company__row">
            <dt>CEO / Representative Director</dt>
            <dd>DAI KUWABARA</dd>
          </div>
          <div class="about-company__row">
            <dt>Main Bank</dt>
            <dd>MUFG Bank, Tamachi Branch</dd>
          </div>
          <div class="about-company__row">
            <dt>Auditor</dt>
            <dd>Kojima Accounting Firm</dd>
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
        <h2 class="about-recruit__heading">Job Openings</h2>

        <div class="about-recruit__items">
          <div class="about-recruit__item">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              iOS Developer
            </h3>
            <p>About Langmate:<br>
              Langmate is a unique service designed to connect people from different cultures and backgrounds, promoting language exchange and cultural interaction.</p>
          </div>

          <div class="about-recruit__item about-recruit__item--team">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              Our Team:
            </h3>
            <p>With the exception of the team manager, our entire development team consists of international members, naturally fostering a diverse and globally-minded work environment on a daily basis.
Additionally, we currently work fully remotely.</p>
            <img class="about-recruit__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-recruit-01.svg" alt="" aria-hidden="true"
              width="200" height="168" />
          </div>

          <div class="about-recruit__item about-recruit__item--member">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              Ideal Candidate:
            </h3>
            <p class="about-recruit__lead">Highly skilled mobile app engineer</p>
            <ul class="about-recruit__list">
              <li>Proven advanced technical skills in iOS development.</li>
              <li>Strong execution ability and practical experience, with a solid track record recognized by peers and superiors.</li>
              <li>A team-oriented mindset: proactively collaborating with the team to solve problems rather than attempting to resolve everything alone.。</li>
              <li>Experience developing matching apps is a major plus.</li>
              <li>Professional proficiency in English or Japanese.</li>
            </ul>
            <img class="about-recruit__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-recruit-02.svg" alt="" aria-hidden="true"
              width="300" height="274" />
          </div>

          <div class="about-recruit__item about-recruit__item--apply">
            <h3 class="about-recruit__title">
              <span class="about-recruit__badge" aria-hidden="true"></span>
              How to Apply:
            </h3>
            <p>If you would like to schedule an interview, please submit your resume/CV here.<br>
              We look forward to hearing from anyone interested in building a career at Langmate.</p>
            <img class="about-recruit__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-recruit-03.svg" alt="" aria-hidden="true"
              width="300" height="193" />
          </div>
        </div>
      </div>
    </section>
  </main>
