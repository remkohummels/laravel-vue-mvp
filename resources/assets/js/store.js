import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

//======= vuex store start ===========
const store = new Vuex.Store({
    state: {
        restaurant: {
            number: null,
            lastLoginAt: null
        },
        salesAlerts: [],
        missingSalesCount: 0,
        productMixLinkActive: false,
        salesInputLinkActive: false,
        productProjectionLinkActive: false,
    },
    actions: {
        loadRestaurantInfo({commit}, todo) {
            commit('SET_RESTAURANT_INFO', todo);
        },

        loadSalesAlertInfo({commit}, todo) {
            commit('SET_SALES_ALERT_INFO', todo);
        },

        activeProductMixLink({commit}) {
            commit('ACTIVE_PRODUCT_MIX_LINK');
        },
        inactiveProductMixLink({commit}) {
            commit('INACTIVE_PRODUCT_MIX_LINK');
        },
        activeSalesInputLink({commit}) {
            commit('ACTIVE_SALES_INPUT_LINK');
        },
        inactiveSalesInputLink({commit}) {
            commit('INACTIVE_SALES_INPUT_LINK');
        },
        activeProductProjectionLink({commit}) {
            commit('ACTIVE_PRODUCT_PROJECTION_LINK');
        },
        inactiveProductProjectionLink({commit}) {
            commit('INACTIVE_PRODUCT_PROJECTION_LINK');
        }
    },
    mutations: {
        SET_RESTAURANT_INFO(state, restaurant) {
            state.restaurant.number = restaurant.restaurant_id;
            state.restaurant.lastLoginAt = restaurant.last_login_at;
        },
        SET_SALES_ALERT_INFO(state, info) {
            state.salesAlerts = info.salesInputs;
            state.missingSalesCount = info.missingDaysCount;
        },
        ACTIVE_PRODUCT_MIX_LINK(state) {
            state.productMixLinkActive = true;
        },
        INACTIVE_PRODUCT_MIX_LINK(state) {
            state.productMixLinkActive = false;
        },
        ACTIVE_SALES_INPUT_LINK(state) {
            state.salesInputLinkActive = true;
        },
        INACTIVE_SALES_INPUT_LINK(state) {
            state.salesInputLinkActive = false;
        },
        ACTIVE_PRODUCT_PROJECTION_LINK(state) {
            state.productProjectionLinkActive = true;
        },
        INACTIVE_PRODUCT_PROJECTION_LINK(state) {
            state.productProjectionLinkActive = false;
        }
    }
});
//======= vuex store end ===========
export default store
