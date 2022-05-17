<template>
  <app-layout>
    
    
    <!-- 	<template #table> The actual table element.</template>-->
    <template #pagination><!-- 	The location of the paginator. --></template>
    
      <Table
        :filters="queryBuilderProps.filters"
        :search="queryBuilderProps.search"
        :columns="queryBuilderProps.columns"
        :on-update="setQueryBuilder"
        :meta="users"
      >
      <template #tableFilter><!--	The location of the button + dropdown to select filters. --></template>
    
    <template #tableAddSearchRow><!-- The location of the button + dropdown to add additional search rows. --></template>
    <template #tableColumns><!-- 	The location of the button + dropdown to toggle columns. --></template>
    <template #tableSearchRows><!-- 	The location of the input elements that handle the additional search rows.--></template>
    <template #tableWrapper></template>
    
        <template #head>
          <tr>
            <th @click.prevent="sortBy('name')">Name</th>
            <th v-show="showColumn('email')" @click.prevent="sortBy('email')">Email</th>
            <th v-show="showColumn('password')" @click.prevent="sortBy('password')">Language</th>
          </tr>
        </template>

        <template #body>
          <tr v-for="user in users.data" :key="user.id">
            <td>{{ user.name }}</td>
            <td v-show="showColumn('email')">{{ user.email }}</td>
            <td v-show="showColumn('password')">{{ user.password }}</td>
          </tr>
        </template>
      </Table>
    
  </app-layout>
</template>

<script>
import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
import AppLayout from '@/Shared/AppLayout.vue';

export default {
  mixins: [InteractsWithQueryBuilder],

  components: {
    Table: Tailwind2.Table,
    AppLayout
  },

  props: {
    users: Object
  }
};
</script>

