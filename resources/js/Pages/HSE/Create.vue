<template>
  <app-layout title="HSE">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">HSE</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <div>
            <div class="md:grid md:gap-6">
              <div class="">
                <form @submit.prevent="submit">
                  <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="hse"
                          class="block text-sm font-medium text-gray-700"
                          >HSE</label
                        >
                        <select
                          id="hse"
                          name="hse"
                          @change="hseChanged"
                          v-model="form.hse"
                          class="
                            mt-1
                            block
                            w-full
                            py-2
                            px-3
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
                          <option v-for="hse in hses" :key="hse" :value="hse">
                            {{ hse.name }}
                          </option>
                        </select>
                      </div>

                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="date"
                          class="block text-sm font-medium text-gray-700"
                          >Date</label
                        >
                        <input
                          type="date"
                          name="date"
                          id="date"
                          v-model="form.date"
                          class="
                            mt-1
                            block
                            w-full
                            py-2
                            px-3
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
                      <div class="col-span-6 sm:col-span-3">
                        <label
                          for="station"
                          class="block text-sm font-medium text-gray-700"
                          >Station</label
                        >
                        <select
                          id="station"
                          name="station"
                          v-model="form.station"
                          class="
                            mt-1
                            block
                            w-full
                            py-2
                            px-3
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

                      <div
                        class="col-span-6 sm:col-span-3"
                        v-if="equipmentFiltered.length > 0"
                      >
                        <label
                          for="equipment"
                          class="block text-sm font-medium text-gray-700"
                          >Equipment</label
                        >
                        <select
                          id="equipment"
                          name="equipment"
                          v-model="form.equipment"
                          class="
                            mt-1
                            block
                            w-full
                            py-2
                            px-3
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
                            v-for="item in equipmentFiltered"
                            :key="item.id"
                            :value="item"
                          >
                            {{ item.serial }}
                          </option>
                        </select>
                      </div>

                      <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                        <fieldset
                          v-for="procedure in form.hse?.procedures ?? []"
                          :key="procedure.id"
                        >
                          <div>
                            <legend class="text-base font-medium text-gray-900">
                              {{ procedure.name }}
                            </legend>
                            <!-- <p class="text-sm text-gray-500">
                      These are delivered via SMS to your mobile phone.
                    </p> -->
                          </div>
                          <div class="mt-4 space-y-4">
                            <div
                              v-for="option in procedure.options"
                              :key="option.id"
                              class="inline-flex items-center p-2"
                            >
                              <input
                                :id="procedure.id"
                                :name="procedure.id"
                                type="radio"
                                :value="option"
                                v-model="form.procedures[procedure.id].option"
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
                                for="push-everything"
                                class="
                                  ml-3
                                  block
                                  text-sm
                                  font-medium
                                  text-gray-700
                                "
                              >
                                {{ option.name }}
                              </label>
                            </div>
                          </div>
                          <div class="grid grid-cols-2 gap-4">
                            <div
                              v-if="
                                (form.procedures[procedure.id]?.option?.spare ??
                                  false) &&
                                procedure?.spare_part?.sub_parts
                              "
                              class="p-3 col-span-1"
                            >
                              <select
                                id="spare"
                                name="spare"
                                v-model="form.procedures[procedure.id].spare"
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
                                  v-for="item in procedure?.spare_part
                                    ?.sub_parts"
                                  :key="item.id"
                                  :value="item"
                                >
                                  {{ item.name }}
                                </option>
                              </select>
                            </div>
                            <div class="p-3 col-span-1">
                              <input
                                type="text"
                                id="val"
                                v-model.trim="form.procedures[procedure.id].val"
                                v-if="
                                  form.procedures[procedure.id]?.option?.val ??
                                  false
                                "
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
                                placeholder=""
                                required
                              />
                            </div>
                          </div>
                        </fieldset>
                      </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                      <button
                        type="submit"
                        class="
                          inline-flex
                          justify-center
                          py-2
                          px-4
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
                        "
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import { reactive, defineComponent } from "vue";
import { Inertia } from "@inertiajs/inertia";
import AppLayout from "@/Layouts/AppLayout.vue";

export default defineComponent({
  components: {
    AppLayout,
  },
  props: {
    hses: Array,
    stations: Array,
  },
  computed: {
    equipmentFiltered: function () {
      return (
        this.form.station?.equipment.filter(
          (i) => i.equipment_id == this.form.hse?.equipment_id
        ) ?? []
      );
    },
  },
  watch: {
    // form: {
    //   handler: function (v) {
    //     console.log(v);
    //   },
    //   deep: true,
    // },
  },
  methods: {
    hseChanged() {
      this.form.procedures = {};
      this.form?.hse?.procedures.forEach((element) => {
        this.form.procedures[element.id] = {
          option: null,
          spare: null,
          val: null,
        };
      });
    },
  },
  setup() {
    const form = reactive({
      hse: null,
      date: null,
      station: null,
      equipment: null,
      procedures: {},
    });

    function submit() {
      console.log(form);
      Inertia.post("/hse", form);
    }

    return { form, submit };
  },
  mounted() {
    if (this.hses[0]) {
      this.form.hse = this.hses[0];
      this.hseChanged();
    }
  },
});
</script>
