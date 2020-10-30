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
                  color="amber"
                ></v-progress-circular>
                <v-icon v-else> mdi-refresh </v-icon>
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
              <template v-slot:[`item.item_status`]="{ item }">
                <v-chip :color="getColor(item.item_status)" dark>
                  {{ item.item_status }}
                </v-chip>
              </template>
            </v-data-table>
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
            <v-form ref="form" v-model="valid" lazy-validation>
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
            <v-btn text @click="dialogAdd = false">
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
        <v-card-title class="headline" v-if="editmode == 'add'">
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
        <v-container v-else-if="editmode == 'show'">
          <v-card-text>
            <div>
              <span>Item: </span><span class="mx-5"></span
              ><span>{{ showItemDetails.item_name }}</span
              ><br />
              <span>Category: </span><span class="mx-5"></span
              ><span>{{ showItemDetails.category }}</span
              ><br />
              <span>Price: </span><span class="mx-5"></span
              ><span>{{ showItemDetails.item_price }}</span
              ><br />
              <span>Quantity: </span><span class="mx-5"></span
              ><span>{{ showItemDetails.item_quantity }}</span
              ><br />
              <span>Status: </span><span class="mx-5"></span
              ><span>{{ showItemDetails.item_status }}</span
              ><br />
              <span>SPECS</span><br>
              <div v-for="specs in showSpecDetails">
                <div>{{specs.spec}}</div>
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
  </v-app>
</template>
<script>
export default {
  data: () => ({
    specs: [],
    stepper: 1,
    dialogAdd: false,
    btnLoadIsPressed: false,
    valid: true,
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
    saveAll(){
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
        if(res.status == 200){
          this.lastId = res.data.data['item_id']
          var toPush = res.data.data
          var addRows = _.map(this.specs, (num) => {
            return _.pick(num, 'spec_name');
          })
          this.$http.post('api/setSpecs/' + this.lastId , { specs: addRows }, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() }})
          .then((res) => {
            this.dialogAdd = false
            this.snackbar = true
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
    },
    discardAdd(){
      this.specs = []
      this.stepper = 1
      this.dialogAdd = false
      this.formReset()
    },
    add() {
      console.log( _.size(this.specs) )
      if( _.size(this.specs) <= 4 ){
        this.specs.push({
          spec_name: ''
        })
      }
      else{
        console.log('Out of bounds')
      }
    },
    remove(index) {
      this.specs.splice(index, 1);
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
      await this.$http
        .get("api/items", {
          headers: { Authorization: "Bearer " + this.$auth.getToken() },
        })
        .then((res) => {
          this.inventoryItems = res.data.data;
        })
        .finally(() => {
          this.btnLoadIsPressed = false;
        });
    },
    btnAddItem() {
      this.formReset();
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
      this.dialog = true;
      this.showItemDetails = item;
      // console.log(item.item_id)
      await this.$http.post('api/getSpecs', item, { headers: { Authorization: 'Bearer ' + this.$auth.getToken() } })
      .then((res) => {
        this.showSpecDetails = res.data.data
        console.log(this.showSpecDetails)
      })
    },
    btnEdit(item) {
      this.editmode = "edit";
      this.dialog = true;
      this.editForm = item;
      this.index = this.inventoryItems.indexOf(item);
    },
    async updateItem() {
      await this.$http
        .put("api/updateItem/" + this.editForm.item_id, this.editForm, {
          headers: {
            Authorization: "Bearer " + this.$auth.getToken(),
          },
        })
        .then((res) => {
          this.snackbar = true;
          this.message = res.data.message;
          this.dialog = false;
          Object.assign(this.inventoryItems[this.index], res.data.data);
        });
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
      this.addForm.item_name = "";
      this.addForm.category = "";
      this.addForm.item_price = "";
      this.addForm.item_quantity = "";
      this.valid = true;
    },
  },
  mounted() {
    this.getAllItems();
    this.getUser();
  },
};
</script>