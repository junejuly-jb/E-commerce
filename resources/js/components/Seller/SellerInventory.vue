<template>
  <v-app>
    <div class="d-flex page" id="wrapper">
      <sellersidebar v-bind:user="user"></sellersidebar>
      <div id="page-content-wrapper">
        <sellernav v-bind:user="user"></sellernav>
        <div class="container">
          <div class="dashHeader">
            <span class="discover">Inventory</span
            ><span class="daily"> Details</span>
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
                <v-icon> mdi-plus </v-icon>
              </v-btn>
              <v-btn
                class="mx-2"
                @click="btnLoad"
                small
                fab
                color="blue darken-1"
              >
                <v-progress-circular
                  v-if="btnLoadIsPressed == true"
                  indeterminate
                  color="white"
                ></v-progress-circular>
                <v-icon v-else> mdi-refresh </v-icon>
              </v-btn>
            </v-card-title>
            <div v-if="beforeDataFetch == true">
              <v-skeleton-loader
              type="article"
              ></v-skeleton-loader>
            </div>
            <div v-else>
              <v-data-table
                :headers="headers"
                :items="inventoryItems"
                :search="search"
              >
                <template v-slot:[`item.actions`]="{ item }">
                  <!-- <v-btn icon color="blue lighten-2" @click="btnShow(item)">
                    <v-icon>mdi-eye-outline</v-icon>
                  </v-btn> -->
                  <!-- <v-btn icon color="green lighten-2" @click="btnEdit(item)">
                    <v-icon>mdi-pencil-outline</v-icon>
                  </v-btn>
                  <v-btn icon color="red lighten-2" @click="btnDelete(item)">
                    <v-icon>mdi-trash-can-outline</v-icon>
                  </v-btn> -->
                  <v-menu offset-y transition="slide-y-transition" left dark>
                    <template v-slot:activator="{ on, attrs }">
                      <v-btn
                        icon
                        v-bind="attrs"
                        v-on="on"
                        small
                        fab
                      >
                        <v-icon>mdi-dots-vertical</v-icon>
                      </v-btn>
                    </template>
                    <v-list max-width="400">
                      <v-list-item link @click="updateItemPhoto(item)">
                        <v-list-item-title> Update Item Image</v-list-item-title>
                      </v-list-item>
                    </v-list>
                    <v-list max-width="400">
                      <v-list-item link @click="btnShow(item)">
                        <v-list-item-title> Product Details</v-list-item-title>
                      </v-list-item>
                    </v-list>
                    <v-list max-width="400">
                      <v-list-item link @click="btnDelete(item)">
                        <v-list-item-title>Delete</v-list-item-title>
                      </v-list-item>
                    </v-list>
                    <v-list max-width="400">
                      <v-list-item link @click="btnEdit(item)">
                        <v-list-item-title>Edit Item</v-list-item-title>
                      </v-list-item>
                    </v-list>

                  </v-menu>
                </template>
                <template v-slot:[`item.item_status`]="{ item }">
                  <v-chip :color="getColor(item.item_status)" dark>
                    {{ item.item_status }}
                  </v-chip>
                </template>
              </v-data-table>
            </div>
          </v-card>
        </div>
      </div>
    </div>

    <!-- DIALOG ADD  -->
    <v-dialog v-model="dialogAdd" persistent max-width="600">
      <v-card>
        <v-card-title class="headline">
          <span class="text-primary"> Add item </span>
        </v-card-title>
        <v-container>
          <v-stepper
          v-model="stepper"
          vertical
        >
          <v-stepper-step
            :complete="stepper > 1"
            step="1"
            color="green darken-2"
          >
            Provide Item Details
            <small>Summarize if needed</small>
          </v-stepper-step>

          <v-stepper-content step="1">
            <v-container>
            <v-form ref="formItem">
              <input
                class="form-control"
                type="file"
                @change="selectPhoto"
              >
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
                    :rules="[rules.required]"
                    v-model="addForm.item_quantity"
                    prepend-icon="mdi-file-table-box"
                    suffix="pcs"
                    label="Quantity"
                    type="number"
                  ></v-text-field>
                </v-col>
              </v-row>
              <v-expand-transition>
                <div v-if="error == true">
                  <v-alert
                    class="m-auto"
                    color="red"
                    dense
                    text
                    width="250"
                    type="error"
                  >{{ err_message }}</v-alert>
                </div>
              </v-expand-transition>

            </v-form>
          </v-container>
            <v-btn
              color="primary"
              @click="saveItem"
            >
              Proceed
            </v-btn>
            <v-btn text @click="stepOneCancellation">
              Cancel
            </v-btn>
          </v-stepper-content>

          <v-stepper-step
            :complete="stepper > 2"
            step="2"
            color="green darken-2"
          >
            Product Specification
          </v-stepper-step>
          <v-stepper-content step="2">
            <div class="container mb-5">
              <v-alert
                border="left"
                color="orange"
                dense
                text
                type="warning"
              >Press "+" to add new field, Maximum fields: (5)</v-alert>
              <v-btn color="blue darken-2" @click="add"> <v-icon>mdi-plus</v-icon> New field</v-btn>
            </div>
            <div class="row" v-for="(spec, index) in specs" v-bind:key="index">
              <div class="col">
                  <v-text-field v-model="spec.spec_name" label="Specification"></v-text-field>
              </div>
              <div class="col-2">
                <v-btn 
                @click="remove(index)"
                fab
                small
                color="red darken-2" 
                v-if="index >= 1">
                <v-icon>mdi-minus</v-icon>
                </v-btn>
              </div>
            </div>
            <v-btn
              color="primary"
              @click="saveAll"
            >
              Save
            </v-btn>
            <v-btn text @click="stepper = 1">
              Previous
            </v-btn>
            <v-btn color="red darken-2" text @click="discardAdd">
              Discard
            </v-btn>
          </v-stepper-content>
        </v-stepper>
        </v-container>
      </v-card>
    </v-dialog>

    <!-- dialog -->
    <v-dialog v-model="dialog" persistent max-width="600">
      <v-card>
        <v-card-title class="headline" v-if="editmode == 'update photo'">
          <span class="text-primary"> Update item image </span>
        </v-card-title>
        <v-card-title class="headline" v-else-if="editmode == 'add'">
          <span class="text-primary"> Add item </span>
        </v-card-title>
        <v-card-title class="headline" v-else-if="editmode == 'delete'">
          <span class="text-danger"> Delete </span>
        </v-card-title>
        <v-card-title class="headline" v-else-if="editmode == 'show'">
          <span class="text-primary"> Item Details </span>
        </v-card-title>
        <v-card-title class="headline" v-else>
          <span class="text-warning"> Edit </span>
        </v-card-title>
        
        <v-container v-if="editmode == 'delete'">
          <v-card-text> do you want to delete this item? </v-card-text>
        </v-container>
        <v-container v-else-if="editmode == 'update photo'">
          <v-card-text>
            <input type="file" class="form-control" @change="updateOnSelectPhoto"/>
          </v-card-text>
        </v-container>
        <v-container v-else-if="editmode == 'show'">
          <v-img
            height="300"
            :src="'./uploads/' + showItemDetails.item_photo"
          ></v-img>
          <v-card-text>
            <div class="row">
              <div class="col">
                <div class="my-2">
                  <span class="my-3"><v-icon>mdi-dropbox </v-icon></span><span class="ml-2">{{ showItemDetails.item_name }}</span>
                </div>
                <div class="my-2">
                  <span class="py-1"><v-icon>mdi-format-list-bulleted</v-icon></span><span class="ml-2">{{ showItemDetails.category }}</span>
                </div>
                <div class="my-2">
                  <span class="py-1"><v-icon>mdi-currency-php</v-icon></span><span class="ml-2">{{ showItemDetails.item_price }}.00</span>
                </div>
                <div class="my-2">
                  <span><v-icon>mdi-file-table-box</v-icon></span><span class="ml-2">{{ showItemDetails.item_quantity }} pcs.</span>
                </div>
                <div class="my-2" v-if="showItemDetails.item_status == 'available'">
                  <span><v-icon color="green darken-2">mdi-check-circle-outline</v-icon></span><span class="ml-2">{{ showItemDetails.item_status }}</span>
                </div>
                </div>
              <div class="col">
                  <div class="text-primary h5">Product Specifications:</div>
                  <div class="my-2" v-for="spec in showSpecDetails" :key="spec.id">
                    <span>{{spec.spec}}</span>
                  </div>
              </div>
            </div>
          </v-card-text>
        </v-container>
        <v-container v-else>
          <v-row>
            <v-col>
              <v-text-field
                :rules="[rules.required]"
                v-model="editForm.item_name"
                prepend-icon="mdi-dropbox"
                label="Item name"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-autocomplete
                :rules="[rules.required]"
                v-model="editForm.category"
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
                v-model="editForm.item_price"
                prepend-icon="mdi-currency-php"
                label="Price"
                suffix=".00"
                type="number"
              ></v-text-field>
            </v-col>
            <v-col>
              <v-text-field
                :rules="[rules.required]"
                v-model="editForm.item_quantity"
                prepend-icon="mdi-file-table-box"
                label="Quantity"
                suffix="pcs"
                type="number"
              ></v-text-field>
            </v-col>
          </v-row>
          <div class="container">
            <div class="text-primary pb-3">Product Specifications {{specsCount}}</div>
            <v-btn color="green" small v-show="specsCount != 5" @click="editAdditionalSpecs"><v-icon>mdi-plus</v-icon> add field</v-btn>
            <div v-for="(specs, index) in editSpecsForm" :key="index" class="d-flex">
              <v-text-field :value="specs.spec" disabled></v-text-field>
              <v-btn fab color="red" small @click="removeSpecs(index, specs.id)"><v-icon>mdi-minus</v-icon></v-btn>
            </div>
            <div class="d-flex" v-for="(addition, i) in additionalSpecs" :key="'A' + i">
                  <v-text-field v-model="addition.edit_spec_name" label="Specification"></v-text-field>
                <v-btn 
                @click="removeAdditionalSpecs(i)"
                fab
                small
                color="red darken-2">
                <v-icon>mdi-minus</v-icon>
                </v-btn>
            </div>
          </div>
        </v-container>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn text @click="dialog = false"> Cancel </v-btn>
          <v-btn
            v-if="editmode == 'delete'"
            color="red darken-1"
            text
            @click="confirmDelete"
          >
            Delete
          </v-btn>
          <v-btn
            v-else-if="editmode == 'update photo'"
            color="green darken-1"
            text
            @click="updatePhoto"
          >
            Update Photo
          </v-btn>
          <v-btn
            v-else-if="editmode == 'edit'"
            color="green darken-1"
            text
            @click="updateItem"
          >
            Update
          </v-btn>
          <v-btn v-else color="green darken-1" text @click="dialog = false">
            Okay
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- snackbar  -->
    <v-snackbar v-model="snackbar">
      {{ message }}

      <template v-slot:action="{ attrs }">
        <v-btn color="pink" text v-bind="attrs" @click="snackbar = false">
          Close
        </v-btn>
      </template>
    </v-snackbar>



    <!-- spinner dialog  -->
    <v-dialog
      v-model="loading_dialog"
      persistent
      max-width="290"
    >
      <v-card>
        <div class="py-5 text-center">
          <v-progress-circular
            :size="70"
            :width="7"
            color="purple"
            indeterminate
          ></v-progress-circular>
          <span> Updating...</span>
        </div>
      </v-card>
    </v-dialog>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    beforeDataFetch: false,
    toUpdatePhoto: '',
    toUpdateItemId: '',
    loading_dialog: false,
    img_selector: '',
    additionalSpecs: [],
    specs: [],
    stepper: 1,
    dialogAdd: false,
    btnLoadIsPressed: false,
    menu: false,
    editmode: "",
    search: "",
    dialog: false,
    categories: [
      "Motherboards",
      "Mouse",
      "Keyboards",
      "Monitor",
      "RAM",
      "HDD",
      "SSD",
    ],
    user: {
      default_profile: "",
      name: "",
      email: "",
      address: "",
      usertype: "",
      contact: "",
    },
    headers: [
      {
        text: "Item (ID Number)",
        align: "start",
        value: "item_id",
      },
      { text: "Name", value: "item_name" },
      { text: "Category", value: "category" },
      { text: "Price", value: "item_price" },
      { text: "Quantity", value: "item_quantity" },
      { text: "Status", value: "item_status" },
      { text: "Actions", value: "actions", align: "center" },
    ],
    inventoryItems: [],
    showItemDetails: [],
    showSpecDetails: [],
    toDelete: [],
    addForm: {
      item_image: "",
      item_name: "",
      category: "",
      item_price: "",
      item_quantity: "",
      item_status: "available"
    },
    lastId: '',
    editForm: {
      item_name: "",
      category: "",
      item_price: "",
      item_quantity: "",
      item_desc: "",
    },
    editSpecsForm: [],
    rules: {
      required: (value) => !!value || "This field is required.",
      notNull: (v) => v != 0 || "Quantity must be higher than 0",
    },
    snackbar: false,
    message: "",
    index: -1,
    error: false,
    addRows: []
  }),
  methods: {

    async updatePhoto(){
      await this.$http.post('api/updateItemPhoto/' + this.toUpdateItemId, { photo: this.toUpdatePhoto }, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
      .then((res) => {
        this.snackbar = true
        this.message = res.data.message
        Object.assign(this.inventoryItems[this.index], res.data.data)
      })
      .finally(() => { this.dialog = false})
    },


    updateItemPhoto(item){
      this.editmode = 'update photo'
      this.dialog = true
      this.toUpdateItemId = item.item_id
      this.index = this.inventoryItems.indexOf(item);
    },


    saveAll(){
      this.dialogAdd = false
      this.loading_dialog = true

      if(this.addForm.item_quantity <= 0){
        this.addForm.item_quantity = '0'
        this.addForm.item_status = 'out of stock'
      }

      this.$http.post('api/saveItem', this.addForm, {
        headers: {
          Authorization: 'Bearer ' + this.$auth.getToken()
        }
      })
      .then((res) => {
        console.log(res.data.img)
        if(res.status == 200){
          this.lastId = res.data.data['item_id']
          var toPush = res.data.data
          var addRows = _.map(this.specs, (num) => {
            return _.pick(num, 'spec_name');
          })
          this.$http.post('api/setSpecs/' + this.lastId , { specs: addRows }, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() }})
          .then((res) => {
            this.specs = []
            this.stepper = 1
            this.message = res.data.message
            this.inventoryItems.push(toPush)
          })
        }
        else{
          this.dialogAdd = false
          this.snackbar = true
          this.message = 'Something went wrong'
        }
      })
      .finally(() => {
        setTimeout(() => {
          this.loading_dialog = false
          this.snackbar = true
          this.$refs.formItem.reset();
          this.$refs.formItem.resetValidation();
        }, 1000)
      })
    },


    updateOnSelectPhoto(e){
      let file = e.target.files[0]
        let reader = new FileReader();
        if(file['size'] > 4194304){
          this.err_message = 'File too large'
          this.error = true
          setTimeout(() => { this.error = false }, 3000)
        }
        else{
             reader.onload = (file) => {
                this.toUpdatePhoto = reader.result
            }
            reader.readAsDataURL(file)
        }
    },


    selectPhoto(e){
        let file = e.target.files[0]
        let reader = new FileReader();
        if(file['size'] > 4194304){
          this.err_message = 'File too large'
          this.error = true
          setTimeout(() => { this.error = false }, 3000)
        }
        else{
             reader.onload = (file) => {
                this.addForm.item_image = reader.result
            }
            reader.readAsDataURL(file)
        }
    },


    discardAdd(){
      this.specs = []
      this.stepper = 1
      this.dialogAdd = false
      this.formReset()
      this.$refs.formItem.resetValidation()
    },


    add() {
      if( _.size(this.specs) <= 4 ){
        this.specs.push({
          spec_name: ''
        })
      }
      else{
        console.log('Out of bounds')
      }
    },


    editAdditionalSpecs(){
      this.additionalSpecs.push({
        edit_spec_name: ''
      })
    },


    remove(index) {
      this.specs.splice(index, 1);
    },


    removeAdditionalSpecs(i) {
      this.additionalSpecs.splice(i, 1);
    },


    async removeSpecs(index, specs){
      await this.$http.delete('api/delSpecs/' + specs, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() }})
      .then((res) => {
        this.snackbar = true
        this.message = res.data.message
        this.editSpecsForm.splice(index, 1)
      })
    },


    getColor(item_status) {
      if (item_status == "available") return "green";
      else return "red";
    },


    saveItem() {
      if(this.addForm.item_name == '' || this.addForm.category == '' || this.addForm.item_quantity == '' || this.addForm.item_price == ''){
        this.error = true
        this.err_message = 'Pls input fields'
        setTimeout(() => {
          this.error = false
        },2000)
      }
      else if(this.addForm.item_image == ''){
        this.error = true
        this.err_message = 'Please select a new file'
        setTimeout(() => {
          this.error = false
        },2000)
      }
      else{
        this.stepper = 2
        this.error = false
      }
    },


    btnLoad() {
      this.btnLoadIsPressed = true;
      this.getAllItems();
    },


    async getAllItems() {
      this.beforeDataFetch = true
      await this.$http.get("api/items", { headers: { Authorization: "Bearer " + this.$auth.getToken() }})
        .then((res) => {
          this.inventoryItems = res.data.data;
        })
        .finally(() => {
          setTimeout(() => {
            this.beforeDataFetch = false
            this.btnLoadIsPressed = false;
          }, 1000)
        });
    },


    btnAddItem() {
      this.dialogAdd = true;
    },


    btnDelete(item) {
      this.editmode = "delete";
      this.dialog = true;
      this.toDelete = item;
      this.index = this.inventoryItems.indexOf(item);
    },


    async confirmDelete() {
      await this.$http
        .delete("api/deleteItem/" + this.toDelete.item_id, {
          headers: {
            Authorization: "Bearer " + this.$auth.getToken(),
          },
        })
        .then((res) => {
          this.dialog = false;
          this.snackbar = true;
          this.message = res.data.message;
          this.inventoryItems.splice(this.index, 1);
        });
    },


    async btnShow(item) {
      this.editmode = "show";
      this.showItemDetails = item;
      await this.$http.post('api/getSpecs', item, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
      .then((res) => {
        this.showSpecDetails = res.data.data
        this.dialog = true;
      })
    },


    btnEdit(item) {
      this.editmode = "edit";
      this.editForm = item;
      this.index = this.inventoryItems.indexOf(item);
      this.$http.get('api/editSpecs/' + item.item_id, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() }})
      .then((res) => {
        this.editSpecsForm = res.data.data
        this.dialog = true;
      })
    },


    async updateItem() {
      this.dialog = false
      this.loading_dialog = true
      console.log('clicked')
      await this.$http.put("api/updateItem/" + this.editForm.item_id, this.editForm, { headers: { Authorization: "Bearer " + this.$auth.getToken()}})
        .then((res) => {
          if(res.status == 200){
            this.lastId = res.data.data['item_id']
            var toPush_editedData = res.data.data
            Object.assign(this.inventoryItems[this.index], toPush_editedData)
            var addRows = _.map(this.additionalSpecs, (num) => {
              return _.pick(num, 'edit_spec_name');
            })
            this.$http.post('api/updateSpecs/' + this.lastId, {specs: addRows}, { headers: { Authorization: 'Bearer ' + this.$auth.getToken()}})
            .then((res) => {
              this.additionalSpecs = []
              this.message = res.data.message
              })
          }
          else{
            this.snackbar = true
            this.message = 'Something went wrong'
            this.loading_dialog = false
            
          }
        })
        .finally(() => {
          setTimeout(() => { 
            this.loading_dialog = false
            this.getColor()
            this.snackbar = true
          }, 1000)
        })
    },


    getUser() {
      var user = JSON.parse(localStorage.getItem("user"));
      this.user = user;

      var name = user.name;

      var getInitials = function (name) {
        var parts = name.split(" ");
        var initials = "";
        for (var i = 0; i < parts.length; i++) {
          if (parts[i].length > 0 && parts[i] !== "") {
            initials += parts[i][0];
          }
        }
        return initials;
      };
      this.user.default_profile = getInitials(name);
    },


    formReset() { 
      this.addForm.item_image = ""
      this.addForm.item_name = ""
      this.addForm.category = ""
      this.addForm.item_price = ""
      this.addForm.item_quantity = ""
      this.valid = true
    },

    stepOneCancellation(){
      this.formReset()
      this.$refs.formItem.resetValidation();
      this.dialogAdd = false
    }

  },


  computed: {
    specsCount(){
      return Object.keys(this.editSpecsForm).length  
    }
  },


  mounted() {
    this.getAllItems();
    this.getUser();
  },


};
</script>