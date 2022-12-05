/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


window.Vue = require('vue');
require('./bootstrap');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/message.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('notification-component', require('./components/notification.vue').default);
Vue.component('emergency-component', require('./components/emergency.vue').default);
Vue.component('offer-component', require('./components/offerType.vue').default);
Vue.component('order-component', require('./components/OrdersComponent.vue').default);
Vue.component('shop-notifications-component', require('./components/ShopNotifications.vue').default);
Vue.component('sizes-component', require('./components/sizes_component.vue').default);
Vue.component('products-component', require('./components/product_component.vue').default);
Vue.component('shop-delivered-orders', require('./components/Shop-Delivered-orders.vue').default);
Vue.component('admin-statistics', require('./components/AdminStatistics.vue').default);
Vue.component('admin-orders-statistics', require('./components/Admin_orders_table.vue').default);
Vue.component('driver-details', require('./components/Driver_details').default);
Vue.component('admin-order-notification', require('./components/Admin_Order_Notification').default);
Vue.component('order-admin-notification', require('./components/Orders-admin-Component').default);
Vue.component('order-admin-add', require('./components/Orders-admin-add-Component').default);
Vue.component('admin-activities', require('./components/Activities').default);
Vue.component('under-constructions', require('./components/underConstructions').default);
Vue.component('driver-blocked', require('./components/blocked').default);
Vue.component('get-trips', require('./components/trips').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */





const app = new Vue({
    el: "#app",
    mounted: function() {
        document.addEventListener('click', function() {
            document.getElementById('xyz').load();
        });
    }
});