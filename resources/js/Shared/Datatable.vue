<template>
  <div class="datatable">
    <table class="min-w-full border border-gray-200" id="dt-users">
      <!-- <thead>
        <tr>
          <th v-for="header in headers" :key="header.id">{{ header }}</th>
        </tr>
      </thead> -->
    </table>
  </div>
</template>

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

export default {
  props: ["url", "columns", "headers"],
  mounted() {
    let datatable = $("#dt-users")
      .on("processing.dt", function (e, settings, processing) {
        if (processing) {
          $("table").addClass("opacity-25");
        } else {
          $("table").removeClass("opacity-25");
        }
      })
      .DataTable({
        dom: "Bfrtip",
        columns: this.columns,
        ajax: {
          url: this.url,
        },
        // serverSide: true,
        processing: true,
        // paging: true,
        // colReorder: true,
        // responsive: true,
        lengthMenu: [
          [10, 25, 50, 100, 250, -1],
          ["10", "25", "50", "100", "250", "ALL"],
        ],
        columnDefs: [
          {
            render: function (data, type, row) {
              return data ? new Date(data).toLocaleDateString("en-US"): data;
            },
            targets: -1,
          },
        ],
        buttons: [
          "copy",
          "pdf",
          {
            extend: "print",
            charset: "UTF-8",
            orientation: "landscape",
            pageSize: "LEGAL",
            exportOptions: {
              columns: ":visible",
            },
          },
          {
            extend: "excel",
            text: "Excel",
            charset: "UTF-8",
            orientation: "landscape",
            pageSize: "LEGAL",
            exportOptions: {
              columns: ":visible",
            },
          },
          {
            extend: "csv",
            charset: "UTF-8",
            exportOptions: {
              columns: ":visible",
            },
          },
          "colvis",
          "pageLength",
        ],
      });
  },
};
</script>


<style src="datatables.net-bs4/css/dataTables.bootstrap4.min.css"></style>
<style src="datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css"></style>