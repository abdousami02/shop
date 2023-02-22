<template>
  <div class="landing mt-4">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 d-xl-block d-none">
          <div class="lan-left">
            <img src="img/soummam.jpg" alt="." />
          </div>
        </div>
        <div class="col-xl-8">
          <div class="row">
            <div class="col">
              <div id="carouselExample" class="carousel slide" style="height" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="4" aria-label="Slide 5"></button>
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="5" aria-label="Slide 6"></button>
                  <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="6" aria-label="Slide 7"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item">
                    <img src="img/bifa-daily2.jpg" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item active">
                    <img src="img/skor.png" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="img/mama2.png" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="img/maxon2.jpg" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="img/kool2.jpg" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="img/elio.png" class="d-block w-100" alt="..." />
                  </div>
                  <div class="carousel-item">
                    <img src="img/loya-family2.png" class="d-block w-100" alt="..." />
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="slider">
                <div class="btn-slider btn-left"><i class="fad fa-chevron-circle-left"></i></div>
                <div class="btn-slider btn-right"><i class="fad fa-chevron-circle-right"></i></div>
                <div class="content">
                  <div class="item">
                    <div class="image">
                      <img src="img/mordjan.jpg" alt="." />
                    </div>
                    <div class="name"><span>Assila Mordjan 1KG</span></div>
                    <div class="price">
                      <p class="old">170 DA</p>
                      <p class="new">155 DA</p>
                    </div>
                  </div>
                  <div class="item">
                    <div class="image">
                      <img src="img/noor.jpg" alt="." />
                    </div>
                    <p class="name">mayounais noor 450ml</p>
                    <div class="price">
                      <p class="old">230 DA</p>
                      <p class="new">185 DA</p>
                    </div>
                  </div>
                  <div class="item">
                    <div class="image">
                      <img src="img/sol2.jpg" alt="." />
                    </div>
                    <p class="name">margarine sole 500g</p>
                    <div class="price">
                      <p class="old">210 DA</p>
                      <p class="new">195 DA</p>
                    </div>
                  </div>
                  <div class="item">
                    <div class="image">
                      <img src="img/pril.jpg" alt="." />
                    </div>
                    <p class="name">pile isis 750ml</p>
                    <div class="price">
                      <p class="old">170 DA</p>
                      <p class="new">160 DA</p>
                    </div>
                  </div>
                  <div class="item">
                    <div class="image">
                      <img src="img/loya.jpg" alt="." />
                    </div>
                    <p class="name">loya lait poudre 500g</p>
                    <div class="price">
                      <p class="old">600 DA</p>
                      <p class="new">570 DA</p>
                    </div>
                  </div>
                  <div class="item">
                    <div class="image">
                      <img src="img/1.jpg" alt="." />
                    </div>
                    <p class="name">isis poudre 320g</p>
                    <div class="price">
                      <p class="old">100 DA</p>
                      <p class="new">85 DA</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "landingCom",
};

// let btn_left = document.querySelector(".btn-left")[0],
//   btn_right = document.querySelector(".btn-right"),
//   slider = document.querySelector(".slider");
// let pos;
// btn_left.addEventListener("click", function(){
//   console.log('hi')
// })
</script>

<style lang="scss">

.lan-left img {
  width: 100%;
}
.slider {
  overflow: hidden;
  position: relative;
  margin-top: 15px;

  .btn-slider {
    position: absolute;
    z-index: 3;
    display: flex;
    width: 35px;
    height: 100%;
    align-items: center;
    font-size: 28px;
    cursor: pointer;

    &.btn-left {
      left: 0;
      background-image: linear-gradient(to right, rgba(0, 0, 0, 0.17), rgba(0, 0, 0, 0));
      padding-left: 10px;
    }
    &.btn-right {
      right: 0;
      background-image: linear-gradient(to left, rgba(0, 0, 0, 0.17), rgba(0, 0, 0, 0));
      padding-right: 10px;
    }
  }

  .content {
    display: flex;
    position: relative;
    justify-content: flex-start;
    width: 200%;

    .item {
      width: 160px;
      margin-right: 14px;
      padding: 10px;
      background: #fff;

      .image {
        width: 120px;
        height: 145px;
        overflow: hidden;
      }

      .name {
        height: 55px;
        overflow: hidden;
        font-size: 16px;
        margin-bottom: 5px;
        text-align: center;
      }

      .price {
        .old {
          text-align: center;
          margin: 6px 0 0;
          font-size: 15px;
          width: fit-content;
          position: relative;

          &::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 1px;
            background: red;
            left: -6px;
            transform: rotate(13deg);
            top: 13px;
          }
        }
        .new {
          width: fit-content;
          padding: 0 5px;
          margin: auto;
          font-size: 20px;
          background: yellow;
        }
      }
    }
    img {
      width: 100%;
    }
  }
}
</style>
