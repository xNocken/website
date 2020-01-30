import request from './request';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('register-form');
  const loginStatus = document.getElementById('register-status');

  if (!form) {
    return;
  }

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const { user, pw } = event.target.elements;

    request('/api/login/register', { user: user.value, pw: pw.value }, (response) => {
      const { msg, type } = JSON.parse(response.response);
      if (type === 'error') {
        loginStatus.classList = 'login--status login--status__error';
      }
      loginStatus.innerText = msg;
    });
  });
});
