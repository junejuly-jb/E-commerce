<template>
    <nav class="navbar navbar-expand-md fixed-top navbar-dark dark-mode shadow-sm" id="nav">
        <div class="container">
            <div class="navbar-brand">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2196F3" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <circle cx="9" cy="19" r="2" />
                        <circle cx="17" cy="19" r="2" />
                        <path d="M3 3h2l2 12a3 3 0 0 0 3 2h7a3 3 0 0 0 3 -2l1 -7h-15.2" />
                    </svg>
                </span>
            </div>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
                data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse bg" id="mainNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <router-link class="nav-link mr-3 py-4 px-3" to="/login">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-3 py-4 px-3" href="#safety_and_security">Cart</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mr-3 py-4 px-3" href="#faq">Notifications</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle pt-4" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{user.name}}
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">My Profile</a>
                            <router-link class="dropdown-item" to="/store_registration">Store Registration</router-link>
                            <a class="dropdown-item" href="#">Change Password</a>
                            <div class="dropdown-divider"></div>
                            <v-btn @click="logout" color="red darken-1" text class="dropdown-item">Logout</v-btn>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
export default {
    props: ['user'],
    return(){

    },
    methods:{
        logout(){
            this.$auth.destroyToken()
            this.$router.push('/login')
        }
    }
}
</script>