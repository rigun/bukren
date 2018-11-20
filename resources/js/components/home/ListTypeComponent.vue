<template>
    <div>
        
        <div class="container is-fullhd">
             <nav class="breadcrumb has-succeeds-separator" aria-label="breadcrumbs">
            <ul>
                <li style="margin-top: 4px;"><router-link :to="{name:'Landing'}">Home</router-link></li>
                <li class="is-active"><a href="#" aria-current="page">{{$route.params.type}}</a></li>
            </ul>
            </nav>
            <div class="notification" style="background: gainsboro;">
               
                <div class="container">
                    <nav class="level">
                    <!-- Left side -->
                    <div class="level-left">
                        <div class="level-item">
                        <h1 >
                            #{{$route.params.type}}
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
              <div class="columns m-t-10">
                <div class="column">
                    <div class="field has-addons">
                        <p class="control">
                            <input class="input" type="text" v-model="search" placeholder="Cari. . " >
                        </p>
                        <p class="control">
                            <a class="button is-static">
                            <i class="fa fa-search"></i>
                            </a>
                        </p>
                    </div>
                
                </div>
                
            </div>
            <div class="columns is-multiline">
                <div class="column is-one-quarter" v-for="barang in filterBarang" :key="barang.id">
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
            search: '',
        }
    },
    mounted(){
        this.getBarang();
    },
    methods:{
        getBarang(){
            let url = '/api/barangType/'+this.$route.params.type
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
      computed: {
       
            filterBarang: function(){
                if(this.barangs.length) {
                    return this.barangs.filter((row, index) => {
                            if(this.search != '') return row.nama.toLowerCase().includes(this.search.toLowerCase())
                            else return true;
                          });
                }
            },
            
        },
}
</script>
