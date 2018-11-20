<template id="admin-list">
<div class="contentlist">
    <div class="flex-container ">
        <div class="columns m-t-10">
            <div class="column">
                <h1 class="title">Artikel</h1>
            </div>
        </div>
           
<form v-on:submit.prevent ="createPost()">
        <div class="columns m-t-10">
            <div class="column">
                <div class="card p-b-20">
                    <div class="card-content">
                     
                        <div class="field">
                            <label class="label">
                                Judul
                            </label>
                            <p class="control">
                                <input type="text" class="input" v-model="title">
                            </p>
                            <p class="control" v-if="$route.params.detail != 'update'">
                                <slug-widget url="/" subdirectory="blog" :title="title" @copied="slugCopied" @slug-changed="updateSlug"></slug-widget>
                                <input type="hidden" v-model="slug" name="slug" />
                            </p>
                        </div>

                        <div class="field">
                            <label class="label">
                                Post
                            </label>
                            <p class="control">
                                <editor api-key="7qnvjsuap7tf4yk5t9v56511ndqs11rpv1autp3kye0xydzd" v-model="content" :init="{plugins: 'image imagetools', height: '500'}"></editor>
                            </p>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="column is-one-quarter-desktop">
                <div class="card">
                     <div class="card-content">
                    <div class="columns">
                            <ul>
                                <li> <label for="">Type</label></li>
                                <li> <input type="radio" name="type" v-model="type" value="Bukren"> Bukren</li>
                                <li> <input type="radio" name="type" v-model="type" value="Metode"> Metode</li>
                                <li> <input type="radio" name="type" v-model="type" value="Bantuan"> Bantuan </li>
                            </ul>
                         
                        
                        

                        </div>

                    </div>
                    <div class="card-content">
                        <label for="">Status</label>
                        <div class="columns">
                            <div class="column is-one-fifth" style="align-self:center">
                               <i class="fa fa-archive" style="padding:0px;font-size: 21px;"></i>
                            </div>
                            <div class="column " v-if="$route.params.detail == 'update'">
                                 <strong>Draft</strong> Tersimpan
                                 <p>dibuat pada tanggal </p>
                                 <p>{{created_at}}</p>
                            </div>
                            <div class="column " v-if="$route.params.detail == 'create'">
                                 <strong>Draft</strong> Belum Tersimpan
                            </div>
                        </div>
                    </div>
                        <hr style="margin:0px;">
                    <div class="card-content">
                    <div class="columns">
                            <div class="column" v-if="$route.params.detail == 'create'" >
                                 <button type="submit" class="button is-info is-fullwidth" :class="{'is-loading' : load}" @click="load = true" > Draft</button>
                            </div>
                            <div class="column" v-else>
                                <button type="submit" class="button is-success is-fullwidth" :class="{'is-loading' : load}" @click="load = true" > Publish</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div> <!-- end of .column.is-one-quarter -->

        </div>
</form>

    </div>
<!-- <editor api-key="7qnvjsuap7tf4yk5t9v56511ndqs11rpv1autp3kye0xydzd " :init="{plugins: 'wordcount'}"></editor> -->
</div>
</template>
<style scoped>
ul{
    list-style: none;
    margin-left: 0px;
    margin-top: 0px;
}

</style>
<script>
    export default {
 
        data(){
            
            return{
                content:'',
                title: '',
                slug: '',
                created_at: '',
                id:'',
                load: false,
                type: 'Bukren'
            }
        },
        watch: {
            '$route' (to, from) {
                if (from.params.kategori !== to.params.kategori) {
                     this.content = '';
                    this.title = '';
                    this.slug = '';
                    this.created_at = '';
                    this.id = '';
                    this.type ='Bukren';
                    return this.getPost();
                }
            }
        },
        created: function() {
           
            if(this.$route.params.detail == 'update'){
                this.getPost();
            }
        },
         methods: {
            updateSlug: function(val) {
             this.slug = val;
            },
            slugCopied: function(type, msg, val) {
                notifications.toast(msg, {type: `is-${type}`});
            },
            getPost(){
                let uri = '/api/article/'+this.$route.params.id;
                axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                    this.id = response.data.id;
                    this.content = response.data.content;
                    this.title = response.data.title;
                    this.created_at = response.data.created_at;
                    this.type = response.data.type;
                });
            },
            createPost(){
                if(this.$route.params.detail == 'update'){
                    var uri = '/api/article/'+this.$route.params.id;
                }else{
                    var uri = '/api/article';
                }
              axios.post(uri, {content: this.content, slug: this.slug, title: this.title,type: this.type},{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.load = false;
                 this.$toast.open({
                    duration: 2000,
                    message: 'Artikel berhasil ditambahkan',
                    position: 'is-bottom',
                    type: 'is-success',
                    queue: false,
                });
                  this.$router.push({ name: 'ArticlesList' });
              }).catch(error => {
                    this.load = false;
                    this.$toast.open({
                        duration: 2000,
                        message: 'Data tidak lengkap',
                        position: 'is-bottom',
                        type: 'is-danger',
                        queue: false,
                    });
                });
            },
            
         },
       
    }
</script>
