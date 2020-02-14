<template>
<div>
    <h2>Список решений</h2>
    {{solutions}}

    <div class="solutions row">
            <div class="col s12 m6" v-for="(item, sol_idx) in solutions" :key="sol_idx">
                <div class="card">
                        <div class="card-image">
                            <img :src="item.imgs_src.split(' ')[0]">
                            <span class="card-title">Card Title</span>
                            </div>
                            <div class="card-content">
                                <div v-html="item.desc_html"></div>
                            </div>
                            <div class="card-action">
                            <a href="#">This is a link</a>
                        </div>
                </div>
            </div>
    </div>  
</div>
</template>

<script>
export default {
  created() {
    this.solutions =  this.$store.dispatch("getSolutions", {})
        .then((res) => {
            this.solutions=res.solutions
        })
    
  },
  data(){
      return{
          solutions:[]
      }
  }
}
</script>
