<template>
  <div id="app">
      <nav>
        <div class="nav-wrapper">
          <a  @click="nav('solution')" class="brand-logo">Решения на базе ОВЕН</a>
          <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a @click="nav('solution')">Показать решения</a></li>
            <li><a @click="nav('add')">Добавить решение</a></li>
            <!-- <li><a onclick="nav('account')">Войти</a></li> -->
          </ul>
        </div>
      </nav>
    <div  class="container">
      <EditSolution v-if="nav_trigger=='add'"/>
      <Solutions v-else />
    </div>
  </div>
</template>

<script>
import EditSolution from "./components/EditSolution.vue";
import Solutions from "./components/Solutions.vue";



export default {
  name: "app",
  components: {
    EditSolution, Solutions
  },
  data(){
    return{
      nav_trigger:'solution'
    }
  },
  created() {
    this.$store.dispatch("getData", {});
    this.$store.dispatch("flatTagList");
  },
  methods:{
    nav(w){
      this.nav_trigger=w
      this.$children[0].showIndex=-1
    }
  }
};
</script>
