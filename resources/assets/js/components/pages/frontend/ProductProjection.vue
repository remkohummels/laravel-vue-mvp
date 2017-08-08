<template>
  <layout>
    <div slot="section" class="container" id="frontend_product_projection">
        <div class="row">
        <div class="col-md-12">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li class="open-tab active" id="openTab" role="presentation">
              <a href="#openPanel" aria-controls="open" role="tab" data-toggle="tab" aria-expanded="true" @click="changeShift('Opening')">Opening Shift</a>
            </li>
            <li class="close-tab" id="closeTab" role="presentation">
              <a href="#closePanel" aria-controls="close" role="tab" data-toggle="tab" aria-expanded="false" @click="changeShift('Closing')">Closing Shift</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div role="tabpanel" v-bind:class="[this.shift == 'Opening' ? 'open-panel' : 'close-panel','tab-pane active']" class="" id="openPanel">
              <div class="col-lg-5 col-md-6 section-info">
                <div class="responsive-table">
                  <table class="table table-sm">
                    <tbody>
                      <tr>
                        <th colspan="6" class="emptycol border-top-disable"></th>
                        <td class="headcol background-white">Day</td>
                      </tr>
                      <tr>
                        <td colspan="7" class="row-divider"></td>
                      </tr>
                      <tr>
                        <th>Restaurant:</th>
                        <td class="col-divider"></td>
                        <td class="background-white">{{ this.$store.state.restaurant.number }}</td>
                        <td class="col-divider"></td>
                        <th>Projected Sales:</th>
                        <td class="col-divider"></td>
                        <td class="background-white">
                          <currency-input v-model="projectedSalesTotal" disabled></currency-input>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="7" class="row-divider"></td>
                      </tr>
                      <tr class="inputFocus">
                        <th><strong>{{ shift }} Mod:</strong></th>
                        <td class="col-divider"></td>
                        <td class="editcol background-white">
                          <input type="text" ref="productOpenModInput" :class="[shift != 'Opening' ? 'hide' : '']" v-model="openingMod"
                                 @change="updateProjection(expectedSalesTotal)" @keyup="checkExpectedSalesInput">
                          <input type="text" ref="productCloseModInput" :class="[shift != 'Closing' ? 'hide' : '']" v-model="closingMod"
                                 @change="updateProjection(expectedSalesTotal)" @keyup="checkExpectedSalesInput">
                        </td>
                        <td class="col-divider"></td>
                        <th>
                          <strong>Expected Sales:</strong><br>(Total Day)
                        </th>
                        <td class="col-divider"></td>
                        <td class="editcol background-white">
                          <currency-input ref="expectedSalesInput" v-model="expectedSalesTotal"
                                          @keyup="checkProductModInput" @change="updateProjection(expectedSalesTotal)"></currency-input>
                          <i v-bind:class="[diffEP.percent > 0 ? 'green-circle-mark' : 'red-circle-mark']">{{ diffEP.percent }}%</i>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="7" class="row-divider"></td>
                      </tr>
                      <tr>
                        <th colspan="4" class="emptycol"></th>
                        <th>Difference:</th>
                        <td class="col-divider"></td>
                        <td class="background-white">
                          <calculated-currency-input v-model="diffEP.value" disabled></calculated-currency-input>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-lg-6 col-md-6 section-calculator">
                <div class="responsive-table">
                  <table class="table table-sm">
                    <tbody>
                      <tr>
                        <th class="emptycol border-top-disable"></th>
                          <template v-for="(value, key) in expectedSales">
                              <td class="headcol">{{ key }}</td>
                              <td class="col-divider"></td>
                          </template>
                      </tr>
                      <tr>
                        <td colspan="12" class="row-divider"></td>
                      </tr>
                      <tr>
                        <th>Expected Sales:</th>
                          <template v-for="(value, key) in expectedSales">
                              <td>
                                  <currency-input v-model="value.value" disabled></currency-input>
                              </td>
                              <td class="col-divider"></td>
                          </template>
                      </tr>
                      <tr>
                        <td colspan="12" class="row-divider"></td>
                      </tr>
                      <tr>
                        <th class="editrowhead"><strong>Actual Sales:</strong></th>
                          <template v-for="(value, key) in actualSales">
                              <td class="editcol">
                                  <currency-input v-model="value.value"></currency-input>
                                  <i v-bind:class="[diffAE[key].percent > 0 ? 'green-circle-mark' : 'red-circle-mark']">{{ diffAE[key].percent }}%</i>
                              </td>
                              <td class="col-divider"></td>
                          </template>
                      </tr>
                      <tr>
                        <td colspan="12" class="row-divider"></td>
                      </tr>
                      <tr>
                        <th>Difference:</th>
                          <template v-for="(value, key) in diffAE">
                              <td>
                                  <calculated-currency-input v-model="value.value" disabled></calculated-currency-input>
                              </td>
                              <td class="col-divider"></td>
                          </template>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="col-lg-1 col-md-12 col-sm-12 section-output">
                <a :href="[ this.$route.path + '/export-pdf/' + expectedSalesTotal +'/' + (shift == 'Opening' ? openingMod : closingMod) +'/' + shiftLabel ]">
                  <button id="printProductProjectionPDF" type="button" class="btn btn-primary btn3d"  @click="preventSpam()">
                    <img src="images/pdf_white.png">
                    <strong class="text-uppercase text-center">
                      Print<br/>
                      Cooking<br/>
                      Schedule
                    </strong>
                  </button>
                </a>
              </div>

              <div class="col-md-12 section-schedule">
                <div class="responsive-table">
                  <table class="table table-striped text-center">
                    <tbody>
                    <tr>
                      <th class="text-uppercase headcol background-silver">
                        <span>
                          <strong>Product</strong>
                        </span>
                      </th>
                      <th class="text-uppercase headcol background-silver">
                        <strong>Unit Ct.</strong>
                      </th>
                        <template v-for="(value, key) in projectionTimes">
                            <td v-bind:colspan="value.length" class="text-uppercase background-silver"><strong>{{ key }}</strong></td>
                            <td class="col-divider"></td>
                        </template>
                    <tr>
                      <th colspan="2" class="emptycol"></th>
                      <template v-for="(value, key) in projectionTimes">
                          <td v-for="(val, k) in value" v-bind:class="[k % 2 == 0 ? 'background-silver' : 'background-dark-silver', 'border-top-disable']">
                            {{ val.toString().substr(0, 2) + ":" + val.toString().substr(2) }}
                          </td>
                          <td class="col-divider"></td>
                      </template>
                    <tr>
                      <td colspan="27" class="row-divider"></td>
                    </tr>
                    <tr>
                      <td colspan="27" class="row-divider"></td>
                    </tr>
                    <template v-for="(row, product) in schedule">
                        <tr>
                            <th class="background-white"><span>{{ product }}</span></th>
                            <th class="background-white">{{ row.info.unit }}</th>


                            <template v-for="(value, key) in row.projection">
                                <td v-for="(val, k) in value" v-bind:class="[Array.isArray(val) ? 'missing-sales' : '']">
                                    <a href="#" data-toggle="modal" data-target="#projectionOverride" @click="openModal($event, product, row.info.menu_item_id,k )">
                                        <i class="triangular-mark"></i>{{ Array.isArray(val) ? val[0] : val }}</a></td>
                                <td class="col-divider"></td>
                            </template>
                        </tr>

                    </template>
                    <!--<tr>-->
                      <!--<td colspan="23" class="row-divider"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                      <!--<td colspan="23" class="row-divider"></td>-->
                    <!--</tr>-->
                    <!--<tr>-->
                      <!--<th class="checkbox background-dark-grey">-->
                        <!--<input type="checkbox" id="lto_checkbox1">-->
                        <!--<label for="lto_checkbox1">LTO 1</label>-->
                      <!--</th>-->
                      <!--<th class="background-dark-grey">Pieces</th>-->
                      <!--<td class="background-dark-grey">3</td>-->
                      <!--<td class="background-dark-grey">3</td>-->
                      <!--<td class="col-divider"></td>-->
                      <!--<td class="background-dark-grey">3</td>-->
                      <!--<td class="background-dark-grey">12</td>-->
                      <!--<td class="background-dark-grey">12</td>-->
                      <!--<td class="background-dark-grey">33</td>-->
                      <!--<td class="background-dark-grey">33</td>-->
                      <!--<td class="background-dark-grey">16</td>-->
                      <!--<td class="background-dark-grey">16</td>-->
                      <!--<td class="background-dark-grey">10</td>-->
                      <!--<td class="background-dark-grey">10</td>-->
                      <!--<td class="col-divider"></td>-->
                      <!--<td class="background-dark-grey">8</td>-->
                      <!--<td class="background-dark-grey">8</td>-->
                      <!--<td class="background-dark-grey">5</td>-->
                      <!--<td class="col-divider"></td>-->
                      <!--<td class="background-dark-grey">5</td>-->
                      <!--<td class="background-dark-grey">5</td>-->
                      <!--<td class="col-divider"></td>-->
                      <!--<td class="background-dark-grey">5</td>-->
                      <!--<td class="background-dark-grey">5</td>-->
                    <!--</tr>-->
                    </tbody>
                  </table>
                </div>
              </div>
              <div v-bind:class="[requiredData]"></div>
            </div>
          </div> <!-- end tab-content -->
        </div> <!-- end .col-md-12 -->
      </div><!-- end .row -->

      <!-- Modal -->
		<transition>
			<div id="errorAlert" class="modal fade-scale" tabindex="-1" role="dialog" aria-labelledby="errorAlert">
				<div class="modal-dialog modal-sm" role="document">
					<div class="alert alert-danger" style="padding:10px">
						{{ errorMessage }}
					</div>
				</div>
			</div>
		</transition>
      <transition>
        <div v-if="showModal" class="modal fade-scale" id="projectionOverride" tabindex="-1" role="dialog" aria-labelledby="missingSalesModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-header">
                <h6 class="modal-title" id="avgUnitModalLabel">Product: <strong>{{ product.name }}</strong></h6>
              </div>
              <div class="modal-body">
                <div class="number-row">

                        <div v-bind:class="[ message == '' ? 'hide' : 'alert alert-danger' ]" role="alert">{{ message }}</div>

                  <div>
                    <label for="unit-count">Projected:</label>
                    <input type="number" name="unit-count" v-model="unitCount">
                  </div>
                  <button type="button" class="inc-button" v-on:click="incUnitCount()"><i class="fa fa-plus"></i></button>
                  <button type="button" class="dec-button" v-on:click="decUnitCount()"><i class="fa fa-minus"></i></button>
                </div>
                <div class="number-reset">
                  <button class="btn" v-on:click="unitCount = defaultUnitCount">Reset to Default</button>
                </div>
                <br><br>
                <div>
                    <p class="text-center">Advanced Settings</p>
                    <hr>
                    <label for="frequency">Do this:</label>
                    <select v-model="frequency" class="form-control">
                        <option value="1" >Just Today</option>
                        <option value="2">Every {{ dayofweek }} at {{ time.toString().substr(0, 2) + ":" + time.toString().substr(2) }}</option>
                    </select>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" @click="submitModal()">Submit</button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div><!-- end .container -->
  </layout>
