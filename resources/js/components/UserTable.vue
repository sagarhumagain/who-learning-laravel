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
    pagination: true,
    paginationPageSize: 12,
    };
  },
};
</script>
