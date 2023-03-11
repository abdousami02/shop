<template>
  <div class="order">
    <p>order</p>
    <panel-template :title="title" :th="thead" :tb="tbody" :tbkey="tkey"
                :getData_forPag="getData"
                :addData_func="addData"
                :editData_func="editeData"
                :deleteData_func="deleteData"
                :deleteMultiData_func="''" >

      <template v-slot="slotProps">
        <td class="id">{{ slotProps.row.id }}</td>
        <td class="image">{{ slotProps.row.user ? slotProps.row.user.name : ''}}</td>
        <td class="name">{{ slotProps.row.store_info ? slotProps.row.store_info.name : '' }}</td>
        <td class="stock">{{ slotProps.row.saller ?  slotProps.row.saller.name : ''}}</td>
        <td class="name">{{ slotProps.row.montant }}</td>
        <td class="price">{{ slotProps.row.num_product }}</td>
        <td class="price">{{ slotProps.row.poide }}</td>
        <td class="status"><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td>
      </template>

    </panel-template>


      <!-- Model for add or modifie -->
    <div class="modal fade " id="modal_product" data-bs="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <!-- <div class="info"> -->
              <!-- id Group-->


          </div>
          <div class="modal-footer">
            <!-- <button type="button" class="btn btn-secondary" @click="empty_data()" data-bs-dismiss="modal">Canccel</button>
            <button type="button" class="btn btn-primary" @click="sendAction()">{{ modal.btn }}</button> -->
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import PanelTemplate from "../../components/admin/pan-content.vue";
export default {
  name: "OrderDash",
  components: {
    PanelTemplate,
  },
  data: function () {
    return {
      title: "Orders",
      thead: ["ID", "User Name", "Store Name", "to Saller", "Montant", "Num Product", "Poide", "Status",],
      tbody:{
        data:{
          4: [4, "amin", "0699426634", "Adam Shop", "Supperett", "actvie", "2", "14"],
          8: [8, "abdelrahman", "0773982345", "Abdou Shop", "Alimantation", "inactive", "0", "0"],
        },
      },
      modal: {},
      errors: {0:{}},
      response: {},
      categories: {},
      familles: {},
      product: {goute: []},
      goute: "",

    };
  },
  methods: {

    getData(page=1){
      let action = 'getData';
      axios.post("/api/order?page="+page, {action: action}).then(response =>{

        // console.log(response);
        let resp = response.data;

        // if don't have permition
        if(resp.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
            // footer: '<a href="">Why do I have this issue?</a>'
          })

        // if not
        }else{

          this.tbody = resp.data;
        }
      });
    },
    getHelpInfo(){
      axios.post("/api/order", {action: "getHelpInfo"}).then(response => {
        // console.log(response);
        this.response.categories = response.data.categories;
        this.response.familles = response.data.familles;
      });
    },
    addData(){
      // console.log('show')
      this.inp_disable = false;
      this.modal.title = "Add Product";
      this.modal.btn = "Add";

      this.model_dom.show();
      this.action_func = "add";

    },
    deleteData(){

    },
    editData(){

    },
    empty_data(){

    },
  },
  mounted: function(){
    this.getData();
    // this.getHelpInfo();
     this.model_dom = new bootstrap.Modal(document.getElementById('modal_product'), {});
  }
};
</script>
