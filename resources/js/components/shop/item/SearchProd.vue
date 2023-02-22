<template>
  <div class="search">
    <form class="d-flex search-prod" role="search">
      <div class="inp">
        <input @focus="show" @blur="hid" class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
        <ul class="out-search">
          <li>
            <a href="#" class="nav-link">caffe Famico 250g<span class="value">213,54</span></a>
          </li>
          <li>
            <a href="#" class="nav-link">caffe Aroma 250g<span class="value">213,54</span></a>
          </li>
          <li>
            <a href="#" class="nav-link">caffe 1001 250g<span class="value">213,54</span></a>
          </li>
        </ul>
      </div>
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "SearchPrdo",
  data: function () {
    return {
      pass: "",
    };
  },
  methods: {
    show(e) {
      console.log(e.target.nextSibling);
      e.target.nextSibling.style.display = "block";
    },
    hid(e) {
      e.target.nextSibling.style.display = "none";
    },
  },
};
</script>

<style lang="scss">
.search {
  margin-bottom: 10px;
  form {
    display: flex;
    justify-content: space-between;
    .inp {
      flex-basis: 85%;
      position: relative;
    }
    .out-search {
      display: none;
      background: #fff;
      width: calc(100% - 10px);
      margin: 0 5px;
      border-bottom-right-radius: 7px;
      border-bottom-left-radius: 7px;
      padding: 5px 10px;
      position: absolute;
      z-index: 20;
      li {
        border-bottom: 1px solid #ccc;
        margin-bottom: 10px;
        .value {
          float: right;
        }
      }
    }
  }
}
</style>
