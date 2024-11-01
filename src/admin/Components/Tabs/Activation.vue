<template>
  <div>
    <div class="mb-6 text-center"></div>
    <div class="mb-6">
      <p class="mb-2">
        <strong>
          LEADsms integrates with your CONNECTsms account, allowing you to offer
          SMS/text help & support or generate leads from your WordPress site.
        </strong>
      </p>
      <p class="mb-2">
        To activate this plugin you will need to obtain your license key from
        your CONNECTsms account's settings accessed from the cog icon at the top
        right of the CONNECTsms application (look for "LEADsms License Key"). To
        login to your CONNECTsms,
        <a href="https://connectsms.ca/" target="_blank">click here</a>.
      </p>
      <p class="mb-2">
        No account? To learn more about CONNECTsms,
        <a
          href="https://localtextmarketers.com/canadian-business-texting/"
          target="_blank"
          >click here</a
        >.
      </p>
    </div>
    <div class="mb-8">
      <div class="flex gap-4 items-center">
        <label class="font-semibold whitespace-nowrap mb-1" for=""
          >License Key</label
        >
        <div
          class="flex flex-col w-[300px]"
          :class="{
            'has-error': validation.valid === false,
            'has-success': validation.valid,
          }"
        >
          <input
            class="w-full !leading-6 placeholder-gray-600 bg-white border rounded !p-2 w-100"
            placeholder="Enter your license key here"
            v-model="licenseKey"
          />
          <span class="help-text" v-if="validation.valid === false">{{
            validation.error
          }}</span>
        </div>
        <CheckIcon v-if="validation.valid" />
      </div>
      <div class="ml-[92px]">
        <span :class="{ 'text-green-600': validation.valid }">
          {{ validation.validating ? "" : validation.valid ? "Activated" : "" }}
        </span>
      </div>
    </div>
    <div class="text-right">
      <button
        class="min-w-[160px] rounded-md bg-brand-orange p-2 px-4 text-white"
        :class="{ 'disabled:opacity-50': !licenseKey }"
        @click="validate()"
        :disabled="!licenseKey"
      >
        <LoadingIcon v-if="validation.validating" />
        {{ validation.validating ? "Activating..." : "Save Changes" }}
      </button>
    </div>
  </div>
</template>
<script setup>
import { ref, computed } from "vue";
import LoadingIcon from "../Common/LoadingIcon.vue";
import CheckIcon from "../Common/CheckIcon.vue";
import { useStore } from "../../store";

const store = useStore();

// console.log("store.licenseInfo", store.licenseInfo)
const licenseKey = ref(store.licenseInfo ? store.licenseInfo.licensekey : "");
const validation = ref({
  valid: store.licenseInfo ? store.licenseInfo.valid : null,
  error: store.licenseInfo ? store.licenseInfo.error : "",
  validating: false,
});

const isInvalid = computed(() => {
  return validation.valid === false;
});

const validate = () => {
  validation.value.validating = true;
  store.validateLicense(licenseKey.value, (resp) => {
    validation.value = resp;
    validation.value.validating = false;
  });
};
// console.log("activation ...", window.LeadSMSAppAjax.app, window.LeadSMS)
</script>
