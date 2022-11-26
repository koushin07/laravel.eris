import { ref } from "vue";

export default () => {
    const munis = ref([]);
    const setItem = (muni, equipment, quantity, pendings) => {
        let date = new Date(new Date().getTime() + 60000 * 10);
        muni["expiration"] = date;
        muni["equipment"] = equipment; //equipments.value.equipment_name
        muni["status"] = "pending";
        muni['quantity_borrowing'] = quantity
        munis.value.push(muni);
        window.localStorage.setItem(
            "municipality",
            JSON.stringify(munis.value)
        );
        pendings.value.push(muni)
    };

    return {
        munis,
        setItem,
    };
};
