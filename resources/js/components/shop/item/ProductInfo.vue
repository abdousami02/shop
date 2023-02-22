<template>
  <div class="prod">
    <div class="modal fade" id="prod-info" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Product Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- name -->
            <p class="name-prod">Margarin Sole 250g</p>
            <!-- images -->
            <div class="image">
              <div class="img-first"><img src="" alt="img1" /></div>
              <div class="img-all">
                <img src="" alt="img" />
                <img src="" alt="img" />
                <img src="" alt="img" />
              </div>
            </div>
            <!-- category -->
            <div class="cat-famil">
              <p class="cat">Category: <span class="value">Alimantation</span></p>
              <p class="famil">Famille: <span class="value">Les Pates</span></p>
            </div>
            <!-- Price -->
            <div class="prices">
              <p class="price-vent">PrixU<sub>1 </sub>: <span class="value">597,00</span></p>
              <p class="price-vent">PrixU<sub>2 </sub>: <span class="value">470,00</span></p>
            </div>
            <div class="qte-txt">
              <p>Qte U/<sub>C</sub> : <span class="value">12</span></p>
            </div>
            <!-- Qte & gout -->
            <div class="qte-goute">
              <div class="qte-inp"><span>Qte: </span><input type="number" name="qte" id="qte" /></div>
              <div class="goute-sel">
                <span>Goute: </span>
                <select name="goute" id="" class="form-select select-cat">
                  <option value="">Frais</option>
                  <option value="">Pomme</option>
                  <option value="">Orange</option>
                  <option value="">Banan</option>
                  <option value="">Ananas</option>
                </select>
              </div>
              <button class="btn btn-primary">OK</button>
            </div>
            <!-- goutes selected -->
            <div class="goutes-sel">
              <p>Goutes selected:</p>
              <div class="qte-txt">
                <span class="name">Frais: </span>
                <span class="value">3</span>
                <i class="far fa-trash-alt delet"></i>
              </div>
              <div class="qte-txt">
                <span class="name">Pomme: </span>
                <span class="value">1</span>
                <i class="far fa-trash-alt delet"></i>
              </div>
              <div class="qte-txt">
                <span class="name">Ananas: </span>
                <span class="value">4</span>
                <i class="far fa-trash-alt delet"></i>
              </div>
            </div>
            <div class="qte-txt">
              <p>QteT: <span class="value">8</span></p>
            </div>
            <div class="prix-t">
              <span>Prix T</span>
              <span class="value">3552,45</span>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Canccel</button>
            <button type="button" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProducInfo",
};
</script>

<style lang="scss">
.modal-body {
  max-width: 400px;
  width: 100%;
  margin: auto;
}
.prod {
  font-size: 16px;
  .name-prod {
    text-align: center;
    font-size: 20px;
    font-weight: 600;
  }
  .img-first {
    width: 100%;
    max-width: 350px;
    border: 1px solid #ccc;
    margin: auto;
    text-align: center;
    min-height: 200px;
    background: #eee;
    border-radius: 5px;
    padding: 5px;
  }
  .img-all {
    text-align: center;
    img {
      max-width: 100px;
      margin: 5px;
      border: 1px solid #ccc;
      padding: 5px;
    }
  }
  .cat-famil {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
  }
  .prices {
    max-width: 200px;
    margin-top: 20px;
    .value {
      float: right;
    }
  }
  .qte-goute {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .goutes-sel {
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
    margin: 10px 15px;
    padding: 10px;
    p {
      font-size: 16px;
      font-weight: 600;
    }
  }
  .prix-t {
    font-size: 18px;
  }
}
</style>
