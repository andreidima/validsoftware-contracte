<script>
import DatePicker from 'vue2-datepicker';
import moment from 'moment';
 
export default {
  components: { DatePicker },
  props: ['dataVeche', 'numeCampDb', 'tip', 'latime', 'notBefore'],
  data() {
    return {
      time1: '',
      time2: '',
      time3: '',
      dataNoua: '',
      format: '',
      // custom lang
      lang: {
        days: ['Dum', 'Lun', 'Mar', 'Mie', 'Joi', 'Vin', 'Sâm'],
        months: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun', 'Iul', 'Aug', 'Sep', 'Oct', 'Noi', 'Dec'],
        pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
        placeholder: {
          date: 'Selectează Data',
          dateRange: 'Select Date Range'
        }
      },
      // custom range shortcuts
      shortcuts: [
        {
          text: 'Today',
          onClick: () => {
            this.time3 = [ new Date(), new Date() ]
          }
        }
      ],
      timePickerOptions:{
        start: '00:00',
        step: '00:30',
        end: '23:30'
      },
      // disabledDays: {
      //   // // to: new Date(2019, 12, 5), // Disable all dates up to specific date
      //   // // from: new Date(2019, 12, 26), // Disable all dates after specific date
      //   // days: [6, 0], // Disable Saturday's and Sunday's
      //   // daysOfMonth: [29], // Disable 29th, 30th and 31st of each month
      //   moment(2019, 11, 25) => true
      //   // days: [ // Disable an array of dates
      //   //   new Date(2019, 11, 25),
      //   //   new Date(2020, 1, 1)
      //   // ]
      // }
    }
  },
  methods: {
    disableDays (date) {
      const day = new Date(date).getDay();
      if (date == new Date('2019-11-25')){
        return date
      }
      //   date = new Date('2019-11-25');
      // if (day === 0 || day === 1 || day === 2 || day === 4 || day === 5) {
      //   return day === 0 || day === 1 || day === 2 || day === 4 || day === 5;
      // }
      // else{
      //   return date;
      // }
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
    <date-picker 
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
      :disabled-days="disableDays"
      >
    </date-picker>
    <!-- <date-picker v-model="time3" range :shortcuts="shortcuts"></date-picker> -->
    <!-- <date-picker v-model="value" :lang="lang"></date-picker> -->
  </div>
</template>