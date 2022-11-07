import axios from "axios";
import { ref } from "vue";

export default () => {
    const municipalities = ref(null);

    const getLocalMunicipality = async (equipment, quantity) => {
        await axios
            .post(
                `/api/equipment/${equipment}/quantity/${quantity}`
            )
            .then((res) => {
                console.log(res.data)
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
        getLocalMunicipality,
        getRegionalMunicipality,
    };
};

