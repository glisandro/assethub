<template>
    <app-layout :title="'Add Building'" :buildings="$attrs.buildings">
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ action }} Building</h3>
                        <p class="mt-1 text-sm text-gray-600">Add new building</p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <Form class="w-full" v-model="form" @submit.prevent="submit">
                                <Input type="text" name="name" id="name" label="Name" />
                                <Group inline>
                                    <Submit>Save</Submit>
                                    <div class="mt-6 flex items-center justify-between">
                                        <InertiaLink class="ah-btn-1" as="button" :href="route('assets.redirect')">
                                            Cancel
                                        </InertiaLink>
                                    </div>
                                </Group>
                            </Form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Shared/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'

export default {

    components: {
        AppLayout
    },

    props: [
        'building',
        'action'
    ],

    setup (props) {
        
        const form = useForm({
            name: (props.building === null) ? null : props.building.name,
        }, props)
        
        function submit() {
            (props.action == 'create') ? store() : update()
        }

        function update() {
            form.put(route('buildings.update', [props.building.id]));
        }

        function store() {
            form.post(route('buildings.store'));
        }

        return { form, submit }
    },
};
</script>