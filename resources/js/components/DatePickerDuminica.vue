<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/ro';
import moment from 'moment';
 
export default {
  components: { DatePicker },
  props: ['dataVeche', 'numeCampDb', 'tip', 'notBefore'],
  data() {
    return {
      time1: null,
      time2: null,
      time3: null,
      dataNoua: '',
      format: '',
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
    }
  },
    methods: {
      notBeforeTodayMiercuri(date) {
        const today = new Date(this.notBefore);
        today.setHours(0, 0, 0, 0);

        // const data_fixa1 = new Date('2019-11-28 00:00:00');
        // const data_fixa2 = new Date('2019-12-01 00:00:00');

        const dateDay = date.getDay()
        
        return (
            (date.getTime() < today.getTime()) || 
            // (date.getTime() == data_fixa1.getTime()) || 
            // (date.getTime() == data_fixa2.getTime()) ||
            // ((dateDay !== 4) && (dateDay !== 0))
            (dateDay !== 4)
          );
        // return ((date < today) || (date == data_fixa));
      },
      notBeforeTodayDuminica(date) {
        const today = new Date(this.notBefore);
        today.setHours(0, 0, 0, 0);

        // const data_fixa1 = new Date('2019-11-28 00:00:00');
        // const data_fixa2 = new Date('2019-12-01 00:00:00');

        const dateDay = date.getDay()
        
        return (
            (date.getTime() < today.getTime()) || 
            // (date.getTime() == data_fixa1.getTime()) || 
            // (date.getTime() == data_fixa2.getTime()) ||
            // ((dateDay !== 4) && (dateDay !== 0))
            (dateDay !== 0)
          );
        // return ((date < today) || (date == data_fixa));
      },
      disabledDays (value) {
        // const date = new Date(value)
        // const today = new Date()
        // const todayDay = today.getDay()
        // const dateDay = date.getDay()
      // if today is Friday, Monday can be choosed.
        // if (todayDay === 5) {
        //   return dateDay !== 1
        // }
        return new Date(2019, 11, 21);
      },
      notAfterToday(date) {
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        return ((date.getTime() > today.getTime()) && (date.getTime() < tomorrow.getTime()));
      },
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
    <!-- <date-picker v-model="time1"></date-picker> -->
    <date-picker 
      v-model="time2"
      :format="format"
      :editable="false"
      :style="{ width: '120px' }"
      :disabled-date="notBeforeTodayDuminica"
    >      
    </date-picker>
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
      :disabled-days="['2019-12-25','2020-01-01']"
      >
    </date-picker> -->
    <!-- <date-picker v-model="time3" range :shortcuts="shortcuts"></date-picker> -->
    <!-- <date-picker v-model="value" :lang="lang"></date-picker> -->
  </div>
</template>