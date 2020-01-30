import request from './request';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('login-form');
  const loginStatus = document.getElementById('login-status');

  if (!form) {
    return;
  }


  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const { user, pw } = event.target.elements;

    request('/api/login/login', { user: user.value, pw: pw.value }, (response) => {
      const { msg, type } = JSON.parse(response.response);
      if (type === 'error') {
        loginStatus.classList = 'login--status login--status__error';
      }
      loginStatus.innerText = msg;
    }, 'post');
  });
});
