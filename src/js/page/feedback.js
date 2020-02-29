import request from '../utils/request';
import notify from '../utils/notify';

export default () => {
  const like = document.getElementById('feedback-like');
  const dislike = document.getElementById('feedback-dislike');
  const textArea = document.getElementById('feedback-message');
  const submit = document.getElementById('feedback-submit');
  const feedbackWrapper = document.querySelector('.feedback');

  let likeActive;

  if (!like || !dislike || !textArea) {
    return;
  }

  const projectId = feedbackWrapper.getAttribute('project-id');

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
      if (value.length > 0 && value.length <= 500) {
        request('/api/feedback/addFeedback', {
          message: value,
          isPositive: likeActive,
          projectId,
        }, (enswer) => {
          const response = JSON.parse(enswer.response);
          notify({ text: response.msg, type: response.type });
        });
      } else {
        notify({ text: window.translate('feedback.error.length'), type: 'error' });
      }
    } else {
      notify({ text: window.translate('feedback.error.noselect'), type: 'error' });
    }
  });
};
