const request = function (method, route, data = {}) {
  // console.log("LEADSMSAdmin", window, window.LEADSMSAdmin)
  // const url = `${window.LeadSMS.rest.url}/${route}`;
  const url = `${window.LEADSMSAdmin.ajaxurl}`;
  const _wpnonce = window.LEADSMSAdmin._wpnonce;
  const _wpnonce_admin = window.LEADSMSAdmin._wpnonce_admin;

  const headers = {};

  if (window.LeadSMS) {
    headers["X-WP-Nonce"] = window.LeadSMS.rest.nonce;
  }

  if (["PUT", "PATCH", "DELETE"].indexOf(method.toUpperCase()) !== -1) {
    headers["X-HTTP-Method-Override"] = method;
    method = "POST";
  }

  data.action = route;

  if (route == "get_plugin_options") {
    data._wpnonce = _wpnonce;
  } else if (route == "send_message") {
    data._wpnonce = _wpnonce;
  } else {
    data._wpnonce = _wpnonce_admin;
  }

  return window.jQuery.ajax({
    url: url,
    type: method,
    data: data,
    headers: headers,
  });
};

export default {
  get(route, data = {}) {
    return request("GET", route, data);
  },
  post(route, data = {}) {
    return request("POST", route, data);
  },
  delete(route, data = {}) {
    return request("DELETE", route, data);
  },
  put(route, data = {}) {
    return request("PUT", route, data);
  },
  patch(route, data = {}) {
    return request("PATCH", route, data);
  },
};

jQuery(document).ajaxSuccess((event, xhr, settings) => {
  const nonce = xhr.getResponseHeader("X-WP-Nonce");
  if (nonce) {
    window.LeadSMS.rest.nonce = nonce;
  }
});
