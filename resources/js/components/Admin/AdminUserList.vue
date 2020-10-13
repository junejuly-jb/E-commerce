<template>
    <v-app>
        <div class="d-flex" id="wrapper">
            <sidebar v-bind:user="user"></sidebar>
            <div id="page-content-wrapper">
                <navbar v-bind:user="user"></navbar>
                <v-container>
                    <h1 class="mt-4">Users List</h1>
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
                        <v-data-table
                        :headers="headers"
                        :items="users"
                        :search="search"
                        >
                            <template v-slot:[`item.actions`]="{ item }">
                                <v-btn v-if="item.status == 'inactive'" @click="activate(item)" color="green lighten-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 11l2 2l4 -4" />
                                    </svg>
                                </v-btn>
                                <v-btn v-if="item.status == 'active'" @click="deactivate(item)" color="red lighten-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M14.274 10.291a4 4 0 1 0 -5.554 -5.58m-.548 3.453a4.01 4.01 0 0 0 2.62 2.65" />
                                    <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 1.147 .167m2.685 2.681a4 4 0 0 1 .168 1.152v2" />
                                    <line x1="3" y1="3" x2="21" y2="21" />
                                    </svg>
                                </v-btn>
                            </template>

                            <template v-slot:[`item.status`]="{ item }">
                            <v-chip
                                :color="getColor(item.status)"
                                dark
                            >
                                {{ item.status }}
                            </v-chip>
                            </template>
                        </v-data-table>
                    </v-card>
                </v-container>
            </div>
        </div>
        
        <!-- disable dialog  -->
        <v-dialog
        v-model="disableDialog"
        persistent
        max-width="290"
        >
            <v-card>
                <v-card-title class="headline">
                Disable
                </v-card-title>
                <v-card-text>Do you want to disable this user?</v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    @click="disableDialog = false"
                >
                    Cancel
                </v-btn>
                <v-btn
                    color="info"
                    text
                    @click="confirmDeactivate"
                >
                    Agree
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog> 
        <!-- end disable dialog  -->

        <!-- enable dialog  -->
        <v-dialog
        v-model="enableDialog"
        persistent
        max-width="290"
        >
            <v-card>
                <v-card-title class="headline">
                Disable
                </v-card-title>
                <v-card-text>Do you want to <span class="text-success">activate</span> this user?</v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text
                    @click="enableDialog = false"
                >
                    Cancel
                </v-btn>
                <v-btn
                    color="info"
                    text
                    @click="confirmActivate"
                >
                    Agree
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog> 
        <!-- end enable dialog  -->

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
    data () {
      return {
        enableDialog: false,
        snackbar: false,
        message: '',
        multiLine: true,
        disableDialog: false,
        editedIndex: -1,
        search: '',
        headers: [
          {
            text: 'ID Number',
            align: 'start',
            value: 'id',
          },
          { text: 'Name', value: 'name' },
          { text: 'Email', value: 'email' },
          { text: 'Contact', value: 'contact' },
          { text: 'Address', value: 'address' },
          { text: 'Usertype', value: 'usertype' },
          { text: 'Status', value: 'status' },
          { text: 'Actions', value: 'actions' },
        ],
        users: [],
        userStat: {
            id: '',
            status: ''
        },
        user: {
            default_profile: '',
            name: '',
            email: '',
            address: '',
            usertype: '',
            contact: '',
        }
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
        async getUsers(){
            await this.$http.get('api/getAllUsers', { headers: { Authorization: 'Bearer ' + this.$auth.getToken()}})
            .then((res) => {
                this.users = res.body
            })
            .catch((err) => {
                console.error(err)
            })
        },
        getColor(status){
            if(status == 'active') return 'green'
            else return 'red'
        },
        deactivate(item){
            this.disableDialog = true
            this.editedIndex = this.users.indexOf(item)
            this.userStat.id = item.id
            this.userStat.status = 'inactive'
            console.log(this.userStat)
        },
        async confirmDeactivate(){
            await this.$http.put('api/deactivateUser/' + this.userStat.id,  this.userStat, { headers: { Authorization: 'Bearer ' + this.$auth.getToken()}})
            .then((res) => {
                this.disableDialog = false
                this.snackbar = true,
                this.message = res.body.message
                Object.assign(this.users[this.editedIndex], this.userStat)
            })
        },
        activate(item){
            this.enableDialog = true
            this.editedIndex = this.users.indexOf(item)
            this.userStat.id = item.id;
            this.userStat.status = 'active';
        },
        async confirmActivate(){
            await this.$http.put('api/activateUser/' + this.userStat.id, this.userStat, 
                { 
                    headers: {
                        Authorization: 'Bearer ' + this.$auth.getToken()
                    }
                })
            .then((res) => {
                this.enableDialog = false;
                this.snackbar = true
                this.message = res.body.message
                Object.assign(this.users[this.editedIndex], this.userStat)
            })
        }
    },
    mounted(){
        this.getUsers()
        this.getUser()
    }
  }
</script>