<template>
    <v-app>
        <div class="d-flex page" id="wrapper">
            <sellersidebar v-bind:user="user"></sellersidebar>
            <div id="page-content-wrapper">
                <sellernav v-bind:user="user"></sellernav>
                <div class="container">
                    <div class="dashHeader">
                        <span class="discover">Inventory</span><span class="daily"> Details</span>
                    </div>
                    <v-card>
                        <v-card-title>
                        <v-text-field
                            v-model="search"
                            append-icon="mdi-magnify"
                            label="Search"
                            single-line
                            hide-details
                        ></v-text-field>
                        <v-btn
                        class="mx-4"
                        @click="btnAddItem"
                        small
                        fab
                        color="blue darken-1"
                        >
                            <v-icon>
                                mdi-plus
                            </v-icon>
                        </v-btn>
                        </v-card-title>
                        <v-data-table
                        :headers="headers"
                        :items="inventoryItems"
                        :search="search"
                        >
                            <template v-slot:[`item.actions`]="{ item }">
                                <v-btn icon color="blue lighten-2" @click="btnShow(item)">
                                    <v-icon>mdi-eye-outline</v-icon>
                                </v-btn>
                                <v-btn icon color="green lighten-2" @click="btnEdit(item)">
                                    <v-icon>mdi-pencil-outline</v-icon>
                                </v-btn>
                                <v-btn icon color="red lighten-2" @click="btnDelete(item)">
                                    <v-icon>mdi-trash-can-outline</v-icon>
                                </v-btn>
                            </template>
                        </v-data-table>
                    </v-card>
                </div>
            </div>
        </div>

        <!-- dialog -->
        <v-dialog
        v-model="dialog"
        persistent
        max-width="600"
        >
        <v-card>
            <v-card-title class="headline" v-if="editmode == 'add'">
                <span class="text-primary">
                    Add item
                </span>
            </v-card-title>
            <v-card-title class="headline" v-else-if="editmode == 'delete'">
                <span class="text-danger">
                    Delete
                </span>
            </v-card-title>
            <v-card-title class="headline" v-else-if="editmode == 'show'">
                Item Details
            </v-card-title>
            <v-card-title class="headline" v-else>
                Edit
            </v-card-title>
            <v-container v-if="editmode == 'add'">
                <v-form v-model="valid">
                    <v-row>
                        <v-col>
                            <v-text-field
                            :rules="[rules.required]"
                            v-model="addForm.item_name"
                            prepend-icon="mdi-dropbox"
                            label="Item name"
                            ></v-text-field>
                        </v-col>
                        <v-col>
                            <v-autocomplete
                                :rules="[rules.required]"
                                v-model="addForm.category"
                                :items="categories"
                                label="Product Category"
                                placeholder="Select..."
                                prepend-icon="mdi-format-list-bulleted"
                            ></v-autocomplete>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                            :rules="[rules.required]"
                            v-model="addForm.item_price"
                            prepend-icon="mdi-currency-php"
                            label="Price"
                            suffix=".00"
                            type="number"
                            ></v-text-field>
                        </v-col>
                        <v-col>
                            <v-text-field
                            :rules="[rules.required, rules.notNull]"
                            v-model="addForm.item_quantity"
                            prepend-icon="mdi-file-table-box"
                            label="Quantity"
                            type="number"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-textarea
                    :rules="[rules.required]"
                    v-model="addForm.item_desc"
                    label="Description"
                    prepend-icon="mdi-comment-quote-outline"
                    ></v-textarea>
                </v-form>
            </v-container>
            <v-container v-else-if="editmode == 'delete'">
                <v-card-text>
                    do you want to delete this item?
                </v-card-text>
            </v-container>
            <v-container v-else-if="editmode == 'show'">
                <v-card-text>
                    Show
                </v-card-text>
            </v-container>
            <v-container v-else>
                <v-row>
                    <v-col>
                        <v-text-field></v-text-field>
                    </v-col>
                    <v-col>
                        <v-text-field></v-text-field>
                    </v-col>
                </v-row>
            </v-container>
            <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                text
                @click="dialog = false"
            >
                Cancel
            </v-btn>
            <v-btn v-if="editmode == 'add'"
                color="green darken-1"
                text
                @click="saveItem"
            >
                Save
            </v-btn>
            <v-btn v-else-if="editmode == 'delete'"
                color="red darken-1"
                text
                @click="dialog = false"
            >
                Delete
            </v-btn>
            <v-btn v-else-if="editmode == 'edit'"
                color="green darken-1"
                text
                @click="dialog = false"
            >
                Update
            </v-btn>
            <v-btn v-else
                color="green darken-1"
                text
                @click="dialog = false"
            >
                Okay
            </v-btn>
            </v-card-actions>
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
    </v-app>
</template>
<script>
export default {
    data: () => ({
        valid: false,
        menu: false,
        editmode: '',
        search: '',
        dialog: false,
        categories: ['Motherboards','Mouse', 'Keyboards', 'Monitor', 'RAM', 'HDD', 'SSD'],
        user: {
            default_profile: '',
            name: '',
            email: '',
            address: '',
            usertype: '',
            contact: '',
        },
        headers: [
          {
            text: 'Item (ID Number)',
            align: 'start',
            value: 'item_id',
          },
          { text: 'Name', value: 'item_name' },
          { text: 'Category', value: 'category' },
          { text: 'Price', value: 'item_price' },
          { text: 'Quantity', value: 'item_quantity' },
          { text: 'Status', value: 'item_status' },
          { text: 'Actions', value: 'actions', align: 'center'},
        ],
        inventoryItems: [
            {
                item_id: 1,
                item_name: 'Mouse',
                category: 'Accessories',
                item_price: 1219,
                item_quantity: 40,
                item_status: 'in stock',

            }
        ],
        items: [],
        addForm: {
            item_name: '',
            category: '',
            item_price: '',
            item_quantity: '',
            item_desc: '',
        },
        // rules: {
        //     required: value => !!value || 'this field is required',
        //     notNull: value != 0 || 'quantity is not 0' 
        // },
        rules: {
            required: value => !!value || 'This field is required.',
            notNull: v => v != 0 || 'Quantity must be higher than 0',
        },
        snackbar: false,
        message: '',
    }),
    methods:{
        async saveItem(){

            await this.$http.post('api/saveItem', this.addForm, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
            .then((res) => {
                this.snackbar = true
                this.message = res.data.message
                this.dialog = false
            })
            // console.log(this.addForm)
        },
        btnAddItem(){
            // this.addForm = ''
            this.editmode = 'add'
            this.dialog = true
        },
        btnDelete(){
            this.editmode = 'delete'
            this.dialog = true
        },
        btnShow(){
            this.editmode = 'show'
            this.dialog = true
        },
        btnEdit(){
            this.editmode = 'edit'
            this.dialog = true
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
       
    },
    mounted(){
        this.getUser()
    }
}
</script>