import request from './utils/request';

export default () => {
  const toggleActiveButtons = document.getElementsByClassName('projects-active-button');
  const deleteButtons = document.getElementsByClassName('projects-delete-button');
  const addprojectsButton = document.getElementById('add-projects-button');
  const addprojectsName = document.getElementById('add-projects-name');
  const addprojectsPath = document.getElementById('add-projects-path');
  const addprojectsRank = document.getElementById('add-projects-rank');

  if (toggleActiveButtons) {
    Array.from(toggleActiveButtons).forEach((button) => {
      button.addEventListener('click', (event) => {
        const id = event.target.parentNode.parentNode.getAttribute('data-id');
        const active = event.target.getAttribute('data-active');

        request('/admin/api/switchActive', { id, active }, () => {
        });
      });
    });
  }

  if (addprojectsButton) {
    addprojectsButton.addEventListener('click', () => {
      request('/admin/api/projects/addProject', { name: addprojectsName.value, path: addprojectsPath.value, rank: addprojectsRank.value }, () => {
      });
    });
  }

  if (deleteButtons) {
    Array.from(deleteButtons).forEach((button) => {
      button.addEventListener('click', (event) => {
        const id = event.target.parentNode.parentNode.getAttribute('data-id');

        request('/admin/api/projects/deleteProject', { id }, () => {
        });
      });
    });
  }
};
