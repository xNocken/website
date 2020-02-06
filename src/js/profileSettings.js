import request from './request';

export default () => {
  const profileDataform = document.getElementById('user-data');
  const profilePictureForm = document.getElementById('user-picture');
  const profilePasswordForm = document.getElementById('user-password');

  profilePictureForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const { gravatar } = event.target.elements;

    if (gravatar.value.match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)) {
      request('/api/account/updateProfilePicture', { email: gravatar.value }, () => {
        gravatar.classList = 'account--picture--field';
      });
    } else {
      gravatar.classList = 'account--picture--field account--picture--field__error';
    }
  });

  profileDataform.addEventListener('submit', (event) => {
    const { name } = event.target.elements;

    event.preventDefault();
    request('/api/account/updateProfileSettings', { name: name.value }, () => {

    });
  });

  profilePasswordForm.addEventListener('submit', (event) => {
    event.preventDefault();

    const { current, pw, pw2 } = event.target.elements;

    if (pw.value === pw2.value) {
      request('/api/account/changePassword', { pw: pw.value, current: current.value }, (response) => {
        console.log(response);
      });
    }
  });
};
