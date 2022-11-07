import { ref } from "vue"

export default () =>{
    const setItem = (muni, equipment) => {
        let date = new Date(new Date().getTime() + (60000 * 10))
        muni['expiration'] = date
        muni['equipment'] = equipment //equipments.value.equipment_name 
        muni['status'] = 'pending'
       
    }

    return {

        setItem,
    }
}