import axios from "axios";
import { ref } from "vue";

export default () => {
    const municipalities = ref(null);
   const loading = ref(false)
   const notFound = ref(false)
    const getLocalMunicipality = async (form) => {
        loading.value =true
        if(notFound.value){
            notFound.value = false
        }
        await axios
            .post(
                '/api/equipment', form
            )
            .then((res) => {
                console.log(res.data)
                loading.value = false
                if(res.data.length ===0){
                    notFound.value= true
                }
                municipalities.value = res.data
            });
    };

    const getRegionalMunicipality = async (equipment, quantity) => {
        await axios
            .post(
                `/api/cross/equipment/${equipment}/quantity/${quantity}`
            )
            .then((res) => {
                municipalities.value = res.data
            });
    };

    return {
        municipalities,
        notFound,
        loading,
        getLocalMunicipality,
        getRegionalMunicipality,
    };
};

