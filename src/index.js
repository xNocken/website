import './scss/main.scss';

import login from './js/login';
import register from './js/register';
import navigation from './js/navigations';
import request from './js/request';

global.request = request;

document.addEventListener('DOMContentLoaded', () => {
  register();
  navigation();
  login();
});
