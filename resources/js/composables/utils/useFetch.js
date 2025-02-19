
import { ref, onMounted } from "vue";
import axios from "axios";
// Global Loading State
const isModalLoadingComponent = ref(false);

export default function useFetch ()
{
    const axiosFetchData = async  (params, apiUrl,responseCallback) => {
        if (!apiUrl) {
            console.error("🚨 Error: API URL is null or undefined!");
            return;
        }
        try {
            const response = await axios.get(apiUrl, {
                params: params,
                transformRequest: [(data, headers) => {
                    headers['Authorization'] = 'Bearer your-token';
                    console.log('Request config modified before sending:', headers);
                    isModalLoadingComponent.value = true;
                }]

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
        axiosFetchData,isModalLoadingComponent
    }
};
