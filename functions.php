<?php
/**
 * Langmate theme functions
 *
 * Phase 6 (WordPress Integration) — 実装は既存の静的HTML/SCSS/JSの
 * デザイン・DOM構造・class名・レスポンシブ設計・JS設計を変更しないことを大前提に進める。
 * ここには「多言語判定・ページURL解決」まわりの共通関数と、
 * テーマセットアップ／アセット読み込み／<head>内の動的出力を実装する。
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ==========================================================
 * Theme Setup
 * ==========================================================
 */
function langmate_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'langmate_setup' );

/**
 * グローバルナビ / モバイルナビ / フッターnav で共通して使う項目定義。
 * header.php・footer.phpの両方から参照するので、ここに一箇所だけ持たせる。
 *
 * @return array
 */
function langmate_get_nav_items() {
	return array(
		array(
			'key'      => 'home',
			'label_ja' => 'ホーム',
			'label_en' => 'Home',
		),
		array(
			'key'      => 'beginners-guide',
			'label_ja' => '初めての方へ',
			'label_en' => 'Getting Started',
		),
		array(
			'key'      => 'how-can-we-help',
			'label_ja' => 'よくある質問',
			'label_en' => 'FAQ',
		),
		array(
			'key'      => 'company',
			'label_ja' => '会社概要',
			'label_en' => 'Company',
		),
		array(
			'key'      => 'contact',
			'label_ja' => 'お問い合わせ',
			'label_en' => 'Contact',
		),
	);
}

/**
 * ==========================================================
 * 多言語: 「Japaneseページ(スラッグ ja)」の子孫かどうかで言語判定する。
 * English = デフォルト/ルート。将来 /ko/ /zh/ 等を追加する場合も、
 * この関数の中身を拡張するだけで他のテンプレート・関数は一切変更不要にする。
 * ==========================================================
 */

/**
 * 指定した投稿(固定ページ)の言語を判定する。
 *
 * @param int $post_id
 * @return string 'ja' | 'en'
 */
function langmate_get_page_language( $post_id ) {
	static $ja_root_id = null;

	if ( null === $ja_root_id ) {
		$ja_root    = get_page_by_path( 'ja' );
		$ja_root_id = $ja_root ? (int) $ja_root->ID : 0;
	}

	if ( ! $ja_root_id ) {
		return 'en';
	}

	$post_id = (int) $post_id;

	if ( $post_id === $ja_root_id ) {
		return 'ja';
	}

	$ancestors = get_post_ancestors( $post_id );

	if ( in_array( $ja_root_id, array_map( 'intval', $ancestors ), true ) ) {
		return 'ja';
	}

	return 'en';
}

/**
 * 現在表示中のページの言語を返す。
 *
 * @return string 'ja' | 'en'
 */
function langmate_get_current_language() {
	if ( is_singular( 'faq' ) ) {
		return langmate_get_faq_language( get_queried_object_id() );
	}

	if ( ! is_page() ) {
		// front-page.php(ENのTOP)、アーカイブ等は現状すべてen扱い(Englishがデフォルト)。
		return 'en';
	}

	return langmate_get_page_language( get_queried_object_id() );
}

/**
 * translation_key(例: 'company')と言語から、対応する固定ページのURLを返す。
 * 見つからない場合は '#'（Language Switcher等で無理にリンクさせない）。
 *
 * @param string      $key  translation_key の値
 * @param string|null $lang 'ja' | 'en'。省略時は現在の言語。
 * @return string
 */
function langmate_get_page_url( $key, $lang = null ) {
	if ( null === $lang ) {
		$lang = langmate_get_current_language();
	}

	// ENのホームはfront-page.phpがサイトルート(/)自体に表示される特殊テンプレートで、
	// 特定のPage投稿に紐づいていない(translation_key=homeのページが仮に存在しても、
	// それはサイトルートとは別の実体で、リンク先を間違えることになる)。
	// そのためhomeだけは常に言語ごとのルートURLを直接返す
	// (JPは/ja/ページのtranslation_key経由に頼らず、ここで確実に解決する)。
	if ( 'home' === $key ) {
		return ( 'en' === $lang ) ? home_url( '/' ) : home_url( '/ja/' );
	}

	$candidates = get_posts(
		array(
			'post_type'      => 'page',
			'posts_per_page' => -1,
			'meta_key'       => 'translation_key',
			'meta_value'     => $key,
			'no_found_rows'  => true,
			'fields'         => 'ids',
		)
	);

	foreach ( $candidates as $candidate_id ) {
		if ( langmate_get_page_language( $candidate_id ) === $lang ) {
			return get_permalink( $candidate_id );
		}
	}

	return '#';
}

/**
 * 現在のページの「もう一方の言語版」のURLを返す（Language Switcher用）。
 * translation_key が未設定、または対訳ページが無い場合は、
 * その言語のトップページへのフォールバックにする（壊れたリンクにしない）。
 *
 * @param string|null $lang 遷移先言語。省略時は「今と逆の言語」。
 * @return string
 */
