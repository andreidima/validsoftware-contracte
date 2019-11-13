<script>
import Datepicker from 'vuejs-datepicker';
import {ro} from 'vuejs-datepicker/dist/locale'

import moment from 'moment';

export default {
  // ...
  components: { Datepicker },
  props: ['dataVeche', 'numeCampDb', 'tip', 'latime', 'notBefore'],
  data() {
    return {
      time2: '',
      dataNoua: '',
      format: '',
      ro: ro,
      disabledDates: {
        to: new Date(2019, 10, 13), // Disable all dates up to specific date
        // // from: new Date(2019, 12, 26), // Disable all dates after specific date
        days: [0,1,2,4,5], // Disable Saturday's and Sunday's
        dates: [ // Disable an array of dates
          new Date(2019, 11, 25),
          new Date(2020, 0, 1)
        ],
        // daysOfMonth: [29], // Disable 29th, 30th and 31st of each month
      }
    }
  },
  methods: {
    customFormatter(date) {
      return moment(date).format('DD.MM.YYYY');
    }
  },
    created() {
        if (this.dataVeche == "") {
            // this.time2 = new Date()
            // this.dataNoua = moment(this.time2, 'DD.MM.YYYY, HH:mm'). format('YYYY-MM-DD')
        }
        else {
          this.time2 = this.dataVeche,
          this.dataNoua = this.dataVeche
        }

        if (this.tip == "date"){
          this.format = "DD.MM.YYYY"
        }
        else {
          this.format = "DD.MM.YYYY, HH:mm"
        }
    },
    updated() {
      if (this.time2 instanceof Date) {
        this.dataNoua = moment(this.time2, 'DD.MM.YYYY, HH:mm'). format('YYYY-MM-DD')
      }
      else {
        this.dataNoua = ''
      }

      if (this.tip == "date"){
        this.format = "DD.MM.YYYY"
      }
      else {
        this.format = "DD.MM.YYYY, HH:mm"
      }
    }


}
</script> 
 
<template>
  <div>
    <!-- <p>dataVeche = {{ dataVeche }}</p>
    <p>dataNoua = {{ dataNoua }}</p>
    <p>time2 = {{ time2 }}</p> -->
    <input type="text" :name=numeCampDb v-model="dataNoua" v-show="false">
    <!-- <date-picker v-model="time1" :first-day-of-week="1"></date-picker> -->
    <datepicker 
      v-model="time2"
      :language="ro"
      :disabled-dates="disabledDates"
      :format="customFormatter"
    >
    </datepicker>
    <!-- <date-picker 
      v-model="time2"
      :type=tip
      :not-before="notBefore"
      :format="format"
      :width="latime"
      :height="10"
      :clearable=true
      :first-day-of-week="1"
      :lang="lang"
      :time-picker-options="timePickerOptions"
      :disabled-days="disableWeekends"
      >
    </date-picker> -->
    <!-- <date-picker v-model="time3" range :shortcuts="shortcuts"></date-picker> -->
    <!-- <date-picker v-model="value" :lang="lang"></date-picker> -->
  </div>
</template>