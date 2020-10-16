<template>
    <v-app>
        <div class="d-flex page" id="wrapper">
            <sidebar v-bind:user="user"></sidebar>
            <div id="page-content-wrapper">
                <navbar v-bind:user="user"></navbar>
                <div class="container">
                    <h1>Admin Dashboard</h1>
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <router-link to="/admin_store_list">
                                        <div class="container smol-cards">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-building-store" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FF5722" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <line x1="3" y1="21" x2="21" y2="21" />
                                                    <path d="M3 7v1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1m0 1a3 3 0 0 0 6 0v-1h-18l2 -4h14l2 4" />
                                                    <line x1="5" y1="21" x2="5" y2="10.85" />
                                                    <line x1="19" y1="21" x2="19" y2="10.85" />
                                                    <path d="M9 21v-4a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v4" />
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <div class="num-header">40</div>
                                                        <div class="sub-header">Shops</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                                <div class="col">
                                    <router-link to="/admin_user_list">
                                        <div class="container smol-cards">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3F51B5" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="9" cy="7" r="4" />
                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <div class="num-header">100</div>
                                                        <div class="sub-header">Users</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <router-link to="/admin_user_list">
                                        <div class="container smol-cards">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="9" cy="7" r="4" />
                                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                    <path d="M16 11l2 2l4 -4" />
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <div class="num-header">50</div>
                                                        <div class="sub-header">Trusted Sellers</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                                <div class="col">
                                    <router-link to="/admin_transaction_logs">
                                        <div class="container smol-cards">
                                            <div class="row">
                                                <div class="col-4 d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-refresh" width="60" height="60" viewBox="0 0 24 24" stroke-width="1.5" stroke="#009688" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" />
                                                    </svg>
                                                </div>
                                                <div class="col">
                                                    <div>
                                                        <div class="num-header">1,208</div>
                                                        <div class="sub-header">Transactions</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="adminNotifCard">
                                <div class="container">
                                    <div class="header-notif pl-2">
                                        Activity Logs
                                    </div>
                                    <div class="body-notif">
                                        <div class="notif-content p-3">
                                            <span>Lorem ipsum dolor sit amet</span>
                                        </div>
                                        <div class="notif-content p-3">
                                            <span>Lorem ipsum dolor sit amet</span>
                                        </div>
                                        <div class="notif-content p-3">
                                            <span>Lorem ipsum dolor sit amet</span>
                                        </div>
                                        <div class="notif-content p-3">
                                            <span>Lorem ipsum dolor sit amet</span>
                                        </div>
                                        <div class="notif-content p-3">
                                            <span>Lorem ipsum dolor sit amet</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
    </v-app>
</template>
<script>
export default {
    data: () => ({
        user: {
            default_profile: '',
            name: '',
            email: '',
            address: '',
            usertype: '',
            contact: '',
        }
    }),
    methods:{
        getUser(){
            var user = JSON.parse(localStorage.getItem('user'))
            this.user = user

            var name = user.name

            var getInitials = function (name) {
            var parts = name.split(' ')
            var initials = ''
            for (var i = 0; i < parts.length; i++) {
                if (parts[i].length > 0 && parts[i] !== '') {
                    initials += parts[i][0]
                }
            }
                return initials
            }

            this.user.default_profile = getInitials(name);
        },
    },
    mounted(){
        this.getUser()
    }
}
</script>
<style>
.adminNotifCard{
    border-radius: 20px;
    background-color: dodgerblue;
}
.header-notif{
    font-size: 30px;
    font-weight: bold;
    color: white;
}
.body-notif{
    padding: 20px 0px;
    font-weight: lighter;
}
.notif-content{
    color: white;
    border-bottom: 1px solid #81A1FF;
}
.num-header{
    font-size: 30px;
    font-weight: bold;
}
.sub-header{
    font-weight: lighter;
}
.smol-cards{
    border-radius: 30px;
    color: #aaaaaa;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    transition: 0.5s;
    cursor: pointer;
}
.smol-cards:hover{
    transition: 0.5s;
    background-color: dodgerblue;
    color: white;
}
</style>