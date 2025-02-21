import { ref, inject,reactive } from 'vue'
import {v4 as uuid4} from 'uuid';
import useFetch from './utils/useFetch';
export default function edocs()
{
    const objModalSaveDocument = ref(null);
    const objModalOpenPdfImage = ref(null);
    const objModalLoading = ref(null);
    const modalEdocs = reactive({
        View : "",
        Approval : ""
    })
    const tblApproverByDocId = ref(null)
    const showBox = ref(false);
    const boxX = ref(0);
    const boxY = ref(0);
    const height = ref(0);
    const width = ref(0);
    const imageSrc = ref(null);
    const { axiosFetchData } = useFetch(); // Call the useFetch function


    const edocsVar = reactive({
        pxCoordinate: '',
        pyCoordinate: '',
        rowSaveDocumentId: '',
        selectedPage: '',
        optApproverName: [],
        optSelectPages: [],
    });

    const formSaveDocument = ref({
        documentId: null,
        documentName: null,
        documentFile:[],
        optSelectPages: [],
        uuid: null,
    });
    const tblEdocs = ref(null);
    const documentFile = ref([]);

    const rowSaveDocuments = ref([
        {
            uuid: uuid4(),
            approverName: '',
            selectPage: "N/A",
            ordinates: '',
        },
    ]);


    const uploadFile = async (event)  => {
        formSaveDocument.value.documentFile =  Array.from(event.target.files);
        // formSaveDocument.value.documentFile =  documentFile.value.files //If multiple files, required variable as array
    }

    /**
     *  Calculate the Coordinates, ready to save in DB
     *  Formula: pxCoordinate X / w  | pyCoordinate = Y / h
     * @param event
     * */
    const getCoordinates = (event) => {
        const imageElement = event.target;
        const rect = imageElement.getBoundingClientRect();

        boxX.value = event.clientX - rect.left;
        boxY.value = event.clientY - rect.top;
        width.value = rect.width;
        height.value = rect.height;

        showBox.value = true;
        edocsVar.pxCoordinate	= boxX.value / width.value;
        edocsVar.pyCoordinate	= boxY.value / height.value;
    };

      /**
      * Getting of current value of select option inside the v-for
      * You need to passed param, row and new row
      * Update the row value to a new row
      * @param rowSaveDocument
      * @param newRowSaveDocument
      * @param rowIndex
      */
      const selectedPage  = async (rowSaveDocument,newRowSaveDocument,rowIndex=null)  => {
        rowSaveDocument.selectPage = newRowSaveDocument; // Update the selectPage
        edocsVar.rowSaveDocumentId = rowIndex;
        edocsVar.selectedPage = newRowSaveDocument;

        let params ={
            select_page: rowSaveDocument.selectPage,
            document_id: formSaveDocument.value.documentId
        }
        await axiosFetchData(params, `${baseUrl}api/convert_pdf_to_image_by_page_number`, (response) => {
            let data = response.data;
            objModalOpenPdfImage.value.show();
            // objModalLoading.value.hide();
            imageSrc.value = data.image;
            width.value = data.width;
            height.value = data.height;
        });
    }

    const readDocumentById = async (documentId)  => {
        edocsVar.optSelectPages = [];
        let params = {
            document_id: documentId
        }
        await axiosFetchData(params, `${baseUrl}api/read_document_by_id`, (response) => {
            console.log("Fetched Users:", response.data);
            let documentDetails = response.data.read_document_by_id[0];
            console.log(documentDetails);

            let approverOrdinates = response.data.read_document_by_id[0].approver_ordinates;

            formSaveDocument.value.documentName = response.data.document_name;

            // Empty the array then push the API array to rowSaveDocuments.value
            rowSaveDocuments.value = []
            approverOrdinates.forEach((approverOrdinates, index) => {
                rowSaveDocuments.value.push({
                    uuid: approverOrdinates.uuid,
                    approverName: approverOrdinates.approver_id,
                    selectedPage: approverOrdinates.page_no,
                    ordinates: approverOrdinates.ordinates,

                });
            });
            //get the page thru array push
            for (let index = 0; index < documentDetails.page_count; index++) {
                edocsVar.optSelectPages.push(index+1)
            }
        });
    }

    const readApproverNameById  = async (approverId)  => {
        edocsVar.optApproverName = [];
        await axios.get('/api/read_approver_name',{
            // params:{
            //     approver_id: approverId
            // }
        }).then((response) => {
            let data = response.data
            let readApproverById = data.read_approver_by_id
            // selectPage = approverId;
            // selectAp
            edocsVar.optApproverName = readApproverById.map((value) => {
                return {
                    value: value.id,
                    label: value.name
                }
            });
        }).catch((err) => {
            console.log(err);
        });
    }

    return {
        uploadFile,
        getCoordinates,
        selectedPage,
        readDocumentById,
        readApproverNameById,
        edocsVar,
        objModalOpenPdfImage,
        objModalSaveDocument,
        objModalLoading,
        modalEdocs,
        boxX,
        boxY,
        showBox,
        imageSrc,
        formSaveDocument,
        rowSaveDocuments,
        tblEdocs,
        tblApproverByDocId,
        documentFile,
    }
};
