import request from './request';

export default () => {
  const toggleActiveButtons = document.getElementsByClassName('active-button');
  const addNavigationButton = document.getElementById('add-navigation-button');

  Array.from(toggleActiveButtons).forEach((button) => {
    button.addEventListener('click', (event) => {
      console.log(event.target.parentNode.parentNode.getAttribute('data-id'));
    });
  });

  addNavigationButton.addEventListener('click', () => {
    request('/admin/api/addNavigation', { name: 'Test', path: '/test/', active: 1 }, (response) => {
      console.log(response);
    });
  });
};
