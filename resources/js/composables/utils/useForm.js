
import { ref, onMounted } from "vue";
import axios from "axios";
// Global Loading State
import useFetch from "./useFetch";
const  {
    isModalLoadingComponent
} = useFetch();
export default function useForm ()
{
    const axiosSaveData = async  (formData, apiUrl,responseCallback) => {
        isModalLoadingComponent.value = true;
        if (!apiUrl) {
            console.error("🚨 Error: API URL is null or undefined!");
            return;
        }
        try {
            const response = await axios.post(apiUrl, formData,{
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            });
            if (typeof responseCallback === "function") {
                responseCallback(response);
            }
        } catch (error) {
            throw error; // Ensure errors are propagated
        } finally {
            isModalLoadingComponent.value = false;
        }
    }
    return {
        axiosSaveData,isModalLoadingComponent
    }
};
