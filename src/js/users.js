import request from './request';

export default () => {
  const selects = document.getElementsByClassName('users-select');
  const banButtons = document.getElementsByClassName('users-ban-button');
  const status = document.getElementById('status');

  if (selects) {
    Array.from(selects).forEach((select) => {
      const field = select;
      const rank = select.getAttribute('data-selected');
      const username = select.parentNode.parentNode.getAttribute('data-username');

      field.value = rank;

      select.addEventListener('change', () => {
        request('/admin/api/changeUserRank', { username, rank: select.value }, (response) => {
          if (response.status !== 200) {
            field.value = rank;
            status.innerHTML = response.response;
          }
        });
      });
    });
  }

  if (banButtons) {
    Array.from(banButtons).forEach((button) => {
      let loading;
      const button2 = button;
      const classes = [
        'users--button users--button__add users-ban-button',
        'users--button users--button__delete users-ban-button',
      ];
      const names = [
        'Unban',
        'Ban',
      ];

      if (!button.hasAttribute('disabled')) {
        button.addEventListener('click', () => {
          const username = button.parentNode.parentNode.getAttribute('data-username');
          let isBanned = button.getAttribute('data-active');
          let reason = '';

          if (loading) {
            loading.abort();
          }

          if (isBanned === '0') {
            reason = prompt('Enter reason');
          }

          loading = request('/admin/api/switchBanUser', { username, isBanned, reason }, (response) => {
            if (response.response === '1') {
              button2.classList = classes[isBanned];
              button2.innerHTML = names[isBanned];
              isBanned = isBanned === '0' ? 1 : 0;
              button.setAttribute('data-active', isBanned);
              status.innerHTML = '';
            } else {
              status.innerHTML = response.response;
            }
          });
        });
      }
    });
  }
};
