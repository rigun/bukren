<template>
    <div style="margin-top:80px">
       <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
            <ul>
                <li style="margin-top: 4px;"><router-link :to="{name:'Landing'}">Home</router-link></li>
                <li style="margin-top: 4px;"><router-link :to="{ name: 'List', params: { kategori: barang.kategori.name }}">{{barang.kategori.name}}</router-link></li>
                <li class="is-active"><a href="#" aria-current="page">{{barang.nama}}</a></li>
            </ul>
            </nav>
        <div class="container">
          <div class="columns">
            <div class="column is-three-quarters">
              <div class="box">
                  <div class="columns">
                    <div class="column is-half">
                      <img :src="'../../images/book/'+barang.filename" alt="">
                    </div>
                    <div class="column is-half">
                      <h1>{{barang.nama}}</h1>
                      <hr>
                      <h2>Rp. {{barang.harga}}</h2>
                      <hr>
                      <div class="field is-horizontal">
                          <label class="label">Methode Transaksi :  {{barang.type}}</label>
                      </div>
                      <hr>
                        <div class="field">
                          <label class="label">Pengarang</label>
                          <div class="field ">
                              <p class="control">
                              {{barang.pengarang}}
                              </p>
                            </div>
                      </div>
                        <div class="field">
                          <label class="label">Tahun Terbit</label>
                          <div class="field ">
                              <p class="control">
                              {{barang.tahun}}
                              </p>
                            </div>
                      </div>
                      <hr>
                      <div class="field">
                          <label class="label">Deskripsi</label>
                          <div class="field ">
                              <p class="control">
                              {{barang.deskripsi}}
                              </p>
                            </div>
                      </div>
                      
                    </div>
                  </div>

              </div>
            </div>
            <div class="column">
              

              <div class="box">
                <a class="button is-fullwidth is-warning" :class="{'is-loading' : load2}" @click="hubPemilik(barang.id_pemilik)">Hubungi Pemilik</a> <br>
                <a class="button is-fullwidth is-info" :class="{'is-loading' : load1}" @click="addtobag()">Tambah ke bag</a>
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
        barang:{},
        jumlah: 1,
        warna: null,
        ukuran: null,
        token : localStorage.getItem('token'),
        load1: false,
        load2: false,
      }
    },
    mounted(){
      this.getBarang();
    },
    methods:{
      getBarang(){
         let url = '/api/barangdetail/'+this.$route.params.slug
            axios.get(url).then((response) => {
                this.barang = response.data;
            })
            .catch(error =>{
                console.log(error);
            });
      },
      addtobag(){
        this.load1 = true;
        if(this.token == null){
          this.$toast.open({
                    duration: 2000,
                    message: 'Anda Harus Login Terlebih Dahulu',
                    position: 'is-bottom',
                    type: 'is-danger',
                    queue: false,
                });
        this.load1 = false;

        }else{
            let formData = new FormData();
            formData.append('barang_id',  this.barang.id);
            axios.post( '/api/bag',
                formData,
              {
              headers: {
                      Authorization: 'Bearer ' + localStorage.getItem('token')
              }
              }
          ).then((response) => {
              this.$router.push({ name: 'Bag' });
              this.load1 = false;

          })
          .catch(error =>{
              console.log(error);
               this.load1 = false;
          });
        }
      },

      hubPemilik(id_pemilik){
           this.load2 = true;
             let uri = '/api/pesan/';
             if(this.token == null){
              this.$toast.open({
                        duration: 2000,
                        message: 'Anda Harus Login Terlebih Dahulu',
                        position: 'is-bottom',
                        type: 'is-danger',
                        queue: false,
                    });
            this.load2 = false;

            }else{
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

            }
                    
        },
      buy(){
       
        
      }
    }
}
</script>
