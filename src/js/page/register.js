import request from '../utils/request';

export default () => {
  const form = document.getElementById('register-form');
  const loginStatus = document.getElementById('register-status');

  if (!form) {
    return;
  }

  form.addEventListener('submit', (event) => {
    event.preventDefault();

    const { user, pw, pw2 } = event.target.elements;

    if (pw.value !== pw2.value) {
      loginStatus.classList = 'login--status login--status__error';
      loginStatus.innerText = 'Passwords must match';
      return;
    }

    request('/api/login/register', { user: user.value, pw: pw.value }, (response) => {
      const { msg, type } = JSON.parse(response.response);

      if (type === 'error') {
        loginStatus.classList = 'login--status login--status__error';
      } else {
        window.location.href = '/';
      }

      loginStatus.innerText = msg;
    });
  });
};
