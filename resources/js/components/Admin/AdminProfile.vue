<template>
    <v-app>
        <div class="d-flex" id="wrapper">
            <sidebar></sidebar>
            <div id="page-content-wrapper">
                <navbar></navbar>
                <div class="container">
                    <h1 class="mt-4">Admin Profile</h1>
                    <div class="row">
                        <div class="col-lg">
                            <v-container>
                                <v-card elevation="2" tile>
                                    <v-card-title class="headline">
                                        User Info
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <div class="text-center py-2">
                                        <v-avatar
                                        color="primary"
                                        size="128"
                                        >
                                        <span class="white--text headline">{{user.default_profile}}</span>
                                        </v-avatar>
                                    </div>
                                    <div class="text-center pb-5 pt-5">
                                        <h3>{{user.name}}</h3>
                                        <span>{{user.usertype}}</span>
                                    </div>
                                    <v-container>
                                        <div class="row text-center py-5">
                                        <div class="col">
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <rect x="3" y="5" width="18" height="14" rx="2" />
                                                    <polyline points="3 7 12 13 21 7" />
                                                </svg>
                                            </div>
                                            <div class="pt-2">
                                                {{user.email}}
                                            </div>
                                        </div>
                                        <div class="col">
                                             <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-map-pin" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="12" cy="11" r="3" />
                                                    <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z" />
                                                </svg>
                                            </div>
                                            <div class="pt-2">
                                                {{user.address}}
                                            </div>
                                        </div>
                                        <div class="col">
                                             <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9E9E9E" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                                </svg>
                                            </div>
                                            <div class="pt-2">
                                                {{user.contact}}
                                            </div>
                                        </div>
                                        </div>
                                    </v-container>
                                </v-card>
                            </v-container>
                        </div>
                        <div class="col-lg">
                            <v-container>
                                <v-card elevation="2" tile>
                                    <v-card-title class="headline">
                                        Edit Information
                                    </v-card-title>
                                    <v-divider></v-divider>
                                    <v-card-text>
                                        Please provide your correct credentials
                                    </v-card-text>
                                    <div class="px-5 pb-3">
                                        <v-text-field
                                        v-model="user.name"
                                        hint="Must be 3 characters and above" 
                                        label="Enter Name"
                                        prepend-icon="mdi-account"
                                        :rules="[rules.required, rules.min_name]"
                                        >
                                        </v-text-field>
                                        <v-text-field
                                        v-model="user.address"
                                        prepend-icon="mdi-map-marker"
                                        label="Enter current address"
                                        :rules="[rules.required]"
                                        >
                                        </v-text-field>
                                        <v-text-field
                                        v-model="user.contact"
                                        hint="Must contain 11 digit contact number" 
                                        label="Enter contact number"
                                        type="number"
                                        :rules="[rules.required]"
                                        prepend-icon="mdi-phone"
                                        >
                                        </v-text-field>
                                    </div>
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-btn
                                            color="blue"
                                            text
                                            @click="save"
                                            class="text-right"
                                        >
                                            Save
                                        </v-btn>
                                    </v-card-actions>
                                </v-card>
                            </v-container>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <v-snackbar
        v-model="snackbar"
        :multi-line="multiLine"
        >
        {{ message }}

        <template v-slot:action="{ attrs }">
            <v-btn
            color="red"
            text
            v-bind="attrs"
            @click="snackbar = false"
            >
            Close
            </v-btn>
        </template>
        </v-snackbar>  
    </v-app>
</template>
<script>
export default {
    data: () => ({
        multiLine: true,
        snackbar: false,
        message: '',
        form: {
            name: '',
            address: '',
            contact: '',
        },
        user: {
            default_profile: '',
            name: '',
            email: '',
            address: '',
            usertype: '',
            contact: '',
        },
        form: {
            name: '',
            address: '',
            contact: '',
        },
        rules: {
            required: value => !!value || 'Required.',
            min_name: v => v.length >=3 || 'Min 3 characters',
            min: v => v.length >= 6 || 'Min 6 characters',
        },
    }),
    methods:{
        async save(){
            await this.$http.put('api/updateMe', this.user, { headers : { Authorization: 'Bearer ' + this.$auth.getToken()}})
            .then((res) => {
                localStorage.removeItem('user')
                localStorage.setItem("user", JSON.stringify(res.body.data))
                this.getUser()
                this.snackbar = true
                this.message = res.body.message
            })
            .catch((err) => {
                console.error(err)
            })
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
        }
    },
    mounted(){
        this.getUser()
    }
}
</script>