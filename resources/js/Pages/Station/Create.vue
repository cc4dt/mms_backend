<template>
  <app-layout :title="category.name">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{category.name}}</h2>
    </template>
    <div class="m-0 sm:m-10">
      <div class="mt-5 md:mt-0">
        <form @submit.prevent="submit">
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="pv-4 py-5 bg-white p-6">
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-4">
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
                    for="date"
                    class="block text-sm font-medium text-gray-700"
                    >Date</label
                  >
                  <input
                    type="date"
                    id="date"
                    v-model="form.date"
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
                <div
                  class="col-span-6 sm:col-span-2"
                  style="border-bottom: 2px solid #eaeaea"
                >
                  <ul class="cursor-pointer my-3 space-y-2">
                    <template
                      v-for="(process, index) in form.processes ?? []"
                      :key="index"
                    >
                      <li
                        class="flex py-2 px-6 bg-gray-200 rounded-lg"
                        :class="
                          processIndex === index ? 'bg-white' : 'text-gray-500'
                        "
                        @click="processIndex = index"
                      >
                        <details>
                          <summary
                            v-text="process?.mf?.equipment?.name ?? 'New'"
                          ></summary>
                          <p
                            v-if="process?.equipment?.serial"
                            v-text="process?.equipment?.serial"
                          ></p>
                        </details>
                        <button
                          v-if="form.processes.length > 1"
                          type="button"
                          @click="deleteProcess(index)"
                          class="text-red-500 ms-auto"
                        >
                          <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                          </svg>
                        </button>
                      </li>
                    </template>
                  </ul>
                </div>
                <div class="col-span-6 sm:col-span-4">
                  <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                      <label
                        for="equipment"
                        class="block text-sm font-medium text-gray-700"
                        >Equipment</label
                      >
                      <select
                        id="equipment"
                        @change="equipmentChanged"
                        v-model="currentProcess.mf"
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
                        <option v-for="mf in category.forms" :key="mf" :value="mf">
                          {{ mf.equipment.name }}
                        </option>
                      </select>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                      <div v-if="equipmentFiltered.length > 0">
                        <label
                          for="serial"
                          class="block text-sm font-medium text-gray-700"
                          >Serial</label
                        >
                        <select
                          id="serial"
                          v-model="currentProcess.equipment"
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
                            v-for="item in equipmentFiltered"
                            :key="item.id"
                            :value="item"
                          >
                            {{ item.serial }}
                          </option>
                        </select>
                      </div>
                    </div>
                    <div class="col-span-6 mt-6 grid grid-cols-6 gap-6">
                      <fieldset
                        class="col-span-6 sm:col-span-3"
                        v-for="procedure in currentProcess?.mf?.procedures ?? {}"
                        :key="procedure.id"
                      >
                        <div
                          v-if="procedure.input_type.name == 'radio'"
                          class="space-y-4"
                        >
                          <div>
                            <legend class="text-base font-medium text-gray-900">
                              {{ procedure.name }}
                            </legend>
                          </div>
                          <div
                            v-for="option in procedure.options"
                            :key="option.id"
                            class="inline-flex items-center p-2"
                          >
                            <input
                              :id="procedure.id + '.' + option.id"
                              type="radio"
                              :name="procedure.id"
                              :value="option"
                              v-model="
                                currentProcess.procedures[procedure.id].option
                              "
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
                              :for="procedure.id + '.' + option.id"
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
                          <div
                            class="grid grid-cols-2 gap-4 space-x-1"
                            v-if="
                              currentProcess.procedures[procedure.id]?.option
                                ?.replace ?? false
                            "
                          >
                            <div
                              v-if="procedure?.spare_part?.sub_parts.length > 0"
                              class="col-span-1"
                            >
                              <select
                                :id="procedure.id"
                                v-model="
                                  currentProcess.procedures[procedure.id].spare
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
                            <div class="col-span-1">
                              <input
                                type="text"
                                id="val"
                                v-model.trim="
                                  currentProcess.procedures[procedure.id].val
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
                                placeholder="Note ..."
                              />
                            </div>
                          </div>
                        </div>
                        <div
                          v-else-if="procedure.input_type.name == 'dropdown'"
                          class="space-y-4"
                        >
                          <div>
                            <legend class="text-base font-medium text-gray-900">
                              <label :for="procedure.id">
                                {{ procedure.name }}
                              </label>
                            </legend>
                          </div>
                          <select
                            :id="procedure.id"
                            v-model="
                              currentProcess.procedures[procedure.id].option
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
                            required
                          >
                            <option
                              v-for="option in procedure.options"
                              :key="option.id"
                              :value="option"
                            >
                              {{ option.name }}
                            </option>
                          </select>
                        </div>
                        <div v-else>
                          <div class="space-y-4">
                            <div>
                              <legend
                                class="text-base font-medium text-gray-900"
                              >
                                <label :for="procedure.id">
                                  {{ procedure.name }}
                                </label>
                              </legend>
                            </div>
                            <input
                              :id="procedure.id"
                              v-model.trim="
                                currentProcess.procedures[procedure.id].val
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
                                mt-4
                              "
                              required
                              :placeholder="procedure.name"
                            />
                          </div>
                        </div>
                      </fieldset>
                    </div>
                    <div class="col-span-6">
                      <label
                        for="note"
                        class="block text-sm font-medium text-gray-700"
                      >
                        Note
                      </label>
                      <div class="mt-1">
                        <textarea
                          id="note"
                          v-model="currentProcess.description"
                          rows="3"
                          class="
                            shadow-sm
                            focus:ring-indigo-500 focus:border-indigo-500
                            mt-1
                            block
                            w-full
                            sm:text-sm
                            border border-gray-300
                            rounded-md
                          "
                          placeholder="Note ..."
                        />
                      </div>
                      <p class="mt-2 text-sm text-gray-500"></p>
                    </div>
                  </div>

                  <div class="pv-4 py-3 bg-gray-50 text-right sm:pv-6">
                    <div class="mx-5 inline-block">
                      <input
                        id="add"
                        type="submit"
                        value="Add"
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
                      />
                    </div>
                    <div class="mx-5 inline-block">
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
    category: Object,
  },
  computed: {
    equipmentFiltered: function () {
      return (
        this.form.station?.equipment.filter(
          (i) => i.equipment_id == this.currentProcess?.mf?.equipment?.id
        ) ?? []
      );
    },
    currentProcess: function () {
      if (this.form.processes && this.processIndex != null)
        return this.form.processes[this.processIndex];
      else if (this.form.processes.find((e) => true))
        return this.form.processes.find((e) => true);
      else return {};
    },
  },
  methods: {
    addProcesses() {
      this.form.processes.push({
        mf: null,
        equipment: null,
        description: null,
        procedures: {},
      });

      this.processIndex = this.form.processes.length - 1;
    },
    deleteProcess(index) {
      if (this.form.processes.length > 1 && this.form.processes[index])
        this.form.processes.splice(index, 1);
      this.processIndex = this.form.processes.length - 1;
    },
    equipmentChanged() {
      this.currentProcess.procedures = {};
      this.currentProcess?.mf.procedures.forEach((element) => {
        this.currentProcess.procedures[element.id] = {
          option: null,
          spare: null,
          val: null,
        };
      });
    },
  },
  data() {
    return {
      processIndex: 0,
    };
  },
  setup() {
    const form = reactive({
      station: null,
      date: null,
      processes: [],
    });

    function submit(event) {
      if (event.submitter.id == "add") this.addProcesses();
      else {
        let data = {
          category_id: this.category.id,
          station_id: form.station.id,
          date: form.date,
          processes: [],
        };
        form.processes.forEach(process => {
          let details = [];
          Object.keys(process.procedures).forEach(key => {
            details.push({
              procedure_id: key,
              option_id: process.procedures[key].option?.id ?? null,
              spare_part_id: process.procedures[key].spare?.id ?? null,
              value: process.procedures[key].val ?? null, 
            })
          })
          data.processes.push({
            equipment_id : process.mf.equipment_id,
            master_equipment_id : process.equipment?.id ?? null,
            description : process.description ?? null,
            details: details,
          });
        });
        console.log(data);
        Inertia.post(route("maintenance." + this.category.slug + ".store"), data, {
          // forceFormData: true,
          onError: (errors) => {
            alert(errors.create);
            // window.Toast.error(errors.create)
          },
        });
      }
    }

    return { form, submit };
  },

  created() {
    this.addProcesses();
  },
});
</script>
