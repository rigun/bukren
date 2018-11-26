<template id="user-list">
<div class="contentlist">
<div class="flex-container">
      <div class="columns m-t-10">
        <div class="column">
          <h1 class="title">Manage User</h1>
        </div>
        <div class="column" style="height: 60px;">
          <!-- <button class="button is-success is-pulled-right" v-on:click="modalCreate"><i class="fa fa-user-plus m-r-10"></i> Buat user Baru</button> -->
        </div>
      </div>
      <div class="columns m-t-10">
        <div class="column">
            <div class="field has-addons">
                <p class="control">
                    <input class="input" type="text" v-model="search" placeholder="Cari. . " >
                </p>
                <p class="control">
                    <a class="button is-static">
                    <i class="fa fa-search"></i>
                    </a>
                </p>
            </div>
        
        </div>
        
      </div>

      <div class="card p-b-20">
        <div class="card-content">
          <table class="table is-hoverable is-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Tanggal Pembuatan</th>
                <th>Pengaturan</th>
              </tr>
            </thead>

            <tbody>
                  
                <tr v-for="(user, index) in filteruser " :key="user.id">
                  <th>{{ index + 1 + start}}</th>
                  <td>{{ user.name }}</td>
                  <td>{{ user.email }}</td>
                  <td>{{ user.created_at }}</td>
                  <td><a class="button " :class="{'is-danger': user.status == 0 , 'is-success': user.status ==1 }" @click="updateStatus(user)"><span v-if="user.status == 0">Belum Verifikasi</span><span v-if="user.status == 1">Sudah Verifikasi</span></a></td>
                  <td><a class="button is-danger" href="#" v-on:click.prevent="modalDelete();setIdDelete(user)">Hapus</a></td>
                </tr>
            
            </tbody>
          </table>
          <div class="footer-table-pagination">
            <!-- <vue-ads-pagination v-if="countuser!=0"
                :page="0"
                :itemsPerPage="100"
                :total-items="countuser"
                :max-visible-pages="3"
                @page-change="pageChange"
            /> -->
        </div>  
        </div>
       
      </div> <!-- end of .card -->
         
    </div>

    
    <div  class="modal" v-bind:class="{ 'is-active' : activeDelete }">
      <div class="modal-background" v-on:click="modalDelete()" ></div>
      
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Hapus user</p>
            <button class="delete" aria-label="close" v-on:click="modalDelete()"></button>
          </header>
            <form v-on:submit.prevent ="deleteuser()">

            <section class="modal-card-body">
                <p>user yang dihapus tidak dapat dikembalikan lagi, apakah anda yakin ingin menghapusnya ? </p>
          </section>
          <footer class="modal-card-foot">
            <button class="button is-warning"  :class="{'is-loading' : load}" @click="updateLoad()">Hapus Data</button>

            <a class="button is-danger" v-on:click="modalDelete()" >Cancel</a>
          </footer>
          </form>

      </div>
    </div>
</div>
</template>

