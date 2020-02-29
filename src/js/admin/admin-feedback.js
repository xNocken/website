import request from '../utils/request';
import notify from '../utils/notify';

export default () => {
  const deleteFeedbackButton = document.getElementsByClassName('feedback-delete');

  if (deleteFeedbackButton) {
    Array.from(deleteFeedbackButton).forEach((button) => {
      const id = button.parentElement.parentElement.getAttribute('data-id');

      button.addEventListener('click', () => {
        request('/admin/api/feedback/deleteFeedback', { id }, (response) => {
          const result = JSON.parse(response.response);
          notify({ text: result.msg, type: result.type });
        });
      });
    });
  }
};
