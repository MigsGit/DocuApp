<template>
    <div class="container-fluid px-4">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edocs Table</h1>
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-body overflow-auto">
                        <!-- <button type="button" class="btn btn-primary" style="float: right !important;" data-toggle="modal" data-target="#saveModal"><i class="fas fa-plus"></i> Add</button> -->
                        <button type="button" class="btn btn-primary" style="float: right !important;" data-toggle="modal" data-target="#saveModal" @click="show"><i class="fas fa-plus"></i> Add</button>
                        <br><br>
                        <div class="table-responsive">
                            <DataTable
                                width="100%" cellspacing="0"
                                class="table table-bordered mt-2"
                                ref="tblEdocs"
                                :columns="columns"
                                :ajax="tblEdocsBaseUrl"
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
                                        <th>Document Name</th>
                                    </tr>
                                </thead>
                            </DataTable>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <ModalComponent modalDialog="modal-dialog modal-md modal-dialog-scrollable" icon="fa-user" title="Module" id="modalCreateDocument" @add-event="saveDocument"> -->
    <ModalComponent modalDialog="modal-dialog modal-lg" icon="fa-user" title="Module" id="modalCreateDocument" @add-event="saveDocument">
        <template #body>
            <div class="align-items-center">
                    <!-- Row 1 -->
                <div v-show="showFirstRow" class="row mb-2 animate__animated animate__slideInLeft">
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
                            accept=".pdf"
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
            <!-- Row 2 -->
                <div v-show="showSecondRow" class="row animate__animated animate__slideInRight">
                    <div class="col-12">
                        <button @click="addRowSaveDocuments"type="button" class="btn btn-primary" style="float: right !important;"><i class="fas fa-plus"></i> Add</button>
                        <br><br>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">UUID</th>
                                <th scope="col" style="width: 30%;">Approver</th>
                                <th scope="col" style="width: 15%;">Page No</th>
                                <th scope="col">Selected Page</th>
                                <th scope="col">Ordinates</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(rowSaveDocument, index) in rowSaveDocuments" :key="rowSaveDocument.index">
                                    <td>
                                        {{index+1}}
                                    </td>
                                    <td>
                                        <input v-model="rowSaveDocument.uuid" type="text" class="form-control" id="inlineFormInputGroup" placeholder="UUID">
                                    </td>
                                    <td>
                                        <MultiselectElement
                                            v-model="rowSaveDocument.approverName"
                                            :close-on-select="true"
                                            :searchable="true"
                                            :options="edocsVar.optApproverName"
                                        />
                                    </td>
                                    <td>
                                        <select v-model="rowSaveDocument.selectPage" class="form-control" id="selectPage" @change="selectedPage(rowSaveDocument, $event.target.value,index)">
                                            <option value="N/A" disabled>N/A</option>
                                            <option v-for="(optSelectPage,index) in edocsVar.optSelectPages" :key="optSelectPage" :value="optSelectPage">
                                                {{ optSelectPage }}
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <input v-model="rowSaveDocument.selectedPage" type="hidden" class="form-control" id="inlineFormInputGroup" placeholder="Selected Page">
                                        <span>{{ rowSaveDocument.selectedPage }}</span>
                                    </td>
                                    <td>
                                        <input v-model="rowSaveDocument.ordinates" type="hidden" class="form-control" id="inlineFormInputGroup" placeholder="Ordinates">
                                        <span>{{ rowSaveDocument.ordinates }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" type="button" data-item-process="add" @click="deleteRowSaveDocuments(index)">
                                            <li class="fa fa-trash"></li>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <!-- <button type="button" id= "closeBtn" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-outline-secondary btn-sm" v-show="showBtnFirstRow" @click="toggleRow('first')">Back</button>
            <button type="button" class="btn btn-outline-secondary btn-sm" v-show="showBtnSecondRow" @click="toggleRow('second')">Next</button>
            <button type="submit" class="btn btn-success btn-sm" v-show="showBtnSave"><li class="fas fa-save"></li>
                 Save
                 <!-- <span v-show="isLoading">Uploading... <i class="fa fa-spinner fa-pulse"></i></span> -->
            </button>
        </template>
    </ModalComponent> <!-- @add-event="" -->
    <ModalComponent modalDialog="modal-dialog modal-xl" icon="fa-user" title="PDF Document" id="modalOpenPdfImage">
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
            <button type="button" class="btn btn-outline-success btn-sm"  @click="saveCoordinates"><li class="fas fa-save"></li></button>
            <button type="button" id= "closeBtn" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
        </template>
    </ModalComponent>
    <ModalComponent modalDialog="modal-dialog modal-lg" icon="fa-folder" title="Document Approval" id="modalEdocsView">
        <template #body>
            <div class="row mb-2">
                <div class="col-12">
                    <a href=""></a>
                </div>
                <div class="col-12">
                    <a class="btn btn-outline-primary" @click="btnViewEdocs(documentId)"><font-awesome-icon class="nav-icon" icon="fa-file" />&nbsp;View Document</a>
                    <div class="table-responsive">
                        <DataTable
                            width="100%" cellspacing="0"
                            class="table table-bordered mt-2"
                            ref="tblApproverByDocId"
                            :ajax="tblApproverBaseUrl"
                            :columns="columnApprovers"
                            :options="{
                                serverSide: true, //Serverside true will load the network
                                columnDefs:[
                                    // {orderable:false,target:[0]}
                                ],
                                paging: false,
                            }"
                        >
                            <thead>
                                <tr>
                                    <th>No {{ documentId }}</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>PageNo</th>
                                    <th>ApproverRemarks</th>
                                </tr>
                            </thead>
                        </DataTable>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button @click="edocsApproval('AP')" type="button" class="btn btn-outline-success btn-sm"><font-awesome-icon icon="fa-thumbs-up"/>&nbsp; Approved</button>
            <!-- <button type="button" class="btn btn-outline-success btn-sm"><font-awesome-icon clas="fa fa-thumbs-up"/>&nbsp; Approved</button> -->
            <button @click="edocsApproval('DIS')" type="button" class="btn btn-outline-danger btn-sm"> <font-awesome-icon icon="fa-thumbs-down"/>&nbsp; Disapproved</button>
        </template>
    </ModalComponent>
    <ModalComponent @add-event="saveEdocsApproval" modalDialog="modal-dialog modal-md" icon="fa-thumbs-up" title="Approval Details" id="modalEdocsApproval">
        <template #body>
            <div class="row mb-2">
                <!-- <div class="col-12">
                    <label class="sr-only" for="inlineFormInputGroup">Doc Id</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Doc Id</div>
                        </div>
                        <input v-model="formEdocsApproval.documentId" value="{{  }}" type="text" class="form-control" id="inlineFormInputGroup" placeholder="Document Id" >
                    </div>
                </div> -->
                <div class="col-12">
                    <label class="sr-only" for="form_edocs_approval_status">Status</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Status</div>
                        </div>
                        <input v-model="formEdocsApproval.status" type="text" class="form-control" id="form_edocs_approval_status" placeholder="status" >
                    </div>
                </div>
                <div class="col-12">
                    <label class="sr-only" for="form_edocs_approval_remarks">Remarks</label>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                        <div class="input-group-text">Remarks</div>
                        </div>
                        <textarea v-model="formEdocsApproval.remarks" type="text" class="form-control" id="form_edocs_approval_remarks">
                        </textarea>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <button type="submit" class="btn btn-outline-success btn-sm"><li class="fas fa-save"></li></button>
            <button type="button" id= "closeBtn" class="btn btn-outline-secondary btn-sm" data-dismiss="modal">Close</button>
        </template>
    </ModalComponent>
    <!--
        Boolean required this example :isModalVisible
     -->
    <LoadingComponent :isModalVisible="isModalLoadingComponent" loadingMsg="Loading, please wait !" id="modalLoading">
    </LoadingComponent>
