<template id="admin-list">
<div id="dashboarComponent" class="contentlist">
<div class="flex-container">
      <div class="columns m-t-10">
        <div class="column">
          <h1 class="title">Post Barang</h1>
        </div>
        
      </div>
      <div class="columns is-multiline">
          <div class="column is-one-third" >
                <div class="box-upload">
                    <div class="uploadSubject">
                   <p class="plus">+</p>
                    <p class="deskripsi">Upload Barang</p>
                    </div>

                </div>
                <div class="box-upload is-button-upload" @click="createBarang()">

                </div>
               
          </div>
        
          <div class="column is-one-third" v-for="barang in Relations" :key="barang.id" >
              <div class="box">
                <div class="info">
                    <span class="tag is-primary is-medium">{{barang.kategori.name}}</span>
                    <span class="tag is-primary"  >{{barang.type}}</span>
                    <img :src="'../../images/book/'+barang.filename" alt="">
                    <p class="namaBarang"> {{barang.nama}}</p>
                    <p class="hargaBarang"> Rp. {{barang.harga}}</p>
                    
                    <br>
                    <ul>
                        <li><button class="button button-primary is-warning" style="width: 100%" @click="editBarang(barang)">Edit Barang </button></li>
                        <li><button class="button button-primary is-danger" style="width: 100%" @click="deleteBarang(barang.id)">Hapus Barang </button></li>
                        <li><button class="button button-primary is-info " style="width: 100%" @click="copyToClipboard(barang.slug,'http://127.0.0.1:8000/detaillist/')">Copy Url</button></li>
                    </ul>
                        
                        

                </div>
            </div>
          </div>
      </div><!-- end of Barang -->

      
</div> <!-- end of container-->
 <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <modal-form :method="type" :barang="barang" :kategoris="kategoris" v-on:get-barang="getBarang"></modal-form>
        </b-modal>
</div>
</template>
<style scoped>
ul{
    list-style: none;
    margin-left: 0px;
    margin-top: 0px;
}

</style>

