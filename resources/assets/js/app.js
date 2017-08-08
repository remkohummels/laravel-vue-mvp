// Global, Essential Libraries
import './bootstrap';
import routes from './routes';
import Vue from 'vue';
import moment from "moment";
import VueMomentJS from "vue-momentjs";
import VueResource from 'vue-resource';
import VueRouter from 'vue-router';
import store from './store.js';

// Custom Components
import HeaderVue from './components/includes/Header.vue';
import FooterVue from './components/includes/Footer.vue';
import NavigationVue from './components/includes/Navigation.vue';
import LayoutVue from './components/layouts/App.vue';

// Foreign Compoents from 3rd-party Packages
import VueSlider from 'vue-slider-component';
import Datepicker from 'vuejs-datepicker';
import BounceLoader from 'vue-spinner/src/BounceLoader';

// Declare the foreign components globally
Vue.use(VueMomentJS, moment);
Vue.use(VueRouter);
Vue.use(VueResource);

export default Vue;

Vue.http.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;

export var router = new VueRouter({
    mode: 'history',
    routes: routes
});

// Declare the custom components globally
Vue.component('page-header', HeaderVue);
Vue.component('page-navigation', NavigationVue);
Vue.component('page-footer', FooterVue);
Vue.component('layout', LayoutVue);

Vue.component('vue-slider', VueSlider);
Vue.component('datepicker', Datepicker);
Vue.component('bounce-loader', BounceLoader);

Vue.component('currency-input', {
    props: ["value"],
    template: '<input type="text" v-model="displayValue" @change="change" @keyup="keyup" @blur="isInputActive = false" @focus="isInputActive = true"/>',
    data: function () {
        return {
            isInputActive: false
        }
    },
    computed: {
        displayValue: {
            get: function() {
                if (this.isInputActive) {

                    // Cursor is inside the input field. unformat display value for user
                    return this.value.toString();

                } else {

                    // User is not modifying now. Format display value for user interface
                    return "$" + this.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");

                }
            },
            set: function(modifiedValue) {

                // Recalculate value after ignoring "$" and "," in user input
                let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""));

                // Ensure that it is not NaN
                if (isNaN(newValue)) {
                    newValue = 0;
                }

                // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
                // $emit the event so that parent component gets it
                this.$emit('input', newValue);
            }
        }
    },
    methods: {
        change: function () {
            this.$emit('change');
        },
        keyup: function(event) {
            this.$emit('keyup', event);
        }
    }
});

// This is a global mixin, it is applied to every vue instance
Vue.mixin({
    data: function() {
        return {
            get browserTimezoneOffset() {
                return moment().utcOffset();
            }
        }
    }
});

// Register a custom filter globally
Vue.filter('formatTime', function(value) {
    if (value) {
        return moment(value, 'hh:mm:ss').format('h:mm A');
    }
});

// Initialize the vue components with laravel views
new Vue({
    el: '#app',
    router: router,
    store: store,
    created: function() {
        let self = this;

        /* get restaurant info */
        this.$http.get('/dashboard/restaurant-info').then(function(response) {
            self.$store.dispatch('loadRestaurantInfo', response.body.restaurant);
        }, function(err) {

        });
        // /* get sales alert info */
        this.$http.get('/sales-input/alert-info/' + this.$moment.utc().format('YYYY-MM-DD')).then(function(response) {
            self.$store.dispatch('loadSalesAlertInfo', response.body);
        }, function(err) {

        });
    }
});
