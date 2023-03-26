<template>
  <tr class="item">
    <td>
      <div class="select">
        <input type="checkbox" />
      </div>
    </td>
    <td>
      <p class="name">margarin sole 500g</p>
      <div class="qte-gout">
        <h6>Qte:</h6>
        <p class="gout spb"><span class="gout">Frais</span>: <span class="value">3</span></p>
        <p class="gout spb"><span class="gout">Pomme</span>: <span class="value">2</span></p>
      </div>
    </td>
    <td>
      <div class="prix">
        <div class="prix-u mb-2"><span>Prix U: </span><span class="value">198,00</span></div>
        <div class="qte">
          <span>QteT: </span>
          <input class="d-none" type="number" name="" />
          <span>4</span>
        </div>
        <div class="prix-t"><span>Prix T: </span><span class="value">4752</span></div>
      </div>
    </td>
    <td>
      <div class="opt dropdown">
        <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
          <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
            <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#prod-info">edit</a>
            <a href="#" class="dropdown-item">deleat</a>
          </div>
        </i>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  name: "StoreItem",
  props: ["show_prod"],
};
</script>
