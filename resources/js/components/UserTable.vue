<template>
    <ag-grid-vue style="width: 100%; height: 600px;"
        class="ag-theme-alpine"
        :pagination="pagination"
    :paginationPageSize="paginationPageSize"
        :columnDefs="columnDefs"
        :rowData="rowData">
    </ag-grid-vue>
</template>

<script>
import { AgGridVue } from "ag-grid-vue3";

export default {
  name: "App",
  components: {
    AgGridVue,
  },
  setup() {
    return {
      columnDefs: [
        { headerName: "Name", field: "name", sortable: true, filter: true },
        { headerName: "Staff Type", field: "staff_type", sortable: true, filter: true },
        { headerName: "Total Credit Hours", field: "total_learned", sortable: true, filter: true },
      ],
      rowData: [
        { name: "John Doe", staff_type: "International Staff", total_learned: 92 },
        { name: "Jane Doe", staff_type: "National Staff", total_learned: 53 },
        { name: "Ram Sita", staff_type: "Non Staff", total_learned: 21 },
      ],
    pagination: true,
    paginationPageSize: 12,
    };
  },
};
</script>
