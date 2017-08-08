<template>
  <layout>
    <div slot="section" class="container" id="frontend_hours_of_operation">
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 res_number">
          Restaurant Number {{ this.$store.state.restaurant.number }}
        </div>
      </div>
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1 col-xs-12 hours">
          <br>
          Hours:
        </div>
      </div>
      <div class="row">
        <div class="col-lg-10 col-lg-offset-1 col-md-10 col-md-offset-1 col-sm-11 col-sm-offset-1 col-xs-12 body">
          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist">
            <li id="mondayTab" class="active">
              <a href="#monday" role="tab" data-toggle="tab">Monday</a>
            </li>
            <li id="tuesdayTab">
              <a href="#tuesday" role="tab" data-toggle="tab">Tuesday</a>
            </li>
            <li id="wednesdayTab">
              <a href="#wednesday" role="tab" data-toggle="tab">Wednesday</a>
            </li>
            <li id="thursdayTab">
              <a href="#thursday" role="tab" data-toggle="tab">Thursday</a>
            </li>
            <li id="fridayTab">
              <a href="#friday" role="tab" data-toggle="tab">Friday</a>
            </li>
            <li id="saturdayTab">
              <a href="#saturday" role="tab" data-toggle="tab">Saturday</a>
            </li>
            <li id="sundayTab">
              <a href="#sunday" role="tab" data-toggle="tab">Sunday</a>
            </li>
          </ul>

          <!-- Tab panes -->
          <div class="tab-content">
            <div class="tab-pane fade active in" id="monday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['monday']"
                    v-for="(row, index) in restaurantHoursList['monday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['monday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'monday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['monday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['monday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['monday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'monday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['monday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on mondays</h4></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="tuesday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['tuesday']"
                    v-for="(row, index) in restaurantHoursList['tuesday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['tuesday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'tuesday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['tuesday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['tuesday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['tuesday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'tuesday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['tuesday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on tuesdays</h4></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="wednesday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['wednesday']"
                    v-for="(row, index) in restaurantHoursList['wednesday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['wednesday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'wednesday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['wednesday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['wednesday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['wednesday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'wednesday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['wednesday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on wednesdays</h4></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="thursday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['thursday']"
                    v-for="(row, index) in restaurantHoursList['thursday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['thursday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'thursday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['thursday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['thursday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['thursday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'thursday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['thursday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on thursdays</h4></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="friday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['friday']"
                    v-for="(row, index) in restaurantHoursList['friday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['friday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'friday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['friday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['friday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['friday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'friday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['friday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on fridays</h4></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="saturday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['saturday']"
                    v-for="(row, index) in restaurantHoursList['saturday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['saturday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'saturday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['saturday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['saturday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['saturday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'saturday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['saturday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on saturdays</h4></td>
                </tr>
              </table>
            </div>
            <div class="tab-pane fade" id="sunday">
              <table>
                <tr class="header">
                  <th>Day Part</th>
                  <th>Start</th>
                  <th>End</th>
                </tr>
                <tr v-if="restaurantHoursList['sunday']"
                    v-for="(row, index) in restaurantHoursList['sunday']"
                    v-bind:class="[index % 2 == 0 ? 'odd' : 'even']">
                  <td>{{ row['day_part'] }}</td>
                  <td v-bind:class="[row['start_time'] != dayPartList['sunday'][index]['start_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == 0 || index == 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == 0 || index == 1 ? 'modal' : '']"
                       v-bind:data-target="[index == 0 || index == 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'sunday', index, 'start_time')">
                      <i class="triangular-mark"></i>{{ row['start_time'] | formatTime }}
                    </a>
                  </td>
                  <td v-bind:class="[row['end_time'] != dayPartList['sunday'][index]['end_time'] ? 'updated-time' : '']">
                    <a v-bind:class="[index == restaurantHoursList['monday'].length - 1 ? 'pointer' : '']"
                       v-bind:data-toggle="[index == restaurantHoursList['sunday'].length - 1 ? 'modal' : '']"
                       v-bind:data-target="[index == restaurantHoursList['sunday'].length - 1 ? '#setTimeModal' : '']"
                       v-on:click="openModal($event, row['id'], 'sunday', index, 'end_time')">
                      <i class="triangular-mark"></i>{{ row['end_time'] | formatTime }}
                    </a>
                  </td>
                </tr>
                <tr v-if="!restaurantHoursList['sunday']">
                  <td class="text-center" colspan="3"><h4>The restaurant is closed on sundays</h4></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <transition>
        <div v-if="showModal" class="modal fade-scale" id="setTimeModal" tabindex="-1" role="dialog" aria-labelledby="setTimeModalLabel">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" v-on:click="closeModal()">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="modal-header">
                <h5 class="modal-title" id="setTimeModalLabel">SET TIME</h5>
              </div>
              <div class="modal-body">
                <div class="time-row">
                  <div>
                    <label for="time">Time:</label>
                    <input type="time" name="time" v-model="time">
                  </div>
                </div>
                <div class="time-reset">
                  <button class="btn" v-on:click="time = defaultTime">Reset to Default</button>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-block" data-dismiss="modal" v-on:click="submitModal()">Submit</button>
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
        data() {
            return {
                restaurantHoursList: {},
                dayPartList: {},
                showModal: false,
                rowPk: null,
                weekDay: null,
                index: null,
                fieldName: null,
                time: null,
                defaultTime: null,
                updatedTimeElement: null
            }
        },
        methods: {
            // -- Modal functions
            openModal(e, row_pk, week_day, index, field_name) {
                // toggle the modal as opening
                this.showModal = true;

                // indicate the row_pk of day part time.
                this.rowPk = row_pk;

                // indicate the field name of day part time.
                this.fieldName = field_name;

                // indicate the week day of day part time.
                this.weekDay = week_day;

                // indicate the index of day part time.
                this.index = index;

                // initialize the day part time on the opening modal
                this.time = this.restaurantHoursList[week_day][index][field_name];

                // initialize the default day part time before opening the modal
                this.defaultTime = this.dayPartList[week_day][index][field_name];

                // save the target element before updating it on the opening modal
                this.updatedTimeElement = e.target;
            },
            closeModal() {
                // toggle the modal as closing
                this.showModal = false;
            },
            submitModal() {
                // Serialize the changed data of day part time
                this.time = this.$moment(this.time, 'HH:mm:ss').format('HH:mm:ss');

                let data = {
                    'rowPk': this.rowPk,
                    'fieldName': this.fieldName,
                    'time': this.time
                };

                /* update the changed data of day part time */
                this.$http.post('/hours-operation/update', data).then(function (response) {

                    // update the restaurantHoursList
                    this.restaurantHoursList[this.weekDay][this.index][this.fieldName] = this.time;

                    // toggle the modal as closing
                    this.showModal = false;

                }, function (err) {

                });
            },
        },
        created() {
            var self = this;

            // get the loading data of restaurant_hours table
            this.$http.get('/hours-operation/info').then(function (response) {
                self.restaurantHoursList = response.body.restaurantHoursList;
                self.dayPartList = response.body.dayPartList;
            }, function (err) {

            });
        }
    }
</script>
