export function initStartedCurve() {
    const curve = document.querySelector(
        '.gs-started__list-curve'
    );

    const maskPath = document.querySelector(
        '.gs-started__list-curve-mask'
    );

    const items = [
        ...document.querySelectorAll(
            '.gs-started__item'
        )
    ];

    if (!curve && !items.length) return;

    const reduceMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;


    // ==========================================================
    // PC Curve setup
    // ==========================================================

    let pathLength = 0;

    if (maskPath) {
        pathLength = maskPath.getTotalLength();

        maskPath.style.strokeDasharray = pathLength;
        maskPath.style.strokeDashoffset = pathLength;
    }


    // ==========================================================
    // Reduced motion
    // ==========================================================

    if (reduceMotion) {
        if (maskPath) {
            maskPath.style.strokeDashoffset = 0;
        }

        items.forEach((item) => {
            item.style.setProperty(
                '--line-progress',
                1
            );
        });

        return;
    }


    // ==========================================================
    // PC Curve
    // 1001px以上
    // ==========================================================

    const updatePcCurve = () => {
        if (!curve || !maskPath) return;

        if (window.innerWidth <= 1000) {
            return;
        }

        const rect =
            curve.getBoundingClientRect();

        const viewportHeight =
            window.innerHeight;

        // 画面の75%くらいまで来たら描画開始
        const startPoint =
            viewportHeight * 0.75;

        // SVG下端が画面35%付近まで来たら完成
        const endPoint =
            viewportHeight * 0.35;

        const totalDistance =
            rect.height +
            startPoint -
            endPoint;

        const passedDistance =
            startPoint -
            rect.top;

        const progress = Math.min(
            Math.max(
                passedDistance /
                totalDistance,
                0
            ),
            1
        );

        maskPath.style.strokeDashoffset =
            pathLength * (1 - progress);
    };


    // ==========================================================
    // Tablet / SP Straight Line
    // 1000px以下
    // ==========================================================

    const updateMobileLines = () => {
        if (window.innerWidth > 1000) {
            return;
        }

        const viewportHeight =
            window.innerHeight;

        // この位置を線の先端として使う
        const triggerY =
            viewportHeight * 0.75;

        items.forEach((item, index) => {

            // 最後のitemには次の線がない
            if (index === items.length - 1) {
                return;
            }

            const currentIcon =
                item.querySelector(
                    '.gs-started__icon'
                );

            const nextIcon =
                items[index + 1].querySelector(
                    '.gs-started__icon'
                );

            if (!currentIcon || !nextIcon) {
                return;
            }

            const currentRect =
                currentIcon.getBoundingClientRect();

            const nextRect =
                nextIcon.getBoundingClientRect();

            // 現在のアイコン中央
            const startY =
                currentRect.top +
                currentRect.height / 2;

            // 次のアイコン中央
            const endY =
                nextRect.top +
                nextRect.height / 2;

            const distance =
                endY - startY;

            if (distance <= 0) return;

            const progress = Math.min(
                Math.max(
                    (triggerY - startY) /
                    distance,
                    0
                ),
                1
            );

            item.style.setProperty(
                '--line-progress',
                progress
            );
        });
    };


    // ==========================================================
    // Update
    // ==========================================================

    const update = () => {
        updatePcCurve();
        updateMobileLines();
    };


    // ==========================================================
    // RAF
    // ==========================================================

    let ticking = false;

    const requestUpdate = () => {
        if (ticking) return;

        ticking = true;

        requestAnimationFrame(() => {
            update();
            ticking = false;
        });
    };


    // 初期描画
    update();

    window.addEventListener(
        'scroll',
        requestUpdate,
        {
            passive: true
        }
    );

    window.addEventListener(
        'resize',
        requestUpdate
    );
}