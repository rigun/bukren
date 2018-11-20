<template>
   <div class="content" id="homeLayout">
     <nav class="navbar" role="navigation" aria-label="main navigation">
         <div class="container">
<div class="navbar-brand">
                <router-link :to="{name: 'Landing'}" class="navbar-item" style="color: white">
                <img src="/images/logo.png" height="40" style="margin-right: 20px;">
                Bukren
                </router-link>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start" style="margin-right: 50px;">
                <div class="field has-addons">
                    <div class="control" style="width: 100%">
                        <input class="input" type="text" v-model="searchInput" placeholder="Cari . .">
                    </div>
                    <div class="control">
                        <a class="button" @click="search()">
                        <img :src="'https://bukren.thekingcorp.org/images/icons/search.png'" style="width: 20px" alt="search">
                        </a>
                    </div>
                </div>
                
                </div>

                <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                    <router-link v-bind:to="{ name: 'Bag' }"  class="button is-shoppingbasket" v-if="user != null">
                        <i class="fa fa-shopping-basket"  style="font-size: 28px;"></i> <span class="bullet">{{count}}</span>
                    </router-link>
                    <router-link :to="{name: 'Profile'}"   class="button is-primary" v-if="user != null && user.roles[0].name != 'admin'">
                         <strong v-if="user.name != '-'">hallo, {{user.name}}</strong>
                        <strong v-else>hallo, {{user.email}}</strong>
                    </router-link>
                    <router-link :to="{name: 'DashboardContent'}"   class="button is-primary" v-if="user != null && user.roles[0].name == 'admin'">
                         <strong v-if="user.name != '-'">hallo, {{user.name}}</strong>
                        <strong v-else>hallo, {{user.email}}</strong>
                    </router-link>
                    
                    <a class="button is-primary" @click="isComponentModalActive = true; type='login'"  v-if="user == null">
                        <strong>Masuk</strong>
                    </a>
                    <a class="button is-light"  @click="isComponentModalActive = true; type='submit'" v-if="user == null">
                        Daftar
                    </a>
                    </div>
                </div>
                </div>
            </div>
         </div>
            
    </nav>
            <div class="m-t-65"></div>
     <div id="appPage">
            <main class="pageContent">
            <transition name="fade">
            <router-view></router-view>
            </transition>
            </main>
        </div>
            <div class="m-b-30"></div>
        <div class="footer">
            <div class="container">
                <div class="columns">
                    <div class="column">
                        <strong>Bukren</strong>
                        <ul>
                            <li v-for="art in filterBukren" :key="art.id"><router-link :to="{name: 'Page', params :{slug: art.slug}}">{{art.title}}</router-link></li>
                        </ul>
                    </div>
                    <div class="column">
                        <strong>Metode Transaksi</strong>
                        <ul>
                            <li v-for="art in filterMetode" :key="art.id"><router-link :to="{name: 'Page', params :{slug: art.slug}}">{{art.title}}</router-link></li>
                        </ul>
                    </div>
                    <div class="column">
                        <strong>Bantuan</strong>
                        <ul>
                            <li v-for="art in filterBantuan" :key="art.id"><router-link :to="{name: 'Page', params :{slug: art.slug}}">{{art.title}}</router-link></li>
                        </ul>
                    </div>
                    <div class="column iconFollow">
                        <strong>Ikuti Kami</strong>
                        <ul >
                            <li><img :src="'https://bukren.thekingcorp.org/images/icons/sosmed/fb.png'" alt="facebook"></li>
                            <li><img :src="'https://bukren.thekingcorp.org/images/icons/sosmed/ins.png'" alt="instagram"></li>
                            <li><img :src="'https://bukren.thekingcorp.org/images/icons/sosmed/line.png'" alt="line"></li>
                            <li><img :src="'https://bukren.thekingcorp.org/images/icons/sosmed/twit.png'" alt="twitter"></li>
                        </ul>
                    </div>
                </div>
            </div> <!--end of container-->
            <hr>
            <p style="text-align: center">Copyright © {{year}} Bukren</p>

        </div>

        <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <modal-form :type="type" v-on:get-user="getUser"></modal-form>
        </b-modal>


   </div>
</template>
<style>

</style>


