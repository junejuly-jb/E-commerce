<template>
    <v-app>
        <v-container>
                <v-btn to="/userdashboard"><v-icon>mdi-arrow-left</v-icon></v-btn>
            <div class="row">
                <div class="col-sm-4 d-flex align-items-center">
                    <div class="dashHeader">
                        <span class="discover">Product </span><span class="daily">details</span>
                    </div>
                </div>
                <div class="col">
                    <v-card>
                        <div class="row">
                            <div class="col-md-3 d-flex justify-content-center align-items-center">
                                <v-avatar
                                color="primary"
                                size="104"
                                >KS</v-avatar>
                            </div>
                            <div class="col">
                                <div class="pb-2"><h5>{{ productDetail.store_name }} <v-icon color="blue">mdi-check-circle</v-icon></h5></div>
                                <div><p>{{ productDetail.store_description }}</p></div>
                                <div>
                                    <v-btn outlined color="blue">Visit Store</v-btn>
                                </div>
                            </div>
                        </div>
                    </v-card>
                </div>
            </div>
            <v-card>
                <v-container>
                    <div class="row">
                        <div class="col-md-6">
                            <v-card>
                                <v-img
                                height="400"
                                :src="'/uploads/' + productDetail.item_photo"
                                ></v-img>
                            </v-card>
                        </div>
                        <div class="col">
                            <div class="py-4">
                                <h5>{{ productDetail.item_name }}</h5>
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
                                        | 10 Sold
                                        </div>
                                </v-row>
                                
                                <div class="py-3">
                                    <div class="py-2">
                                        ₱ {{productDetail.item_price}}
                                    </div>
                                    <div class="py-2">
                                        <v-chip color="green darken-1">
                                            {{productDetail.item_status}}
                                        </v-chip>
                                    </div>
                                    <div class="to-bottom">
                                        <div>{{productDetail.item_quantity}} piece available</div>
                                        <div class="wrapper_number_input py-2 d-flex align-items-center">
                                            <v-btn depressed tile @click="dec"><v-icon small>mdi-minus</v-icon></v-btn>
                                            <input type="number" class="numInput" v-model="addToCart.quantity">
                                            <v-btn depressed tile @click="inc"><v-icon small>mdi-plus</v-icon></v-btn>
                                        </div>
                                        <div class="mt-2">
                                            <v-btn v-if="cartStatus" x-large color="blue" disabled><v-icon>mdi-cart-outline</v-icon> Add to cart</v-btn>
                                            <v-btn v-else x-large color="blue" @click="btnAddToCart"><v-icon>mdi-cart-outline</v-icon> Add to cart</v-btn>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="py-4">
                                <h5>Specifications</h5>
                                <div>
                                    <div v-for="spec in specs" :key="spec.id">
                                        <div class="py-1">{{spec.spec}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-container>
            </v-card>
        </v-container>


        <v-snackbar v-model="snackbar">
            {{ message }}
            <template v-slot:action="{ attrs }">
                <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
                Close
                </v-btn>
            </template>
        </v-snackbar>
    </v-app>
</template>
<script>
export default {
    data(){
        return{
            id: this.$route.params.id,
            productStat: false,
            user: {
                id: '',
                name: '',
                email: '',
                address: '',
                contact: '',
            },
            addToCart: {
                item_id: '',
                quantity: 1,
            },
            productDetail: '',
            specs: [],
            cartStatus: false,
            message: '',
            snackbar: false,
        }
    },


    methods: {
        back(){
            this.$router.back()
        },

        getUser(){
            var user = JSON.parse(localStorage.getItem('user'))
            this.user = user
        },

        inc(){
            this.addToCart.quantity = this.addToCart.quantity + 1;
        },

        dec(){
            if(this.addToCart.quantity <= 1){
                this.addToCart.quantity = 1
            }
            else{
                this.addToCart.quantity = this.addToCart.quantity - 1;
            }
        },

        async getProductDetail(){
            this.productStat = true
            await this.$http.get('api/productDetails/' + this.id, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } } )
            .then((res) => {
                this.productDetail = res.data.items[0]
                this.specs = res.data.specs
            })
            .finally(() => this.productStat = false)
        },

        async btnAddToCart(){
            this.addToCart.item_id = this.id
            await this.$http.post('api/addToCart', this.addToCart, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
            .then((res) => {
                this.cartStatus = true
                this.snackbar = true
                this.message = res.data.message
            })
        }
    },

    mounted(){
        this.getUser()
        this.getProductDetail()
    }
}
</script>

<style scoped>

    .to-margin{
        margin-top: 100px;
    }

    .numInput{
        width: 70px;
        background: #121212;
        color: white;
        text-align: center;
        height: 35px;
    }

    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input:focus{
        outline: none;
    }

    .to-bottom{
        margin-top: 80px;
    }

</style>