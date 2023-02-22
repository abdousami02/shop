<template>
  <div class="add-prod">
    <!-- <div class="modal fade" id="add-prod"> -->
    <div class="modal fade" id="add-prod" tabindex="-1" aria-labelledby="add-prodLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title">Add Product</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- select option -->
            <select-option />
            <!-- search  -->
            <search />
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Canccel</button>
            <button class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import selectOption from "./selectOpt.vue";
import search from "./SearchProd.vue";
export default {
  name: "addProduct",
  components: {
    search,
    selectOption,
  },
};
</script>