function langmate_get_translation_url( $lang = null ) {
	$current_lang = langmate_get_current_language();

	if ( null === $lang ) {
		$lang = ( 'ja' === $current_lang ) ? 'en' : 'ja';
	}

	$fallback = ( 'ja' === $lang ) ? home_url( '/ja/' ) : home_url( '/' );

	if ( ! is_page() ) {
		return $fallback;
	}

	$key = get_post_meta( get_queried_object_id(), 'translation_key', true );

	if ( ! $key ) {
		return $fallback;
	}

	$url = langmate_get_page_url( $key, $lang );

	return ( '#' !== $url ) ? $url : $fallback;
}

/**
 * ==========================================================
 * Assets（main.css / Google Fonts / JS）
 * ==========================================================
 */
function langmate_enqueue_assets() {
	wp_enqueue_style( 'langmate-fonts', 'https://fonts.googleapis.com/css2?family=Inter:ital,wght@1,700&family=Poppins:wght@400;500;700&family=Zen+Kaku+Gothic+New:wght@400;500;700&display=swap', array(), null );

	wp_enqueue_style( 'langmate-main', get_template_directory_uri() . '/main.css', array(), filemtime( get_template_directory() . '/main.css' ) );

	wp_enqueue_script( 'langmate-main', get_template_directory_uri() . '/js/main.js', array(), filemtime( get_template_directory() . '/js/main.js' ), true );
}
add_action( 'wp_enqueue_scripts', 'langmate_enqueue_assets' );

/**
 * main.js は ES Modules 形式（import/export）なので type="module" を付与する。
 * WP 6.3+ なら wp_script_add_data() の 'type' で対応できる。
 */
function langmate_script_module_type( $tag, $handle, $src ) {
	if ( 'langmate-main' !== $handle ) {
		return $tag;
	}

	return sprintf( '<script type="module" src="%s"></script>' . "\n", esc_url( $src ) );
}
add_filter( 'script_loader_tag', 'langmate_script_module_type', 10, 3 );

/**
 * ==========================================================
 * <head> 内の動的出力（title-tagはWP標準、それ以外をここで担当）
 * meta description / OGP / hreflang / 構造化データ
 * ==========================================================
 */
function langmate_head_meta() {
	$lang    = langmate_get_current_language();
	$is_faq  = is_singular( 'faq' );

	$description = is_page() ? get_post_meta( get_queried_object_id(), 'meta_description', true ) : '';
	$title       = wp_get_document_title();
	// canonicalは常に「今表示している実URL」。FAQ単体はis_page()がfalseになるので
	// 個別に含めないと、旧実装のようにサイトルートへ誤って落ちてしまう。
	$permalink   = ( is_page() || $is_faq ) ? get_permalink() : home_url( '/' );

	// Canonical
	printf( '<link rel="canonical" href="%s" />' . "\n", esc_url( $permalink ) );

	// hreflang
	if ( $is_faq ) {
		// FAQはPageのようなtranslation_keyでの対訳ペア機構を持たない(投稿ごとに
		// faq_langで単一言語のみ)。存在しない対訳URLを出さないよう、
		// 自分の言語は自己参照のみ、x-defaultはEnglishのサイトルートに固定する
		// (このFAQ自体が英語ならx-default=自分自身と同じURLになる)。
		printf( '<link rel="alternate" hreflang="%s" href="%s" />' . "\n", esc_attr( $lang ), esc_url( $permalink ) );
		printf( '<link rel="alternate" hreflang="x-default" href="%s" />' . "\n", esc_url( 'en' === $lang ? $permalink : home_url( '/' ) ) );
	} else {
		// 対訳が無い場合は各言語のホームへのフォールバック（壊れた相互参照を出さない）
		$ja_url = langmate_get_translation_url( 'ja' );
		$en_url = langmate_get_translation_url( 'en' );

		printf( '<link rel="alternate" hreflang="ja" href="%s" />' . "\n", esc_url( $ja_url ) );
		printf( '<link rel="alternate" hreflang="en" href="%s" />' . "\n", esc_url( $en_url ) );
		printf( '<link rel="alternate" hreflang="x-default" href="%s" />' . "\n", esc_url( $en_url ) );
	}

	// OGP / meta description / Twitterカード
	//
	// AIOSEOが有効な環境(テスト環境・本番)では、これらは全てAIOSEOに任せる
	// (クライアントがページごとに編集できるようにするため)。AIOSEOが無い
	// Local環境では、今まで通りテーマ側がフォールバックとして出力する。
	// canonical/hreflang/Organizationスキーマは対象外(常にテーマ側が担当、
	// 下記のAIOSEOフィルターフックで住み分けている)。
	if ( ! function_exists( 'aioseo' ) ) {
		printf( '<meta property="og:site_name" content="Langmate" />' . "\n" );
		printf( '<meta property="og:type" content="website" />' . "\n" );
		printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
		if ( $description ) {
			printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
			printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
		}
		printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $permalink ) );
		printf( '<meta property="og:locale" content="%s" />' . "\n", ( 'en' === $lang ) ? 'en_US' : 'ja_JP' );

		printf( '<meta name="twitter:card" content="summary_large_image" />' . "\n" );
		printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
		if ( $description ) {
			printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $description ) );
		}
	}

	// 構造化データ（トップページのみ、Organization / WebSite）
	$is_home = is_front_page() || ( is_page() && 'home' === get_post_meta( get_queried_object_id(), 'translation_key', true ) );

	if ( $is_home ) {
		$org = ( 'en' === $lang )
			? array(
				'name'          => 'Langmate Inc.',
				'alternateName' => '株式会社ラングメイト',
				'addressRegion' => 'Tokyo',
				'addressLocality' => 'Minato-ku',
				'streetAddress' => '2F Hamamatsucho Daiya Building, 2-2-15 Hamamatsucho',
			)
			: array(
				'name'          => '株式会社ラングメイト',
				'alternateName' => 'Langmate Inc.',
				'addressRegion' => '東京都',
				'addressLocality' => '港区',
				'streetAddress' => '浜松町2-2-15 浜松町ダイヤビル2F',
			);

		$organization_schema = array(
			'@context'     => 'https://schema.org',
			'@type'        => 'Organization',
			'name'         => $org['name'],
			'alternateName' => $org['alternateName'],
			'url'          => $permalink,
			'foundingDate' => '2017-07-28',
			'address'      => array(
				'@type'           => 'PostalAddress',
				'postalCode'      => '105-0003',
				'addressRegion'   => $org['addressRegion'],
				'addressLocality' => $org['addressLocality'],
				'streetAddress'   => $org['streetAddress'],
				'addressCountry'  => 'JP',
			),
		);

		$website_schema = array(
			'@context' => 'https://schema.org',
			'@type'    => 'WebSite',
			'name'     => 'Langmate',
			'url'      => $permalink,
		);

		printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $organization_schema ) );
		printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $website_schema ) );
	}
}
add_action( 'wp_head', 'langmate_head_meta', 1 );

