import Vue from 'vue'
import VueRouter from 'vue-router'
import homePage from './vue/components/pages/homePage.vue'
import BrgyWorkerPage from './vue/components/pages/BrgyWorkerPage.vue'
import CitizenPage from './vue/components/pages/CitizenPage.vue'
import ServicePage from './vue/components/pages/ServicePage.vue'
import AnnouncementPage from './vue/components/pages/AnnouncementPage.vue'
import GeneratedCitListSubPage from './vue/components/pages/subPages/generatedCitList.vue'
import ViewServiceDetails from './vue/components/pages/subPages/viewServiceDetails.vue'
import LoginPage from './vue/components/pages/LoginPage.vue'
Vue.use(VueRouter)

const routes = [
  //project routes

    //admin
      // {
      //     path: '/',
      //     name: "Home",
      //     component: homePage
      // },
      {
        path: '/login',
        name: "Login",
        component: LoginPage
      },
    {
        path: '/',
        name: "BrgyWorker",
        component: BrgyWorkerPage
    },
    {
      path: '/citizens',
      name: "Citizen",
      component: CitizenPage
  },
  ,
    {
      path: '/services',
      name: "Service",
      component: ServicePage,
  },
  ,
    {
      path: '/announcements',
      name: "Announcement",
      component: AnnouncementPage
  },
    {
      path: '/generatedList',
      name: "GeneratedList",
      component: GeneratedCitListSubPage
  },
  {
    path: '/services/serviceDetails/:id',
    name: "ServiceDetail",
    component: ViewServiceDetails
},
]

export default new VueRouter({
    mode: 'history',
    routes
})