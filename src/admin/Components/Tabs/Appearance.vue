<template>
  <div :class="{ disabled: !store.licenseInfo.valid || store.loading }">
    <div class="mb-6">
      <p class="mb-2">
        <strong>
          Customize the look and feel of your text widget (to watch your changes
          populate live, click the "Widget Preview" button at the bottom right).
        </strong>
      </p>
    </div>
    <div class="grid grid-cols-1 gap-4">
      <div class="mb-4 border p-4">
        <div class="flex flex-col gap-4">
          <label class="font-semibold whitespace-nowrap text-center" for=""
            >Header Text</label
          >
          <textarea
            class="border min-h-52 p-2"
            v-model="store.options.appearance.headerText"
            :maxlength="headerMaxLength"
          >
          </textarea>
          <span class="text-right -mt-3 text-gray-500"
            >{{ store.options.appearance.headerText.length }} /
            {{ headerMaxLength }}</span
          >
        </div>
      </div>
    </div>
    <div class="grid grid-cols-2 gap-4">
      <div>
        <div class="grid grid-cols-1 gap-4">
          <div class="mb-4 border p-4">
            <div class="grid grid-cols-2 gap-4">
              <div>
                <div class="flex flex-col gap-4">
                  <label
                    class="font-semibold whitespace-nowrap text-center"
                    for=""
                    >Width</label
                  >
                  <input
                    type="number"
                    class="w-full !leading-6 placeholder-gray-600 bg-white border rounded !p-2"
                    v-model="store.options.appearance.width"
                  />
                </div>
              </div>
              <div>
                <div class="flex flex-col gap-4">
                  <label
                    class="font-semibold whitespace-nowrap text-center"
                    for=""
                    >Height</label
                  >
                  <input
                    type="number"
                    class="w-full !leading-6 placeholder-gray-600 bg-white border rounded !p-2"
                    v-model="store.options.appearance.height"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div>
        <!-- <div class="mb-4 border p-4">
                    <div class="flex flex-col gap-4">
                        <label class="font-semibold whitespace-nowrap text-center" for="">Widget Position</label>
                        <select name="" id="" class="w-full !leading-6 placeholder-gray-600 bg-white border rounded !p-2">
                            <option value="Bottom Right">Bottom Right</option>
                            <option value="Bottom Left">Bottom Left</option>
                        </select>
                    </div>
                </div> -->
      </div>
    </div>
    <div class="grid grid-cols-1 gap-4">
      <div class="mb-4 border p-4 relative">
        <div class="flex flex-col gap-4 relative">
          <label class="font-semibold whitespace-nowrap text-center" for=""
            >Widget Form Settings</label
          >

          <div>
            <div class="grid grid-cols-2 gap-4">
              <div class="relative">
                <strong>Header</strong>
                <div class="flex flex-col">
                  <span>Background Color</span>
                  <input
                    class="border"
                    v-model="store.options.appearance.colors.header.bg"
                    id="header-bg-color-input"
                  />
                </div>
              </div>
              <div class="relative">
                <strong>Submit Button</strong>
                <div class="flex flex-col">
                  <span>Button Color</span>
                  <input
                    class="border"
                    v-model="store.options.appearance.colors.button.color"
                    id="button-color"
                  />
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="grid grid-cols-2 gap-4">
              <div class="relative">
                <strong>Body Background</strong>
                <div class="flex flex-col">
                  <span>Background Color</span>
                  <input
                    class="border"
                    v-model="store.options.appearance.colors.body.bg"
                    id="body-bg-color-input"
                  />
                </div>
              </div>

              <div class="relative">
                <div class="flex flex-col">
                  <span>Button Text</span>
                  <input
                    type="text"
                    class="border"
                    :maxlength="15"
                    v-model="store.options.appearance.colors.button.text"
                  />
                </div>
                <div class="text-right">
                  <small
                    >{{ store.options.appearance.colors.button.text.length }}/15
                    characters</small
                  >
                </div>
              </div>
            </div>
          </div>
          <div>
            <div class="grid grid-cols-2 gap-4">
              <div class="relative">
                <strong>Header Content</strong>
                <div class="flex flex-col">
                  <span>Text Color</span>
                  <input
                    class="border"
                    v-model="store.options.appearance.colors.header.text"
                    id="header-text-color-input"
                  />
                </div>
              </div>
              <div class="relative">
                <strong>Text Us Button</strong>
                <div class="flex gap-8">
                  <div class="flex flex-col">
                    <span>Button Color</span>
                    <input
                      class="border"
                      v-model="store.options.appearance.colors.textUsButton.bg"
                      id="textus-button-color"
                    />
                  </div>
                  <div class="flex flex-col">
                    <span>Text Color</span>
                    <input
                      class="border"
                      v-model="
                        store.options.appearance.colors.textUsButton.color
                      "
                      id="textus-text-color"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-4">
      <div class="mb-4 border p-4">
        <div class="flex flex-col gap-4">
          <label class="font-semibold whitespace-nowrap text-center" for=""
            >Popover Settings</label
          >
          <div class="mb-4 bg-sky-100 text-sky-700 p-3" role="alert">
            <div class="flex">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="w-8 h-8 mr-3"
              >
                <path
                  fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z"
                  clip-rule="evenodd"
                />
              </svg>
              <div>
                Pops open a small window to draw the visitor's attention to the
                contact form option. We recommend using a minimum of a 10-15
                second delay for your Popover.
              </div>
            </div>
          </div>
        </div>
        <div class="flex flex-col gap-4 mb-4">
          <label
            for="appearance-popover-enabled"
            class="flex items-center cursor-pointer"
          >
            <div class="pr-2">Enable Popover</div>
            <!-- toggle -->
            <div class="relative">
              <input
                id="appearance-popover-enabled"
                v-model="store.options.appearance.popoverEnabled"
                type="checkbox"
                class="hidden"
              />
              <!-- path -->
              <div
                class="toggle-path bg-gray-200 w-9 h-5 rounded-full shadow-inner"
              ></div>
              <!-- crcle -->
              <div
                class="toggle-circle absolute w-3.5 h-3.5 bg-white rounded-full shadow inset-y-0 left-0"
              ></div>
            </div>
          </label>
        </div>
        <div class="flex flex-col gap-4 mb-4">
          <label class="whitespace-nowrap" for="">Content</label>
          <textarea
            class="border min-h-[80px] p-2"
            v-model="store.options.appearance.popoverText"
            :maxlength="popoverMaxLength"
          >
          </textarea>
          <span class="text-right -mt-3 text-gray-500"
            >{{ store.options.appearance.popoverText.length }} /
            {{ popoverMaxLength }}</span
          >
        </div>

        <div class="flex flex-col gap-4 mb-4">
          <label class="whitespace-nowrap" for="">Delay (in seconds)</label>
          <input
            type="number"
            class="w-[80px] !leading-6 placeholder-gray-600 bg-white border rounded !p-2"
            v-model="store.options.appearance.popoverDelay"
          />
        </div>
      </div>
    </div>

    <div
      class="leadsms-widget-container"
      :class="{ 'widget-opened': showWidget }"
      :data-prompt-delay="store.options.appearance.popoverDelay"
      :data-prompt-enabled="store.options.appearance.popoverEnabled ? 1 : 0"
    >
      <div>
        <Widget />
      </div>
      <span class="leadsms-widget-preview-text">Widget Preview</span>
      <div class="leadsms-widget-launcher">
        <div
          class="leadsms-widget-prompt hidden"
          :class="{
            hidden: showWidget,
            hidden: !store.options.appearance.popoverEnabled,
          }"
        >
          <div class="content">
            <div>
              {{ store.options.appearance.popoverText }}
            </div>
            <span class="close-button" @click="closePrompt"
              ><svg
                width="12"
                height="12"
                viewBox="0 0 26 26"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M1 25L25 1M25 25L1 1"
                  stroke="#a1a1a1"
                  stroke-width="2.57753"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </span>
          </div>
        </div>
        <div
          class="leadsms-widget-bubble"
          :style="{
            backgroundColor: store.options.appearance.colors.textUsButton.bg,
          }"
        >
          <div class="leadsms-widget-launcher-icon" @click="toggleLauncher">
            <div
              class="leadsms-widget-launcher-icon-message"
              :class="{ hidden: showWidget }"
            >
              <svg
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <g clip-path="url(#clip0_607_117)">
                  <path
                    d="M20 2.00006H4C2.9 2.00006 2.01 2.90006 2.01 4.00006L2 22.0001L6 18.0001H20C21.1 18.0001 22 17.1001 22 16.0001V4.00006C22 2.90006 21.1 2.00006 20 2.00006ZM17 14.0001H7C6.45 14.0001 6 13.5501 6 13.0001C6 12.4501 6.45 12.0001 7 12.0001H17C17.55 12.0001 18 12.4501 18 13.0001C18 13.5501 17.55 14.0001 17 14.0001ZM17 11.0001H7C6.45 11.0001 6 10.5501 6 10.0001C6 9.45006 6.45 9.00006 7 9.00006H17C17.55 9.00006 18 9.45006 18 10.0001C18 10.5501 17.55 11.0001 17 11.0001ZM17 8.00006H7C6.45 8.00006 6 7.55006 6 7.00006C6 6.45006 6.45 6.00006 7 6.00006H17C17.55 6.00006 18 6.45006 18 7.00006C18 7.55006 17.55 8.00006 17 8.00006Z"
                    :fill="store.options.appearance.colors.textUsButton.color"
                  />
                </g>
                <defs>
                  <clipPath id="clip0_607_117">
                    <rect
                      width="24"
                      height="24"
                      :fill="store.options.appearance.colors.textUsButton.color"
                    />
                  </clipPath>
                </defs>
              </svg>
            </div>
            <div
              class="leadsms-widget-launcher-icon-close"
              :class="{ hidden: !showWidget }"
            >
              <svg
                width="16"
                height="16"
                viewBox="0 0 26 26"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M1 25L25 1M25 25L1 1"
                  :stroke="store.options.appearance.colors.textUsButton.color"
                  stroke-width="2.57753"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                />
              </svg>
            </div>
            <label
              :style="{
                color: store.options.appearance.colors.textUsButton.color,
              }"
              >{{ store.options.appearance.colors.textUsButton.text }}</label
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, onMounted } from "vue";
import { useStore } from "../../store";
import Widget from "../Widget.vue";

