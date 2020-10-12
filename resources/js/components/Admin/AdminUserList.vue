<template>
    <v-app>
        <div class="d-flex" id="wrapper">
            <sidebar></sidebar>
            <div id="page-content-wrapper">
                <navbar></navbar>
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
                                <v-btn v-if="item.status == 'inactive'" @click="modalIgnite(item)" color="green lighten-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                    <path d="M16 11l2 2l4 -4" />
                                    </svg>
                                </v-btn>
                                <v-btn v-if="item.status == 'active'" @click="modalIgnite(item)" color="red lighten-1">
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
    </v-app>
</template>
<script>
  export default {
    data () {
      return {
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
        users: []
      }
    },
    methods:{
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
        }
    },
    mounted(){
        this.getUsers()
    }
  }
</script>