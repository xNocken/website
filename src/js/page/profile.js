import request from '../utils/request';
import messages from '../utils/messages';

export default () => {
  const editArea = document.getElementById('profile-about');
  const status = document.getElementById('profile-status');
  const nameArea = document.getElementById('profile-name');
  const charcount = document.getElementById('profile-charcount');
  const profilePicture = document.getElementById('profile-picture');
  let originalName;

  if (nameArea) {
    originalName = nameArea.innerText;
  }

  const eventListener = () => {
    const about = editArea.value;
    const name = nameArea.innerText;

    if (about.length > 0) {
      editArea.classList.remove('profile--info--about__empty');
      request('/api/account/updateProfileSettings', { about, name }, (response) => {
        if (status) {
          const json = JSON.parse(response.response);
          status.innerText = json.msg;

          if (json.type === 'success') {
            setTimeout(() => {
              if (name !== originalName) {
                window.location.href = `/profile/${name}`;
              }
            }, 1000);
          }

          setTimeout(() => {
            status.innerText = '';
          }, 3000);
        }
      });
    } else {
      status.innerText = 'Please fill in something in your about';

      if (!editArea.classList.contains('profile--info--about__empty')) {
        editArea.classList.add('profile--info--about__empty');
      }
    }
  };

  if (editArea) {
    editArea.addEventListener('focusout', eventListener);
    nameArea.addEventListener('focusout', eventListener);

    editArea.addEventListener('keyup', () => {
      const { length } = editArea.value;
      charcount.innerText = `${length}/500`;

      if (length >= 500) {
        charcount.classList.add('profile--info--about--charcount__limit-reached');
      } else {
        charcount.classList.remove('profile--info--about--charcount__limit-reached');
      }
    });

    profilePicture.addEventListener('click', () => {
      messages.input(window.translate('profile.gravatar_email'), (email) => {
        if (email) {
          if (email.match(/[A-Za-z0-9]@[A-Za-z0-9]/)) {
            request('/api/account/updateProfilePicture', { email }, (response) => {
              status.innerText = response.response;
              setTimeout(() => {
                status.innerText = '';
              }, 3000);
            });
          } else {
            status.innerText = window.translate('profile.invalid_email');
            setTimeout(() => {
              status.innerText = '';
            }, 3000);
          }
        }
      });
    });
  }
};
