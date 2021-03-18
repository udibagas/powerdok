import Vue from 'vue';
import wysiwyg from "vue-wysiwyg";

const options = {
  hideModules: { "image": true, "table": true },
  // iconOverrides: { "bold": "<i class='your-custom-icon'></i>" },
  // image: {
  //   uploadURL: "/api/upload?path_only=true",
  //   dropzoneOptions: {}
  // },

  maxHeight: "500px",
  // forcePlainTextOnPaste: true,
  locale: 'en'
}
Vue.use(wysiwyg, options);
