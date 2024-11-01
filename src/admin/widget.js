import LeadSMS from "./Bits/LeadSMS";
import Widget from "./Components/Widget.vue";

const framework = new LeadSMS();

framework.app.config.globalProperties.appVars = window.LeadSMSAdmin;

framework.app.component("Widget", Widget);

window.LeadSMSApp = framework.app.mount("#LEADSMS_widget");
window.LeadSMSAppAjax = framework;
