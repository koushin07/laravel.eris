import axios from "axios";
import { reactive } from "vue";
import { ref } from "vue";

export default () => {
    const notification =reactive({
        reconfirm: 0,
        request: 0,
    })
  
    const url = "/api/notification";
    const fetchPendingNotification = async () => {
        axios.get(`${url}/request`).then((req) => {
        //    console.log('this is for notif ', recon.data);
            notification.request = req.data
            console.log('this is for notif ', notification.reconfirm);

        });
    };

    const fetchReconfirmationotification = async () => {
        axios.get(`${url}/reconfirm`).then((rec)=>{
            notification.reconfirm = rec.data
        })
    }

    return{
        fetchPendingNotification,
        fetchReconfirmationotification,
        notification
    }
};
