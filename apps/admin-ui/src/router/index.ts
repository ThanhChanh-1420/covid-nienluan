import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router"
import Home from "../views/Home.vue"
import Admin from "../views/admin/index.vue"
import Login from "../views/login/index.vue"
import AdminHome from "../views/admin_home/index.vue"
import PopulateManager from "../views/populate_manager/index.vue"
import Vaccine from "../views/vaccine/index.vue"

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "Home",
    component: Home
  },
  {
    path: "/admin",
    name: "Admin",
    component: Admin,
    children: [
      {
        path: "",
        name: "AdminHome",
        component: AdminHome
      },
      {
        path: "populate-manager",
        name: "PopulateManager",
        component: PopulateManager
      },
      {
        path: "vaccine",
        name: "Vaccine",
        component: Vaccine
      }
    ],
    meta: {
      isAuth: true
    }
  },
  {
    path: "/admin/login",
    name: "Login",
    component: Login
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from) => {
  const token = localStorage.getItem("token")
  if (to.meta.isAuth && !token) {
    return { name: "Login" }
  }
})

export default router
