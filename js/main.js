// main.js自体はwp_enqueue_script()でファイル更新日時ベースの?verが
// 付与されキャッシュ回避されるが、ここからimportする子モジュールの
// URLは静的なimport文だとクエリを付けられず、ブラウザにキャッシュされた
// 古いバージョンがファイル更新後も使われ続けてしまう問題があった
// (main.js自身は最新でも、language-switcher.js等の中身だけ古いまま、
// という不具合が実際に起きていた)。import.meta.urlからmain.js自身の
// ?verを取り出し、全ての子モジュールのimportにも同じクエリを付けて、
// main.jsが更新されるたびに子モジュールも確実に再取得されるようにする。
const verSuffix = new URL( import.meta.url ).search;

const { initViewportHeight } = await import( `./viewport-height.js${ verSuffix }` );
const { initHeaderOffset } = await import( `./header-offset.js${ verSuffix }` );
const { initMobileNav } = await import( `./mobile-nav.js${ verSuffix }` );
const { initLanguageSwitcher } = await import( `./language-switcher.js${ verSuffix }` );
const { initFloatingDl, initMobileDownload } = await import( `./floating-dl.js${ verSuffix }` );
const { initStatPop } = await import( `./stat-pop.js${ verSuffix }` );
const { initServiceTabs } = await import( `./service-tabs.js${ verSuffix }` );
const { initFaqAccordion } = await import( `./faq-accordion.js${ verSuffix }` );
const { initContactForm } = await import( `./contact-form.js${ verSuffix }` );
const { initVoiceSlider } = await import( `./voice-slider.js${ verSuffix }` );
const { initStartedCurve } = await import( `./started-curve.js${ verSuffix }` );
const { initCf7Redirect } = await import( `./cf7-redirect.js${ verSuffix }` );
const { initDropzone } = await import( `./dropzone.js${ verSuffix }` );

initViewportHeight();
initHeaderOffset();
initMobileNav();
initLanguageSwitcher();
initFloatingDl();
initMobileDownload();
initStatPop();
initServiceTabs();
initFaqAccordion();
initContactForm();
initVoiceSlider();
initStartedCurve();
initCf7Redirect();
initDropzone();
