<template>
  <div
    class="leadsms-widget"
    :style="{
      width: store.options.appearance.width + 'px',
      height: store.options.appearance.height + 'px',
    }"
    v-if="!loading"
  >
    <div
      class="leadsms-widget-header"
      :style="{ backgroundColor: store.options.appearance.colors.header.bg }"
    >
      <p :style="{ color: store.options.appearance.colors.header.text }">
        {{ store.options.appearance.headerText }}
      </p>
    </div>
    <div
      class="leadsms-widget-main"
      :style="{ backgroundColor: store.options.appearance.colors.body.bg }"
    >
      <div
        class="leadsms-widget-main-form-top"
        :style="{ backgroundColor: store.options.appearance.colors.header.bg }"
      ></div>
      <div class="leadsms-widget-main-form" :class="{ invalid: invalid }">
        <div v-if="!thankyou">
          <div class="leadsms-form-field" :class="{ 'has-error': !form.name }">
            <label>Name *</label>
            <input type="text" v-model="form.name" maxlength="150" />
          </div>
          <div
            class="leadsms-form-field"
            :class="{ 'has-error': !form.phone || form.phone === '1' }"
          >
            <label>Cell Phone (we'll text you back) *</label>
            <input type="text" v-model="form.phone" @input="phFormat" />
          </div>
          <div
            class="leadsms-form-field no-margin-bottom"
            :class="{ 'has-error': !form.message }"
          >
            <label>Message *</label>
            <textarea maxlength="255" v-model="form.message"></textarea>
          </div>
          <p class="small-text">
            * By submitting this form you consent to receive text messages from
            us. Reply STOP to end messaging. Message/data rates may apply.
          </p>
          <div class="submit-btn">
            <button
              @click="onSubmit"
              :style="{
                borderColor: store.options.appearance.colors.button.color,
                color: store.options.appearance.colors.button.color,
              }"
            >
              {{
                submitting
                  ? "Submitting..."
                  : store.options.appearance.colors.button.text || "Submit"
              }}
            </button>
          </div>
          <p class="small-text">
            <span v-if="messageError" class="text-error">{{
              messageError
            }}</span>
          </p>
        </div>
        <div v-else>
          <p class="mb-2">
            Thank you! We have received your message and will respond as soon as
            possible within regular business hours.
          </p>
          <!-- <p><a href="#" class="leadsms-button-link" @click="sendAnother()">Send another message</a></p> -->
        </div>
      </div>
    </div>
    <div
      class="leadsms-widget-footer"
      :style="{ backgroundColor: store.options.appearance.colors.body.bg }"
      v-if="showPoweredBy"
    >
      <span
        >Powered by
        <a href="https://localtextmarketers.com/" target="_blank"
          >Local Text Marketers</a
        ></span
      >
    </div>
  </div>
</template>
<script setup>
import { reactive, ref, onMounted } from "vue";
import { useStore } from "../store";

const store = useStore();

let submitting = ref(false);
let invalid = ref(false);
let thankyou = ref(false);
let messageError = ref(null);
let loading = ref(false);
let showPoweredBy = ref(true);

const form = reactive({
  name: "",
  phone: "",
  message: "",
});

let errors = reactive([]);

const onSubmit = () => {
  errors = [];
  invalid.value = false;
  submitting.value = true;

  if (!form.name) errors.push("name");
  if (!form.phone || form.phone == "1") errors.push("phone");
  if (!form.message.trim()) errors.push("message");
  if (errors.length > 0) {
    invalid.value = true;
    submitting.value = false;
    return;
  }

  store.sendMessage(form, (resp) => {
    if (resp.success) {
      invalid.value = false;
      submitting.value = false;
      thankyou.value = true;
      messageError.value = null;

      setTimeout(() => {
        thankyou.value = false;
        form.message = "";
      }, 12000);
    } else {
      submitting.value = false;
      thankyou.value = false;
      messageError.value = resp.message;
    }
  });
};

const sendAnother = () => {
  thankyou.value = false;
};

const phFormat = () => {
  var phRaw = form.phone.replace(/[\D]+/g, "");
  var ph = phRaw;
  if (ph.substr(0, 1) != "1") {
    ph = "1" + ph;
  }
  var phArr = ph.split("", 11);
  var inserts = [" (", "", "", ") ", "", "", "-", "", "", "", ""];
  ph = "";
  for (let i = 0; i < phArr.length; i++) {
    ph += phArr[i] + inserts[i];
  }
  form.phone = ph;
};

onMounted(() => {
  loading.value = true;
  if (window) {
    setTimeout(() => {
      store.getOptions(() => {
        loading.value = false;
      });
    }, 1000);
  }
});
</script>
