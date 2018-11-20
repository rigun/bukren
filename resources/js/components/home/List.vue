<template>
    <div>
        
        <div class="container is-fullhd">
             <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
            <ul>
                <li style="margin-top: 4px;"><router-link :to="{name:'Landing'}">Home</router-link></li>
                <li class="is-active"><a href="#" aria-current="page">{{$route.params.kategori}}</a></li>
            </ul>
            </nav>
            <div class="notification listNotif">
               
                <div class="container">
                    <nav class="level">
                    <!-- Left side -->
                    <div class="level-left">
                        <div class="level-item">
                        <h1 @click="setHover">
                            {{$route.params.kategori}}
                        </h1>
                        </div>
                       
                    </div>

                    <!-- Right side -->
                    <div class="level-right">
                        
                    </div>
                    </nav>

                </div>
            </div>
        </div>
       
        <div class="container">
            <div class="columns is-multiline">
                <div class="column is-one-quarter" v-for="barang in barangs" :key="barang.id">
                    <div class="box" id="barangImage">
                              <div class="barangImage">
                                        <a>
                                            <img :src="'../../images/book/'+barang.filename">
                                            <div class="event-button name"><span><router-link :to="{name: 'DetailList',  params: { slug: barang.slug } }"><button class="button is-primary is-fullwidth" href="#">Detail</button></router-link></span></div>
                                        </a>
                                </div>
                            <p class="namaBarang">{{barang.nama}}</p>
                            <p class="hargaBarang">Rp {{barang.harga}}</p>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</template>
<style scoped>
p{
    cursor: default;
}
</style>

<script>
export default {
    data(){
        return{
            barangs: [],
        }
    },
    mounted(){
        this.getBarang();
    },
    updated(){
        

    },
    methods:{
        getBarang(){
            let url = '/api/barang/'+this.$route.params.kategori
            axios.get(url).then((response) => {
                this.barangs = response.data;
            })
            .catch(error =>{
                console.log(error);
            });
        },
        setHover(){
            var elements = document.querySelectorAll('.barangImage a');
            hoverDir(elements);
        }
    }
}
</script>
