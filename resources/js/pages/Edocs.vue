<template>
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edocs Table</h1>
        <div class="row">
            <div class="col-9">
                <div class="card mt-3">
                    <div class="card-body overflow-auto">
                        <button type="button" class="btn btn-primary" style="float: right !important;" data-toggle="modal" data-target="#saveModal"><i class="fas fa-plus"></i> Add Ticket</button>
                        <br><br>
                        <DataTable
                            ref="tblEdocs"
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
                                    <th class="w-25">Category</th>
                                    <th class="w-75">Document Name</th>
                                    <!-- <th class="w-50">Document</th> -->
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
                    <label class="sr-only" for="inlineFormInputGroup">Document Name</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Document Name</div>
                        </div>
                        <input v-model="formSaveDocument.documentName" type="text" class="form-control" id="inlineFormInputGroup" placeholder="Document Name">
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
                        multiple
                        @change="uploadFile"
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

    const documentFile = ref([]);
    const tblEdocs = ref(null);
    const formSaveDocument = ref({
        documentId: null,
        documentName: null,
        documentFile:[],
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
                        let documentId = this.getAttribute('data-id')
                        formSaveDocument.value.documentId = documentId;
                        readDocumentById(documentId);
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
        // { data: 'document_filename'},
        // { data: 'Attachment'}
    ];

    /*
        Function
    */
    const uploadFile = async (event)  => {
        formSaveDocument.value.documentFile =  Array.from(event.target.files);
        // formSaveDocument.value.documentFile =  documentFile.value.files //If multiple files, required variable as array
        console.log('uploadFile',formSaveDocument.value.documentFile);
    }
    const readDocumentById = async (documentId)  => {
        console.log('documentId',documentId);
        await axios.get('/api/read_document_by_id',{
            params:{
                document_id: documentId
            }
        }).then((response) => {
            let document_details = response.data.data;
            formSaveDocument.value.documentName = document_details[0].document_name;
            console.log(document_details[0].document_name);
            console.log(response.data.is_success);
        }).catch((err) => {
            console.log(err);
        });
    }
    const saveDocument = async ()  => {
        let formData = new FormData();
        formData.append("document_id", formSaveDocument.value.documentId);
        formData.append("document_name", formSaveDocument.value.documentName);
        console.log('saveDocument',formSaveDocument.value.documentFile);

        formSaveDocument.value.documentFile.forEach((file, index) => {
            formData.append(`document_file[${index}]`, file);  // Ensures that each file gets a unique key
        });

        // console.log('formData',formData);
        // return;
        await axios.post('/api/save_document', formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        }).then((response) => {
            console.log(response);
            tblEdocs.value.dt.draw();

        }).catch((err) => {
            console.log(err);
        });
    }

</script>
<style  src="@vueform/multiselect/themes/default.css">
    @import 'datatables.net-bs5';
</style>
