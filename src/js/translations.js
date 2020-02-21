import request from './utils/request';

export default () => {
  const lang = document.getElementById('translations-lang');
  const key = document.getElementById('translations-key');
  const value = document.getElementById('translations-value');
  const submit = document.getElementById('translations-submit');

  if (!lang || !key || !value || !submit) {
    return;
  }

  submit.addEventListener('click', () => {
    request('/admin/api/addTranslation', { key: key.value, value: value.value, lang: lang.value }, () => {
      window.location.reload();
    });
  });
};
