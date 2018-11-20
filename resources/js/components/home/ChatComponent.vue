<template>
    <div id="pesan" style="padding-top: 20px;">
        <div class="box">
            <div class="card" v-for="pesan in pesans" :key="pesan.id">
                <div class="card-content">
                    <article class="media">
                        <div class="media-content">
                            <div class="content">
                            <p v-if="pesan.id_user1 == userDetail.id">
                                <strong>{{pesan.user2.name}}</strong><br>
                                <strong>Email : </strong>{{pesan.user2.email}} <br>
                            </p>
                            <p v-if="pesan.id_user2 == userDetail.id && pesan.id_user2 != pesan.id_user1">
                                <strong>{{pesan.user1.name}}</strong><br>
                                <strong>Email : </strong>{{pesan.user1.email}} <br>
                            </p>
                            </div>
                            
                        </div>
                        <div class="media-right">
                            <ul style="list-style: none">
                                <li>
                                    <router-link :to="{name: 'Message', params: {token: pesan.token}}" class="button is-primary" style="min-width: 200px">
                                        Buka Pesan
                                    </router-link>
                                </li>
                                <li>
                                    <button class="button is-danger" style="min-width: 200px" @click="deletePesan(pesan.id)">Hapus</button>

                                </li>
                            </ul>
                        </div>
                        </article>
                </div>
                
            </div>
        </div>
               
    </div>
</template>
<script>
export default {
    data(){
        return{
           pesans : null,
           userDetail:{
               id : null
           },
        }
    },
      created: function() {
        this.getPesan();
        this.getUser();
    },
    methods:{
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
        getPesan(){
            this.load = false;
            let uri = '/api/pesan';
            axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.pesans = response.data;
                
            });
        },
        deletePesan(id){
                 this.$toast.open({
                        duration: 500,
                        message: 'Menghapus',
                        position: 'is-bottom',
                        type: 'is-info',
                        queue: false,
                    })
                let uri = '/api/pesan/'+id;
                    axios.delete(uri,{
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    }).then((response) => {
                         this.$toast.open({
                            message: 'Berhasil di hapus',
                            position: 'is-bottom',
                            type: 'is-success'
                        })
                     
                        this.getPesan();
                    }).catch(error=>{
                        this.$toast.open({
                            message: 'Silahkan coba lagi',
                            position: 'is-bottom',
                            type: 'is-danger'
                        })
                    });
            },
    }
}
</script>
