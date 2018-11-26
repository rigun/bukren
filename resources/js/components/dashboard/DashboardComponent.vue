<template id="admin-list">
<div id="dashboarComponent" class="contentlist">
<div class="flex-container">
      <div class="columns m-t-10">
        <div class="column">
          <h1 class="title">Dashboard</h1>
        </div>
        
      </div>
      <div class="columns">
          <div class="column is-one-quarter"  v-if="numbers.length != 0">
                <div v-if="sliderImage == null && numbers.length != 0">
                            <b-field >
                                <b-upload v-model="sliderImage"
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
                    <div  v-if="sliderImage != null && numbers.length != 0" >
                        <img style="width: 150px" :src="preview" alt="">
                        <div class="columns is-multiline">
                            <div class="column is-full">
                                <div class="select ">
                                    <select v-model="urutan">
                                        <option value="0" hidden>Pilih salah satu</option>
                                        <option v-for="number in numbers" :key="number" >{{number}}</option>
                                    </select>

                                </div>
                            </div>
                            <div class="column is-full">
                                <button class="button button-success" @click="uploadSlider">Upload</button>

                            </div>
                        </div>
                        
                    </div>
          </div>
          <div class="column" :class="{'is-three-quarters': numbers.length != 0, ' is-full': numbers.length == 0}" >
              <div class="box">
                <div class="info">
                    <h2 >Slider Anda</h2>
                </div>
                
                <carousel :perPage="3" :navigationEnabled="true" :paginationEnabled="false">
                    <slide v-for="slider in sliders" :key="slider.id" >
                            <img style="width: 150px" :src="'/images/slider/'+slider.filename">
                            <p>Slider ke {{slider.urutan}}</p>
                            <div class="columns">
                                <div class="column">
                                <button class="button button-primary is-danger" @click="deletePicture(slider.id, slider.urutan)">Hapus Foto </button>
                                    
                                </div>
                                <div class="column">
                                <button class="button button-primary is-info" @click="copyToClipboard(slider.filename,'/images/slider/')">Copy link</button>

                                </div>
                            </div>
                    </slide>
                
                </carousel>
            </div>
          </div>
      </div><!-- end of slider -->

      <div class="columns">
          <div class="column is-one-quarter" >
                <div v-if="kategoriImage == null" >
                            <b-field >
                                <b-upload v-model="kategoriImage"
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
                    <div  v-if="kategoriImage != null" >
                        <img style="width: 150px" :style="'background-color:'+kategoriColors.hex" :src="previewKategori" alt="img">
                        <div class="columns is-multiline">
                            <div class="column is-three-quarters">
                                <div class="field">
                                    <label class="label" >Nama Kategori</label>
                                    <div class="control">
                                        <input class="input" type="text" v-model="kategoriName" placeholder="Name">
                                    </div>
                                    
                                </div>
                               
                            </div>
                            <div class="column is-full">
                                <button class="button button-success" @click="uploadKategori">Upload</button>

                            </div>
                        </div>
                        
                    </div>
          </div>
          <div class="column is-three-quarters "  >
              <div class="box">
                <div class="info">
                    <h2 >Kategori Anda</h2>
                </div>
                
                <carousel :perPage="3" :navigationEnabled="true" :paginationEnabled="false">
                    <slide v-for="kategori in kategoris" :key="kategori.id" >
                            <img style="width: 150px" :src="'/images/kategori/'+kategori.filename">
                            <p>{{kategori.name}}</p>

                            <ul>
                                <li>
                                    <button class="button button-primary is-danger" @click="deleteKategori(kategori.id)">Hapus Foto </button>
                                </li>
                                <li>
                                    <button class="button button-primary is-warning" @click="editKategoriFunc(kategori)">Edit Kategori</button>
                                </li>
                                <li>
                                    <button class="button button-primary is-info" @click="copyToClipboard(kategori.filename,'/images/kategori/')">Copy link</button>
                                </li>
                            </ul>
                    </slide>
                
                </carousel>
            </div>
          </div>
      </div><!-- end of kategori -->

      
   <b-modal :active.sync="isComponentModalActive" has-modal-card>
            <modal-form :kategori="editKategori" v-on:get-kategori="getKategori"></modal-form>
        </b-modal>
</div> <!-- end of container-->
</div>
</template>
<style scoped>
ul{
    list-style: none;
    margin-left: 0px;
    margin-top: 0px;
}
ul button{
    width: 100%;
}
</style>

<script>
import { Carousel, Slide } from 'vue-carousel';

