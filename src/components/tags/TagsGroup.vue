<template>
  <div>
    <ul class="collapsible expandable" v-if="data_tags.length > 0" >
      <li v-for="(row, row_index) in data_tags" :key="row_index">
        <div class="collapsible-header">
          <i class="material-icons">filter_drama</i>{{ row.group }} ({{
            row.tags.length
          }})
        </div>
        <div class="collapsible-body">
          <div
            class="chip my_chips"
            v-for="(tag, tag_index) in row.tags"
            :key="tag_index"
            @click="selectTag($event, tag.id)"
          >
            {{ tag.tag}}
            <!-- <i @click="deleteTag(tag.id, tag.tag)" class="custom-close material-icons">close</i> -->
          </div>
          <div class="actions_buttons">
            <a
              class="waves-effect waves-light btn-small"
              @click="addTag(row.id, row_index)"
              >Добавить характеристику</a>
            <!-- <a
              class="waves-effect waves-light btn-small"
              @click="editGroup(row.id)"
              >Изменить название группы</a> -->
            <a
              class="waves-effect waves-light btn-small red del"
              @click="deleteGroup(row_index + 1)">
              <i class="material-icons">delete_forever</i></a>
          </div>
        </div>
      </li>
    </ul>
    <div class="actions_buttons">
      <a class="waves-effect waves-light btn-small" @click="addGroup()"
        >Добавить группу характеристик</a
      >
    </div>
  </div>

</template>

<script>
import M from "materialize-css";

export default {
  name: "TagsGroup",
  components: {},
  props: ["tags"],
  data() {
    return {
      data_tags: []
    };
  },
  mounted() {
    this.data_tags = this.tags;
  },
  created() {
      this.initColapse()
  },
  methods: {
    initColapse(n){
        setTimeout(() => {
            var elems = document.querySelectorAll(".collapsible");
            M.Collapsible.init(elems, {});
            if(n||n==0){
                var instance = M.Collapsible.getInstance(document.querySelector(".collapsible"));
                instance.open(n);
            }
        }, 0);
    },
    addTag(n, index){
      var tag = prompt("Название тега");
      this.$store.dispatch("addTag", {tag, n});
      setTimeout(() => this.getTags(index), 100)
      
    },
    deleteTag(n, m) {
        var c = confirm("Удалить характеристику '"+m+"'?")
        console.log(c)
        //this.$store.dispatch("getData", {});
    },
    selectTag(e, n){
        let el = e.target
        el.classList.toggle("green");
        el.classList.toggle("darken-1")
        this.$store.dispatch("setTemplateValue", {w:'tags', val:n});
        //console.log(e.target, n)
    },
    getTags(n) {
        console.log('gettags')
        
        this.$store.dispatch("getData", {});
        console.log(n)
        
        setTimeout(() => {
                this.data_tags = this.$store.getters.getTags
                console.log(this.data_tags[n].tags)
                this.initColapse(n)
            }, 50);
      

    }
  }
};
</script>
