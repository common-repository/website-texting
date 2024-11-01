import routes from "./routes";
import { createWebHashHistory, createRouter } from "vue-router";
import LeadSMS from "./Bits/LeadSMS";
import "../tailwind-assets/tailwind.css";

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

const framework = new LeadSMS();

framework.app.config.globalProperties.appVars = window.LeadSMSAdmin;

window.LeadSMSApp = framework.app.use(router).mount("#LEADSMS_app");
window.LeadSMSAppAjax = framework;

router.afterEach((to, from) => {
  jQuery(".LEADSMS_menu_item").removeClass("active");
  let active = to.meta.active;
  if (active) {
    jQuery(".LEADSMS_main-menu-items")
      .find("li[data-key=" + active + "]")
      .addClass("active");
  }
});
