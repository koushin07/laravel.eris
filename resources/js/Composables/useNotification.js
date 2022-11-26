import axios from "axios";
import { ref } from "vue";

export default () => {
    const  count= ref(0);
    const url = "/api/municipality/notification";
    const notification = async () => {
        const url = "/api/municipality/notification";


        axios.get(`${url}/count`).then((c) => {
            console.log('this is fired  ', c);
            console.log(c.data);
            count.value = c.data;
        });
    };

    return{
        notification,
        count
    }
};
