import './scss/main.scss';

import feedback from './js/feedback';
import login from './js/login';
import navigation from './js/navigations';
import register from './js/register';
import request from './js/utils/request';
import users from './js/users';
import profileSettings from './js/profileSettings';
import profile from './js/profile';
import projects from './js/projects';
import notify from './js/utils/notify';
import adminFeedback from './js/admin-feedback';
// TODO: bye   |                |
// TODO: bye   V                V
global.request = request; global.notify = notify;

document.addEventListener('DOMContentLoaded', () => {
  adminFeedback();
  feedback();
  login();
  navigation();
  register();
  users();
  profileSettings();
  profile();
  projects();
});
