<template>
    <div>
<h4 >{{solution.label}}</h4>
    <div class="solution_raiting">
        <i class="material-icons sulutions_thumb" @click="setRaiting(solution.id, 'plus')">thumb_up</i>       
        <i class="solution_raiting_value">{{showRaiting(solution.rating).split('/')[0]}} / {{showRaiting(solution.rating).split('/')[1]}}</i>
        <i class="material-icons sulutions_thumb" @click="setRaiting(solution.id, 'minus')">thumb_down</i>
    </div>
<div class="solution_imgs">
   <div class="solution_imgs_main" @click="adCount()">
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
           
            <div class="deleteSolution" v-if="a_count>4"><a class="waves-effect waves-light btn-small red" @click="deleteSolution(solution.id)">Удалить решение</a></div>
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
            serverLink:'',
            comments:[],
            comment:"",
            a_count: 0
        }
    },
    created(){
        this.getComments(this.solution.id).then((res)=>{this.comments = res})
        this.serverLink=this.getServerLink()
        console.log('this.serverLink - ' + this.serverLink)
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
            //console.log(w)
            return w==null?'0/0':w
        },



        async setRaiting(n, w){
            let sl = this.getServerLink()
            await axios.post(sl+'set_raiting.php', {n, w})
            .then((response) => {
                console.log(response.data)
                this.solution.rating = response.data.r
            })
        },    
        async addComment(n){
            let comment=this.comment
            let sl = this.getServerLink()
            await axios.post(sl+'add_comment.php', {n, comment})
            .then((response) => {
                console.log(response.data)
                this.comment=response.data.data.comment
            })
            this.getComments(this.solution.id).then((res)=>{this.comments = res})
        },
        async getComments(n){
            let sl = this.getServerLink()
            let comment=this.comment
            let localComments=[]
            await axios.post(sl+'get_comment.php', {n, comment})
            .then((response) => {
                localComments = response.data.data
                
            })
            return localComments
        },
        adCount(){
            this.a_count++
        },
        async deleteSolution(n){
            let sl = this.getServerLink()
            if(confirm("Удалить решение?")){
                await axios.post(sl+'delete_sol.php', {n})
                    .then((response) => {
                        console.log(response.data)
                        document.location.reload(true);
                    })
            }

        },
        getServerLink(){
            return this.$store.getters.getServerLink
        }
        
    }
}
</script>