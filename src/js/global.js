import request from './utils/request';

const logoutFunc = () => {
  const logout = document.getElementById('logout');

  if (logout) {
    logout.addEventListener('click', () => {
      request('/api/login/logout', {}, () => window.location.reload());
    });
  }
};

export default () => {
  logoutFunc();
};
