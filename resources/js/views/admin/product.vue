<template>
  <div class="product">
    <panel-template :title="title" :th="thead" :tb="tbody"
                    :getData_forPag="getData"
                    :addData_func="addData"
                    :editData_func="editeData"
                    :deleteData_func="deleteData"
                    :deleteMultiData_func="''"
                    :selected="nothing"
                    :search_str="search_prod">
      <template #search>
        <select class="form-select form-select-sm search-select" v-model="search_method">
          <option value="name">Name</option>
          <option value="code_bare">Code Bare</option>
          <option value="name_ar">Name AR</option>
        </select>
      </template>

      <template v-slot="slotProps">
        <td class="id">{{ slotProps.row.id }}</td>
        <td class="image"><img :src="'/'+slotProps.row.image" alt=""></td>
        <td class="code-bare">{{ slotProps.row.code_bare }}</td>
        <td class="name">{{ slotProps.row.name }}</td>
        <td class="name ar">{{ slotProps.row.name_ar }}</td>
        <td class="price">{{ slotProps.row.price_sell1 }}</td>
        <td class="price">{{ slotProps.row.price_sell2 }}</td>
        <td class="price">{{ slotProps.row.price_sell3 }}</td>
        <td class="goute">{{ slotProps.row.has_goute }}</td>
        <td class="stock">{{ slotProps.row.in_stock }}</td>
        <td class="status"><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td>
        <td class="stock">{{ slotProps.row.rank }}</td>
      </template>

    </panel-template>


    <!-- ***** Model for add or modifie ***** -->
    <div class="modal fade " id="modal_product" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

              <div class="info">

                <div class="row">

                  <div class="col">

                    <div class="row mt-5">
                      <div class="col">
                        <!-- Porduct ID -->
                        <div class="id">
                          <span class="name">Product ID</span>
                          <div class="inp-form select-form">
                            <input :class="['form-control',errors.id?'is-invalid':'']" type="text" name="id" disabled v-model="product.id" />
                            <span class="invalid-feedback" v-text="errors.id?errors.id[0]:''"></span>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <!-- Code Bare -->
                        <div class="code-bare">
                          <label for="code_bare" class="name">Code Bare</label>
                          <div class="inp-form">
                            <input :class="['form-control',errors.code_bare?'is-invalid':'']"  id="code_bare" type="number" name="mobile" v-model="product.code_bare" />
                            <span class="invalid-feedback" v-text="errors.code_bare?errors.code_bare[0]:''"></span>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col">
                        <!-- categorie Product -->
                        <div class="inp-form">
                          <span>categorie</span>
                          <select name="categorie" :class="['form-select from-select-sm', errors.categorie_id? 'is-invalid':'']" v-model="product.categorie_id">
                            <option v-for="elem in response.categories" :key="elem" :value="elem.id">{{elem.name}}</option>
                          </select>
                          <span class="invalid-feedback" v-text="errors.categorie_id?errors.categorie_id[0]:''"></span>
                        </div>
                      </div>
                      <div class="col">
                        <!-- famille product -->
                        <div class="inp-form">
                          <span>Famille</span>
                          <select name="famille" :class="['form-select from-select-sm', errors.famille_id? 'is-invalid':'']" v-model="product.famille_id">
                            <option v-for="elem in response.familles" :key="elem" :value="elem.id">{{elem.name}}</option>
                          </select>
                          <span class="invalid-feedback" v-text="errors.famille_id?errors.famille_id[0]:''"></span>
                        </div>
                      </div>
                    </div>

                    <div class="row mt-5">
                      <div class="col">
                        <!-- name Product -->
                        <div class="name">
                          <label for="name-product" class="name">Name</label>
                          <div class="inp-form">
                            <input :class="['form-control',errors.name?'is-invalid':'']" id="name-user" type="text" name="name" v-model="product.name" required />
                            <span class="invalid-feedback" v-text="errors.name?errors.name[0]:''"></span>
                          </div>
                        </div>

                        <!-- name Ar Product -->
                        <div class="name_ar mt-2">
                          <label for="name-product-ar" class="name">Name AR</label>
                          <div class="inp-form ar">
                            <input :class="['form-control',errors.name_ar?'is-invalid':'']" id="name-product-ar" type="text" name="name_ar" v-model="product.name_ar" required />
                            <span class="invalid-feedback" v-text="errors.name_ar?errors.name_ar[0]:''"></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col">
                    <!-- Product Image -->
                    <div class="mb-3 image">
                      <div class="show-image">
                        <img :src="image ? image : ('/'+product.image)" alt="">
                      </div>
                      <input class="upload-inp" type="file" id="formFile" @change="upload_image">
                    </div>
                  </div>
                </div>

                <div class="row mt-5">

                  <div class="col">
                    <!-- price buy -->
                    <div class="price-buy">
                      <span class="name">Price buy</span>
                      <div class="inp-form select-form">
                        <input name="rat" type="number" :class="['form-control from-control-sm', errors.price_buy? 'is-invalid':'']" v-model="product.price_buy" />
                        <span class="invalid-feedback" v-text="errors.price_buy?errors.price_buy[0]:''"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <!-- Qte Unit / Cartoune -->
                    <div class="qte-uc">
                      <span class="name">Qte Unit/<sub>Cartone</sub></span>
                      <div class="inp-form select-form">
                        <input name="rat" type="number" :class="['form-control from-control-sm', errors.qte_uc? 'is-invalid':'']" v-model="product.qte_uc" />
                        <span class="invalid-feedback" v-text="errors.qte_uc?errors.qte_uc[0]:''"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <!-- price method -->
                    <div class="method">
                      <span class="name">Price method</span>

                      <div class="check-form">
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="check_price" id="check_price_unit" value="unite" v-model="product.method_price">
                          <label class="form-check-label" for="check_price_unit">Unite</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="check_price" id="check_price_carton" value="cartone" v-model="product.method_price">
                          <label class="form-check-label" for="check_price_carton">Cartone</label>
                        </div>
                      </div>
                      <span class="text-danger" v-text="errors.method_price?errors.method_price[0]:''"></span>
                    </div>
                  </div>
                </div>

                <div class="row mt-5">
                  <div class="col">
                    <!-- price 1 -->
                    <div class="price inp-form select-form">
                      <span class="name">Price sell 1</span>
                      <input name="rat" type="number" :class="['form-control from-control-sm', errors.price_sell1? 'is-invalid':'']" v-model="product.price_sell1" />
                      <span class="invalid-feedback" v-text="errors.price_sell1?errors.price_sell1[0]:''"></span>
                    </div>
                  </div>

                  <div class="col">
                     <!-- price 2 -->
                    <div class="price">
                      <div class="inp-form select-form">
                        <span class="name">Price sell 2</span>
                        <input name="rat" type="number" :class="['form-control from-control-sm', errors.price_sell2? 'is-invalid':'']" v-model="product.price_sell2" />
                        <span class="invalid-feedback" v-text="errors.price_sell2?errors.price_sell2[0]:''"></span>
                      </div>
                      <div class="qte">
                        <span>Qte<sub>Cartone</sub> :</span>
                        <input type="number" class="form-control" v-model="product.qte_sell2">
                      </div>
                    </div>
                  </div>

                  <div class="col">
                    <!-- price 3 -->
                    <div class="price">
                      <div class="inp-form select-form">
                        <span class="name">Price sell 3</span>
                        <input name="rat" type="number" :class="['form-control from-control-sm', errors.price_sell3? 'is-invalid':'']" v-model="product.price_sell3" />
                        <span class="invalid-feedback" v-text="errors.price_sell3?errors.price_sell3:''"></span>
                      </div>
                      <div class="qte">
                        <span>Qte<sub>Cartone</sub> :</span>
                        <input type="number" class="form-control" v-model="product.qte_sell3">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-5">
                  <div class="col-3">
                    <!-- Goute input -->
                    <div class="goute">
                      <label for="goute">Goute</label>
                      <div class="btn-add">
                        <input type="text" :class="['form-control', errors.product_goute? 'is-invalid':'']" v-model="goute" v-on:keyup.enter="add_goute">
                        <button type="button" class="btn btn-outline-success ms-2" @click.prevent="add_goute">add</button>
                        <span class="invalid-feedback" v-text="errors.product_goute?errors.product_goute[0]:''"></span>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <ul class="list-goute">
                      <li v-for="(elem, index) in product.product_goute" :key="elem" :class="elem.edite">
                        <span>{{ elem.goute }}</span>

                        <div class="opt">
                          <span :class="['status-btn', elem.in_stock == 1 ? 'active':'']" @click="change_status(elem)"></span>
                          <i class="far fa-trash-alt delete" @click="del_goute(index, elem)"></i>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="col-1"></div>

                  <div class="col-2">
                    <!-- status product -->
                    <div class="status">
                      <span class="name">Status</span>
                      <div class="inp-form select-form">
                        <select name="status" :class="['form-select from-select-sm', errors.status? 'is-invalid':'']" v-model="product.status" >
                          <option value="1">active</option>
                          <option value="0">inactive</option>
                        </select>
                        <span class="invalid-feedback" v-text="errors.status?errors.status[0]:''"></span>
                      </div>
                    </div>
                  </div>

                  <div class="col-2">
                    <!-- stock Product -->
                    <div class="stock">
                      <span class="name">Stock</span>
                      <div class="inp-form select-form">
                        <select name="status" :class="['form-select from-select-sm', errors.in_stock? 'is-invalid':'']" v-model="product.in_stock" >
                          <option value="1">in stock</option>
                          <option value="0">out stock</option>
                        </select>
                        <span class="invalid-feedback" v-text="errors.in_stock?errors.in_stock[0]:''"></span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row mt-3">
                  <div class="col-6">
                    <!-- description -->
                    <label for="desc">Description</label>
                    <div class="inp-form">
                      <textarea name="description" :class="['form-control', errors.description? 'is-invalid':'' ]" id="desc" cols="30" rows="1" v-model="product.description"></textarea>
                    </div>
                  </div>
                  <div class="col-2"></div>
                  <div class="col-4">
                    <!-- Rank -->
                    <div class="price inp-form select-form">
                      <span class="name">Rank</span>
                      <input name="rat" type="number" :class="['form-control from-control-sm', errors.rank? 'is-invalid':'']" v-model="product.rank" />
                      <span class="invalid-feedback" v-text="errors.rank?errors.rank[0]:''"></span>
                    </div>
                  </div>
                </div>
              </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="empty_data()" data-bs-dismiss="modal">Canccel</button>
            <button type="submit" class="btn btn-primary" @click="sendAction">{{ modal.btn }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>


<script>
import PanelTemplate from '../../components/admin/pan-content.vue';

export default {
  name: "ProductDash",
  components: {
    PanelTemplate
  },
  data: function () {
    return {
      title: "product",
      thead: ["ID", "Image", "code_bare", "Name", "Name AR", "Price 1", "price 2", "price 3", "Goute", "in Stocke", "status", "rank"],
      tbody:{data:{},},
      modal: {},
      response: {},
      categories: {},
      familles: {},
      product: {product_goute: [], status: 0, in_stock: 0},
      errors: {0:{},},
      goute: "",
      action_func: "",
      image: '',
      image_up: '',
      search:'',
      search_method: 'name',

    };
  },
  methods: {

    getData(page=1){
      let action = 'getData';
      axios.post("/api/product?page="+page, {action: action}).then(response =>{
        console.log(response);
        // if don't have permition
        if(response.data.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
            // footer: '<a href="">Why do I have this issue?</a>'
          })

        // if not
        }else{
          this.tbody = response.data.data;
        }
      });
    },
    getHelpInfo(){
      axios.post("/api/product", {action: "getHelpInfo"}).then(response => {
        this.response.categories = response.data.categories;
        this.response.familles = response.data.familles;
      });
    },

    sendAction(id=''){
      let action = this.action_func;
      let data = new FormData();
      data.append('action', action);
      data.append('image', this.product.image);
      data.append('product', JSON.stringify(this.product));

      action == "delete" ? data={action: 'delete', id: id} : '';

      axios.post("/api/product", data).then(response => {

          // if don't have permition
        if(response.data.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
            // footer: '<a href="">Why do I have this issue?</a>'
          })

        // if not
        }else{
          this.responseHandel(response, action);
        }
      })
    },
    responseHandel(response, action){
      let status_resp = response.data.status;

      // if have errore
      if(status_resp == "error" && action != 'delete'){
        console.log('error in form')
        this.errors = response.data.errors;

      // if saccess
      } else if(status_resp == "done" && action != 'delete'){
        this.getData(this.tbody.current_page);
        this.model_dom.hide();
        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +' Product :)'
        })

       // on success delete
      }else if( action == 'delete' && status_resp == "done"){
        this.getData(this.tbody.current_page);
        Swal.fire({
          icon: 'success',
          title: 'Product has been deleted.',
          showConfirmButton: false,
          timer: 1000
        });

      // on error delete
      }else if( action == 'delete' && status_resp == "error"){
        Swal.fire({
          icon: 'error',
          title: "Can't delete this Product :(",
          showConfirmButton: false,
          timer: 1000
        });

      }
    },
    addData(){
      this.modal.title = "Add Product";
      this.modal.btn = "Add";

      this.model_dom.show();
      this.action_func = "add";

    },
    deleteData(elem){
      Swal.fire({
        title: 'Are you sure to delete?',
        html: "Delete Product : <span class='fs-3 text-primary'> " + elem.name + "</span>",
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

      }).then((result) => {
        if (result.isConfirmed) {
          this.action_func = "delete";
          this.sendAction(elem.id);
        }
      })
    },
    editeData(elem){

      this.product = JSON.parse( JSON.stringify(elem)); // get the data from response register and put it in Modal

      // this.inp_disable = true;          // modifie element Modal in DOM
      this.modal.title = "Edit User";
      this.modal.btn = "Update";

      this.model_dom.show();
      this.action_func = "update";
    },
    search_prod(str){
      let data= {action: "search", str: str, method: this.search_method};

      axios.post("/api/product", data).then(resp =>{
        this.tbody = resp.data;
      })
    },

