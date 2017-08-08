<template>
  <layout>
    <div slot="section" class="container" id="frontend_sales_input">
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 text-right section-output">
          <a :href="[ this.$route.path + '/export-pdf' ]" class="pdf-print">Print<img src="images/pdf.png"></a>
          <a :href="[ this.$route.path + '/export-excel' ]" class="excel-export">Export<img src="images/excel.png"></a>
        </div>
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 comment">
          You are Editing Sales for <b>{{ selectedDate }}</b>
          <br/>
          Enter your hourly sales below.
          If you'd like to fill in missing past dates, pick from the calendar below.
          <hr>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6 col-lg-offset-1 col-md-6 col-md-offset-1 col-sm-6 col-sm-offset-1 col-xs-12 timevalues">
          <div class="row top-save text-center">
            <button class="btn" v-on:click="update">Save</button>
          </div>
          <div class="row header">
            <div class="col-lg-4 col-md-4 col-sm-5 col-xs-4 text-center">
              Time
            </div>
            <div class="col-lg-6 col-lg-offset-2 col-md-6 col-md-offset-2 col-sm-5 col-sm-offset-1 col-xs-6 col-xs-offset-2 text-center">
              Total: <b>${{ total }}</b>
            </div>
          </div>
          <div class="row body">
            <div v-for="(row, index) in slider"
                 v-if="starttime + index < endtime"
                 v-bind:class="[index % 2 == 0 ? 'row odd' : 'row even']">
              <div class="col-lg-4 col-md-4 col-sm-5 col-xs-4 time">
                {{ starttime + index < 13 || starttime + index > 24 ? starttime == 0 ? '12' : (starttime + index) % 24 : starttime + index - 12 }}:00
                - {{ starttime + index < 12 || starttime + index > 23 ? (starttime + index + 1) % 24 : starttime + index - 11}}:00
                {{ starttime + index < 12 || starttime + index > 23 ? starttime + index == 11 ? 'Noon' : 'AM' : 'PM' }}
              </div>
              <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                <currency-input v-model="cInput[(starttime + index) % 24].value"/>
              </div>
              <div style="display: none;">{{ getValue((starttime + index) % 24) }}</div>
              <div class="col-lg-5 col-md-5 col-sm-5 col-xs-6 slider">
                <vue-slider ref="slider" v-bind="row" v-model="slider[(starttime + index) % 24].value"></vue-slider>
              </div>
            </div>
            <div class="row piece">
            </div>
          </div>
          <div class="row bottom-save text-center">
            <button class="btn" v-on:click="update">Save</button>
          </div>
        </div>
        <div class="col-lg-4 col-md-5 col-sm-5 col-xs-12 actions">
          <div class="row review">
            <div class="col-lg-11 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-9 col-xs-offset-3">
              Review/Modify Past Day
            </div>
          </div>
          <div class="row edit">
            <div class="col-lg-10 col-lg-offset-2 col-md-11 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-11 col-xs-offset-1">
              <span>Edit:</span>
              <datepicker v-bind="datepicker" v-on:selected="savePreviousDate"/>
            </div>
          </div>
          <div class="row ignore">
            <div class="col-lg-9 col-lg-offset-3 col-md-9 col-md-offset-3 col-sm-10 col-sm-offset-2 col-xs-9 col-xs-offset-3">
              <label>
                <input type="checkbox" v-model="ignore">
                &nbsp;&nbsp;Ignore this day.
              </label>
            </div>
          </div>
          <div class="row done">
            <div class="col-lg-11 col-lg-offset-1 col-md-11 col-md-offset-1 col-sm-12 col-sm-offset-0 col-xs-8 col-xs-offset-2 wow fadeInLeft" data-wow-delay="0.2s">
              <router-link :to="{ name: 'dashboard' }">
                <button class="btn btn-lg btn-block btn-info btn3d" v-on:click="update">
                  <strong class="text-uppercase text-left">I'M DONE! TAKE ME BACK<br/>TO THE HOME SCREEN</strong>
                </button>
              </router-link>
            </div>
          </div>
        </div>
      </div><!-- end .row -->
      <!-- Modal -->
      <transition>
        <div class="modal fade-scale" id="setUpdateModal" tabindex="-1" role="dialog" aria-labelledby="setUpdateModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" v-on:click="loadSelectedDate(pickDate)" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-header danger">
                <h5 class="modal-title" id="setUpdateModalLabel">Warning!</h5>
              </div>
              <div class="modal-body">
                <h4 class="question">Save your changes before changing dates?</h4>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-block btn-success" data-dismiss="modal" v-on:click="update">OK</button>
                <button type="button" class="btn btn-primary btn-block btn-cancel" data-dismiss="modal" v-on:click="loadSelectedDate(pickDate)">Cancel</button>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div><!-- end .container -->
  </layout>
