<template>
    <v-app>
        <div class="d-flex page" id="wrapper">
            <sidebar v-bind:user="user"></sidebar>
            <div id="page-content-wrapper">
                <navbar v-bind:user="user"></navbar>
                <div class="container">
                    <div class="dashHeader">
                        <span class="discover">Admin</span><span class="daily"> Dashboard</span>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <router-link to="/admin_store_list">
                                        <div class="container smol-cards dark-accent">
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
                                                        <div class="num-header">{{totalStores}}</div>
                                                        <div class="sub-header">Shops</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                                <div class="col">
                                    <router-link to="/admin_user_list">
                                        <div class="container smol-cards dark-accent">
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
                                                        <div class="num-header">{{totalUsers}}</div>
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
                                        <div class="container smol-cards dark-accent">
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
                                                        <div class="num-header">{{totalSellers}}</div>
                                                        <div class="sub-header">Trusted Sellers</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                                <div class="col">
                                    <router-link to="/admin_transaction_logs">
                                        <div class="container smol-cards dark-accent">
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
                                                        <div class="num-header">
                                                           1000
                                                        </div>
                                                        <div class="sub-header">Transactions</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </router-link>
                                </div>
                            </div>
                            <div>
                                <v-container class="card-todo dark-accent mt-3">
                                    <div class="row">
                                        <div class="col">
                                            <div class="d-flex align-items-center h-100">
                                                <div class="header-todo">Todo List</div>
                                            </div>
                                        </div>
                                        <div class="col text-right">
                                            <v-btn
                                                fab
                                                small
                                                @click="getTodos"
                                                color="blue lighten-1"
                                                >
                                                <span v-if="refreshTodo == true">
                                                    <v-progress-circular
                                                    :width="3"
                                                    color="white"
                                                    indeterminate
                                                    ></v-progress-circular>
                                                </span>
                                                <v-icon v-else color="white">
                                                    mdi-refresh
                                                </v-icon>
                                            </v-btn>
                                            <v-btn
                                                fab
                                                small
                                                @click="addButton"
                                                color="blue lighten-1"
                                                >
                                                <v-icon color="white">
                                                    mdi-plus
                                                </v-icon>
                                            </v-btn>
                                        </div>
                                    </div>
                                    <div v-if="loadTodo == true" class="py-5 text-center">
                                        <div class="py-5">Fetching your Todo's</div>
                                        <v-progress-linear
                                            color="deep-purple accent-4"
                                            indeterminate
                                            rounded
                                            height="6"
                                        ></v-progress-linear>
                                    </div>
                                    <div v-else class="py-2">
                                        <div class="py-2"></div>
                                        <div class="py-1" v-for="todos in mytodo">
                                            <template v-if="todos.status == 'incomplete'">
                                                <span @click="mark(todos)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2196F3" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="12" cy="12" r="9" />
                                                    </svg>
                                                </span>
                                                <span class="pl-2">{{todos.todo}}</span>
                                            </template>
                                            <template v-else>
                                                <span v-if="todos.status == 'complete'" @click="mark(todos)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-circle-check" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFC107" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <circle cx="12" cy="12" r="9" />
                                                    <path d="M9 12l2 2l4 -4" />
                                                    </svg>
                                                </span>
                                                <del v-if="todos.status == 'complete'" class="pl-2">{{todos.todo}}</del>
                                            </template>
                                            <div class="float-right">
                                                <span class="mx-2">
                                                    <svg @click="editButton(todos)" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-pencil" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#8BC34A" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
                                                    <line x1="13.5" y1="6.5" x2="17.5" y2="10.5" />
                                                    </svg>
                                                </span>
                                                <span class="mx-2">
                                                    <svg @click="deleteButton(todos)" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#F44336" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <line x1="4" y1="7" x2="20" y2="7" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />
                                                    <line x1="14" y1="11" x2="14" y2="17" />
                                                    <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                    <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <!-- <v-btn icon color="red lighten-3" @click="deleteButton">
                                                <v-icon>mdi-trash-can-outline</v-icon>
                                            </v-btn>
                                            <v-btn icon color="teal lighten-3" @click="editButton">
                                                <v-icon>mdi-pencil-outline</v-icon>
                                            </v-btn> -->
                                        </div>
                                    </div>
                                </v-container>
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

        <!-- add dialog  -->
        <v-dialog
        v-model="dialog"
        persistent
        max-width="350"
        >
        <v-card>
            <v-card-title class="headline">
                <span v-if="edit_mode == 'add'"> Todo </span>
                <span v-else-if="edit_mode == 'delete'"> Delete </span>
                <span v-else> Edit Todo </span>
            </v-card-title>
            <v-container>
                <v-text-field
                    v-if="edit_mode == 'add'"
                    v-model="form.todo"
                    label="Add todo"
                >
                </v-text-field>
                <v-card-text v-else-if="edit_mode == 'delete'">
                    Do you want to delete this Todo?
                </v-card-text>
                <v-text-field
                    v-else
                    v-model="form.todo"
                    label="Edit Todo"
                >
                </v-text-field>
            </v-container>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                text
                @click="dialog = false"
            >
                Cancel
            </v-btn>
            <v-btn
                v-if="edit_mode == 'add'"
                color="green darken-1"
                text
                @click="confirmAdd"
            >
                Save
            </v-btn>
            <v-btn
                v-else-if="edit_mode == 'delete'"
                color="red darken-3"
                text
                @click="confirmDelete"
            >
                Delete
            </v-btn>
            <v-btn
                v-else
                color="blue lighten-3"
                text
                @click="confirmUpdate"
            >
                Update
            </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
        <!-- snackbar  -->
            <div class="text-center">
                <v-snackbar
                v-model="snackbar"
                >
                {{ message }}

                <template v-slot:action="{ attrs }">
                    <v-btn
                    color="blue"
                    text
                    v-bind="attrs"
                    @click="snackbar = false"
                    >
                    Close
                    </v-btn>
                </template>
                </v-snackbar>
            </div>
        <!-- end snackbar -->
    </v-app>
