import request from './request';

export default () => {
  const selects = document.getElementsByClassName('users-select');

  if (selects) {
    Array.from(selects).forEach((select) => {
      const field = select;
      const rank = select.getAttribute('data-selected');
      const username = select.parentNode.parentNode.getAttribute('data-username');

      field.value = rank;

      select.addEventListener('change', () => {
        request('/admin/api/changeUserRank', { username, rank: select.value }, (response) => {
          if (response.status === 200) {
            window.location.reload();
          } else {
            alert(response.responseText);
          }
        });
      });
    });
  }
};
