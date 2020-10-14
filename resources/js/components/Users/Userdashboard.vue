<template>
    <v-app>
        <usernav v-bind:user="user"></usernav>
        <v-container class="card-notifier">
            <!-- <v-alert
                v-if="toShow == ''"
                close-text="Close Alert"
                color="info"
                text
                dismissible
                >
                    Want to start business with us? <br>
                    become one of our business partners!
                    <br><br>
                    What are you waiting for? Register your store now!
                    <br>
                    <br>
                    <router-link to="/store_registration" tag="v-btn">Register</router-link>
                </v-alert> -->

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