/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./pace.min');
require('./jquery.popconfirm');

/**
 * i18n
 */

const _ = require('lodash');
window.trans = (string) => _.get(window.i18n, string);

/**
 * Vue
 */

window.Vue = require('vue');

Vue.use(require('vue-intl'));
Vue.setLocale(window.locale);

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

Vue.component(
    'budget-monthly-view',
    require('./components/BudgetMonthlyView.vue')
);

Vue.component(
    'recurrence',
    require('./components/Recurrence.vue')
);

Vue.prototype.trans = (string, args) => {
    let value = _.get(window.i18n, string);

    _.eachRight(args, (paramVal, paramKey) => {
        value = _.replace(value, `:${paramKey}`, paramVal);
    });

    return value;
};

const app = new Vue({
    el: '#app'
});

/**
 * Menu
 */

function toggleClassMenu() {
    myMenu.classList.add("menu--animatable");
    if(!myMenu.classList.contains("menu--visible")) {
        myMenu.classList.add("menu--visible");
    } else {
        myMenu.classList.remove('menu--visible');
    }
}

function OnTransitionEnd() {
    myMenu.classList.remove("menu--animatable");
}

var myMenu = document.querySelector(".menu");
var openMenu = document.querySelector(".menu-open");
var closeMenu = document.querySelector(".menu-close");
myMenu.addEventListener("transitionend", OnTransitionEnd, false);
openMenu.addEventListener("click", toggleClassMenu, false);
closeMenu.addEventListener("click", toggleClassMenu, false);

/**
 * Document ready
 */

$(document).ready(function() {
    $(".btn-delete").popConfirm({
        title: trans('are-you-sure.title'),
        content: trans('are-you-sure.message'),
        yesBtn: trans('action.yes'),
        noBtn: trans('action.no'),
        placement: "top"
    });
});