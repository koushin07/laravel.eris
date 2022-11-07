<template>
    <div>
        <form @submit.prevent="submit">
            <div class="mb-4">
                <input type="file" name="docs" @input="form.docs = $event.target.files[0]" />
                <div v-if="form.errors.docs" class="text-sm text-red-600">
                    {{ form.errors.docs }}
                </div>
            </div>
            <button type="submit"> sumbit</button>
        </form>
    </div>
</template>

<script>

import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { useForm } from "@inertiajs/inertia-vue3";
export default {
    setup() {
        const form = useForm({
          
            docs: "",
       
        });

        const submit = () => {
            // console.log(form)
            form.post('/uploading', {
                forceFormData: true,
            });
        };

        return {
            form,
            submit
        }
    }
}
</script>

<style lang="scss" scoped>

</style>