</template>
<script>
    var defaultDate = new Date(new Date().setDate(new Date().getDate() - 1));
    export default {
        data: function() {
            return {
                cInput: [{
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }, {
                        value: 0,
                        oldValue: 0
                    }],
                slider: [{
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: false,
                    }, {
                        value: 0,
                        formatter: '${value}',
                        oldValue: 0,
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }, {
                        value: 0,
                        oldValue: 0,
                        formatter: '${value}',
                        max: 750,
                        interval: 0.01,
                        tooltip: "hover",
                    }],
                datepicker: {
                    value: defaultDate,
                    format: 'MM/dd/yyyy',
                    'calendar-button': true,
                    'calendar-button-icon': 'fa fa-calendar',
                    'monday-first': true,
                    disabled: {
                        to: null,
                        from: defaultDate
                    }
                },
                salesInputList: {},
                ignore: 0,
                selectedDate: null,
                pickDate: null,
                restaurantHoursList: {},
                starttime: null,
                endtime: null
            }
        },
        computed: {
            total: function(){
                var total = 0;
                for (var i = 0; i < 24; i++)
                {
                    total += this.cInput[i].value;
                }
                return total.toFixed(2);
            }
        },
        methods: {
            getValue(index) {
                if (this.slider[index].value != this.slider[index].oldValue) {
                    if (this.slider[index].value == 750) {
                        if (this.cInput[index].value > 750) {
                            return;
                        } else if (this.cInput[index].value != this.cInput[index].oldValue && this.cInput[index].oldValue > 750) {
                            this.cInput[index].oldValue = this.cInput[index].value;
                            this.slider[index].oldValue = this.cInput[index].value;
                            this.slider[index].value = this.cInput[index].value;
                            return;
                        }
                    }
                    this.slider[index].oldValue = this.slider[index].value;
                    this.cInput[index].oldValue = this.slider[index].value;
                    this.cInput[index].value = this.slider[index].value;
                } else if (this.cInput[index].value != this.cInput[index].oldValue) {
                    this.cInput[index].oldValue = this.cInput[index].value;
                    if (this.cInput[index].value >= 750) {
                        if (this.slider[index].value < 750) {
                            this.slider[index].oldValue = this.cInput[index].value;
                            this.slider[index].value = this.cInput[index].value;
                        }
                    } else {
                        this.slider[index].oldValue = this.cInput[index].value;
                        this.slider[index].value = this.cInput[index].value;
                    }
                }
            },
            savePreviousDate(date) {
                // check if the values are modified
                this.pickDate = date;
                var formatDate = this.$moment(this.datepicker.value).format('YYYY-MM-DD');
                var flag = 0;
                for (var i = this.starttime; i < this.endtime; i++)
                {
                    if (this.salesInputList[formatDate])
                    {
                        var index;
                        if (i == 0) index = '2400';
                            else if (i < 10) index = '0' + i + '00';
                                else index = i + '00';

                        if (this.cInput[i].value != this.salesInputList[formatDate][index]) flag = 1;
                    } else {
                        if (this.cInput[i].value != 0) flag = 1;
                    }
                }

                if (this.salesInputList[formatDate])
                {
                    if (this.ignore != this.salesInputList[formatDate]['ignore']) flag = 1;
                } else {
                    if (this.ignore == 1) flag = 1;
                }

                if (flag == 1) {
                    $('#setUpdateModal').modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                } else {
                    this.loadSelectedDate(date);
                }
            },
            loadSelectedDate(date) {
                // refresh the sliders
                var formatDate = this.$moment(date).format('YYYY-MM-DD');
                var daypartList = this.restaurantHoursList[this.$moment(date).format('dddd').toLowerCase()];

                this.starttime = parseInt(daypartList[0]['start_time'].substr(0,2));
                this.endtime = parseInt(daypartList[0]['end_time'].substr(0,2));

                for (var i = 1; i < daypartList.length; i++)
                {
                    if (this.starttime > parseInt(daypartList[i]['start_time'].substr(0,2)))
                        this.starttime = parseInt(daypartList[i]['start_time'].substr(0,2));
                    if (this.endtime < parseInt(daypartList[i]['end_time'].substr(0,2)))
                        this.endtime = parseInt(daypartList[i]['end_time'].substr(0,2));
                }

                // set the selectedDate to date
                this.selectedDate = this.$moment(date).format('M/D/YYYY');
                this.datepicker.value = date;

                // load the sales input values for selected date
                if (this.salesInputList[formatDate]) {
                    for (var i = this.starttime; i < this.endtime; i++)
                    {
                        var index;
                        if (i == 0) index = '2400';
                            else if (i < 10) index = '0' + i + '00';
                                else index = i + '00';

                        this.cInput[i].value = parseFloat(this.salesInputList[formatDate][index]);
                    }
                    this.ignore = this.salesInputList[formatDate]['ignore'];
                } else {
                    for (i = this.starttime; i < this.endtime; i++)
                    {
                        this.slider[i].value = 0;
                    }
                    this.ignore = 0;
                }
            },
            update() {
                var salesInputArray = {};
                var formatDate = this.$moment.utc(this.datepicker.value).utcOffset(this.$moment().utcOffset()).format('YYYY-MM-DD');

                for (var i = this.starttime; i < this.endtime; i++)
                {
                    var index;
                    if (i == 0) index = '2400';
                        else if (i < 10) index = '0' + i + '00';
                            else index = i + '00';

                    salesInputArray[index] = this.cInput[i].value;
                }

                salesInputArray['date'] = formatDate;
                salesInputArray['ignore'] = this.ignore;
                if (this.salesInputList[formatDate]) salesInputArray['rowPk'] = this.salesInputList[formatDate]['id'];

                this.$http.post('/sales-input/update', salesInputArray).then(function(response) {
                    if (response.body.success)
                    {
                        this.salesInputList[formatDate] = {};
                        for (i = this.starttime; i < this.endtime; i++)
                        {
                            var index;
                            if (i == 0) index = '2400';
                                else if (i < 10) index = '0' + i + '00';
                                    else index = i + '00';
                            this.salesInputList[formatDate][index] = salesInputArray[index];
                        }
                        this.salesInputList[formatDate]['date'] = salesInputArray['date'];
                        this.salesInputList[formatDate]['ignore'] = salesInputArray['ignore'];
                        this.salesInputList[formatDate]['id'] = response.body.id;
                        this.loadSelectedDate(this.pickDate);
                    }
                }, function (err) {

                });
            },
            leaving: function () {
                alert("Leaving...");
            },
        },
        created() {
            let self = this;
            self.pickDate = defaultDate;
            self.selectedDate = self.$moment(defaultDate).format('M/D/YYYY');

            this.$http.get('/hours-operation/info').then(function (response) {
                self.restaurantHoursList = response.body.restaurantHoursList;
                 var daypartList = this.restaurantHoursList[this.$moment(defaultDate).format('dddd').toLowerCase()];

                 this.starttime = parseInt(daypartList[0]['start_time'].substr(0,2));
                 this.endtime = parseInt(daypartList[0]['end_time'].substr(0,2));

                 for (var i = 1; i < daypartList.length; i++)
                 {
                     if (this.starttime > parseInt(daypartList[i]['start_time'].substr(0,2)))
                         this.starttime = parseInt(daypartList[i]['start_time'].substr(0,2));
                     if (this.endtime < parseInt(daypartList[i]['end_time'].substr(0,2)))
                         this.endtime = parseInt(daypartList[i]['end_time'].substr(0,2));
                 }

                 this.$http.get('/sales-input/info').then(function (response) {
                     self.salesInputList = response.body.salesInputList;
                     var formatDate = self.$moment(defaultDate).format('YYYY-MM-DD');

                     if (self.salesInputList[formatDate]) {
                         for (var i = this.starttime; i < this.endtime; i++)
                         {
                             var index;
                             if (i == 0) index = '2400';
                                 else if (i < 10) index = '0' + i + '00';
                                     else index = i + '00';

                             self.cInput[i].value = parseFloat(self.salesInputList[formatDate][index]);
                         }
                         self.ignore = self.salesInputList[formatDate]['ignore'];
                     } else {
                         for (i = this.starttime; i < this.endtime; i++)
                         {
                             self.slider[i].value = 0;
                         }
                         self.ignore = 0;
                     }

                     if (typeof this.$route.query.date != 'undefined') {
                         this.loadSelectedDate(this.$route.query.date);
                         this.selectedDate = this.$moment(this.$route.query.date).format('M/D/YYYY');
                     }
                 }, function (err) {

                 });
            }, function (err) {

            });
        }
    };
</script>
