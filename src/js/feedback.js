export default () => {
  const like = document.getElementById('feedback-like');
  const dislike = document.getElementById('feedback-dislike');
  const textArea = document.getElementById('feedback-message');
  const submit = document.getElementById('feedback-submit');

  let likeActive;

  if (!like || !dislike || !textArea) {
    return;
  }

  like.addEventListener('click', () => {
    like.classList.add('clicked');
    dislike.classList.remove('clicked');

    likeActive = true;
  });

  dislike.addEventListener('click', () => {
    like.classList.remove('clicked');
    dislike.classList.add('clicked');

    likeActive = false;
  });

  submit.addEventListener('click', () => {
    const { value } = textArea;

    if (likeActive !== undefined) {
      if (value.length > 1 && value.length <= 500) {
        console.log(likeActive, value);
      }
    }
  });
};
