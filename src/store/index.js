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
    serverLink: "http://localhost/solution_v02/solutions/server/",
    tags: [],
    instM: M,
    template:{
        tags:[]
    },
    solutions:{},
    flatTags:[]
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
    },
    setflatTagList(state, payload){
        state.flatTags = payload;
    }
  },
  actions: {
    async getData(store) {
      console.log(store.state.serverLink)
      await fetch(
        store.state.serverLink+"get_tags.php",
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
    async addTag(store, payload) {
      console.log(payload)
      await axios.post(store.state.serverLink+'add_tag.php', payload)
      .then((response) => {
        console.log(response.data)
      })
    },
    async addGroup(store, group_name) {
        let config= {}
        await axios.post(store.state.serverLink+'add_group.php', group_name, config)
          .then((response) => {
            console.log(response.data)
          })
    },
    // async deleteTag(tagId) {
    //   await fetch("http://localhost/solution_v02/solutions/server/delete_tag.php", {
    //     method: "POST",
    //     mode: "cors",
    //     body: JSON.stringify({ tagId: tagId })
    //   })
    //     .then(function(response) {return response.json()})
    //     .then(function(myJson) {
    //         console.log(myJson)
    //         //Обновить теги
    //     });
    //   this.getData();
    // },
    setTemplateValue(store, payload){
        store.commit("mutationTemplateValue", payload);
    },
    async getSolutions(store, payload){
        let config= {}
        let data={}
        let localSolutions=[]

        if(payload.reload){
            console.log(store.getters.getTemplate.tags)
            data={tags:store.getters.getTemplate.tags}
        }
        await axios.post(store.state.serverLink+'get_solutions.php', data, config)
          .then((response) => {
            console.log(response.data)
            store.commit("setSolutions", response.data.solutions);
            localSolutions =  response.data 
          })
        return localSolutions
    },
    async flatTagList(store){
        await axios.post(store.state.serverLink+'get_flat_tags.php')
          .then((response) => {
            console.log(response.data)
            store.commit("setflatTagList", response.data.tags);
          })
    },
    // async raiting(store, payload){
    //     await axios.post('http://localhost/solution_v02/solutions/server/set_raiting.php', payload)
    //       .then((response) => {
    //         console.log(response.data)
    //         //store.commit("setRaiting", response.data.tags);
    //     })
    // },
  },
  getters: {
    getTags(state) {
      return state.tags;
    },

    getTemplate(state){
        return state.template
    },
    getSolutions(state){
        return state.solutions
    },
    getflatTags(state){
        return state.flatTags
    },
    getServerLink(state){
      return state.serverLink
    }
  }
});
