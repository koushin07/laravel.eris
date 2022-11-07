import { usePage } from "@inertiajs/inertia-vue3";

export default () => {
    const confirmed = async (pendings) => {
        await window.Echo.private(
            `confirmed.${usePage().props.value.auth.user.id}`
        ).listen(".equipment.confirmed", (e) => {
            alert("borrow accepted", e);

            Object.values(pendings.value).filter((p) => {
                if (
                    e.unfinish.owner === p.municipality_id &&
                    e.unfinish.equipment === p.equipment &&
                    p.status === "pending"
                ) {
                    p.status = "accept";
                }
            });
        });
    };
    const denied = async (pendings) => {
        window.Echo.private(
            `denied.${usePage().props.value.auth.user.id}`
        ).listen(".equipment.denied", (e) => {
            alert("borrow denied", e);

            Object.values(pendings.value).filter((p) => {
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
            alert("someone borrowed", e);
        });
        window.Echo.private(
            `incident.report.${usePage().props.value.auth.user.id}`
        ).listen(".report", (e) => {
            console.log("this is e", e);
            alert("province ask for incident report", e);
        });
    };

    return {
        confirmed,
        denied,
    };
};
