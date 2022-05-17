<template>
  <app-layout title="Buildings" :buildings="$attrs.buildings">
    <Table
      :filters="queryBuilderProps.filters"
      :search="queryBuilderProps.search"
      :columns="queryBuilderProps.columns"
      :on-update="setQueryBuilder"
      :meta="resources"
    >
      <template #buttonCreate>
        <InertiaLink class="ah-btn-1" as="button" :href="route('buildings.create')">Create Building</InertiaLink>
      </template>

      <template #head>
        <tr>
          <th @click.prevent="sortBy('name')">Name</th>
          <th>Assets Count</th>
          <th>Actions</th>
        </tr>
      </template>

      <template #body>
        <tr v-for="building in resources.data" :key="building.id">
          <td>{{ building.name }}</td>
          <td>{{ building.assets_count }}</td>
          <td><inertia-link :href="route('buildings.edit', building.id)">Edit</inertia-link></td>
        </tr>
      </template>
    </Table>
  </app-layout>
</template>

<script>
import { InteractsWithQueryBuilder } from '@protonemedia/inertiajs-tables-laravel-query-builder';
import AppLayout from '@/Shared/AppLayout.vue';
import Table from '@/Tailwind2/Table.vue';

export default {
  mixins: [InteractsWithQueryBuilder],

  components: {
    Table,
    AppLayout
  },

  props: {
    resources: Object
  }
};
</script>