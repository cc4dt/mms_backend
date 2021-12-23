<template>
  <app-layout title="HSE">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">HSE</h2>
    </template>
    <div class="mt-10 sm:mt-0">
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
                    name="station"
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
                    name="date"
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
                  class="col-span-6 sm:col-span-2 bg-gray-200 rounded-lg"
                  style="border-bottom: 2px solid #eaeaea"
                >
                  <ul class="cursor-pointer my-3">
                    <template
                      v-for="(process, index) in form.processes ?? []"
                      :key="index"
                    >
                      <li
                        class="py-2 px-6"
                        :class="
                          processIndex === index ? 'bg-white' : 'text-gray-500'
                        "
                        @click="processIndex = index"
                      >
                        <span v-text="process?.hse?.name ?? 'New'"></span>
                        <span
                          v-if="process?.equipment?.serial"
                          v-text="' - ' + process?.equipment?.serial"
                        ></span>
                      </li>
                    </template>
                  </ul>
                </div>
                <div class="col-span-6 sm:col-span-4">
                  <div class="grid grid-cols-6 gap-6">
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
                        v-model="currentProcess.hse"
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
                        <option v-for="hse in hses" :key="hse" :value="hse">
                          {{ hse.name }}
                        </option>
                      </select>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                      <div v-if="equipmentFiltered.length > 0">
                        <label
                          for="equipment"
                          class="block text-sm font-medium text-gray-700"
                          >Equipment</label
                        >
                        <select
                          id="equipment"
                          name="equipment"
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
                    <fieldset
                      class="col-span-6 sm:col-span-3"
                      v-for="procedure in currentProcess?.hse?.procedures ?? {}"
                      :key="procedure.id"
                    >
                      <div>
                        <legend class="text-base font-medium text-gray-900">
                          {{ procedure.name }}
                        </legend>
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
                            for="push-everything"
                            class="ml-3 block text-sm font-medium text-gray-700"
                          >
                            {{ option.name }}
                          </label>
                        </div>
                      </div>
                      <div class="grid grid-cols-2 gap-4">
                        <div
                          class="p-3 col-span-2 sm:col-span-1"
                          v-if="
                            (currentProcess.procedures[procedure.id]?.option
                              ?.spare ??
                              false) &&
                            procedure?.spare_part?.sub_parts
                          "
                        >
                          <select
                            id="spare"
                            name="spare"
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
                              v-for="item in procedure?.spare_part?.sub_parts"
                              :key="item.id"
                              :value="item"
                            >
                              {{ item.name }}
                            </option>
                          </select>
                        </div>
                        <div class="p-3 col-span-2 sm:col-span-1">
                          <input
                            type="text"
                            id="val"
                            v-model.trim="
                              currentProcess.procedures[procedure.id].val
                            "
                            v-if="
                              currentProcess.procedures[procedure.id]?.option
                                ?.val ?? false
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
          (i) => i.equipment_id == this.currentProcess.hse?.equipment_id
        ) ?? []
      );
    },
    currentProcess: function () {
      if (this.form.processes && this.processIndex != null)
        return this.form.processes[this.processIndex];
      else return {};
    },
  },
  methods: {
    addProcesses() {
      this.form.processes.push({
        hse: null,
        equipment: null,
        description: null,
        procedures: {},
      });

      this.processIndex = this.form.processes.length - 1;
    },
    initProcedure(hse) {
      var procedures = {};
      hse?.procedures.forEach((element) => {
        procedures[element.id] = {
          option: null,
          spare: null,
          val: null,
        };
      });
      return procedures;
    },
    hseChanged() {
      this.currentProcess.procedures = {};
      this.currentProcess?.hse.procedures.forEach((element) => {
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
      console.log(form);
      if (event.submitter.id == "add") this.addProcesses();
      else Inertia.post("/hse", form);
    }

    return { form, submit };
  },

  created() {
    this.addProcesses();
  },
});
</script>
