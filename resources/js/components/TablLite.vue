<template>
    <table-lite
      :has-checkbox="false"
      :is-loading="table.isLoading"
      :is-re-search="table.isReSearch"
      :columns="table.columns"
      :rows="table.rows"
      :total="table.totalRecordCount"
      :sortable="table.sortable"
      :messages="table.messages"
      @do-search="doSearch"
      @is-finished="tableLoadingFinish"
      @return-checked-rows="updateCheckedRows"
    />
</template>

<script>
import { defineComponent, reactive } from "vue";
import VueTableLite from 'vue3-table-lite'


export default defineComponent({
  name: "App",
  components: { TableLite },
  setup() {
    // Table config
    const table = reactive({
      isLoading: false,
      columns: [
        {
          label: "ID",
          field: "id",
          width: "3%",
          sortable: true,
          isKey: true,
        },
        {
          label: "Name",
          field: "name",
          width: "10%",
          sortable: true,
        },
        {
          label: "Email",
          field: "email",
          width: "15%",
          sortable: true,
        },
      ],
      rows: [],
      totalRecordCount: 0,
      sortable: {
        order: "id",
        sort: "asc",
      },
    });
    /**
     * Search Event
     */
    const doSearch = async(offset, limit, order, sort) => {
      table.isLoading = true;
      const response = await this.$api.
      // Start use axios to get data from Server
      let url = 'https://www.example.com/api/some_endpoint?offset=' + offset + '&limit=' + limit + '&order=' + order + '&sort=' + sort;
      axios.get(url)
      .then((response) => {
        // Point: your response is like it on this example.
        //   {
        //   rows: [{
        //     id: 1,
        //     name: 'jack',
        //     email: 'example@example.com'
        //   },{
        //     id: 2,
        //     name: 'rose',
        //     email: 'example@example.com'
        //   }],
        //   count: 2,
        //   ...something
        // }
        
        // refresh table rows
        table.rows = response.rows;
        table.totalRecordCount = response.count;
        table.sortable.order = order;
        table.sortable.sort = sort;
      });
      // End use axios to get data from Server
    };
    return {
      table,
      doSearch,
    };
  },
});
export default {
  name: "App",
  components: {
    VueTableLite,
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
    };
  },
};
</script>