/**
 * ==========================================================
 * AIOSEO連携: 自作バイリンガル構造をAIOSEOが認識できない箇所を補正する
 *
 * AIOSEOはWPML/Polylang等の対応済み多言語プラグインが無いと、
 * ページごとの言語を判定できない。そのため何もしないと以下が
 * 常にWordPress管理画面の「サイトの言語」設定(このサイトの現状は
 * 日本語)だけで出力されてしまい、English側のページで内容と食い違う:
 *   - og:locale
 *   - schema WebPage/WebSiteノードのinLanguage
 * また、ナレッジグラフを「組織」に設定すると、詳細欄を空にしても
 * サイトタイトル／キャッチフレーズをフォールバックにしたOrganization
 * スキーマを必ず1つ生成してしまい、テーマ側が既に出している
 * 日英出し分けのOrganizationスキーマと重複する。
 *
 * ここではAIOSEOの設定自体は変更せず、フィルターフックで
 * 「このページの実際の言語」に基づいて出力だけを補正する。
 * AIOSEOが無効な環境(Local)ではこれらのフィルターは単に発火しない。
 * ==========================================================
 */

// ---- og:locale / og:site_name / og:type をページの実際の言語に補正 ----
function langmate_fix_aioseo_facebook_tags( $facebookMeta ) {
	$lang = langmate_get_current_language();

	if ( isset( $facebookMeta['og:locale'] ) ) {
		$facebookMeta['og:locale'] = ( 'en' === $lang ) ? 'en_US' : 'ja_JP';
	}
	if ( isset( $facebookMeta['og:site_name'] ) ) {
		$facebookMeta['og:site_name'] = 'Langmate';
	}
	if ( isset( $facebookMeta['og:type'] ) && ! is_singular( 'faq' ) ) {
		$facebookMeta['og:type'] = 'website';
	}

	return $facebookMeta;
}
add_filter( 'aioseo_facebook_tags', 'langmate_fix_aioseo_facebook_tags' );

// ---- スキーマ: 重複するOrganizationノードを除去し、WebPage/WebSiteのinLanguageを補正 ----
function langmate_fix_aioseo_schema_output( $graphs ) {
	$lang       = langmate_get_current_language();
	$in_language = ( 'en' === $lang ) ? 'en' : 'ja';

	foreach ( $graphs as $index => $graph ) {
		if ( empty( $graph['@type'] ) ) {
			continue;
		}

		if ( in_array( $graph['@type'], array( 'Organization', 'WebSite' ), true ) ) {
			// テーマ側のlangmate_head_meta()がホームページで日英出し分けの
			// Organization・WebSiteスキーマを別途出しているため、AIOSEO側の
			// 同じノードは重複するので除去する。
			unset( $graphs[ $index ] );
			continue;
		}

		if ( in_array( $graph['@type'], array( 'WebPage', 'CollectionPage' ), true ) ) {
			// フロントページ(is_front_page())はAIOSEO内部でWebPageではなく
			// CollectionPageとして扱われるため、両方をinLanguage補正の対象にする。
			$graphs[ $index ]['inLanguage'] = $in_language;
		}
	}

	return $graphs;
}
add_filter( 'aioseo_schema_output', 'langmate_fix_aioseo_schema_output' );

/**
 * ==========================================================
 * Contact Form 7: メールアドレス（確認）の一致チェック
 *
 * JP/EN両方のフォームで your-email / your-email-confirm という
 * 同じフィールド名を使っているため、この1つのフィルターで両言語に対応する。
 * 言語判定は（AJAX送信中でis_page()等が使えないため）リファラーURLで行う。
 * ==========================================================
 */
