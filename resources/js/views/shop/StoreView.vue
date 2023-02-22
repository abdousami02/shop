<template>
  <div class="stor">
    <div class="container">
      <nav class="nav-links">
        <a href="#" class="linkd">Home</a> /
        <a href="#" class="linkd">Store</a>
      </nav>
      <!-- star select order & info -->
      <div class="order-det">
        <div class="num">
          <h4 class="d-inline-block">Command No: <span v-text="order_num"></span></h4>
          <br />
          <div class="sel-order">
            <select class="form-select order-select form-select-sm mb-2 d-block" v-model="order_num" aria-label="Default select example">
              <option value="None" selected>none</option>
              <option value="142">142 (pending)</option>
              <option value="425">425 (pending)</option>
            </select>
            <button type="button" class="btn btn-primary btn-sm"><i class="fas fa-pen"></i> edit</button>
            <button type="button" class="btn btn-success btn-sm ms-2"><i class="fal fa-plus"></i> Add</button>
          </div>
          <p class="order-date">created at: <br /><span>25/01/2023-12:32</span></p>
        </div>
      </div>
      <!-- start select family & categorie & search -->
      <div class="opt-prod">
        <!-- select option -->
        <select-option />
        <!-- search -->
        <search />
      </div>
      <!-- start totale prix -->
      <div class="shop-prix">
        <h5>Totale Prix :</h5>
        <div class="mon"><span class="num">1834,00</span><span class="cur"> DA</span></div>
      </div>
      <!-- start tabel mobile -->
      <table class="table table-bordered tab-mobile">
        <thead>
          <tr>
            <th class="image">image</th>
            <th class="name">name</th>
            <th class="q-u">Prix</th>
            <th class="opt"></th>
          </tr>
        </thead>
        <tbody>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Margarin Sol 500g</p>
              <p class="q-u">Q<sub>U/C: </sub><span class="value">6</span></p>
            </td>
            <td>
              <div class="prix">
                <div class="prix-u"><span>Prix U: </span><span class="value">198,00</span></div>
                <div class="qte"><span>Qte: </span><input type="number" name="" /></div>
                <div class="prix-t"><span>Prix T: </span><span class="value">14752,00</span></div>
              </div>
            </td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button><br />
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Fanta 1L</p>
              <p class="q-u">Q<sub>U/C: </sub><span class="value">6</span></p>
              <div class="gout">
                <p class="m-0">Goute:</p>
                <select class="form-select form-select-sm" style="width: 100px" aria-label="Default select example">
                  <option value="Categorie" selected>Frais</option>
                  <option value="2">Pomme</option>
                  <option value="3">Orange</option>
                  <option value="3">Ananas</option>
                </select>
              </div>
            </td>
            <td>
              <div class="prix">
                <div class="prix-u"><span>Prix U:</span><span class="value text-end">88,00</span></div>
                <div class="qte"><span>Qte: </span><input type="number" name="" /></div>
                <div class="qte-gout">
                  <p class="gout"><span class="gout">Frais</span>: <span class="value">3</span></p>
                  <p class="gout"><span class="gout">Pomme</span>: <span class="value">2</span></p>
                </div>
                <div class="prix-t"><span>Prix T: </span><span class="value">4752,00</span></div>
              </div>
            </td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button><br />
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Margarin Sol 500g</p>
              <p class="q-u">Q<sub>U/C: </sub><span class="value">6</span></p>
            </td>
            <td>
              <div class="prix">
                <div class="prix-u"><span>Prix U: </span><span class="value">198,00</span></div>
                <div class="qte"><span>Qte: </span><input type="number" name="" /></div>
                <div class="prix-t"><span>Prix T: </span><span class="value">4752,00</span></div>
              </div>
            </td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button><br />
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Fanta 1L</p>
              <p class="q-u">Q<sub>U/C: </sub><span class="value">6</span></p>
              <div class="gout">
                <p class="m-0">Goute:</p>
                <select class="form-select form-select-sm" style="width: 100px" aria-label="Default select example">
                  <option value="Categorie" selected>Frais</option>
                  <option value="2">Pomme</option>
                  <option value="3">Orange</option>
                  <option value="3">Ananas</option>
                </select>
              </div>
            </td>
            <td>
              <div class="prix">
                <div class="prix-u"><span>Prix U:</span><span class="value text-end">88,00</span></div>
                <div class="qte"><span>Qte: </span><input type="number" name="" /></div>
                <div class="qte-gout">
                  <p class="gout"><span class="gout">Frais</span>: <span class="value">3</span></p>
                  <p class="gout"><span class="gout">Pomme</span>: <span class="value">2</span></p>
                </div>
                <div class="prix-t"><span>Prix T: </span><span class="value">4752,00</span></div>
              </div>
            </td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button><br />
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Margarin Sol 500g</p>
              <p class="q-u">Q<sub>U/C: </sub><span class="value">6</span></p>
            </td>
            <td>
              <div class="prix">
                <div class="prix-u"><span>Prix U: </span><span class="value">198,00</span></div>
                <div class="qte"><span>Qte: </span><input type="number" name="" /></div>
                <div class="prix-t"><span>Prix T: </span><span class="value">4752,00</span></div>
              </div>
            </td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button><br />
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Fanta 1L</p>
              <p class="q-u">Q<sub>U/C: </sub><span class="value">6</span></p>
              <div class="gout">
                <p class="m-0">Goute:</p>
                <select class="form-select form-select-sm" style="width: 100px" aria-label="Default select example">
                  <option value="Categorie" selected>Frais</option>
                  <option value="2">Pomme</option>
                  <option value="3">Orange</option>
                  <option value="3">Ananas</option>
                </select>
              </div>
            </td>
            <td>
              <div class="prix">
                <div class="prix-u"><span>Prix U:</span><span class="value text-end">88,00</span></div>
                <div class="qte"><span>Qte: </span><input type="number" name="" /></div>
                <div class="qte-gout">
                  <p class="gout"><span class="gout">Frais</span>: <span class="value">3</span></p>
                  <p class="gout"><span class="gout">Pomme</span>: <span class="value">2</span></p>
                </div>
                <div class="prix-t"><span>Prix T: </span><span class="value">4752</span></div>
              </div>
            </td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button><br />
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- start table pc -->
      <table class="table table-bordered tab-pc table-hover">
        <thead>
          <tr>
            <th class="image">image</th>
            <th class="name">name</th>
            <th class="q-u">Prix Unit</th>
            <th class="qte-u">Q<sub>U/C: </sub></th>
            <th class="qte">Qte</th>
            <th class="prix-t">Prix Tot</th>
            <th class="opt">de</th>
          </tr>
        </thead>
        <tbody>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Margarin Sol 500g</p>
            </td>
            <td class="prix-u"><span class="num">198</span></td>
            <td class="q-u"><span class="num">24</span></td>
            <td class="qte"><input type="number" name="" /></td>
            <td class="prix-t"><span class="num">4752</span></td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button>
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p>Fanta 1L</p>
              <div class="gout">
                <p class="m-0">Goute:</p>
                <select class="form-select form-select-sm" style="width: 100px" aria-label="Default select example">
                  <option value="Categorie" selected>Frais</option>
                  <option value="2">Pomme</option>
                  <option value="3">Orange</option>
                  <option value="3">Ananas</option>
                </select>
              </div>
            </td>
            <td class="prix-u"><span class="num">88</span> DA</td>
            <td class="q-u"><span class="num">6</span></td>
            <td class="qte">
              <input type="number" name="" />
              <div class="qte-gout">
                <p class="gout"><span class="gout">Frais</span>: <span class="num">3</span></p>
                <p class="gout"><span class="gout">Pomme</span>: <span class="num">2</span></p>
              </div>
            </td>
            <td class="prix-t"><span class="num">528</span> DA</td>
            <td>
              <div class="opt dropdown">
                <button type="button" class="btn btn-primary">ok</button>
                <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                  <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                    <a href="#" class="dropdown-item">info</a>
                  </div>
                </i>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <!-- start next and previes page -->
      <a href="/orders/orderDetails" class="submit btn btn-success">Check Orders</a>
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import search from "../../components/shop/item/SearchProd.vue";
import selectOption from "../../components/shop/item/selectOpt.vue";
// import item from "../components/item/StoreItem.vue";
export default {
  name: "StorePage",
  data: function () {
    return {
      order_num: "None",
    };
  },
  components: {
    search,
    selectOption,
    // item,
  },
};
</script>

