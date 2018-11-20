<template>
    <div style="padding-top: 20px;">
        
    
       
        <div class="container">
            
            <div class="columns is-multiline">
                <div class="column is-one-quarter" v-for="barang in barangs" :key="barang.id">
                    <div class="box" id="barangImage">
                        <span class="tag is-primary is-medium">{{barang.kategori.name}}</span>
                            <span class="tag is-info"  >{{barang.type}}</span>
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
     watch: {
            '$route' (to, from) {
                if (from.params.search !== to.params.search) {
                     this.barangs = [];
                    return this.getBarang();
                }
            }
        },
    mounted(){
        this.getBarang();
    },
    methods:{
        getBarang(){
            let url = '/api/search/'+this.$route.params.search
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
    },
     
}
</script>
