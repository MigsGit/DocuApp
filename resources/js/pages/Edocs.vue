<template>
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank"
                href="https://datatables.net">official DataTables documentation</a>.
        </p>
        <div class="row">
            <div class="col-9">
                <div class="card mt-3">
                    <div class="card-header">Test</div>
                    <div class="card-body overflow-auto">
                        <button type="button" class="btn btn-primary" style="float: right !important;" data-toggle="modal" data-target="#saveModal"><i class="fas fa-plus"></i> Add Ticket</button>
                        <br><br>
                        <DataTable
                            class="table table-striped table-responsive mt-2"
                            :columns="columns"
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
                                    <!-- <th>Attachment</th> -->
                                    <!-- <th>Report Approvers</th> -->
                                </tr>
                            </thead>
                        </DataTable>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- @add-event="" -->
    <Modal icon="fa-user" title="Resolution Procedure" @add-event="saveDocument">
    <!-- <Modal icon="fa-user" title="Module"> -->
        <template #body>
            <div class="form-row align-items-center">
                <div class="col-12">
                    <label class="sr-only" for="inlineFormInputGroup">Document Id</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Document Id</div>
                        </div>
                        <input v-model="formSaveDocument.documentId" type="text" class="form-control" id="inlineFormInputGroup" placeholder="Document Id" >
                    </div>
                </div>
                <div class="col-12">
                    <label class="sr-only" for="inlineFormInputGroup">Username</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Username</div>
                        </div>
                        <input v-model="formSaveDocument.documentName" type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username">
                    </div>
                </div>
                <div class="col-12">
                    <label class="sr-only" for="inlineFormInputGroup">Document File</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Document File</div>
                        </div>
                        <input
                        id="fileThumbnail"
                        class="form-control"
                        ref="documentFile"
                        type="file"
                        @change="uploadFile()"
                    >
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button" id= "closeBtn" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-sm"><li class="fas fa-save"></li> Save</button>
        </template>
    </Modal> <!-- @add-event="" -->
</template>

<script setup>
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
    DataTable.use(DataTablesCore);
    import { onMounted, ref, reactive, watch,nextTick } from "vue";
    import Modal from '../components/Modal.vue'

    const documentFile = ref(null)
    const formSaveDocument = ref({
        documentId: null,
        documentName: null,
        documentFile: null,
    });


    onMounted( async () => {
        $('#modalSave').on('hidden.bs.modal', function (e) {
		/* Allows the overlayed modal to be scrollable */
            documentFile.value.value = "";
        });
    })

    const columns =[
        {
            data: 'get_action',
            orderable: false,
            searchable: false,
            createdCell(cell) {
                let btnEdocs = cell.querySelector("#btnEdocs")
                if((btnEdocs !== null)){
                    btnEdocs.addEventListener('click', function(event){
                        let ticketId = this.getAttribute('data-id')
                        formSaveDocument.value.documentId = ticketId;
                    });
                }
                // if((btnViewTicket !== null)){
                //     btnViewTicket.addEventListener('click', function(event){
                //         event.preventDefault();
                //         let ticketId = this.getAttribute('ticket-id')
                //         let btnType = this.getAttribute('title')
                //         editTicket(ticketId,btnType)
                //     });
                // }
            },
        },
        { data: 'status'},
        { data: 'category_id'},
        { data: 'document_name'},
        { data: 'document_filename'},
        // { data: 'Attachment'}
    ];

    /*
        Function
    */
    const uploadFile = async ()  => {
        formSaveDocument.value.documentFile =  documentFile.value.files[0]
        console.log(formSaveDocument.value.documentFile);
    }
    const saveDocument = async ()  => {
        console.log('formSaveDocument',formSaveDocument.value.documentFile);
        let formData = new FormData();
        formData.append("document_id", formSaveDocument.value.documentId);
        formData.append("document_name", formSaveDocument.value.documentName);
        formData.append("document_file", formSaveDocument.value.documentFile);

        console.log('formData',formData);

        await axios.post('/api/save_document', formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        }).then((res) => {
            console.log(res);
        }).catch((err) => {
            console.log(err);

        });
    }

</script>
<style  src="@vueform/multiselect/themes/default.css">
    @import 'datatables.net-bs5';
</style>