// **** Goute Function *****
    edite_goute(){

    },
    add_goute(){
      let inp = this.goute;
      if(inp.length > 2){
        // Array.isArray(this.product.product_goute) ? '' : this.product.groduct_goute = [];
        this.product.product_goute.push({goute: inp, in_stock: 0});
        this.goute = '';
      }
    },
    change_status(elem){

      if(elem.edite != "delete"){
        elem.in_stock =  elem.in_stock == 1 ? 0 : 1;
        elem.edite = "edite";
      }
    },
    del_goute(index, elem){
      if(elem.id){
        elem.edite = elem.edite != "delete" ? "delete" : "edite";

      }else{
        this.product.product_goute.splice(index,1);
      }
    },
    upload_image(e){
      let file = e.target.files[0];
      file ? this.product.image = file: '';

      let reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = e=>{
        this.image = e.target.result;
      }
    },

  // **** Other Function *******
    empty_data(){
      this.product= {product_goute: [], status: 0, in_stock: 0};
      this.errors= {0:{},};
      this.image= '';
      this.goute= "";
    },
    search_id(id_search, from_search){
      for(let elem of from_search){           // loop in response and get data of element with id
        if(id_search == elem.id){return elem; };
      };
    },
    nothing(){

    },
  },
  mounted: function(){
    this.getData();
    this.getHelpInfo();
     this.model_dom = new bootstrap.Modal(document.getElementById('modal_product'), {});
  },
};
</script>
