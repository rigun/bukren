<template>
    <div id="bag" style="padding-top: 20px;">
        <div class="box">
            <div class="card" v-for="bag in bags" :key="bag.id">
                <div class="card-content">
                    <article class="media">
                        <figure class="media-left">
                            <p class="image is-64x64">
                            <img :src="'../../images/book/'+bag.barang.filename">
                            </p>
                        </figure>
                        <div class="media-content">
                            <div class="content">
                            <p>
                                <strong>{{bag.barang.nama}}</strong><br>
                                Pengarang : {{bag.barang.pengarang}} <br>
                                Harga  : Rp. {{bag.barang.harga}} <br>
                            </p>
                            </div>
                            
                        </div>
                        <div class="media-right">
                            <ul style="list-style: none">
                                <li>
                                    <a class="button is-primary" :class="{'is-loading':load}" @click="hubPemilik(bag.barang.id_pemilik)">
                                      Hubungi Pemilik
                                    </a>
                                </li>
                                <li>
                                    <button class="button is-danger" style="min-width: 200px" @click="deleteBag(bag.id)">Hapus</button>

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
           bags : null,
           load: false,
        }
    },
      created: function() {
        this.getBag();
    },
    methods:{
        hubPemilik(id_pemilik){
            this.load = true;
             let uri = '/api/pesan/';
                    axios.post(uri,{id_penerima: id_pemilik},{
                        headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                        }
                    }).then((response) => {
                        this.$router.push({name: 'Message',params: {token: response.data}});
                    }).catch(error=>{
                        this.$toast.open({
                            message: 'Silahkan coba lagi',
                            position: 'is-bottom',
                            type: 'is-danger'
                        })
                    });
        },
        getBag(){
            this.load = false;
            let uri = '/api/bag';
            axios.get(uri,{
                  headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
                  }
              }).then((response) => {
                this.bags = response.data;
            });
        },
        deleteBag(id){
                 this.$toast.open({
                        duration: 500,
                        message: 'Menghapus',
                        position: 'is-bottom',
                        type: 'is-info',
                        queue: false,
                    })
                let uri = '/api/bag/'+id;
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
                     
                        this.getBag();
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
