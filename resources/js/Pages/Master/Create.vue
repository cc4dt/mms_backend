<template>
  <app-layout title="New Equipment">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        New Equipment
      </h2>
    </template>
    <div class="m-0 sm:m-10">
      <div class="mt-5 md:mt-0">
        <form @submit.prevent="submit">
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="pv-4 py-5 bg-white p-6">
              <div class="grid grid-cols-6 gap-4">
                <div class="col-span-6 sm:col-span-2">
                  <label
                    for="station"
                    class="block text-sm font-medium text-gray-700"
                    >Station</label
                  >
                  <select
                    id="station"
                    v-model="form.station"
                    class="
                      mt-1
                      block
                      w-full
                      py-2
                      pv-3
                      border border-gray-300
                      bg-white
                      rounded-md
                      shadow-sm
                      focus:outline-none
                      focus:ring-indigo-500
                      focus:border-indigo-500
                      sm:text-sm
                    "
                    required
                  >
                    <option
                      v-for="station in stations"
                      :key="station.id"
                      :value="station"
                    >
                      {{ station.name }}
                    </option>
                  </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                  <label
                    for="equipment"
                    class="block text-sm font-medium text-gray-700"
                    >Equipment</label
                  >
                  <select
                    id="equipment"
                    @change="equipmentChanged"
                    v-model="form.equipment"
                    class="
                      mt-1
                      block
                      w-full
                      py-2
                      pv-3
                      border border-gray-300
                      bg-white
                      rounded-md
                      shadow-sm
                      focus:outline-none
                      focus:ring-indigo-500
                      focus:border-indigo-500
                      sm:text-sm
                    "
                    required
                  >
                    <option
                      v-for="item in equipment"
                      :key="item.id"
                      :value="item"
                    >
                      {{ item.name }}
                    </option>
                  </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                  <label
                    for="serial"
                    class="block text-sm font-medium text-gray-700"
                    >Serial</label
                  >
                  <input
                    id="serial"
                    v-model="form.serial"
                    class="
                      mt-1
                      block
                      w-full
                      py-2
                      pv-3
                      border border-gray-300
                      bg-white
                      rounded-md
                      shadow-sm
                      focus:outline-none
                      focus:ring-indigo-500
                      focus:border-indigo-500
                      sm:text-sm
                    "
                    required
                  />
                </div>
              </div>

              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 mt-6 grid grid-cols-6 gap-6">
                  <fieldset
                    class="col-span-6 sm:col-span-3 space-y-4"
                    v-for="attr in form.equipment?.attributes ?? []"
                    :key="attr.id"
                  >
                    <div>
                      <legend class="text-base font-medium text-gray-900">
                        <label :for="attr.id">
                          {{ attr.name }}
                        </label>
                      </legend>
                    </div>
                    <div v-if="attr.type.key == 'radio'">
                      <div
                        v-for="option in attr.options"
                        :key="option.id"
                        class="inline-flex items-center p-2"
                      >
                        <input
                          :id="attr.id + '.' + option.id"
                          type="radio"
                          :name="attr.id"
                          :value="option.name"
                          v-model="form.details[attr.id]"
                          class="
                            focus:ring-indigo-500
                            h-4
                            w-4
                            text-indigo-600
                            border-gray-300
                          "
                          required
                        />
                        <label
                          :for="attr.id + '.' + option.id"
                          class="ml-3 block text-sm font-medium text-gray-700"
                        >
                          {{ option.name }}
                        </label>
                      </div>
                    </div>
                    <select
                      :id="attr.id"
                      v-else-if="attr.type.key == 'dropdown'"
                      v-model="form.details[attr.id]"
                      class="
                        bg-gray-50
                        border border-gray-300
                        text-gray-900
                        sm:text-sm
                        rounded-lg
                        focus:ring-blue-500 focus:border-blue-500
                        block
                        w-full
                        p-2.5
                      "
                      required
                    >
                      <option
                        v-for="option in attr.options"
                        :key="option.id"
                        :value="option.name"
                      >
                        {{ option.name }}
                      </option>
                    </select>
                    <div v-else>
                      <input
                        :id="attr.id"
                        v-model.trim="form.details[attr.id]"
                        class="
                          bg-gray-50
                          border border-gray-300
                          text-gray-900
                          sm:text-sm
                          rounded-lg
                          focus:ring-blue-500 focus:border-blue-500
                          block
                          w-full
                          p-2.5
                          mt-4
                        "
                        required
                        :placeholder="attr.name"
                      />
                    </div>
                  </fieldset>
                </div>
              </div>

              <div class="pv-4 py-3 bg-gray-50 text-right sm:pv-6">
                <input
                  type="submit"
                  id="submit"
                  class="
                    mv-5
                    inline-flex
                    justify-center
                    py-2
                    pv-4
                    border border-transparent
                    shadow-sm
                    text-sm
                    font-medium
                    rounded-md
                    text-white
                    bg-indigo-600
                    hover:bg-indigo-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-offset-2
                    focus:ring-indigo-500
                    px-3
                  "
                  value="Submit"
                />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { reactive, defineComponent } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Jetstream/Button.vue";

export default defineComponent({
  components: {
    AppLayout,
    Button,
  },
  props: {
    stations: Array,
    equipment: Array,
  },
  methods: {
    equipmentChanged() {
      this.form.details = {};
      this.form.equipment?.attributes?.forEach((element) => {
        this.form.details[element.id] = null
      });
    },
  },
  setup() {
    const form = reactive({
      station: null,
      equipment: null,
      serial: null,
      details: {},
    });

    function submit(event) {
      let data = {
        equipment_id: form.equipment.id,
        station_id: form.station.id,
        serial: form.serial,
        details: [],
      };
      Object.keys(form.details).forEach((key) => {
        data.details.push({
          attribute_id: key,
          value: form.details[key] ?? null,
        });
      });
      console.log(data);
      Inertia.post(route("master.store"), data, {
        // forceFormData: true,
        onError: (errors) => {
          alert(errors.create);
          // window.Toast.error(errors.create)
        },
      });
    }

    return { form, submit };
  },
});
</script>
