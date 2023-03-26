<template>
  <div class="select-prod">
    <select class="form-select form-select-sm cat-select" aria-label="Default select example">
      <option value="Categorie" selected>Categorie</option>
      <option value="2">Alimantation</option>
      <option value="3">Boisson</option>
    </select>
    <select class="form-select form-select-sm fami-select" aria-label="Default select example">
      <option value="Categorie" selected>Famille</option>
      <option value="2">cafe</option>
      <option value="3">Pates</option>
    </select>
  </div>
</template>

<script>
export default {
  name: "selectOption",
};
</script>

