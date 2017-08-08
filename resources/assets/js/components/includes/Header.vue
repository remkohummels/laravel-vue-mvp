<template>
  <header id="header_section">
    <!-- Sales Alert -->
    <div class="sales-alert text-center" v-if="this.$store.state.missingSalesCount > 0">
      <div class="container">
        <p class="col-md-12 col-sm-12">
          You have <strong>{{ this.$store.state.missingSalesCount }} days</strong> missing sales figures. <a href="#" data-toggle="modal" data-target="#salesAlertModal" @click="openModal($event)">Complete Daily Figures.</a>
        </p>
      </div>
    </div>
    <!-- Sales Alert Modal -->
    <transition>
      <div v-if="showModal" class="modal fade-scale" id="salesAlertModal" tabindex="-1" role="dialog" aria-labelledby="salesAlertModalLabel">
        <div class="modal-dialog modal-bg" role="document">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()" ref="closeModalBtn">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-header">
              <h3 class="modal-title" id="avgUnitModalLabel">You have {{ this.$store.state.missingSalesCount }} days</h3>
            </div>
            <div class="modal-body">
              <datepicker  :inline="true" :highlighted="state.highlighted" :disabled="state.disabled"
                           v-on:selected="linkToSalesInput" class="sales-alert-calendar"></datepicker>
              <!--<div class="number-reset">-->
              <!--<button class="btn" v-on:click="unitCount = defaultUnitCount">Reset to Default</button>-->
              <!--</div>-->
            </div>
          </div>
        </div>
      </div>
    </transition>
    <!-- Header Content -->
    <div class="header">
      <div class="container">
        <div class="row header-overlay">
          <div class="col-lg-2 col-md-2 col-sm-12 header-logo text-center">
            <router-link :to="{ name: 'dashboard' }">
              <img src="images/fready_logo.png" alt="Header Logo">
            </router-link>
          </div>

          <div class="col-lg-7 col-md-6 col-sm-6 header-info">
            <p>
              <strong class="restaurant-number">Restaurant {{ this.$store.state.restaurant.number }}</strong><br/>
              <strong v-if="this.$store.state.restaurant.lastLoginAt == null">Welcome to Login Restaurant MOD First</strong>
              <strong v-else>Last Restaurant MOD Login: {{ this.$moment.utc(this.$store.state.restaurant.lastLoginAt).utcOffset(browserTimezoneOffset).calendar() }}</strong>
            </p>
          </div>

          <div class="col-lg-3 col-md-4 col-sm-6 header-link text-right">
            <ul class="list-inline">

              <!-- weather dropdown -->
              <li class="col-md-12 col-sm-12 weather-dropdown">
                <!--<div class="btn-group">-->
                  <!--<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">-->
                    <!--<span class="caret"></span>-->
                  <!--</button>-->
                  <!--<button class="btn btn-default" data-toggle="dropdown">-->
                    <!--<strong>76° F</strong>&nbsp;&nbsp;&nbsp;-->
                    <!--<i class="wi wi-day-cloudy"></i>-->
                  <!--</button>-->
                  <!--<ul class="dropdown-menu pull-right">-->
                    <!--<li>-->
                      <!--<p>9:00</p>-->
                      <!--<a href="#"><i class="wi wi-day-cloudy"></i><br><strong>76° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>9:30</p>-->
                      <!--<a href="#"><i class="wi wi-rain"></i><br><strong>77° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>10:00</p>-->
                      <!--<a href="#"><i class="wi wi-storm-showers"></i><br><strong>78° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>10:30</p>-->
                      <!--<a href="#"><i class="wi wi-day-sunny"></i><br><strong>79° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>11:00</p>-->
                      <!--<a href="#"><i class="wi wi-day-snow"></i><br><strong>80° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>11:30</p>-->
                      <!--<a href="#"><i class="wi wi-hot"></i><br><strong>81° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>12:00</p>-->
                      <!--<a href="#"><i class="wi wi-day-cloudy"></i><br><strong>82° F</strong></a>-->
                    <!--</li>-->
                    <!--<li>-->
                      <!--<p>12:30</p>-->
                      <!--<a href="#"><i class="wi wi-day-cloudy"></i><br><strong>83° F</strong></a>-->
                    <!--</li>-->
                  <!--</ul>-->
                <!--</div>-->
              </li><!-- end .weather-dropdown -->

              <!--<li class="return-admin clearfix"><a href="#">Return to Admin</a></li>-->
              <!--<li class="help clearfix"><a href="#">Help</a></li>-->
              <li class="logout clearfix"><a href="/logout">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div><!-- end .header -->
  </header>
</template>

<script>
    export default {
        name: 'HeaderVue',
        data() {
            return {
                showModal: false,
                updatedUnitElement: null,
                state: {
                    disabled: {
                        dates: []
                    },
                    highlighted: {
                        dates: [
                        ]
                    }
                }
            }
        },
        methods: {
            openModal(e) {

                let salesAlertDates = this.$store.state.salesAlerts;
                for (let item of salesAlertDates) {
                    let dateObj = this.$moment.utc(item.date).utcOffset(this.browserTimezoneOffset).toDate();
                    if (item.id * 1 !== 0)
                      this.state.highlighted.dates.push(dateObj);
                    else this.state.disabled.dates.push(dateObj);
                }
                // Toggle the modal as opening
                this.showModal = true;

                // Save the target element before updating it on the opening modal
                this.updatedUnitElement = e.target;
            },
            linkToSalesInput (val) {
                for (let item of this.state.highlighted.dates) {
                    /* check if this date is highlighted value */
                    if (this.$moment(item).format('YYYY-M-D') === this.$moment(val).format('YYYY-M-D')) {
                        const elem = this.$refs.closeModalBtn;
                        elem.click();
                        /* go to sales input with date */
                        /*this.$router.push('sales-input?date=' + this.$moment(val).format('YYYY-M-D'));*/
//                        this.$router.push({name: 'sales-input', query: { date: this.$moment(val).format('YYYY-M-D') }});
                        window.location.href = "/sales-input?date="  + this.$moment(val).format('YYYY-M-D');
                    }
                }

            },
            closeModal() {
                // Toggle the modal as closing
                this.showModal = false;
            },
            submitModal() {
            },
        }
    }
</script>