</template>
<script>
export default {
    data: () => ({
        refreshTodo: false,
        loadTodo: false,
        snackbar: false,
        message: '',
        user: {
            default_profile: '',
            name: '',
            email: '',
            address: '',
            usertype: '',
            contact: '',
        },
        form: {
            todo: ''
        },
        mytodo: [],
        savedTodo: {
            todo: ''
        },
        editedTodo: {
            id: '',
            todo: ''
        },
        totalStores: '',
        totalUsers: '',
        totalSellers: '',
        dialog: false,
        edit_mode: '',
        selectedIndex: -1,
        selectedTodo: {
            id: '',
            todo: ''
        }
    }),
    methods:{
        async mark(todos){
            // console.log(todos.status)
            this.selectedIndex = this.mytodo.indexOf(todos)
            await this.$http.put('api/mark/' + todos.todo_id, todos, {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.snackbar = true
                this.message = res.data.message
                Object.assign(this.mytodo[this.selectedIndex], res.data.data)
            })
        },
        async getTodos(){
            this.refreshTodo = true
            this.loadTodo = true
            await this.$http.get('api/getTodos', {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.mytodo = res.body.data
            })
            .catch((err) => {
                console.err(err)
            })
            .finally(() => { 
                this.loadTodo = false
                this.refreshTodo = false
            })
        },
        addButton(){
            this.form.todo = ''
            this.edit_mode = 'add'
            this.dialog = true
        },
        async confirmAdd(){
            this.savedTodo.todo = this.form.todo;
            await this.$http.post('api/addTodo', this.savedTodo, {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.dialog = false
                this.snackbar = true
                this.message = res.body.message
                this.mytodo.push(res.data.data)
                console.log(res.data.data)
            })
        },
        editButton(todos){
            this.edit_mode = 'edit'
            this.dialog = true
            this.editedTodo.id = todos.todo_id
            this.selectedIndex = this.mytodo.indexOf(todos)
            this.form.todo = todos.todo
            // console.log(this.selectedIndex)
        },
        async confirmUpdate(){
            this.editedTodo.todo = this.form.todo
            await this.$http.put('api/updateTodo/' + this.editedTodo.id, this.editedTodo, {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.snackbar = true
                this.message = res.data.message
                Object.assign(this.mytodo[this.selectedIndex], res.data.data)
                this.dialog = false
            })
            console.log(this.editedTodo)
        },
        deleteButton(todos){
            this.edit_mode = 'delete'
            this.dialog = true
            this.selectedIndex = this.mytodo.indexOf(todos)
            this.selectedTodo.id = todos.todo_id
            // console.log(todos.todo_id)
        },
        async confirmDelete(){
            await this.$http.delete('api/deleteTodo/' + this.selectedTodo.id, {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.mytodo.splice(this.selectedIndex, 1)
                this.snackbar = true
                this.message = res.data.message
                this.dialog = false
            })
        },
        saveTodo(){
            console.log('clicked!')
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
        async getTotal(){
            await this.$http.get('api/getTotal', {
                headers: {
                    Authorization: 'Bearer ' + this.$auth.getToken()
                }
            })
            .then((res) => {
                this.totalUsers = res.body.users
                this.totalStores = res.body.stores
                this.totalSellers = res.body.sellers
            })
            .catch((err) => {
                console.err(err)
            })
        },
        default(){
            this.selectedTodo = ''
            this.selectedIndex = ''
        }
    },
    mounted(){
        this.getUser()
        this.getTotal()
        this.getTodos()
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
.header-todo{
    font-size: 30px;
    font-weight: bold;

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
.card-todo{
    padding: 10px 30px !important;
    border-radius: 20px;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
}
</style>