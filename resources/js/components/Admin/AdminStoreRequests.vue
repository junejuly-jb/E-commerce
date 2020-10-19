<template>
    <v-app>
        <div class="d-flex" id="wrapper">
            <sidebar v-bind:user="user"></sidebar>
            <div id="page-content-wrapper">
                <navbar v-bind:user="user"></navbar>
                <v-container>
                    <h1 class="mt-4">Store Requests</h1>
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
                        <v-btn
                        class="ma-2"
                        :loading="loading4"
                        :disabled="loading4"
                        color="info"
                        @click="loader = 'loading4'"
                        >
                        Refresh
                        <template v-slot:loader>
                            <span class="custom-loader">
                            <v-icon light>mdi-cached</v-icon>
                            </span>
                        </template>
                        </v-btn>
                        <v-data-table
                        :headers="headers"
                        :items="stores"
                        :search="search"
                        >
                        
                            <template v-slot:[`item.actions`]="{ item }">
                                <v-btn color="info" @click="showRequest(item)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="12" cy="12" r="2" />
                                    <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                    </svg>
                                </v-btn>
                            </template>

                        </v-data-table>
                    </v-card>
                </v-container>
            </div>
        </div>
        
       <!-- dialog  -->
       <v-dialog
        v-model="dialog"
        persistent
        max-width="450"
        >
        <v-card
            class="mx-auto"
            max-width="450"
        >
            <v-card-title>
                <v-icon>mdi-store</v-icon><span class="pl-3"> Store Details</span>
            </v-card-title>

            <v-container>
                <div class="py-1">
                    <v-icon>mdi-storefront</v-icon> <span class="pl-2">{{toShowInfo.store_name}}</span>
                </div>
                <div class="py-1">
                    <v-icon>mdi-map-marker-outline</v-icon> <span class="pl-2">{{toShowInfo.store_address}}</span>
                </div>
                <div class="py-1">
                    <v-icon>mdi-web</v-icon> <span class="pl-2">{{toShowInfo.store_website}}</span>
                </div>
                <div class="py-1">
                    <v-icon color="red">mdi-alert-box-outline</v-icon> <span class="pl-2 text-danger">{{toShowInfo.store_status}}</span>
                </div>
                <div class="py-1">
                    <v-icon>mdi-comment-quote-outline</v-icon> <span class="pl-2 text-center">" {{toShowInfo.store_description}} "</span>
                </div>
            </v-container>

            <v-card-actions>
           


            <v-btn
                text
                @click="show = !show"
            >
                <v-icon>{{ show ? 'mdi-chevron-up' : 'mdi-chevron-down' }}</v-icon>Show User Profile
            </v-btn>
                <v-spacer></v-spacer>
            <v-btn
                color="gray"
                text
                @click="dialog = false"
                >
                Close
            </v-btn>
             <v-btn
                color="orange lighten-2"
                text
                @click="grant"
            >
                Grant
            </v-btn>
            </v-card-actions>

            <v-expand-transition>
            <div v-show="show">
                <v-divider></v-divider>

                <div class="container">
                    <div class="row">
                        <div class="col text-center d-flex justify-content-center align-items-center">
                            <v-avatar
                            color="primary"
                            size="120"
                            ><span class="headline text-white">{{sellerDefaultPP}}</span></v-avatar>
                        </div>
                        <div class="col">
                            <div class="py-1">
                                <span><v-icon>mdi-account-circle-outline</v-icon></span><span class="pl-2">{{toShowInfo.name}}</span>
                            </div>
                            <div class="py-1">
                                <span><v-icon>mdi-map-marker-outline</v-icon></span><span class="pl-2">{{toShowInfo.address}}</span>
                            </div>
                            <div class="py-1">
                                <span><v-icon>mdi-phone-outline</v-icon></span><span class="pl-2">{{toShowInfo.contact}}</span>
                            </div>
                            <div class="py-1">
                                <span><v-icon>mdi-gender-male-female</v-icon></span><span class="pl-2">{{toShowInfo.gender}}</span>
                            </div>
                            <div class="py-1">
                                <span><v-icon>mdi-cake</v-icon></span><span class="pl-2">{{toShowInfo.birthday}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </v-expand-transition>
        </v-card>
        </v-dialog>

        <!-- snackbar  -->
        <v-snackbar
        v-model="snackbar"
        >
        {{ message }}

        <template v-slot:action="{ attrs }">
            <v-btn
            color="pink"
            text
            v-bind="attrs"
            @click="snackbar = false"
            >
            Close
            </v-btn>
        </template>
        </v-snackbar>
        <!-- snackbar  -->

    </v-app>
</template>
<script>
export default {
    data: () => ({
        loader: null,
        loading4: false,
        message: '',
        snackbar: false,
        dialog: false,
        show: false,
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
            value: 'id',
          },
          { text: 'Store', value: 'store_name' },
          { text: 'Owner', value: 'name' },
          { text: 'Store Address', value: 'store_address' },
          { text: 'Website', value: 'store_website' },
          { text: 'Status', value: 'store_status' },
          { text: 'Actions', value: 'actions' },
        ],
        stores: [],
        toShowInfo: '',
        sellerDefaultPP: '',
        toUpdate: '',
        editedIndex: -1
    }),
    methods:{
        async getAllStores(){
            await this.$http.get('api/getAllStores', {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                console.log(res.body.data)
                this.stores = res.body.data
            })
        },
        showRequest(item){
            this.dialog = true
            this.toShowInfo = item
            this.toUpdate = item
            this.editedIndex = this.stores.indexOf(item)
            var name = item.name
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

            this.sellerDefaultPP = getInitials(name);
        },
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
        async grant(){
            await this.$http.post('api/grant', this.toUpdate, {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.dialog = false
                this.snackbar = true
                this.message = res.body.message
                this.stores.splice(this.editedIndex, 1)
            })
        }
    },
    mounted(){
        this.getUser()
        this.getAllStores()
    },
    watch: {
        loader () {
        this.getAllStores()
        const l = this.loader
        this[l] = !this[l]
        setTimeout(() => (this[l] = false), 3000)
        this.loader = null
        },
    },
}
</script>
<style>
  .custom-loader {
    animation: loader 1s infinite;
    display: flex;
  }
  @-moz-keyframes loader {
    from {
      transform: rotate(360deg);
    }
    to {
      transform: rotate(0);
    }
  }
  @-webkit-keyframes loader {
    from {
      transform: rotate(360deg);
    }
    to {
      transform: rotate(0);
    }
  }
  @-o-keyframes loader {
    from {
      transform: rotate(360deg);
    }
    to {
      transform: rotate(0);
    }
  }
  @keyframes loader {
    from {
      transform: rotate(360deg);
    }
    to {
      transform: rotate(0);
    }
  }
</style>