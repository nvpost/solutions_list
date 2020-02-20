<template>
<div>
    <div class="head_label">
        <div class="head_label_text"><h4>Решения</h4></div>
        <div class="head_label_icons">
            <i class="material-icons" v-if="showIndex>-1" @click="showIndex=-1"> arrow_back</i>
            <i class="material-icons" @click="cards=!cards" v-if="cards">list</i>
            <i class="material-icons" @click="cards=!cards" v-else>view_module</i>
        </div>    
    </div>
    
    <openSolution class="solution" v-if="showIndex>-1" :out_solution="solutions[showIndex]">
    </openSolution>
    <div class="solutions" v-else>
        <div class=" row">

            <div class="cards_field"  v-if="cards">
            <div class="col s12 m4" v-for="(item, sol_idx) in solutions" :key="sol_idx">
                <div class="card">
                        <div class="card-image">
                            <img @click="showIndex = sol_idx" :src="item.imgs_src.split(' ')[0]">
                            <!-- <span class="card-title">Card Title</span> -->
                            </div>
                            <div class="card-content my_card-content" @click="showIndex = sol_idx">
                                <strong>{{item.label}}</strong>
                                <!-- <div v-html="shorterText(item.desc_html)"></div> -->
                            </div>
                            <div class="card-action">
                            <a @click="showIndex = sol_idx">Открыть решение</a>
                        </div>
                </div>
            </div>
            </div>

            <div class="table_field" v-else>
                      <table><tbody>
                <tr v-for="(item, sol_idx) in solutions" :key="sol_idx">
                    <td><img @click="showIndex = sol_idx" class="table_img" :src="item.imgs_src.split(' ')[0]"></td>
                    <td><p><strong>{{item.label}}</strong></p></td>
                    <td>
                        <div v-html="shorterText(item.desc_html)"></div>
                    </td>
                    <td><a @click="showIndex = sol_idx">Открыть</a></td>
                </tr>
                </tbody></table>
            </div>

        </div> 
        <div class="solution_count">
            <p style="display: none">{{getNewSolutions}}</p>
            <p>Решений подходящих под фильтры: <span>{{solutions.length}}</span></p>
        </div>   
            <filters :tags="getTags()" v-if="getTags().length" :w="true"/>
</div>
  

</div>
</template>

<script>
import filters from './tags/TagsGroup.vue'
import openSolution from './openSolution.vue'

export default {
  created() {

    this.getSolutions()
  },
  components:{
      filters, openSolution
  },
  data(){
      return{
          solutions:[],
          showIndex:-1,
          cards:true
      }
  },
  computed:{
    getNewSolutions () { 
        let newSol = this.$store.getters.getSolutions
        this.drowNewSolutions(newSol)
        return true
        },
  },
  methods:{
    shorterText(t){
          if(t.length>150){
              return t.substr(0, 140)+"..."
          }else{
            return t.length
          }
      },
    getSolutions(){
        this.solutions =  this.$store.dispatch("getSolutions", {})
            .then((res) => {
                this.solutions=res.solutions
            })
    },  
    getTags() {
      return this.$store.getters.getTags;
    },
    getSelectedTags(){
        return this.$store.getters.getTemplate.tags;
    },
    drowNewSolutions(ns){
        this.solutions=ns
    },


        
  }

}
</script>