function langmate_cf7_validate_email_confirmation( $result, $tag ) {
	if ( 'your-email-confirm' !== $tag->name ) {
		return $result;
	}

	$email         = isset( $_POST['your-email'] ) ? trim( wp_unslash( $_POST['your-email'] ) ) : '';
	$email_confirm = isset( $_POST['your-email-confirm'] ) ? trim( wp_unslash( $_POST['your-email-confirm'] ) ) : '';

	if ( $email !== $email_confirm ) {
		$referer = wp_get_referer();
		$is_ja   = $referer && 0 === strpos( (string) wp_parse_url( $referer, PHP_URL_PATH ), '/ja/' );

		$message = $is_ja
			? 'メールアドレスが一致しません。'
			: 'The email addresses do not match.';

		$result->invalidate( $tag, $message );
	}

	return $result;
}
add_filter( 'wpcf7_validate_email', 'langmate_cf7_validate_email_confirmation', 20, 2 );
add_filter( 'wpcf7_validate_email*', 'langmate_cf7_validate_email_confirmation', 20, 2 );

/**
 * ==========================================================
 * FAQ: カスタム投稿タイプ + カテゴリータクソノミー
 *
 * ACFは使わず、標準の投稿本文(the_content)をそのまま回答として扱う。
 * 多言語対応はPage側の親子階層方式とは異なり、
 * 投稿メタ faq_lang ('ja' | 'en') で言語を持たせる方式にしている
 * (CPTはPageのような親子階層を前提にしていないため)。
 *
 * カテゴリー(faq_category)は階層あり(WP標準の「カテゴリー」と同じ仕組み)。
 * ターム自体はJP/ENで複製せず1セットのみとし、英語表示名は
 * タームメタ name_en に保存する(未入力ならターム名をそのまま使う)。
 * ==========================================================
 */

// ---- CPT登録 ----
function langmate_register_faq_cpt() {
	register_post_type(
		'faq',
		array(
			'labels'       => array(
				'name'          => 'FAQ',
				'singular_name' => 'FAQ',
				'add_new_item'  => '新規FAQを追加',
				'edit_item'     => 'FAQを編集',
				'all_items'     => 'FAQ一覧',
				'search_items'  => 'FAQを検索',
				'menu_name'     => 'FAQ',
			),
			'public'       => true,
			'has_archive'  => false, // 一覧は「よくある質問」Page側で動的に出力するため不要
			'rewrite'      => array( 'slug' => 'faq', 'with_front' => false ),
			'supports'     => array( 'title', 'editor' ),
			'show_in_rest' => true,
			'menu_icon'    => 'dashicons-editor-help',
		)
	);
}
add_action( 'init', 'langmate_register_faq_cpt' );

