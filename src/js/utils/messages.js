const input = (text, callback) => {
  const html = `
  <div class="overlay--window">
    <h2 class="overlay--window--title">${text}</h2>
    <input type="input" class="overlay--window--input" id="overlay-input">
    <input type="submit" class="overlay--window--submit" id="overlay-submit">
  </div>`;

  const inputOverlay = document.createElement('div');
  inputOverlay.classList.add('overlay');
  inputOverlay.innerHTML = html;

  document.getElementsByTagName('body')[0].appendChild(inputOverlay);
  const inputField = document.getElementById('overlay-input');
  const submit = document.getElementById('overlay-submit');

  inputOverlay.addEventListener('click', (event) => {
    if (event.target === inputOverlay) {
      callback(false);
      inputOverlay.remove();
    }
  });

  submit.addEventListener('click', () => {
    callback(inputField.value);
    inputOverlay.remove();
  });
};

export default {
  input,
};
