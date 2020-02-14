<template>
  <div>
    <h3>Добавить решение</h3>
    <form ation="/add" id="add" method = "POST">
        <SolutionBody />
        <TagsGroup :tags="getTags()" v-if="getTags().length" />

        <div class="actions_buttons">
        <a class="waves-effect waves-light btn-small" @click="addSolution()"
            >Сохранить решение</a
        >
        </div>
    </form>

  </div>

</template>

<script>
import TagsGroup from "./tags/TagsGroup.vue";
import SolutionBody from "./SolutionBody.vue";

import axios from 'axios'

export default {
  name: "EditSolutions",
  data() {
    return {
      tags: [],
      solution_data:{}
    };
  },
  components: {
    TagsGroup, SolutionBody
  },
  methods: {
    async addSolution(){
         console.log(this.$children[0])
        let solutionData ={
            label: this.$children[0].label,
            desc_html: this.$children[0].desc_html,
            imgs_src: this.$children[0].imgs_src.join(' '),
            tags: this.getTemplate().tags.join(' '),
            autor:1,
        }

        let config={
            
        }

        await axios.post('http://localhost/solution_v02/solutions/server/save_solutons.php', solutionData, config)
            .then((response) => {
                console.log(response.data)
            })
            .catch(error => {
              console.log(error.response)
            }) 

    },
    getTemplate(){
        return this.$store.getters.getTemplate;
    },
    getTags() {
      return this.$store.getters.getTags;
    },
  }
};
</script>
