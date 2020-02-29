import request from '../utils/request';

export default () => {
  const profileDataform = document.getElementById('user-data');
  const profilePictureForm = document.getElementById('user-picture');
  const profilePasswordForm = document.getElementById('user-password');

  if (profilePictureForm) {
    profilePictureForm.addEventListener('submit', (event) => {
      event.preventDefault();

      const { gravatar } = event.target.elements;

      if (gravatar.value.match(/[A-Za-z0-9]@[A-Za-z0-9]/)) {
        request('/api/account/updateProfilePicture', { email: gravatar.value }, () => {
          gravatar.classList = 'account--picture--field';
        });
      } else {
        gravatar.classList = 'account--picture--field account--picture--field__error';
      }
    });
  }

  if (profileDataform) {
    profileDataform.addEventListener('submit', (event) => {
      const { name } = event.target.elements;

      event.preventDefault();
      request('/api/account/updateProfileSettings', { name: name.value }, () => {

      });
    });
  }

  if (profilePasswordForm) {
    profilePasswordForm.addEventListener('submit', (event) => {
      event.preventDefault();

      const { current, pw, pw2 } = event.target.elements;

      if (pw.value === pw2.value) {
        request('/api/account/changePassword', { pw: pw.value, current: current.value }, (response) => {
          console.log(response);
        });
      }
    });
  }
};
