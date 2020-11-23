<template>
    <v-app>
        <usernav v-bind:user="user"></usernav>
        <v-container class="card-notifier">
            <!-- <v-btn @click="sample">Sample</v-btn> -->
            <v-row v-if="toShowBanner == true">
                <v-col cols="6">
                    <v-alert 
                    color="cyan"
                    border="left"
                    elevation="2"
                    colored-border
                    >
                    <div class="mx-2">
                        <v-row>
                            <v-col>
                                Want to start building business with us? <br>Click the button below to start! <br><br>
                            </v-col>
                            <v-col cols="2">
                                <v-btn icon color="red lighter-4" @click.prevent="sample"> <v-icon>mdi-close</v-icon></v-btn>
                            </v-col>
                        </v-row>
                        <v-btn outlined color="blue lighter-2" to="/store_registration" small>
                            Start Now
                        </v-btn>
                    </div>
                    </v-alert>
                </v-col>
            </v-row>
            <div class="row">
                <div class="col">
                    <div class="dashHeader">
                        <span class="discover">Discover </span><span class="daily">daily</span>
                    </div>
                    <div class="row">
                        <div class="col-7">
                            <div class="img1-container">
                                <img :src="'/images/img1.jpg'" alt="" class="img1">
                            </div>
                        </div>
                        <div class="col">
                            <div>
                                <div class="img2-container">
                                    <img :src="'/images/img2.jpg'" alt="" class="img2">
                                </div>
                            </div>
                            <div>
                                <div class="img3-container">
                                    <img :src="'/images/img3.jpg'" alt="" class="img3">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dashHeader">
                        <span class="new">New</span>
                        <span class="items">Items</span>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="container">
                        <div class="cart-card">
                            <div class="container">
                                <div class="header d-flex align-items-center">
                                    <span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <circle cx="9" cy="19" r="2" />
                                        <circle cx="17" cy="19" r="2" />
                                        <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
                                        </svg>
                                    </span>
                                    <span class="cartName">Cart</span>
                                </div>
                                <div class="cart-body pt-3">
                                    <div class="container">
                                        <div class="itemRow row">
                                            <div class="col-4">
                                                <div class="img-container">
                                                    <img :src="'/images/raze.jpg'" alt="" width="120" class="img-fluid">
                                                </div>
                                            </div>
                                            <div class="col text-white">
                                                <div class="itemTitle">Razer Black Widow</div>
                                                <div>$ 20</div>
                                                <div><span>Qty. 1</span></div>
                                            </div>
                                        </div>
                                        <div class="py-5"></div>
                                        <div class="text-center text-white">
                                            <router-link to="/cart" class="text-white">
                                            View All <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="28" height="28" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <line x1="5" y1="12" x2="19" y2="12" />
                                                        <line x1="13" y1="18" x2="19" y2="12" />
                                                        <line x1="13" y1="6" x2="19" y2="12" />
                                                    </svg>
                                            </router-link> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <v-container>
                <div class="row">
                    <div class="col" v-for="chunk in productChunks" :key="chunk.id">
                        <div v-for="product in chunk" :key="product.item_id">
                            <v-card
                                class="mx-auto my-12"
                                max-width="300"
                            >
                                <v-img
                                height="180"
                                :src="'/uploads/' + product.item_photo"
                                ></v-img>

                                <v-card-title>{{product.item_name}}</v-card-title>

                                <v-card-text>
                                <v-row
                                    align="center"
                                    class="mx-0"
                                >
                                    <v-rating
                                    :value="4.5"
                                    color="amber"
                                    dense
                                    half-increments
                                    readonly
                                    size="14"
                                    ></v-rating>

                                    <div class="grey--text ml-4">
                                    4.5 (413)
                                    </div>
                                </v-row>

                                <div class="my-4 subtitle-1">
                                    <div>
                                        ₱ {{product.item_price}}
                                    </div>
                                    <div>
                                        {{product.item_quantity}} stock(s)
                                    </div>
                                </div>

                                </v-card-text>

                                <v-divider class="mx-4"></v-divider>
                                <v-card-actions>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    :to="'/user_productDetails/' + product.item_id"
                                >
                                    View Product
                                </v-btn>
                                </v-card-actions>
                            </v-card>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <v-btn v-show="loadMore" @click="nextPage">Load More ...</v-btn>
                </div>
            </v-container>
            <!-- <v-container>
                <div v-for="product in products" :key="product.item_id">
                    <div>{{product.item_id}}</div>
                </div>
            </v-container> -->
        </v-container>

        <v-dialog
        v-model="dialog"
        persistent
        max-width="400"
        >
        <v-card>
            <v-card-title class="headline blue darken-2">
            Welcome!
            </v-card-title>
            <v-card-text class="py-3">Congratulations! 🎉 your store is approved by our admins. <br><br>Click to log-in as seller</v-card-text>
            <v-card-actions>
            <v-spacer></v-spacer>
                <v-btn
                    color="red darken-1"
                    text
                    @click="logout"
                >
                    Login
                </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>

    </v-app>
</template>
<script>
export default {
    
    data: () => ({
        productState: 'not-loading',
        dialog: false,
        user: {
            id: '',
            name: '',
            email: '',
            address: '',
            contact: '',
        },
        toShow: '',
        toShowBanner: false,
        message: 'Hello',
        products: [],
        loadMore: false,
        page: 0
    }),

    computed: {
        productChunks(){
            return _.chunk(this.products, 1);
        }
    },

    beforeRouteEnter(to, from, next){
        next( vm => {
            vm.getAllProducts()
        })
    },

    methods: {

        
        async getAllProducts(){
            await this.$http.get('api/allProducts', { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
            .then((res) => {
                
                this.products = res.body.data.data

                if(res.body.data.current_page < res.body.data.last_page){
                    this.loadMore = true
                    this.page = res.body.data.current_page + 1
                }
                else{
                    this.loadMore = false
                }
            })
        },


        checkIfActive(){
            this.$http.get('api/profile', { headers: { Authorization: 'Bearer ' + this.$auth.getToken()}})
            .then((res) => {
                // console.log(res.body)
                if(res.body['status'] == 'inactive'){
                    this.$auth.destroyToken()
                    this.$router.push('/login')
                }
                else if(res.body['usertype'] == 'seller'){
                    this.dialog = true
                }
            })
        },


        getUser(){
            var user = JSON.parse(localStorage.getItem('user'))
            this.user = user
        },


        logout(){
            this.$auth.destroyToken()
            this.$router.push('/login')
        },


        getSetting(){
            var setting = JSON.parse(localStorage.getItem('setting'))
            if(setting.adBanner == true){
                this.toShowBanner = true
            }
            else{
                this.toShowBanner = false
            }
        },


        sample(){
            this.$http.post('api/updateAd', this.user,{
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.toShowBanner = false
                localStorage.removeItem('setting')
                localStorage.setItem('setting', JSON.stringify(res.data.data))
            })
            .finally(() => this.getSetting())
        },

        async nextPage(){
            await this.$http.get(`api/allProducts?page=${this.page}`, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
            .then((res) => {
                // console.log(res.body.data)
                res.body.data.data.forEach(data => {

                    if(res.body.data.current_page < res.body.data.last_page){
                        this.loadMore = true
                        this.page = res.body.data.current_page + 1
                    }
                    else{
                        this.loadMore = false
                    }

                    this.products.push(data)
                });
                // this.products.push(res.body.data)
            })
        }
    },

    mounted(){
        this.getUser()
        this.getSetting()
        this.checkIfActive()
        // this.getAllProducts()
    }
}
</script>