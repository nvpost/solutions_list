<template>
  <div>
    <input type="text" placeholder="Название решения" v-model="label"><br>

    <div class="my_editor">
        <ckeditor :editor="editor" v-model="desc_html" :config="editorConfig"></ckeditor>
    </div>
    <div class="file_upload">   
        <form>
            <div class="large-12 medium-12 small-12 cell">
                <label>File
                    <input type="file" id="file" ref="file" @change="handleFileUpload()"/>
                </label>
             <div class="btn" @click="send_file()">Загрузить картинку</div>
            </div>
        </form>
        <div class="img_block" v-if="imgs_src.length>0">
            <div class="img_block_item" v-for="(src, index) in imgs_src" :key="index">
                <img :src="src">
            </div>
        </div>
    </div>
  </div>
</template>

<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

import axios from 'axios'


export default {
    data() {
        return {
        file:'', 
        imgs_src:[],   
        label: "",
        editor: ClassicEditor,
        desc_html: '',
        editorConfig: {
             language: 'ru',
        }
        };
  },
  methods:{
      
      handleFileUpload(){
        this.file = this.$refs.file.files[0];
      },
      async send_file(){
        let serverLink=this.getServerLink()
        let fData = new FormData();
        fData.append('file', this.file);
        let config= {headers: {
              'Content-Type': 'multipart/form-data',
            } 
        }
        var localSrc=''
        await axios.post(serverLink+'upload_img.php', fData, config)
            .then((response) => {
                localSrc = response.data
                console.log('this.imgs_src', localSrc)
            })
            this.imgs_src.push(localSrc) 
        },

        getServerLink(){
                return this.$store.getters.getServerLink;
            }


    }
}
</script>