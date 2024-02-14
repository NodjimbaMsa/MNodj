<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DateRangePicker from "@/Components/DateRangePicker.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ref } from 'vue';
import VueTailwindDatepicker from "vue-tailwind-datepicker";

const props = defineProps({
    events: {
        type: Object,
        default: () => ({}),
    },
    event: {
        type: Object,
        default: () => ({}),
    }
});

const form = useForm({
    id: "",
    title: "",
    event_date: ""
});

const dateForm = useForm({
    startDate: "",
    endDate: ""
});

const dateValue = useForm({
    startDate: "",
    endDate: ""
});

const showModal = ref(false);

const editMode = ref(false);

const editModal = (event) => {
    showModal.value = true;
    editMode.value = true;
    form.id = event.id;
    form.title = event.title;
    form.event_date = event.event_date;
}

/**const formSubmit = (string) => {
    if (editMode.value) {
        form.put(route("events.update", form.id));
    } else {
        form.post(route("events.store"));
    }
    showModal.value = false;
};**/

const dateRangePickerSubmit = () => {
    if (dateForm.startDate && dateForm.endDate) {
        dateForm.get(route("events.getSelected"));
    }
}

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("events.destroy", id));
    }
}
</script>

<template>
    <Head title="Events" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Evenement Index
            </h2>
        </template>

        <Teleport to="body">
            <Modal :show="showModal" @close="showModal = false">
                <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
                    <div class="items-center justify-between">
                        <h3 class="text-2xl font-semibold leading-tight text-gray-800">Formulaire d'un évènement</h3>

                        <form @submit.prevent="editMode? form.put(route('events.update', form.id)) : form.post(route('events.store'))">
                            <div>
                                <InputLabel for="title" value="Title" />

                                <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" required
                                    autofocus autocomplete="username" />

                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>

                            <div class="my-6">
                                <InputLabel for="event_date" value="Date de l'évènement" />

                                <TextInput id="event_date" class="mt-2" type="date" name="event_date" required
                                    v-model="form.event_date" />

                                <div v-if="form.event_date" class="text-sm"> La date actuel est : {{ form.event_date }}
                                </div>

                                <div v-if="form.errors.event_date" class="text-sm text-red-600">
                                    {{ form.errors.event_date }}
                                </div>
                            </div>
                            <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing">
                                Submit
                            </PrimaryButton>
                        </form>
                    </div>
                </div>
            </Modal>
        </Teleport>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <div class="mb-2" @click="showModal = true">
                                <PrimaryButton>Add Event</PrimaryButton>
                            </div>
                            <div class="mb-2">
                                <Link :href="route('events.index')">
                                <PrimaryButton>Réinitialiser le filtre</PrimaryButton>
                                </Link>
                            </div>
                        </div>
                        <form inline @submit.prevent="dateRangePickerSubmit">
                            <label class="mr-sm-2" for="inline-form-custom-select-pref">Choississez deux dates</label>
                            <div>
                                <DateRangePicker v-model="dateForm.startDate"></DateRangePicker>
                                <DateRangePicker v-model="dateForm.endDate"></DateRangePicker>

                                <!---<vue-tailwind-datepicker v-model="dateValue"/> -->

                                <PrimaryButton type="submit" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            Titre
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Date de l'évènement
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="event in events" :key="event.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ event.id }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ event.title }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ event.event_date }}
                                        </th>
                                        <td class="px-6 py-4">
                                            <PrimaryButton class="px-4 py-2 text-white bg-green-700 rounded-lg"
                                                @click="editModal(event)">
                                                Edit
                                            </PrimaryButton>
                                        </td>
                                        <td class="px-6 py-4">
                                            <PrimaryButton class="bg-red-700" @click="destroy(event.id)">
                                                Delete
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
