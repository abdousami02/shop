import { createRouter, createWebHistory } from "vue-router";

// file import
import login from "../views/saller/LoginView.vue";
import HomeDashboard from "../views/saller/DashboardView.vue";

// children
import dashBoard from "../views/saller/dashboard.vue";
import order from "../views/saller/order.vue";
import product from "../views/saller/product.vue";
import anal from "../views/saller/anal.vue";
import setting from "../views/saller/setting.vue";

const routes = [
  {
    path: "/",
    name: "Login",
    component: login,
  },
  {
    path: "/dashboard",
    name: "Dashboard",
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
