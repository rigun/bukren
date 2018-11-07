<template>
   <div class="content" id="landingComponent">
         <div class="header">
             <div class="container">
                    <div class="columns">
                    <div class="column landingInfo" style="align-self:center">
                            <h1>Website Pencarian Referensi Buku Untuk Mahasiswa Semua Program Studi di Indonesia</h1>
                            <hr>
                            <p>Bukren adalah sebuah Website Referensi Buku yang bertujuan untuk mempertemukan pemiliki buku dan pencari buku. Pemiliki buku dapat sekedar meminjamkan bukunya kepada siapapun melalui website ini, ataupun menyewakannya dan juga menjualnya. Transaksi yang dilakukan di website ini dapat dilakukan dengan temu langsung atau COD.</p>
                    </div>
                    <div class="column">
                        <img src="/images/book.png" alt="">
                    </div>
                </div>
             </div>
                
           </div>
       <div class="container">
         
           
            <div class="box">
                <h2 class="navbar-item  ">Program Studi</h2>

                <div class="columns is-multiline">
                    <div class="column is-one-quarter" v-for="prodi in prodis" :key="prodi.name" >
                        <div class="card">
                        <div class="card-content">
                            <router-link :to="{name: 'kategoriList', params: prodi.name}" >
                                <img :src="'./images/icons/'+ prodi.filename" alt="">
                                </router-link>
                                    <p style="font-size: 14px; text-align: center">{{prodi.name}}</p>

                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <h2 class="navbar-item  ">Gratis</h2>

                <div class="columns is-multiline">
                    <div class="column is-one-quarter" v-for="prodi in prodis" :key="prodi.name" >
                        <div class="card">
                        <div class="card-content">
                            <router-link :to="{name: 'kategoriList', params: prodi.name}"  >
                                    {{prodi.name}}
                                </router-link>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <h2 class="navbar-item  ">Sewa</h2>

                <div class="columns is-multiline">
                    <div class="column is-one-quarter" v-for="prodi in prodis" :key="prodi.name" >
                        <div class="card">
                        <div class="card-content">
                            <router-link :to="{name: 'kategoriList', params: prodi.name}" >
                                    {{prodi.name}}
                                </router-link>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box">
                <h2 class="navbar-item  ">Jual</h2>

                <div class="columns is-multiline">
                    <div class="column is-one-quarter" v-for="prodi in prodis" :key="prodi.name" >
                        <div class="card">
                        <div class="card-content">
                            <router-link :to="{name: 'kategoriList', params: prodi.name}"  >
                                    {{prodi.name}}
                                </router-link>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
           
       </div>
   </div>
</template>
<style>

</style>


<script>

 export default {
     data(){
         return{
             prodis:[
                    {name:'Hukum',
                    filename: 'Hkm.png'},
                    {name:'Akuntasi',
                    filename: 'Ak.png'}, 
                    {name:'Ekonomi Pembangunan',
                    filename: 'EP.png'}, 
                    {name:'Manajemen',
                    filename: 'Man.png'},
                    {name:'Teknik Informatika',
                    filename: 'TF.png'},
                    {name:'Teknik Industri',
                    filename: 'TI.png'},
                    {name:'Sistem Informasi',
                    filename: 'SI.png'},
                    {name:'Teknik Sipil',
                    filename: 'Sipil.png'},
                    {name:'Arsitek',
                    filename: 'Arsitek.png'},
                    {name:'Teknobiologi',
                    filename: 'Tekno.png'},
                    {name:'Sosiologi',
                    filename: 'Sos.png'},
                    {name:'Ilmu Komunikasi',
                    filename: 'ilkom.png'}]

         }
     },
     created(){
     },
     methods:{
        
     }
        
    }
</script>