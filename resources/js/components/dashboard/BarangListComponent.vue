<template id="barang-list">
<div class="contentlist">
<div class="flex-container">
      <div class="columns m-t-10">
        <div class="column">
          <h1 class="title">Manage barang</h1>
        </div>
        <div class="column" style="height: 60px;">
            <router-link v-bind:to="{ name: 'Barang' }">
          <button class="button is-success is-pulled-right" ><i class="fa fa-user-plus m-r-10"></i> Buat barang Baru</button>
            </router-link>
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
                <th>Pemilik</th>
                <th>Slug</th>
                <th>Tanggal Pembuatan</th>
                <th>Pengaturan</th>
              </tr>
            </thead>

            <tbody>
                  
                <tr v-for="(barang, index) in filterbarang " :key="barang.id">
                  <th>{{ index + 1 + start}}</th>
                  <td>{{ barang.nama }}</td>
                  <td>{{ barang.user.name }}</td>
                  <td>{{ barang.slug }}</td>
                  <td>{{ barang.created_at }}</td>
                  <td><a class="button is-danger" href="#" v-on:click.prevent="modalDelete();setIdDelete(barang)">Hapus</a></td>
                </tr>
            
            </tbody>
          </table>
          <div class="footer-table-pagination">
         
        </div>  
        </div>
       
      </div> <!-- end of .card -->
         
    </div>

    <div  class="modal" v-bind:class="{ 'is-active' : active }">
      <div class="modal-background" v-on:click="modalCreate" ></div>
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Tambahkan barang</p>
            <button class="delete" aria-label="close" v-on:click="modalCreate"></button>
          </header>
            <form v-on:submit.prevent ="createbarang()">

            <section class="modal-card-body">
            
            <div class="columns">
              <div class="column">
                <div class="field">
                  <label for="name" class="label">Nama</label>
                  <p class="control">
                    <input type="text" class="input" v-model="databarang.name" name="name" id="name" required>
                  </p>
                </div>
                <div class="field">
                  <label for="name" class="label">Username</label>
                  <p class="control">
                    <input type="text" class="input" v-model="databarang.username" name="username" id="username" required>
                  </p>
                </div>

                <div class="field">
                  <label for="password" class="label">Password</label>
                  <p class="control">
                    <input type="password" class="input" name="password" v-model="databarang.password" id="password" required >
                  </p>
                </div>

              </div> <!-- end of .column -->
            </div> <!-- end of .columns for forms -->       
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success" :class="{'is-loading' : load}" @click="updateLoad()">Buat barang</button>

            <a class="button is-danger" v-on:click="modalCreate" >Cancel</a>
          </footer>
          </form>

      </div>
    </div>
    <div  class="modal" v-bind:class="{ 'is-active' : activeUpdate }">
      <div class="modal-background" v-on:click="modalUpdate()" ></div>
      
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Perbaharui barang</p>
            <button class="delete" aria-label="close" v-on:click="modalUpdate()"></button>
          </header>
            <form v-on:submit.prevent ="updatebarang()">

            <section class="modal-card-body">
            <div class="columns">
              <div class="column">
                <div class="field">
                  <label for="name" class="label">Nama</label>
                  <p class="control">
                    <input type="text" class="input" v-model="databarang.name" name="name" id="name" required>
                  </p>
                </div>
                <div class="field">
                  <label for="name" class="label">Username</label>
                  <p class="control">
                    <input type="text" class="input" v-model="databarang.username" name="username" id="username" required>
                  </p>
                </div>

                <div class="field">
                  <label for="password" class="label">Password</label>
                  <p class="control">
                    <input type="password" class="input" name="password" v-model="databarang.password" id="password" >
                  </p>
                </div>
                <div class="field">
                  <p class="control">
                    <b-checkbox v-model="databarang.password_options" >reset</b-checkbox>
                  </p>
                </div>

              </div> <!-- end of .column -->
            </div> <!-- end of .columns for forms -->       
          </section>
          <footer class="modal-card-foot">
            <button class="button is-success"  :class="{'is-loading' : load}" @click="updateLoad()">Ubah Data</button>

            <a class="button is-danger" v-on:click="modalUpdate()" >Cancel</a>
          </footer>
          </form>

      </div>
    </div>
    <div  class="modal" v-bind:class="{ 'is-active' : activeDelete }">
      <div class="modal-background" v-on:click="modalDelete()" ></div>
      
        <div class="modal-card">
          <header class="modal-card-head">
            <p class="modal-card-title">Hapus barang</p>
            <button class="delete" aria-label="close" v-on:click="modalDelete()"></button>
          </header>
            <form v-on:submit.prevent ="deletebarang()">

            <section class="modal-card-body">
                <p>barang yang dihapus tidak dapat dikembalikan lagi, apakah anda yakin ingin menghapusnya ? </p>
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
    export default {
    
        data(){
            return{
                search: '',
                active: false,
                activeUpdate: false,
                activeDelete:false,
                id:'',
                databarang:{
                  id:'',
                  name:'',
                  username:'',
                  password:'',
                  password_options: false,
                  roles:2
                  },
                databarangNull:{
                  id:'',
                  name:'',
                  username:'',
                  password:'',
                  password_options: false,
                  roles:2
                  },
                barangs:[],
                page: 0,
                start: 0,
                end: 0,
                countbarang: 0,
                load: false,
            }
        },
        created: function() {
            this.getbarang();
            
        },
         methods: {
           pageChange(page, start, end) {
              this.page = page;
              this.start = start;
              this.end = end;
          },
          updateLoad(){
            this.load = true;
          },
            getbarang(){
              this.load = false;
                  let uri = '/api/barang/all';
                  axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                      this.barangs = response.data;
                      this.countbarang = this.barangs.length;
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
              this.databarang = data;
            },
            createbarang: function() {
             
              let uri = '/api/barang/create';
              axios.post(uri, this.databarang,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.active = false;
                this.databarang = this.databarangNull;
                   this.getbarang();
                this.$toast.open({
                    duration: 2000,
                    message: 'barang berhasil di tambahkan',
                    position: 'is-bottom',
                    type: 'is-success',
                    queue: false,
                });
              }).catch(error => {
                
                this.active = false;
                this.databarang = this.databarangNull;
                this.getbarang();
                this.$toast.open({
                  duration: 2000,
                  message: 'Terjadi Kesalahan, Silahkan coba lagi',
                  position: 'is-bottom',
                  type: 'is-danger',
                  queue: false,
              })
                });
            },
            updatebarang(){
              
              let uri = '/api/barang/update/'+this.databarang.id;
              axios.patch(uri, this.databarang,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
               
                this.activeUpdate = false;
                this.databarang = this.databarangNull;
                this.getbarang();

                 this.$toast.open({
                  duration: 2000,
                  message: response.data.msg,
                  position: 'is-bottom',
                  type: 'is-success',
                  queue: false,
              })
              }).catch(error => {
              
                this.activeUpdate = false;
                this.databarang = this.databarangNull;
                this.getbarang();

                  this.$toast.open({
                  duration: 2000,
                  message: 'Coba lagi dengan username yang berbeda',
                  position: 'is-bottom',
                  type: 'is-danger',
                  queue: false,
              })
                });
            },
            deletebarang(){
              let uri = '/api/barang/'+this.id;
              axios.delete(uri,{
                headers: {
                    Authorization: 'Bearer ' + localStorage.getItem('token')
                }
            }).then((response) => {
                this.activeDelete = false;
                this.id = '';
                this.getbarang();
                
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
                this.getbarang();
                
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
            filterbarang: function(){
                if(this.barangs.length) {
                    return this.barangs.filter((row, index) => {
                        if(this.search != '') return row.nama.toLowerCase().includes(this.search.toLowerCase()); else return true;
                    });
                }
            },
            
        },
        
}
</script>
