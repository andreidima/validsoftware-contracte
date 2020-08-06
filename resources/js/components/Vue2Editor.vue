<template>
  <div>
    <input type="text" :name=numeCampDb v-model="content" v-show="false">
    <vue-editor 
        v-model="content"
        :editorToolbar="customToolbar"
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
  props: ['textVechi', 'numeCampDb'],

  data() {
    return {
    //   content: "<h1>Some initial content</h1>"
    content:null,
    customToolbar: [
        // [{ 'font': [] }],
        // [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
        [{ 'size': ['small', false, 'large', 'huge'] }],
        // ['bold', 'italic', 'underline', 'strike'],
        ['bold', 'italic', 'underline'],
        [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
        // [{ 'header': 1 }, { 'header': 2 }],
        // ['blockquote', 'code-block'],
        // [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
        [{ 'script': 'sub'}, { 'script': 'super' }],
        [{ 'indent': '-1'}, { 'indent': '+1' }],
        [{ 'color': [] }, { 'background': [] }],
        // ['link', 'image', 'video', 'formula'],
        ['link'],
        // [{ 'direction': 'rtl' }],
        ['clean'],
      ]
    };
  },  
    created() {
        if (this.textVechi != ""){
          this.content = this.textVechi
        }
    },

};
</script>