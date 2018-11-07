<template>
   <div class="content" id="homeLayout">
       <div class="background-color-all"></div>
     <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="https://bulma.io">
                <img src="https://bulma.io/images/bulma-logo.png" width="112" height="28">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasicExample" class="navbar-menu">
                <div class="navbar-start">
                
                
                </div>

                <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                    <a class="button is-primary" @click="isComponentModalActive = true; type='login'">
                        <strong>Masuk</strong>
                    </a>
                    <a class="button is-light"  @click="isComponentModalActive = true; type='submit'">
                        Daftar
                    </a>
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
                            <li>Tentang Kami</li>
                            <li>Kegiatan Kami</li>
                            <li>Hubungi Kami</li>
                        </ul>
                    </div>
                    <div class="column">
                        <strong>Metode Transaksi</strong>
                        <ul>
                            <li>Beli</li>
                            <li>Sewa</li>
                            <li>Pinjam</li>
                        </ul>
                    </div>
                    <div class="column">
                        <strong>Bantuan</strong>
                        <ul>
                            <li>Syarat dan Ketentuan</li>
                            <li>Kebijakan Privasi</li>
                            <li>Panduan Keamanan</li>
                        </ul>
                    </div>
                    <div class="column iconFollow">
                        <strong>Ikuti Kami</strong>
                        <ul >
                            <li>icon</li>
                            <li>icon</li>
                            <li>icon</li>
                        </ul>
                    </div>
                </div>
            </div> <!--end of container-->
            <hr>
            <p style="text-align: center">Copyright © {{year}} Bukren</p>

        </div>

        <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <modal-form v-bind="data" :type="type"></modal-form>
        </b-modal>

        <!-- <div  class="modal" v-bind:class="{ 'is-active' : activeCreate }">
      <div class="modal-background" v-on:click="modalCreate()" ></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Daftar</p>
            <button class="delete" aria-label="close" v-on:click="modalCreate()"></button>
          </header>
            <form v-on:submit.prevent ="updateLoad();signUp();">

            <section class="modal-card-body">
            

                <b-field label="Email"
                    :type="{'is-danger' : false}"
                    :message="{'This email is invalid':false}">
                    <b-input type="email"
                        v-model="data.email"
                        maxlength="60">
                    </b-input>
                </b-field>

                <b-field label="Password">
                    <b-input type="password"
                        v-model="data.password"
                        password-reveal>
                    </b-input>
                </b-field>
               
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success" :class="{'is-loading' : load}" >Login</button>
          </footer>
          </form>

      </div>
    </div>

        <div  class="modal" v-bind:class="{ 'is-active' : activeLogin }">
      <div class="modal-background" v-on:click="modalLogin()" ></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Masuk</p>
            <button class="delete" aria-label="close" v-on:click="modalLogin()"></button>
          </header>
            <form v-on:submit.prevent ="updateLoad();login();">

            <section class="modal-card-body">
            

                <b-field label="Email"
                    :type="{'is-danger' : false}"
                    :message="{'This email is invalid':false}">
                    <b-input type="email"
                        v-model="data.email"
                        maxlength="30">
                    </b-input>
                </b-field>

                <b-field label="Password">
                    <b-input type="password"
                        v-model="data.password"
                        password-reveal>
                    </b-input>
                </b-field>
               
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success" :class="{'is-loading' : load}" >Login</button>
          </footer>
          </form>

      </div>
    </div> -->

   </div>
</template>
<style>

</style>


<script>
import store from '../../store'

const ModalForm = {
    
        props: ['email', 'password','type'],
        data(){
            return{
                load: false,
            }
        },
        template: `
            <form @submit.prevent="senddata();load = true">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title" v-if="type=='login'">Masuk</p>
                        <p class="modal-card-title" v-if="type=='submit'">Daftar</p>
                    </header>
                    <section class="modal-card-body">
                        <b-field label="Email">
                            <b-input
                                type="email"
                                :value="email"
                                v-model="email"
                                placeholder="Your email"
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
                    <footer class="modal-card-foot">
                        <button class="button" type="button" @click="$parent.close()">Close</button>
                        <button class="button is-primary" :class="{'is-loading' : load}" v-if="type=='login'">Masuk</button>
                        <button class="button is-primary" :class="{'is-loading' : load}" v-if="type=='submit'">Daftar</button>
                    </footer>
                </div>
            </form>
        `,
        methods:{
            senddata(){
                if(this.type=="submit"){
                    let uri = '/api/user';
                    axios.post(uri,{email: this.email, password: this.password}).then((response) => {
                        this.load = false;
                        this.$parent.close()
                        this.$router.push({ name: 'Sukses' })
                    }).catch(error => {
                        this.$parent.close()
                        this.$toast.open({
                        duration: 2000,
                        message: error,
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
                        this.$router.push({ name: 'DashboardLayout' })
                    }).catch(error => {
                        this.loginError = true
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
             data:{
                 email: '',
                 password: '',
             },
                user: {},
                error:'',
                mssg:'Login',
             load: false,
             prodis:['Hukum','Akuntasi', 'Ekonomi Pembangunan', 'Manajemen','Teknik Informatika','Teknik Industri','Sistem Informasi','Teknik Sipil','Arsitek','Teknobiologi','Sosiologi','Ilmu Komunikasi']
         }
     },
     created(){
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
                    this.mssg = response.data.userdata.name;
                }
            }).catch(error => {
                this.mssg = 'Login';
            })  
     },
      mounted(){
          this.getUser();
        },
     methods:{
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
     }
       
    }
</script>