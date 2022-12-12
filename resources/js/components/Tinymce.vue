<template>
   <div id="app">
     <!-- <img alt="Vue logo" src="./assets/logo.png"> -->
     <editor
       api-key="qfvel52dls643trvhfl7htj92heo6mggf0lwt3uha1vnos13"
       :init="{
         height: (height ? height : 500),
         menubar: false,
         plugins: [
           'advlist autolink lists link image charmap print preview anchor',
           'searchreplace visualblocks code fullscreen',
           'insertdatetime media table paste code help wordcount'
         ],
         toolbar:
           'undo redo | formatselect | bold italic backcolor | \
           alignleft aligncenter alignright alignjustify | \
           bullist numlist outdent indent | link | removeformat | help'
       }"
       v-model="content"
     />
     <input id="content" type="hidden" :name="inputname" v-model="content" />
   </div>
 </template>

 <script>
 import Editor from '@tinymce/tinymce-vue'

 export default {
   props: ['inputvalue', 'inputname', 'height'],
   name: 'app',
   components: {
     'editor': Editor
   },

  data() {
    return {
        content: this.inputvalue
    }
  }
 }
 </script>
