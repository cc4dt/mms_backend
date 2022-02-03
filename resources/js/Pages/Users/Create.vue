<template>
  <app-layout title="Create User">
    <jet-authentication-card>
      <jet-validation-errors class="mb-4" />

      <form @submit.prevent="submit">
        <div>
          <jet-label for="name" value="Name" />
          <jet-input
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            required
            autofocus
            autocomplete="name"
          />
        </div>

        <div class="mt-4">
          <jet-label for="email" value="Email" />
          <jet-input
            id="email"
            type="email"
            class="mt-1 block w-full"
            v-model="form.email"
            required
          />
        </div>

        <div class="mt-4">
          <jet-label for="level" value="Level" />
          <select
            id="level"
            class="
              border-gray-300
              focus:border-indigo-300
              focus:ring
              focus:ring-indigo-200
              focus:ring-opacity-50
              rounded-md
              shadow-sm
              mt-1
              block
              w-full
            "
            v-model="form.level"
            required
          >
            <option
              v-for="level in levels"
              :key="level['key']"
              :value="level['key']"
            >
              {{ level["value"] }}
            </option>
          </select>
        </div>

        <div class="flex items-center justify-end mt-4">
          <jet-button
            class="ml-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            Create
          </jet-button>
        </div>
      </form>
    </jet-authentication-card>
  </app-layout>
</template>

<script>
import { reactive, defineComponent } from "vue";
import JetAuthenticationCard from "@/Jetstream/AuthenticationCard.vue";
import JetAuthenticationCardLogo from "@/Jetstream/AuthenticationCardLogo.vue";
import JetButton from "@/Jetstream/Button.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetValidationErrors from "@/Jetstream/ValidationErrors.vue";
import { Link } from "@inertiajs/inertia-vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Inertia } from "@inertiajs/inertia";

export default defineComponent({
  components: {
    AppLayout,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
    Link,
  },

  props: {
    levels: Array,
  },

  setup() {
    const form = reactive({
      name: "",
      email: "",
      level: "",
    });

    function submit() {
      console.log(form);
      Inertia.post("/users", form);
    }

    return { form, submit };
  },

  //   data() {
  //     return {
  //       form: this.$inertia.form({
  //         name: "",
  //         email: "",
  //         level: "",
  //         terms: false,
  //       }),
  //     };
  //   },

  //   methods: {
  //     submit() {
  //       Inertia.post("/users", this.form);
  //     //   this.form.post(this.route("users.create"));
  //     },
  //   },
});
</script>
