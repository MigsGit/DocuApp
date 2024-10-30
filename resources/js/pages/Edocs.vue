<template>
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edocs Table</h1>
        <div class="row">
            <div class="col-9">
                <div class="card mt-3">
                    <div class="card-body overflow-auto">
                        <button type="button" class="btn btn-primary" style="float: right !important;" data-toggle="modal" data-target="#saveModal"><i class="fas fa-plus"></i> Add Ticket</button>
                        <!-- <button type="button" class="btn btn-primary" style="float: right !important;"  @click="showModal('modal1')"><i class="fas fa-plus"></i> Add Ticket</button> -->
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
    <ModalComponent icon="fa-user" title="Module" id="modalCreateDocument" @add-event="saveDocument">
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
                <div class="col-12">
                    <label class="sr-only" for="selectPage">Select Page</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Select Page</div>
                        </div>
                        <select v-model="formSaveDocument.selectPage" class="form-control" id="selectPage" @change="selectedPage">
                            <option value="N/A" disabled>N/A</option>
                            <option v-for="(optSelectPage,index) in formSaveDocument.optSelectPages" :key="optSelectPage" :value="optSelectPage">
                                {{ optSelectPage }}
                            </option>
                        </select>
                    </div>
                </div>

            </div>
        </template>
        <template #footer>
            <button type="button" id= "closeBtn" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-sm"><li class="fas fa-save"></li> Save</button>
        </template>
    </ModalComponent> <!-- @add-event="" -->
    <ModalComponent icon="fa-user" title="Resolution Procedure" id="modalOpenPdfImage">
        <template #body>
            <div class="form-row align-items-center">
                <div class="col-12">
                    <div v-if="imageSrc" class="pdf-image-container">
                        <img
                            :src="imageSrc"
                            alt="PDF Page"
                            ref="pdfImage"
                            style="width: 100%;
                            height: 100%;
                            border: solid 1px;"
                            @click="getCoordinates"
                        />
                        <div
                            v-if="showBox"
                            :style="{ top: boxY + 'px', left: boxX + 'px'}"
                            class="click-box"
                        >Signature will be here</div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="button" id= "closeBtn" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
        </template>
    </ModalComponent>
</template>

<script setup>
    import DataTable from 'datatables.net-vue3';
    import DataTablesCore from 'datatables.net-bs5';
    DataTable.use(DataTablesCore);
    import { onMounted, ref, reactive, watch,nextTick } from "vue";
    import ModalComponent from '../components/Modal.vue'

    const objModalSaveDocument = ref(null);
    const objModalOpenPdfImage = ref(null);
    const tblEdocs = ref(null);
    const imageSrc = ref(null);
    const documentFile = ref([]);

    const showBox = ref(false);
    const boxX = ref(0);
    const boxY = ref(0);

    const formSaveDocument = ref({
        documentId: null,
        documentName: null,
        documentFile:[],
        selectPage: "",
        optSelectPages: [],
    });

    formSaveDocument.value.selectPage = "N/A";

    onMounted( () => {
        //modalOpenPdfImage
        objModalSaveDocument.value = new Modal(document.querySelector("#modalCreateDocument"),{});
        objModalOpenPdfImage.value = new Modal(document.querySelector("#modalOpenPdfImage"),{});
        $('#modalSave').on('hidden.bs.modal', function (e) {
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
                        objModalSaveDocument.value.show()
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
    ];

    /*
        Function
    */
    const getCoordinates = (event) => {
      const imageElement = event.target;
      const rect = imageElement.getBoundingClientRect();

      boxX.value = event.clientX - rect.left;
      boxY.value = event.clientY - rect.top;

      showBox.value = true;
      console.log('dsdad',showBox.value);
      console.log('boxX',boxX.value);
      console.log('boxY',boxY.value);
      console.log('rect',rect);
    };
    const uploadFile = async (event)  => {
        formSaveDocument.value.documentFile =  Array.from(event.target.files);
        // formSaveDocument.value.documentFile =  documentFile.value.files //If multiple files, required variable as array
    }
    const selectedPage  = async ()  => {
        await axios.get('/api/convert_pdf_to_image_by_page_number',{
            params:{
                select_page: formSaveDocument.value.selectPage,
                document_id: formSaveDocument.value.documentId
            },
            transformRequest: [(data, headers) => {
                // Modify the request config here (similar to beforeSend in jQuery)
                headers['Authorization'] = 'Bearer your-token';
                console.log('Request config modified before sending:', headers);
                // return data;
            }]
        }).then((response) => {
            let data = response.data;
            objModalOpenPdfImage.value.show();
            imageSrc.value = data.image;
        }).catch((err) => {
            console.log(err);
        });
    }
    const readDocumentById = async (documentId)  => {
        formSaveDocument.value.optSelectPages = [];
        await axios.get('/api/read_document_by_id',{
            params:{
                document_id: documentId
            }
        })
        .then((response) => {
            let document_details = response.data;
            formSaveDocument.value.documentName = document_details.read_document_by_id[0].document_name;

            //get the page thru array push
            for (let index = 0; index < document_details.page_count; index++) {
                formSaveDocument.value.optSelectPages.push(index+1)
            }
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
<!-- <style  src="@vueform/multiselect/themes/default.css">
    @import 'datatables.net-bs5';
</style> -->
<style>
    .pdf-image-container {
        position: relative;

    }
    .click-box {
        height:4%;
        border: solid 1px;
        position:absolute;
        color:black
    }
</style>
