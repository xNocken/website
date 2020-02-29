import request from '../utils/request';

export default () => {
  const deleteButtons = document.getElementsByClassName('projects-delete-button');
  const addprojectsButton = document.getElementById('add-projects-button');
  const addprojectsName = document.getElementById('add-projects-name');
  const addprojectsPath = document.getElementById('add-projects-path');
  const addprojectsRank = document.getElementById('add-projects-rank');
  const addprojectsDesc = document.getElementById('add-projects-desc');
  const addprojectsGithub = document.getElementById('add-projects-github');

  if (addprojectsButton) {
    addprojectsButton.addEventListener('click', () => {
      request('/admin/api/projects/addProject', {
        name: addprojectsName.value,
        path: addprojectsPath.value,
        rank: addprojectsRank.value,
        github: addprojectsGithub.value,
        desc: addprojectsDesc.value,
      }, () => {
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