</template>
<script>
    import Vue from 'vue';

    var calculatedCurrency = {
        props: ["value"],
        template: '<input type="text" v-model="calculatedCurrency"/>',
        computed: {
            calculatedCurrency: {
                get: function() {

                    // Recalculate value after ignoring "$" and "," in user input
                    let newValue = parseFloat(this.value.toFixed(2).replace(/[^\d\.]/g, ""));

                    // Format display value for user interface
                    let modifiedValue = (Math.abs(newValue)).toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1,");

                    // Reformat the display values with positive & negative symbol
                    if (this.value > 0)
                        return "+$" + modifiedValue;
                    else if (this.value == 0)
                        return "$" + modifiedValue;
                    else
                        return "-$" + modifiedValue;

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
        }
    };

    export default {
        components: {
            // <calculated-currency-input> will only be available in parent's template
            'calculated-currency-input': calculatedCurrency
        },
        data() {
            return {
                productProjection: {},
                projectionTimes: {},
                schedule: {},
                openingMod: null,
                closingMod: null,
                expectedSalesTotal: 0,
                projectedSalesTotal: 0.00,
                calculator: {},
                expectedSales: {},
                actualSales: {},
                diffEP: {
                    value: 0.00,
                    percent: 0
                },
                diffAE: {},
                showModal: false,
                unitCount: null,
                defaultUnitCount: null,
                shift: 'Opening',
                shiftLabel: 'Open',
                requiredData: 'modal-backdrop fade in',
                product: {
                    name: null,
                    id: null,
                },
                time: null,
                frequency: 1,
                updatedUnitElement: null,
                message: '',
                dayofweek: null,
                alert: false,
                errorMessage: '',
            }
        },
        created() {
            // -- Ajax call to get Default values
            let data = {
                'expectedSales':   this.expectedSalesTotal,
                'openingMod':         this.openingMod,
                'closingMod':        this.closingMod
            };

            this.$http.post('/product-projection/getInfo', data ).then(function(response) {

                this.productProjection = response.body.productProjection;
                this.projectionTimes = response.body.productProjection.schedule.projectionTimes;
                this.projectedSalesTotal = response.body.productProjection.projectedSalesTotal;
                this.expectedSalesTotal = response.body.productProjection.expectedSalesTotal;

                this.schedule = response.body.productProjection.schedule;
                delete this.schedule['projectionTimes'];

                this.expectedSales = response.body.productProjection.calculator.expected;
                this.actualSales = response.body.productProjection.calculator.actual;
                this.diffAE = response.body.productProjection.calculator.difference;

                this.openingMod = response.body.productProjection.openingMod;
                this.closingMod = response.body.productProjection.closingMod;

            }, function(err) {
                console.log(err.bodyText);
                this.errorMessage =  err.bodyText;
                $('#errorAlert').modal('show')
                //alert(err.bodyText);
            });


            let d = new Date();
            let weekday = new Array(7);
            weekday[0] =  "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";

            this.dayofweek = weekday[d.getDay()];

            if (this.shift == "Opening" && this.openingMod != null && this.expectedSalesTotal != 0 ){
                this.requiredData = 'hide';
            }

        },
        mounted() {
            if (this.shift == "Opening") {
                if (this.openingMod == null) {
                    this.$refs.productOpenModInput.focus();
                }
            }

            if (this.shift == "Closing") {
                if (this.closingMod == null) {
                    this.$refs.productCloseModInput.focus();
                }
            }
        },
        updated() {
            let self = this;

            // -- Total Day Calculations
            this.diffEP.value = this.expectedSalesTotal- this.projectedSalesTotal;
            this.diffEP.percent = parseInt(((this.expectedSalesTotal - this.projectedSalesTotal) / this.projectedSalesTotal) * 100);

            // -- Set calculator values
            _.each(this.actualSales, function( value, prop){
                self.diffAE[prop].value = (value.value) - (self.expectedSales[prop].value);
                self.diffAE[prop].percent = parseInt(((value.value - self.expectedSales[prop].value) / self.expectedSales[prop].value) * 100);
            });

            if (this.shift == "Opening" && this.openingMod != null && this.expectedSalesTotal != 0 ){
                this.requiredData = 'hide';
            }
        },
        methods: {
            // -- Method to prevent Spam clicking the Print Cooking Schedule Button
            preventSpam(){
                let innerHTML = document.querySelector('#printProductProjectionPDF > strong').innerHTML;

                document.querySelector('#printProductProjectionPDF').setAttribute('disabled', true);
                document.querySelector('#printProductProjectionPDF > strong').innerHTML = "<p>PLEASE </br> WAIT </p>";

                setTimeout(function(){
                    document.querySelector('#printProductProjectionPDF').removeAttribute('disabled');
                    document.querySelector('#printProductProjectionPDF > strong').innerHTML = innerHTML;
                }, 10000)
            },

            // -- Check the next cursor focus with not-filled input
            checkExpectedSalesInput(e) {
                if (e.keyCode === 13) {
                    if (this.expectedSalesTotal == 0) {
                        this.$refs.expectedSalesInput.$el.focus();
                    }
                }
            },
            checkProductModInput(e) {
                if (e.keyCode === 13) {
                    if (this.shift == "Opening") {
                        if (this.openingMod == null) {
                            this.$refs.productOpenModInput.focus();
                        }
                    }

                    if (this.shift == "Closing") {
                        if (this.closingMod == null) {
                            this.$refs.productCloseModInput.focus();
                        }
                    }
                }
            },

            // -- Modal functions
            openModal(e, name, id, time) {
                this.showModal = true;
                this.unitCount = parseInt(e.target.text);
                this.defaultUnitCount = this.unitCount;
                this.time = time;
                this.product.name = name;
                this.product.id = id;
                this.updatedUnitElement = e.target;

            },
            closeModal() {
                this.showModal = false;
            },
            submitModal() {
                // Serialize the changed data of unit ct.
                let data = {
                    'product_id':   this.product.id,
                    'time':         this.time,
                    'value':        this.unitCount,
                    'frequency':    this.frequency
                };

                /* update the changed data of unit ct. */
                this.$http.post('/product-projection/override', data).then(function (response) {

                    // toggle the updated unit ct. as red-marked value
                    this.updatedUnitElement.parentElement.className += ' missing-sales';

                    // update the unit ct.
                    this.updatedUnitElement.innerHTML = '<i class="triangular-mark"></i>' + this.unitCount;

                    // toggle the modal as closing
                    this.showModal = false;

                    this.message = '';

                }, function (err) {
                    this.showModal = true;
                    this.message = err.bodyText;
                    $('#projectionOverride').modal('show');

                });
            },
            changeShift(e){
                this.shift = e;

                // -- Table Scroll for Shift
                if( this.shift == "Opening"){
                    document.querySelector('.section-schedule .responsive-table').scrollLeft = 0;
                    document.querySelector('.section-calculator .responsive-table').scrollLeft = 0;
                    this.shiftLabel = 'Open';
                }else if (this.shift == "Closing"){
                    document.querySelector('.section-schedule .responsive-table').scrollLeft = 1000;
                    document.querySelector('.section-calculator .responsive-table').scrollLeft = 1000;
                    this.shiftLabel = 'Close'; 
                }

                // -- Grey Overlay
                if (this.shift == "Opening" && (this.openingMod == null || this.expectedSalesTotal == 0 )) {
                    this.requiredData = 'modal-backdrop fade in';
                }else if (this.shift == "Closing" && (this.closingMod == null || this.expectedSalesTotal == 0)) {
                    this.requiredData = 'modal-backdrop fade in';
                }else{
                    this.requiredData = 'hide';
                }
            },
            updateProjection(e) {

                // -- Ajax call for ProductProjection
                if ((this.shift == "Opening" && this.openingMod != null && this.expectedSalesTotal != 0) ||
                    (this.shift == "Closing" && this.closingMod != null && this.expectedSalesTotal != 0) ) {

                    let data = {
                        'expectedSales':   this.expectedSalesTotal,
                        'openingMod':         this.openingMod,
                        'closingMod':        this.closingMod
                    };

                    this.$http.post('/product-projection/getInfo', data ).then(function(response) {

                        this.productProjection = response.body.productProjection;
                        this.projectionTimes = response.body.productProjection.schedule.projectionTimes;
                        this.projectedSalesTotal = response.body.productProjection.projectedSalesTotal;
                        this.expectedSalesTotal = response.body.productProjection.expectedSalesTotal;

                        this.schedule = response.body.productProjection.schedule;
                        delete this.schedule['projectionTimes'];

                        this.expectedSales = response.body.productProjection.calculator.expected;
                        this.actualSales = response.body.productProjection.calculator.actual;

                        this.openingMod = response.body.productProjection.openingMod;
                        this.closingMod = response.body.productProjection.closingMod;

                    }, function (err) {
                        console.log(err.bodyText);
		                this.errorMessage =  err.bodyText;
		                $('#errorAlert').modal('show')
                        
                        //alert(err.bodyText);
                    });

                    this.requiredData = 'hide';

                }else{
                    this.requiredData = 'modal-backdrop fade in';
                }
            },

            // -- Number increase/decrease functions
            incUnitCount() {
                this.unitCount = parseInt(this.unitCount) + 1;
            },
            decUnitCount() {
                if (this.unitCount > 0)
                    this.unitCount = parseInt(this.unitCount) - 1;
            },
        },
    }

</script>
