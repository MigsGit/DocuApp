import { ref, inject,reactive } from 'vue';
import { v4 as uuidv4 } from 'uuid';

export default function edocs()
{
    const objModalSaveDocument = ref(null);
    const objModalOpenPdfImage = ref(null);
    const objModalLoading = ref(null);
    const isModalLoadingComponent = ref(false);

    const showBox = ref(false);
    const boxX = ref(0);
    const boxY = ref(0);
    const height = ref(0);
    const width = ref(0);
    const imageSrc = ref(null);
    const formSaveDocument = ref({
        documentId: null,
        documentName: null,
        documentFile:[],
        selectPage: "",
        optSelectPages: [],
        optApproverName: [],
    });
    const tblEdocs = ref(null);
    const documentFile = ref([]);

    const rowSaveDocuments = ref([
        { uuid:uuidv4(),selectPage: 'N/A', approverName: '', ordinates: '' },
    ]);
    console.log(rowSaveDocuments.value);

    const uploadFile = async (event)  => {
        formSaveDocument.value.documentFile =  Array.from(event.target.files);
        // formSaveDocument.value.documentFile =  documentFile.value.files //If multiple files, required variable as array
    }

    const getCoordinates = (event) => {
        const imageElement = event.target;
        const rect = imageElement.getBoundingClientRect();

        boxX.value = event.clientX - rect.left;
        boxY.value = event.clientY - rect.top;
        width.value = rect.width;
        height.value = rect.height;

        showBox.value = true;

        // const pxCoordinate	= boxX.value / width.value;
        // const pyCoordinate	= boxY.value / height.value;
        const pxCoordinate	= boxX.value / width.value;
        const pyCoordinate	= boxY.value / height.value;
        /*
            $return['px_py'] = $px."|".$py;
            echo json_encode($return);
        */
            console.log('pxCoordinate',pxCoordinate);
            console.log('pyCoordinate',pyCoordinate);
            console.log('height',height.value);
            console.log('width',width.value);
            console.log('rect',rect);
      };
      const getCoordinatesCalculation = async ()  => {

      }
      /**
      * Getting of current value of select option inside the v-for
      * You need to passed param, row and new row
      * Update the row value to a new row
      * @param rowSaveDocument
      * @param newRowSaveDocument
      */
      const selectedPage  = async (rowSaveDocument,newRowSaveDocument)  => {
        rowSaveDocument.selectPage = newRowSaveDocument; // Update the selectPage
        await axios.get('/api/convert_pdf_to_image_by_page_number',{
            params:{
                select_page: rowSaveDocument.selectPage,
                document_id: formSaveDocument.value.documentId
            },
            transformRequest: [(data, headers) => {
                // Modify the request config here (similar to beforeSend in jQuery)
                headers['Authorization'] = 'Bearer your-token';
                console.log('Request config modified before sending:', headers);
                // objModalLoading.value.show();
                isModalLoadingComponent.value = true;
            }]
        }).then((response) => {
            let data = response.data;
            objModalOpenPdfImage.value.show();
            // objModalLoading.value.hide();
            isModalLoadingComponent.value = false;
            imageSrc.value = data.image;
            width.value = data.width;
            height.value = data.height;
        }).catch((err) => {
            console.log(err);
        });
    }

    const readDocumentById = async (documentId)  => {
        formSaveDocument.value.optSelectPages = [];
        await axios.get('/api/read_document_by_id',{
            params:{
                document_id: documentId
            },
            transformRequest: [(data, headers) => {
                // objModalLoading.value.show();
                isModalLoadingComponent.value = true;
            }]
        })
        .then((response) => {
            // objModalLoading.value.hide();
            isModalLoadingComponent.value = false;
            let documentDetails = response.data;
            formSaveDocument.value.documentName = documentDetails.read_document_by_id[0].document_name;

            //get the page thru array push
            for (let index = 0; index < documentDetails.page_count; index++) {
                formSaveDocument.value.optSelectPages.push(index+1)
            }
        }).catch((err) => {
            console.log(err);
        });
    }

    const readApproverNameById  = async (approverId)  => {
        formSaveDocument.value.optApproverName = [];
        await axios.get('/api/read_approver_name_by_id',{
            params:{
                approver_id: approverId
            }
        }).then((response) => {
            let data = response.data
            let readApproverById = data.read_approver_by_id
            console.log(readApproverById);
            
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
        objModalOpenPdfImage,
        objModalSaveDocument,
        objModalLoading,
        isModalLoadingComponent,
        boxX,
        boxY,
        showBox,
        imageSrc,
        formSaveDocument,
        rowSaveDocuments,
        tblEdocs,
        documentFile,
    }
}
