import { usePage } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import { useToast } from "vue-toastification";


const toast = useToast();

export default () => {
    const notif = ref(false);
    const pendings = ref([]);
   
  

    const confirmed = async () => {
        await window.Echo.private(
            `confirmed.${usePage().props.value.auth.user.id}`
        ).listen(".equipment.confirmed", (e) => {
            // alert("accepted");
           notif.value = true
            toast.success("Request Confirmed", {
                timeout: 7000,
                icon: "fa-regular fa-circle-check",
            });

            console.log("this is", e);
            Object.values(pendings.value).filter((p) => {
                if (
                    e.unfinish.owner === p.municipality_id &&
                    e.unfinish.equipment === p.equipment &&
                    p.status =='pending'
                ) {
                    console.log('inside if')
                    p.status = "accept";
                }
            });
           
        });
       
    };
    const denied = async () => {
        window.Echo.private(
            `denied.${usePage().props.value.auth.user.id}`
        ).listen(".equipment.denied", (e) => {
            toast.error("Request Denied", {
                timeout: 7000,
                icon: "fa-regular fa-circle-xmark",
            });
            console.log("this is", e);
            Object.values(pendings.value).filter((p) => {
                console.log('in');
                if (
                  
                    e.unfinish.owner === p.municipality_id &&
                    e.unfinish.equipment === p.equipment &&
                    p.status === "pending"
                ) {
                  
                    p.status = "denied";
                }
            });
        });
    };
    const equipmentRequest = () => {
       
        window.Echo.private(
            `borrowing.${usePage().props.value.auth.user.id}`
        ).listen(".borrow.recieved", (e) => {
            console.log("this is e", e);
          
            notif.value = true;
            toast.info("Equipment Request Recieved", {
                timeout: 7000,
                icon: "fa-regular fa-envelope",
            });
           
        });
        window.Echo.private(
            `incident.report.${usePage().props.value.auth.user.id}`
        ).listen(".report", (e) => {
            console.log("this is e", e);
            alert("province ask for incident report", e);
        });
    };
    const notifyProvince = () => {
        window.Echo.private(
            `child.transacton.${usePage().props.value.auth.user.id}`
        ).listen(".child.trans", (e) => {
            console.log("this is e", e);
            toast.info("Municipality Transactions Happen", {
                timeout: 7000,
                icon: "fa-regular fa-envelope",
            });
        });

        window.Echo.private(`report.submitted.${usePage().props.value.auth.user.id}`)
        .listen(".report.sub", (e)=>{
            
            toast.info('Municipality submitted report', {
                timeout: 7000,
                icon: "fa-regular fa-envelope"
            })
        })
    };

    return {
        pendings,
        notif,
        confirmed,
        denied,
        equipmentRequest,
        notifyProvince,
    };
};