<script>
// import VueAdsPagination from 'vue-ads-pagination';
    export default {
       components: {
        //   VueAdsPagination,
      },
        data(){
            return{
                search: '',
                active: false,
                activeUpdate: false,
                activeDelete:false,
                id:'',
               datauser: [],
                users:[],
                page: 0,
                start: 0,
                end: 0,
                countuser: 0,
                load: false,
            }
        },
        created: function() {
          if(localStorage.getItem('roles') == 'user'){
                  this.$router.push({ name: 'DashboardContent' });
          }else{
            this.getuser();
          }
            
        },
         methods: {
           updateStatus(user){
             var status 
             if(user.status == 0){
               status = 1
             }else if(user.status == 1){
               status = 0
             }
              let uri = '/api/user/updateStatus/'+this.user.id;
              axios.patch(uri, {status: status},{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
               
                this.getuser();

                 this.$toast.open({
                  duration: 2000,
                  message: response.data.msg,
                  position: 'is-bottom',
                  type: 'is-success',
                  queue: false,
              })
              }).catch(error => {
                this.getuser();
                  this.$toast.open({
                  duration: 2000,
                  message: 'Coba lagi',
                  position: 'is-bottom',
                  type: 'is-danger',
                  queue: false,
              })
                });
           },
           pageChange(page, start, end) {
              this.page = page;
              this.start = start;
              this.end = end;
          },
          updateLoad(){
            this.load = true;
          },
            getuser(){
              this.load = false;
                  let uri = '/api/user/list/';
                  axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                      this.users = response.data;
                      this.countuser = this.users.length;
                  }).catch(error => {
                      // console.log(error.response)
                  });
            },
            modalCreate: function(event){
              if(this.active == true){
                this.active = false;
              }else if(this.active == false){
                this.active = true;
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
            modalUpdate(){
              if(this.activeUpdate == true){
                this.activeUpdate = false;
              }else if(this.activeUpdate == false){
                this.activeUpdate = true;
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
            modalDelete(){
              if(this.activeDelete == true){
                this.activeDelete = false;
              }else if(this.activeDelete == false){
                this.activeDelete = true;
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
            setIdDelete(data){
              this.id = data.id;
            },
            setDataUpdate(data){
              this.datauser = data;
            },
            createuser: function() {
             
              let uri = '/api/user/create';
              axios.post(uri, this.datauser,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.active = false;
                this.datauser = this.datauserNull;
                   this.getuser();
                this.$toast.open({
                    duration: 2000,
                    message: 'user berhasil di tambahkan',
                    position: 'is-bottom',
                    type: 'is-success',
                    queue: false,
                });
              }).catch(error => {
                
                this.active = false;
                this.datauser = this.datauserNull;
                this.getuser();
                this.$toast.open({
                  duration: 2000,
                  message: 'Terjadi Kesalahan, Silahkan coba lagi',
                  position: 'is-bottom',
                  type: 'is-danger',
                  queue: false,
              })
                });
            },
            updateuser(){
              
              let uri = '/api/user/update/'+this.datauser.id;
              axios.patch(uri, this.datauser,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
               
                this.activeUpdate = false;
                this.datauser = this.datauserNull;
                this.getuser();

                 this.$toast.open({
                  duration: 2000,
                  message: response.data.msg,
                  position: 'is-bottom',
                  type: 'is-success',
                  queue: false,
              })
              }).catch(error => {
              
                this.activeUpdate = false;
                this.datauser = this.datauserNull;
                this.getuser();

                  this.$toast.open({
                  duration: 2000,
                  message: 'Coba lagi dengan username yang berbeda',
                  position: 'is-bottom',
                  type: 'is-danger',
                  queue: false,
              })
                });
            },
            deleteuser(){
              let uri = '/api/user/delete/'+this.id;
              axios.delete(uri,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.activeDelete = false;
                this.id = '';
                this.getuser();
                
                  this.$toast.open({
                  duration: 2000,
                  message: 'Berhasil di hapus',
                  position: 'is-bottom',
                  type: 'is-success',
                  queue: false,
              })
              }).catch(error => {
                this.activeDelete = false;
                this.id = '';
                this.getuser();
                
                  this.$toast.open({
                  duration: 2000,
                  message: 'Coba lagi',
                  position: 'is-bottom',
                  type: 'is-danger',
                  queue: false,
              })
                });
            }
         },
        computed: {
            // filteruser: function(){
            //     if(this.users.length) {
            //         return this.users.filter((row, index) => {
            //                 if(this.search != '') return row.name.toLowerCase().includes(this.search.toLowerCase());
            //                 if(index >= this.start && index < this.end) return true;
            //               });
            //     }
            // },
            filteruser: function(){
                if(this.users.length) {
                    return this.users.filter((row, index) => {
                            if(this.search != '') return row.name.toLowerCase().includes(this.search.toLowerCase())
                            else return true;
                          });
                }
            },
            
        },
        
}
</script>
