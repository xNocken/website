import request from './request';
import messages from './messages';

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
    const about = editArea.innerHTML;
    const name = nameArea.innerText;

    if (editArea.innerText !== '') {
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
      const { length } = editArea.innerHTML;
      charcount.innerText = `${length}/500`;

      if (length >= 500) {
        charcount.classList.add('profile--info--about--charcount__limit-reached');
      } else {
        charcount.classList.remove('profile--info--about--charcount__limit-reached');
      }
    });

    profilePicture.addEventListener('click', () => {
      messages.input('Please enter your Gravatar email', (email) => {
        if (email) {
          if (email.match(/[A-Za-z0-9]@[A-Za-z0-9]/)) {
            request('/api/account/updateProfilePicture', { email }, (response) => {
              status.innerText = response.response;
              setTimeout(() => {
                status.innerText = '';
              }, 3000);
            });
          } else {
            status.innerText = 'Please enter a valid E-Mail adress';
            setTimeout(() => {
              status.innerText = '';
            }, 3000);
          }
        }
      });
    });
  }
};
