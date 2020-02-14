import Vue from "vue";
import App from "./App.vue";
import Vuex from "vuex";
import store from "./store/";
import VueMaterial from "vue-material";
import M from "materialize-css";

import "materialize-css";
import "materialize-css/dist/css/materialize.min.css";

import axios from 'axios'
import VueAxios from 'vue-axios'
 


Vue.config.productionTip = false;

Vue.use(VueAxios, axios)
Vue.use(Vuex);

Vue.use(M);
Vue.use(VueMaterial);

window.globalVar = "I am global";
new Vue({
  M,
  store,
  render: h => h(App)
}).$mount("#app");
