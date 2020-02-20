<template>
    <div>
<h4>{{solution.label}}</h4>
    <div class="solution_raiting">
        <i class="material-icons sulutions_thumb" @click="setRaiting(solution.id, 'plus')">thumb_up</i>       
        <i class="solution_raiting_value">{{showRaiting(solution.rating).split('/')[0]}} / {{showRaiting(solution.rating).split('/')[1]}}</i>
        <i class="material-icons sulutions_thumb" @click="setRaiting(solution.id, 'minus')">thumb_down</i>
    </div>
<div class="solution_imgs">
   <div class="solution_imgs_main">
       <img :src="solution.imgs_src.split(' ')[0]">
    </div> 
    <div class="solution_imgs_seconds">
    </div> 
    <div class="solution_desc">
        <div v-html="solution.desc_html"></div>
    </div>
    <div class="solution_tags">
        <h5>Характеристики решения</h5>
           <div class="chip my_chips"
            v-for="(tag, tag_index) in solution.tags.split(' ')"
            :key="tag_index">
            {{textTag(tag)}}
          </div>
    </div> 


    <div class="solution_comment">
        <h5>Комментарии</h5>
            <div class="comments">
                <div class="comment_item" v-for="(comment, index) in comments" :key="index">
                    <p>{{comment['text_value']}}</p>
                </div>
            </div>
            <div class="my_comment_editor">
                <textarea v-model="comment" placeholder="Введите комментарий" style="my_comment"></textarea>
                <a class="waves-effect waves-light btn-small" @click="addComment(solution.id)">Добавить комментарий</a>
            </div>
    </div>     
    </div>
    </div>
</template>

<script>
import axios from 'axios'


export default {
    props:[
        'out_solution'
    ],
    data(){
        return{
            flatTags:this.getflatTags(),
            solution:this.out_solution,
            comments:[],
            comment:""
        }
    },
    created(){
        this.getComments(this.solution.id).then((res)=>{this.comments = res})
    },
    methods:{
        textTag(n){
            let row = this.flatTags.filter(i=> i.id==n )
            return row[0].tag
        },
        getflatTags(){
            return this.$store.getters.getflatTags;
        },
        showRaiting(w){
            console.log(w)
            return w==null?'0/0':w
        },



        async setRaiting(n, w){
            await axios.post('http://localhost/solution_v02/solutions/server/set_raiting.php', {n, w})
            .then((response) => {
                console.log(response.data)
                this.solution.rating = response.data.r
            })
        },    
        async addComment(n){
            let comment=this.comment
            console.log("addCommentFoo")
            await axios.post('http://localhost/solution_v02/solutions/server/add_comment.php', {n, comment})
            .then((response) => {
                console.log(response.data)
                this.comment=''
            })
        },
        async getComments(n){
            let comment=this.comment
            let localComments=[]
            await axios.post('http://localhost/solution_v02/solutions/server/get_comment.php', {n, comment})
            .then((response) => {
                console.log(response.data)
                localComments = response.data.data
                
            })
            return localComments
        },
        
    }
}
</script>