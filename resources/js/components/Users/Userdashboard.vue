<template>
    <v-app>
        <usernav v-bind:user="user"></usernav>
        <v-container class="card-notifier">
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
        </v-container>
    </v-app>
</template>
<script>
export default {
    data: () => ({
        user: {
            id: '',
            name: '',
            email: '',
            address: '',
            contact: '',
        },
        toShow: ''
    }),
    created(){
        this.$http.get('api/profile', { headers: { Authorization: 'Bearer ' + this.$auth.getToken()}})
        .then((res) => {
            // console.log(res.body)
            if(res.body['status'] == 'inactive'){
                this.$auth.destroyToken()
                this.$router.push('/login')
            }
            else if(res.body['usertype'] == 'seller'){
                this.$auth.destroyToken()
                this.$router.push('/login')
            }
        })

        bus.$on('updated', (data) => {
            console.log(data)
        })
    },
    methods: {
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