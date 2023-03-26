<template>
  <div class="cat">
    <div class="cat-famille">
      <div class="row mt-4">

        <div class="col-12  mt-4">
          <!-- Store Type template -->
          <panel :title="store_type.title" :th="store_type.thead" :tb="store_type.tbody"
                :getData_forPag="getData"
                :addData_func="addData"
                :editData_func="editeData"
                :deleteData_func="deleteData"
                :deleteMultiData_func="''" >

            <template v-slot="slotProps">
              <td class="">{{ slotProps.row.id }}</td>
              <td class="">{{ slotProps.row.name }}</td>
              <td class=""><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td>
              <td class="">{{ slotProps.row.rank }}</td>
            </template>
          </panel>

        </div>
      </div>
      <div class="row mt-4">
        <div class="col-6">
          <!-- Categorie templete -->
          <panel :title="cat.title" :th="cat.thead" :tb="cat.tbody"
                :getData_forPag="getData"
                :addData_func="addData"
                :editData_func="editeData"
                :deleteData_func="deleteData"
                :deleteMultiData_func="''" >

            <template v-slot="slotProps">
              <td class="">{{ slotProps.row.id }}</td>
              <td class="">{{ slotProps.row.name }}</td>
              <td class=""><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td>
              <td class="">{{ slotProps.row.rank }}</td>
            </template>
          </panel>

        </div>

        <div class="col-6">
          <!-- Famille tmeplate -->
          <panel :title="famille.title" :th="famille.thead" :tb="famille.tbody"
                :getData_forPag="getData"
                :addData_func="addData"
                :editData_func="editeData"
                :deleteData_func="deleteData"
                :deleteMultiData_func="''" >

            <template v-slot="slotProps">
              <td class="">{{ slotProps.row.id }}</td>
              <td class="">{{ slotProps.row.name }}</td>
              <td class=""><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td>
              <td class="">{{ slotProps.row.rank }}</td>
            </template>
          </panel>

        </div>


      </div>






       <!-- Model for add or modifie -->
    <div class="modal fade " id="modal_cat" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="info">

              <!-- Categore -->
                <div class="cat" v-if="modal.type == 'famille'">
                  <span class="name">Categorie</span>
                  <div class="inp-form select-form">
                    <select name="catigorie" :class="['form-select from-select-sm', errors.categorie? 'is-invalid':'']" v-model="element.categorie_id" disabled>
                      <option v-for="elem in response.cat" :key="elem" :value="elem.id">{{elem.name}}</option>
                    </select>
                  </div>
                </div>

              <!-- name -->
              <div class="name">
                <span class="name">Name</span>
                <div class="inp-form">
                  <input :class="['form-control',errors.name?'is-invalid':'']" type="text" name="name" v-model="element.name" />
                  <span class="invalid-feedback" v-text="errors.name?errors.name[0]:''"></span>
                </div>
              </div>

              <!-- status -->
              <div class="status">
                <span class="name">Status</span>
                <div class="inp-form">
                  <select name="status" :class="['form-select from-select-sm',errors.status?'is-invalid':'']" v-model="element.status" >
                    <option value="1">active</option>
                    <option value="0">inactive</option>
                  </select>
                  <span class="invalid-feedback" v-text="errors.status?errors.status[0]:''"></span>
                </div>
              </div>

              <!-- rank -->
                <div class="rank">
                  <span class="name">Rank</span>
                  <div class="inp-form">
                    <input :class="['form-control',errors.rank?'is-invalid':'']" type="text" name="name" v-model="element.rank" />
                    <span class="invalid-feedback" v-text="errors.rank?errors.rank[0]:''"></span>
                  </div>
                </div>

            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="empty_data()" data-bs-dismiss="modal">Canccel</button>
            <button type="button" class="btn btn-primary" @click="sendAction(modal.type)">{{ modal.btn }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>
import $ from "jquery";
import panel from "../../components/admin/pan-content.vue";
export default {
  name: "categorieDash",
  components: {
    panel,
  },
  data: function() {
    return {
      cat: {
        type: 'cat',
        title: "Categories",
        thead: ["ID", "Name", "status", "rank" ],
        tbody: '',
      },
      famille: {
        type: 'famille',
        title: "Famille",
        thead: ["ID", "Name", "status", "rank" ],
        tbody: '',
      },
      store_type: {
        type: 'store',
        title: "Store Type",
        thead: ["ID", "Name", "status", "rank" ],
        tbody: '',
      },
      inp_disable: true,
      response: {},
      modal: {
        type: '',
        title: 'Groupe',
        btn: 'save',
      },
      element: {status: 0,},
      errors: {},
      model_dom: '',
      action_func: '',
      selected: '',
    };
  },
  methods:{

    // get Data of Categories
    getData(page=1,to, id){
      let action = 'getData';
      axios.post("/api/admin/"+ to, {action: action, id: id}).then(response =>{
        // console.log(response)
        this.response[to] = response.data.data.data;
        this[to]['tbody'] = '';
        this[to]['tbody'] = response.data.data;
        this[to]['tbody']['type'] = to;
      })
    },

    sendAction(to, id){
      let data = this.element;
      let action = this.action_func;
      action == "delete" ? data = {id: id} : '';
      data.action = action;

      axios.post("/api/admin/"+ to, data).then(response =>{
        // console.log(response);

        // if don't have permition
        if(response.data.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
          })

        // if not
        }else{
          this.responseHandel(response, action, to);
        }
      })
    },

    responseHandel(response, action, to){
      let status_resp = response.data.status;

      // if have errore
      if(status_resp == "error" && action != 'delete'){
        this.errors = response.data.errors;


        // if success
      } else if(status_resp == "done" && action != 'delete'){

        if(to == 'famille'){
          this.getData(1,to, this.element.categorie_id)
        }else{
          this.getData(1,to);
        }

        // this.getData(to);
        this.model_dom.hide();
        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +" " + to
        })

        // on success delete
      }else if( action == 'delete' && status_resp == "done"){
        to == 'famille' ? this.getData(1,to, this.element.categorie_id) : this.getData(1,to);
        Swal.fire({
          icon: 'success',
          title: to + 'has been deleted.',
          showConfirmButton: false,
          timer: 1000
        });

        // on error delete
      }else if( action == 'delete' && status_resp == "error"){
        Swal.fire({
          icon: 'error',
          title: "Can't delete this element  :(",
          showConfirmButton: false,
          timer: 1000
        });
      }
    },

    // change sum element in add
    addData(type){
      this.element.categorie_id = this.selected;
      if(type == undefined){
        Swal.fire(
          'Select Categorie!',
          'اختر القسم الذي تريد اضافة فيه العائلة',
          'question',
        );

      }else{
        this.inp_disable = false;
        this.modal.type = type;
        this.modal.title = "Add "+ type;
        this.modal.btn = "Add";

        this.model_dom.show();
        this.action_func = "add";
      }
    },

    // change sum element in edit
    editeData(elem, type){

      this.inp_disable = true;          // modifie element in DOM
      this.modal.type = type;
      this.modal.title = "Add "+ type;
      this.modal.btn = "Update";

      let data = Object.assign({},elem);   // get the data and put it in Modal
      this.element = data;

      this.model_dom.show();
      this.action_func = "update";

    },

    // show message whene delete
    deleteData(elem, type){
      Swal.fire({
        title: 'Are you sure to delete?',
        text: "Delete Group: " + elem.name,
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

      }).then((result) => {
        if (result.isConfirmed) {

          this.action_func = "delete";
          this.sendAction(type, elem.id);
        }
      })
    },

    click_row(id, event, type){
      if(type == 'cat'){
        this.getData(1,'famille', id);
        this.selected = id;
      }
    },

    dblclick_row(elem, type){
      this.editeData(elem, type);
    },

    empty_data(){
      this.element = {status: 0,};
      this.errors = {};
    }
  },
  mounted: function (){
    setTimeout( ()=> {this.getData(1,'cat')}, 200);
    // setTimeout(this.getDataFamille, 200);
    setTimeout( ()=> {this.getData(1,'store_type')}, 200);
    this.model_dom = new bootstrap.Modal(document.getElementById('modal_cat'), {});
  },
};
</script>

