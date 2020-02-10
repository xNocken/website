import './scss/main.scss';

import login from './js/login';
import navigation from './js/navigations';
import register from './js/register';
import request from './js/request';
import users from './js/users';
import profileSettings from './js/profileSettings';
import profile from './js/profile';
import projects from './js/projects';

global.request = request;

document.addEventListener('DOMContentLoaded', () => {
  login();
  navigation();
  register();
  users();
  profileSettings();
  profile();
  projects();
});