// ---- タクソノミー登録(親子カテゴリー) ----
function langmate_register_faq_category_taxonomy() {
	register_taxonomy(
		'faq_category',
		'faq',
		array(
			'labels'            => array(
				'name'          => 'FAQカテゴリー',
				'singular_name' => 'FAQカテゴリー',
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'rewrite'           => array( 'slug' => 'faq-category', 'with_front' => false ),
		)
	);
}
add_action( 'init', 'langmate_register_faq_category_taxonomy' );

// ---- 投稿メタ: faq_lang / faq_featured ----
function langmate_register_faq_meta() {
	register_post_meta(
		'faq',
		'faq_lang',
		array(
			'type'          => 'string',
			'single'        => true,
			'show_in_rest'  => true,
			'default'       => 'ja',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
	register_post_meta(
		'faq',
		'faq_featured',
		array(
			'type'          => 'string',
			'single'        => true,
			'show_in_rest'  => true,
			'default'       => '',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
	register_post_meta(
		'faq',
		'faq_toc',
		array(
			'type'          => 'string',
			'single'        => true,
			'show_in_rest'  => true,
			'default'       => '',
			'auth_callback' => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'langmate_register_faq_meta' );

// ---- 投稿メタ用メタボックス(言語選択) ----
function langmate_add_faq_lang_meta_box() {
	add_meta_box( 'langmate_faq_lang', '表示設定', 'langmate_render_faq_lang_meta_box', 'faq', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'langmate_add_faq_lang_meta_box' );

function langmate_render_faq_lang_meta_box( $post ) {
	wp_nonce_field( 'langmate_faq_lang_save', 'langmate_faq_lang_nonce' );
	$value = get_post_meta( $post->ID, 'faq_lang', true );
	if ( ! $value ) {
		$value = 'ja';
	}
	$featured = get_post_meta( $post->ID, 'faq_featured', true );
	$toc      = get_post_meta( $post->ID, 'faq_toc', true );
	?>
	<p>
		<label><input type="radio" name="faq_lang" value="ja" <?php checked( $value, 'ja' ); ?>> 日本語</label><br>
		<label><input type="radio" name="faq_lang" value="en" <?php checked( $value, 'en' ); ?>> English</label>
	</p>
	<hr>
	<p>
		<label><input type="checkbox" name="faq_featured" value="1" <?php checked( $featured, '1' ); ?>> よくある質問に表示する</label>
	</p>
	<p class="description">
		ONにすると、カテゴリーに関係なく「よくある質問」ボタンを押した時の一覧にも出るようになる
		(カテゴリー分類自体には影響しない)。
	</p>
	<hr>
	<p>
		<label><input type="checkbox" name="faq_toc" value="1" <?php checked( $toc, '1' ); ?>> 目次(セクションリンク)を表示する</label>
	</p>
	<p class="description">
		ONにすると、本文中のH3・H4見出しを自動で拾って、冒頭にジャンプリンク付きの目次を表示する。
		短いFAQで不要な場合はOFFのままでよい。
	</p>
	<?php
}

function langmate_save_faq_lang_meta( $post_id ) {
	if ( ! isset( $_POST['langmate_faq_lang_nonce'] ) || ! wp_verify_nonce( $_POST['langmate_faq_lang_nonce'], 'langmate_faq_lang_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	if ( isset( $_POST['faq_lang'] ) ) {
		update_post_meta( $post_id, 'faq_lang', sanitize_text_field( wp_unslash( $_POST['faq_lang'] ) ) );
	}
	update_post_meta( $post_id, 'faq_featured', isset( $_POST['faq_featured'] ) ? '1' : '' );
	update_post_meta( $post_id, 'faq_toc', isset( $_POST['faq_toc'] ) ? '1' : '' );
}
add_action( 'save_post_faq', 'langmate_save_faq_lang_meta' );

// ---- タームメタ: name_en(カテゴリーの英語表示名) / faq_order(表示順) ----
function langmate_faq_category_add_form_fields() {
	?>
	<div class="form-field">
		<label for="faq_category_name_en">英語名</label>
		<input type="text" name="faq_category_name_en" id="faq_category_name_en" value="">
		<p>英語版サイトでの表示名(未入力の場合は日本語名がそのまま使われます)</p>
	</div>
	<div class="form-field">
		<label for="faq_category_order">表示順</label>
		<input type="number" name="faq_category_order" id="faq_category_order" value="0" step="1">
		<p>数字が小さいものから先に表示される(同じ階層の中での並び順。未入力は0扱い)。</p>
	</div>
	<?php
}
add_action( 'faq_category_add_form_fields', 'langmate_faq_category_add_form_fields' );

function langmate_faq_category_edit_form_fields( $term ) {
	$name_en = get_term_meta( $term->term_id, 'name_en', true );
	$order   = get_term_meta( $term->term_id, 'faq_order', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="faq_category_name_en">英語名</label></th>
		<td>
			<input type="text" name="faq_category_name_en" id="faq_category_name_en" value="<?php echo esc_attr( $name_en ); ?>">
			<p class="description">英語版サイトでの表示名(未入力の場合は日本語名がそのまま使われます)</p>
		</td>
	</tr>
	<tr class="form-field">
		<th scope="row"><label for="faq_category_order">表示順</label></th>
		<td>
			<input type="number" name="faq_category_order" id="faq_category_order" value="<?php echo esc_attr( $order ? $order : '0' ); ?>" step="1">
			<p class="description">数字が小さいものから先に表示される(同じ階層の中での並び順)。</p>
		</td>
	</tr>
	<?php
}
add_action( 'faq_category_edit_form_fields', 'langmate_faq_category_edit_form_fields' );

function langmate_save_faq_category_meta( $term_id ) {
	if ( isset( $_POST['faq_category_name_en'] ) ) {
		update_term_meta( $term_id, 'name_en', sanitize_text_field( wp_unslash( $_POST['faq_category_name_en'] ) ) );
	}
	if ( isset( $_POST['faq_category_order'] ) ) {
		update_term_meta( $term_id, 'faq_order', (int) $_POST['faq_category_order'] );
	}
}
add_action( 'created_faq_category', 'langmate_save_faq_category_meta' );
add_action( 'edited_faq_category', 'langmate_save_faq_category_meta' );

// ---- JA投稿のパーマリンクを /ja/faq/{slug}/ にする(EN=デフォルトの /faq/{slug}/) ----
function langmate_faq_permalink( $link, $post ) {
	if ( 'faq' !== get_post_type( $post ) ) {
		return $link;
	}
	if ( 'ja' === get_post_meta( $post->ID, 'faq_lang', true ) ) {
		$link = home_url( '/ja/faq/' . $post->post_name . '/' );
	}
	return $link;
}
add_filter( 'post_type_link', 'langmate_faq_permalink', 10, 2 );

// ---- /ja/faq/{slug}/ を faq 投稿に振り分けるリライトルール ----
// 有効化には パーマリンク設定 での一度の再保存(フラッシュ)が必要
function langmate_faq_rewrite_rules() {
	add_rewrite_rule( '^ja/faq/([^/]+)/?$', 'index.php?faq=$matches[1]', 'top' );
}
add_action( 'init', 'langmate_faq_rewrite_rules' );

/**
 * ---- 下書きFAQの「プレビュー」が空クエリになる問題の修正 ----
 *
 * langmate_faq_permalink()/langmate_faq_rewrite_rules()はどちらも
 * 「公開済みのFAQ投稿をスラッグで検索する」前提の仕組みで、下書き状態の
 * 投稿はこのスラッグ検索にヒットしない(=index.phpの「見つかりません」に
 * フォールバックしてしまう)。編集画面の「プレビュー」ボタンだけは、
 * スラッグ経由のURLではなく投稿ID直指定のURL(?post_type=faq&p=123&preview=true)
 * に差し替え、下書きでも確実にその投稿自体を解決できるようにする。
 * 公開後の実際のURL構造(/ja/faq/{slug}/、/faq/{slug}/)には一切影響しない。
 */
function langmate_fix_faq_preview_link( $preview_link, $post ) {
	if ( 'faq' !== get_post_type( $post ) ) {
		return $preview_link;
	}

	return add_query_arg(
		array(
			'post_type' => 'faq',
			'p'         => $post->ID,
			'preview'   => 'true',
		),
		home_url( '/' )
	);
}
add_filter( 'preview_post_link', 'langmate_fix_faq_preview_link', 10, 2 );

/**
 * ---- プレビュー表示中はredirect_canonicalを無効化 ----
 *
 * 下書き投稿はpost_name(スラッグ)が未確定/空のことがあり、その状態で
 * langmate_faq_permalink()等のpost_type_linkフィルターを通すと不完全な
 * URL(例: /ja/faq//)が組み立てられる。WordPress標準のredirect_canonical
 * がこれを「正規URL」と誤認してリダイレクトしてしまうと、preview=true
 * クエリごと失われて「投稿が見つからない」状態になる。
 * プレビュー表示中はこの自動リダイレクトを止め、上記のpreview_post_link
 * が生成したURLをそのまま使わせる。
 */
function langmate_disable_redirect_canonical_on_preview( $redirect_url ) {
	if ( is_preview() ) {
		return false;
	}
	return $redirect_url;
}
add_filter( 'redirect_canonical', 'langmate_disable_redirect_canonical_on_preview' );

/**
 * ---- FAQ言語判定 ----
 * ページ側の langmate_get_current_language() と同じ役割。
 * single-faq.php や条件分岐から呼び出す。
 */
function langmate_get_faq_language( $post_id ) {
	$lang = get_post_meta( $post_id, 'faq_lang', true );
	return 'en' === $lang ? 'en' : 'ja';
}

/**
 * ---- FAQカテゴリーの表示名(言語対応) ----
 */
function langmate_get_faq_category_label( $term, $lang ) {
	if ( 'en' === $lang ) {
		$name_en = get_term_meta( $term->term_id, 'name_en', true );
		if ( $name_en ) {
			return $name_en;
		}
	}
	return $term->name;
}

/**
 * ---- タームメタ faq_order(表示順)で並び替える ----
 * get_terms()のmeta_value_numソートはfaq_order未設定のタームで
 * 挙動が不安定になりやすいため、PHP側で確実にソートする。
 * 数字が同じ場合は名前順(get_termsのデフォルト)を保つ。
 */
function langmate_sort_faq_terms_by_order( $terms ) {
	usort(
		$terms,
		function ( $a, $b ) {
			$order_a = (int) get_term_meta( $a->term_id, 'faq_order', true );
			$order_b = (int) get_term_meta( $b->term_id, 'faq_order', true );
			if ( $order_a === $order_b ) {
				return 0;
			}
			return ( $order_a < $order_b ) ? -1 : 1;
		}
	);
	return $terms;
}

/**
 * ---- 親カテゴリー一覧 ----
 */
function langmate_get_faq_parent_categories() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'faq_category',
			'parent'     => 0,
			'hide_empty' => false,
		)
	);
	return is_wp_error( $terms ) ? array() : langmate_sort_faq_terms_by_order( $terms );
}

/**
 * ---- 指定した親カテゴリー配下の子カテゴリー一覧 ----
 */
function langmate_get_faq_child_categories( $parent_term_id ) {
	$terms = get_terms(
		array(
			'taxonomy'   => 'faq_category',
			'parent'     => $parent_term_id,
			'hide_empty' => false,
		)
	);
	return is_wp_error( $terms ) ? array() : langmate_sort_faq_terms_by_order( $terms );
}

/**
 * ---- 指定カテゴリー・言語に属するFAQ投稿一覧 ----
 *
 * @param int    $term_id          faq_categoryのterm_id
 * @param string $lang             'ja' | 'en'
 * @param bool   $include_children trueなら子タームに属する投稿も含む(通常の子カテゴリー表示用)。
 *                                 falseなら「このタームに直接ひもづく投稿だけ」に絞る
 *                                 (親カテゴリーに直接タグ付けされた、子カテゴリー無しのFAQ抽出用)。
 */
function langmate_get_faq_posts_by_term( $term_id, $lang, $include_children = true ) {
	return get_posts(
		array(
			'post_type'      => 'faq',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
				array(
					'taxonomy'         => 'faq_category',
					'field'            => 'term_id',
					'terms'            => $term_id,
					'include_children' => $include_children,
				),
			),
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => 'faq_lang',
					'value' => $lang,
				),
			),
		)
	);
}

/**
 * ---- 選択中の親カテゴリーに対する表示グループ一覧を組み立てる ----
 *
 * 子カテゴリーに属さず親カテゴリーに直接タグ付けされたFAQがあれば、
 * 「親カテゴリー自身の名前」のグループとしてまず出す(「よくある質問」という
 * 別名は使わない。「よくある質問」はfaq_featuredフラグによる、カテゴリー横断の
 * 別枠のため)。続けて子カテゴリーごとに1グループずつ出す。
 * 投稿が1件も無いグループは含めない。
 *
 * @return array 各要素は ['title' => string, 'posts' => WP_Post[]]
 */
function langmate_get_faq_groups_for_parent( $parent_term, $lang ) {
	$groups = array();

	$direct_posts = langmate_get_faq_posts_by_term( $parent_term->term_id, $lang, false );
	if ( ! empty( $direct_posts ) ) {
		$groups[] = array(
			'title' => langmate_get_faq_category_label( $parent_term, $lang ),
			'posts' => $direct_posts,
		);
	}

	$children = langmate_get_faq_child_categories( $parent_term->term_id );

	foreach ( $children as $child ) {
		$posts = langmate_get_faq_posts_by_term( $child->term_id, $lang );
		if ( ! empty( $posts ) ) {
			$groups[] = array(
				'title' => langmate_get_faq_category_label( $child, $lang ),
				'posts' => $posts,
			);
		}
	}

	return $groups;
}

/**
 * ---- FAQ検索(キーワードでタイトル・本文を検索。言語で絞り込み) ----
 *
 * @param string $search_term 検索キーワード
 * @param string $lang        'ja' | 'en'
 * @return WP_Post[]
 */
function langmate_search_faq_posts( $search_term, $lang ) {
	return get_posts(
		array(
			'post_type'      => 'faq',
			'posts_per_page' => -1,
			's'              => $search_term,
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => 'faq_lang',
					'value' => $lang,
				),
			),
		)
	);
}

/**
 * ---- 「よくある質問」に手動でピン留めされたFAQ一覧(カテゴリー横断) ----
 */
function langmate_get_faq_featured_posts( $lang ) {
	return get_posts(
		array(
			'post_type'      => 'faq',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order title',
			'order'          => 'ASC',
			'meta_query'     => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'   => 'faq_lang',
					'value' => $lang,
				),
				array(
					'key'   => 'faq_featured',
					'value' => '1',
				),
			),
		)
	);
}

