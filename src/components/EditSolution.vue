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
      solution_data:{},
    };
  },
  components: {
    TagsGroup, SolutionBody
  },
  methods: {
    async addSolution(){
        let serverLink=this.getServerLink()
        var wo_img=true
        if(this.$children[0].imgs_src.join(' ').length<1){
            wo_img = confirm("Добавить решение без картинки")
        }

        if(!wo_img){
            console.log('exit')
            return
        }
                let solutionData ={
                    label: this.$children[0].label,
                    desc_html: this.$children[0].desc_html,
                    imgs_src: this.$children[0].imgs_src.join(' '),
                    tags: this.getTemplate().tags.join(' '),
                    autor:1,
                }
                console.log(solutionData)
                await axios.post(serverLink+'save_solutons.php', solutionData)
                    .then((response) => {
                        console.log(response.data)
                        document.location.reload()
                    })
            },
            getTemplate(){
                return this.$store.getters.getTemplate;
            },
            getTags() {
            return this.$store.getters.getTags;
            },
            getServerLink(){
                return this.$store.getters.getServerLink;
            }
        }
        };
</script>
