<template id="admin-list">
    <div id="pageviewContent" class="flex-container " style="margin-bottom: 10px; padding: 20px;">
        <div class="columns">
                <div class="column">
                    <div class="card">
                        <div class="card-content blogContent">
                            <h3 >{{article.type}}</h3>
                            <div class="bodyContent">
                                <div class="titleContent">
                                    <h1>'{{article.title}}'</h1>
                                    <h4>{{article.created_at}}</h4>
                                </div>
                                <div class="Content" v-html="article.content">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="column is-one-quarter">
                    <div class="card">
                        <div class="card-content">
                            <h3>Bukren</h3>
                            <div  v-for="art in filterBukren" :key="art.id">
                                <hr>
                                 <router-link :to="{name: 'Page', params :{slug: art.slug}}">{{art.title}}</router-link>
                            </div>
                            <hr>
                            <h3>Metode</h3>
                            <div  v-for="art in filterMetode" :key="art.id">
                                <hr>
                                 <router-link :to="{name: 'Page', params :{slug: art.slug}}">{{art.title}}</router-link>
                            </div>
                        
                            <hr>
                            <h3>Bantuan</h3>
                               <div  v-for="art in filterBantuan" :key="art.id">
                                <hr>
                                 <router-link :to="{name: 'Page', params :{slug: art.slug}}">{{art.title}}</router-link>
                            </div>
                         
                        </div>
                    </div>
                </div>
        
    </div>
</div>
</template>

<script>
    export default {
        data(){
            
            return{
                dataArticle: [],
                article: {
                    id: '',
                    title: '',
                    slug: '',
                    created_at: '',
                    type: '',
                    content: '',
                }
            }
        },
        watch: {
            '$route' (to, from) {
                if (from.params.slug !== to.params.slug) {
                    this.article = {
                            id: '',
                            title: '',
                            slug: '',
                            created_at: '',
                            type: '',
                            content: '',
                        }
                    return this.getPost();
                }
            }
        },
        created: function() {
            this.getPost();
            this.getArticle();
        },
         methods: {
           getArticle(){
                  let uri = '/api/article';
                  axios.get(uri).then((response) => {
                      this.dataArticle = response.data;
                  }).catch(error => {
                      // console.log(error);
                  });
            },
            getPost(){
                this.load=false;
                var uri = '/api/blog/'+this.$route.params.slug;
                axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.article = {
                            id: response.data.id ,
                            title: response.data.title ,
                            slug: response.data.slug ,
                            created_at: response.data.created_at ,
                            type: response.data.type ,
                            content: response.data.content,
                        }
                }).catch(error => {
                    //   console.log(error);
                  });
            },
         },
       computed: {
           filterBukren(){
                if(this.dataArticle.length) {
                    return this.dataArticle.filter((row, index) => {
                            if(row.type == 'Bukren'){
                                return true;
                            }
                      });
                }
            },
            filterMetode: function(){
                 if(this.dataArticle.length) {
                    return this.dataArticle.filter((row, index) => {
                            if(row.type == 'Metode'){
                                return true;
                            }
                      });
                }
            },
            filterBantuan: function(){
                 if(this.dataArticle.length) {
                    return this.dataArticle.filter((row, index) => {
                            if(row.type == 'Bantuan'){
                                return true;
                            }
                      });
                }
            }
        }
    }
</script>