const store = useStore();
const showWidget = ref(false);
const initColors = ref(false);
const popoverMaxLength = ref(150);
const headerMaxLength = ref(150);

const toggleLauncher = () => {
  showWidget.value = !showWidget.value;
};

const closePrompt = () => {
  var $container = jQuery(".leadsms-widget-container");
  var $prompt = $container.find(".leadsms-widget-prompt");
  $prompt.addClass("hidden");
};

onMounted(() => {
  setTimeout(() => {
    jQuery("#header-bg-color-input").spectrum({
      type: "color",
      showInput: true,
      change: function (color) {
        store.options.appearance.colors.header.bg = color.toHexString();
      },
    });
    jQuery("#header-text-color-input").spectrum({
      type: "color",
      showInput: true,
      change: function (color) {
        store.options.appearance.colors.header.text = color.toHexString();
      },
    });
    jQuery("#body-bg-color-input").spectrum({
      type: "color",
      showInput: true,
      change: function (color) {
        store.options.appearance.colors.body.bg = color.toHexString();
      },
    });
    jQuery("#button-color").spectrum({
      type: "color",
      showInput: true,
      change: function (color) {
        store.options.appearance.colors.button.color = color.toHexString();
      },
    });
    jQuery("#textus-button-color").spectrum({
      type: "color",
      showInput: true,
      change: function (color) {
        store.options.appearance.colors.textUsButton.bg = color.toHexString();
      },
    });
    jQuery("#textus-text-color").spectrum({
      type: "color",
      showInput: true,
      change: function (color) {
        store.options.appearance.colors.textUsButton.color =
          color.toHexString();
      },
    });

    /** When launcher is load */
    var $container = jQuery(".leadsms-widget-container"),
      $prompt_delay = parseFloat($container.data("prompt-delay")), //in seconds
      $prompt_enabled = parseInt($container.data("prompt-enabled")); //1 or 0

    if ($prompt_enabled) {
      var $prompt_delay_in_ms = 1000;
      if (!isNaN($prompt_delay)) {
        $prompt_delay_in_ms = $prompt_delay * 1000;
      }
      setTimeout(() => {
        if (!$container.hasClass("widget-opened")) {
          var $prompt = $container.find(".leadsms-widget-prompt");
          $prompt.removeClass("hidden");
        }
      }, $prompt_delay_in_ms);
    }
  }, 1000);
});
</script>