<script>
import { Carousel, Slide } from 'vue-carousel';
import { Chrome } from 'vue-color';
const ModalForm = {
    props: ['kategoris','method','barang'],
        data(){
            return{
                load: false,
                barangImage: null,
                nama: '',
                deskripsi: '',
                thisYear: new Date().getFullYear(),
                tahun: '',
                type: 'Gratis',
                harga: 0,
                stok : 0,
                pengarang: '',
                kat_id: '',
                slug: '',
                url: 'http://127.0.0.1:8000',
                editImage: null,
            }
        },
        mounted(){
            if(this.method == 'edit'){
                this.setData();
            }else{
                this.init();
            }
        },
        template: `
            <form @submit.prevent="senddata();load = true">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title" >Tambahkan Barang</p>
                    </header>
                    <section class="modal-card-body">
                    <div v-if="barangImage == null && editImage == null">
                        <b-field style="text-align:center">
                            <b-upload v-model="barangImage"
                                drag-drop >
                                <section class="section">
                                    <div class="content has-text-centered">
                                        <p>
                                            <b-icon
                                                icon="upload"
                                                size="is-large">
                                            </b-icon>
                                        </p>
                                        <p>Drop your files here or click to upload</p>
                                    </div>
                                </section>
                            </b-upload>
                        </b-field>
                        </div>
                        <div style="text-align:center;" v-else-if="editImage == null">
                            <img style="width: 150px" :src="previewBarang" alt="img">
                            <a @click="barangImage = null" class="button is-danger">Ganti</a>
                        </div>
                        <div style="text-align:center;" v-else-if="editImage != null">
                            <img style="width: 150px" :src="'../../images/book/'+editImage" alt="img">
                            <a @click="editImage = null" class="button is-danger">Ganti</a>
                        </div>
                        <p class="control" v-if="method == 'create'">
                                <slug-widget :url="url+'/'" subdirectory="detaillist" :title="nama" @copied="slugCopied" @slug-changed="updateSlug"></slug-widget>
                                <input type="hidden" v-model="slug" name="slug" />
                            </p>
                        
                        <b-field label="Nama">
                            <b-input
                                type="text"
                                v-model="nama" expanded
                                required>
                            </b-input>
                        </b-field>
                        <b-field label="Pengarang">
                            <b-input
                                type="text"
                                v-model="pengarang" expanded
                                required>
                            </b-input>
                        </b-field>
                        <div class="field">
                            <label for="name" class="label">Jenis Buku</label>

                            <div class="control">
                                <label class="radio">
                                <input type="radio" value="Gratis" name="question" v-model="type">
                                Gratis
                                </label>
                                <label class="radio">
                                <input type="radio" value="Disewakan" name="question" v-model="type">
                                Disewakan
                                </label>
                                <label class="radio">
                                <input type="radio" value="Dijual" name="question" v-model="type">
                                Dijual
                                </label>
                            </div>
                        </div>
                        <b-field label="Harga" v-if="type != 'Gratis'">
                            <b-field>
                                <p class="control">
                                    <button class="button" disabled>
                                        Rp
                                    </button>
                                </p>
                                <b-input type="number" v-model="harga" expanded required></b-input>
                            </b-field>
                        </b-field>

                    <div class="field is-horizontal">
                        
                            <div class="field-body">
                                <div class="field">
                                        <label for="name" class="label">Kategori</label>
                                    <p class="control is-expanded has-icons-right">
                                        <span class="select">
                                        <select v-model="kat_id">
                                            <option v-for="cat in kategoris" :key="cat.id" :value="cat.id">{{cat.name}}</option>
                                        </select>
                         
                                        </span>
                                    </p>
                                </div>
                            </div>

                            <div class="field-body">
                                <div class="field">
                                        <label for="name" class="label">Tahun</label>
                                    <p class="control is-expanded has-icons-right">
                                        <span class="select">
                                        <select v-model="tahun">
                                            <option v-for="index in 40" :key="index" >{{thisYear - index}}</option>
                                        </select>
                         
                                        </span>
                                    </p>
                                </div>
                            </div>

                        </div>
                   
                        <b-field label="Deskripsi">
                            <b-input maxlength="200" type="textarea" v-model="deskripsi"></b-input>
                        </b-field>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-fullwidth" type="button" @click="$parent.close()">Close</button>
                        <button class="button is-primary is-fullwidth" :class="{'is-loading' : load}" v-if="method == 'create'">Tambahkan</button>
                        <button class="button is-primary is-fullwidth" :class="{'is-loading' : load}" v-else>Edit</button>
                    </footer>
                </div>
            </form>
        `,
        methods:{
            setData(){
                this.editImage = this.barang.filename
                this.nama = this.barang.nama
                this.deskripsi = this.barang.deskripsi
                this.pengarang = this.barang.pengarang
                this.harga = this.barang.harga
                this.stok = this.barang.stok
                this.tahun = this.barang.tahun
                this.type = this.barang.type
                this.kat_id = this.barang.id_kategori
            },
            init(){
                this.editImage = null
                this.nama = ''
                this.deskripsi = null
                this.pengarang = null
                this.harga = 0
                this.stok = 0
                this.tahun = null
                this.type = 'Gratis'
                this.kat_id = null
            },
            updateSlug: function(val) {
             this.slug = val;
            },
            slugCopied: function(type, msg, val) {
                notifications.toast(msg, {type: `is-${type}`});
            },
            senddata(){
                 let formData = new FormData();
                 if(this.editImage == null){
                     formData.append('file',  this.barangImage);
                 }
                 formData.append('nama',  this.nama);
                 formData.append('deskripsi',  this.deskripsi);
                 formData.append('pengarang',  this.pengarang);
                 formData.append('harga',  this.harga);
                 formData.append('stok',  this.stok);
                 formData.append('tahun',  this.tahun);
                 formData.append('type',  this.type);
                 if(this.method == 'create'){
                     formData.append('slug',  this.slug);
                 }
                 formData.append('kat_id',  this.kat_id);
                 if(this.method == 'create'){
                    var uri = '/api/barang';

                 }else if(this.method == 'edit'){
                    var uri = '/api/barang/'+this.barang.id;
                 }
                    axios.post(uri,formData,{
                headers: {
                    'Content-Type': 'multipart/form-data',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
                }).then((response) => {
                        this.load = false;
                        this.$parent.close();
                         this.$emit('get-barang')
                    }).catch(error => {
                        this.load = false;
                        this.$parent.close()
                        this.$toast.open({
                        duration: 2000,
                        message: error,
                        position: 'is-bottom',
                        type: 'is-danger',
                        queue: false,
                    })
                    });
            }
        },
        computed: {
            previewBarang(){
                return URL.createObjectURL(this.barangImage);
            }
        }
    }
    export default {
        components:{
            Carousel,
            Slide,
            ModalForm,
            'chrome-picker': Chrome,
        },
        data(){
            return{
                roles: localStorage.getItem('roles'),
                header: localStorage.getItem('token'),
                Relations: [],
                isComponentModalActive: false,
                kategoris: null,
                color: '#333',
                colors: [],
                colorName: null,
                sizeName: null,
                typeUkuran: 'Baju',
                ukurans:[],
                type: 'create',
                barang: {},
            }
        },
        mounted(){
            this.getBarang();
            this.getKategori();
        },
        methods:{
            getKategori(){
               let url = '/api/kategori'
               axios.get(url,{
                   headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.kategoris = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
           },
         
           getBarang(){
               let url = '/api/barang'
               axios.get(url,{
                   headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.Relations = response.data;
                    
                })
                .catch(error =>{
                    console.log(error);
                });
           },
           editBarang(barang){
               this.type = 'edit';
               this.barang = barang;
               this.isComponentModalActive = true;
           },
           createBarang(){
               this.type = 'create';
               this.barang = null;
               this.isComponentModalActive = true;
           },
           deleteBarang(id){
                 this.$toast.open({
                        duration: 500,
                        message: 'Menghapus',
                        position: 'is-bottom',
                        type: 'is-info',
                        queue: false,
                    })
                let uri = '/api/barang/'+id;
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
                        this.getBarang();
                    }).catch(error=>{
                        this.$toast.open({
                            message: 'Silahkan coba lagi',
                            position: 'is-bottom',
                            type: 'is-danger'
                        })
                    });
            },
            addWarna(){
              axios.post( '/api/warna',
                  {nama: this.colorName, kodeWarna: this.color.hex},
                {
                    headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }
            ).then((response) => {
                this.colorName = null;
                this.getWarna();
            })
            .catch(error =>{
                this.colorName = null;
                console.log(error);
            });
           },
            addUkuran(){
              axios.post( '/api/ukuran',
                  {nama: this.sizeName, type: this.typeUkuran},
                {
                    headers: {
                            Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }
            ).then((response) => {
                this.sizeName = null;
                this.getUkuran();
            })
            .catch(error =>{
                this.sizeName = null;
                console.log(error);
            });
           },
           copyToClipboard: function(val,path) {
                let temp = document.createElement('textarea');
                temp.value = path+val;
                document.body.appendChild(temp);
                temp.select();
                try {
                    let success = document.execCommand('copy');
                    let type = (success ? 'success' : 'warning');
                    let msg = (success ? `Copied to Clipboard: ${val}` : "Copy failed, your browser may not support this feature");
                    this.$emit('copied', type, msg, val);
                    this.$toast.open({
                        duration: 5000,
                        message: 'Berhasil di copy',
                        position: 'is-bottom',
                        type: 'is-success'
                    })
                    
                } catch (err) {
                    this.$emit('copy-failed', val);
                    this.$toast.open({
                        duration: 5000,
                        message: 'Coba lagi',
                        position: 'is-bottom',
                        type: 'is-danger'
                    })
                }
               
                document.body.removeChild(temp);
            },
             
        },
        computed:{
            preview(){
                return URL.createObjectURL(this.BarangImage);
            },
            previewKategori(){
                return URL.createObjectURL(this.kategoriImage);
            },
            previewSubkategori(){
                return URL.createObjectURL(this.subkategoriImage);
            }
        }
    }
</script>
