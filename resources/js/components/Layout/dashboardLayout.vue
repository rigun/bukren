<template>
   <div class="content">
    <vue-topprogress ref="topProgress"></vue-topprogress>
    <div v-if="loading == true"></div>
    <div  v-else>
    <div id="topnav" class="topnav" >
        <nav class="navbar has-shadow dashnav" style="padding: 0px">
                <div class="navbar-start">
                    <div class="navbar-item box-hamburger">
                        <div class="hamburger" onclick="myHamburger(this)">
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>
                    </div>
                </div>
                <div class="navbar-end">
                    <!-- <div class="navbar-item notif-space">
                        <i class="fa fa-bell"></i>
                    </div> -->
                    <div class="navbar-item dropdown-space has-dropdown is-hoverable">
                    <div class="navbar-item">
                        <div id="textRightNav" class="text-item" onclick="rightDropDown()">
                            <p class="mute-text" >
                                {{roles}}
                            </p>
                            <h2 class="name-text">
                            <strong>{{user.name}}
                                </strong>
                            </h2>

                        </div>
                        <i id="logoRightNav" class="fa fa-user-circle m-l-15 size-40" onclick="rightDropDown()"></i>
                    </div>
                    <div class="navbar-dropdown arrow-up"></div>
                        <ul id="navbarRight" class="navbar-dropdown is-boxed  is-right box-dropdown-custom">
                            <li>
                            <router-link v-if="roles != 'user'" class="navbar-item" v-bind:to="{ name: 'UploadFile'}"> Upload File</router-link>
                            <router-link v-else class="navbar-item" v-bind:to="{name: 'StudentsProfile', params: {id:user.id}}" > <i class="fa fa-user m-r-10" aria-hidden="true"></i> Profile Saya </router-link>
                            </li>
                            <hr class="navbar-divider">
                            <li>  <router-link v-bind:to="{name: 'Logout'}" class="navbar-item">
                                        <span class="icon">
                                        <i class="fa fa-fw fa-sign-out m-r-5"></i>
                                        </span>
                                        Logout
                        </router-link ></li>
                        </ul>
                    </div>

                </div>
                        
            </nav>
    </div>
       <div id="side-menu"  class="side-menu">
            <aside class="menu">
                <div id="side-header" class="side-header">
                    <div class="menu-label imgLabel">
                        <router-link :to="{name: 'Landing'}">
                        <!-- <img src="/images/Logo.png" alt="Logo" /> -->
                        <h1>Bukren</h1>
                        </router-link>
                    </div>
                </div>
                <hr class="separator-side">
                <div class="side-body">
                
                    <div class="side-label">
                        HOME
                    </div>
                    <ul class="menu-list">
                        <li><router-link v-bind:to="{name: 'DashboardContent'}"><i class="fa fa-home m-r-10" aria-hidden="true"></i>  <span>Dashboard</span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'PostComponent', params: { kategori: 'PPDB' }}"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Buku Saya</span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'PostComponent', params: { kategori: 'PPDB' }}"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Transaksi Saya</span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'PostComponent', params: { kategori: 'PPDB' }}"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Laporan</span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'PostComponent', params: { kategori: 'PPDB' }}"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Laporan</span> </router-link></li>
                    </ul>

                    
                    
                </div>
            </aside>
        </div>
        <div id="app">
            <main class="dashboardContent">
            <transition name="fade">
            <router-view></router-view>
            </transition>
            </main>
        </div>
          <div  class="modal" v-bind:class="{ 'is-active' : activeFirst }" v-if="roles=='user'">
      <div class="modal-background" ></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title text-resetpassword" style="text-align:center">Selamat datang <br/>silahkan update password anda terlebih dahulu <br/> Terima Kasih</p>
          </header>
            <form v-on:submit.prevent ="firstLogin()">

            <section class="modal-card-body">
            
            <div class="columns">
              <div class="column">
                
                <div class="field">
                  <label for="name" class="label">Password Baru</label>
                  <p class="control">
                    <input type="password" class="input" v-bind:class="{ 'is-danger' : wrongPassword }" v-model="dataPassword.password_baru" @keyup="cek" required>
                  </p>

                </div>
                <div class="field">
                  <label for="name" class="label">Konfirmasi Password Baru</label>
                  <p class="control">
                    <input type="password" class="input" v-bind:class="{ 'is-danger' : wrongPassword }" v-model="dataPassword.password_konfirmasi" @keyup="cek" required>
                  </p>
                  <label for="name" class="label" v-if="wrongPassword == true"><span style="color:red">Password tidak cocok</span></label>

                </div>
                
              
                
              </div> <!-- end of .column -->
            </div> <!-- end of .columns for forms -->       
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success" :disabled="wrongPassword">Ubah Password</button>
          </footer>
          </form>

      </div>
    </div>
        </div>
      
   </div>
</template>

<script>
import { vueTopprogress } from 'vue-top-progress'
       export default {
            components: {
            vueTopprogress
        },
        data() {
            return {
                user: {},
                error:'',
                loading: true,
                roles: localStorage.getItem('roles'),
                activeFirst : false,
                wrongPassword: false,
                dataPassword: {
                    password_baru: '',
                    password_konfirmasi: '',
                }
            }
        },
        created(){
            axios.get('/api/user', {
            headers: {
                Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            })
            .then(response => {
                if(response.data.status == "Token is Expired"){
                    this.$router.push({ name: 'Logout' })
                }else {
                    this.user = response.data.userdata;
                    if(this.roles == 'user'){
                        if(this.user.detail.status == 0){
                            this.activeFirst = true;
                        }
                    }
                }
            }).catch(error => {
                this.error = error;
            })  
        },
        mounted(){
            this.$refs.topProgress.start()
             this.getUser();
        },
        methods:{
            cek(){
                if(this.dataPassword.password_baru != '' && this.dataPassword.password_konfirmasi != ''){
                    if(this.dataPassword.password_baru != this.dataPassword.password_konfirmasi){
                        this.wrongPassword = true;
                    }else{
                        this.wrongPassword = false;
                    }
                }
            },
            firstLogin(){
              let uri = '/api/firstLogin/';
              axios.patch(uri, this.dataPassword,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.$toast.open({
                    duration: 2000,
                    message: response.data.msg,
                    position: 'is-bottom',
                    type: 'is-success',
                    queue: false,
                });
                this.activeFirst = false;
              }).catch(error => {
                this.$toast.open({
                    duration: 2000,
                    message: error.data.msg,
                    position: 'is-bottom',
                    type: 'is-danger',
                    queue: false,
                });
                this.activeFirst = false;
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
                            this.$refs.topProgress.done();
                            this.loading = false;
                            if(response.data.status == "Token is Expired"){
                                this.$router.push({ name: 'Logout' })
                            }else {
                                this.user = response.data.userdata;
                                if(this.roles == 'user'){
                                    if(this.user.detail.status == 0){
                                        this.activeFirst = true;
                                    }
                                }
                            }
                        }).catch(error => {
                            this.error = error;
                            this.$router.push({ name: 'Logout' })
                        })  
                }).catch(error => {
                    this.$router.push({ name: 'Logout' })
                });
            }
        }
    }
</script>
