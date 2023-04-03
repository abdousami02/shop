<template>
  <div class="setting">
    <div class="row saller">
      <div class="col-3 param">
        <h3>Saller :</h3>
        <div class="order">
          <p>
            <b>price product: </b>
            <select class="form-select" v-if="all_setting.order_saller" v-model="setting_set.order_saller.set_price_sell">
              <option v-for="elem in all_setting.order_saller.set_price_sell"
                      :key="elem"
                      :value="elem.value">{{elem.name}}</option>
            </select>
          </p>
          <button class="btn btn-success" @click="setSetting(setting_set.order_saller, 'order_saller')">Ok</button>
        </div>
      </div>
      <div class="col">

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "settingDash",
  data: function(){
    return {
      all_setting: {},
      setting_set: {order_saller:{}},
      not: {},
    };
  },
  methods: {
    getOrigin(){
      axios.post("/api/admin/setting", {action: "getOrigin", all: true}).then(resp=>{
        console.log(resp);
        if(resp.data.status == 'done'){
          this.handel(resp.data.data);
        }
      });
    },
    handel(data){
      data.forEach(elem => {
        this.all_setting[elem.section] = JSON.parse(elem.value);
      });
    },

    // setting set in DB
    getSetting(){
      axios.post("/api/admin/setting", {action: "getSetting", all: true}).then(resp=>{
        console.log(resp);
        if(resp.data.status == "done"){
          resp.data.data.forEach(elem=>{
            this.setting_set[elem.section][elem.param] = elem.value;
          });
          // this.setting_set = resp.data.data;
        }
      });
    },
    setSetting(data, section){
      axios.post("/api/admin/setting", {action: "setSetting", section: section, data: data}).then(resp=>{
        console.log(resp);
      })
    }
  },
  mounted: function(){
    this.getOrigin();
    this.getSetting();
  }
};
</script>
