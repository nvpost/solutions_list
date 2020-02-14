import Vue from "vue";
import Vuex from "vuex";
import VueMaterial from "vue-material";
import M from "materialize-css";
import CKEditor from '@ckeditor/ckeditor5-vue';
import axios from 'axios'

Vue.use(Vuex);

Vue.use(M);
Vue.use(VueMaterial);
Vue.use( CKEditor );

export default new Vuex.Store({
  state: {
    LocalServerPath: "../server",
    tags: [],
    instM: M,
    template:{
        tags:[]
    },
    solutions:{}
  },
  mutations: {
    setTags(state, payload) {
      state.tags = payload;
    },
    mutationTemplateValue(state, payload){
        if(payload.w=='tags'){
            let n= payload.val
            let t_tags=state.template.tags
            t_tags.indexOf(n)==-1?state.template.tags.push(n):state.template.tags.splice(t_tags.indexOf(n), 1)
        }
    },
    setSolutions(state, payload){
        state.solutions = payload;
    }
  },
  actions: {
    async getData(store) {
      await fetch(
        "http://localhost/solution_v02/solutions/server/get_tags.php",
        {
          method: "POST",
          mode: "cors"
        }
      )
        .then(function(response) {
          return response.json();
        })
        .then(function(myJson) {
          store.commit("setTags", myJson.tags);
        })
    },
    async addTag(n, payload) {
        console.log(payload)
      await fetch("http://localhost/solution_v02/solutions/server/add_tag.php", {
        method: "POST",
        mode: "cors",
        body: JSON.stringify({...payload})
      })
        .then(function(response) {
          return response.json();
        })
        .then(function(myJson) {
          console.log(myJson);
        });
    },
    async addGroup() {
      var group = prompt("Название тега");
      await fetch("http://localhost/solution_v02/solutions/server/add_group.php", {
        method: "POST",
        mode: "cors",
        body: JSON.stringify({ group: group })
      })
        .then(function(response) {
          return response.json();
        })
        .then(function(myJson) {
          console.log(myJson);
        });
      this.getData();
    },
    async deleteTag(tagId) {
      await fetch("http://localhost/solution_v02/solutions/server/delete_tag.php", {
        method: "POST",
        mode: "cors",
        body: JSON.stringify({ tagId: tagId })
      })
        .then(function(response) {return response.json()})
        .then(function(myJson) {
            console.log(myJson)
            //Обновить теги
        });
      this.getData();
    },
    setTemplateValue(store, payload){
        store.commit("mutationTemplateValue", payload);
    },
    async getSolutions(store){
        let config= {}
        let data={}
        let localSolutions=[]
        await axios.post('http://localhost/solution_v02/solutions/server/get_solutions.php', data, config)
          .then((response) => {
            console.log(response.data)
            store.commit("setSolutions", response.data.solutions);
            localSolutions =  response.data 
          })
        return localSolutions
    }
  },
  getters: {
    getTags(state) {
      return state.tags;
    },

    getTemplate(state){
        return state.template
    },
    // getSolutions(state){
    //     return state.solutions
    // }
  }
});
