<template>
  <div class="footer">
    <div class="container">
      <p>CopyRight &copy; 2023 - <a href="/">Badni Shop</a>, All Rights Riserved</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "footer-nav",
};
</script>

<style lang="scss">
.footer {
  position: absolute;
  width: 100%;
  bottom: 0;
  text-align: center;
  background: #103262;
  color: #fff;
  padding: 10px 0;
  margin-top: auto;
  z-index: 20;
  p {
    margin: 0;
    a {
      color: #f3a620;
    }
  }
}
</style>
