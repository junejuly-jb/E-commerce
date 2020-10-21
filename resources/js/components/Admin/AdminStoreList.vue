<template>
    <v-app>
        <div class="d-flex" id="wrapper">
            <sidebar v-bind:user="user"></sidebar>
            <div id="page-content-wrapper">
                <navbar v-bind:user="user"></navbar>
                <v-container>
                    <h1 class="mt-4">Stores List</h1>
                    <v-card>
                        <v-card-title>
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                        </v-card-title>
                        <div v-if="loadStores == true" class="container">
                            <div class="py-5 text-center">
                                <div class="py-5">Fetching Stores...</div>
                                <v-progress-linear
                                    color="deep-purple accent-4"
                                    indeterminate
                                    rounded
                                    height="6"
                                ></v-progress-linear>
                            </div>
                        </div>
                        <v-data-table
                        v-else
                        :headers="headers"
                        :items="stores"
                        :search="search"
                        ></v-data-table>
                    </v-card>
                </v-container>
            </div>
        </div>
    </v-app>
</template>
<script>
export default {
    data(){
        return{
            user: {
                default_profile: '',
                name: '',
                email: '',
                address: '',
                usertype: '',
                contact: '',
            },
            search: '',
            headers: [
            {
                text: 'Store ID',
                align: 'start',
                value: 'store_id',
            },
            { text: 'Store Name', value: 'store_name' },
            { text: 'Owner', value: 'name' },
            { text: 'Store Address', value: 'store_address' },
            { text: 'Website', value: 'store_website' },
            { text: 'Status', value: 'store_status' },
            { text: 'Actions', value: 'actions' },
            ],
            stores: [],
            loadStores: false,
        }
    },
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
        async getActiveStores(){
            this.loadStores = true
            await this.$http.get('api/getActiveStores', {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.stores = res.data.data
                console.log(this.stores)
            })
            .finally(() => { this.loadStores = false})
        }
    },
    mounted(){
        this.getUser()
        this.getActiveStores()
    }
}
</script>