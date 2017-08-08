<template>
  <layout>
    <div slot="section" class="container" id="frontend_product_mix">
      <div class="row section-header">
        <div class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
          <span class="section-title">Product Mix MOD</span>
          <span class="section-edit" v-if="productMixModifier != null">
            Last edit: {{ this.$moment.utc(productMixModifier['updated_at']).utcOffset(browserTimezoneOffset).format('MM/DD/YYYY') }}

            <!-- - <a href="#">View History</a>-->
          </span>
        </div>
      </div>
      <div class="row section-action">
        <div class="col-md-6 col-sm-6 section-reset">
          <!--<button class="btn">Reset Product Mix</button>-->
        </div>
        <div class="col-md-6 col-sm-6 text-right section-output">
          <!--<a :href="[ this.$route.path + '/export-pdf' ]" class="pdf-print" @click="exportPDF()">Print<img src="images/pdf.png"></a>-->
          <!--<a :href="[ this.$route.path + '/export-excel' ]" class="excel-export" @click="exportExcel()">Export<img src="images/excel.png"></a>-->
          <div class="btn-export">
            <a href class="pdf-print" @click="exportPDF()" v-if="isLoading == false">
              Print<img src="images/pdf.png">
            </a>
            <a class="pdf-print" @click="exportPDF()" v-else>
              <bounce-loader :size="'30px'"></bounce-loader>
            </a>
            <a :href="[ this.$route.path + '/export-excel' ]" class="excel-export" @click="exportExcel()">Export<img src="images/excel.png"></a>
          </div>
        </div>
      </div>
      <div class="row section-body">
        <div class="col-lg-12">
          <div class="responsive-table">

            <table class="table table-striped text-center">
              <tbody>
              <tr>
                <th class="text-uppercase headcol background-white col-border-bottom col-border-left">
                    <span>
                      <strong>Product</strong>
                    </span>
                </th>
                <th class="text-uppercase headcol background-white col-border-right col-border-bottom">
                  <strong>Unit Ct.</strong>
                </th>
                <td colspan="7" class="text-uppercase col-border-right col-border-left"><strong>Avg. Pieces Sold On Any Given...</strong></td>
              </tr>
              <tr>
                <th colspan="2" class="emptycol"></th>
                <td class="background-white border-top-disable col-border-bottom col-border-left">Monday</td>
                <td class="border-top-disable col-border-bottom">Tuesday</td>
                <td class="background-white border-top-disable col-border-bottom">Wednesday</td>
                <td class="border-top-disable col-border-bottom">Thursday</td>
                <td class="background-white border-top-disable col-border-bottom">Friday</td>
                <td class="border-top-disable col-border-bottom">Saturday</td>
                <td class="background-white border-top-disable col-border-right col-border-bottom">Sunday</td>
              </tr>
              <tr v-if="productMixRequiredList.length > 0">
                <td colspan="9" class="row-divider"></td>
              </tr>
              <tr v-if="productMixRequiredList.length > 0">
                <td colspan="9" class="row-divider"></td>
              </tr>
              <tr v-for="(row, index) in productMixRequiredList">
                <th v-bind:class="[index % 2 == 0 ? 'background-white' : 'background-grey', 'col-border-left']">
                  <span>{{ row['menu_item_name'] }}</span>
                </th>
                <th v-bind:class="[index % 2 == 0 ? 'background-white' : 'background-grey', 'col-border-right']">
                  {{ row['unit'] }}
                </th>
                <td :class="[row['monday'] != productMixDefaultList[row['menu_item_id']]['monday'] ? 'missing-sales' : '', 'col-border-left']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'monday')">
                    <i class="triangular-mark"></i>{{ row['monday'] }}</a>
                </td>
                <td :class="[row['tuesday'] != productMixDefaultList[row['menu_item_id']]['tuesday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'tuesday')">
                    <i class="triangular-mark"></i>{{ row['tuesday'] }}</a>
                </td>
                <td :class="[row['wednesday'] != productMixDefaultList[row['menu_item_id']]['wednesday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'wednesday')">
                    <i class="triangular-mark"></i>{{ row['wednesday'] }}</a>
                </td>
                <td :class="[row['thursday'] != productMixDefaultList[row['menu_item_id']]['thursday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'thursday')">
                    <i class="triangular-mark"></i>{{ row['thursday'] }}</a>
                </td>
                <td :class="[row['friday'] != productMixDefaultList[row['menu_item_id']]['friday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'friday')">
                    <i class="triangular-mark"></i>{{ row['friday'] }}</a>
                </td>
                <td :class="[row['saturday'] != productMixDefaultList[row['menu_item_id']]['saturday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'saturday')">
                    <i class="triangular-mark"></i>{{ row['saturday'] }}</a>
                </td>
                <td :class="[row['sunday'] != productMixDefaultList[row['menu_item_id']]['sunday'] ? 'missing-sales' : '', 'col-border-right']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'sunday')">
                    <i class="triangular-mark"></i>{{ row['sunday'] }}</a>
                </td>
              </tr>
              <tr v-if="productMixLimitedList.length > 0">
                <td colspan="9" class="row-divider"></td>
              </tr>
              <tr v-if="productMixLimitedList.length > 0">
                <td colspan="9" class="row-divider"></td>
              </tr>
              <tr v-for="(row, index) in productMixLimitedList">
                <th v-bind:class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey', 'col-border-left checkbox']">
                  <input type="checkbox" :id="[ 'lto_checkbox__' + index ]">
                  <label :for="[ 'lto_checkbox__' + index ]">{{ row['menu_item_name'] }}</label>
                </th>
                <th v-bind:class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey', 'col-border-right']">
                  {{ row['unit'] }}
                </th>
                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                            row['monday'] != productMixDefaultList[row['menu_item_id']]['monday'] ? 'missing-sales' : '', 'col-border-left']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'monday')">
                    <i class="triangular-mark"></i>{{ row['monday'] }}</a>
                </td>

                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                            row['tuesday'] != productMixDefaultList[row['menu_item_id']]['tuesday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'tuesday')">
                    <i class="triangular-mark"></i>{{ row['tuesday'] }}</a>
                </td>
                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                                  row['wednesday'] != productMixDefaultList[row['menu_item_id']]['wednesday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'wednesday')">
                    <i class="triangular-mark"></i>{{ row['wednesday'] }}</a>
                </td>
                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                                  row['thursday'] != productMixDefaultList[row['menu_item_id']]['thursday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'thursday')">
                    <i class="triangular-mark"></i>{{ row['thursday'] }}</a>
                </td>
                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                            row['friday'] != productMixDefaultList[row['menu_item_id']]['friday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'friday')">
                    <i class="triangular-mark"></i>{{ row['friday'] }}</a>
                </td>
                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                            row['saturday'] != productMixDefaultList[row['menu_item_id']]['saturday'] ? 'missing-sales' : '']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'saturday')">
                    <i class="triangular-mark"></i>{{ row['saturday'] }}</a>
                </td>
                <td :class="[index % 2 == 0 ? 'background-dark-grey' : 'background-grey',
                            row['sunday'] != productMixDefaultList[row['menu_item_id']]['sunday'] ? 'missing-sales' : '', 'col-border-right']">
                  <a href="#" data-toggle="modal" data-target="#avgUnitModal" @click="openModal($event, row['id'], 'sunday')">
                    <i class="triangular-mark"></i>{{ row['sunday'] }}</a>
                </td>
              </tr>
              </tbody>
            </table>

          </div><!-- end .responsive-table -->
        </div><!-- end .col-lg-12 -->
      </div><!-- end .section-body -->
      <div class="row text-center section-footer">
        <router-link :to="{ name: 'dashboard' }">
          <button type="button" class="btn btn-lg btn-primary btn3d">
            <strong class="text-uppercase text-center">
              I'm Done...<br>Take Me To Home Screen
            </strong>
          </button>
        </router-link>
      </div><!-- end .section-footer -->

      <!-- Modal -->
      <transition>
        <div v-if="showModal" class="modal fade-scale" id="avgUnitModal" tabindex="-1" role="dialog" aria-labelledby="avgUnitModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-header">
                <h6 class="modal-title" id="avgUnitModalLabel">Average Units Sold</h6>
              </div>
              <div class="modal-body">
                <div class="number-row">
                  <div>
                    <label for="unit-count">Sold:</label>
                    <input type="number" name="unit-count" v-model="unitCount">
                  </div>
                  <button type="button" class="inc-button" v-on:click="incUnitCount()"><i class="fa fa-plus"></i></button>
                  <button type="button" class="dec-button" v-on:click="decUnitCount()"><i class="fa fa-minus"></i></button>
                </div>
                <!--<div class="number-reset">-->
                  <!--<button class="btn" v-on:click="unitCount = defaultUnitCount">Reset to Default</button>-->
                <!--</div>-->
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
    export default {
        ready() {
            console.log('success');
        },
        data() {
            return {
                productMixRequiredList: {},
                productMixLimitedList: {},
                productMixDefaultList: {},
                productMixModifier: {},
                isLoading: false,
                showModal: false,
                rowPk: 1,
                fieldName: null,
                unitCount: 0,
                defaultUnitCount: 0,
                updatedUnitElement: null
            }
        },
        methods: {
            // -- PDF & Excel export functions
            exportPDF() {
                this.isLoading = true;

                // Export the PDF of product-mix table
                this.$http.get('/product-mix/export-pdf').then(function (response) {

                    this.isLoading = false;
                    console.log(response.body.pdfFileName);

                    window.location.href = '/product-mix/download/pdf';

                }, function (err) {

                    this.isLoading = false;
                    console.log('err');

                });
            },
            exportExcel() {

            },

            // -- Modal functions
            openModal(e, row_pk, field_name) {
                // Toggle the modal as opening
                this.showModal = true;

                // Indicate the row_pk of unit ct.
                this.rowPk = row_pk;

                // Indicate the field name of unit ct.
                this.fieldName = field_name;

                // Initialize the unit ct. on the opening modal
                this.unitCount = parseInt(e.target.text);

                // Initialize the default unit ct. before opening the modal
                this.defaultUnitCount = this.unitCount;

                // Save the target element before updating it on the opening modal
                this.updatedUnitElement = e.target;
            },
            closeModal() {
                // Toggle the modal as closing
                this.showModal = false;
            },
            submitModal() {
                // Serialize the changed data of unit ct.
                let data = {
                    'rowPk': this.rowPk,
                    'fieldName': this.fieldName,
                    'unitCount': this.unitCount
                };

                /* Update the changed data of unit ct. */
                this.$http.post('/product-mix/update', data).then(function (response) {

                    // Update the productMixModifier with a new one
                    this.productMixModifier = response.body.productMixModifier;

                    // Toggle the updated unit ct. as red-marked value
                    this.updatedUnitElement.parentElement.className += ' missing-sales';

                    // Update the unit ct.
                    this.updatedUnitElement.innerHTML = '<i class="triangular-mark"></i>' + this.unitCount;

                    // Toggle the modal as closing
                    this.showModal = false;

                }, function (err) {

                });
            },

            // -- Number increase/decrease functions
            incUnitCount() {
                this.unitCount = parseInt(this.unitCount) + 1;
            },
            decUnitCount() {
                if (this.unitCount > 0)
                    this.unitCount = parseInt(this.unitCount) - 1;
            }
        },
        created() {
            let self = this;

            // Get the loading data of product-mix table
            this.$http.get('/product-mix/info').then(function (response) {
                self.productMixRequiredList = response.body.productMixRequiredList;
                self.productMixLimitedList = response.body.productMixLimitedList;
                self.productMixDefaultList = response.body.productMixDefaultList;
                self.productMixModifier = response.body.productMixModifier;
            }, function (err) {

            });
        }
    }
</script>
