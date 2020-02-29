import feedback from './page/feedback';
import globalJs from './global';
import header from './layout/header';
import login from './page/login';
import navigation from './admin/navigations';
import register from './page/register';
import translations from './admin/translations';
import request from './utils/request';
import users from './admin/users';
import profileSettings from './page/profileSettings';
import profile from './page/profile';
import projects from './admin/projects';
import notify from './utils/notify';
import adminFeedback from './admin/admin-feedback';

// TODO: bye   |                |
// TODO: bye   V                V
global.request = request; global.notify = notify;

document.addEventListener('DOMContentLoaded', () => {
  adminFeedback();
  feedback();
  globalJs();
  header();
  login();
  navigation();
  register();
  translations();
  users();
  profileSettings();
  profile();
  projects();
});
