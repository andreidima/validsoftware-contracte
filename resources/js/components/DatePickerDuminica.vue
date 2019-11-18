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
        }
        else {
          this.time2 = this.dataVeche
        }
    },
    updated() {
    }


}
</script> 
 
<template>
  <div>
    <input type="text" :name=numeCampDb v-model="time2" v-show="false">
    <date-picker 
      v-model="time2"  
      value-type="YYYY-MM-DD"
      format="DD-MM-YYYY"
      :editable="false"
      :style="{ width: '120px' }"
      :disabled-date="notBeforeTodayDuminica"
    >      
    </date-picker>
  </div>
</template>