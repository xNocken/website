import './scss/main.scss';

import feedback from './js/feedback';
import login from './js/login';
import navigation from './js/navigations';
import register from './js/register';
import request from './js/request';
import users from './js/users';
import profileSettings from './js/profileSettings';
import profile from './js/profile';
import projects from './js/projects';
import notify from './js/utils/notify';
//             |                |
// todo: bye   V                V
global.request = request; global.notify = notify;

document.addEventListener('DOMContentLoaded', () => {
  feedback();
  login();
  navigation();
  register();
  users();
  profileSettings();
  profile();
  projects();
});
