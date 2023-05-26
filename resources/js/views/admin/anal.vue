<template>
  <div class="anal">
    <div class="panel-anal">
      <h4 class="title">Total product Montant</h4>
      <div class="icon">

      </div>
      <div class="info">
        <span class="value" v-bind="mont"></span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AnalyticsDash",
  data: function (){
    return {
      mont: 0,
    }
  },
  methods: {
    getData (){
      axios.post("/api/anal").then(resp=>{
        console.log(resp)
      })
    }
  },
};
</script>
