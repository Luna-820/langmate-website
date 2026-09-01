<?php
/**
 * template-parts/page-body-beginners-guide-ja.php
 *
 * 既存の beginners-guide.html の <main> 部分をそのまま移植したもの。
 * デザイン・DOM構造・class名は完全に維持し、
 * アセットパスと内部ページへのリンクのみPHP化している。
 */

$lang      = 'ja';
$theme_uri = get_template_directory_uri();
?>

<main id="main">
    <!-- ===== Hero ===== -->
    <section class="sub-hero gs-hero">
      <picture>
        <source srcset="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page-sp.svg" media="(max-width: 430px)">
        <img class="sub-hero__map gs-hero__map" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/bg-page.svg" alt="" aria-hidden="true" width="1280"
          height="500" />
      </picture>

      <div class="wrapper sub-hero__inner gs-hero__inner">
        <svg class="sub-hero__eyebrow gs-hero__eyebrow" viewBox="0 0 220 70" role="img" aria-label="GET STARTED">
          <!-- Figma実測: バウンディングボックス W196×H23 → 半径R=H/2+W²/(8H)≒220.3 で逆算 -->
          <path id="gs-hero-eyebrow-arc" d="M12,55 A220.3,220.3 0 0,1 208,55" fill="none" />
          <text text-anchor="middle">
            <textPath href="#gs-hero-eyebrow-arc" startOffset="50%">GET STARTED</textPath>
          </text>
        </svg>
        <h1 class="sub-hero__heading gs-hero__heading">初めての方へ</h1>
        <p class="sub-hero__lead gs-hero__lead">英語に自信がなくても、<br />世界中のユーザーと安心して交流を始められます。</p>

        <!-- Breadcrumb -->
        <nav class="breadcrumb gs-hero__breadcrumb" aria-label="パンくずリスト">
          <ol class="breadcrumb__list">
            <li class="breadcrumb__item">
              <a href="<?php echo esc_url( langmate_get_page_url( 'home', $lang ) ); ?>">HOME</a>
            </li>

            <li class="breadcrumb__item" aria-current="page">
              初めての方へ
            </li>
          </ol>
        </nav>

        <div class="gs-hero__nav">
          <a class="gs-hero__nav-card gs-hero__nav-card--reason" href="#reason">
            <img class="gs-hero__nav-illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-page-reason.svg" alt="" aria-hidden="true" />
            <span class="gs-hero__nav-eyebrow">初めてでも安心な</span>
            <span class="gs-hero__nav-title">４つの理由</span>
            <span class="gs-hero__nav-arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4v16m0 0l-7-7m7 7l7-7" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </span>
          </a>
          <a class="gs-hero__nav-card gs-hero__nav-card--started" href="#get-started">
            <img class="gs-hero__nav-illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-page-start.svg" alt="" aria-hidden="true" />
            <span class="gs-hero__nav-eyebrow">Langmateの</span>
            <span class="gs-hero__nav-title">はじめ方</span>
            <span class="gs-hero__nav-arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4v16m0 0l-7-7m7 7l7-7" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </span>
          </a>
          <a class="gs-hero__nav-card gs-hero__nav-card--safety" href="#safety">
            <img class="gs-hero__nav-illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-page-safety.svg" alt="" aria-hidden="true" />
            <span class="gs-hero__nav-eyebrow">安心して交流できる</span>
            <span class="gs-hero__nav-title">環境づくり</span>
            <span class="gs-hero__nav-arrow" aria-hidden="true">
              <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 4v16m0 0l-7-7m7 7l7-7" stroke="currentColor" stroke-width="3" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>
            </span>
          </a>
        </div>
      </div>
    </section>

    <!-- ===== REASON ===== -->
    <section class="gs-reason" id="reason" aria-labelledby="gs-reason-heading">

      <div class="gs-reason__inner">

        <span class="gs-reason__watermark" aria-hidden="true">REASON</span>

        <div class="gs-reason__head">
          <p class="gs-reason__eyebrow">初めてでも安心な</p>
          <h2 id="gs-reason-heading" class="gs-reason__title">４つの理由</h2>
        </div>

        <div class="wrapper gs-reason__wrapper">
          <ul class="gs-reason__list">

            <!-- Reason 01 -->
            <li class="gs-reason__item">
              <div class="gs-reason__blob-wrap gs-reason__blob-wrap--01">

                <svg class="gs-reason__blob-shape" viewBox="0 0 387 303" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M0.0515811 169.048C-0.473394 140.836 2.91216 116.372 14.6652 93.5788C27.5378 68.6222 47.5029 51.3722 72.6749 39.5902C113.735 20.3586 156.783 8.24453 201.781 2.80336C236.992 -1.45425 272.031 -1.38998 306.733 6.69679C327.143 11.4525 346.299 19.2393 363.655 31.2785C382.196 44.1423 389.24 61.8154 386.385 83.7729C378.853 141.698 352.99 188.788 305.046 223.396C257.375 257.81 205.954 283.864 148.218 296.46C123.887 301.768 99.3146 304.365 74.3676 301.736C44.2405 298.554 24.6557 282.284 14.7187 254.013C7.52979 233.544 4.19245 212.256 1.814 190.802C0.903325 182.598 0.469418 174.339 0.0515811 169.048Z"
                    fill="white" />
                </svg>

                <svg class="gs-reason__blob-label" viewBox="0 0 387 303" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path id="gs-reason-path-01"
                    d="M0.0515811 169.048C-0.473394 140.836 2.91216 116.372 14.6652 93.5788C27.5378 68.6222 47.5029 51.3722 72.6749 39.5902C113.735 20.3586 156.783 8.24453 201.781 2.80336C236.992 -1.45425 272.031 -1.38998 306.733 6.69679"
                    fill="none" />
                  <text>
                    <textPath href="#gs-reason-path-01" startOffset="8%" textLength="360"
                      lengthAdjust="spacing" lengthAdjust="spacing">
                      まずは短いチャットから始められる
                    </textPath>
                  </text>
                </svg>

                <p class="gs-reason__blob-text">
                  最初から流暢に話す必要はありません。一言のメッセージから、自分のペースで世界の人との交流を始められます。
                </p>

              </div>
            </li>

            <!-- Reason 02 -->
            <li class="gs-reason__item">
              <div class="gs-reason__blob-wrap gs-reason__blob-wrap--02">

                <svg class="gs-reason__blob-shape" viewBox="0 0 453 354" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M452.092 156.253C452.705 189.219 448.75 217.804 435.018 244.437C419.978 273.599 396.652 293.755 367.242 307.522C319.269 329.994 268.973 344.149 216.4 350.506C175.261 355.481 134.322 355.406 93.7778 345.957C69.9319 340.4 47.5505 331.301 27.2721 317.234C5.61053 302.203 -2.61972 281.552 0.716187 255.895C9.51602 188.211 39.7333 133.187 95.7493 92.7494C151.446 52.537 211.524 22.093 278.981 7.37479C307.408 1.17334 336.117 -1.86166 365.264 1.21091C400.464 4.92801 423.346 23.9391 434.956 56.9738C443.355 80.8909 447.254 105.766 450.033 130.834C451.097 140.421 451.604 150.07 452.092 156.253Z"
                    fill="white" />
                </svg>

                <svg class="gs-reason__blob-label" viewBox="0 0 453 354" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path id="gs-reason-path-02"
                    d="M0.716187 255.895C9.51602 188.211 39.7333 133.187 95.7493 92.7494C151.446 52.537 211.524 22.093 278.981 7.37479C307.408 1.17334 336.117 -1.86166 365.264 1.21091"
                    fill="none" />
                  <text>
                    <textPath href="#gs-reason-path-02" startOffset="2%" textLength="344"
                      lengthAdjust="spacing">
                      会話を助けるサポート機能がある
                    </textPath>
                  </text>
                </svg>

                <p class="gs-reason__blob-text">
                  分からない表現があっても、翻訳・添削・返信サポートを使いながら会話を続けられます。英語に自信がない方でも、実際に使いながら少しずつ慣れていけます。
                </p>

              </div>
            </li>

            <!-- Reason 03 -->
            <li class="gs-reason__item">
              <div class="gs-reason__blob-wrap gs-reason__blob-wrap--03">

                <svg class="gs-reason__blob-shape" viewBox="0 0 492 328" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M453.259 240.204C436.807 268.777 418.693 291.242 393.206 306.999C365.295 324.249 334.919 329.512 302.62 326.165C249.925 320.719 199.523 306.948 151.184 285.321C113.358 268.397 78.306 247.248 48.4194 218.266C30.8415 201.222 16.3432 181.895 6.20646 159.393C-4.61954 135.352 -1.0384 113.412 15.0353 93.1381C57.438 39.6539 111.679 8.0518 180.521 2.24032C248.973 -3.54244 316.15 1.30436 381.552 23.4313C409.113 32.7568 435.285 44.9414 458.686 62.587C486.943 83.9022 496.766 111.983 489.703 146.279C484.585 171.106 475.115 194.436 464.586 217.355C460.561 226.12 456.025 234.653 453.259 240.204Z"
                    fill="white" />
                </svg>

                <svg class="gs-reason__blob-label" viewBox="0 0 492 328" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path id="gs-reason-path-03"
                    d="M15.0353 93.1381C57.438 39.6539 111.679 8.0518 180.521 2.24032C248.973 -3.54244 316.15 1.30436 381.552 23.4313"
                    fill="none" />
                  <text>
                    <textPath href="#gs-reason-path-03" startOffset="2%" textLength="367"
                      lengthAdjust="spacing">
                      話の合いそうな相手を見つけやすい
                    </textPath>
                  </text>
                </svg>

                <p class="gs-reason__blob-text">
                  プロフィールや興味、国籍・年齢などの条件から、話してみたい相手を探せます。日本語や日本文化に興味を持つ海外の人も多いため、共通の話題を見つけやすい環境です。
                </p>

              </div>
            </li>

            <!-- Reason 04 -->
            <li class="gs-reason__item">
              <div class="gs-reason__blob-wrap gs-reason__blob-wrap--04">

                <svg class="gs-reason__blob-shape" viewBox="0 0 492 333" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M44.9611 79.7792C62.9488 52.1465 82.2609 30.7031 108.57 16.3609C137.381 0.659864 167.999 -2.93791 200.068 2.16631C252.387 10.4801 301.962 26.9809 349.049 51.2143C385.894 70.177 419.74 93.2076 448.001 123.777C464.622 141.755 478.044 161.844 486.938 184.866C496.436 209.462 491.663 231.174 474.507 250.54C429.248 301.631 373.364 330.226 304.307 332.272C235.641 334.31 168.829 325.805 104.732 300.142C77.7209 289.326 52.2533 275.731 29.8497 256.835C2.79775 234.01 -5.47751 205.435 3.44596 171.575C9.91184 147.065 20.64 124.286 32.4043 101.976C36.9023 93.4431 41.8964 85.171 44.9611 79.7792Z"
                    fill="white" />
                </svg>

                <svg class="gs-reason__blob-label" viewBox="0 0 492 333" aria-hidden="true"
                  xmlns="http://www.w3.org/2000/svg">
                  <path id="gs-reason-path-04"
                    d="M44.9611 79.7792C62.9488 52.1465 82.2609 30.7031 108.57 16.3609C137.381 0.659864 167.999 -2.93791 200.068 2.16631C252.387 10.4801 301.962 26.9809 349.049 51.2143"
                    fill="none" />
                  <text>
                    <textPath href="#gs-reason-path-04" startOffset="1%" textLength="275"
                      lengthAdjust="spacing">
                      困ったときに自分を守れる
                    </textPath>
                  </text>
                </svg>

                <p class="gs-reason__blob-text">
                  不快なメッセージや迷惑行為に遭遇した場合は、相手をブロックしたり、運営へ通報したりできます。Langmateは日本企業が運営し、安心して交流を続けられる環境づくりに取り組んでいます。
                </p>

              </div>
            </li>

          </ul>
        </div>

        <img class="gs-reason__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-page-reason.svg" alt="" aria-hidden="true" width="405"
          height="470" data-pop />

      </div>
    </section>

    <img class="gs-divider gs-divider--reason" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/reason-bottom-divider.svg" alt="" aria-hidden="true"
      width="1280" height="237" />
    <!-- ===== GET STARTED ===== -->
    <section class="gs-started" id="get-started" aria-labelledby="gs-started-heading">
      <div class="gs-started__inner">

        <span class="gs-started__watermark" aria-hidden="true">
          GET STARTED
        </span>

        <div class="gs-started__head">
          <p class="gs-started__eyebrow">
            Langmateの
          </p>

          <h2 id="gs-started-heading" class="gs-started__title">
            はじめ方
          </h2>
        </div>

        <div class="wrapper gs-started__wrapper">
          <ol class="gs-started__list">

            <!-- PC用カーブ -->
            <svg class="gs-started__list-curve" viewBox="0 0 121 708" preserveAspectRatio="none" aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg">
              <defs>
                <mask id="gs-started-curve-mask">
                  <path class="gs-started__list-curve-mask"
                    d="M2.00003 2.00023C155.067 207.078 157.864 487.622 8.91684 695.711L2 705.375" />
                </mask>
              </defs>

              <path class="gs-started__list-curve-line"
                d="M2.00003 2.00023C155.067 207.078 157.864 487.622 8.91684 695.711L2 705.375"
                mask="url(#gs-started-curve-mask)" />
            </svg>


            <!-- Step 01 -->
            <li class="gs-started__item">

              <span class="gs-started__icon gs-started__icon--download">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-download.svg" alt="" aria-hidden="true" width="38.4" height="60" />
              </span>

              <div class="gs-started__content">
                <h3>ダウンロード</h3>
                <p>
                  App StoreまたはGoogle Playからアプリをダウンロードして始めましょう。
                </p>
              </div>

            </li>


            <!-- Step 02 -->
            <li class="gs-started__item">

              <span class="gs-started__icon gs-started__icon--register">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-register.svg" alt="" aria-hidden="true" width="56" height="42.57" />
              </span>

              <div class="gs-started__content">
                <h3>アカウント登録</h3>
                <p>
                  メールアドレスやSNSアカウントで簡単に登録できます。
                </p>
              </div>

            </li>


            <!-- Step 03 -->
            <li class="gs-started__item">

              <span class="gs-started__icon gs-started__icon--profile">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-profile.svg" alt="" aria-hidden="true" width="52.42" height="60" />
              </span>

              <div class="gs-started__content">
                <h3>プロフィールを作成</h3>
                <p>
                  話したい言語や趣味を設定して、自分に合う相手とつながりやすくしましょう。
                </p>
              </div>

            </li>


            <!-- Step 04 -->
            <li class="gs-started__item">

              <span class="gs-started__icon gs-started__icon--search">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-search-blue.svg" alt="" aria-hidden="true" width="60" height="60" />
              </span>

              <div class="gs-started__content">
                <h3>相手を探す</h3>
                <p>
                  フィルター機能を使って、国籍や年齢など条件に合うユーザーを探せます。
                </p>
              </div>

            </li>


            <!-- Step 05 -->
            <li class="gs-started__item">

              <span class="gs-started__icon gs-started__icon--chat">
                <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-chat.svg" alt="" aria-hidden="true" width="60" height="43.86" />
              </span>

              <div class="gs-started__content">
                <h3>交流スタート！</h3>
                <p>
                  チャットや音声・ビデオメッセージで、世界中のユーザーとの交流を楽しみましょう。
                </p>
              </div>

            </li>

          </ol>
        </div>


        <img class="gs-started__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-page-start.svg" alt="" aria-hidden="true" width="400"
          height="556.54" data-pop />

      </div>
    </section>

    <img class="gs-divider gs-divider--started" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/get-started-bottom-divider.svg" alt=""
      aria-hidden="true" width="1280" height="263" />

    <!-- ===== SAFETY ===== -->
    <section class="gs-safety" id="safety" aria-labelledby="gs-safety-heading">
      <div class="gs-safety__inner">

        <span class="gs-safety__watermark" aria-hidden="true">
          SAFETY
        </span>

        <div class="gs-safety__head">
          <p class="gs-safety__eyebrow">
            安心して交流できる
          </p>

          <h2 id="gs-safety-heading" class="gs-safety__title">
            環境づくり
          </h2>
        </div>

        <div class="wrapper gs-safety__wrapper">

          <ul class="gs-safety__grid">

            <li class="gs-safety__card">
              <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-report.svg" alt="" aria-hidden="true" width="40" height="40" />

              <h3>通報機能</h3>

              <p>
                迷惑ユーザーを運営へ報告できます。
              </p>
            </li>


            <li class="gs-safety__card">
              <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-security.svg" alt="" aria-hidden="true" width="40" height="40" />

              <h3>ブロック機能</h3>

              <p>
                苦手な相手とのやり取りを制限できます。
              </p>
            </li>


            <li class="gs-safety__card">
              <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-spam.svg" alt="" aria-hidden="true" width="40" height="40" />

              <h3>スパム対策</h3>

              <p>
                毎日迷惑ユーザーをチェックしています。
              </p>
            </li>


            <li class="gs-safety__card">
              <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/icon-privacy.svg" alt="" aria-hidden="true" width="40" height="40" />

              <h3>個人情報保護</h3>

              <p>
                個人情報を適切に管理しています。
              </p>
            </li>


            <li class="gs-safety__card">
              <svg viewBox="0 0 40 40" fill="none" aria-hidden="true" width="40" height="40"
                xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="8" width="34" height="24" rx="4" stroke="#21A3FF" stroke-width="2.5" />

                <circle cx="20" cy="20" r="6" fill="#21A3FF" />
              </svg>

              <h3>日本企業が運営</h3>

              <p>
                安心して利用できるサポート体制を整えています。
              </p>
            </li>

          </ul>
        </div>


        <img class="gs-safety__illust" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-page-safety.svg" alt="" aria-hidden="true" width="400"
          height="434.63" data-pop />

      </div>
    </section>

    <!-- ===== FAQ Preview ===== -->
    <section class="faq-preview" aria-labelledby="faq-preview-heading">
      <div class="wrapper">
        <h2 id="faq-preview-heading" class="section-title section-title--faq">
          <span class="section-title__deco" aria-hidden="true">
            <span class="section-title__deco-first">F</span>AQ
          </span>

          <span class="section-title__sub">
            <span class="section-title__dot" aria-hidden="true"></span>
            よくある質問
          </span>
        </h2>
        <div class="faq-preview__box">
          <img class="faq-preview__illustration" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/illust-faq.svg" alt="" aria-hidden="true"
            width="160" height="160" />
          <ul class="faq-preview__list">
            <li class="faq-preview__item">
              <button type="button" class="faq-preview__question" aria-expanded="false" aria-controls="gs-faq-a-1"
                data-faq-accordion-trigger>
                <span class="faq-preview__q-icon" aria-hidden="true">Q</span>
                <span class="faq-preview__q-text">何歳から利用できますか？</span>
                <span class="faq-preview__arrow" aria-hidden="true"></span>
              </button>
              <div class="faq-preview__answer" id="gs-faq-a-1" hidden>
                <span class="faq-preview__a-icon" aria-hidden="true">A</span>
                <p>Langmate（ラングメイト）をご利用するには、18歳以上である必要があります。
                  Langmate（ラングメイト）では、未成年保護を重要視しておりますので、18歳未満のユーザーはアクセスをブロックします。
                </p>
              </div>
            </li>
            <li class="faq-preview__item">
              <button type="button" class="faq-preview__question" aria-expanded="false" aria-controls="gs-faq-a-2"
                data-faq-accordion-trigger>
                <span class="faq-preview__q-icon" aria-hidden="true">Q</span>
                <span class="faq-preview__q-text">Langmate（ラングメイト）は無料ですか？</span>
                <span class="faq-preview__arrow" aria-hidden="true"></span>
              </button>
              <div class="faq-preview__answer" id="gs-faq-a-2" hidden>
                <span class="faq-preview__a-icon" aria-hidden="true">A</span>
                <p>Langmateは Apple App Store and Google Play Storeにて無料でダウンロードできます。
                  世界中の人々とつながり、交流するための様々な機能を無料でご利用いただけます。
                  <br><br>
                  Langmateでは、ユーザーとのマッチやチャットは無料です。
                  Langmateはスマイルと呼ばれる仮想クレジットシステムを使用しており、カードスワイプや高度なチャットツールなどの機能を利用することができます。
                  プロフィールを右にスワイプすると相手にフレンドリクエストが送信され、左にスワイプするとパスされます。
                  相手があなたのフレンド申請を承認するか、あなたが他のユーザーからのフレンド申請を承認すると、マッチ成立です！
                  <br><br>
                  限られた数の新しいフレンズと無料でチャットを始め、楽しむことができます。
                  無料チャットのクレジットを使用した後、スマイルを使用するか、PREMIUMになることで、追加チャットをアンロックできます。
                  「チャットを始める」機能についてもっと読む
                  <br><br>
                  すべてのプレミアム機能を楽しむ
                  Langmateのすべての機能を完全にご利用いただくには、 PREMIUM か PLUS+にアップグレードする必要があります。
                  どのプランが適用されるかを確認するには、Langmateアプリを開きます。
                  > My Page を開く
                  > ステータスをタップするかセッティング > マイステータスを確認
                  > 画面に表示される手順に従ってください。

                </p>
              </div>
            </li>
            <li class="faq-preview__item">
              <button type="button" class="faq-preview__question" aria-expanded="false" aria-controls="gs-faq-a-3"
                data-faq-accordion-trigger>
                <span class="faq-preview__q-icon" aria-hidden="true">Q</span>
                <span class="faq-preview__q-text">Langmateはどこの国のアプリですか？</span>
                <span class="faq-preview__arrow" aria-hidden="true"></span>
              </button>
              <div class="faq-preview__answer" id="gs-faq-a-3" hidden>
                <span class="faq-preview__a-icon" aria-hidden="true">A</span>
                <p>Langmate（ラングメイト）は、日本で開発されたアプリです。
                  <br><br>
                  ※アプリの詳しい機能や特徴については、ダウンロードページをご覧ください。
                  <br>
                  世界へ旅立つ前に、事前に友達を作っちゃおう！
                </p>
              </div>
            </li>
          </ul>
        </div>
        <a href="<?php echo esc_url( langmate_get_page_url( 'how-can-we-help', $lang ) ); ?>" class="btn btn--outline">よくある質問を見る</a>
      </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="cta" aria-labelledby="cta-heading" id="download">
      <img class="cta__deco cta__deco--lt-wave" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/cta-deco-lefttop.svg" alt="" aria-hidden="true"
        width="554" height="132" />
      <img class="cta__deco cta__deco--lt-circle" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/cta-deco-leftbottom.svg" alt="" aria-hidden="true"
        width="172" height="296" />
      <img class="cta__deco cta__deco--rb-circle" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/cta-deco-righttop.svg" alt="" aria-hidden="true"
        width="185" height="218" />
      <img class="cta__deco cta__deco--rb-wave" src="<?php echo esc_url( $theme_uri ); ?>/design-assets/cta-deco-rightbottom.svg" alt="" aria-hidden="true"
        width="509" height="138" />
      <div class="cta__inner">
        <h2 id="cta-heading">世界中のユーザーとの交流を、<br />今日から始めてみませんか？</h2>
        <p>英語を勉強するだけではなく、<br>実際に使いながら自然な語学力を身につけましょう。</p>
        <div class="cta__badges">
          <a href="https://apps.apple.com/us/app/langmate-japanese-friends/id1093968775" target="_blank" rel="noopener" class="btn btn--store">
            <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-appstore-ja.svg" alt="App Storeからダウンロード" width="160" height="48" />
          </a>
          <a href="https://play.google.com/store/apps/details?id=co.thoron.langmate" target="_blank" rel="noopener" class="btn btn--store">
            <img src="<?php echo esc_url( $theme_uri ); ?>/design-assets/badge-googleplay-ja.svg" alt="Google Playで手に入れよう" width="160" height="48" />
          </a>
        </div>
      </div>
    </section>
  </main>
