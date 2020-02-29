import request from '../utils/request';

export default () => {
  const form = document.getElementById('login-form');
  const loginStatus = document.getElementById('login-status');

  if (!form) {
    return;
  }

  form.addEventListener('submit', (event) => {
    const { user, pw } = event.target.elements;

    event.preventDefault();
    request('/api/login/login', { user: user.value, pw: pw.value }, (response) => {
      const { msg, type } = JSON.parse(response.response);

      if (type === 'error') {
        loginStatus.classList = 'login--status login--status__error';
      } else {
        loginStatus.classList = 'login--status';
        window.location.href = window.location.href;
      }

      loginStatus.innerHTML = msg;
    }, 'post');
  });
};
