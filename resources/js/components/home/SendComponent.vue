<template>
    <div id="profile">
        
                <div class="column">
                    <h1>Kirim Pesan</h1>
                    <h3>Detail Penerima</h3>
                    <p>Nama Lengkap : {{dataPenerim.name}}</p>
                    <p>Jenis Kelamin : {{dataPenerim.detail.jenisKelamin}}</p>
                    <p>NPM : {{dataPenerim.detail.npm}}</p>
                    <div class="box">
                        <div class="columns" v-for="msg in messages" :key="msg.id">
                            <div class="column is-11" :class="{'is-offset-1': msg.id_pemilik != userDetail.id}" >
                                <div class="card" >
                                    <div class="card-content" >
                                        {{msg.pesan}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form v-on:submit.prevent ="sendMail(); load = true">
                        <div class="columns">
                            <div class="column">
                               
                                <div class="field">
                                    <label for="name" class="label">Email Penerima </label>
                                    <p class="control">
                                        <input class="input " type="text" v-model="dataPenerim.email" disabled>
                                    </p>
                                </div>
                                <div class="field">
                                    <label for="name" class="label">Email Pengirim</label>
                                    <p class="control">
                                        <input class="input " v-model="userDetail.email" disabled>
                                    </p>
                                    <p class="help is-danger" v-if="userDetail.status == 0 || userDetail.status == 2">Email belum di verifikasi</p>
                                </div>

                                  <b-field label="Pesan">
                                        <b-input maxlength="200" type="textarea" v-model="pesan"></b-input>
                                    </b-field>
                                
                            </div> <!-- end of .column -->
                            </div> <!-- end of .columns for forms -->       
                        <footer class="modal-card-foot">
                            <button class="button is-success" :class="{'is-loading':load}">Kirim Pesan</button>

                        </footer>
                        </form>
        </div>
    </div>
</template>
<style scoped>
.is-offset-1{
    text-align: right;
}
</style>

<script>
export default {
    data(){
        return{
            userDetail:{
                name:'',
                email: '',
                detail: {
                    tanggalLahir: new Date(),
                    nomorHp: '',
                    jenisKelamin: 'Laki-laki',
                    npm: '',
                    prodi: '',
                }
            },
            dataPenerim: [],
            messages: [],
            load: false,
            kategoris: [],
            pesan: '',
        }
    },
      created: function() {
        this.getUser();
        this.getPenerima();
        this.getMessage();
    },
    methods:{
        getMessage(){
            this.load = false;
            let url = '/api/inbox/'+ this.$route.params.token;
               axios.get(url,{
                   headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.messages = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
        },

        getPenerima(){
               let url = '/api/penerima/detail/'+ this.$route.params.token;
               axios.get(url,{
                   headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.dataPenerim = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
           },
        getUser(){
            this.load = false;
            let uri = '/api/user/detail/';
            axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.userDetail = response.data;
                if(this.userDetail.name == '-'){
                    this.userDetail.name = null;
                }
                if(this.userDetail.detail == null){
                    this.userDetail.detail = {
                        tanggalLahir : new Date(),
                        nomorHp : '',
                        jenisKelamin : '',
                    }
                }
            });
        },
        sendMail(){
            let uri = '/api/outbox';
            axios.post(uri,{pesan: this.pesan, token: this.$route.params.token},{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                  this.getMessage();
                 this.$toast.open({
                    duration: 2000,
                    message: 'Detail Berhasil update',
                    position: 'is-bottom',
                    type: 'is-success',
                    queue: false,
                });
              }).catch(error => {
                  this.getMessage();
                 this.$toast.open({
                    duration: 2000,
                    message: 'Data tidak lengkap',
                    position: 'is-bottom',
                    type: 'is-danger',
                    queue: false,
                });
                });
        }
    }
}
</script>