/**
 * ==========================================================
 * FAQ: 目次(セクションリンク)の自動生成
 *
 * ACF等のフィールドは使わず、投稿本文(the_content適用後のHTML)から
 * H3/H4見出しをそのまま拾ってジャンプリンク付きの目次を組み立てる。
 * 見出しに手動でHTMLアンカー(id)が設定されていればそれを使い、
 * 無ければ見出しテキストから自動採番する(重複時は連番を付与)。
 * ==========================================================
 */

/**
 * 本文HTMLからH3/H4を抽出し、id付与済みの本文と目次データを返す。
 *
 * @param string $content the_contentフィルター適用済みのHTML
 * @return array ['content' => string, 'items' => array]
 *               itemsの各要素: ['id'=>string,'text'=>string,'children'=>array]
 */
function langmate_faq_build_toc( $content ) {
	if ( ! class_exists( 'DOMDocument' ) || '' === trim( $content ) ) {
		return array(
			'content' => $content,
			'items'   => array(),
		);
	}

	$dom         = new DOMDocument();
	$prev_errors = libxml_use_internal_errors( true );
	$dom->loadHTML(
		'<?xml encoding="UTF-8">' . $content,
		LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD
	);
	libxml_clear_errors();
	libxml_use_internal_errors( $prev_errors );

	$xpath    = new DOMXPath( $dom );
	$headings = $xpath->query( '//h3 | //h4' );

	if ( 0 === $headings->length ) {
		return array(
			'content' => $content,
			'items'   => array(),
		);
	}

	$used_ids   = array();
	$items      = array();
	$has_h3     = false;
	$auto_index = 0;

	foreach ( $headings as $heading ) {
		$text = trim( $heading->textContent );
		if ( '' === $text ) {
			continue;
		}

		$id = $heading->getAttribute( 'id' );
		if ( '' === $id ) {
			// sanitize_title()は日本語のような非ASCII文字を%encodeするため、
			// アンカーIDとしては読みにくく壊れやすい(投稿のスラッグと同じ問題)。
			// 手動でHTMLアンカーを設定していない見出しは、連番の単純なIDにする。
			do {
				++$auto_index;
				$id = 'faq-section-' . $auto_index;
			} while ( in_array( $id, $used_ids, true ) );
			$heading->setAttribute( 'id', $id );
		}
		$used_ids[] = $id;

		if ( 'h3' === $heading->nodeName ) {
			$items[] = array(
				'id'       => $id,
				'text'     => $text,
				'children' => array(),
			);
			$has_h3  = true;
		} else {
			// h4は直前のh3配下にぶら下げる。h3がまだ無ければトップレベル扱い。
			$entry = array(
				'id'   => $id,
				'text' => $text,
			);
			if ( $has_h3 && ! empty( $items ) ) {
				$items[ count( $items ) - 1 ]['children'][] = $entry;
			} else {
				$items[] = array(
					'id'       => $id,
					'text'     => $text,
					'children' => array(),
				);
			}
		}
	}

	$modified_content = $dom->saveHTML();
	// loadHTMLに与えたXML宣言を除去
	$modified_content = preg_replace( '/^<\?xml[^>]*>\s*/', '', (string) $modified_content );
	// DOMDocumentは非ASCII文字を数値文字参照(&#12354;等)にエンコードして出力するため、
	// 元のUTF-8文字に戻す(ブラウザ表示上は同じだが、ソースが読みづらくなるのを防ぐ)。
	// &lt;/&gt;/&amp;等の名前付きエンティティ(HTML構文として必要なもの)は
	// 巻き込んで壊さないよう、数値文字参照だけを対象にする。
	$modified_content = preg_replace_callback(
		'/&#(x[0-9a-fA-F]+|[0-9]+);/',
		function ( $matches ) {
			$code      = $matches[1];
			$codepoint = ( 0 === stripos( $code, 'x' ) ) ? hexdec( substr( $code, 1 ) ) : (int) $code;
			return mb_chr( $codepoint, 'UTF-8' );
		},
		$modified_content
	);

	return array(
		'content' => $modified_content,
		'items'   => $items,
	);
}

