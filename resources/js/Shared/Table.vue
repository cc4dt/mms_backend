<script>
window.Popper = require("popper.js").default;
var $ = (window.$ = window.jQuery = require("jquery"));
window.JSZip = require("jszip");
window.pdfMake = require("pdfmake/build/pdfmake");
let pdfFonts = require("pdfmake/build/vfs_fonts");
window.pdfMake.vfs = pdfFonts.pdfMake.vfs;

// datatables js
require("datatables.net-buttons-bs4")(window, $);
require("datatables.net-bs4");
require("datatables.net-dt");

// buttons
require("datatables.net-buttons/js/buttons.html5.js");
require("datatables.net-buttons/js/buttons.colVis.min.js");
require("datatables.net-buttons/js/buttons.flash.min.js");
require("datatables.net-buttons/js/buttons.print.min.js");

import ActionButtons from "./ActionButtons.vue";
import { Head, Link } from "@inertiajs/inertia-vue3";
import { createApp } from "vue";

export default {
  components: {
    Head,
    Link,
  },
  props: [
    "datatableUrl",
    "datatableColumns",
    "datatableHeaders",
    "createRoute",
    "viewRoute",
    "editRoute",
    "deleteRoute",
  ],
  mounted() {
    const viewRoute = this.viewRoute;
    const editRoute = this.editRoute;
    const deleteRoute = this.deleteRoute;
    this.datatableColumns.push({
      data: null,
      defaultContent: "",
      orderable: false,
      searchable: false,
    });
    let datatable = $("#dt-users")
      .on("processing.dt", function (e, settings, processing) {
        if (processing) {
          $("table").addClass("opacity-25");
        } else {
          $("table").removeClass("opacity-25");
        }
      })
      .DataTable({
        // dom: "Bfrtip",
        ajax: {
          url: this.datatableUrl,
        },
        serverSide: true,
        processing: true,
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        columns: this.datatableColumns,
        lengthMenu: [
          [10, 25, 50, 100, 250, -1],
          ["10", "25", "50", "100", "250", "ALL"],
        ],
        columnDefs: [
          {
            render: function (data, type, row) {
              const tempApp = createApp(ActionButtons, {
                viewUrl: route(viewRoute, data["id"]),
                editUrl: route(editRoute, data["id"]),
                deleteUrl: route(deleteRoute, data["id"]),
              });

              const el = document.createElement("div");
              const mountedApp = tempApp.mount(el);
              return mountedApp.$el.outerHTML;
            },
            targets: -1,
          },
        ],
        // buttons: [
        //   "copy",
        //   "pdf",
        //   {
        //     extend: "print",
        //     charset: "UTF-8",
        //     orientation: "landscape",
        //     pageSize: "LEGAL",
        //     exportOptions: {
        //       columns: ":visible",
        //     },
        //   },
        //   {
        //     extend: "excel",
        //     text: "Excel",
        //     charset: "UTF-8",
        //     orientation: "landscape",
        //     pageSize: "LEGAL",
        //     exportOptions: {
        //       columns: ":visible",
        //     },
        //   },
        //   {
        //     extend: "csv",
        //     charset: "UTF-8",
        //     exportOptions: {
        //       columns: ":visible",
        //     },
        //   },
        //   "colvis",
        //   "pageLength",
        // ],
      });
  },
};
</script>


<style src="datatables.net-bs4/css/dataTables.bootstrap4.min.css"></style>
<style src="datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"></style>