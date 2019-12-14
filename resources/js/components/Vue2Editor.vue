<template>
  <div>
    <input type="text" :name=numeCampDb v-model="content" v-show="false">
    <vue-editor 
        v-model="content"
    >
    </vue-editor>
  </div>
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
  components: {
    VueEditor
  },
  props: ['anexaVeche', 'numeCampDb'],

  data() {
    return {
    //   content: "<h1>Some initial content</h1>"
    content:null,
    };
  },  
    created() {
        if (this.anexaVeche == "") {
        }
        else {
            this.content = this.anexaVeche
        }
    },

};
</script>