/**
 * 目次(セクションリンク)のHTMLを組み立てる。
 *
 * @param array  $items langmate_faq_build_toc()が返したitems
 * @param string $lang  'ja' | 'en'
 * @return string
 */
function langmate_faq_render_toc( $items, $lang ) {
	if ( empty( $items ) ) {
		return '';
	}
	ob_start();
	?>
	<div class="faq-toc">
		<p class="faq-toc__title"><?php echo ( 'en' === $lang ) ? 'Contents' : '目次'; ?></p>
		<ul class="faq-toc__list">
			<?php foreach ( $items as $item ) : ?>
			<li>
				<a class="faq-toc__link" href="#<?php echo esc_attr( $item['id'] ); ?>"><?php echo esc_html( $item['text'] ); ?></a>
				<?php if ( ! empty( $item['children'] ) ) : ?>
				<ul class="faq-toc__sub-list">
					<?php foreach ( $item['children'] as $child ) : ?>
					<li><a class="faq-toc__link" href="#<?php echo esc_attr( $child['id'] ); ?>"><?php echo esc_html( $child['text'] ); ?></a></li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * ---- 「よくある質問」一覧ページ(指定カテゴリー付き)へのURL ----
 */
function langmate_get_faq_archive_url( $lang, $category_slug = '' ) {
	$url = langmate_get_page_url( 'how-can-we-help', $lang );
	if ( $category_slug ) {
		$url = add_query_arg( 'faq_cat', $category_slug, $url );
	}
	return $url;
}

/**
 * ==========================================================
 * FAQ:「全部見る」ボタンの表示名設定
 *
 * このボタンはfaq_categoryのタームではなく、絞り込み解除の固定リンク
 * (コード側で出している)。カテゴリーとして作ってしまうと、投稿の
 * 二重タグ付けが必要になってしまうため、あえてタクソノミーの外に出している。
 * その代わり、表示名だけは設定画面(設定 → FAQ表示設定)からクライアント側で
 * 編集できるようにする。
 * ==========================================================
 */
function langmate_register_faq_settings() {
	register_setting(
		'langmate_faq_settings',
		'langmate_faq_all_label_ja',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'よくある質問',
		)
	);
	register_setting(
		'langmate_faq_settings',
		'langmate_faq_all_label_en',
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default'           => 'All FAQs',
		)
	);
}
add_action( 'admin_init', 'langmate_register_faq_settings' );