const ModalForm = {
    props: ['kategori'],
        data(){
            return{
                load: false,
                kategoriImage: null,
                kategoriName: '',
                editImage: null,
            }
        },
        mounted(){
                this.setData();
        },
        template: `
            <form @submit.prevent="senddata();load = true">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title" >Add kategori</p>
                    </header>
                    <section class="modal-card-body">
                        <div v-if="kategoriImage == null && editImage == null" style="text-align: center">
                                <b-field >
                                    <b-upload v-model="kategoriImage"
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
                            <img style="width: 150px" :src="previewKategori" alt="img">
                            <a @click="kategoriImage = null" class="button is-danger">Ganti</a>
                        </div>
                        <div style="text-align:center;" v-else-if="editImage != null">
                            <img style="width: 150px" :src="'/images/kategori/'+editImage" alt="img">
                            <a @click="editImage = null" class="button is-danger">Ganti</a>
                        </div>
                            <div class="columns is-multiline">
                                <div class="column is-three-quarters">
                                    <div class="field">
                                        <label class="label" >Nama Kategori</label>
                                        <div class="control">
                                            <input class="input" type="text" v-model="kategoriName" placeholder="Name">
                                        </div>
                                        
                                    </div>
                                
                                </div>
                            </div>
                            
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-fullwidth" type="button" @click="$parent.close()">Close</button>
                        <button class="button is-primary is-fullwidth" :class="{'is-loading' : load}" >Edit</button>
                    </footer>
                </div>
            </form>
        `,
        methods:{
            setData(){
                this.editImage = this.kategori.filename
                this.kategoriName = this.kategori.name
            },
            senddata(){
                 var formData = new FormData();
                 if(this.editImage == null){
                     formData.append('file',  this.kategoriImage);
                 }
                 formData.append('name', this.kategoriName);
                    var uri = '/api/kategori/'+this.kategori.id;
                    axios.patch(uri,formData,{
                headers: {
                    'Content-Type': 'multipart/form-data',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
                }).then((response) => {
                        this.load = false;
                        this.$parent.close();
                         this.$emit('get-kategori')
                    }).catch(error => {
                        console.log(error)
                        this.load = false;
                        this.$parent.close()
                        this.$toast.open({
                        duration: 2000,
                        message: "Coba Lagi",
                        position: 'is-bottom',
                        type: 'is-danger',
                        queue: false,
                    })
                    });
            }
        },
        computed: {
            previewKategori(){
                return URL.createObjectURL(this.kategoriImage);
            }
        }
    }

    export default {
        components:{
            ModalForm,
            Carousel,
            Slide,
        },
        data(){
            return{
                roles: localStorage.getItem('roles'),
                header: localStorage.getItem('token'),
                sliders: [],
                sliderImage: null,
                urutan: 0,
                numbers: [1,2,3,4,5,6],
                kategoris: [],
                kategoriImage: null,
                kategoriColors :'#333',
                kategoriName : '',
                isComponentModalActive: false,
                editKategori : null
            }
        },
        mounted(){
            this.getSlider();
            this.getKategori();
         
        },
        methods:{
            editKategoriFunc(kategori){
                this.isComponentModalActive = true;
                this.editKategori = kategori
            },
           uploadSlider(){
              let formData = new FormData();
              formData.append('file',  this.sliderImage);
              formData.append('urutan',  this.urutan);
              axios.post( '/api/slider',
                  formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
                }
            ).then((response) => {
                this.sliderImage = null;
                this.getSlider();
            })
            .catch(error =>{
                this.sliderImage = null;
                console.log(error);
            });
           },
           getSlider(){
               let url = '/api/slider'
               axios.get(url,{
                   headers: {
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                    }
                }).then((response) => {
                    this.sliders = response.data;
                    for(var i =0;i<this.sliders.length; i++){
                        var index = this.numbers.indexOf(this.sliders[i].urutan);
                        if(index !== -1){
                            this.numbers.splice(index, 1);

                        }
                    }
                    
                })
                .catch(error =>{
                    console.log(error);
                });
           },
           deletePicture(id,urutan){
                 this.$toast.open({
                        duration: 500,
                        message: 'Menghapus',
                        position: 'is-bottom',
                        type: 'is-info',
                        queue: false,
                    })
                let uri = '/api/slider/'+id;
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
                        this.numbers.push(urutan);
                        this.getSlider();
                    }).catch(error=>{
                        this.$toast.open({
                            message: 'Silahkan coba lagi',
                            position: 'is-bottom',
                            type: 'is-danger'
                        })
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
              uploadKategori(){
              let formData = new FormData();
              formData.append('file',  this.kategoriImage);
              formData.append('name',  this.kategoriName);
              axios.post( '/api/kategori',
                  formData,
                {
                headers: {
                    'Content-Type': 'multipart/form-data',
                        Authorization: 'Bearer ' + localStorage.getItem('token')
                }
                }
            ).then((response) => {
                this.kategoriImage = null;
                this.getKategori();
            })
            .catch(error =>{
                this.kategoriImage = null;
                console.log(error);
            });
           },
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
            deleteKategori(id){
                 this.$toast.open({
                        duration: 500,
                        message: 'Menghapus',
                        position: 'is-bottom',
                        type: 'is-info',
                        queue: false,
                    })
                let uri = '/api/kategori/'+id;
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
                        this.getKategori();
                    }).catch(error=>{
                        this.$toast.open({
                            message: 'Silahkan coba lagi',
                            position: 'is-bottom',
                            type: 'is-danger'
                        })
                    });
            },
             
        },
        computed:{
            preview(){
                return URL.createObjectURL(this.sliderImage);
            },
            previewKategori(){
                return URL.createObjectURL(this.kategoriImage);
            },
   
        }
    }
</script>
