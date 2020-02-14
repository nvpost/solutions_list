<template>
  <div id="app" class="container">
    <EditSolution v-if="edit==true"/>
    <Solutions v-else />
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
      edit:false
    }
  },
  created() {
    this.$store.dispatch("getData", {});
  }
};
</script>