<style lang="scss">
body {
  font-size: 0.9rem !important;
}
.nav-links {
  margin: 10px 0;
}

.opt-prod {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 15px 0;
}
.cat-select,
.fami-select {
  max-width: 150px;
  margin-right: 10px;
}
.order-select {
  max-width: 150px;
}
.order-det {
  padding: 10px;
  background: #ffd044bd;
  border-radius: 10px;

  .num {
    position: relative;

    h4 {
      font-size: 18px;
    }
  }
  .order-date {
    position: absolute;
    right: 0;
    top: 0;
  }
}
.shop-prix {
  position: sticky;
  top: 0;
  z-index: 10;
  display: flex;
  justify-content: space-between;
  background: #cff4fc;
  padding: 10px;
  border-radius: 10px;
  margin-bottom: 15px;
  margin-top: -10px;

  .mon {
    font-size: 18px;
    font-weight: 600;
  }
}
table {
  width: 100%;
  font-size: 14px;
  th.q-u {
    max-width: 50px;
  }
  th.prix-u,
  th.prix-t,
  th.q {
    width: 100px;
  }
  .tab-pc {
    display: none;
  }
  .qte input {
    width: 50px;
  }
  .dot-opt {
    padding: 8px 16px;
    border-radius: 50%;
    float: right;
    line-height: 20px;
    cursor: pointer;
    &:hover {
      background: #eee;
    }
  }
}
.tab-mobile {
  td {
    height: 10px;
  }
  .prix {
    min-width: 100px;
    height: 100%;
    display: flex;
    flex-direction: column;
    & > div {
      display: flex;
      justify-content: space-between;
      margin-bottom: 7px;
    }
    .qte {
      display: flex;
      justify-content: space-between;
    }
    .prix-t {
      background-color: #d1e7dd;
      padding: 4px;
      border-radius: 5px;
      margin-top: auto;
      flex-wrap: wrap;
      .value {
        font-weight: 600;
        margin-left: auto;
      }
    }
  }
  .opt {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
  }
}
.qte-gout {
  flex-direction: column;
  padding-left: 10px;
  .gout {
    margin: 0;
  }
}
.gout {
  display: flex;
  align-items: center;
  margin-top: -5px;
  flex-wrap: wrap;
  select {
    margin-left: auto;
  }
}
.tab-pc {
  display: none;
  .qte-gout {
    border-bottom: none;
    margin-bottom: 0;
  }
}
.submit {
  position: sticky;
  bottom: 5px;
  margin-bottom: 20px;
}
.pagination {
  float: right;
}
.table-hover > tbody > tr:hover > * {
  --bs-table-accent-bg: rgba(0, 0, 0, 0.04) !important;
}
@media (min-width: 992px) {
  .opt-prod {
    flex-direction: row;
  }
  .tab-mobile {
    display: none;
  }
  .tab-pc {
    display: table;
  }
  .tab-pc {
    th.opt {
      width: 100px;
    }
  }
}
</style>