</template>

<script setup>
    import { onMounted, ref, reactive, watch,nextTick } from "vue";
    import ModalComponent from '../components/ModalComponent.vue'
    import LoadingComponent from '../components/LoadingComponent.vue'
    import edocs from "../composables/edocs";
    import useFetchAxios from "../composables/utils/useFetch";
    import useForm from "../composables/utils/useForm";
    import {v4 as uuid4} from 'uuid';
    const {
        uploadFile,getCoordinates,selectedPage,
        readDocumentById,readApproverNameById,edocsVar,
        boxX,boxY,showBox,
        objModalOpenPdfImage,objModalSaveDocument, modalEdocs,
        imageSrc,formSaveDocument,rowSaveDocuments,
        tblEdocs,tblApproverByDocId,
        documentFile,
        // isModalLoadingComponent, //Cannot read the variable name
    } = edocs();

    const {
        axiosFetchData,isModalLoadingComponent,
    } = useFetchAxios();

    const {
        axiosSaveData
    } = useForm();
    //Ref State
    const tblEdocsBaseUrl = ref(null);
    const tblApproverBaseUrl = ref(null);
    const documentId = ref(null);
    // const aDocumentId = ref(null);
    const showFirstRow = ref(true);
    const showSecondRow = ref(false);
    const showBtnFirstRow = ref(false);
    const showBtnSecondRow = ref(true);
    const showBtnSave = ref(false);
    //Reactive
    const formEdocsApproval = reactive({
        documentId : '',
        status : '',
        remarks : '',
    });

    // URL
    tblEdocsBaseUrl.value = baseUrl+"api/load_edocs";
    tblApproverBaseUrl.value = baseUrl+"api/load_approver_by_doc_id";

    const columns =[
        {
            data: 'get_action',
            orderable: false,
            searchable: false,
            createdCell(cell) {
                let btnEdocs = cell.querySelector("#btnEdocs")
                let btnEdocsView = cell.querySelector("#btnEdocsView")
                if((btnEdocs !== null)){
                    btnEdocs.addEventListener('click', function(event){
                        let documentId = this.getAttribute('data-id')
                        formSaveDocument.value.documentId = documentId;
                        readDocumentById(documentId);
                        readApproverNameById(1);
                        objModalSaveDocument.value.show()
                    });
                }
                if((btnEdocsView !== null)){
                    btnEdocsView.addEventListener('click', function(event){
                        documentId.value = this.getAttribute('data-id');
                        // aDocumentId.value = documentId;
                        modalEdocs.View.show();
                        tblApproverByDocId.value.dt.ajax.url( `${tblApproverBaseUrl.value}?document_id=${documentId.value}` ).draw();

                    });
                }
            },
        },
        { data: 'status'},
        { data: 'category_id'},
        { data: 'document_name'},
    ];
    const columnApprovers =[
        { data: 'get_num'},
        { data: 'get_status'},
        { data: 'get_approver_name'},
        { data: 'page_no'},
        { data: 'approver_remarks'},
    ];

    //Table Url
    onMounted( () => {
        objModalSaveDocument.value = new Modal(document.querySelector("#modalCreateDocument"),{});
        objModalOpenPdfImage.value = new Modal(document.querySelector("#modalOpenPdfImage"),{});
        modalEdocs.View = new Modal(document.querySelector("#modalEdocsView"),{});
        modalEdocs.View = new Modal(document.querySelector("#modalEdocsView"),{});
        modalEdocs.Approval = new Modal(document.querySelector("#modalEdocsApproval"),{});

        $('#modalCreateDocument').on('hidden.bs.modal', function (e) {
            documentFile.value.value = "";
            rowSaveDocuments.value = [
                {
                    uuid: uuid4(),
                    approverName: '',
                    selectPage: "N/A",
                    ordinates: '',
                },
            ];
        });
        $('#modalOpenPdfImage').on('hidden.bs.modal', function (e) {
            rowSaveDocuments.value.forEach(rowSaveDocuments => {
                rowSaveDocuments.selectPage = "N/A"
            });
            showBox.value = false;
            boxX.value = "";
            boxY.value = "";
        });

    })
    /*
        Function
    */
    const toggleRow = (row) => {
      if (row === 'first') {
        showFirstRow.value = true;
        showSecondRow.value = false;
        showBtnSecondRow.value = true;
        showBtnFirstRow.value = false;
        showBtnSave.value = false;

      } else if (row === 'second') {
        showSecondRow.value = true;
        showFirstRow.value = false;
        showBtnSecondRow.value = false;
        showBtnFirstRow.value = true;
        showBtnSave.value = true;
      }
    }
    const show = async () =>{

    }
    const addRowSaveDocuments = async () =>{
        rowSaveDocuments.value.push({   uuid: uuid4(), selectPage: 'N/A' ,approverName: '', ordinates: '' })
    }
    const deleteRowSaveDocuments = async (index) =>{
        rowSaveDocuments.value.splice(index,1);
    }
    const btnViewEdocs = (documentId) =>{
        window.open(`${baseUrl}api/pdf/view?documentId=${documentId}`, '_blank'); //boostrap.js
    }
    const edocsApproval = (status) => {
        formEdocsApproval.documentId = documentId.value;
        formEdocsApproval.status =  status;
        console.log('formEdocsApproval.documentId',formEdocsApproval.documentId);

        modalEdocs.Approval.show();
        // let params = {
        //     'status' : status
        // };
        // axiosFetchData(params,'update_edocs_approval_status',function(response){
        //     console.log(response);
        // });
    }
    /**
     * Array of formSaveDocument
     * Nested Loop for Array of rowSaveDocuments
     */
    const saveDocument = async ()  => {
        let formData = new FormData();

        const {
            documentId,documentName,
        } =  formSaveDocument.value;

        [
            ["document_id", documentId], ["document_name", documentName]
        ].forEach(([key, value]) =>
            formData.append(key, value)
        );

        for (let index = 0; index < rowSaveDocuments.value.length; index++) {
            const uuid = rowSaveDocuments.value[index].uuid;
            const ordinates = rowSaveDocuments.value[index].ordinates;
            const approverName = rowSaveDocuments.value[index].approverName;
            const selectedPage = rowSaveDocuments.value[index].selectedPage;
            [
                ["uuid[]", uuid], ["ordinates[]", ordinates],
                ["approver_name[]", approverName], ["selected_page[]", selectedPage]
            ].forEach(([key, value]) =>
                formData.append(key, value)
            );
        }

        axiosSaveData(formData,'/api/save_document', (response) =>{
            tblEdocs.value.dt.draw();
            console.log(response);
        });
        return;
        await axios.post('/api/save_document', formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        }).then((response) => {
            tblEdocs.value.dt.draw();
        }).catch((err) => {
            console.log(err);
        });
    }
    const saveEdocsApproval = async () => {

        let formData = new FormData();
            formData.append("document_id", formEdocsApproval.documentId);
            formData.append("status", formEdocsApproval.status);
            formData.append("remarks", formEdocsApproval.remarks);
        axiosSaveData(formData,'/api/update_edocs_approval_status', (response) =>{
            modalEdocs.Approval.hide();
            tblApproverByDocId.value.dt.ajax.url( `${tblApproverBaseUrl.value}?document_id=${documentId.value}` ).draw();
        });
    }
    /**
     *  The use of rowSaveDocuments (plural) instead of rowSaveDocument (singular) is a best practice
     *  when handling multiple rows in a table or list,
     *  as it represents a collection of rowSaveDocuments
     *  */
    const saveCoordinates = () =>{
        rowSaveDocuments.value[edocsVar.rowSaveDocumentId].ordinates = `${edocsVar.pxCoordinate} | ${edocsVar.pyCoordinate}`;
        rowSaveDocuments.value[edocsVar.rowSaveDocumentId].selectedPage = edocsVar.selectedPage;
        objModalOpenPdfImage.value.hide();
        console.log(rowSaveDocuments);

    }

</script>
<style  src="@vueform/multiselect/themes/default.css">
</style>
<style>
    .pdf-image-container {
        position: relative;
    }
    .click-box {
        height:4%;
        border: solid 1px;
        position: absolute;
        color:black
    }
</style>
