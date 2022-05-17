<template>
    <app-layout :title="building.name + ' / Assets / ' + asset.name" :buildings="$attrs.buildings">
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">

                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Asset</h3>
                        <p class="mt-1 text-sm text-gray-600"></p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <Form class="w-full" v-model="form" @submit.prevent="submit">
                                <Input type="text" name="name" id="name" label="Name" />
                                <Textarea id="description" name="description" rows="5" label="Description" autosize />
                                <Group label="Status">
                                    <Checkbox id="status" name="status" type="checkbox" :label="form.status ? 'Enabled' : 'Disabled'" />
                                </Group>
                                <Group inline>
                                    <Submit>Save</Submit>

                                    <div class="mt-6 flex items-center justify-between">
                                        <InertiaLink class="ah-btn-1" as="button" :href="route('buildings.assets.index', building.id)">
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
        'asset',
        'action'
    ],

    setup (props) {
        
        const form = useForm({
            name: props.asset.name,
            description: props.asset.description,
            status: props.asset.status,
        }, props)
        
        function submit() {
            (props.action == 'create') ? store() : update()
        }

        function update() {
            form.put(route('buildings.assets.update', [props.building.id, props.asset.id]));
        }

        function store() {
            form.post(route('buildings.assets.store', [props.building.id]));
        }

        return { form, submit }
    },
};
</script>