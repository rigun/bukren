<template>
    <div id="profile" style="min-height: 310px;">
        <div class="container">
            <div class="columns">
                <div class="column is-one-third">
                    <aside class="menu">
                         <div class="side-body">
            
                    <ul class="menu-list" style="list-style: none;">
                        <li><router-link v-bind:to="{name: 'Profile'}"><i class="fa fa-home m-r-10" aria-hidden="true"></i>  <span>Profile</span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'Barang' }"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Book </span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'Bag' }"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Bag </span> </router-link></li>
                        <li><router-link v-bind:to="{ name: 'Chat' }"  ><i class="fa fa-file m-r-10" aria-hidden="true"></i>  <span>Chat </span> </router-link></li>
                         <li><router-link v-bind:to="{name: 'Logout'}" class="navbar-item"><span class="icon"><i class="fa fa-fw fa-sign-out m-r-5"></i></span>Logout</router-link ></li>

                    </ul>
                </div>
                        </aside>
                </div>
                <div class="column">

                <div id="app">
                    <main class="userDashboardContent">
                    <transition name="fade">
                    <router-view></router-view>
                    </transition>
                    </main>
                </div>


                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
.router-link-exact-active{
    background-color: whitesmoke !important;
    color: #363636;
}
</style>

<script>
export default {
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
        
}
</script>
