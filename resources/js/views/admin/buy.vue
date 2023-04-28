<template>
  <div class="buy">
    <panel-template class="pan"  v-if="!show_details"
                    :title="title" :th="thead" :tb="tbody"
                    :getData_forPag="getData"
                    :addData_func="addData"
                    :editData_func="editeData"
                    :deleteData_func="deleteData"
                    :deleteMultiData_func="nothing" >

        <!-- link top -->
      <!-- <template v-slot:link_top>
        <li class="link"><router-link to="?status=0">Draft <span class="count">({{response.order_draft}})</span></router-link> |</li>
        <li class="link"><router-link to="?status=9">Canccel <span class="count">({{response.order_canccel}})</span></router-link></li>
      </template> -->

      <template v-slot="slotProps">
        <td class="id">{{ slotProps.row.id }}</td>
        <td class="date">{{ convert_date(slotProps.row.created_at)}}</td>
        <td class="user info-order" v-if="slotProps.row">
          <b>User :</b>
          <p class="info-elem" v-if="slotProps.row.user">
            <span class="name"> Name: <i>{{ slotProps.row.user.name }}, </i></span>
            <span> Mobile: <i>{{ '0'+slotProps.row.user.mobile }}</i></span>
          </p>
          <b>Store :</b>
          <p class="info-elem" v-if="slotProps.row.store_info">
            <span class="name">Name: <i>{{ slotProps.row.store_info.name }}, </i></span>
            <span class="name"> Address: <i>{{ slotProps.row.store_info.address }}, </i></span>
            <!-- <span> Store Type: <i>{{ slotProps.row.store_info.store_type.name }}</i></span> -->
          </p>
        </td>

        <td class="saller info-order">
          <b>Saller :</b>
          <p class="info-elem" v-if="slotProps.row.saller">
            <span class="name"> Name: <i>{{ slotProps.row.saller.name }}, </i></span><span> Mobile: <i>{{ '0'+slotProps.row.saller.user.mobile }}</i></span><br>
            <span>Address: <i>{{ slotProps.row.saller.address }}</i></span>
          </p>
        </td>

        <td class="num-product">{{ slotProps.row.num_product }}</td>
        <td class="weight">{{ slotProps.row.weight }} Kg</td>
        <td class="amount"><span>{{ setNumber(slotProps.row.amount) }} DA</span></td>
      </template>

      <template v-slot:btns_opt="slotProps">
        <a class="dropdown-item" @click="editeData(slotProps.row)"><i class="far fa-pen c"></i> Edit</a>
        <a class="dropdown-item" @click="makeCopy(slotProps.row)"><i class="far fa-copy"></i> Make Copy</a>
        <a class="dropdown-item" @click="calcOrder(slotProps.row, slotProps.index)"><i class="far fa-calculator"></i> Calc</a>
        <a class="dropdown-item" @click="$root.printOrder(slotProps.row.id, 'a5')"><i class="fas fa-print"></i> Print A5</a>
        <a class="dropdown-item" @click="$root.printOrder(slotProps.row.id, 'mobile')"><i class="fas fa-print"></i> Print Mobile</a>
        <a class="dropdown-item" @click="deleteOrder(slotProps.row.id, slotProps.index)"><i class="far fa-trash"></i> Delete</a>
      </template>

    </panel-template>

    <buy-details class="pan" :backToOrder="hid_details" :order_id="order_id_edite" v-if="show_details"/>

  </div>
</template>

<script>
import PanelTemplate from "../../components/admin/pan-content.vue";
import BuyDetails from "./buyDetails.vue";
export default {
  name: "Buy",
  components: {
    PanelTemplate,
    BuyDetails,
  },
  props: [

  ],
  data: function (){
    return {
      title: "Buys",
      thead: ["ID", "date", "Saller", "Num Product", "Poide", "Amount"],
      tbody:{
        data:{},
      },
      show_details: false,
    }
  }

}
</script>
