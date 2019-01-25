
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('spinner', require('./components/Utils/Spinner.vue').default);
Vue.component('compose-message', require('./components/Utils/ComposeMessage.vue').default);
Vue.component('member-show', require('./components/Members/MemberShow.vue').default);
Vue.component('member-edit', require('./components/Members/MemberEdit.vue').default);
Vue.component('members-search', require('./components/Members/MembersSearch.vue').default);
Vue.component('course-details', require('./components/Courses/CourseDetails.vue').default);
Vue.component('student-inscription', require('./components/Courses/StudentInscription.vue').default);
Vue.component('student-unfinished', require('./components/Courses/StudentUnfinished.vue').default);
Vue.component('simple-login', require('./components/Members/SimpleLogin.vue').default);
Vue.component('course-register-small', require('./components/Courses/CourseRegisterSmall.vue').default);

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en'
Vue.use(ElementUI, { locale })

import Vue2TouchEvents from 'vue2-touch-events'
Vue.use(Vue2TouchEvents)

const app = new Vue({
    el: '#app'
});

window.vm = app;