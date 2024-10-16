<template>
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank"
                href="https://datatables.net">official DataTables documentation</a>.
        </p>
        <div class="card mt-3"  style="width: 100%;">
            <div class="card-body overflow-auto">
                <button type="button" class="btn btn-primary" style="float: right !important;" data-bs-toggle="modal" data-bs-target="#ModalTicket" @click="state.ticketModalTitle = 'Add Ticket'"><i class="fas fa-plus"></i> Add Ticket</button>
                <br><br>
                <DataTable
                    class="table table-striped table-responsive mt-2"
                    ajax="/docu-app/api/get_module"
                    :options="{
                        serverSide: true, //Serverside true will load the network
                        columnDefs:[
                            // {orderable:false,target:[0]}
                        ]
                    }"
                >
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>Status</th>
                            <th>Category</th>
                            <th  style="width: 35%;">Document Name</th>
                            <th>Document</th>
                            <th>Attachment</th>
                            <th>Report Approvers</th>
                        </tr>
                    </thead>
                </DataTable>
            </div>
        </div>
    </div>
</template>
<script setup>
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
    DataTable.use(DataTablesCore);
    import { onMounted, ref, reactive, watch,nextTick } from "vue";
</script>
<style  src="@vueform/multiselect/themes/default.css">
    @import 'datatables.net-bs5';
</style>
