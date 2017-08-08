<template>
  <layout>
    <div slot="section" class="container" id="frontend_dashboard">
      <div class="row">
        <div class="col-md-4 col-md-offset-1 col-sm-6 action-buttons wow fadeInLeft" data-wow-delay="0.2s">
          <div class="product-mix">
            <router-link :to="{ name: 'product-mix' }" @click.native="productMixBtnInactive">
              <button type="button" :class="['btn btn-lg btn-block btn-info btn3d', productMixEdited(productMixUpdatedAt) ? 'btn-grey' : '']"
                      @mouseover="productMixBtnActive" @mouseleave="productMixBtnInactive">
                <img src="images/chicken_icon.png" @mouseover="productMixBtnActive" @mouseleave="productMixBtnActive">
                <strong class="text-uppercase text-left" @mouseover="productMixBtnActive" @mouseleave="productMixBtnActive">
                  <b v-if="productMixEdited(productMixUpdatedAt)">You Did It!</b>
                  <b v-else>Confirm Product Mix</b>
                </strong>
                <span v-if="productMixEdited(productMixUpdatedAt)">
                  Product Mix Last Reviewed {{ this.$moment.utc(productMixUpdatedAt).utcOffset(browserTimezoneOffset).fromNow() }}
                </span>
              </button>
            </router-link>
          </div>
          <div class="sales-input">
            <router-link :to="{ name: 'sales-input' }" @click.native="salesInputBtnInactive">
              <button type="button" :class="['btn btn-lg btn-block btn-success btn3d', yesterdaySalesEdited ? 'btn-grey' : '']"
                      @mouseover="salesInputBtnActive" @mouseleave="salesInputBtnInactive">
                <img src="images/dollar_icon.png" @mouseover="salesInputBtnActive" @mouseleave="salesInputBtnActive">
                <strong class="text-uppercase text-left" @mouseover="salesInputBtnActive" @mouseleave="salesInputBtnActive">
                  <b v-if="yesterdaySalesEdited">Done!</b>
                  <b v-else>Enter Yesterday's<br>Sales</b>
                </strong>
                <span v-if="yesterdaySalesEdited">Sales Input</span>
              </button>
            </router-link>
          </div>
          <div class="product-projection">
            <router-link :to="{ name: 'product-projection' }" @click.native="productProjectionBtnInactive">
              <button type="button" :class="['btn btn-lg btn-block btn-warning btn3d', todayProductProjectionEdited ? 'btn-grey' : '']"
                      @mouseover="productProjectionBtnActive" @mouseleave="productProjectionBtnInactive">
                <img src="images/calendar_icon.png" @mouseover="productProjectionBtnActive" @mouseleave="productProjectionBtnActive">
                <strong class="text-uppercase text-left" @mouseover="productProjectionBtnActive" @mouseleave="productProjectionBtnActive">
                  <b v-if="todayProductProjectionEdited">Done!</b>
                  <b v-else>Get Today's<br>Product Projection</b>
                </strong>
                <span v-if="todayProductProjectionEdited">Product Projection</span>
              </button>
            </router-link>
          </div>
        </div><!-- end .col-md-6 -->

        <div class="col-md-5 col-md-offset-1 col-sm-6 wow fadeInRight measuring-up" data-wow-delay="0.4s">
          <div>
            <h4 class="text-center text-capitalize">How Are You Measuring Up?</h4>
            <table class="measuring-overlay-table">
              <thead>
              <tr>
                <th></th>
                <th class="text-center">My Score</th>
                <th class="text-center">Vs. Last Period</th>
                <th class="text-center">Last Period</th>
                <th class="text-center">System Score</th>
              </tr>
              </thead>
              <tbody>
              <tr>
                <td class="row-name">Overall Satisfaction</td>
                <td class="text-center blue-circle">
                  <span>{{ (smg['cw']['overall_satisfaction_score'] * 100).toFixed(1) }}%</span>
                </td>
                <td v-bind:class="toggleValue(smg['cw']['overall_satisfaction_score'] - smg['pw']['overall_satisfaction_score'])">
                  {{ toggleSymbol(smg['cw']['overall_satisfaction_score'] - smg['pw']['overall_satisfaction_score']) +
                    ((smg['cw']['overall_satisfaction_score'] - smg['pw']['overall_satisfaction_score']) * 100).toFixed(1) }}%
                </td>
                <td class="text-center blue-circle">
                  <span>{{ (smg['pw']['overall_satisfaction_score'] * 100).toFixed(1) }}%</span>
                </td>
                <td class="text-center blue-circle system-score">
                  <span>{{ (smg['system']['overall_satisfaction_score'] * 100).toFixed(1) }}%</span>
                </td>
              </tr>
              <tr>
                <td class="row-name">Taste of Food</td>
                <td class="text-center blue-circle">
                  <span>{{ (smg['cw']['taste_of_food_score'] * 100).toFixed(1) }}%</span>
                </td>
                <td v-bind:class="toggleValue(smg['cw']['taste_of_food_score'] - smg['pw']['taste_of_food_score'])">
                  {{ toggleSymbol(smg['cw']['taste_of_food_score'] - smg['pw']['taste_of_food_score']) +
                    ((smg['cw']['taste_of_food_score'] - smg['pw']['taste_of_food_score']) * 100).toFixed(1) }}%
                </td>
                <td class="text-center blue-circle">
                  <span>{{ (smg['pw']['taste_of_food_score'] * 100).toFixed(1) }}%</span>
                </td>
                <td class="text-center blue-circle system-score">
                  <span>{{ (smg['system']['taste_of_food_score'] * 100).toFixed(1) }}%</span>
                </td>
              </tr>
              <tr>
                <td class="row-name">Speed of Service</td>
                <td class="text-center blue-circle">
                  <span>{{ (smg['cw']['speed_of_service_score'] * 100).toFixed(1) }}%</span>
                </td>
                <td v-bind:class="toggleValue(smg['cw']['speed_of_service_score'] - smg['pw']['speed_of_service_score'])">
                  {{ toggleSymbol(smg['cw']['speed_of_service_score'] - smg['pw']['speed_of_service_score']) +
                    ((smg['cw']['speed_of_service_score'] - smg['pw']['speed_of_service_score']) * 100).toFixed(1) }}%</td>
                <td class="text-center blue-circle">
                  <span>{{ (smg['pw']['speed_of_service_score'] * 100).toFixed(1) }}%</span>
                </td>
                <td class="text-center blue-circle system-score">
                  <span>{{ (smg['system']['speed_of_service_score'] * 100).toFixed(1) }}%</span>
                </td>
              </tr>
              <tr>
                <td colspan="5" class="text-center update-date">Updated: {{ smgUpdatedAt }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </div><!-- end .col-md-6 -->
      </div><!-- end .row -->
    </div><!-- end .container -->
  </layout>
</template>
<script>
    import layout from '../../layouts/App.vue';
    export default {
        components: { layout },
        data() {
            return {
                smg: {
                    cw: {},
                    pw: {},
                    system: {}
                },
                smgUpdatedAt: null,
                productMixUpdatedAt: null,
                productMixEdited: function(date) {
                    if (date == null) {
                        return false;
                    } else {
                        let momentDate = this.$moment.utc(date);
                        let momentCurrentWeek = this.$moment.utc().startOf('week');
                        return (momentDate.isSame(momentCurrentWeek, 'week'));
                    }

                },
                yesterdaySalesEdited: false,
                todayProductProjectionEdited: false,
                toggleValue: function(value) {
                    if (value > 0)
                        return 'text-center last-period positive-value';
                    else if (value < 0)
                        return 'text-center last-period negative-value';
                    else
                        return 'text-center last-period';
                },
                toggleSymbol: function(value) {
                    if (value > 0)
                        return '+';
                    else
                        return '';
                }
            }
        },
        created() {
            let self = this;
            this.$http.get('/dashboard/smg-score').then(function(response) {
                self.smg = response.body.smg;
                self.smgUpdatedAt = response.body.smgUpdatedAt;

                let productMixModifier = response.body.productMixModifier;
                if (productMixModifier != null)
                    self.productMixUpdatedAt = productMixModifier['updated_at'];

                self.yesterdaySalesEdited = response.body.yesterdaySalesEdited;
                self.todayProductProjectionEdited = response.body.todayProductProjectionEdited;
            }, function(err) {

            });
        },
        methods: {
            productMixBtnActive: function() {
                this.$store.dispatch('activeProductMixLink');
            },
            productMixBtnInactive: function() {
                this.$store.dispatch('inactiveProductMixLink');
            },
            salesInputBtnActive: function() {
                this.$store.dispatch('activeSalesInputLink');
            },
            salesInputBtnInactive: function() {
                this.$store.dispatch('inactiveSalesInputLink');
            },
            productProjectionBtnActive: function() {
                this.$store.dispatch('activeProductProjectionLink');
            },
            productProjectionBtnInactive: function() {
                this.$store.dispatch('inactiveProductProjectionLink');
            }
        }
    }
</script>
