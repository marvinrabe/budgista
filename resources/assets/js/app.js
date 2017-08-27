/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./pace.min');
require('./jquery.popconfirm');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('recurrence', require('./components/Recurrence.vue'));

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

$(document).ready(function() {
    $(".btn-delete").popConfirm({
        title: "Delete Item",
        content: "Are you sure you want to delete this item?",
        placement: "top"
    });
});