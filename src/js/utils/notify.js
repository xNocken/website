export default (opts = {}) => {
  const options = {
    text: 'Error',
    time: 3000,
    type: 'error',
    ...opts,
  };

  const notification = document.createElement('div');
  notification.classList.add('notification', `notification--${options.type}`);
  notification.innerText = options.text;

  const notifications = document.querySelector('.notification');

  if (notifications) {
    notifications.classList.remove('notification--is-visible');

    setTimeout(() => {
      notifications.remove();
    }, 200);
  }

  document.getElementsByTagName('body')[0].appendChild(notification);

  setTimeout(() => {
    notification.classList.add('notification--is-visible');
  }, 10);

  setTimeout(() => {
    notification.classList.remove('notification--is-visible');

    setTimeout(() => {
      notification.remove();
    }, 200);
  }, options.time);
};
