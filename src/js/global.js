import request from './utils/request';

export default () => {
  const logout = document.getElementById('logout');

  if (logout) {
    logout.addEventListener('click', () => {
      request('/api/login/logout', {}, () => window.location.reload());
    });
  }
};
