<template>
   <div class="content" id="landingComponent">
         <div class="header">
             <div class="container">
                     <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:380px;overflow:hidden;visibility:hidden;">
                            <!-- Loading Screen -->
                            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" :src="'./images/spin.svg'" />
                            </div>
                            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">
                                <div v-for="slider in sliders" :key="slider.id">
                                    <img data-u="image" :src="'./images/slider/'+slider.filename" />
                                </div>
                                

                            </div>
                            <!-- Bullet Navigator -->
                            <div data-u="navigator" class="jssorb051" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                                <div data-u="prototype" class="i" style="width:16px;height:16px;">
                                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                        <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                                    </svg>
                                </div>
                            </div>
                            <!-- Arrow Navigator -->
                            <div data-u="arrowleft" class="jssora051" style="width:65px;height:65px;top:0px;left:35px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                    <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                                </svg>
                            </div>
                            <div data-u="arrowright" class="jssora051" style="width:65px;height:65px;top:0px;right:35px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                                    <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                                </svg>
                            </div>
                        </div>
             </div>
                
           </div>
       <div class="container">
         
           <h2>Pilih Prodi Anda</h2>
           <div class="box">
                <carousel :perPage="6" :navigationEnabled="true" :paginationEnabled="false">
                    <slide v-for="kategori in kategoris" :key="kategori.id" >
                       
                        <router-link :to="{ name: 'List', params: { kategori: kategori.name }}" class="slideHover" >
                            <!-- <a href="" class="slideHover"> -->
                            <div style="padding: 5px 40px;" >
                            <img :src="'/images/kategori/' + kategori.filename">
                            </div>
                            <!-- </a> -->
                        </router-link>
                        <p class="kategoriName"> {{kategori.name}}</p>

                    </slide>
                
                </carousel>
           </div>
           
           <div class="columns is-multiline">
                <div class="column is-full">
                    <img class="" :src="'./images/slider/Banner1.png'"  alt="">
                    
                </div>
                <div class="column is-one-third">
                    <img class="" :src="'./images/slider/Banner1.png'"  alt="">
                    
                </div>
                <div class="column is-one-third">
            <img class="" :src="'./images/slider/Banner1.png'"  alt="">
                    
                </div>
                <div class="column is-one-third">
            <img class="" :src="'./images/slider/Banner1.png'"  alt="">
                
                </div>
            
            </div>


            <div class="box">
                <div class="info">
                    <h2 >Terbaru</h2>
                </div>
                
                       <carousel :perPage="6" :navigationEnabled="true" :paginationEnabled="false">
                            <slide v-for="barang in barangTerbarus" :key="barang.name" >
                                <router-link :to="{name: 'DetailList',  params: { slug: barang.slug } }" >
                                            <img :src="'./images/book/'+barang.filename">

                                            </router-link>
                                 <p class="namaBarang"> {{barang.nama}}</p>
                                 <p class="hargaBarang"> Rp. {{barang.harga}}</p>

                            </slide>
                        
                        </carousel>
            </div>

            <div class="box">
                <div class="info">
                    <h2 >Gratis</h2>
                     <router-link :to="{name: 'ListType',  params: { type: 'Gratis' } }"  >
                        Lihat Selengkapnya
                        </router-link>
                </div>
                
                        <carousel :perPage="6" :navigationEnabled="true" :paginationEnabled="false">
                            <slide v-for="barang in barangGratis" :key="barang.name" >
                                <router-link :to="{name: 'DetailList',  params: { slug: barang.slug } }" >
                                            <img :src="'./images/book/'+barang.filename">
                                            </router-link>
                                <p class="namaBarang"> {{barang.nama}}</p>
                                 <p class="hargaBarang"> Rp. {{barang.harga}}</p>
                            </slide>
                        
                        </carousel>
            </div>
            <div class="box">
                <div class="info">
                    <h2 >Berbayar</h2>
                        <router-link :to="{name: 'ListType',  params: { type: 'Berbayar' } }"  >
                        Lihat Selengkapnya
                        </router-link>
                </div>
                
                        <carousel :perPage="6" :navigationEnabled="true" :paginationEnabled="false">
                            <slide v-for="barang in barangBerbayar" :key="barang.name" >
                                <router-link :to="{name: 'DetailList',  params: { slug: barang.slug } }"  >
                                            <img :src="'./images/book/'+barang.filename">
                                            </router-link>
                                <p class="namaBarang"> {{barang.nama}}</p>
                                 <p class="hargaBarang"> Rp. {{barang.harga}}</p>
                            </slide>
                        
                        </carousel>
            </div>

            
           
       </div>
   </div>
</template>
<style>

</style>

<script>

</script>

<script>
import { Carousel, Slide } from 'vue-carousel';
 export default {
     components: {
        Carousel,
        Slide
    },
    mounted() {
        
        this.getSlider();
        this.getKategori();
        this.getBarang();
    },
     data(){
         return{
             sliders : [],
             kategoris: [],
             barangTerbarus: [],
             barangRekomendasis: [],
             barangGratis: [],
             barangBerbayar: [],
         }
     },
       
     created(){
     },
     methods:{
         getBarang(){
            this.getBarangRekomendasi();
            this.getBarangTerbaru();
            this.getBarangGratis();
            this.getBarangBerbayar();
         },
        
        getBarangGratis(){
               let url = '/api/barang/gratis'
               axios.get(url).then((response) => {
                    this.barangGratis = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });

        },
        getBarangBerbayar(){
               let url = '/api/barang/berbayar'
               axios.get(url).then((response) => {
                    this.barangBerbayar = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });

        },
        getBarangRekomendasi(){
               let url = '/api/barang/rekomendasi'
               axios.get(url).then((response) => {
                    this.barangRekomendasis = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });

        },
        getBarangTerbaru(){
               let url = '/api/barang/terbaru'
               axios.get(url).then((response) => {
                    this.barangTerbarus = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });

        },
        
        getSlider(){
               let url = '/api/slider'
               axios.get(url).then((response) => {
                    this.sliders = response.data;
                    this.$nextTick(()=>{
                        this.jssor_1_slider_init();
                    })
                })
                .catch(error =>{
                    console.log(error);
                });
           },
             getKategori(){
               let url = '/api/kategori'
               axios.get(url).then((response) => {
                    this.kategoris = response.data;
                })
                .catch(error =>{
                    console.log(error);
                });
           },
        jssor_1_slider_init(){
            var jssor_1_options = {
            $AutoPlay: 1,
            $SlideWidth: 720,
            $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
            },
            $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
            }
            };

            const jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*#region responsive code begin*/

            var MAX_WIDTH = 1152;

            var ScaleSlider = this.ScaleSlider(jssor_1_slider,MAX_WIDTH);

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            
        },
        ScaleSlider(jssor_1_slider,MAX_WIDTH) {
            var containerElement = jssor_1_slider.$Elmt.parentNode;
            var containerWidth = containerElement.clientWidth;

            if (containerWidth) {

                var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

                jssor_1_slider.$ScaleWidth(expectedWidth);
            }
            else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
     }
    }
</script>