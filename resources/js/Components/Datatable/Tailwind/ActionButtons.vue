<template>
  <div class="flex space-x-1.5">
    <Link
      v-if="showRoute != null"
      :href="route(showRoute, id)"
      class="
        text-blue-700
        border border-blue-700
        hover:bg-blue-700 hover:text-white
        focus:ring-4 focus:ring-blue-300
        font-medium
        rounded-lg
        text-sm
        p-1
        text-center
        inline-flex
        items-center
        dark:border-blue-500
        dark:text-blue-500
        dark:hover:text-white
        dark:focus:ring-blue-800
      "
    >
      <EyeIcon class="h-5 w-5" fill="currentColor" title="View" />
    </Link>
    <Link
      v-if="editRoute != null"
      :href="route(editRoute, id)"
      class="
        text-green-700
        border border-green-700
        hover:bg-green-700 hover:text-white
        focus:ring-4 focus:ring-green-300
        font-medium
        rounded-lg
        text-sm
        p-1
        text-center
        inline-flex
        items-center
        dark:border-green-500
        dark:text-green-500
        dark:hover:text-white
        dark:focus:ring-green-800
      "
    >
      <PencilIcon class="h-5 w-5" title="Edit" />
    </Link>
    <button
      @click="confirmDeletion"
      type="button"
      class="
        text-red-700
        border border-red-700
        hover:bg-red-700 hover:text-white
        focus:ring-4 focus:ring-red-300
        font-medium
        rounded-lg
        text-sm
        p-1
        text-center
        inline-flex
        items-center
        dark:border-red-500
        dark:text-red-500
        dark:hover:text-white
        dark:focus:ring-red-800
      "
    >
      <TrashIcon class="h-5 w-5" fill="currentColor" title="Delete" />
    </button>
    <!-- <span class="fa fa-trash fill-sky-500 hover:fill-sky-600"></span> -->
  </div>

  <!-- Delete Account Confirmation Modal -->
  <jet-dialog-modal :show="confirmingDeletion" @close="closeModal">
    <template #title> Delete </template>

    <template #content>
      Are you sure you want to delete item ?

      <div class="mt-4">
        <jet-input-error :message="form?.errors ?? ''" class="mt-2" />
      </div>
    </template>

    <template #footer>
      <jet-secondary-button @click="closeModal"> Cancel </jet-secondary-button>

      <jet-danger-button
        class="ml-2"
        @click="deleteItem"
        :class="{ 'opacity-25': !confirmingDeletion }"
        :disabled="!confirmingDeletion"
      >
        Delete
      </jet-danger-button>
    </template>
  </jet-dialog-modal>
</template>

<script>
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { EyeIcon, PencilIcon, TrashIcon } from "@heroicons/vue/solid";
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetDangerButton from "@/Jetstream/DangerButton.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import JetInputError from "@/Jetstream/InputError.vue";

export default defineComponent({
  components: {
    EyeIcon,
    PencilIcon,
    TrashIcon,
    Link,
    JetDialogModal,
    JetDangerButton,
    JetSecondaryButton,
    JetInputError,
  },
  props: {
    id: {
      type: Number,
      required: true,
    },
    showRoute: {
      type: String,
      default: null,
    },
    editRoute: {
      type: String,
      default: null,
    },
    deleteRoute: {
      type: String,
      default: null,
    },
    onDeleted: {
      type: Function,
      required: false,
    }
  },
  data() {
    return {
      form: {},
      confirmingDeletion: false,
    };
  },
  methods: {
    confirmDeletion() {
      this.confirmingDeletion = true;
    },

    deleteItem() {
      Inertia.delete(route(this.deleteRoute, this.id), this.form, {
        preserveScroll: true,
        preserveState: true,
        onError: (errors) => console.log(errors),
      });
      
      this.closeModal()
      if(this.onDeleted)
        this.onDeleted()
    },

    closeModal() {
      this.confirmingDeletion = false;
    },
  },
});
</script>