import { ref, inject,reactive } from 'vue'
export default function edocs()
{
    const objModalSaveDocument = ref(null);
    const objModalOpenPdfImage = ref(null);
    const objModalLoading = ref(null);
    const isModalVisible = ref(false);

    const showBox = ref(false);
    const boxX = ref(0);
    const boxY = ref(0);
    const imageSrc = ref(null);
    const formSaveDocument = ref({
        documentId: null,
        documentName: null,
        documentFile:[],
        selectPage: "",
        optSelectPages: [],
    });
    const tblEdocs = ref(null);
    const documentFile = ref([]);


    const uploadFile = async (event)  => {
        formSaveDocument.value.documentFile =  Array.from(event.target.files);
        // formSaveDocument.value.documentFile =  documentFile.value.files //If multiple files, required variable as array
    }

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
        /*
            $width 	= $_POST['width'];
            $height = $_POST['height'];
            $x 		= $_POST['x'];
            $y 		= $_POST['y'];
            $px		= $x / $width;
            $py		= $y / $height;
            $return['px_py'] = $px."|".$py;
            echo json_encode($return);

        */
      };
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
                // objModalLoading.value.show();
                isModalVisible.value = true;
            }]
        }).then((response) => {
            let data = response.data;
            objModalOpenPdfImage.value.show();
            // objModalLoading.value.hide();
            isModalVisible.value = false;

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
            },
            transformRequest: [(data, headers) => {
                // objModalLoading.value.show();
                isModalVisible.value = true;
            }]
        })
        .then((response) => {
            // objModalLoading.value.hide();
            isModalVisible.value = false;
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


    return {
        uploadFile,
        getCoordinates,
        selectedPage,
        readDocumentById,
        objModalOpenPdfImage,
        objModalSaveDocument,
        objModalLoading,
        isModalVisible,
        boxX,
        boxY,
        showBox,
        imageSrc,
        formSaveDocument,
        tblEdocs,
        documentFile,
    }
}