function langmate_add_faq_settings_page() {
	add_options_page( 'FAQ表示設定', 'FAQ表示設定', 'manage_options', 'langmate-faq-settings', 'langmate_render_faq_settings_page' );
}
add_action( 'admin_menu', 'langmate_add_faq_settings_page' );

function langmate_render_faq_settings_page() {
	?>
	<div class="wrap">
		<h1>FAQ表示設定</h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'langmate_faq_settings' ); ?>
			<table class="form-table">
				<tr>
					<th scope="row"><label for="langmate_faq_all_label_ja">「全部見る」ボタンの表示名(日本語)</label></th>
					<td>
						<input type="text" name="langmate_faq_all_label_ja" id="langmate_faq_all_label_ja"
							value="<?php echo esc_attr( get_option( 'langmate_faq_all_label_ja', 'よくある質問' ) ); ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="langmate_faq_all_label_en">「全部見る」ボタンの表示名(英語)</label></th>
					<td>
						<input type="text" name="langmate_faq_all_label_en" id="langmate_faq_all_label_en"
							value="<?php echo esc_attr( get_option( 'langmate_faq_all_label_en', 'All FAQs' ) ); ?>" class="regular-text">
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

/**
 * ---- 「全部見る」ボタンの表示名を取得(言語対応) ----
 */
function langmate_get_faq_all_label( $lang ) {
	if ( 'en' === $lang ) {
		return get_option( 'langmate_faq_all_label_en', 'All FAQs' );
	}
	return get_option( 'langmate_faq_all_label_ja', 'よくある質問' );
}
