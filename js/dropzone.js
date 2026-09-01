// お問い合わせフォームのファイル添付ドロップゾーン
// - 実際のドラッグ&ドロップを受け付ける（今まで見た目だけで機能していなかった）
// - ファイルが選択されたら、ファイル名を表示して「選択済み」の見た目にする
export function initDropzone() {
  const dropzones = document.querySelectorAll('.contact-form__dropzone');

  dropzones.forEach((dropzone) => {
    const input = dropzone.querySelector('input[type="file"]');
    const filenameTextEl = dropzone.querySelector('.contact-form__dropzone-filename-text');
    const changeBtn = dropzone.querySelector('.contact-form__dropzone-change');
    const removeBtn = dropzone.querySelector('.contact-form__dropzone-remove');
    if (!input) return;

    // 表示・非表示はCSS側(.has-file)に任せ、ここではクラスの付け外しだけ行う
    // （hidden属性はCF7フォーム保存時にサニタイズで落ちることがあるため使わない）
    const showFile = (file) => {
      if (!file) {
        dropzone.classList.remove('has-file');
        if (filenameTextEl) filenameTextEl.textContent = '';
        return;
      }
      dropzone.classList.add('has-file');
      if (filenameTextEl) filenameTextEl.textContent = file.name;
    };

    input.addEventListener('change', () => {
      showFile(input.files && input.files[0]);
    });

    // 「他のファイルを選ぶ」ボタンで選び直せるようにする
    if (changeBtn) {
      changeBtn.addEventListener('click', () => {
        input.click();
      });
    }

    // 「削除」ボタンで添付を取り消し、初期のドロップ画面に戻す
    if (removeBtn) {
      removeBtn.addEventListener('click', () => {
        input.value = ''; // file inputの選択を確実にクリアする唯一の方法
        showFile(null);
      });
    }

    ['dragover', 'dragenter'].forEach((eventName) => {
      dropzone.addEventListener(eventName, (e) => {
        e.preventDefault();
        dropzone.classList.add('is-dragover');
      });
    });

    ['dragleave', 'dragend'].forEach((eventName) => {
      dropzone.addEventListener(eventName, () => {
        dropzone.classList.remove('is-dragover');
      });
    });

    dropzone.addEventListener('drop', (e) => {
      e.preventDefault();
      dropzone.classList.remove('is-dragover');

      const file = e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files[0];
      if (!file) return;

      // input.files はread-onlyなので、DataTransferを介して差し替える
      const transfer = new DataTransfer();
      transfer.items.add(file);
      input.files = transfer.files;

      showFile(file);
    });
  });
}
