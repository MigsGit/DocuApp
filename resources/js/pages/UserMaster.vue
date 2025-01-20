<template>
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">User Master Table</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">User Master</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <!-- id="dataTable" -->
            <!-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            </table> -->
            <DataTable
                ref="tblUserMaster"
                width="100%" cellspacing="0"
                class="table table-bordered mt-2"
                :ajax="tblUserMasterBaseUrl"
                :columns="columns"
                :options="{
                    serverSide: true, //Serverside true will load the network
                    //columnDefs:[
                        // {orderable:false,target:[0]}
                    //]
                }"
            >
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                    </tr>
                </thead>
            </DataTable>
        </div>
    </div>
</div>

</div>
</template>

<script setup>
    import { onMounted, ref, reactive, watch,nextTick } from "vue";
    const tblUserMasterBaseUrl = ref(null);
    const tblUserMaster = ref(null);

    tblUserMasterBaseUrl.value = baseUrl+"api/get_user_master";

    const columns =[
        {
            data: 'get_action',
            orderable: false,
            searchable: false,
            createdCell(cell) {
                let btnEdocs = cell.querySelector("#btnEdocs")
                if((btnEdocs !== null)){
                    btnEdocs.addEventListener('click', function(event){
                        let documentId = this.getAttribute('data-id')
                        formSaveDocument.value.documentId = documentId;
                        readDocumentById(documentId);
                        readApproverNameById(1);
                        objModalSaveDocument.value.show()
                    });
                }
            },
        },
        { data: 'get_status'},
        { data: 'name'},
        { data: 'email'},
        { data: 'roles'},
    ];

     axios.get(tblUserMasterBaseUrl.value,{

    }).then((response) => {

    }).catch((err) => {
        console.log(err);
    });
    console.log(tblUserMasterBaseUrl.value)

</script>

<style lang="scss" scoped>

</style>
