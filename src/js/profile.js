import request from './request';

export default () => {
  const editArea = document.getElementById('profile-about');
  const status = document.getElementById('profile-status');
  const nameArea = document.getElementById('profile-name');

  const eventListener = () => {
    const about = editArea.innerHTML;
    const name = nameArea.innerText;

    request('/api/account/updateProfileSettings', { about, name }, (response) => {
      if (status) {
        if (response.response === 'true') {
          status.innerText = 'Saved successfully';

          setTimeout(() => {
            status.innerText = '';
          }, 5000);
        } else if (response.response === 'short') {
          status.innerText = 'Name is too short';
        } else if (response.response === 'long') {
          status.innerText = 'Name is too long';
        } else {
          status.innerText = 'Unkown error while saving infos';
        }
      }
    });
  };

  if (editArea) {
    editArea.addEventListener('focusout', eventListener);
    nameArea.addEventListener('focusout', eventListener);
  }
};