<script>
import store from '../../store'
const ModalForm = {
    
        props: ['type'],
        data(){
            return{
                email: '',
                password: '',
                load: false,
                infoView: 'none',
                infoMessage: null,
                valid: 0,
            }
        },
        template: `
            <form @submit.prevent="senddata();load = true" class="loginSubmit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title" v-if="type=='login'">Masuk</p>
                        <p class="modal-card-title" v-if="type=='submit'">Daftar</p><br>
                         
                    </header>
                    <section class="modal-card-body">
                        <b-field label="Email" v-if="type == 'login'">
                            <b-input
                                type="email"
                                :value="email"
                                v-model="email"
                                placeholder="Your email"
                                required>
                            </b-input>
                        </b-field>
                        <b-field label="Email" v-else
                            :type="infoView"
                            :message="infoMessage"
                            >
                            <b-input
                                type="email"
                                :value="email"
                                v-model="email"
                                placeholder="email"
                                @change.native="cekEmail"
                                required>
                            </b-input>
                        </b-field>

                        <b-field label="Password">
                            <b-input
                                type="password"
                                :value="password"
                                v-model="password"
                                password-reveal
                                placeholder="Your password"
                                required>
                            </b-input>
                        </b-field>

                    </section>
                    <footer class="modal-card-foot" style="display:block">
                
                        <button class="button is-fullwidth" type="button" @click="$parent.close()">Close</button><br>
                        <button class="button is-primary is-fullwidth" :class="{'is-loading' : load}" v-if="type=='login'">Masuk</button>
                        <button class="button is-primary is-fullwidth" :class="{'is-loading' : load}" v-if="type=='submit'">Daftar</button>
                        <p v-if="type == 'submit'">Sudah punya akun ? <span style="color: blue; cursor:pointer;" @click="type = 'login'">klik disini</span></p>
                        <p v-if="type == 'login'">Belum punya akun ? <span style="color: blue; cursor:pointer;" @click="type = 'submit'">klik disini</span></p>
                    </footer>
                   
                </div>
            </form>
        `,
        methods:{
            cekEmail(){
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                if(this.email == ''){
                    this.infoView = "none";
                        this.infoMessage = '';
                        this.valid = 0;
                }else if( re.test(String(this.email).toLowerCase()) ){
                    let uri = '/api/user/email/'+this.email;
                    axios.get(uri).then((response) => {
                    if(response.data){
                        this.valid = 0;
                        this.infoView = "is-danger";
                        this.infoMessage = "Email sudah terdaftar"
                    }else if(!response.data){
                        this.valid = 1;
                        this.infoView = "is-success";
                        this.infoMessage = "Email tersedia"
                    }
                    })
                }else{
                    this.valid = 0;
                    this.infoView = "is-danger";
                    this.infoMessage = "Email tidak valid"
                }

            },
            senddata(){
                if(this.type=="submit"){
                    let uri = '/api/user';
                    axios.post(uri,{email: this.email, password: this.password}).then((response) => {
                        this.load = false;
                        axios.post('/api/mail/send',{email: this.email}).then((response) =>{
                            this.$router.push({ name: 'SuksesLayout' })
                        }).catch(error =>{
                            this.$toast.open({
                                duration: 2000,
                                message: 'Gagal saat mengirim email',
                                position: 'is-bottom',
                                type: 'is-danger',
                                queue: false,
                            })
                        })
                    }).catch(error => {
                        this.$parent.close()
                        this.$toast.open({
                        duration: 2000,
                        message: 'Coba Lagi',
                        position: 'is-bottom',
                        type: 'is-danger',
                        queue: false,
                    })
                  });
                }else if(this.type=="login"){
                    axios.post('/api/auth/login', {
                        email: this.email,
                        password: this.password
                    }).then(response => {
                        store.commit('loginUser')
                        localStorage.setItem('token', response.data.access_token)
                        localStorage.setItem('roles', response.data.role)
                        this.load = false;
                        if(response.data.role == 'pengguna'){
                            this.$parent.close();
                            this.$emit('get-user')
                        }else{
                            this.$router.push({ name: 'DashboardContent' })
                        }
                        
                    }).catch(error => {
                        this.loginError = true;
                        this.$parent.close()
                        this.$toast.open({
                        duration: 2000,
                        message: "Username atau password salah",
                        position: 'is-bottom',
                        type: 'is-danger',
                        queue: false,
                        });
                    });
                }
            }
        }
    }



    export default {
        components: {
            ModalForm
        },
       
        data() {
            return {
                isComponentModalActive: false,
             year:'',
             activeCreate:false,
             activeLogin: false,
             type: '',
             data:{
                 email: '',
                 password: '',
             },
                user: null,
                error:'',
                mssg:'Login',
             load: false,
             count: 0,
             dataArticle:[],
             searchInput: '',
         }
     },
     created(){
        this.getArticle();

        this.getThisYear();
       axios.get('/api/user', {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => {
                if(response.data.status == "Token is Expired"){
                  this.mssg = 'Login';
                }else {
                    this.user = response.data.userdata;
                    this.getCountBag();
                }
            }).catch(error => {
                this.mssg = 'Login';
            })  
     },
      mounted(){
          this.getUser();
        },
        updated(){
            this.getCountBag();
        },
     methods:{
         search(){
             if(this.searchInput != ''){
                 this.$router.push({name: 'Search', params:{search : this.searchInput}})
             }
         },
          getArticle(){
                  let uri = '/api/article';
                  axios.get(uri).then((response) => {
                      this.dataArticle = response.data;
                  }).catch(error => {
                      // console.log(error);
                  });
            },
         getUser(){
                 axios.get('/api/refresh', {
                    headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then(response => {
                    localStorage.setItem('token', response.data.access_token);
                      axios.get('/api/user', {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                            }
                        })
                        .then(response => {
                            if(response.data.status == "Token is Expired"){
                                this.mssg = 'Login';
                            }else {
                                this.mssg = response.data.userdata.name;
                                this.user = response.data.userdata;
                                this.getCountBag();                                
                            }
                        }).catch(error => {
                            this.mssg = 'Login';
                        })  
                }).catch(error => {
                   this.mssg = 'Login';
                });
            },
         getThisYear(){
                this.year = new Date().getFullYear();
            },
            getCountBag(){
                axios.get('/api/bag/count', {
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                            }
                        })
                        .then(response => {
                            if(response.data.status == null){
                                this.count = response.data;

                            }
                        }).catch(error => {
                            this.count = 0;
                        })  
            },
         modalCreate(){
            if(this.activeCreate == true){
            this.activeCreate = false;
            }else if(this.activeCreate == false){
            this.activeCreate = true;
            }else{
            this.$toast.open({
                duration: 2000,
                message: 'error',
                position: 'is-bottom',
                type: 'is-danger',
                queue: false,
            });
            }
        },
         modalLogin(){
            if(this.activeLogin == true){
            this.activeLogin = false;
            }else if(this.activeLogin == false){
            this.activeLogin = true;
            }else{
            this.$toast.open({
                duration: 2000,
                message: 'error',
                position: 'is-bottom',
                type: 'is-danger',
                queue: false,
            });
            }
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