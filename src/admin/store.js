import { defineStore } from "pinia";

export const useStore = defineStore("store", {
  state: () => {
    return {
      loading: false,
      licenseInfo: null,
      licenseChecked: false,
      options: {
        visibility: {
          inAllPages: true,
          homepageOnly: false,
          pagesOnly: false,
          postsOnly: false,
        },
        appearance: {
          width: 400,
          height: 580,
          headerText: "Send us a message and we'll text you back!",
          hidePoweredBy: false,
          colors: {
            header: {
              bg: "#2A9AD6",
              text: "#FFFFFF",
            },
            body: {
              bg: "#F7F7F9",
            },
            button: {
              outline: "#2A9AD6",
              text: "Submit",
              color: "#2A9AD6",
              type: "outline",
            },
            textUsButton: {
              bg: "#2A9AD6",
              text: "Text us",
              color: "#FFFFFF",
            },
          },
          popoverEnabled: true,
          popoverText: "Hi there, have a question? Text us here.",
          popoverDelay: 1,
        },
      },
    };
  },
  // could also be defined as
  // state: () => ({ count: 0 })
  actions: {
    validateLicense(licenseKey, callback) {
      console.log("window.LeadSMSAppAjax", window.LeadSMSAppAjax);
      window.LeadSMSAppAjax.$post("validate_license", {
        licensekey: licenseKey,
      })
        .then((resp) => {
          let data = JSON.parse(resp);
          this.licenseInfo = data;
          this.licenseChecked = true;
          callback(data);
        })
        .catch(() => {
          callback({
            valid: false,
            error: "Error validating license. Please reload and try again.",
          });
        });
    },
    getLicenseInfo(callback) {
      window.LeadSMSAppAjax.$get("get_license_info")
        .then((resp) => {
          this.licenseInfo = resp;
          this.licenseChecked = true;
          callback && callback();
        })
        .catch(() => {
          this.licenseInfo = null;
          this.licenseChecked = true;
        });
    },
    sendMessage(form, callback) {
      window.LeadSMSAppAjax.$post("send_message", {
        form: form,
      })
        .then((resp) => {
          let data = JSON.parse(resp);
          callback(data);
        })
        .catch(() => {
          callback({});
        });
    },
    getOptions(callback) {
      this.loading = true;
      window.LeadSMSAppAjax.$get("get_plugin_options")
        .then((resp) => {
          this.options = JSON.parse(resp);
          this.loading = false;
          callback && callback();
        })
        .catch(() => {
          this.loading = false;
        });
    },
    saveOptions() {
      this.loading = true;
      window.LeadSMSAppAjax.$post("save_plugin_options", this.options)
        .then((resp) => {
          this.loading = false;
        })
        .catch(() => {
          alert("Error saving options. Please reload and try again.");
          this.loading = false;
        });
    },
  },
});
