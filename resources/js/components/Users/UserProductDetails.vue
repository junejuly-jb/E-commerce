<template>
    <v-app>
        <usernav v-bind:user="user"></usernav>
        <v-container>
            <div class="to-margin">

            </div>
            <div class="dashHeader">
                <span class="discover">Product </span><span class="daily">details</span>
            </div>
            <v-card>
                <v-container>
                    <div class="row">
                        <div class="col-md-6">
                            <v-card>
                                <v-img
                                height="400"
                                src="https://cdn.vuetifyjs.com/images/cards/cooking.png"
                                ></v-img>
                            </v-card>
                        </div>
                        <div class="col">
                            <div class="py-4">
                                <h5>Product Name</h5>
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
                                        ₱ 1299
                                    </div>
                                    <div class="py-2">
                                        <v-chip color="green darken-1">
                                            available
                                        </v-chip>
                                    </div>
                                    <div class="to-bottom">
                                        <div>10 piece available</div>
                                        <div class="wrapper_number_input py-2 d-flex align-items-center">
                                            <v-btn depressed tile><v-icon small>mdi-minus</v-icon></v-btn>
                                            <input type="number" class="numInput" v-model="quantity">
                                            <v-btn depressed tile><v-icon small>mdi-plus</v-icon></v-btn>
                                        </div>
                                        <div class="mt-2">
                                            <v-btn x-large color="blue"><v-icon>mdi-cart-outline</v-icon> Add to cart</v-btn>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="py-4">
                                <h5>Specifications</h5>
                                <div>
                                    <ul>
                                        <li>asd</li>
                                        <li>as</li>
                                        <li>asd</li>
                                        <li>asd</li>
                                        <li>asd</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </v-container>
            </v-card>
            <v-card class="mt-3">
                <v-container>
                    asd
                </v-container>
            </v-card>
        </v-container>
    </v-app>
</template>
<script>
export default {
    data(){
        return{
            id: this.$route.params.id,
            user: {
                id: '',
                name: '',
                email: '',
                address: '',
                contact: '',
            },
            quantity: '1'
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
    },

    mounted(){
        this.getUser()
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