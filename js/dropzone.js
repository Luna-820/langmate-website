// お問い合わせフォームのファイル添付ドロップゾーン(最大5枚まで)
//
// Contact Form 7には複数ファイル一括アップロード用のタグ(multiple属性)が
// 無いため、実際の送信は隠した[file]タグ5個(.contact-form__dropzone-slots
// 内のyour-file-1〜your-file-5)で行う。画面に見えているのは、それとは
// 独立した1つの<input type="file" multiple>(.contact-form__dropzone-picker)
// で、ここで選ばれた/ドロップされたファイルを、JS側で1枚ずつ隠しの
// [file]タグへ割り当て直す。
export function initDropzone() {
  const dropzones = document.querySelectorAll('.contact-form__dropzone');

  dropzones.forEach((dropzone) => {
    const picker = dropzone.querySelector('.contact-form__dropzone-picker');
    const slotInputs = Array.from(
      dropzone.querySelectorAll('.contact-form__dropzone-slots input[type="file"]')
    );
    const listEl = dropzone.querySelector('.contact-form__dropzone-filelist');
    const countEl = dropzone.querySelector('.contact-form__dropzone-count');
    const maxFiles = slotInputs.length;
    if (!picker || !listEl || maxFiles === 0) return;

    let files = [];

    // 選択中のfilesを、隠しの[file]タグ(1枚=1入力)へ実際に反映する。
    // input.filesは読み取り専用のため、DataTransferを介して差し替える。
    const syncSlots = () => {
      slotInputs.forEach((input, index) => {
        const transfer = new DataTransfer();
        if (files[index]) transfer.items.add(files[index]);
        input.files = transfer.files;
      });
    };

    const renderList = () => {
      listEl.innerHTML = '';
      dropzone.classList.toggle('has-file', files.length > 0);
      dropzone.classList.toggle('is-full', files.length >= maxFiles);

      if (countEl) {
        countEl.textContent = `${files.length}/${maxFiles}`;
      }

      files.forEach((file, index) => {
        const item = document.createElement('li');
        item.className = 'contact-form__dropzone-file';

        const icon = document.createElement('span');
        icon.className = 'contact-form__dropzone-filename-icon';
        icon.setAttribute('aria-hidden', 'true');

        const name = document.createElement('span');
        name.className = 'contact-form__dropzone-filename-text';
        name.textContent = file.name;

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'contact-form__dropzone-remove';
        removeBtn.textContent = 'Remove';
        removeBtn.addEventListener('click', () => {
          files.splice(index, 1);
          syncSlots();
          renderList();
        });

        item.append(icon, name, removeBtn);
        listEl.appendChild(item);
      });
    };

    const addFiles = (fileList) => {
      const incoming = Array.from(fileList || []);
      if (!incoming.length) return;
      const room = maxFiles - files.length;
      files = files.concat(incoming.slice(0, room));
      syncSlots();
      renderList();
      // 同じファイルを選び直してもchangeイベントが発火するようにリセットする
      picker.value = '';
    };

    picker.addEventListener('change', () => addFiles(picker.files));

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
      addFiles(e.dataTransfer && e.dataTransfer.files);
    });

    renderList();
  });
}
