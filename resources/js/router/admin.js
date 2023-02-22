import { createRouter, createWebHistory } from "vue-router";

// file import
import login from "../views/LoginView.vue";
import HomeDashboard from "../views/DashboardView.vue";

// children
import dashBoard from "../views/dashView/dashboard.vue";
import order from "../views/dashView/order.vue";
import product from "../views/dashView/product.vue";
import cat from "../views/dashView/cat.vue";
import user from "../views/dashView/user.vue";
import saller from "../views/dashView/saller.vue";
import anal from "../views/dashView/anal.vue";
import setting from "../views/dashView/setting.vue";

const routes = [
  {
    path: "/",
    name: "login",
    component: login,
  },
  {
    path: "/dashboard",
    name: "HomeDashboard",
    component: HomeDashboard,
    children: [
      {
        path: "",
        component: dashBoard,
      },
      {
        path: "order",
        component: order,
      },
      {
        path: "product",
        component: product,
      },
      {
        path: "cat",
        component: cat,
      },
      {
        path: "user",
        component: user,
      },
      {
        path: "saller",
        component: saller,
      },
      {
        path: "anal",
        component: anal,
      },
      {
        path: "setting",
        component: setting,
      },
    ],
  },
];

const router = createRouter({
  mode: "history",
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
