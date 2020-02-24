export default () => {
  const button = document.getElementById('header-burger');
  const header = document.querySelector('.header');

  if (!header || !button) {
    return;
  }

  button.addEventListener('click', () => {
    header.classList.toggle('is-open');
  });
};
