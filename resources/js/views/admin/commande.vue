<template>
  <div class="commande">
    <panel-template
                    :title="title" :th="thead" :tb="tbody"
                    :getData_forPag="getData"
                    :addData_func="addData"
                    :editData_func="editeData"
                    :deleteData_func="deleteData"
                    :deleteMultiData_func="''" >

      <template #btns>
        <button class="btn btn-primary me-5 ms-2 mb-3 w-50" @click="backToOrder(); empty_tbody()"><i class="fas fa-long-arrow-left"></i></button>
        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fal fa-print"></i> Print
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click="$root.printOrder(order_id, 'a5')">A5</a></li>
          <li><a class="dropdown-item" href="#" @click="$root.printOrder(order_id, 'a4')">A4</a></li>
          <li><a class="dropdown-item" href="#" @click="$root.printOrder(order_id, 'mobile')">Mobile</a></li>
        </ul>
      </template>

      <template #header>
        <ul class="info-order header-order-detail">
          <li class="shop">
            <b>Store: </b><br>
            <div v-if="order_info.store_info">
              <span class="name">Name: <i>{{order_info.store_info.name}}</i></span><br>
              <span class="name">Address: <i>{{order_info.store_info.address}}</i></span>
            </div>
          </li>
          <li class="saller">
            <b>Saller: </b><br>
            <div v-if="order_info.saller">
              <span class="name">Name: <i>{{order_info.saller.name}}</i></span><br>
              <span class="name">Address: <i>{{order_info.saller.address}}</i></span>
              <span class="name">Mobile: <i>{{'0'+order_info.saller.user.mobile}}</i></span>
            </div>
          </li>
          <li class="status">
            <b>Status: </b><br>
            {{order_status[order_info.status]}}
          </li>
          <li class="amount">
            <b>Total: </b>{{ setNumber(order_info.amount)}} DA
          </li>
        </ul>
      </template>

      <template v-slot="slotProps" v-if="response.finish">

        <td class="image"><img :src="'/'+slotProps.row.product.image" alt=""  v-if="setting.image"></td>

        <td class="product-name info-order">
          <p><span class="name"  v-if="setting.id"><i>{{ slotProps.row.product.id}}</i></span><span class="name-lg">Name: <i>{{slotProps.row.product.name}}</i></span></p>
          <div v-if="setting.categorie">
            <span class="name">{{ response.categories[slotProps.row.product.categorie_id].name }}</span> <span class="name">{{ response.familles[slotProps.row.product.famille_id].name }}</span>
          </div>
        </td>

        <td class="price info-order">
          <b>Price: </b><input type="number" class="inp-price" :value="slotProps.row.price_sell">
          <div v-if="setting.all_price">
            <p><span class="name">Price 1: <i>{{ setNumber(slotProps.row.product.price_sell1) }}</i></span> <span></span></p>
            <p v-if="slotProps.row.product.price_sell2"><span class="name">Price 2:<i>{{ setNumber(slotProps.row.product.price_sell2) }}</i></span> <span>qte : <i>{{ slotProps.row.product.qte_sell2 }}</i></span></p>
            <p v-if="slotProps.row.product.price_sell3"><span class="name">Price 3:<i>{{ setNumber(slotProps.row.product.price_sell3) }}</i></span> <span>qte : <i>{{ slotProps.row.product.qte_sell3 }}</i></span></p>
          </div>
        </td>

        <td class="qte">
          <input type="number" class="inp-qte" :value="slotProps.row.qte">
          <span v-if="slotProps.row.order_detail_saller && slotProps.row.qte != slotProps.row.order_detail_saller.qte" class="qte-saller">{{slotProps.row.order_detail_saller.qte}}</span>
        </td>

        <td class="goute info-order">
          <span v-if="slotProps.row.order_detail_goute.length == 0">None</span>
          <ul>
            <li v-for="elem in slotProps.row.order_detail_goute" :key="elem">
              <span class="name"> <i>{{ elem.product_goute.goute }}</i></span> <span>{{elem.qte}}</span>,
            </li>
          </ul>
        </td>

        <td class="instock">
          <span @click="edite_stock(slotProps.row, slotProps.index)"
                :class="['status-btn', slotProps.row.in_stock == 1 ? 'active':'',
                          slotProps.row.order_detail_saller && slotProps.row.in_stock != slotProps.row.order_detail_saller.in_stock && slotProps.row.in_stock == 1 ? 'not' :'' ]" ></span><br>
          <span v-if="slotProps.row.order_detail_saller && slotProps.row.in_stock != slotProps.row.order_detail_saller.in_stock && slotProps.row.in_stock == 1 " class="text-danger">Not in Stock</span>

        </td>

        <td class="discount">
          <span v-if="!slotProps.row.discount">None</span>
        </td>

        <td class="price-total">{{ setNumber(slotProps.row.price_total) }} DA</td>
        <!-- <td class="status"><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td> -->
      </template>

      <template #footer>
        <div class="amount-detail" v-if="order_info.amount">
          <button class="btn btn-primary" @click="closeOrder"><i class="fas fa-lock"></i> Valide & Close</button>
          <span class="value">{{ setNumber(order_info.amount) }} DA</span>
        </div>
      </template>

    </panel-template>
  </div>
</template>

<script>
import PanelTemplate from "../../components/admin/pan-content.vue";
export default {
  name: "orderDetails",
  components: {
    PanelTemplate,
  },
  props: [
    'backToOrder',
    'order_id',
  ],
}
</script>
