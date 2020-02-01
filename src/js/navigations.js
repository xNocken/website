import request from './request';

export default () => {
  const toggleActiveButtons = document.getElementsByClassName('navigation-active-button');
  const deleteButtons = document.getElementsByClassName('navigation-delete-button');
  const addNavigationButton = document.getElementById('add-navigation-button');
  const addNavigationName = document.getElementById('add-navigation-name');
  const addNavigationPath = document.getElementById('add-navigation-path');

  if (toggleActiveButtons) {
    Array.from(toggleActiveButtons).forEach((button) => {
      button.addEventListener('click', (event) => {
        const id = event.target.parentNode.parentNode.getAttribute('data-id');
        const active = event.target.getAttribute('data-active');

        request('/admin/api/switchActive', { id, active }, () => {
          window.location.reload();
        });
      });
    });
  }

  if (addNavigationButton) {
    addNavigationButton.addEventListener('click', () => {
      request('/admin/api/addNavigation', { name: addNavigationName.value, path: addNavigationPath.value }, () => {
        window.location.reload();
      });
    });
  }

  if (deleteButtons) {
    Array.from(deleteButtons).forEach((button) => {
      button.addEventListener('click', (event) => {
        const id = event.target.parentNode.parentNode.getAttribute('data-id');

        request('/admin/api/deleteNavigation', { id }, () => {
          window.location.reload();
        });
      });
    });
  }
};
